@extends('attendance.layout')

@section('title', 'Attendance Records')

@section('content')
    <div class="head">
        <h1>Attendance Records</h1>

        @if(auth()->user()->role === 'officer')
            <a class="btn" href="{{ route('attendance.create') }}">+ Record Attendance</a>
        @endif
    </div>

    <div class="card">
        <!-- Saved Filter Form -->
        <form method="GET" action="{{ route('attendance.index') }}" class="filters">

            <select name="event_id">
                <option value="">All events</option>

                @foreach ($events as $event)
                    <option value="{{ $event->id }}"
                        @selected(($eventFilter ?? '') == $event->id)>
                        {{ $event->label }}
                    </option>
                @endforeach
            </select>

            <select name="status">
                <option value="">All statuses</option>

                @foreach ($statuses as $status)
                    <option value="{{ $status }}"
                        @selected(($statusFilter ?? '') === $status)>
                        {{ ucfirst($status) }}
                    </option>
                @endforeach
            </select>

            <button class="btn small" type="submit">Filter</button>

            <a class="btn ghost small"
                href="{{ route('attendance.index', ['clear' => 1]) }}">
                Clear
            </a>
        </form>

        <!-- Attendance Table -->
        <table>
            <thead>
                <tr>
                    <th>Student</th>
                    <th>Event</th>
                    <th>Session</th>
                    <th>Status</th>
                    <th>Time in</th>
                    <th>Time out</th>

                    @if(auth()->user()->role === 'officer')
                        <th>Actions</th>
                    @endif
                </tr>
            </thead>

            <tbody>
                @forelse ($records as $record)
                    <tr>
                        <td>
                            <strong>{{ $record->student_name }}</strong>
                            <small>{{ $record->student_email }}</small>
                        </td>

                        <td>
                            {{ $record->event_label ?? ('Event #' . $record->event_id) }}
                        </td>

                        <td>
                            {{ $record->session_name ?? 'Legacy attendance' }}
                        </td>

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

                        @if(auth()->user()->role === 'officer')
                            <td>
                                <div class="actions">
                                    <a class="btn small ghost"
                                        href="{{ route('attendance.edit', $record->id) }}">
                                        Edit
                                    </a>

                                    <form method="POST"
                                        action="{{ route('attendance.destroy', $record->id) }}"
                                        onsubmit="return confirm('Delete this attendance record?');">
                                        @csrf
                                        @method('DELETE')

                                        <button class="btn small danger" type="submit">
                                            Delete
                                        </button>
                                    </form>
                                </div>
                            </td>
                        @endif
                    </tr>
                @empty
                    <tr>
                        <td colspan="{{ auth()->user()->role === 'officer' ? 7 : 6 }}"
                            class="empty">
                            No attendance records found.
                        </td>
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
