<div class="card mb-3">
    <div class="card-header">
        <h6 class="mb-0">Staff Report</h6>
    </div>
    <div class="card-body p-0">
        <table class="table table-striped mb-0">
            <thead>
                <tr>
                    <th>Name</th>
                    <th>Email</th>
                    <th>Total Sales</th>
                </tr>
            </thead>
            <tbody>
                @forelse($data as $staff)
                    <tr>
                        <td>{{ $staff->name ?? '-' }}</td>
                        <td>{{ $staff->email ?? '-' }}</td>
                        <td>Rs.{{ number_format($staff->total_sales, 2) }}</td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="3" class="text-center text-muted">No staff data available.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>