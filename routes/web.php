<?php

use Illuminate\Http\Request;
use App\Livewire\CustomLogin;
use App\Livewire\Admin\Products;
use App\Livewire\Staff\Billing;
use App\Livewire\Admin\MadeByList;
use App\Livewire\Admin\ProductTypes;
use App\Livewire\Admin\BillingPage;
use App\Livewire\Admin\ManageAdmin;
use App\Livewire\Admin\ManageStaff;
use App\Livewire\Staff\DuePayments;
use App\Livewire\Admin\SupplierList;
use App\Livewire\Admin\ViewPayments;
use Illuminate\Support\Facades\Auth;
use App\Livewire\Admin\AddProductColor;
use Illuminate\Support\Facades\Route;
use App\Livewire\Admin\AdminDashboard;
use App\Livewire\Admin\ManageCustomer;
use App\Livewire\Admin\ProductBrandlist;
use App\Livewire\Staff\StaffDashboard;
use App\Livewire\Admin\StaffDueDetails;
use App\Livewire\Admin\PaymentApprovals;
use App\Livewire\Admin\StaffSaleDetails;
use App\Livewire\Admin\StaffStockDetails;
use App\Livewire\Admin\ProductCategorylist;
use App\Livewire\Admin\ProductStockDetails;
use App\Livewire\Admin\ProductDialColorlist;
use App\Livewire\Admin\ProductGlassTypeList;
use App\Livewire\Admin\ProductStrapMaterial;
use App\Livewire\Staff\StaffStockOverview;
use App\Http\Controllers\ReceiptController;
use App\Livewire\Admin\CustomerSaleDetails;
use App\Livewire\Admin\ProductStrapColorlist;
use App\Livewire\Staff\CustomerSaleManagement;
use App\Livewire\Admin\StoreBilling;
use App\Livewire\Admin\DuePayments as AdminDuePayments;
use App\Livewire\Admin\StaffStockDetails as StaffStockDetailsExport;
use App\Livewire\Staff\StoreBilling as StaffStoreBilling;
use App\Http\Controllers\ProductsExportController;
use App\Http\Controllers\StaffSaleExportController;
use App\Livewire\Admin\StaffAttendance;
use App\Livewire\Admin\StaffSallary;
use App\Livewire\Admin\LoanManage;



/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

// Public routes
Route::get('/', CustomLogin::class)->name('welcome')->middleware('guest');

// Custom logout route
Route::post('/logout', function (Request $request) {
    Auth::logout();
    $request->session()->invalidate();
    $request->session()->regenerateToken();
    return redirect('/');
})->name('logout');

// Routes that require authentication
Route::middleware(['auth:sanctum', config('jetstream.auth_session'), 'verified'])->group(function () {

    // !! Admin routes
    Route::middleware('role:admin')->prefix('admin')->name('admin.')->group(function () {
        Route::get('/dashboard', AdminDashboard::class)->name('dashboard');
        Route::get('/Product-list', Products::class)->name('Productes');
        Route::get('/Product-color', AddProductColor::class)->name('Product-color');
        Route::get('/add-Product-brand', ProductBrandlist::class)->name('Product-brand');
        Route::get('/Product-category', ProductCategorylist::class)->name('Product-category');
        Route::get('/Product-dial-colorlist', ProductDialColorlist::class)->name('Product-dial-color');
        Route::get('/Product-glass-type', ProductGlassTypeList::class)->name('Product-glass-type');
        Route::get('/Product-strap-material', ProductStrapMaterial::class)->name('Product-strap-material');
        Route::get('/Product-types', ProductTypes::class)->name('Product-types');
        Route::get('/made-by-list', MadeByList::class)->name('made-by-list');
        Route::get('/supplier-list', SupplierList::class)->name('supplier-list');
        Route::get('/Product-strap-colorlist', ProductStrapColorlist::class)->name('Product-strap-color');
        Route::get('/billing-page', BillingPage::class)->name('billing-page');
        Route::get('/manage-admin', ManageAdmin::class)->name('manage-admin');
        Route::get('/manage-staff', ManageStaff::class)->name('manage-staff');
        Route::get('/manage-customer', ManageCustomer::class)->name('manage-customer');
        Route::get('/Product-stock-details', ProductStockDetails::class)->name('Product-stock-details');
        Route::get('/staff-stock-details', StaffStockDetails::class)->name('staff-stock-details');
        Route::get('/staff-sale-details', StaffSaleDetails::class)->name('staff-sale-details');
        Route::get('/staff-due-details', StaffDueDetails::class)->name('staff-due-details');
        Route::get('/customer-sale-details', CustomerSaleDetails::class)->name('customer-sale-details');
        Route::get('/payment-approvals', PaymentApprovals::class)->name('payment-approvals');
        Route::get('/view-payments', ViewPayments::class)->name('view-payments');
        Route::get('/admin/staff/{staffId}/reentry', \App\Livewire\Admin\StockReentry::class)->name('staff.reentry');
        // Route::get('/store-billing', [StoreBilling::class, 'index'])->name('store-billing');
        Route::get('/store-billing', StoreBilling::class)->name('store-billing');
        Route::get('/due-payments', AdminDuePayments::class)->name('due-payments');
        Route::get('/staff-attendance', StaffAttendance::class)->name('staff-attendance');
        Route::get('/staff-salary', StaffSallary::class)->name('staff-salary');
        Route::get('/loan-management', LoanManage::class)->name('loan-management');

        // Uncomment the above line if App\Livewire\Admin\DuePayments exists and is implemented.



    });

   
    //!! Staff routes
    Route::middleware('role:staff')->prefix('staff')->name('staff.')->group(function () {
        Route::get('/dashboard', StaffDashboard::class)->name('dashboard');
        Route::get('/billing', Billing::class)->name('billing');
        Route::get('/customer-sale-management', CustomerSaleManagement::class)->name('customer-sale-management');
        Route::get('/staff-stock-overview', StaffStockOverview::class)->name('staff-stock-overview');
        Route::get('/due-payments', DuePayments::class)->name('due-payments');

    });


    // !! Export routes (accessible to authenticated users)

    Route::get('/Productes/export', [ProductsExportController::class, 'export'])->name('Productes.export')->middleware(['auth']);
    Route::get('/staff-sales/export', [StaffSaleExportController::class, 'export'])
    ->name('staff-sales.export')->middleware(['auth']);
    // Receipt download (accessible to authenticated users)
    Route::get('/receipts/{id}/download', [App\Http\Controllers\ReceiptController::class, 'download'])
        ->name('receipts.download')
        ->middleware(['auth']);

    // Export staff stock details
    Route::get('/export/staff-stock', function() {
        return app(StaffStockDetails::class)->exportToCSV();
    })->name('export.staff-stock');

});
