<?php

namespace App\Http\Controllers;

use App\Models\Attendance;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\Rule;

class AttendanceController extends Controller
{
    private const STATUSES = ['present', 'late', 'absent'];

    private function events()
    {
        return DB::table('events')
            ->select('id', 'name as label')
            ->orderByDesc('event_date')
            ->get();
    }

    private function sessions()
    {
        return DB::table('event_sessions')
            ->join('events', 'events.id', '=', 'event_sessions.event_id')
            ->select(
                'event_sessions.*',
                'events.name as event_label'
            )
            ->orderBy('event_sessions.session_date')
            ->orderBy('event_sessions.start_time')
            ->get();
    }

    private function timeOrderError(array $data): ?string
    {
        if (
            !empty($data['time_in']) &&
            !empty($data['time_out']) &&
            $data['time_out'] < $data['time_in']
        ) {
            return 'Time out cannot be earlier than time in.';
        }

        return null;
    }

    public function index(Request $request)
    {
        // Clear saved filters.
        if ($request->boolean('clear')) {
            session()->forget([
                'attendance_filters.event_id',
                'attendance_filters.status',
            ]);

            return redirect()->route('attendance.index');
        }

        // Save submitted filters.
        if ($request->has('event_id')) {
            session()->put(
                'attendance_filters.event_id',
                $request->input('event_id')
            );
        }

        if ($request->has('status')) {
            session()->put(
                'attendance_filters.status',
                $request->input('status')
            );
        }

        // Retrieve saved filters.
        $eventFilter = session('attendance_filters.event_id');
        $statusFilter = session('attendance_filters.status');

        $query = DB::table('attendances')
            ->join('students', 'students.id', '=', 'attendances.student_id')
            ->leftJoin('events', 'events.id', '=', 'attendances.event_id')
            ->leftJoin('event_sessions', 'event_sessions.id', '=', 'attendances.event_session_id')
            ->select(
                'attendances.*',
                'students.name as student_name',
                'students.email as student_email',
                'events.name as event_label',
                'event_sessions.session_name'
            );

        if (!empty($eventFilter)) {
            $query->where('attendances.event_id', $eventFilter);
        }

        if (
            !empty($statusFilter) &&
            in_array($statusFilter, self::STATUSES, true)
        ) {
            $query->where('attendances.status', $statusFilter);
        }

        // T11: Support Collection summary (groupBy, map, sum).
        $rows = (clone $query)->get();

        $statusSummary = $rows
            ->groupBy('status')
            ->map(fn ($group) => $group->count());

        $totalMinutes = $rows->sum(function ($row) {
            if ($row->time_in && $row->time_out) {
                return (int) Carbon::parse($row->time_in)
                    ->diffInMinutes(Carbon::parse($row->time_out));
            }
            return 0;
        });

        $records = $query
            ->orderByDesc('attendances.created_at')
            ->paginate(15)
            ->withQueryString();

        return view('attendance.index', [
            'records' => $records,
            'events' => $this->events(),
            'statuses' => self::STATUSES,
            'eventFilter' => $eventFilter,
            'statusFilter' => $statusFilter,
            'statusSummary' => $statusSummary,
            'totalMinutes' => $totalMinutes,
        ]);
    }

    public function create()
    {
        return view('attendance.create', [
            'students' => DB::table('students')
                ->orderBy('name')
                ->get(['id', 'name', 'email']),
            'events' => $this->events(),
            'sessions' => $this->sessions(),
            'statuses' => self::STATUSES,
        ]);
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'student_id' => [
                'required',
                'integer',
                Rule::exists('students', 'id'),
            ],
            'event_id' => [
                'required',
                'integer',
                Rule::exists('events', 'id'),
            ],
            'event_session_id' => [
                'required',
                'integer',
                Rule::exists('event_sessions', 'id'),
            ],
            'status' => [
                'required',
                Rule::in(self::STATUSES),
            ],
            'time_in' => ['nullable', 'date_format:H:i'],
            'time_out' => ['nullable', 'date_format:H:i'],
            'remarks' => ['nullable', 'string', 'max:255'],
        ]);

        $session = DB::table('event_sessions')
            ->where('id', $data['event_session_id'])
            ->first();

        if (!$session || $session->event_id != $data['event_id']) {
            return back()->withInput()->withErrors([
                'event_session_id' => 'The selected session does not belong to this event.',
            ]);
        }

        if ($error = $this->timeOrderError($data)) {
            return back()->withInput()->withErrors([
                'time_out' => $error,
            ]);
        }

        $alreadyRecorded = Attendance::where(
            'student_id',
            $data['student_id']
        )->where(
            'event_session_id',
            $data['event_session_id']
        )->exists();

        if ($alreadyRecorded) {
            return back()->withInput()->withErrors([
                'student_id' => 'This student already has an attendance record for this session.',
            ]);
        }

        Attendance::create($data);

        return redirect()->route('attendance.index')
            ->with('success', 'Attendance recorded.');
    }

    public function edit(Attendance $attendance)
    {
        $student = DB::table('students')
            ->where('id', $attendance->student_id)
            ->first(['name', 'email']);

        $event = DB::table('events')
            ->where('id', $attendance->event_id)
            ->value('name');

        $session = DB::table('event_sessions')
            ->where('id', $attendance->event_session_id)
            ->value('session_name');

        return view('attendance.edit', [
            'attendance' => $attendance,
            'studentName' => $student->name ?? ('Student #' . $attendance->student_id),
            'eventLabel' => $event ?? ('Event #' . $attendance->event_id),
            'sessionName' => $session,
            'statuses' => self::STATUSES,
        ]);
    }

    public function update(Request $request, Attendance $attendance)
    {
        $data = $request->validate([
            'status' => ['required', Rule::in(self::STATUSES)],
            'time_in' => ['nullable', 'date_format:H:i'],
            'time_out' => ['nullable', 'date_format:H:i'],
            'remarks' => ['nullable', 'string', 'max:255'],
        ]);

        if ($error = $this->timeOrderError($data)) {
            return back()->withInput()->withErrors([
                'time_out' => $error,
            ]);
        }

        $attendance->update($data);

        return redirect()->route('attendance.index')
            ->with('success', 'Attendance updated.');
    }

    public function destroy(Attendance $attendance)
    {
        $attendance->delete();

        return redirect()->route('attendance.index')
            ->with('success', 'Attendance record deleted.');
    }
}
