<?php

namespace App\Livewire\Admin;
use Exception;
use Livewire\Attributes\On;
use Livewire\Component;
use App\Models\BrandList;
use App\Models\ProductPrice;
use App\Models\ProductStock;
use App\Models\ProductColors;
use App\Models\ProductDetail;
use App\Models\ProductMadeBy;
use App\Models\CategoryList;
use App\Models\DialColorList;
use App\Models\GlassTypeList;
use App\Models\ProductSupplier;
use App\Models\ProductTypeList;
use App\Models\StrapColorList;
use Livewire\Attributes\Title;
use Livewire\Attributes\Layout;
use App\Models\StrapMaterialList;
use Illuminate\Support\Facades\DB;
use Livewire\WithFileUploads;
use Livewire\WithPagination;

#[Title("Productes")]
#[Layout('components.layouts.admin')]
class Products extends Component
{
    use WithFileUploads, WithPagination;

    public $code;
    public $name;
    public $brand;
    public $model;
    public $color;
    public $madeBy;
    public $category;
    public $gender;
    public $type;
    public $movement;
    public $dialColor;
    public $strapColor;
    public $strapMaterial;
    public $caseDiameter;
    public $caseThickness;
    public $glassType;
    public $waterResistance;
    public $features;
    public $image;
    public $warranty;
    public $description;
    public $barcode;
    public $supplier;
    public $supplierPrice = 0;
    public $sellingPrice;
    public $discountPrice;
    public $shopStock = 0;
    public $storeStock = 0;
    public $damageStock = 0;
    public $status;
    public $location;
    public $search = '';

    public $imagePreview = null;
    public $editImagePreview = null;

    private function getDefaultSupplier()
    {
        // Cache the supplier ID to avoid repeated database queries
        static $supplierId = null;
        
        if ($supplierId === null) {
            $defaultSupplier = ProductSupplier::latest('id')->first();
            
            if (!$defaultSupplier) {
                $defaultSupplier = ProductSupplier::create([
                    'name' => 'Default Supplier',
                    'email' => null,
                    'contact' => null,
                    'address' => null,
                ]);
            }
            
            $supplierId = $defaultSupplier->id;
        }
        
        return $supplierId;
    }
    public function render()
    {
        $Productes = ProductDetail::join('Product_suppliers', 'Product_details.supplier_id', '=', 'Product_suppliers.id')
            ->join('Product_prices', 'Product_details.id', '=', 'Product_prices.Product_id')
            ->join('Product_stocks', 'Product_details.id', '=', 'Product_stocks.Product_id')
            ->select(
                'Product_details.id',
                'Product_details.code',
                'Product_details.name as Product_name',
                'Product_details.model',
                'Product_details.color',
                'Product_details.made_by',
                'Product_details.gender',
                'Product_details.type',
                'Product_details.movement',
                'Product_details.dial_color',
                'Product_details.strap_color',
                'Product_details.strap_material',
                'Product_details.case_diameter_mm',
                'Product_details.case_thickness_mm',
                'Product_details.glass_type',
                'Product_details.water_resistance',
                'Product_details.features',
                'Product_details.image',
                'Product_details.warranty',
                'Product_details.description',
                'Product_details.barcode',
                'Product_details.status',
                'Product_details.location',
                'Product_details.brand',
                'Product_details.category',
                'Product_details.supplier_id',
                'Product_suppliers.id as supplier_id',
                'Product_suppliers.name as supplier_name',
                'Product_prices.supplier_price',
                'Product_prices.selling_price',
                'Product_prices.discount_price',
                'Product_stocks.shop_stock',
                'Product_stocks.store_stock',
                'Product_stocks.damage_stock',
                'Product_stocks.total_stock',
                'Product_stocks.available_stock'
            )
            ->where('Product_details.name', 'like', '%' . $this->search . '%')
            ->orWhere('Product_details.code', 'like', '%' . $this->search . '%')
            ->orWhere('Product_details.model', 'like', '%' . $this->search . '%')
            ->orWhere('Product_details.brand', 'like', '%' . $this->search . '%')
            ->orWhere('Product_details.status', 'like', '%' . $this->search . '%')
            ->orWhere('Product_details.barcode', 'like', '%' . $this->search . '%')
            ->orderBy('Product_details.created_at', 'desc')
            ->paginate(10);

        $ProductColors = ProductColors::orderBy('id', 'asc')->get();
        $ProductStrapColors = StrapColorList::orderBy('id', 'asc')->get();
        $ProductStrapMaterials = StrapMaterialList::orderBy('id', 'asc')->get();
        $ProductBarnds = BrandList::orderBy('id', 'asc')->get();
        $ProductCategories = CategoryList::orderBy('id', 'asc')->get();
        $ProductDialColors = DialColorList::orderBy('id', 'asc')->get();
        $ProductGlassTypes = GlassTypeList::orderBy('id', 'asc')->get();
        $ProductMadeins = ProductMadeBy::orderBy('id', 'asc')->get();
        $ProductType = ProductTypeList::orderBy('id', 'asc')->get();
        $ProductSuppliers = ProductSupplier::orderBy('id', 'asc')->get();
        return view('livewire.admin.Productes', [
            'Productes' => $Productes,
            'ProductColors' => $ProductColors,
            'ProductStrapColors' => $ProductStrapColors,
            'ProductStrapMaterials' => $ProductStrapMaterials,
            'ProductCategories' => $ProductCategories,
            'ProductBarnds' => $ProductBarnds,
            'ProductDialColors' => $ProductDialColors,
            'ProductGlassTypes' => $ProductGlassTypes,
            'ProductMadeins' => $ProductMadeins,
            'ProductType' => $ProductType,
            'ProductSuppliers' => $ProductSuppliers,
        ]);
    }

