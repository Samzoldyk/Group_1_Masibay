@extends('attendance.layout')

@section('title', 'Attendance Records')

@section('content')
    <div class="head">
        <h1>Attendance Records</h1>
        <a class="btn" href="{{ route('attendance.create') }}">+ Record Attendance</a>
    </div>

    <div class="card">
        <!-- Filter Form -->
        <form method="GET" action="{{ route('attendance.index') }}" class="filters">
            <select name="event_id">
                <option value="">All events</option>
                @foreach ($events as $event)
                    <option value="{{ $event->id }}" @selected(request('event_id') == $event->id)>
                        {{ $event->label }}
                    </option>
                @endforeach
            </select>

            <select name="status">
                <option value="">All statuses</option>
                @foreach ($statuses as $status)
                    <option value="{{ $status }}" @selected(request('status') === $status)>
                        {{ ucfirst($status) }}
                    </option>
                @endforeach
            </select>

            <button class="btn small" type="submit">Filter</button>
            <a class="btn ghost small" href="{{ route('attendance.index') }}">Reset</a>
        </form>

        <!-- Data Table -->
        <table>
            <thead>
                <tr>
                    <th>Student</th>
                    <th>Event</th>
                    <th>Session</th>
                    <th>Status</th>
                    <th>Time in</th>
                    <th>Time out</th>
                    <th>Actions</th>
                </tr>
            </thead>

            <tbody>
                @forelse ($records as $record)
                    <tr>
                        <td>
                            <strong>{{ $record->student_name }}</strong>
                            <small>{{ $record->student_email }}</small>
                        </td>

                        <td>{{ $record->event_label ?? ('Event #' . $record->event_id) }}</td>

                        <td>{{ $record->session_name ?? 'Legacy attendance' }}</td>

                        <td>
                            <span class="badge {{ $record->status }}">
                                {{ ucfirst($record->status) }}
                            </span>
                        </td>

                        <td>
                            {{ $record->time_in ? \Carbon\Carbon::parse($record->time_in)->format('g:i A') : '—' }}
                        </td>

                        <td>
                            {{ $record->time_out ? \Carbon\Carbon::parse($record->time_out)->format('g:i A') : '—' }}
                        </td>

                        <td>
                            <div class="actions">
                                <a class="btn small ghost" href="{{ route('attendance.edit', $record->id) }}">Edit</a>

                                <form method="POST"
                                    action="{{ route('attendance.destroy', $record->id) }}"
                                    onsubmit="return confirm('Delete this attendance record?');">
                                    @csrf
                                    @method('DELETE')
                                    <button class="btn small danger" type="submit">Delete</button>
                                </form>
                            </div>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="7" class="empty">No attendance records yet.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>

        <!-- Pagination -->
        <div style="margin-top: 24px;">
            {{ $records->links('pagination::bootstrap-4') }}
        </div>
    </div>
@endsection
