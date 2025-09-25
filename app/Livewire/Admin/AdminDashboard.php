<?php

namespace App\Livewire\Admin;

use Livewire\Component;
use Livewire\Attributes\Layout;
use Livewire\Attributes\Title;
use App\Models\Sale;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Facades\Excel; // Add this at the top

#[Layout('components.layouts.admin')]
#[Title('Dashboard')]
class AdminDashboard extends Component
{
    public $totalRevenue = 0;
    public $totalDueAmount = 0;
    public $totalSales = 0;
    public $revenuePercentage = 0;
    public $duePercentage = 0;
    public $previousMonthRevenue = 0;
    public $revenueChangePercentage = 0;
    public $fullPaidCount = 0;
    public $fullPaidAmount = 0;

    public $partialPaidCount = 0;
    public $partialPaidAmount = 0;

    public $totalStock = 0;
    public $assignedStock = 0;
    public $soldStock = 0;
    public $availableStock = 0;
    public $assignmentPercentage = 0;
    public $soldPercentage = 0;
    public $damagedStock = 0;
    public $damagedValue = 0;
    public $totalInventoryValue = 0;
    public $totalAvailableInventory = 0;
    public $totalStaffCount = 0;
    public $staffWithAssignmentsCount = 0;
    public $staffAssignmentPercentage = 0;
    public $totalStaffSalesValue = 0;

    public $recentSales = [];
    public $ProductInventory = [];
    public $brandSales = [];
    public $staffSales = [];

    // Analytics data
    public $monthlySalesData = [];
    public $monthlyRevenueData = [];
    public $invoiceStatusData = [];
    public $paymentTrendsData = [];
    public $topPerformingMonths = [];

    public $selectedReport = '';
    public $salesReport = [];
    public $salesReportTotal = 0;
    public $salaryReport = [];
    public $salaryReportTotal = 0;
    public $inventoryReport = [];
    public $inventoryReportTotal = 0;
    public $staffReport = [];
    public $staffReportTotal = 0;
    public $paymentsReport = [];
    public $paymentsReportTotal = 0;
    public $attendanceReport = [];
    public $attendanceReportTotal = 0;

    public $activeTab = 'overview';
    public $reportStartDate;
    public $reportEndDate;