    public $ProductDetails;
    public function viewProduct($id)
    {
        // Find the Product with its related data
        $this->ProductDetails = ProductDetail::join('Product_suppliers', 'Product_details.supplier_id', '=', 'Product_suppliers.id')
            ->join('Product_prices', 'Product_details.id', '=', 'Product_prices.Product_id')
            ->join('Product_stocks', 'Product_details.id', '=', 'Product_stocks.Product_id')
            ->select(
                'Product_details.id',
                'Product_details.code',
                'Product_details.name as Product_name',
                'Product_details.model',
                'Product_details.color',
                'Product_details.made_by',
                'Product_details.gender',
                'Product_details.type',
                'Product_details.movement',
                'Product_details.dial_color',
                'Product_details.strap_color',
                'Product_details.strap_material',
                'Product_details.case_diameter_mm',
                'Product_details.case_thickness_mm',
                'Product_details.glass_type',
                'Product_details.water_resistance',
                'Product_details.features',
                'Product_details.image',
                'Product_details.warranty',
                'Product_details.description',
                'Product_details.barcode',
                'Product_details.status',
                'Product_details.location',
                'Product_details.brand',
                'Product_details.category',
                'Product_details.supplier_id',
                'Product_suppliers.name as supplier_name',
                'Product_prices.supplier_price',
                'Product_prices.selling_price',
                'Product_prices.discount_price',
                'Product_stocks.shop_stock',
                'Product_stocks.store_stock',
                'Product_stocks.damage_stock',
                'Product_stocks.total_stock',
                'Product_stocks.available_stock'
            )
            ->where('Product_details.id', $id)
            ->first();
// dd($this->ProductDetails);        
        $this->js("$('#viewProductModal').modal('show')");
    }

