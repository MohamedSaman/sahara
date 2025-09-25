# Final comprehensive script to fix all table name case inconsistencies
Write-Host "Running final comprehensive table name fixes..." -ForegroundColor Green

# Define all files that might have table name issues
$filesToProcess = Get-ChildItem -Path "app" -Filter "*.php" -Recurse | Where-Object { 
    $_.FullName -notlike "*vendor*" -and $_.FullName -notlike "*storage*" 
}

foreach ($file in $filesToProcess) {
    $relativePath = $file.FullName -replace [regex]::Escape((Get-Location).Path + "\"), ""
    Write-Host "Checking: $relativePath" -ForegroundColor Yellow
    
    $content = Get-Content $file.FullName -Raw -ErrorAction SilentlyContinue
    if (-not $content) { continue }
    
    $originalContent = $content
    
    # Fix all remaining table name case issues
    $content = $content -replace "Product_details", "product_details"
    $content = $content -replace "Product_prices", "product_prices"  
    $content = $content -replace "Product_stocks", "product_stocks"
    $content = $content -replace "Product_suppliers", "product_suppliers"
    $content = $content -replace "Product_made_bies", "product_made_bies"
    
    # Also fix any join references that might still be capitalized
    $content = $content -replace "join\('Product_", "join('product_"
    $content = $content -replace "table\('Product_", "table('product_"
    $content = $content -replace "from\('Product_", "from('product_"
    
    if ($content -ne $originalContent) {
        Set-Content -Path $file.FullName -Value $content -NoNewline
        Write-Host "  Updated $relativePath" -ForegroundColor Green
    }
}

Write-Host "Final table name fixes completed!" -ForegroundColor Green