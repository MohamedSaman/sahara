<?php

namespace App\Livewire\Admin;
use Exception;
use Livewire\Component;
use Livewire\Attributes\Layout;
use Livewire\Attributes\Title;
use App\Models\ProductStock;
use App\Models\ProductDetails;

#[Layout('components.layouts.admin')]
#[Title('Product Stock Details')]
class ProductStockDetails extends Component
{
    public function render()
    {
        $ProductStocks = ProductStock::join('product_details', 'product_stocks.product_id', '=', 'product_details.id')
            ->select('product_stocks.*', 'product_details.name as Product_name', 'product_details.brand as Product_brand','product_details.model as Product_model', 'product_details.code as Product_code', 'product_details.image as Product_image')
            ->get();
        return view('livewire.admin.Product-stock-details',[
            'ProductStocks'=> $ProductStocks
        ]);
    }

    public function exportToCSV()
    {
        // Get data
        $ProductStocks = ProductStock::join('product_details', 'product_stocks.product_id', '=', 'product_details.id')
            ->select('product_details.name', 'product_details.code', 'product_details.brand', 'product_details.model', 
                    'product_stocks.total_stock', 'product_stocks.available_stock', 
                    'product_stocks.sold_count', 'product_stocks.damage_stock')
            ->get();

        if ($ProductStocks->isEmpty()) {
            $this->dispatch('banner-message', [
                'style' => 'danger',
                'message' => 'No data available to export'
            ]);
            return;
        }
        
        // Generate filename with date
        $fileName = 'Product_stock_' . date('Y-m-d_His') . '.csv';
        
        // Create CSV content with headers
        $headers = [
            'Name',
            'Code',
            'Brand',
            'Model',
            'Total Stock',
            'Available Stock',
            'Sold Count',
            'Damage Stock'
        ];
        
        $callback = function() use($ProductStocks, $headers) {
            $file = fopen('php://output', 'w');
            fputcsv($file, $headers);
            
            foreach ($ProductStocks as $stock) {
                $row = [
                    $stock->name ?? '-',
                    $stock->code ?? '-',
                    $stock->brand ?? '-',
                    $stock->model ?? '-',
                    $stock->total_stock ?? '0',
                    $stock->available_stock ?? '0',
                    $stock->sold_count ?? '0',
                    $stock->damage_stock ?? '0'
                ];
                fputcsv($file, $row);
            }
            
            fclose($file);
        };
        
        // Create response with headers for browser download
        return response()->stream($callback, 200, [
            'Content-Type' => 'text/csv',
            'Content-Disposition' => "attachment; filename=\"$fileName\"",
        ]);
    }
}
