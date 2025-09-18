<?php

namespace App\Livewire\Admin;
use Exception;
use App\Models\ProductTypeList;
use Livewire\Component;
use Livewire\Attributes\On;
use Livewire\Attributes\Title;
use Livewire\Attributes\Layout;

#[Title("Product Type List")]
#[Layout('components.layouts.admin')]

class ProductTypes extends Component
{
    public $typeName;

    public function render()
    {
        $types = ProductTypeList::orderBy('id','desc')->get();
        return view('livewire.admin.Product-types',[
            'types'=> $types,
        ]);
    }

    public function createType(){
        $this->dispatch('create-type-modal');
    }
    public function resetForm(){
        $this->reset([
            'typeName',
        ]);
        $this->resetValidation();
        $this->resetErrorBag();
    }

    public function saveType(){
        $this->validate([
            'typeName' => 'required|unique:Product_type_lists,type_name'
        ]);
        try{
            
            ProductTypeList::create([
                'type_name' => $this->typeName,
            ]);
            $this->js("Swal.fire('Success!', 'Type Created Successfully', 'success')");
        }catch(Exception $e){
            // log($e->getMessage());
            $this->js("Swal.fire('Error!', '".$e->getMessage()."', 'error')");
        }
        
        $this->js('$("#createTypeModal").modal("hide")');
        return redirect()->route('admin.Product-types');
        
    }

    public $editTypeId;
    public $editTypeName;
  
    public function editType($id){
        $type = ProductTypeList::find($id);
        $this->editTypeName = $type->type_name;
        $this->editTypeId = $type->id;
        
        // $this->js("$('#editTypeModal').modal('show')");
        $this->dispatch('edit-type-modal');
    }

    public function updateType($id){
        // dd($id);
        $this->validate([
            'editTypeName' => 'required|unique:Product_type_lists,type_name,'.$id
        ]);
        try{
            ProductTypeList::where('id', $id)->update([
                'type_name' => $this->editTypeName,
            ]);
            $this->js('$("#editTypeModal").modal("hide")');
            $this->js("Swal.fire('Success!', 'Type Updated Successfully', 'success')");
        }catch(Exception $e){
            // log($e->getMessage());
            $this->js("Swal.fire('Error!', '".$e->getMessage()."', 'error')");
        }
        
        $this->js('$("#editTypeModal").modal("hide")');
    }
    
    public $deleteId;
    public function confirmDelete($id)
    {
        $this->deleteId = $id;
        $this->dispatch('confirm-delete');
    }
    #[On('confirmDelete')]
    public function deleteType(){
        try{
            ProductTypeList::where('id', $this->deleteId )->delete();
        }catch(Exception $e){
            // log($e->getMessage());
            $this->js("Swal.fire('Error!', '".$e->getMessage()."', 'error')");
        }
    }
}
