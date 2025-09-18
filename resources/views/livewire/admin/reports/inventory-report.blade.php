<div class="card mb-3">
    <div class="card-header">
        <h6 class="mb-0">Inventory Report</h6>
    </div>
    <div class="card-body p-0">
        <table class="table table-striped mb-0">
            <thead>
                <tr>
                    <th>Watch Name</th>
                    <th>Model</th>
                    <th>Brand</th>
                    <th>Available</th>
                    <th>Total</th>
                </tr>
            </thead>
            <tbody>
                @forelse($data as $watch)
                    <tr>
                        <td>{{ $watch->name ?? '-' }}</td>
                        <td>{{ $watch->model ?? '-' }}</td>
                        <td>{{ $watch->brand ?? '-' }}</td>
                        <td>{{ $watch->available_stock ?? '-' }}</td>
                        <td>{{ $watch->total_stock ?? '-' }}</td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="5" class="text-center text-muted">No inventory data available.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>