# PowerShell script to replace Product_id with product_id across the codebase
# Run this in the root directory of your Laravel project

Write-Host "Starting Product_id to product_id replacement..." -ForegroundColor Green

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
        
        # Replace Product_id with product_id (but not in comments)
        $newContent = $content -replace "Product_id", "product_id"
        
        # Write back to file
        Set-Content -Path $file -Value $newContent -NoNewline
        
        Write-Host "  Updated $file" -ForegroundColor Green
    } else {
        Write-Host "  File not found: $file" -ForegroundColor Red
    }
}

# Also fix any remaining Product_prices references
foreach ($file in $filesToProcess) {
    if (Test-Path $file) {
        $content = Get-Content $file -Raw
        $newContent = $content -replace "Product_prices\.Product_id", "Product_prices.product_id"
        $newContent = $newContent -replace "product_stocks\.Product_id", "product_stocks.product_id" 
        Set-Content -Path $file -Value $newContent -NoNewline
    }
}

Write-Host "Replacement completed!" -ForegroundColor Green
Write-Host "Please review the changes and test your application." -ForegroundColor Cyan