    public function createProduct()
    {
        $this->resetForm();
        
        // Set default supplier
        $this->supplier = $this->getDefaultSupplier();
        $this->supplierPrice = 0;
        
        $this->js("
            setTimeout(() => {
                const modal = new bootstrap.Modal(document.getElementById('createProductModal'));
                modal.show();
            }, 500);
        ");
    }

    public function saveProduct()
    {
        $this->validateCretaeProduct();

        $this->code = $this->generateCode();
        $this->supplier = $this->getDefaultSupplier();

        DB::beginTransaction();

        try {
            $imagePath = null;
            if ($this->image) {
                $imageName = time() . '-' . $this->code . '.' . $this->image->getClientOriginalExtension();
                $this->image->storeAs('public/images/ProductImages', $imageName);
                $imagePath = 'images/ProductImages/' . $imageName;
            }

            $Product = ProductDetail::create([
                'code' => $this->code,
                'name' => $this->name,
                'model' => $this->model,
                'color' => $this->color,
                'made_by' => $this->madeBy,
                'gender' => $this->gender,
                'type' => $this->type,
                'movement' => $this->movement,
                'dial_color' => $this->dialColor,
                'strap_color' => $this->strapColor,
                'strap_material' => $this->strapMaterial,
                'case_diameter_mm' => $this->caseDiameter,
                'case_thickness_mm' => $this->caseThickness,
                'glass_type' => $this->glassType,
                'water_resistance' => $this->waterResistance,
                'features' => $this->features,
                'image' => $imagePath,
                'warranty' => $this->warranty,
                'description' => $this->description,
                'barcode' => $this->barcode,
                'status' => $this->status,
                'location' => $this->location,
                'brand' => $this->brand,
                'category' => $this->category,
                'supplier_id' => $this->supplier
            ]);

            ProductPrice::create([
                'supplier_price' => $this->supplierPrice ?? 0,
                'selling_price' => $this->sellingPrice,
                'discount_price' => $this->discountPrice,
                'Product_id' => $Product->id
            ]);

            $shopStock = (int) $this->shopStock;
            $storeStock = (int) $this->storeStock;
            $damageStock = (int) $this->damageStock;

            ProductStock::create([
                'shop_stock' => $shopStock,
                'store_stock' => $storeStock,
                'damage_stock' => $damageStock,
                'total_stock' => $shopStock + $storeStock + $damageStock,
                'available_stock' => $shopStock + $storeStock,
                'Product_id' => $Product->id
            ]);

            DB::commit();

            $this->js('$("#createProductModal").modal("hide")');
            $this->resetForm();
            $this->dispatch('Product-created');
            $this->js("Swal.fire('Success!', 'Product created successfully', 'success')");
            return redirect()->route('admin.Productes');

        } catch (Exception $e) {
            DB::rollBack();
            logger('Error creating Product: ' . $e->getMessage());
            $this->js("Swal.fire({
                icon: 'error',
                title: 'Product Creation Failed',
                text: '" . $e->getMessage() . "',
            })");
        }
        
    }