    public function mount()
    {
        // Restore active tab from session if available
        $this->activeTab = session('activeTab', 'overview');
        
        // Get sales statistics
        $salesStats = Sale::select(
            DB::raw('SUM(total_amount) as total_sales'),
            DB::raw('SUM(due_amount) as total_due'),
            DB::raw('COUNT(*) as sales_count')
        )->first();

        // Calculate total revenue (total_amount - due_amount)
        $this->totalSales = $salesStats->total_sales ?? 0;
        $this->totalDueAmount = $salesStats->total_due ?? 0;
        $this->totalRevenue = $this->totalSales - $this->totalDueAmount;

        // Calculate percentages
        if ($this->totalSales > 0) {
            $this->revenuePercentage = round(($this->totalRevenue / $this->totalSales) * 100, 1);
            $this->duePercentage = round(($this->totalDueAmount / $this->totalSales) * 100, 1);
        }

        // Get previous month's revenue for comparison
        $previousMonthSales = Sale::whereMonth(
            'created_at',
            '=',
            now()->subMonth()->month
        )->select(
                DB::raw('SUM(total_amount - due_amount) as revenue')
            )->first();

        $this->previousMonthRevenue = $previousMonthSales->revenue ?? 0;

        // Calculate month-over-month change percentage
        if ($this->previousMonthRevenue > 0) {
            $this->revenueChangePercentage = round((($this->totalRevenue - $this->previousMonthRevenue) / $this->previousMonthRevenue) * 100, 1);
        }

        // Get fully paid invoices data
        $fullPaidData = Sale::where('payment_status', 'paid')
            ->select(
                DB::raw('COUNT(*) as count'),
                DB::raw('SUM(total_amount) as amount')
            )->first();

        $this->fullPaidCount = $fullPaidData->count ?? 0;
        $this->fullPaidAmount = $fullPaidData->amount ?? 0;

        // Get partially paid invoices data
        $partialPaidData = Sale::where('payment_status', 'partial')
            ->select(
                DB::raw('COUNT(*) as count'),
                DB::raw('SUM(due_amount) as amount')
            )->first();

        $this->partialPaidCount = $partialPaidData->count ?? 0;
        $this->partialPaidAmount = $partialPaidData->amount ?? 0;

        // Get inventory statistics
        $stockStats = DB::table('product_stocks')
            ->select(
                DB::raw('SUM(total_stock) as total_stock'),
                DB::raw('SUM(assigned_stock) as assigned_stock'),
                DB::raw('SUM(sold_count) as sold_stock'),
                DB::raw('SUM(damage_stock) as damaged_stock'),
                DB::raw('SUM(available_stock) as available_stock')
            )->first();

        $this->totalStock = $stockStats->total_stock ?? 0;
        $this->assignedStock = $stockStats->assigned_stock ?? 0;
        $this->soldStock = $stockStats->sold_stock ?? 0;
        $this->damagedStock = $stockStats->damaged_stock ?? 0;
        $this->availableStock = $stockStats->available_stock ?? 0;

        // Calculate percentages
        if ($this->assignedStock > 0) {
            $this->soldPercentage = round(($this->soldStock / $this->assignedStock) * 100, 1);
        }

        if ($this->totalStock > 0) {
            $this->assignmentPercentage = round(($this->assignedStock / $this->totalStock) * 100, 1);
        }

        // Calculate damaged inventory value
        $damagedValue = DB::table('product_stocks')
            ->join('product_prices', 'product_stocks.product_id', '=', 'Product_prices.product_id')
            ->select(DB::raw('SUM(product_stocks.damage_stock * product_prices.supplier_price) as damaged_value'))
            ->first();

        $this->damagedValue = $damagedValue->damaged_value ?? 0;

        // Calculate total inventory value (all stocks)
        $totalInventoryValue = DB::table('product_stocks')
            ->join('product_prices', 'product_stocks.product_id', '=', 'Product_prices.product_id')
            ->select(DB::raw('SUM(product_stocks.available_stock * product_prices.supplier_price) as total_value'))
            ->first();

        $totalAvailableInventory = DB::table('product_stocks')
            ->join('product_prices', 'product_stocks.product_id', '=', 'Product_prices.product_id')
            ->select(DB::raw('SUM(product_stocks.available_stock * product_prices.supplier_price) as total_value'))
            ->first();

        $this->totalInventoryValue = $totalInventoryValue->total_value ?? 0;
        $this->totalAvailableInventory = $totalAvailableInventory->total_value ?? 0;

        $this->totalStaffCount = DB::table('users')->where('role', 'staff')->count();
        $this->staffWithAssignmentsCount = DB::table('staff_sales')
            ->select('staff_id')
            ->distinct()
            ->count('staff_id');

        // Calculate assignment percentage
        if ($this->totalStaffCount > 0) {
            $this->staffAssignmentPercentage = round(($this->staffWithAssignmentsCount / $this->totalStaffCount) * 100, 1);
        }
        $staffSalesTotal = DB::table('staff_sales')
            ->select(DB::raw('SUM(total_value) as total_value'))
            ->first();
            
        $this->totalStaffSalesValue = $staffSalesTotal->total_value ?? 0;

        // Fetch recent sales
        $this->loadRecentSales();

        // Fetch Product inventory data
        $this->loadProductInventory();

        // Fetch brand sales data
        $this->loadBrandSales();

        // Fetch staff sales data
        $this->loadStaffSales();

        // Load analytics data
        $this->loadAnalyticsData();
    }

