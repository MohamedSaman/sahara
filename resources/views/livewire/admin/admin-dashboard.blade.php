<div>
    @push('styles')
    <style>
        /* Base styles */
        .stat-card {
            background: white;
            border-radius: 8px;
            padding: 20px;
            box-shadow: 0 1px 3px rgba(0, 0, 0, 0.1);
            height: 100%;
        }

        .stat-value {
            font-size: 24px;
            font-weight: 600;
            margin-bottom: 5px;
        }

        .stat-label {
            color: #6c757d;
            font-size: 14px;
            margin-bottom: 5px;
        }

        .stat-change {
            color: #28a745;
            font-size: 13px;
        }

        .stat-change-alert {
            color: #842029;
            font-size: 13px;
        }

        .content-tabs {
            display: flex;
            border-bottom: 1px solid #dee2e6;
            margin-bottom: 20px;
        }

        .content-tab {
            padding: 10px 20px;
            cursor: pointer;
            font-weight: 500;
            color: #495057;
            border-bottom: 3px solid transparent;
            transition: all 0.2s;
        }

        .content-tab.active {
            color: #0d6efd;
            border-bottom-color: #0d6efd;
        }

        .content-tab:hover:not(.active) {
            color: #0d6efd;
            border-bottom-color: #dee2e6;
        }

        .tab-content {
            display: none;
        }

        .tab-content.active {
            display: block;
        }

        .chart-card {
            box-shadow: 0 0.5rem 1rem rgba(0, 0, 0, 0.15);
            border-radius: 0.5rem;
            margin-bottom: 20px;
        }

        .chart-header {
            background-color: #f8f9fa;
            padding: 1rem 1.5rem;
            border-bottom: 1px solid #dee2e6;
            border-top-left-radius: 0.5rem;
            border-top-right-radius: 0.5rem;
        }

        .chart-container {
            position: relative;
            height: 300px;
            padding: 1.5rem;
        }

        .chart-scroll-container {
            overflow-x: auto;
        }

        .recent-sales-card {
            box-shadow: 0 0.5rem 1rem rgba(0, 0, 0, 0.15);
            border-radius: 0.5rem;
            height: 380px;
            width: 100%;
        }

        .avatar {
            width: 40px;
            height: 40px;
            background-color: #e9ecef;
            border-radius: 50%;
            display: flex;
            justify-content: center;
            align-items: center;
            margin-right: 15px;
            color: #6c757d;
            font-size: 1rem;
            font-weight: bold;
        }

        .amount {
            font-weight: bold;
            color: #198754;
        }

        .widget-container {
            background-color: #fff;
            border-radius: 8px;
            box-shadow: 0 0.5rem 1rem rgba(0, 0, 0, 0.1);
            padding: 20px;
            margin-bottom: 20px;
            height: 100%;
            width: auto;
            margin-left: 0;
        }

        .widget-header {
            margin-bottom: 15px;
        }

        .widget-header h6 {
            font-size: 1.25rem;
            margin-bottom: 5px;
            font-weight: 500;
            color: #212529;
        }

        .widget-header p {
            font-size: 0.875rem;
            color: #6c757d;
            margin-bottom: 0;
        }

        .item-row {
            display: flex;
            align-items: center;
            margin-bottom: 10px;
        }

        .item-details {
            flex-grow: 1;
            margin-right: 10px;
        }

        .item-details h6 {
            font-size: 1rem;
            margin-bottom: 3px;
            color: #212529;
        }

        .item-details p {
            font-size: 0.875rem;
            color: #6c757d;
            margin-bottom: 0;
        }

        .status-badge {
            padding: 0.25rem 0.5rem;
            border-radius: 5px;
            font-size: 0.8rem;
            font-weight: bold;
            white-space: nowrap;
        }

        .in-stock {
            background-color: #d1e7dd;
            color: #0f5132;
        }

        .low-stock {
            background-color: #fff3cd;
            color: #664d03;
        }

        .out-of-stock {
            background-color: #f8d7da;
            color: #842029;
        }

        .progress {
            height: 0.5rem;
            margin-top: 5px;
            background-color: #e9ecef;
            border-radius: 0.25rem;
            overflow: hidden;
        }

        .progress-bar {
            background-color: #007bff;
            /* Default progress bar color */
            height: 0.5rem;
        }

        .staff-info {
            display: flex;
            align-items: center;
            margin-bottom: 15px;
        }

        .staff-status {
            margin-right: 10px;
        }

        .staff-status-badge {
            padding: 0.25rem 0.5rem;
            border-radius: 5px;
            font-size: 0.8rem;
            font-weight: bold;
            white-space: nowrap;
        }

        .present {
            background-color: #d1e7dd;
            color: #0f5132;
        }

        .late {
            background-color: #fff3cd;
            color: #664d03;
        }

        .absent {
            background-color: #f8d7da;
            color: #842029;
        }

        .staff-details {
            flex-grow: 1;
        }

        .staff-details h6 {
            font-size: 1rem;
            margin-bottom: 3px;
            color: #212529;
        }

        .staff-details p {
            font-size: 0.875rem;
            color: #6c757d;
            margin-bottom: 2px;
        }

        .staff-details .bi {
            margin-right: 5px;
        }

        .attendance-icon {
            margin-left: auto;
            font-size: 1.5rem;
            color: #198754;
            /* Success green */
        }

        .late-icon {
            color: #ffc107;
            /* Warning yellow  */
        }

        .absent-icon {
            color: #dc3545;
            /* Danger red  */
        }

        /* Stats progress bars */
        .stat-card .progress {
            height: 6px;
            margin-bottom: 5px;
        }

        .stat-card .progress-bar {
            height: 6px;
        }

        .stat-info small,
        .stat-change-alert small {
            font-size: 12px;
        }

        .staff-avatar {
            display: flex;
            align-items: center;
            justify-content: center;
            width: 32px;
            height: 32px;
        }

        .staff-card {
            border-left: 3px solid #0d6efd;
            transition: all 0.2s ease;
        }

        .staff-card:hover {
            transform: translateY(-2px);
        }

        .progress {
            background-color: #e9ecef;
            border-radius: 0.25rem;
            overflow: hidden;
        }

        .btn-outline-primary,
        .btn-outline-secondary {
            font-size: 0.8rem;
            font-weight: 500;
            border-radius: 6px;
            padding: 0.3rem 0.7rem;
            transition: all 0.15s ease;
        }

        .btn-outline-primary:hover,
        .btn-outline-secondary:hover {
            transform: translateY(-1px);
            box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1);
        }

        /* MOBILE RESPONSIVE STYLES */
        @media (max-width: 768px) {
            .stat-card {
                padding: 12px;
                margin-bottom: 15px;
            }

            .stat-value {
                font-size: 20px !important;
            }

            .stat-info small,
            .stat-change-alert small {
                font-size: 11px !important;
                white-space: normal !important;
            }

            .content-tab {
                padding: 8px 12px !important;
                white-space: nowrap;
            }

            .chart-header {
                padding: 0.75rem !important;
                flex-direction: column !important;
                align-items: flex-start !important;
            }

            .chart-header .btn {
                margin-top: 0.5rem;
                font-size: 0.8rem;
            }

            .chart-header h6 {
                font-size: 1rem;
            }

            .chart-header p {
                font-size: 0.75rem;
            }

            .widget-container {
                padding: 15px;
            }

            .item-row {
                flex-wrap: wrap;
            }

            .item-details {
                width: 100%;
                margin-bottom: 5px;
            }

            .avatar {
                width: 32px;
                height: 32px;
                margin-right: 10px;
            }

            .amount {
                font-size: 13px;
            }

            .staff-card .d-flex {
                flex-wrap: wrap;
            }

            .staff-card .d-flex .d-flex {
                margin-top: 5px;
                justify-content: space-between !important;
                width: 100%;
            }

            .staff-card {
                padding: 10px !important;
            }

            .staff-card h6 {
                font-size: 0.9rem;
            }

            .progress {
                height: 5px !important;
            }

            .recent-sales-card {
                height: auto;
                max-height: 380px;
            }
        }

        @media (max-width: 576px) {
            .content-tabs {
                margin-bottom: 15px;
            }

            .stat-card {
                padding: 10px;
            }

            .stat-value {
                font-size: 18px !important;
            }

            .status-badge {
                padding: 0.15rem 0.35rem;
                font-size: 0.7rem;
            }

            .widget-header h6 {
                font-size: 1rem;
            }

            .widget-header p {
                font-size: 0.75rem;
            }

            .item-row {
                align-items: flex-start;
            }

            .item-details h6 {
                font-size: 0.9rem;
            }

            .d-flex-mobile-column {
                flex-direction: column !important;
            }

            .justify-content-mobile-between {
                justify-content: space-between !important;
            }

            .mb-mobile-2 {
                margin-bottom: 0.5rem !important;
            }

            .w-mobile-100 {
                width: 100% !important;
            }

            .text-truncate-mobile {
                white-space: nowrap;
                overflow: hidden;
                text-overflow: ellipsis;
                max-width: 100%;
            }
        }

        /* Fix for horizontal scrolling on mobile */
        .container-fluid {
            width: 100%;
            padding-right: var(--bs-gutter-x, 0.75rem);
            padding-left: var(--bs-gutter-x, 0.75rem);
            margin-right: auto;
            margin-left: auto;
            overflow-x: hidden;
        }

        /* ANALYTICS STYLES */
        .analytics-metric-card {
            background: linear-gradient(135deg, #fff 0%, #f8f9fa 100%);
            border-radius: 16px;
            padding: 24px;
            box-shadow: 0 8px 32px rgba(0, 0, 0, 0.1);
            border: 1px solid rgba(255, 255, 255, 0.2);
            transition: all 0.3s ease;
            position: relative;
            overflow: hidden;
            height: 100%;
        }

        .analytics-metric-card::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            height: 4px;
            background: linear-gradient(90deg, #007bff, #28a745, #ffc107, #dc3545);
        }

        .analytics-metric-card:hover {
            transform: translateY(-4px);
            box-shadow: 0 12px 40px rgba(0, 0, 0, 0.15);
        }

        .metric-icon {
            width: 56px;
            height: 56px;
            border-radius: 14px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 24px;
            color: white;
            margin-bottom: 16px;
        }

        .revenue-icon { background: linear-gradient(135deg, #007bff, #0056b3); }
        .sales-icon { background: linear-gradient(135deg, #28a745, #1e7e34); }
        .due-icon { background: linear-gradient(135deg, #dc3545, #bd2130); }
        .profit-icon { background: linear-gradient(135deg, #ffc107, #e0a800); }

        .metric-content h6 {
            color: #6c757d;
            font-size: 14px;
            font-weight: 500;
            margin-bottom: 8px;
            text-transform: uppercase;
            letter-spacing: 0.5px;
        }

        .metric-value {
            font-size: 28px;
            font-weight: 700;
            color: #212529;
            margin-bottom: 8px;
            line-height: 1.2;
        }

        .metric-change {
            font-size: 13px;
            font-weight: 500;
            display: flex;
            align-items: center;
            gap: 4px;
        }

        .metric-change.positive { color: #28a745; }
        .metric-change.negative { color: #dc3545; }

        .analytics-chart-card {
            background: white;
            border-radius: 16px;
            box-shadow: 0 8px 32px rgba(0, 0, 0, 0.08);
            border: 1px solid rgba(0, 0, 0, 0.05);
            overflow: hidden;
            transition: all 0.3s ease;
        }

        .analytics-chart-card:hover {
            box-shadow: 0 12px 40px rgba(0, 0, 0, 0.12);
        }

        .chart-header {
            background: linear-gradient(135deg, #f8f9fa 0%, #e9ecef 100%);
            padding: 20px 24px;
            border-bottom: 1px solid rgba(0, 0, 0, 0.05);
        }

        .chart-title {
            font-size: 18px;
            font-weight: 600;
            color: #212529;
            margin-bottom: 4px;
        }

        .chart-subtitle {
            font-size: 14px;
            color: #6c757d;
            margin-bottom: 0;
        }

        .chart-body {
            padding: 24px;
            position: relative;
        }

        /* Make Monthly Sales Chart larger */
        .chart-body canvas#monthlySalesChart {
            min-height: 400px !important;
            max-height: 500px !important;
        }

        #monthlySalesChart {
            height: 400px !important;
        }

        .chart-footer {
            padding: 16px 24px;
            background: #f8f9fa;
            border-top: 1px solid rgba(0, 0, 0, 0.05);
        }

        .chart-controls {
            display: flex;
            gap: 8px;
        }

        .chart-controls .btn {
            padding: 6px 16px;
            font-size: 13px;
            border-radius: 20px;
            transition: all 0.2s ease;
        }

        .chart-controls .btn.active {
            background: #007bff;
            color: white;
            border-color: #007bff;
        }

        .status-legend {
            display: flex;
            justify-content: center;
            gap: 20px;
            flex-wrap: wrap;
        }

        .legend-item {
            display: flex;
            align-items: center;
            gap: 8px;
            font-size: 13px;
            font-weight: 500;
        }

        .legend-color {
            width: 12px;
            height: 12px;
            border-radius: 50%;
        }

        .legend-color.paid { background: #28a745; }
        .legend-color.partial { background: #ffc107; }
        .legend-color.pending { background: #dc3545; }

        .performance-card {
            background: white;
            border-radius: 12px;
            padding: 20px;
            box-shadow: 0 4px 20px rgba(0, 0, 0, 0.08);
            border: 1px solid rgba(0, 0, 0, 0.05);
            transition: all 0.3s ease;
            position: relative;
            overflow: hidden;
        }

        .performance-card::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            height: 3px;
            background: linear-gradient(90deg, #ffc107, #fd7e14);
        }

        .performance-card.rank-1::before { background: linear-gradient(90deg, #ffc107, #fd7e14); }
        .performance-card.rank-2::before { background: linear-gradient(90deg, #6c757d, #495057); }
        .performance-card.rank-3::before { background: linear-gradient(90deg, #cd7f32, #8B4513); }

        .performance-card:hover {
            transform: translateY(-2px);
            box-shadow: 0 8px 30px rgba(0, 0, 0, 0.12);
        }

        .rank-badge {
            display: flex;
            align-items: center;
            gap: 8px;
            font-size: 18px;
            font-weight: 700;
            color: #495057;
            margin-bottom: 12px;
        }

        .month-name {
            font-size: 20px;
            font-weight: 600;
            color: #212529;
            margin-bottom: 16px;
        }

        .performance-stats {
            display: flex;
            flex-direction: column;
            gap: 12px;
        }

        .stat-item {
            display: flex;
            justify-content: between;
            align-items: center;
        }

        .stat-label {
            font-size: 13px;
            color: #6c757d;
            font-weight: 500;
        }

        .stat-value {
            font-size: 15px;
            font-weight: 600;
            color: #212529;
        }

        /* Responsive Analytics Styles */
        @media (max-width: 768px) {
            .analytics-metric-card {
                padding: 16px;
                margin-bottom: 16px;
            }

            .metric-icon {
                width: 48px;
                height: 48px;
                font-size: 20px;
                margin-bottom: 12px;
            }

            .metric-value {
                font-size: 24px;
            }

            .chart-header {
                padding: 16px;
            }

            .chart-body {
                padding: 16px;
            }

            .chart-title {
                font-size: 16px;
            }

            .performance-card {
                padding: 16px;
                margin-bottom: 16px;
            }

            .status-legend {
                gap: 12px;
            }

            .legend-item {
                font-size: 12px;
            }
        }

        @media (max-width: 576px) {
            .analytics-metric-card {
                padding: 12px;
            }

            .metric-value {
                font-size: 20px;
            }

            .chart-controls {
                flex-direction: column;
                gap: 4px;
            }

            .chart-controls .btn {
                padding: 8px 12px;
                font-size: 12px;
            }

            .status-legend {
                flex-direction: column;
                gap: 8px;
            }
        }
    </style>
    @endpush

    <!-- Navigation Tabs -->
    <div class="content-tabs overflow-auto">
        <div class="d-flex">
            <div class="content-tab {{ $activeTab === 'overview' ? 'active' : '' }}" wire:click="selectedTab('overview')">Overview</div>
                        <div class="content-tab {{ $activeTab === 'reports' ? 'active' : '' }}" wire:click="selectedTab('reports')">Reports</div>
            <div class="content-tab {{ $activeTab === 'analytics' ? 'active' : '' }}" wire:click="selectedTab('analytics')">Analytics</div>
            <div class="content-tab {{ $activeTab === 'notifications' ? 'active' : '' }}" wire:click="selectedTab('notifications')">Notifications</div>
        </div>
    </div>

    <!-- Overview Content -->
    <div id="overview" class="tab-content {{ $activeTab === 'overview' ? 'active' : '' }}">
        <!-- Stats Cards Row -->
        <div class="row mb-4">
            <div class="col-sm-6 col-lg-3 mb-3">
                <div class="stat-card">
                    <div class="d-flex justify-content-between align-items-center mb-2">
                        <div class="stat-label">Total Revenue</div>
                        {{-- <a href="" class="btn btn-sm btn-outline-secondary">
                            <i class="bi bi-arrow-right"></i>
                        </a> --}}
                    </div>
                    <div class="stat-value">Rs.{{ number_format($totalRevenue, 2) }}</div>
                    <div class="stat-info mt-1">
                        <div class="d-flex justify-content-between mb-1">
                            <small>Revenue</small>
                            <small>{{ $revenuePercentage }}% of total sales</small>
                        </div>
                        <div class="progress">
                            <div class="progress-bar bg-success" role="progressbar"
                                style="width: {{ $revenuePercentage }}%;" aria-valuenow="{{ $revenuePercentage }}"
                                aria-valuemin="0" aria-valuemax="100"></div>
                        </div>
                        <div class="d-flex justify-content-between">
                            <small class="text-muted text-truncate-mobile">Rs.{{ number_format($totalRevenue) }} of
                                Rs.{{ number_format($totalRevenue+$totalDueAmount) }}</small>
                        </div>
                    </div>

                    <!-- Added Fully Paid Invoices Information -->
                    <div class="stat-info mt-3 pt-2 border-top">
                        <div class="d-flex justify-content-between align-items-center">
                            <small class="text-muted"><i class="bi bi-check-circle-fill text-success me-1"></i> Fully
                                Paid</small>
                            <span class="badge bg-success">{{ $fullPaidCount }}</span>
                        </div>
                        <small class="d-block text-end text-success">Rs.{{ number_format($fullPaidAmount, 2) }}</small>
                    </div>
                </div>
            </div>
            <div class="col-sm-6 col-lg-3 mb-3">
                <div class="stat-card">
                    <div class="d-flex justify-content-between align-items-center mb-2">
                        <div class="stat-label">Total Due Amount</div>
                    </div>
                    <div class="stat-value">Rs.{{ number_format($totalDueAmount, 2) }}</div>
                    <div class="stat-change-alert">
                        <div class="d-flex justify-content-between mb-1">
                            <small>Due Amount</small>
                            <small>{{ $duePercentage }}% of total sales</small>
                        </div>
                        <div class="progress">
                            <div class="progress-bar bg-danger" role="progressbar" style="width: {{ $duePercentage }}%;"
                                aria-valuenow="{{ $duePercentage }}" aria-valuemin="0" aria-valuemax="100"></div>
                        </div>
                        <div class="d-flex justify-content-between">
                            <small class="text-muted text-truncate-mobile">Rs.{{ number_format($totalDueAmount) }} due
                                of {{ number_format($totalDueAmount+$totalRevenue) }}</small>
                        </div>
                    </div>

                    <!-- Partial Payment Info -->
                    <div class="stat-info mt-3 pt-2 border-top">
                        <div class="d-flex justify-content-between align-items-center">
                            <small class="text-muted"><i class="bi bi-clock-fill text-danger me-1"></i> Partially
                                Paid</small>
                            <span class="badge bg-danger">{{ $partialPaidCount }}</span>
                        </div>
                        <small class="d-block text-end text-danger">Rs.{{ number_format($totalDueAmount, 2) }}</small>
                    </div>
                </div>
            </div>
            <div class="col-sm-6 col-lg-3 mb-3">
                <div class="stat-card">
                    <div class="d-flex justify-content-between align-items-center mb-2">
                        <div class="stat-label">Inventory Status</div>
                    </div>
                    <div class="stat-value">{{ number_format($totalStock) }} <span class="fs-6 text-muted">units</span>
                    </div>

                    <!-- Sales Progress -->
                    <div class="stat-info">
                        <div class="d-flex justify-content-between mb-1">
                            <small>Sold Stock</small>
                            <small>{{ $soldPercentage }}% of assigned</small>
                        </div>
                        <div class="progress">
                            <div class="progress-bar bg-primary" role="progressbar"
                                style="width: {{ $soldPercentage }}%;" aria-valuenow="{{ $soldPercentage }}"
                                aria-valuemin="0" aria-valuemax="100"></div>
                        </div>
                        <div class="d-flex justify-content-between">
                            <small class="text-muted text-truncate-mobile">{{ number_format($soldStock) }} sold of {{
                                number_format($assignedStock) }}</small>
                        </div>
                    </div>

                    <!-- Damaged Stock Info -->
                    <div class="stat-info mt-3 pt-2 border-top">
                        <div class="d-flex justify-content-between align-items-center">
                            <small class="text-muted"><i
                                    class="bi bi-exclamation-triangle-fill text-primary me-1"></i>Available
                                Stock</small>
                            <span class="badge bg-primary">{{ number_format($availableStock) }}</span>
                        </div>
                        <small class="d-block text-end text-primary">Rs.{{ number_format($totalAvailableInventory, 2)
                            }}</small>
                    </div>
                </div>
            </div>
            <div class="col-sm-6 col-lg-3 mb-3">
                <div class="stat-card">
                    <div class="d-flex justify-content-between align-items-center mb-2">
                        <div class="stat-label">Staff Status</div>
                    </div>
                    <div class="stat-value">{{ $totalStaffCount }} <span class="fs-6 text-muted">members</span></div>

                    <!-- Staff Product Assignment Progress -->
                    <div class="stat-info mt-1">
                        <div class="d-flex justify-content-between mb-1">
                            <small>Staff with Products</small>
                            <small>{{ $staffAssignmentPercentage }}% of total</small>
                        </div>
                        <div class="progress">
                            <div class="progress-bar bg-info" role="progressbar"
                                style="width: {{ $staffAssignmentPercentage }}%;"
                                aria-valuenow="{{ $staffAssignmentPercentage }}" aria-valuemin="0" aria-valuemax="100">
                            </div>
                        </div>
                        <div class="d-flex justify-content-between">
                            <small class="text-muted text-truncate-mobile">{{ $staffWithAssignmentsCount }} staff with
                                assignments</small>
                        </div>
                    </div>

                    <!-- Assigned Stock Info -->
                    <div class="stat-info mt-3 pt-2 border-top">
                        <div class="d-flex justify-content-between align-items-center">
                            <small class="text-muted"><i class="bi bi-person-check-fill text-info me-1"></i>
                                Assigned</small>
                            <span class="badge bg-info">{{ $assignedStock }}</span>
                        </div>
                        <small class="d-block text-end text-info">Rs.{{number_format($totalStaffSalesValue, 2)}}</small>
                    </div>
                </div>
            </div>
        </div>

        <!-- Chart Section -->
        <div class="row">
            <div class="col-lg-8 col-md-12 mb-4">
                <div class="chart-card">
                    <div class="chart-header d-flex justify-content-between align-items-center flex-wrap">
                        <div class="mb-mobile-2">
                            <h6 class="mb-1">Sales Overview By Brands</h6>
                            <p class="text-muted mb-0 small">Compare sales performance Base Product Brands</p>
                        </div>
                        <a href="" class="btn btn-sm btn-outline-primary">
                            View Report <i class="bi bi-bar-chart-line"></i>
                        </a>
                    </div>
                    <!-- Add scrollable wrapper for the chart -->
                    <div class="chart-scroll-container">
                        <div class="chart-container" style="min-width: {{ count($brandSales) * 60 }}px;">
                            <canvas id="salesChart"></canvas>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Recent Sales Section -->
            <div class="col-lg-4 col-md-12 mb-4">
                <div class="recent-sales-card">
                    <div class="card-body">
                        <div class="p-2 d-flex justify-content-between align-items-start flex-wrap">
                            <div class="mb-2 mb-md-0">
                                <h6 class="card-title">Recent Sales</h6>
                                <p class="card-subtitle text-muted small mb-0">Latest transactions</p>
                            </div>
                            <a href="" class="btn btn-sm btn-outline-primary">
                                <i class="bi bi-list-ul"></i>
                            </a>
                        </div>
                        <ul class="list-group list-group-flush">
                            @forelse($recentSales as $sale)
                            <li class="list-group-item d-flex align-items-center">
                                <div class="avatar">
                                    {{ strtoupper(substr($sale->name, 0, 1)) }}{{ strtoupper(substr(strpos($sale->name,
                                    ' ') !== false ? substr($sale->name, strpos($sale->name, ' ') + 1, 1) : '', 0, 1))
                                    }}
                                </div>
                                <div class="flex-grow-1">
                                    <h6 class="mb-1 text-truncate-mobile">{{ $sale->name }}</h6>
                                    <p class="text-muted small mb-0 text-truncate-mobile">{{ $sale->email }}</p>
                                </div>
                                <div class="amount">
                                    +Rs.{{ number_format($sale->total_amount, 2) }}
                                    @if($sale->due_amount > 0)
                                    <span class="d-block text-danger small text-end">Rs.{{
                                        number_format($sale->due_amount, 2) }}</span>
                                    @else
                                    <span class="d-block badge bg-success mt-1 small">Paid</span>
                                    @endif
                                </div>
                            </li>
                            @empty
                            <li class="list-group-item text-center">
                                <p class="text-muted mb-0">No sales recorded yet</p>
                            </li>
                            @endforelse
                        </ul>
                    </div>
                </div>
            </div>
        </div>
        <!-- Inventory and staff section -->
        <div class="container-fluid mt-4 p-0">
            <div class="row">
                <div class="col-lg-5 col-md-12 mb-4">
                    <div class="widget-container">
                        <div class="widget-header d-flex justify-content-between align-items-start flex-wrap">
                            <div class="mb-2 mb-md-0">
                                <h6>Inventory Status</h6>
                                <p class="text-muted small mb-0">Current stock levels and alerts</p>
                            </div>
                            <a href="{{ route('admin.Product-stock-details') }}" class="btn btn-sm btn-outline-primary">
                                <i class="bi bi-box-seam"></i>
                            </a>
                        </div>

                        <!-- Scrollable container WITHOUT footer -->
                        <div class="inventory-container" style="max-height: 400px; overflow-y: auto;">
                            @forelse($ProductInventory as $Product)
                            @php
                            // Calculate stock percentage and status
                            $stockPercentage = $Product->total_stock > 0 ?
                            round(($Product->available_stock / $Product->total_stock) * 100, 2) : 0;

                            // Determine stock status badge
                            if ($Product->available_stock == 0) {
                            $statusClass = 'out-of-stock';
                            $statusText = 'Out of Stock';
                            $progressClass = 'bg-danger';
                            } elseif ($stockPercentage <= 25) { $statusClass='low-stock' ; $statusText='Low Stock' ;
                                $progressClass='bg-warning' ; } else { $statusClass='in-stock' ; $statusText='In Stock'
                                ; $progressClass='' ; } @endphp <div class="item-row @if(!$loop->first) mt-3 @endif">
                                <div class="item-details">
                                    <h6 class="text-truncate-mobile">{{ $Product->name }} {{ $Product->model }}</h6>
                                    <p class="text-muted small text-truncate-mobile">SKU: {{ $Product->code }}</p>
                                </div>
                                <div class="d-flex align-items-center flex-wrap mt-1 mt-md-0">
                                    <span class="status-badge {{ $statusClass }}">{{ $statusText }}</span>
                                    <div class="ms-2 text-muted small">{{ $Product->available_stock }}/{{
                                        $Product->total_stock }}</div>
                                </div>
                        </div>
                        <div class="progress">
                            <div class="progress-bar {{ $progressClass }}" style="width: {{ $stockPercentage }}%;">
                            </div>
                        </div>
                        @empty
                        <div class="alert alert-info">No Product inventory data available.</div>
                        @endforelse
                    </div>
                </div>
            </div>

            <!-- Staff Sales Section -->
            <div class="col-lg-7 col-md-12 mb-4">
                <div class="widget-container p-3">
                    <div class="widget-header mb-3 d-flex justify-content-between align-items-start flex-wrap">
                        <div class="mb-2 mb-md-0">
                            <h6 class="fw-bold">Staff Sales</h6>
                            <p class="text-muted small mb-0">Sales performance and collection status</p>
                        </div>
                        <a href="" class="btn btn-sm btn-outline-primary">
                            <i class="bi bi-people"></i>
                        </a>
                    </div>

                    <!-- Scrollable container WITHOUT footer -->
                    <div class="staff-sales-container" style="max-height: 400px; overflow-y: auto;">
                        @forelse($staffSales as $staff)
                        <div class="staff-card p-3 mb-3 bg-light rounded shadow-sm">
                            <div class="d-flex align-items-start mb-2">
                                <div class="staff-avatar me-2">
                                    <span class="badge bg-primary bg-opacity-25 text-white fw-medium py-2 px-2">
                                        {{ strtoupper(substr($staff->name, 0, 1)) }}{{
                                        strtoupper(substr(strpos($staff->name, ' ') !== false ? substr($staff->name,
                                        strpos($staff->name, ' ') + 1, 1) : '', 0, 1)) }}
                                    </span>
                                </div>
                                <div class="flex-grow-1">
                                    <h6 class="fw-bold mb-0 text-truncate-mobile">{{ $staff->name }}</h6>
                                </div>
                            </div>

                            <!-- Sales Progress Section -->
                            <div class="sales-progress mb-2">
                                <div class="d-flex justify-content-between align-items-center mb-1 flex-wrap">
                                    <small class="text-muted">Sales Progress</small>
                                    <div class="d-flex align-items-center flex-wrap">
                                        <small class="me-2 text-success fw-bold">Rs.{{ number_format($staff->sold_value,
                                            2) }}</small>
                                        <small class="text-muted">/ Rs.{{ number_format($staff->assigned_value, 2)
                                            }}</small>
                                        <span class="badge bg-success ms-2">{{ $staff->sales_percentage }}%</span>
                                    </div>
                                </div>
                                <div class="progress" style="height: 6px;">
                                    <div class="progress-bar bg-success" role="progressbar"
                                        style="width: {{ $staff->sales_percentage }}%"></div>
                                </div>
                            </div>

                            <!-- Payment Progress Section -->
                            <div class="payment-progress">
                                <div class="d-flex justify-content-between align-items-center mb-1 flex-wrap">
                                    <small class="text-muted">Payment Collection</small>
                                    <div class="d-flex align-items-center flex-wrap">
                                        <small class="me-2 text-success fw-bold">Rs.{{
                                            number_format($staff->collected_amount, 2) }}</small>
                                        <small class="text-danger fw-bold">- Rs.{{ number_format($staff->total_due, 2)
                                            }} due</small>
                                        <span
                                            class="badge {{ $staff->payment_percentage >= 80 ? 'bg-success' : 'bg-danger' }} ms-2">{{
                                            $staff->payment_percentage }}%</span>
                                    </div>
                                </div>
                                <div class="progress" style="height: 6px;">
                                    <div class="progress-bar {{ $staff->payment_percentage >= 80 ? 'bg-success' : 'bg-danger' }}"
                                        role="progressbar" style="width: {{ $staff->payment_percentage }}%"></div>
                                </div>
                            </div>
                        </div>
                        @empty
                        <div class="alert alert-info">No staff sales data available.</div>
                        @endforelse
                    </div>
                </div>
            </div>
        </div>
    </div>
    </div>


    <!-- Analytics Content -->
    <div id="analytics" class="tab-content {{ $activeTab === 'analytics' ? 'active' : '' }}">
        <!-- Analytics Header -->
        <div class="row mb-4">
            <div class="col-12">
                <div class="d-flex justify-content-between align-items-center">
                    <div>
                        <h4 class="fw-bold mb-1">Analytics Dashboard</h4>
                        <p class="text-muted mb-0">Comprehensive business insights and trends</p>
                    </div>
                    <div class="d-flex gap-2">
                        <button class="btn btn-outline-primary btn-sm">
                            <i class="bi bi-download"></i> Export
                        </button>
                        <button class="btn btn-primary btn-sm">
                            <i class="bi bi-arrow-clockwise"></i> Refresh
                        </button>
                    </div>
                </div>
            </div>
        </div>

        <!-- Key Metrics Cards -->
        <div class="row mb-4">
            <div class="col-xl-3 col-md-6 mb-3">
                <div class="analytics-metric-card">
                    <div class="metric-icon revenue-icon">
                        <i class="bi bi-graph-up-arrow"></i>
                    </div>
                    <div class="metric-content">
                        <h6 class="metric-title">Total Revenue</h6>
                        <h3 class="metric-value">Rs.{{ number_format($totalRevenue) }}</h3>
                        <span class="metric-change positive">
                            <i class="bi bi-arrow-up"></i> {{ $revenueChangePercentage }}%
                        </span>
                    </div>
                </div>
            </div>
            <div class="col-xl-3 col-md-6 mb-3">
                <div class="analytics-metric-card">
                    <div class="metric-icon sales-icon">
                        <i class="bi bi-receipt"></i>
                    </div>
                    <div class="metric-content">
                        <h6 class="metric-title">Total Invoices</h6>
                        <h3 class="metric-value">{{ array_sum(array_column($monthlySalesData, 'total_invoices')) }}</h3>
                        <span class="metric-change">
                            <i class="bi bi-calendar-month"></i> This Year
                        </span>
                    </div>
                </div>
            </div>
            <div class="col-xl-3 col-md-6 mb-3">
                <div class="analytics-metric-card">
                    <div class="metric-icon due-icon">
                        <i class="bi bi-exclamation-triangle"></i>
                    </div>
                    <div class="metric-content">
                        <h6 class="metric-title">Outstanding Due</h6>
                        <h3 class="metric-value">Rs.{{ number_format($totalDueAmount) }}</h3>
                        <span class="metric-change negative">
                            <i class="bi bi-arrow-down"></i> {{ $duePercentage }}%
                        </span>
                    </div>
                </div>
            </div>
            <div class="col-xl-3 col-md-6 mb-3">
                <div class="analytics-metric-card">
                    <div class="metric-icon profit-icon">
                        <i class="bi bi-currency-rupee"></i>
                    </div>
                    <div class="metric-content">
                        <h6 class="metric-title">Collection Rate</h6>
                        <h3 class="metric-value">{{ $revenuePercentage }}%</h3>
                        <span class="metric-change positive">
                            <i class="bi bi-check-circle"></i> Collected
                        </span>
                    </div>
                </div>
            </div>
        </div>

        <!-- Charts Row 1 -->
        <div class="row mb-4">
            <!-- Monthly Sales Trend -->
            <div class="col-xl-8 col-lg-7 mb-4">
                <div class="analytics-chart-card">
                    <div class="chart-header">
                        <div class="d-flex justify-content-between align-items-center">
                            <div>
                                <h6 class="chart-title">Monthly Sales & Revenue Trends</h6>
                                <p class="chart-subtitle">Sales performance over the last 12 months</p>
                            </div>
                            <div class="chart-controls">
                                <button class="btn btn-sm btn-outline-secondary active" data-chart="sales">Sales</button>
                                <button class="btn btn-sm btn-outline-secondary" data-chart="revenue">Revenue</button>
                            </div>
                        </div>
                    </div>
                    <div class="chart-body">
                        <canvas id="monthlySalesChart" height="400"></canvas>
                    </div>
                </div>
            </div>

            <!-- Invoice Status Distribution -->
            <div class="col-xl-4 col-lg-5 mb-4">
                <div class="analytics-chart-card">
                    <div class="chart-header">
                        <h6 class="chart-title">Invoice Status</h6>
                        <p class="chart-subtitle">Payment status distribution</p>
                    </div>
                    <div class="chart-body">
                        <canvas id="invoiceStatusChart" height="300"></canvas>
                    </div>
                    <div class="chart-footer">
                        <div class="status-legend">
                            <div class="legend-item">
                                <span class="legend-color paid"></span>
                                <span>Fully Paid</span>
                            </div>
                            <div class="legend-item">
                                <span class="legend-color partial"></span>
                                <span>Partial</span>
                            </div>
                            <div class="legend-item">
                                <span class="legend-color pending"></span>
                                <span>Pending</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Charts Row 2 -->
        <div class="row mb-4">
            <!-- Payment Trends -->
            <div class="col-xl-6 col-lg-6 mb-4">
                <div class="analytics-chart-card">
                    <div class="chart-header">
                        <h6 class="chart-title">Payment Collection Trends</h6>
                        <p class="chart-subtitle">Monthly payment collections</p>
                    </div>
                    <div class="chart-body">
                        <canvas id="paymentTrendsChart" height="250"></canvas>
                    </div>
                </div>
            </div>

            <!-- Monthly Comparison -->
            <div class="col-xl-6 col-lg-6 mb-4">
                <div class="analytics-chart-card">
                    <div class="chart-header">
                        <h6 class="chart-title">Monthly Revenue vs Due Comparison</h6>
                        <p class="chart-subtitle">Revenue and outstanding comparison</p>
                    </div>
                    <div class="chart-body">
                        <canvas id="revenueComparisonChart" height="250"></canvas>
                    </div>
                </div>
            </div>
        </div>

        <!-- Top Performing Months -->
        @if(count($topPerformingMonths) > 0)
        <div class="row mb-4">
            <div class="col-12">
                <div class="analytics-chart-card">
                    <div class="chart-header">
                        <h6 class="chart-title">Top Performing Months</h6>
                        <p class="chart-subtitle">Best revenue generating months</p>
                    </div>
                    <div class="chart-body">
                        <div class="row">
                            @foreach($topPerformingMonths as $index => $month)
                            <div class="col-xl-4 col-md-6 mb-3">
                                <div class="performance-card rank-{{ $index + 1 }}">
                                    <div class="rank-badge">
                                        @if($index == 0)
                                            <i class="bi bi-trophy-fill text-warning"></i>
                                        @elseif($index == 1)
                                            <i class="bi bi-award-fill text-muted"></i>
                                        @else
                                            <i class="bi bi-award text-dark"></i>
                                        @endif
                                        #{{ $index + 1 }}
                                    </div>
                                    <div class="performance-content">
                                        <h5 class="month-name">{{ $month['month_name'] }}</h5>
                                        <div class="performance-stats">
                                            <div class="stat-item">
                                                <span class="stat-label px-2">Revenue</span>
                                                <span class="stat-value">Rs.{{ number_format($month['revenue']) }}</span>
                                            </div>
                                            <div class="stat-item">
                                                <span class="stat-label px-2">Invoices</span>
                                                <span class="stat-value">{{ $month['total_invoices'] }}</span>
                                            </div>
                                            <div class="stat-item">
                                                <span class="stat-label px-2">Collection Rate</span>
                                                <span class="stat-value">{{ number_format(($month['revenue'] / $month['total_sales']) * 100, 1) }}%</span>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            @endforeach
                        </div>
                    </div>
                </div>
            </div>
        </div>
        @endif

        <!-- Detailed Analytics Table -->
        <div class="row">
            <div class="col-12">
                <div class="analytics-chart-card">
                    <div class="chart-header">
                        <h6 class="chart-title">Monthly Breakdown</h6>
                        <p class="chart-subtitle">Detailed monthly performance data</p>
                    </div>
                    <div class="chart-body">
                        <div class="table-responsive">
                            <table class="table table-hover">
                                <thead class="table-light">
                                    <tr>
                                        <th>Month</th>
                                        <th>Invoices</th>
                                        <th>Total Sales</th>
                                        <th>Revenue</th>
                                        <th>Due Amount</th>
                                        <th>Collection %</th>
                                        <th>Growth</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($monthlySalesData as $index => $month)
                                    <tr>
                                        <td>
                                            <strong>{{ $month['month_name'] }}</strong>
                                        </td>
                                        <td>
                                            <span class="badge bg-primary">{{ $month['total_invoices'] }}</span>
                                        </td>
                                        <td>Rs.{{ number_format($month['total_sales']) }}</td>
                                        <td>
                                            <span class="text-success fw-bold">Rs.{{ number_format($month['revenue']) }}</span>
                                        </td>
                                        <td>
                                            <span class="text-danger">Rs.{{ number_format($month['due_amount']) }}</span>
                                        </td>
                                        <td>
                                            @php
                                                $collectionRate = $month['total_sales'] > 0 ? ($month['revenue'] / $month['total_sales']) * 100 : 0;
                                            @endphp
                                            <div class="d-flex align-items-center">
                                                <div class="progress me-2" style="width: 60px; height: 8px;">
                                                    <div class="progress-bar 
                                                        @if($collectionRate >= 80) bg-success 
                                                        @elseif($collectionRate >= 60) bg-warning 
                                                        @else bg-danger @endif" 
                                                        style="width: {{ $collectionRate }}%"></div>
                                                </div>
                                                <span class="small">{{ number_format($collectionRate, 1) }}%</span>
                                            </div>
                                        </td>
                                        <td>
                                            @if($index > 0)
                                                @php
                                                    $prevMonth = $monthlySalesData[$index - 1];
                                                    $growth = $prevMonth['revenue'] > 0 ? (($month['revenue'] - $prevMonth['revenue']) / $prevMonth['revenue']) * 100 : 0;
                                                @endphp
                                                <span class="badge {{ $growth >= 0 ? 'bg-success' : 'bg-danger' }}">
                                                    <i class="bi bi-arrow-{{ $growth >= 0 ? 'up' : 'down' }}"></i>
                                                    {{ number_format(abs($growth), 1) }}%
                                                </span>
                                            @else
                                                <span class="text-muted">-</span>
                                            @endif
                                        </td>
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Reports Content -->
    <div id="reports" class="tab-content {{ $activeTab === 'reports' ? 'active' : '' }}">
        <div class="mb-3 card p-3 shadow-sm border-0">
            <div class="row g-2 align-items-end">
                <div class="col-md-3 col-12">
                    <label class="form-label fw-semibold">Report Type</label>
                    <select class="form-select" wire:model="selectedReport">
                        <option value="">-- Select Report --</option>
                        <option value="sales">Sales Report</option>
                        <option value="salary">Salary Report</option>
                        <option value="inventory">Inventory Report</option>
                        <option value="staff">Staff Report</option>
                        <option value="payments">Payments Report</option>
                        <option value="attendance">Attendance Report</option>
                    </select>
                </div>
                <div class="col-md-3 col-6">
                    <label class="form-label fw-semibold">Start Date</label>
                    <input type="date" class="form-control" wire:model="reportStartDate">
                </div>
                <div class="col-md-3 col-6">
                    <label class="form-label fw-semibold">End Date</label>
                    <input type="date" class="form-control" wire:model="reportEndDate">
                    @error('reportEndDate')
                    <small class="text-danger">{{ $message }}</small>
                    @enderror
                </div>
                <div class="col-md-3 col-12 d-grid">
                    <button class="btn btn-primary mt-md-4 mt-2" wire:click="generateReport" onclick="showReportModal()">
                        <i class="bi bi-file-earmark-bar-graph"></i> Generate Report
                    </button>
                    @if($selectedReport && (count($salesReport) || count($salaryReport) || count($inventoryReport) || count($staffReport) || count($paymentsReport) || count($attendanceReport)))
                    <button class="btn btn-success mt-2" wire:click="downloadReport">
                        <i class="bi bi-download"></i> Download Excel
                    </button>
                    @endif
                </div>
            </div>
        </div>
        <div>
            @if($selectedReport === 'sales')
            @include('livewire.admin.reports.sales-report', ['data' => $salesReport, 'salesReportTotal' => $salesReportTotal])
            @elseif($selectedReport === 'salary')
            @include('livewire.admin.reports.salary-report', ['data' => $salaryReport, 'salaryReportTotal' => $salaryReportTotal])
            @elseif($selectedReport === 'inventory')
            @include('livewire.admin.reports.inventory-report', ['data' => $inventoryReport, 'inventoryReportTotal' => $inventoryReportTotal])
            @elseif($selectedReport === 'staff')
            @include('livewire.admin.reports.staff-report', ['data' => $staffReport, 'staffReportTotal' => $staffReportTotal])
            @elseif($selectedReport === 'payments')
            @include('livewire.admin.reports.payments-report', ['data' => $paymentsReport, 'paymentsReportTotal' => $paymentsReportTotal])
            @elseif($selectedReport === 'attendance')
            @include('livewire.admin.reports.attendance-report', ['data' => $attendanceReport, 'attendanceReportTotal' => $attendanceReportTotal])
            @else
            <div class="alert alert-info">Please select a report type and date range.</div>
            @endif
        </div>
    </div>

    <!-- Notifications Content -->
    <div id="notifications" class="tab-content {{ $activeTab === 'notifications' ? 'active' : '' }}">
        <div class="alert alert-info">
            Notifications content will appear here when this tab is selected.
        </div>
    </div>
    @push('scripts')
    <script>
        // Prepare data from PHP
        const brandLabels = @json(collect($brandSales)->pluck('brand'));
        const brandTotals = @json(collect($brandSales)->pluck('total_sales'));
        
        // Analytics data
        const monthlySalesData = @json($monthlySalesData);
        const invoiceStatusData = @json($invoiceStatusData);
        const paymentTrendsData = @json($paymentTrendsData);

        // Chart instances
        let salesChartInstance = null;
        let monthlySalesChartInstance = null;
        let invoiceStatusChartInstance = null;
        let paymentTrendsChartInstance = null;
        let revenueComparisonChartInstance = null;

        // Global helper function to format large numbers
        function formatCurrency(value) {
            if (value >= 10000000) {
                return 'Rs.' + (value / 10000000).toFixed(1) + 'Cr';
            } else if (value >= 100000) {
                return 'Rs.' + (value / 100000).toFixed(1) + 'L';
            } else if (value >= 1000) {
                return 'Rs.' + (value / 1000).toFixed(0) + 'K';
            }
            return 'Rs.' + new Intl.NumberFormat().format(value);
        }

        document.addEventListener('DOMContentLoaded', function() {
            // Initialize existing brand sales chart
            initializeBrandSalesChart();
            
            // Initialize analytics charts
            initializeAnalyticsCharts();

            // Add tab change listeners to reinitialize analytics charts
            const analyticsTab = document.querySelector('.content-tab[wire\\:click="selectedTab(\'analytics\')"]');
            if (analyticsTab) {
                analyticsTab.addEventListener('click', function() {
                    // Small delay to ensure tab content is visible
                    setTimeout(function() {
                        // Check if analytics tab is active
                        const analyticsContent = document.getElementById('analytics');
                        if (analyticsContent && analyticsContent.classList.contains('active')) {
                            console.log('Reinitializing analytics charts...');
                            initializeAnalyticsCharts();
                        }
                    }, 100);
                });
            }

            // Also listen for Livewire updates (when tab switching via Livewire)
            document.addEventListener('livewire:load', function() {
                // Reinitialize charts after Livewire updates
                setTimeout(function() {
                    const analyticsContent = document.getElementById('analytics');
                    if (analyticsContent && analyticsContent.classList.contains('active')) {
                        initializeAnalyticsCharts();
                    }
                }, 150);
            });
        });

        function initializeBrandSalesChart() {
            const ctx = document.getElementById('salesChart');
            if (!ctx) return;
            
            salesChartInstance = new Chart(ctx.getContext('2d'), {
                type: 'bar',
                data: {
                    labels: brandLabels,
                    datasets: [{
                        label: 'Sales by Brand',
                        backgroundColor: '#007bff',
                        borderColor: '#007bff',
                        borderWidth: 1,
                        data: brandTotals
                    }]
                },
                options: getResponsiveChartOptions()
            });
        }

        function initializeAnalyticsCharts() {
            // Destroy existing charts before creating new ones
            destroyExistingCharts();
            
            // Monthly Sales Trend Chart
            initializeMonthlySalesChart();
            
            // Invoice Status Pie Chart
            initializeInvoiceStatusChart();
            
            // Payment Trends Chart
            initializePaymentTrendsChart();
            
            // Revenue Comparison Chart
            initializeRevenueComparisonChart();
        }

        function destroyExistingCharts() {
            if (monthlySalesChartInstance) {
                monthlySalesChartInstance.destroy();
                monthlySalesChartInstance = null;
            }
            if (invoiceStatusChartInstance) {
                invoiceStatusChartInstance.destroy();
                invoiceStatusChartInstance = null;
            }
            if (paymentTrendsChartInstance) {
                paymentTrendsChartInstance.destroy();
                paymentTrendsChartInstance = null;
            }
            if (revenueComparisonChartInstance) {
                revenueComparisonChartInstance.destroy();
                revenueComparisonChartInstance = null;
            }

            // Reset all canvas elements to prevent dimension accumulation
            const canvasIds = ['monthlySalesChart', 'invoiceStatusChart', 'paymentTrendsChart', 'revenueComparisonChart'];
            canvasIds.forEach(canvasId => {
                const canvas = document.getElementById(canvasId);
                if (canvas) {
                    // Clear all canvas attributes and styles
                    canvas.style.height = '';
                    canvas.style.width = '';
                    canvas.removeAttribute('height');
                    canvas.removeAttribute('width');
                    // Reset canvas parent container if needed
                    const parent = canvas.parentElement;
                    if (parent) {
                        parent.style.height = '';
                        parent.style.width = '';
                    }
                }
            });
        }

        function resetCanvas(canvasId) {
            const canvas = document.getElementById(canvasId);
            if (!canvas) return null;

            // Store parent for context
            const parent = canvas.parentElement;
            
            // Remove all inline styles and attributes
            canvas.removeAttribute('style');
            canvas.removeAttribute('height');
            canvas.removeAttribute('width');
            canvas.style.cssText = '';
            
            // Reset parent container styles if needed
            if (parent) {
                parent.style.height = '';
                parent.style.width = '';
            }

            return canvas;
        }

        function initializeMonthlySalesChart() {
            const canvas = resetCanvas('monthlySalesChart');
            if (!canvas) return;

            const ctx = canvas.getContext('2d');

            const months = monthlySalesData.map(item => item.month_name);
            const salesData = monthlySalesData.map(item => item.total_sales);
            const revenueData = monthlySalesData.map(item => item.revenue);

            // Helper function to format large numbers
            function formatCurrency(value) {
                if (value >= 10000000) {
                    return 'Rs.' + (value / 10000000).toFixed(1) + 'Cr';
                } else if (value >= 100000) {
                    return 'Rs.' + (value / 100000).toFixed(1) + 'L';
                } else if (value >= 1000) {
                    return 'Rs.' + (value / 1000).toFixed(0) + 'K';
                }
                return 'Rs.' + new Intl.NumberFormat().format(value);
            }

            monthlySalesChartInstance = new Chart(ctx, {
                type: 'line',
                data: {
                    labels: months,
                    datasets: [
                        {
                            label: 'Total Sales',
                            data: salesData,
                            borderColor: '#007bff',
                            backgroundColor: 'rgba(0, 123, 255, 0.15)',
                            borderWidth: 4,
                            pointRadius: 6,
                            pointHoverRadius: 8,
                            pointBackgroundColor: '#007bff',
                            pointBorderColor: '#fff',
                            pointBorderWidth: 2,
                            fill: true,
                            tension: 0.4
                        },
                        {
                            label: 'Revenue',
                            data: revenueData,
                            borderColor: '#28a745',
                            backgroundColor: 'rgba(40, 167, 69, 0.15)',
                            borderWidth: 4,
                            pointRadius: 6,
                            pointHoverRadius: 8,
                            pointBackgroundColor: '#28a745',
                            pointBorderColor: '#fff',
                            pointBorderWidth: 2,
                            fill: true,
                            tension: 0.4
                        }
                    ]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    aspectRatio: 1.5,
                    layout: {
                        padding: {
                            top: 15,
                            bottom: 15,
                            left: 10,
                            right: 10
                        }
                    },
                    interaction: {
                        mode: 'index',
                        intersect: false,
                    },
                    plugins: {
                        title: {
                            display: false
                        },
                        legend: {
                            position: 'top',
                            labels: {
                                usePointStyle: true,
                                padding: 20
                            }
                        },
                        tooltip: {
                            backgroundColor: 'rgba(0, 0, 0, 0.8)',
                            titleColor: '#fff',
                            bodyColor: '#fff',
                            borderColor: '#007bff',
                            borderWidth: 1,
                            callbacks: {
                                label: function(context) {
                                    return context.dataset.label + ': ' + formatCurrency(context.raw);
                                }
                            }
                        }
                    },
                    scales: {
                        x: {
                            grid: {
                                display: false
                            },
                            ticks: {
                                font: {
                                    size: window.innerWidth < 768 ? 10 : 12
                                }
                            }
                        },
                        y: {
                            beginAtZero: true,
                            grid: {
                                color: 'rgba(0, 0, 0, 0.1)'
                            },
                            ticks: {
                                stepSize: 1000000, // 10L intervals for better readability
                                maxTicksLimit: 12,
                                callback: function(value) {
                                    return formatCurrency(value);
                                },
                                font: {
                                    size: window.innerWidth < 768 ? 11 : 14
                                }
                            }
                        }
                    }
                }
            });
        }

        function initializeInvoiceStatusChart() {
            const ctx = resetCanvas('invoiceStatusChart');
            if (!ctx) return;

            const statusLabels = invoiceStatusData.map(item => {
                switch(item.payment_status) {
                    case 'paid': return 'Fully Paid';
                    case 'partial': return 'Partial';
                    case 'pending': return 'Pending';
                    default: return item.payment_status;
                }
            });
            const statusCounts = invoiceStatusData.map(item => item.count);
            const statusColors = ['#28a745', '#ffc107', '#dc3545'];

            invoiceStatusChartInstance = new Chart(ctx, {
                type: 'doughnut',
                data: {
                    labels: statusLabels,
                    datasets: [{
                        data: statusCounts,
                        backgroundColor: statusColors,
                        borderWidth: 2,
                        borderColor: '#fff'
                    }]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    aspectRatio: 1,
                    plugins: {
                        legend: {
                            display: false
                        },
                        tooltip: {
                            backgroundColor: 'rgba(0, 0, 0, 0.8)',
                            titleColor: '#fff',
                            bodyColor: '#fff',
                            borderColor: '#007bff',
                            borderWidth: 1,
                            callbacks: {
                                label: function(context) {
                                    const total = context.dataset.data.reduce((a, b) => a + b, 0);
                                    const percentage = ((context.raw / total) * 100).toFixed(1);
                                    return context.label + ': ' + context.raw + ' (' + percentage + '%)';
                                }
                            }
                        }
                    },
                    cutout: '60%'
                }
            });
        }

        function initializePaymentTrendsChart() {
            const ctx = resetCanvas('paymentTrendsChart');
            if (!ctx) return;

            const months = paymentTrendsData.map(item => item.month_name);
            const paymentAmounts = paymentTrendsData.map(item => item.total_payments);

            paymentTrendsChartInstance = new Chart(ctx, {
                type: 'bar',
                data: {
                    labels: months,
                    datasets: [{
                        label: 'Collections',
                        data: paymentAmounts,
                        backgroundColor: 'rgba(40, 167, 69, 0.8)',
                        borderColor: '#28a745',
                        borderWidth: 2,
                        borderRadius: 8,
                        borderSkipped: false,
                    }]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    aspectRatio: 2,
                    plugins: {
                        legend: {
                            display: false
                        },
                        tooltip: {
                            backgroundColor: 'rgba(0, 0, 0, 0.8)',
                            titleColor: '#fff',
                            bodyColor: '#fff',
                            borderColor: '#28a745',
                            borderWidth: 1,
                            callbacks: {
                                label: function(context) {
                                    const value = context.raw;
                                    let formattedValue;
                                    if (value >= 10000000) {
                                        formattedValue = 'Rs.' + (value / 10000000).toFixed(1) + ' Cr';
                                    } else if (value >= 100000) {
                                        formattedValue = 'Rs.' + (value / 100000).toFixed(1) + ' L';
                                    } else if (value >= 1000) {
                                        formattedValue = 'Rs.' + (value / 1000).toFixed(0) + ' K';
                                    } else {
                                        formattedValue = 'Rs.' + new Intl.NumberFormat().format(value);
                                    }
                                    return 'Collections: ' + formattedValue;
                                }
                            }
                        }
                    },
                    scales: {
                        x: {
                            grid: {
                                display: false
                            },
                            ticks: {
                                font: {
                                    size: window.innerWidth < 768 ? 10 : 12
                                }
                            }
                        },
                        y: {
                            beginAtZero: true,
                            grid: {
                                color: 'rgba(0, 0, 0, 0.1)'
                            },
                            ticks: {
                                stepSize: 50000,
                                maxTicksLimit: 8,
                                callback: function(value) {
                                    return formatCurrency(value);
                                },
                                font: {
                                    size: window.innerWidth < 768 ? 10 : 12
                                }
                            }
                        }
                    }
                }
            });
        }

        function initializeRevenueComparisonChart() {
            const ctx = resetCanvas('revenueComparisonChart');
            if (!ctx) return;

            const months = monthlySalesData.map(item => item.month_name);
            const revenueData = monthlySalesData.map(item => item.revenue);
            const dueData = monthlySalesData.map(item => item.due_amount);

            revenueComparisonChartInstance = new Chart(ctx, {
                type: 'bar',
                data: {
                    labels: months,
                    datasets: [
                        {
                            label: 'Revenue',
                            data: revenueData,
                            backgroundColor: 'rgba(40, 167, 69, 0.8)',
                            borderColor: '#28a745',
                            borderWidth: 2
                        },
                        {
                            label: 'Outstanding Due',
                            data: dueData,
                            backgroundColor: 'rgba(220, 53, 69, 0.8)',
                            borderColor: '#dc3545',
                            borderWidth: 2
                        }
                    ]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    aspectRatio: 2,
                    plugins: {
                        legend: {
                            position: 'top',
                            labels: {
                                usePointStyle: true,
                                padding: 20
                            }
                        },
                        tooltip: {
                            backgroundColor: 'rgba(0, 0, 0, 0.8)',
                            titleColor: '#fff',
                            bodyColor: '#fff',
                            borderColor: '#007bff',
                            borderWidth: 1,
                            callbacks: {
                                label: function(context) {
                                    return context.dataset.label + ': ' + formatCurrency(context.raw);
                                }
                            }
                        }
                    },
                    scales: {
                        x: {
                            grid: {
                                display: false
                            },
                            ticks: {
                                font: {
                                    size: window.innerWidth < 768 ? 10 : 12
                                }
                            }
                        },
                        y: {
                            beginAtZero: true,
                            grid: {
                                color: 'rgba(0, 0, 0, 0.1)'
                            },
                            ticks: {
                                stepSize: 50000,
                                maxTicksLimit: 8,
                                callback: function(value) {
                                    return formatCurrency(value);
                                },
                                font: {
                                    size: window.innerWidth < 768 ? 10 : 12
                                }
                            }
                        }
                    }
                }
            });
        }

        function getResponsiveChartOptions() {
            return {
                responsive: true,
                maintainAspectRatio: false,
                plugins: {
                    legend: { display: false },
                    tooltip: { 
                        enabled: true,
                        displayColors: false,
                        bodyFont: {
                            size: window.innerWidth < 768 ? 12 : 14
                        },
                        titleFont: {
                            size: window.innerWidth < 768 ? 12 : 14
                        }
                    }
                },
                scales: {
                    y: {
                        beginAtZero: true,
                        grid: { color: '#dee2e6' },
                        ticks: {
                            font: {
                                size: window.innerWidth < 768 ? 10 : 12
                            }
                        }
                    },
                    x: {
                        grid: { display: false },
                        ticks: {
                            font: {
                                size: window.innerWidth < 768 ? 10 : 12
                            }
                        }
                    }
                }
            };
        }

        // Handle window resize for all charts
        window.addEventListener('resize', function() {
            const charts = [salesChartInstance, monthlySalesChartInstance, invoiceStatusChartInstance, paymentTrendsChartInstance, revenueComparisonChartInstance];
            
            charts.forEach(chart => {
                if (chart) {
                    // Update font sizes based on screen width
                    if (chart.options.plugins && chart.options.plugins.tooltip) {
                        chart.options.plugins.tooltip.bodyFont = { size: window.innerWidth < 768 ? 12 : 14 };
                        chart.options.plugins.tooltip.titleFont = { size: window.innerWidth < 768 ? 12 : 14 };
                    }
                    if (chart.options.scales && chart.options.scales.y && chart.options.scales.y.ticks) {
                        chart.options.scales.y.ticks.font = { size: window.innerWidth < 768 ? 10 : 12 };
                    }
                    if (chart.options.scales && chart.options.scales.x && chart.options.scales.x.ticks) {
                        chart.options.scales.x.ticks.font = { size: window.innerWidth < 768 ? 10 : 12 };
                    }
                    chart.update();
                }
            });
        });

        // Chart control buttons
        document.addEventListener('click', function(e) {
            if (e.target.matches('[data-chart]')) {
                const chartType = e.target.getAttribute('data-chart');
                const buttons = document.querySelectorAll('[data-chart]');
                
                buttons.forEach(btn => btn.classList.remove('active'));
                e.target.classList.add('active');
                
                // Update chart based on selection
                if (monthlySalesChartInstance && chartType === 'revenue') {
                    // Show only revenue data
                    monthlySalesChartInstance.data.datasets[0].hidden = true;
                    monthlySalesChartInstance.data.datasets[1].hidden = false;
                } else if (monthlySalesChartInstance && chartType === 'sales') {
                    // Show only sales data
                    monthlySalesChartInstance.data.datasets[0].hidden = false;
                    monthlySalesChartInstance.data.datasets[1].hidden = true;
                }
                
                if (monthlySalesChartInstance) {
                    monthlySalesChartInstance.update();
                }
            }
        });

        // Observe changes to analytics tab visibility for proper chart initialization
        const observer = new MutationObserver(function(mutations) {
            mutations.forEach(function(mutation) {
                if (mutation.type === 'attributes' && mutation.attributeName === 'class') {
                    const analyticsContent = document.getElementById('analytics');
                    if (analyticsContent && analyticsContent.classList.contains('active')) {
                        // Analytics tab became active, reinitialize charts
                        setTimeout(function() {
                            console.log('Analytics tab detected as active, reinitializing charts...');
                            initializeAnalyticsCharts();
                        }, 200);
                    }
                }
            });
        });

        // Start observing the analytics content div
        setTimeout(function() {
            const analyticsContent = document.getElementById('analytics');
            if (analyticsContent) {
                observer.observe(analyticsContent, {
                    attributes: true,
                    attributeFilter: ['class']
                });
            }
        }, 1000);

        // Window resize handler for responsive chart sizing
        let resizeTimer;
        window.addEventListener('resize', function() {
            clearTimeout(resizeTimer);
            resizeTimer = setTimeout(function() {
                [monthlySalesChartInstance, invoiceStatusChartInstance, paymentTrendsChartInstance, revenueComparisonChartInstance].forEach(chart => {
                    if (chart) {
                        chart.resize();
                        chart.update('none'); // Update without animation for better performance
                    }
                });
            }, 300); // Debounce resize events
        });
    </script>
    @endpush
</div>