    public $editId;
    public $editCode;
    public $editName;
    public $editModel;
    public $editBrand;    
    public $editColor;
    public $editMadeBy;
    public $editCategory;
    public $editType;
    public $editGender;
    public $editMovement;
    public $editDialColor;
    public $editStrapColor;
    public $editStrapMaterial;
    public $editCaseDiameter;
    public $editCaseThickness;
    public $editGlassType;
    public $editWaterResistance;
    public $editFeatures;
    public $editWarranty;
    public $editDescription;
    public $editStatus;
    public $editLocation;
    public $editSupplier;
    public $editSupplierName; // Add this to store the supplier name for display
    public $editSupplierPrice = 0;
    public $editSellingPrice;
    public $editDiscountPrice;
    public $editShopStock;
    public $editStoreStock;
    public $editDamageStock;
    public $editBarcode;
    public $editImage;
    public $existingImage;
    public $isLoading = false;
    public function editProduct($id)
    {
        $this->resetEditImage();
        // Find the Product with its related data
        $Product = ProductDetail::join('Product_suppliers', 'Product_details.supplier_id', '=', 'Product_suppliers.id')
            ->join('Product_prices', 'Product_details.id', '=', 'Product_prices.Product_id')
            ->join('Product_stocks', 'Product_details.id', '=', 'Product_stocks.Product_id')
            ->select(
                'Product_details.id',
                'Product_details.code',
                'Product_details.name as Product_name',
                'Product_details.model',
                'Product_details.color',
                'Product_details.made_by',
                'Product_details.gender',
                'Product_details.type',
                'Product_details.movement',
                'Product_details.dial_color',
                'Product_details.strap_color',
                'Product_details.strap_material',
                'Product_details.case_diameter_mm',
                'Product_details.case_thickness_mm',
                'Product_details.glass_type',
                'Product_details.water_resistance',
                'Product_details.features',
                'Product_details.image',
                'Product_details.warranty',
                'Product_details.description',
                'Product_details.barcode',
                'Product_details.status',
                'Product_details.location',
                'Product_details.brand',
                'Product_details.category',
                'Product_details.supplier_id',
                'Product_suppliers.name as supplier_name',
                'Product_prices.supplier_price',
                'Product_prices.selling_price',
                'Product_prices.discount_price',
                'Product_stocks.shop_stock',
                'Product_stocks.store_stock',
                'Product_stocks.damage_stock'
            )
            ->where('Product_details.id', $id)
            ->first();

        // Basic information
        $this->editId = $id;
        $this->editCode = $Product->code;
        $this->editName = $Product->Product_name;
        $this->editModel = $Product->model;
        $this->editBrand = $Product->brand;
        $this->editColor = $Product->color;
        $this->editMadeBy = $Product->made_by;

        // Classification
        $this->editCategory = $Product->category;
        $this->editGender = $Product->gender;
        $this->editType = $Product->type;

        // Technical Specifications
        $this->editMovement = $Product->movement;
        $this->editDialColor = $Product->dial_color;
        $this->editStrapColor = $Product->strap_color;
        $this->editStrapMaterial = $Product->strap_material;
        $this->editCaseDiameter = $Product->case_diameter_mm;
        $this->editCaseThickness = $Product->case_thickness_mm;
        $this->editGlassType = $Product->glass_type;
        $this->editWaterResistance = $Product->water_resistance;
        $this->editFeatures = $Product->features;

        // Product Information
        $this->existingImage = $Product->image;
        $this->editWarranty = $Product->warranty;
        $this->editBarcode = $Product->barcode;
        $this->editDescription = $Product->description;

        // Supplier Information - Store both ID and name
        $this->editSupplier = $Product->supplier_id; // Store the ID for the update
        $this->editSupplierName = $Product->supplier_name ?? $this->getDefaultSupplier(); // Store name for display
        $this->editSupplierPrice = $Product->supplier_price ?? 0;

        // Pricing and Inventory
        $this->editSellingPrice = $Product->selling_price;
        $this->editDiscountPrice = $Product->discount_price;
        $this->editShopStock = $Product->shop_stock;
        $this->editStoreStock = $Product->store_stock;
        $this->editDamageStock = $Product->damage_stock;
        $this->editStatus = $Product->status;
        $this->editLocation = $Product->location;

        $this->dispatch('open-edit-modal');
    }

