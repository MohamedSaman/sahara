<div class="card mb-3">
    <div class="card-header">
        <h6 class="mb-0">Attendance Report</h6>
    </div>
    <div class="card-body p-0">
        <table class="table table-striped mb-0">
            <thead>
                <tr>
                    <th>Name</th>
                    <th>Date</th>
                    <th>Check In</th>
                    <th>Check Out</th>
                    <th>Status</th>
                </tr>
            </thead>
            <tbody>
                @forelse($data as $attendance)
                    <tr>
                        <td>{{ $attendance->name ?? '-' }}</td>
                        <td>{{ $attendance->date ?? '-' }}</td>
                        <td>{{ $attendance->check_in ?? '-' }}</td>
                        <td>{{ $attendance->check_out ?? '-' }}</td>
                        <td>
                            @if($attendance->status === 'present')
                                <span class="badge bg-success">Present</span>
                            @elseif($attendance->status === 'late')
                                <span class="badge bg-warning">Late</span>
                            @else
                                <span class="badge bg-danger">Absent</span>
                            @endif
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="5" class="text-center text-muted">No attendance data available.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>