    public function loadAnalyticsData()
    {
        // Get monthly sales data for the last 12 months
        $this->monthlySalesData = DB::table('sales')
            ->select(
                DB::raw('YEAR(created_at) as year'),
                DB::raw('MONTH(created_at) as month'),
                DB::raw('COUNT(*) as total_invoices'),
                DB::raw('SUM(total_amount) as total_sales'),
                DB::raw('SUM(total_amount - due_amount) as revenue'),
                DB::raw('SUM(due_amount) as due_amount')
            )
            ->where('created_at', '>=', now()->subMonths(12))
            ->groupBy('year', 'month')
            ->orderBy('year', 'asc')
            ->orderBy('month', 'asc')
            ->get()
            ->map(function($item) {
                return [
                    'year' => $item->year,
                    'month' => $item->month,
                    'month_name' => date('M Y', mktime(0, 0, 0, $item->month, 1, $item->year)),
                    'total_invoices' => $item->total_invoices,
                    'total_sales' => $item->total_sales,
                    'revenue' => $item->revenue,
                    'due_amount' => $item->due_amount
                ];
            })
            ->toArray();

        // Get invoice status distribution
        $this->invoiceStatusData = DB::table('sales')
            ->select(
                'payment_status',
                DB::raw('COUNT(*) as count'),
                DB::raw('SUM(total_amount) as amount')
            )
            ->groupBy('payment_status')
            ->get()
            ->map(function($item) {
                return [
                    'payment_status' => $item->payment_status,
                    'count' => $item->count,
                    'amount' => $item->amount
                ];
            })
            ->toArray();

        // Get payment trends (last 6 months)
        $this->paymentTrendsData = DB::table('payments')
            ->select(
                DB::raw('YEAR(payment_date) as year'),
                DB::raw('MONTH(payment_date) as month'),
                DB::raw('COUNT(*) as payment_count'),
                DB::raw('SUM(amount) as total_payments')
            )
            ->where('payment_date', '>=', now()->subMonths(6))
            ->groupBy('year', 'month')
            ->orderBy('year', 'asc')
            ->orderBy('month', 'asc')
            ->get()
            ->map(function($item) {
                return [
                    'year' => $item->year,
                    'month' => $item->month,
                    'month_name' => date('M Y', mktime(0, 0, 0, $item->month, 1, $item->year)),
                    'payment_count' => $item->payment_count,
                    'total_payments' => $item->total_payments
                ];
            })
            ->toArray();

        // Get top performing months
        $this->topPerformingMonths = collect($this->monthlySalesData)
            ->sortByDesc('revenue')
            ->take(3)
            ->values()
            ->toArray();
    }

    public function loadRecentSales()
    {
        // Join customers table to get customer details
        $this->recentSales = DB::table('sales')
            ->join('customers', 'sales.customer_id', '=', 'customers.id')
            ->select(
                'sales.id',
                'sales.invoice_number',
                'sales.total_amount',
                'sales.payment_status',
                'sales.created_at',
                'customers.name',
                'customers.email',
                'sales.due_amount',
            )
            ->orderBy('sales.created_at', 'desc')
            ->limit(5)
            ->get();
    }

    public function loadProductInventory()
    {
        // Join Productes and stock tables to get full inventory data
        $this->ProductInventory = DB::table('product_details')
            ->join('product_stocks', 'product_details.id', '=', 'product_stocks.product_id')
            ->select(
                'product_details.id',
                'product_details.code',
                'product_details.name',
                'product_details.model',
                'product_details.brand',
                'product_stocks.available_stock',
                'product_stocks.total_stock',
                'product_stocks.damage_stock'
            )
            ->orderBy('product_stocks.available_stock', 'asc')
            ->limit(5)
            ->get();
    }

    public function loadBrandSales()
    {
        // Get total sales per brand
        $this->brandSales = DB::table('sale_items')
            ->join('product_details', 'sale_items.product_id', '=', 'product_details.id')
            ->select('product_details.brand', DB::raw('SUM(sale_items.total) as total_sales'))
            ->groupBy('product_details.brand')
            ->orderBy('total_sales', 'desc')
            ->get()
            ->toArray();
    }