    public function updateProduct($id)
    {
        $this->validateEditProduct();

        // Use database transaction to ensure all records are updated together
        DB::beginTransaction();

        try {
            // Handle image upload if file exists
            $imagePath = $this->existingImage;
            if ($this->editImage) {
                $imageName = time() . '-' . $this->editCode . '.' . $this->editImage->getClientOriginalExtension();
                $this->editImage->storeAs('public/images/ProductImages', $imageName);
                $imagePath = 'images/ProductImages/' . $imageName;
            }

            $code = $this->editCode();
            
            // Update the main Product record
            ProductDetail::where('id', $id)->update([
                'code' => $code,
                'name' => $this->editName,
                'model' => $this->editModel,
                'color' => $this->editColor,
                'made_by' => $this->editMadeBy,
                'brand' => $this->editBrand,
                'category' => $this->editCategory,
                'gender' => $this->editGender,
                'type' => $this->editType,
                'movement' => $this->editMovement,
                'dial_color' => $this->editDialColor,
                'strap_color' => $this->editStrapColor,
                'strap_material' => $this->editStrapMaterial,
                'case_diameter_mm' => $this->editCaseDiameter,
                'case_thickness_mm' => $this->editCaseThickness,
                'glass_type' => $this->editGlassType,
                'water_resistance' => $this->editWaterResistance,
                'features' => $this->editFeatures,
                'warranty' => $this->editWarranty,
                'barcode' => $this->editBarcode,
                'description' => $this->editDescription,
                'image' => $imagePath,
                'status' => $this->editStatus,
                'location' => $this->editLocation,
                'supplier_id' => $this->editSupplier ?? $this->getDefaultSupplier(), // Use the correct supplier ID
            ]);

            // Update the price record
            ProductPrice::where('Product_id', $this->editId)->update([
                'supplier_price' => $this->editSupplierPrice ?? 0,
                'selling_price' => $this->editSellingPrice,
                'discount_price' => $this->editDiscountPrice,
            ]);

            // Update stock record
            $shopStock = (int) $this->editShopStock;
            $storeStock = (int) $this->editStoreStock;
            $damageStock = (int) $this->editDamageStock;
            
            ProductStock::where('Product_id', $this->editId)->update([
                'shop_stock' => $shopStock,
                'store_stock' => $storeStock,
                'damage_stock' => $damageStock,
                'total_stock' => $shopStock + $storeStock + $damageStock,
                'available_stock' => $shopStock + $storeStock
            ]);

            DB::commit();
            $this->resetEditImage();

            // Close the modal
            $this->js("$('#editProductModal').modal('hide')");
            $this->js("Swal.fire('Success!', 'Product updated successfully!', 'success')");
        } catch (Exception $e) {
            DB::rollBack();
            $this->js("Swal.fire('Error!', '" . $e->getMessage() . "', 'error')");
        }
    }   

