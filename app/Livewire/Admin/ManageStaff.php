<?php

namespace App\Livewire\Admin;
use Exception;
use App\Models\User;
use Livewire\Component;
use Livewire\Attributes\On;
use Livewire\WithPagination;
use Livewire\Attributes\Title;
use Livewire\Attributes\Layout;
use Illuminate\Support\Facades\Hash;

#[Layout('components.layouts.admin')]
#[Title('Manage Staff')]
class ManageStaff extends Component
{
    public $viewUserDetail = [];
    public function viewDetails($id)
    {
        $user = User::find($id);
        if (! $user) {
            $this->js("Swal.fire('Error!', 'Staff Not Found', 'error')");
            return;
        }
        $userDetail = \App\Models\UserDetail::where('user_id', $user->id)->first();
        $this->viewUserDetail = [
            'name' => $user->name,
            'contact' => $user->contact,
            'email' => $user->email,
            'role' => $user->role,
            'dob' => $userDetail ? $userDetail->dob : '-',
            'age' => $userDetail ? $userDetail->age : '-',
            'nic_num' => $userDetail ? $userDetail->nic_num : '-',
            'address' => $userDetail ? $userDetail->address : '-',
            'work_role' => $userDetail ? $userDetail->work_role : '-',
            'department' => $userDetail ? $userDetail->department : '-',
            'gender' => $userDetail ? $userDetail->gender : '-',
            'join_date' => $userDetail ? $userDetail->join_date : '-',
            'fingerprint_id' => $userDetail ? $userDetail->fingerprint_id : '-',
            'allowance' => $userDetail ? $userDetail->allowance : '-',
            'basic_salary' => $userDetail ? $userDetail->basic_salary : '-',
            'user_image' => $userDetail ? $userDetail->user_image : null,
            'description' => $userDetail ? $userDetail->description : '-',
            'status' => $userDetail ? $userDetail->status : '-',
        ];
        $this->js("$('#viewDetailsModal').modal('show')");
    }
    public function render()
    {
        $staffs = User::where('role', 'staff')->get();
        return view('livewire.admin.manage-staff', [
            'staffs' => $staffs,
        ]);

    }
    public function createStaff()
    {
        $this->reset();
        $this->js("$('#createStaffModal').modal('show')");
    }
    public $name;
    public $contactNumber;
    public $email;
    public $password;
    public $confirmPassword;
    // UserDetails fields
    public $dob;
    public $age;
    public $nic_num;
    public $address;
    public $work_role;
    public $work_type;
    public $department;
    public $gender;
    public $join_date;
    public $fingerprint_id;
    public $allowance;
    public $basic_salary;
    public $user_image;
    public $description;
    public $status = 'active';
 
    public function saveStaff()
    {
        $this->validate([
            'name' => 'required',
            'contactNumber' => 'required',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|min:8',
            'confirmPassword' => 'required|min:8|same:password',
            'dob' => 'nullable|date',
            'age' => 'nullable|integer|min:0',
            'nic_num' => 'nullable|string',
            'address' => 'nullable|string',
            'work_role' => 'nullable|string',
            'work_type' => 'required|in:daily,monthly',
            'department' => 'nullable|string',
            'gender' => 'nullable|in:male,female,other',
            'join_date' => 'nullable|date',
            'fingerprint_id' => 'nullable|string',
            'allowance' => 'nullable|string',
            'basic_salary' => 'nullable|numeric',
            'user_image' => 'nullable|string',
            'description' => 'nullable|string',
            'status' => 'required|in:active,inactive',
        ]);

        try {
            $user = User::create([
                'name' => $this->name,
                'contact'=> $this->contactNumber,
                'email' => $this->email,
                'password' => Hash::make($this->password),
                'role' => 'staff',
                'profile_photo_path' => $this->user_image,
            ]);

            // Convert allowance to array if not empty
            $allowanceArray = null;
            if (!empty($this->allowance)) {
                $allowanceArray = array_map('trim', explode(',', $this->allowance));
            }

            \App\Models\UserDetail::create([
                'user_id' => $user->id,
                'dob' => $this->dob,
                'age' => $this->age,
                'nic_num' => $this->nic_num,
                'address' => $this->address,
                'work_role' => $this->work_role,
                'work_type' => $this->work_type,
                'department' => $this->department,
                'gender' => $this->gender,
                'join_date' => $this->join_date,
                'fingerprint_id' => $this->fingerprint_id,
                'allowance' => $allowanceArray,
                'basic_salary' => $this->basic_salary,
                'user_image' => $this->user_image,
                'description' => $this->description,
                'status' => $this->status,
            ]);

            $this->js("Swal.fire('Success!', 'Staff Created Successfully', 'success')");
        } catch (Exception $e) {
            $this->js("Swal.fire('Error!', '" . $e->getMessage() . "', 'error')");
        }

        $this->js('$("#createStaffModal").modal("hide")');
    }

    public $editName;
    public $editContactNumber;
    public $editEmail;
    
    public $editStaffId;
    public $editPassword;
    public $editConfirmPassword;
    public function editStaff($id)
    {
        $user = User::find($id);
        if(! $user) {
            $this->js("Swal.fire('Error!', 'Staff Not Found', 'error')");
            return;
        }
        $this->editName = $user->name;
        $this->editContactNumber = $user->contact;
        $this->editEmail = $user->email;
        $this->editStaffId = $user->id;
        // Don't set password fields - leave them blank
        $this->editPassword = '';
        $this->editConfirmPassword = '';

        $this->dispatch('edit-staff-modal');
    }

    public function updateStaff()
    {
        $validationRules = [
            'editName' => 'required',
            'editContactNumber' => 'required',
            'editEmail' => 'required|email|unique:users,email,' . $this->editStaffId,
        ];
        
        // Only validate password if it's provided
        if (!empty($this->editPassword)) {
            $validationRules['editPassword'] = 'required|min:8';
            $validationRules['editConfirmPassword'] = 'required|same:editPassword';
        }
        
        $this->validate($validationRules);

        try {
            $user = User::find($this->editStaffId);
            if ($user) {
                $user->name = $this->editName;
                $user->contact = $this->editContactNumber;
                $user->email = $this->editEmail;
                
                // Only update password if a new one was provided
                if (!empty($this->editPassword)) {
                    $user->password = Hash::make($this->editPassword);
                }
                
                $user->save();
                $this->js("Swal.fire('Success!', 'Staff Updated Successfully', 'success')");
            } else {
                $this->js("Swal.fire('Error!', 'Staff Not Found', 'error')");
            }
        } catch (Exception $e) {
            $this->js("Swal.fire('Error!', '" . $e->getMessage() . "', 'error')");
        }

        $this->js('$("#editStaffModal").modal("hide")');
    }
    public $deleteId;
    #[On('confirmDelete')]
    public function deleteStaff()
    {
        $user = User::find($this->deleteId);
        if ($user) {
            $user->delete();
            $this->js("Swal.fire('Success!', 'Staff Deleted Successfully', 'success')");
        } else {
            $this->js("Swal.fire('Error!', 'Staff Not Found', 'error')");
        }
    }
    public function confirmDelete($id)
    {
        $this->deleteId = $id;
        $this->dispatch('confirm-delete');
    }
}
