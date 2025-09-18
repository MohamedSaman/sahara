<div class="card mb-3">
    <div class="card-header">
        <h6 class="mb-0">Payments Report</h6>
    </div>
    <div class="card-body p-0">
        <table class="table table-striped mb-0">
            <thead>
                <tr>
                    <th>Sale Invoice</th>
                    <th>Amount</th>
                    <th>Method</th>
                    <th>Status</th>
                    <th>Date</th>
                </tr>
            </thead>
            <tbody>
                @forelse($data as $payment)
                    <tr>
                        <td>{{ $payment->sale->invoice_number ?? '-' }}</td>
                        <td>Rs.{{ number_format($payment->amount, 2) }}</td>
                        <td>{{ ucfirst($payment->payment_method) }}</td>
                        <td>{!! $payment->status !!}</td>
                        <td>{{ $payment->payment_date ? $payment->payment_date->format('Y-m-d') : '-' }}</td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="5" class="text-center text-muted">No payment data available.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>