    public function loadStaffSales()
    {
        $this->staffSales = DB::table('users')
            ->where('role', 'staff')
            ->leftJoin('staff_sales', 'users.id', '=', 'staff_sales.staff_id')
            ->select(
                'users.id',
                'users.name',
                'users.email',
                DB::raw('COALESCE(SUM(staff_sales.total_value), 0) as assigned_value'),
                DB::raw('COALESCE(SUM(staff_sales.sold_value), 0) as sold_value'),
                DB::raw('COALESCE(SUM(staff_sales.total_quantity), 0) as assigned_quantity'),
                DB::raw('COALESCE(SUM(staff_sales.sold_quantity), 0) as sold_quantity')
            )
            ->groupBy('users.id', 'users.name', 'users.email')
            ->get()
            ->map(function($staff) {
                // Calculate due amount from sales table
                $salesInfo = DB::table('sales')
                    ->where('user_id', $staff->id)
                    ->select(
                        DB::raw('COALESCE(SUM(total_amount), 0) as total_sales'),
                        DB::raw('COALESCE(SUM(due_amount), 0) as total_due')
                    )
                    ->first();
                
                $staff->total_sales = $salesInfo->total_sales ?? 0;
                $staff->total_due = $salesInfo->total_due ?? 0;
                $staff->collected_amount = $staff->total_sales - $staff->total_due;
                
                // Calculate percentages for progress bars
                $staff->sales_percentage = $staff->assigned_value > 0 ? 
                    round(($staff->sold_value / $staff->assigned_value) * 100, 1) : 0;
                
                $staff->payment_percentage = $staff->total_sales > 0 ? 
                    round(($staff->collected_amount / $staff->total_sales) * 100, 1) : 0;
                    
                return $staff;
            });
    }

    public function selectedTab($tab)
    {
        $this->activeTab = $tab;
        session(['activeTab' => $tab]);
    }

    public function generateReport()
    {
        $currentTab = $this->activeTab;

        // Validate date range (optional)
        if ($this->reportStartDate && $this->reportEndDate && $this->reportStartDate > $this->reportEndDate) {
            $this->addError('reportEndDate', 'End date must be after start date.');
            return;
        }

        if ($this->selectedReport === 'sales') {
            $this->salesReport = $this->getSalesReport($this->reportStartDate, $this->reportEndDate);
            $this->salesReportTotal = collect($this->salesReport)->sum('total_amount');
        } elseif ($this->selectedReport === 'salary') {
            $this->salaryReport = $this->getSalaryReport($this->reportStartDate, $this->reportEndDate);
            $this->salaryReportTotal = collect($this->salaryReport)->sum('net_salary');
        } elseif ($this->selectedReport === 'inventory') {
            $this->inventoryReport = $this->getInventoryReport($this->reportStartDate, $this->reportEndDate);
            $this->inventoryReportTotal = collect($this->inventoryReport)->sum('available_stock');
        } elseif ($this->selectedReport === 'staff') {
            $this->staffReport = $this->getStaffReport($this->reportStartDate, $this->reportEndDate);
            $this->staffReportTotal = collect($this->staffReport)->sum('total_sales');
        } elseif ($this->selectedReport === 'payments') {
            $this->paymentsReport = $this->getPaymentsReport($this->reportStartDate, $this->reportEndDate);
            $this->paymentsReportTotal = collect($this->paymentsReport)->sum('amount');
        } elseif ($this->selectedReport === 'attendance') {
            $this->attendanceReport = $this->getAttendanceReport($this->reportStartDate, $this->reportEndDate);
            $this->attendanceReportTotal = collect($this->attendanceReport)->count();
        }

        $this->activeTab = $currentTab;
        session(['activeTab' => $currentTab]);
    }

