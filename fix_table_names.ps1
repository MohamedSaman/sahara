# PowerShell script to fix all table naming inconsistencies
# Run this in the root directory of your Laravel project

Write-Host "Fixing all table name case inconsistencies..." -ForegroundColor Green

# Define files to process
$filesToProcess = @(
    "app\Livewire\Admin\AdminDashboard.php",
    "app\Livewire\Admin\BillingPage.php", 
    "app\Livewire\Admin\Products.php",
    "app\Livewire\Admin\StoreBilling.php",
    "app\Livewire\Admin\ProductStockDetails.php",
    "app\Livewire\Staff\Billing.php",
    "app\Livewire\Staff\StaffStockOverview.php"
)

foreach ($file in $filesToProcess) {
    if (Test-Path $file) {
        Write-Host "Processing: $file" -ForegroundColor Yellow
        
        # Read the file content
        $content = Get-Content $file -Raw
        
        # Fix all table name references to lowercase
        $newContent = $content -replace "'Product_prices'", "'product_prices'"
        $newContent = $newContent -replace "'Product_details'", "'product_details'"
        $newContent = $newContent -replace "'Product_suppliers'", "'product_suppliers'"
        $newContent = $newContent -replace "'Product_stocks'", "'product_stocks'"
        
        # Fix column references (keep the dot notation consistent)
        $newContent = $newContent -replace "Product_prices\.", "product_prices."
        $newContent = $newContent -replace "Product_details\.", "product_details."  
        $newContent = $newContent -replace "Product_suppliers\.", "product_suppliers."
        $newContent = $newContent -replace "Product_stocks\.", "product_stocks."
        
        # Write back to file
        Set-Content -Path $file -Value $newContent -NoNewline
        
        Write-Host "  Updated $file" -ForegroundColor Green
    } else {
        Write-Host "  File not found: $file" -ForegroundColor Red
    }
}

Write-Host "Table name fixes completed!" -ForegroundColor Green