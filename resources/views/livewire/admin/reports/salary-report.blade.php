<div class="card mb-3">
    <div class="card-header">
        <h6 class="mb-0">Salary Report</h6>
    </div>
    <div class="card-body p-0">
        <table class="table table-striped mb-0">
            <thead>
                <tr>
                    <th>Staff Name</th>
                    <th>Month</th>
                    <th>Amount</th>
                    <th>Status</th>
                </tr>
            </thead>
            <tbody>
                @forelse($data as $salary)
                    <tr>
                        <td>{{ $salary->name ?? '-' }}</td>
                        <td>{{ $salary->salary_month ?? '-' }}</td>
                        <td>Rs.{{ number_format($salary->net_salary, 2) }}</td>
                        <td>
                            @if($salary->payment_status === 'paid')
                                <span class="badge bg-success">Paid</span>
                            @else
                                <span class="badge bg-warning">Pending</span>
                            @endif
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="4" class="text-center text-muted">No salary data available.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>