    public function downloadReport()
    {
        $filename = 'report.xlsx';
        $data = [];

        switch ($this->selectedReport) {
            case 'sales':
                $data = $this->salesReport;
                $export = new \App\Exports\SalesReportExport($data, $this->salesReportTotal);
                break;
            case 'salary':
                $data = $this->salaryReport;
                $export = new \App\Exports\SalaryReportExport($data, $this->salaryReportTotal);
                break;
            case 'inventory':
                $data = $this->inventoryReport;
                $export = new \App\Exports\InventoryReportExport($data, $this->inventoryReportTotal);
                break;
            case 'staff':
                $data = $this->staffReport;
                $export = new \App\Exports\StaffReportExport($data, $this->staffReportTotal);
                break;
            case 'payments':
                $data = $this->paymentsReport;
                $export = new \App\Exports\PaymentsReportExport($data, $this->paymentsReportTotal);
                break;
            case 'attendance':
                $data = $this->attendanceReport;
                $export = new \App\Exports\AttendanceReportExport($data, $this->attendanceReportTotal);
                break;
            default:
                return;
        }

        return Excel::download($export, $filename);
    }

    // Example report functions
    public function getSalesReport($start = null, $end = null)
    {
        $query = \App\Models\Sale::with('items', 'customer', 'payments')->orderBy('created_at', 'desc');
        if ($start) $query->whereDate('created_at', '>=', $start);
        if ($end) $query->whereDate('created_at', '<=', $end);
        return $query->limit(50)->get();
    }

    public function getSalaryReport($start = null, $end = null)
    {
        $query = DB::table('salaries')
            ->join('users', 'salaries.user_id', '=', 'users.id')
            ->select('users.name', 'salaries.net_salary', 'salaries.salary_month', 'salaries.payment_status')
            ->orderBy('salaries.salary_month', 'desc');
        if ($start) $query->whereDate('salaries.salary_month', '>=', $start);
        if ($end) $query->whereDate('salaries.salary_month', '<=', $end);
        return $query->limit(50)->get();
    }

    public function getInventoryReport($start = null, $end = null)
    {
        $query = DB::table('product_details')
            ->join('product_stocks', 'product_details.id', '=', 'product_stocks.product_id')
            ->select('product_details.name', 'product_details.model', 'product_details.brand', 'product_stocks.*')
            ->orderBy('product_stocks.available_stock', 'desc');
        // Inventory may not have a date, so skip date filter or add if you have a date column
        return $query->get();
    }

    public function getStaffReport($start = null, $end = null)
    {
        $query = DB::table('users')
            ->where('role', 'staff')
            ->leftJoin('staff_sales', 'users.id', '=', 'staff_sales.staff_id')
            ->select('users.name', 'users.email', DB::raw('SUM(staff_sales.sold_value) as total_sales'))
            ->groupBy('users.id', 'users.name', 'users.email');
        // Staff sales may have a date column, add filter if available
        return $query->get();
    }

    public function getPaymentsReport($start = null, $end = null)
    {
        $query = \App\Models\Payment::with('sale')->orderBy('payment_date', 'desc');
        if ($start) $query->whereDate('payment_date', '>=', $start);
        if ($end) $query->whereDate('payment_date', '<=', $end);
        return $query->limit(50)->get();
    }

    public function getAttendanceReport($start = null, $end = null)
    {
        $query = DB::table('attendances')
            ->join('users', 'attendances.user_id', '=', 'users.id')
            ->select('users.name', 'attendances.date', 'attendances.check_in', 'attendances.check_out', 'attendances.status')
            ->orderBy('attendances.date', 'desc');
        if ($start) $query->whereDate('attendances.date', '>=', $start);
        if ($end) $query->whereDate('attendances.date', '<=', $end);
        return $query->limit(50)->get();
    }

    public function render()
    {
        return view('livewire.admin.admin-dashboard', [
            'salesReportTotal' => $this->salesReportTotal,
            'salaryReportTotal' => $this->salaryReportTotal,
            'inventoryReportTotal' => $this->inventoryReportTotal,
            'staffReportTotal' => $this->staffReportTotal,
            'paymentsReportTotal' => $this->paymentsReportTotal,
            'attendanceReportTotal' => $this->attendanceReportTotal,
            'monthlySalesData' => $this->monthlySalesData,
            'monthlyRevenueData' => $this->monthlyRevenueData,
            'invoiceStatusData' => $this->invoiceStatusData,
            'paymentTrendsData' => $this->paymentTrendsData,
            'topPerformingMonths' => $this->topPerformingMonths,
        ]);
    }
}