    public function duplicateProduct()
    {
        $this->validateEditProduct();

        // Generate a new code for the duplicated Product
        $this->code = $this->generateDuplicateCode();
        $this->supplier = $this->editSupplier ?? $this->getDefaultSupplier();

        DB::beginTransaction();

        try {
            // Handle image - use the existing image or the newly uploaded one
            $imagePath = $this->existingImage;
            if ($this->editImage) {
                $imageName = time() . '-' . $this->code . '.' . $this->editImage->getClientOriginalExtension();
                $this->editImage->storeAs('public/images/ProductImages', $imageName);
                $imagePath = 'images/ProductImages/' . $imageName;
            }

            // Create a new Product record with the edited values
            $Product = ProductDetail::create([
                'code' => $this->code,
                'name' => $this->editName,  // Add (Copy) to indicate it's a duplicate
                'model' => $this->editModel,
                'color' => $this->editColor,
                'made_by' => $this->editMadeBy,
                'gender' => $this->editGender,
                'type' => $this->editType,
                'movement' => $this->editMovement,
                'dial_color' => $this->editDialColor,
                'strap_color' => $this->editStrapColor,
                'strap_material' => $this->editStrapMaterial,
                'case_diameter_mm' => $this->editCaseDiameter,
                'case_thickness_mm' => $this->editCaseThickness,
                'glass_type' => $this->editGlassType,
                'water_resistance' => $this->editWaterResistance,
                'features' => $this->editFeatures,
                'image' => $imagePath,
                'warranty' => $this->editWarranty,
                'description' => $this->editDescription,
                'barcode' => $this->editBarcode,  // Modify barcode to avoid duplicates
                'status' => $this->editStatus,
                'location' => $this->editLocation,
                'brand' => $this->editBrand,
                'category' => $this->editCategory,
                'supplier_id' => $this->supplier
            ]);

            // Create pricing record
            ProductPrice::create([
                'supplier_price' => $this->editSupplierPrice ?? 0,
                'selling_price' => $this->editSellingPrice,
                'discount_price' => $this->editDiscountPrice,
                'Product_id' => $Product->id
            ]);

            // Create stock record
            $shopStock = (int) $this->editShopStock;
            $storeStock = (int) $this->editStoreStock;
            $damageStock = (int) $this->editDamageStock;

            ProductStock::create([
                'shop_stock' => $shopStock,
                'store_stock' => $storeStock,
                'damage_stock' => $damageStock,
                'total_stock' => $shopStock + $storeStock + $damageStock,
                'available_stock' => $shopStock + $storeStock,
                'Product_id' => $Product->id
            ]);

            DB::commit();
            $this->resetEditImage();

            // Close the modal and show success message
            $this->js('$("#editProductModal").modal("hide")');
            $this->resetForm();
            $this->js("Swal.fire('Success!', 'Product duplicated successfully', 'success')");

        } catch (Exception $e) {
            DB::rollBack();
            logger('Error duplicating Product: ' . $e->getMessage());
            $this->js("Swal.fire({
                icon: 'error',
                title: 'Product Duplication Failed',
                text: '" . $e->getMessage() . "',
            })");
        }
    }

    private function generateDuplicateCode()
    {
        $lastProduct = ProductDetail::latest('id')->first();
        $numericId = $lastProduct ? $lastProduct->id + 1 : 1;

        $components = [
            'brand' => strtoupper(substr($this->editBrand ?? '', 0, 3)),
            'color' => strtoupper(substr($this->editColor ?? '', 0, 1)),
            'strap' => strtoupper(substr($this->editStrapMaterial ?? '', 0, 1)),
            'gender' => strtoupper(substr($this->editGender ?? '', 0, 1)),
        ];

        $prefix = implode('', $components);

        return $prefix . $numericId;
    }

    public $deleteId;
    public function confirmDelete($id)
    {
        $this->deleteId = $id;
        $this->dispatch("confirm-delete");
    }
    #[On('confirmDelete')]
    public function deleteProduct()
    {
        try {
            DB::beginTransaction();
            
            // First delete any related sale_items
            DB::table('sale_items')->where('Product_id', $this->deleteId)->delete();
            
            // Then delete the Product and its related data
            ProductStock::where('Product_id', $this->deleteId)->delete();
            ProductPrice::where('Product_id', $this->deleteId)->delete();
            ProductDetail::where('id', $this->deleteId)->delete();
            
            DB::commit();
            return true;
        } catch (Exception $e) {
            DB::rollBack();
            $this->js("Swal.fire('Error!', '" . $e->getMessage() . "', 'error')");
            return false;
        }
    }

    public function exportToCsv()
    {
        return redirect()->route('Productes.export');
    }

    private function validateCretaeProduct()
    {
        $this->validate([
            'name' => 'required',
            'model' => 'required',
            'barcode' => 'required',
            'description' => 'required',
            'image' => 'required|image|max:2048',
            'brand' => 'required',
            'category' => 'required',
            'gender' => 'required',
            'type' => 'required',
            'color' => 'required',
            'madeBy' => 'required',
            'movement' => 'required',
            'dialColor' => 'required',
            'strapColor' => 'required',
            'strapMaterial' => 'required',
            'caseDiameter' => 'required|numeric',
            'caseThickness' => 'required|numeric',
            'glassType' => 'required',
            'waterResistance' => 'required',
            'features' => 'required',
            'warranty' => 'required',
            // 'supplier' => 'required',
            'status' => 'required',
            'location' => 'required',
            // 'supplierPrice' => 'required|numeric|min:0',
            'sellingPrice' => 'required|numeric|min:0',
            'discountPrice' => 'required|numeric|min:0',
            'shopStock' => 'required|numeric|min:0',
            'storeStock' => 'required|numeric|min:0',
            'damageStock' => 'required|numeric|min:0',
        ]);
    }

    private function validateEditProduct()
    {
        $this->validate([
            'editName' => 'required',
            'editModel' => 'required',
            'editBarcode' => 'required',
            'editDescription' => 'required',
            'editImage' => $this->existingImage ? 'nullable|image|max:2048' : 'required|image|max:2048',
            'editBrand' => 'required',
            'editCategory' => 'required',
            'editGender' => 'required',
            'editType' => 'required',
            'editColor' => 'required',
            'editMadeBy' => 'required',
            'editMovement' => 'required',
            'editDialColor' => 'required',
            'editStrapColor' => 'required',
            'editStrapMaterial' => 'required',
            'editCaseDiameter' => 'required|numeric',
            'editCaseThickness' => 'required|numeric',
            'editGlassType' => 'required',
            'editWaterResistance' => 'required',
            'editFeatures' => 'required',
            'editWarranty' => 'required',
            // 'editSupplier' => 'required',
            'editStatus' => 'required',
            'editLocation' => 'required',
            // 'editSupplierPrice' => 'required|numeric|min:0',
            'editSellingPrice' => 'required|numeric|min:0',
            'editDiscountPrice' => 'required|numeric|min:0',
            'editShopStock' => 'required|numeric|min:0',
            'editStoreStock' => 'required|numeric|min:0',
            'editDamageStock' => 'required|numeric|min:0',
        ]);
    }

    private function generateCode()
    {
        $lastProduct = ProductDetail::latest('id')->first();
        $numericId = $lastProduct ? $lastProduct->id + 1 : 1;

        $components = [
            'brand' => strtoupper(substr($this->brand ?? '', 0, 3)),
            'color' => strtoupper(substr($this->color ?? '', 0, 1)),
            'strap' => strtoupper(substr($this->strapMaterial ?? '', 0, 1)),
            'gender' => strtoupper(substr($this->gender ?? '', 0, 1)),
        ];

        $prefix = implode('', $components);

        return $prefix . $numericId;
    }

    private function editCode()
    {
        $numericId = $this->editId;

        $components = [
            'brand' => strtoupper(substr($this->editBrand ?? '', 0, 3)),
            'color' => strtoupper(substr($this->editColor ?? '', 0, 1)),
            'strap' => strtoupper(substr($this->editStrapMaterial ?? '', 0, 1)),
            'gender' => strtoupper(substr($this->editGender ?? '', 0, 1)),
        ];

        $prefix = implode('', $components);

        return $prefix . $numericId;
    }

    #[On('reset-create-form')]
    public function resetCreateForm()
    {
        $this->resetForm();
    }

    public function resetForm()
    {
        // Enhanced reset that clears all relevant properties
        $this->reset([
            'code', 'name', 'model', 'color', 'madeBy', 'category', 'gender',
            'type', 'movement', 'dialColor', 'strapColor', 'strapMaterial',
            'caseDiameter', 'caseThickness', 'glassType', 'waterResistance',
            'features', 'warranty', 'description', 'barcode', 'status',
            'location', 'sellingPrice', 'discountPrice', 'shopStock',
            'storeStock', 'damageStock', 'image', 'supplier', 'supplierPrice'
        ]);
        
        // Reset validation errors
        $this->resetValidation();
        $this->resetErrorBag();
    }

    /**
     * Get file preview information with fallbacks for invalid temporary URLs
     * 
     * @param mixed $file The uploaded file object
     * @return array File information including type, preview URL, and icon
     */
    private function getFilePreview($file)
    {
        if (!$file || !is_object($file)) {
            return [
                'type' => null,
                'url' => null,
                'icon' => null
            ];
        }
        
        $extension = strtolower($file->getClientOriginalExtension());
        $isImage = in_array($extension, ['jpg', 'jpeg', 'png', 'gif']);
        $isPdf = $extension === 'pdf';
        
        $result = [
            'type' => $isImage ? 'image' : ($isPdf ? 'pdf' : 'other'),
            'name' => $file->getClientOriginalName(),
            'url' => null,
            'icon' => $isImage ? 'bi-file-image' : ($isPdf ? 'bi-file-earmark-pdf' : 'bi-file'),
            'icon_color' => $isImage ? 'text-primary' : ($isPdf ? 'text-danger' : 'text-secondary')
        ];
        
        // Only try to get temporary URL for images
        if ($isImage) {
            try {
                $result['url'] = $file->temporaryUrl();
            } catch (\Exception $e) {
                // Temporary URL failed, we'll use the icon instead
                $result['url'] = null;
            }
        }
        
        return $result;
    }

    public function updatedImage()
    {
        if ($this->image) {
            $this->imagePreview = $this->getFilePreview($this->image);
        }
    }

    public function updatedEditImage()
    {
        if ($this->editImage) {
            $this->editImagePreview = $this->getFilePreview($this->editImage);
        }
    }

    public function resetEditImage()
    {
        $this->editImage = null;
        $this->editImagePreview = null;
    }
}
