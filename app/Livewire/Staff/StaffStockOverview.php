<?php

namespace App\Livewire\Staff;
use Livewire\Component;
use App\Models\StaffSale;
use App\Models\StaffProduct;
use Livewire\Attributes\Title;
use Livewire\Attributes\Layout;
use Illuminate\Support\Facades\DB;

#[Title('My Stock Overview')]
#[Layout('components.layouts.staff')]
class StaffStockOverview extends Component
{
    public $selectedSaleId = null;
    public $showSaleDetails = false;
    public $searchQuery = '';
    public $activeView = 'watches'; // Default view: 'watches' or 'batches'

    public $totalInventory = 0;
    public $soldInventory = 0;
    public $availableStockValue = 0;
    public $totalSoldValue = 0;

    public function mount()
    {
        // Get the first sale by default if any exists
        $firstSale = StaffSale::where('staff_id', auth()->id())->first();
        if ($firstSale) {
            $this->selectedSaleId = $firstSale->id;
            $this->showSaleDetails = true;
        }
    }

    public function viewSaleDetails($saleId)
    {
        $this->selectedSaleId = $saleId;
        $this->showSaleDetails = true;
        $this->activeView = 'batches';
    }
    
    public function switchView($view)
    {
        $this->activeView = $view;
        if ($view === 'watches') {
            $this->showSaleDetails = false;
        }
    }

    public function render()
    {
        // Get all sales assigned to the authenticated staff
        $staffSales = StaffSale::where('staff_id', auth()->id())
            ->with('admin')
            ->orderBy('created_at', 'desc')
            ->get();


        // Calculate total quantity for the authenticated staff
        $staffstockTotalQuantity = StaffProduct::where('staff_id', auth()->id())
            ->sum('quantity');

        $staffstockTotalSoldQuantity = StaffProduct::where('staff_id', auth()->id())
            ->sum('sold_quantity');

        $staffstockTotalSoldValue = StaffProduct::where('staff_id', auth()->id())
            ->sum('sold_value');

        $staffstockTotalValue = StaffProduct::where('staff_id', auth()->id())
            ->sum('total_value');
            // dd($staffstockTotalQuantity, $staffstockTotalSoldQuantity);

       
        // Modified to explicitly include all statuses including completed
        $staffProducts = StaffProduct::where('staff_id', auth()->id())
            ->with(['watch', 'staffSale.admin'])
            ->get();

        // Group products by watch_id and aggregate quantities
        $watchGroups = $staffProducts->groupBy('watch_id');
        $watches = collect();
        
        
        // Process watch groups
        foreach ($watchGroups as $watchId => $products) {
            $watch = $products->first()->watch;
            if (!$watch) continue;
            
            $watchTotalQuantity = $products->sum('quantity');
            $watchSoldQuantity = $products->sum('sold_quantity');
            $watchTotalValue = $products->sum('total_value');
            $watchSoldValue = $products->sum('sold_value');
            
            // Filter by search query if any
            if (!empty($this->searchQuery)) {
                $query = strtolower($this->searchQuery);
                if (!str_contains(strtolower($watch->name ?? ''), $query) && 
                    !str_contains(strtolower($watch->code ?? ''), $query) && 
                    !str_contains(strtolower($watch->brand ?? ''), $query)) {
                    continue;
                }
            }
            
            $watches->push([
                'watch' => $watch,
                'total_quantity' => $watchTotalQuantity,
                'sold_quantity' => $watchSoldQuantity,
                'remaining_quantity' => $watchTotalQuantity - $watchSoldQuantity,
                'total_value' => $watchTotalValue,
                'sold_value' => $watchSoldValue,
                'progress_percentage' => $watchTotalQuantity > 0 ? 
                    round(($watchSoldQuantity / $watchTotalQuantity) * 100, 1) : 0,
                'status' => $watchSoldQuantity == 0 ? 'pending' : 
                    ($watchSoldQuantity < $watchTotalQuantity ? 'partial' : 'completed')
            ]);
        }
        
        // Get selected sale details with products
        $selectedSale = null;
        $batchProducts = collect();
        
        if ($this->selectedSaleId) {
            $selectedSale = StaffSale::with(['admin', 'products.watch'])
                ->find($this->selectedSaleId);
                
            if ($selectedSale) {
                $batchProducts = $selectedSale->products;
                
                // Apply search filter if needed
                if (!empty($this->searchQuery)) {
                    $query = strtolower($this->searchQuery);
                    $batchProducts = $batchProducts->filter(function($product) use ($query) {
                        return str_contains(strtolower($product->watch->name ?? ''), $query) || 
                               str_contains(strtolower($product->watch->code ?? ''), $query) || 
                               str_contains(strtolower($product->watch->brand ?? ''), $query);
                    });
                }
            }
        }

        $inventoryStats = StaffProduct::where('staff_id', auth()->id())
            ->select(
                DB::raw('SUM(quantity) as total_quantity'),
                DB::raw('SUM(sold_quantity) as sold_quantity'),
                DB::raw('SUM(sold_value) as sold_value')

            )->first();
        
        $this->totalInventory = $inventoryStats->total_quantity ?? 0;
        $this->soldInventory = $inventoryStats->sold_quantity ?? 0;
        $this->totalSoldValue = $inventoryStats->sold_value ?? 0;

        
        return view('livewire.staff.staff-stock-overview', [
            'staffSales' => $staffSales,
            'watches' => $watches,
            'selectedSale' => $selectedSale,
            'products' => $batchProducts,
            'totalAssigned' => $staffstockTotalQuantity,
            'totalSold' => $staffstockTotalSoldQuantity,
            'totalValue' => $staffstockTotalValue,
            'soldValue' => $staffstockTotalSoldValue,
            'remainingValue' => $staffstockTotalValue - $staffstockTotalSoldValue,
        ]);
    }
}
