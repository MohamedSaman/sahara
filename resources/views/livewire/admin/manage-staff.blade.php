<div>
    <div class="container-fluid">
        <div class="card shadow-sm">
            <div class="card-header bg-light">
                <div class="d-flex flex-column flex-sm-row justify-content-between align-items-sm-center gap-2">
                    <h4 class="card-title mb-2 mb-sm-0">Staff List</h4>
                    <div class="card-tools">
                        <button class="btn btn-primary w-100 w-sm-auto" wire:click="createStaff">
                            <i class="bi bi-plus-circle me-1"></i> Create Staff
                        </button>
                    </div>
                </div>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <!-- Wrap table in div with table-responsive class -->
                    <table class="table table-bordered table-hover">
                        <!-- Remove table-responsive from table -->
                        <thead>
                            <tr>
                                <th class="text-center">#</th>
                                <th class="text-center">Staff Name</th>
                                <th class="text-center">Contact Number</th>
                                <th class="text-center">Email</th>
                                <th class="text-center">Role</th>
                                <th class="text-center">Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @if ($staffs->count() > 0)
                            @foreach ($staffs as $staff)
                            <tr>
                                <td class="text-center">{{ $loop->iteration }}</td>
                                <td class="text-center">{{ $staff->name ?? '-' }}</td>
                                <td class="text-center">{{ $staff->contact ?? '-' }}</td>
                                <td class="text-center">{{ $staff->email ?? '-' }}</td>
                                <td class="text-center">{{ $staff->role ?? '-' }}</td>
                                <td class="text-center">
                                    <div class="d-flex justify-content-center gap-2 flex-wrap">
                                        <button class="btn btn-sm btn-info" wire:click="viewDetails({{ $staff->id }})">
                                            <i class="bi bi-eye"></i>
                                        </button>
                                        <button class="btn btn-sm btn-primary" wire:click="editStaff({{ $staff->id }})"
                                            wire:loading.attr="disabled">
                                            <i class="bi bi-pencil" wire:loading.class="d-none"
                                                wire:target="editStaff({{ $staff->id }})"></i>
                                            <span wire:loading wire:target="editStaff({{ $staff->id }})">
                                                <i class="spinner-border spinner-border-sm"></i>
                                            </span>
                                        </button>
                                        <button class="btn btn-sm btn-danger"
                                            wire:click="confirmDelete({{ $staff->id }})">
                                            <i class="bi bi-trash"></i>
                                        </button>
                                    </div>
                                </td>
                            </tr>
                            {{-- View Details Modal --}}
                            <div wire:ignore.self class="modal fade" id="viewDetailsModal" tabindex="-1"
                                aria-labelledby="viewDetailsModalLabel" aria-hidden="true">
                                <div class="modal-dialog modal-lg">
                                    <div class="modal-content">
                                        <div class="modal-header bg-primary text-white">
                                            <h1 class="modal-title fs-5" id="viewDetailsModalLabel"><i
                                                    class="bi bi-person-badge me-2"></i>Staff Details</h1>
                                            <button type="button" class="btn-close btn-close-white"
                                                data-bs-dismiss="modal" aria-label="Close"></button>
                                        </div>
                                        <div class="modal-body bg-light">
                                            <div class="row g-0">
                                                <div
                                                    class="col-md-4 d-flex flex-column align-items-center justify-content-center p-3 border-end">
                                                    <img src="{{ $viewUserDetail['user_image'] ?? 'https://media.istockphoto.com/id/1300845620/vector/user-icon-flat-isolated-on-white-background-user-symbol-vector-illustration.jpg?s=612x612&w=0&k=20&c=yBeyba0hUkh14_jgv1OKqIH0CCSWU_4ckRkAoy2p73o=' }}"
                                                        alt="User Image" class="img-fluid rounded-circle shadow mb-3"
                                                        style="width: 140px; height: 140px; object-fit: cover;">
                                                    <span class="fw-bold fs-5">{{ $viewUserDetail['name'] ?? '-'
                                                        }}</span>
                                                    <span class="text-muted">{{ $viewUserDetail['role'] ?? '-' }}</span>
                                                </div>
                                                <div class="col-md-8 p-3">
                                                    <div class="mb-3 pb-2 border-bottom">
                                                        <h6 class="fw-bold text-primary mb-2"><i
                                                                class="bi bi-person-lines-fill me-1"></i>Personal Info
                                                        </h6>
                                                        <div class="row mb-1">
                                                            <div class="col-5 text-muted">Contact:</div>
                                                            <div class="col-7">{{ $viewUserDetail['contact'] ?? '-' }}
                                                            </div>
                                                            <div class="col-5 text-muted">Email:</div>
                                                            <div class="col-7">{{ $viewUserDetail['email'] ?? '-' }}
                                                            </div>
                                                            <div class="col-5 text-muted">Date of Birth:</div>
                                                            <div class="col-7">{{ $viewUserDetail['dob'] ?? '-' }}</div>
                                                            <div class="col-5 text-muted">Age:</div>
                                                            <div class="col-7">{{ $viewUserDetail['age'] ?? '-' }}</div>
                                                            <div class="col-5 text-muted">NIC Number:</div>
                                                            <div class="col-7">{{ $viewUserDetail['nic_num'] ?? '-' }}
                                                            </div>
                                                            <div class="col-5 text-muted">Gender:</div>
                                                            <div class="col-7">{{ $viewUserDetail['gender'] ?? '-' }}
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="mb-3 pb-2 border-bottom">
                                                        <h6 class="fw-bold text-primary mb-2"><i
                                                                class="bi bi-building me-1"></i>Work Info</h6>
                                                        <div class="row mb-1">
                                                            <div class="col-5 text-muted">Work Role:</div>
                                                            <div class="col-7">{{ $viewUserDetail['work_role'] ?? '-' }}
                                                            </div>
                                                            <div class="col-5 text-muted">Department:</div>
                                                            <div class="col-7">{{ $viewUserDetail['department'] ?? '-'
                                                                }}</div>
                                                            <div class="col-5 text-muted">Join Date:</div>
                                                            <div class="col-7">{{ $viewUserDetail['join_date'] ?? '-' }}
                                                            </div>
                                                            <div class="col-5 text-muted">Fingerprint ID:</div>
                                                            <div class="col-7">{{ $viewUserDetail['fingerprint_id'] ??
                                                                '-' }}</div>
                                                            <div class="col-5 text-muted">Allowance:</div>
                                                            <div class="col-7">{{ is_array($viewUserDetail['allowance']
                                                                ?? null) ? implode(', ', $viewUserDetail['allowance']) :
                                                                ($viewUserDetail['allowance'] ?? '-') }}</div>
                                                            <div class="col-5 text-muted">Basic Salary:</div>
                                                            <div class="col-7">{{ $viewUserDetail['basic_salary'] ?? '-'
                                                                }}</div>
                                                        </div>
                                                    </div>
                                                    <div class="mb-3 pb-2 border-bottom">
                                                        <h6 class="fw-bold text-primary mb-2"><i
                                                                class="bi bi-geo-alt me-1"></i>Address & Status</h6>
                                                        <div class="row mb-1">
                                                            <div class="col-5 text-muted">Address:</div>
                                                            <div class="col-7">{{ $viewUserDetail['address'] ?? '-' }}
                                                            </div>
                                                            <div class="col-5 text-muted">Status:</div>
                                                            <div class="col-7">{{ $viewUserDetail['status'] ?? '-' }}
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div>
                                                        <h6 class="fw-bold text-primary mb-2"><i
                                                                class="bi bi-chat-left-text me-1"></i>Description</h6>
                                                        <div class="row mb-1">
                                                            <div class="col-12">{{ $viewUserDetail['description'] ?? '-'
                                                                }}</div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="modal-footer bg-light">
                                            <button type="button" class="btn btn-secondary"
                                                data-bs-dismiss="modal">Close</button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            @endforeach
                            @else
                            <tr>
                                <td colspan="6" class="text-center">
                                    <div class="alert alert-primary bg-opacity-10 my-2">
                                        <i class="bi bi-info-circle me-2"></i> No staffs found.
                                    </div>
                                </td>
                            </tr>
                            @endif
                        </tbody>
                    </table>
                </div>
                {{-- <div class="d-flex justify-content-center">
                    {{ $staffs->links('livewire.custom-pagination') }}
                </div> --}}
            </div>
        </div>
        {{-- Create Suplier Modal --}}
        <div wire:ignore.self class="modal fade" id="createStaffModal" tabindex="-1"
            aria-labelledby="createStaffModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-xl">
                <div class="modal-content">
                    <div class="modal-header bg-primary text-white">
                        <h1 class="modal-title fs-5" id="createStaffModalLabel"><i
                                class="bi bi-person-plus me-2"></i>Create Staff</h1>
                        <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"
                            aria-label="Close"></button>
                    </div>
                    <div class="modal-body bg-light">
                        <div class="row g-0">

                            <div class="col-md-12 p-3">
                                <div class="mb-3 pb-2 border-bottom">
                                    <h6 class="fw-bold text-primary mb-2"><i
                                            class="bi bi-person-lines-fill me-1"></i>Personal Info</h6>
                                    <div class="row mb-1">
                                        <div class="col-md-6 mb-2">
                                            <label for="staffName" class="form-label">Staff Name</label>
                                            <input type="text" class="form-control" id="staffName" wire:model="name"
                                                placeholder="Enter staff name">
                                            @error('name')<span class="text-danger">* {{ $message }}</span>@enderror
                                        </div>
                                        <div class="col-md-6 mb-2">
                                            <label for="contactNumber" class="form-label">Contact Number</label>
                                            <input type="text" class="form-control" id="contactNumber"
                                                wire:model="contactNumber" placeholder="Enter contact number">
                                            @error('contactNumber')<span class="text-danger">* {{ $message
                                                }}</span>@enderror
                                        </div>
                                        <div class="col-md-6 mb-2">
                                            <label for="email" class="form-label">Email</label>
                                            <input type="email" class="form-control" id="email" wire:model="email"
                                                placeholder="Enter email">
                                            @error('email')<span class="text-danger">* {{ $message }}</span>@enderror
                                        </div>
                                        <div class="col-md-6 mb-2">
                                            <label for="dob" class="form-label">Date of Birth</label>
                                            <input type="date" class="form-control" id="dob" wire:model="dob">
                                            @error('dob')<span class="text-danger">* {{ $message }}</span>@enderror
                                        </div>
                                        <div class="col-md-6 mb-2">
                                            <label for="age" class="form-label">Age</label>
                                            <input type="number" class="form-control" id="age" wire:model="age" min="0">
                                            @error('age')<span class="text-danger">* {{ $message }}</span>@enderror
                                        </div>
                                        <div class="col-md-6 mb-2">
                                            <label for="nic_num" class="form-label">NIC Number</label>
                                            <input type="text" class="form-control" id="nic_num" wire:model="nic_num"
                                                placeholder="Enter NIC number">
                                            @error('nic_num')<span class="text-danger">* {{ $message }}</span>@enderror
                                        </div>
                                        <div class="col-md-12 mb-2">
                                            <label for="gender" class="form-label">Gender</label>
                                            <select class="form-select" id="gender" wire:model="gender">
                                                <option value="">Select Gender</option>
                                                <option value="male">Male</option>
                                                <option value="female">Female</option>
                                                <option value="other">Other</option>
                                            </select>
                                            @error('gender')<span class="text-danger">* {{ $message }}</span>@enderror
                                        </div>
                                    </div>
                                </div>
                                <div class="mb-3 pb-2 border-bottom">
                                    <h6 class="fw-bold text-primary mb-2"><i class="bi bi-building me-1"></i>Work Info
                                    </h6>
                                    <div class="row mb-1">
                                        <div class="col-md-6 mb-2">
                                            <label for="work_role" class="form-label">Work Role</label>
                                            <input type="text" class="form-control" id="work_role"
                                                wire:model="work_role" placeholder="Enter work role">
                                            @error('work_role')<span class="text-danger">* {{ $message }}</span>@enderror
                                        </div>
                                        <div class="col-md-6 mb-2">
                                            <label for="work_type" class="form-label">Work Type</label>
                                            <select class="form-select" id="work_type" wire:model="work_type">
                                                <option value="">Select Work Type</option>
                                                <option value="daily">Daily</option>
                                                <option value="monthly">Monthly</option>
                                            </select>
                                            @error('work_type')<span class="text-danger">* {{ $message }}</span>@enderror
                                        </div>
                                        <div class="col-md-6 mb-2">
                                            <label for="department" class="form-label">Department</label>
                                            <input type="text" class="form-control" id="department"
                                                wire:model="department" placeholder="Enter department">
                                            @error('department')<span class="text-danger">* {{ $message
                                                }}</span>@enderror
                                        </div>
                                        <div class="col-md-6 mb-2">
                                            <label for="join_date" class="form-label">Join Date</label>
                                            <input type="date" class="form-control" id="join_date"
                                                wire:model="join_date">
                                            @error('join_date')<span class="text-danger">* {{ $message
                                                }}</span>@enderror
                                        </div>
                                        <div class="col-md-6 mb-2">
                                            <label for="fingerprint_id" class="form-label">Fingerprint ID</label>
                                            <input type="text" class="form-control" id="fingerprint_id"
                                                wire:model="fingerprint_id" placeholder="Enter fingerprint ID">
                                            @error('fingerprint_id')<span class="text-danger">* {{ $message
                                                }}</span>@enderror
                                        </div>
                                        <div class="col-md-6 mb-2">
                                            <label for="allowance" class="form-label">Allowance (comma
                                                separated)</label>
                                            <input type="text" class="form-control" id="allowance"
                                                wire:model="allowance" placeholder="e.g. fix,food">
                                            @error('allowance')<span class="text-danger">* {{ $message
                                                }}</span>@enderror
                                        </div>
                                        <div class="col-md-6 mb-2">
                                            <label for="basic_salary" class="form-label">Basic Salary</label>
                                            <input type="number" step="0.01" class="form-control" id="basic_salary"
                                                wire:model="basic_salary" placeholder="Enter basic salary">
                                            @error('basic_salary')<span class="text-danger">* {{ $message
                                                }}</span>@enderror
                                        </div>
                                    </div>
                                </div>
                                <div class="mb-3 pb-2 border-bottom">
                                    <h6 class="fw-bold text-primary mb-2"><i class="bi bi-geo-alt me-1"></i>Address &
                                        Status</h6>
                                    <div class="row mb-1">
                                        <div class="col-md-12 mb-2">
                                            <label for="address" class="form-label">Address</label>
                                            <textarea class="form-control" id="address" wire:model="address"
                                                placeholder="Enter address"></textarea>
                                            @error('address')<span class="text-danger">* {{ $message }}</span>@enderror
                                        </div>
                                        <div class="col-md-6 mb-2">
                                            <label for="status" class="form-label">Status</label>
                                            <select class="form-select" id="status" wire:model="status">
                                                <option value="active">Active</option>
                                                <option value="inactive">Inactive</option>
                                            </select>
                                            @error('status')<span class="text-danger">* {{ $message }}</span>@enderror
                                        </div>
                                        <div class="col-md-6 mb-2">
                                            <label for="user_image" class="form-label">User Image (URL or path)</label>
                                            <input type="text" class="form-control" id="user_image"
                                                wire:model="user_image" placeholder="Image URL or path">
                                            @error('user_image')<span class="text-danger">* {{ $message
                                                }}</span>@enderror
                                        </div>
                                    </div>
                                </div>
                                <div>
                                    <h6 class="fw-bold text-primary mb-2"><i
                                            class="bi bi-chat-left-text me-1"></i>Description</h6>
                                    <div class="row mb-1">
                                        <div class="col-md-12 mb-2">
                                            <textarea class="form-control" id="description" wire:model="description"
                                                placeholder="Enter description"></textarea>
                                            @error('description')<span class="text-danger">* {{ $message
                                                }}</span>@enderror
                                        </div>
                                    </div>
                                </div>
                                <div class="mb-3 pb-2 border-bottom">
                                    <h6 class="fw-bold text-primary mb-2"><i class="bi bi-key me-1"></i>Login Info</h6>
                                    <div class="row mb-1">
                                        <div class="col-md-6 mb-2">
                                            <label for="password" class="form-label">Password</label>
                                            <div class="input-group">
                                                <input type="password" class="form-control" id="password"
                                                    wire:model="password" placeholder="Enter password">
                                                <button class="btn btn-outline-secondary" type="button"
                                                    onclick="togglePasswordVisibility('password')">
                                                    <i class="bi bi-eye" id="passwordToggleIcon"></i>
                                                </button>
                                            </div>
                                            @error('password')<span class="text-danger">* {{ $message }}</span>@enderror
                                        </div>
                                        <div class="col-md-6 mb-2">
                                            <label for="confirmPassword" class="form-label">Confirm Password</label>
                                            <div class="input-group">
                                                <input type="password" class="form-control" id="confirmPassword"
                                                    wire:model="confirmPassword" placeholder="Confirm password">
                                                <button class="btn btn-outline-secondary" type="button"
                                                    onclick="togglePasswordVisibility('confirmPassword')">
                                                    <i class="bi bi-eye" id="confirmPasswordToggleIcon"></i>
                                                </button>
                                            </div>
                                            @error('confirmPassword')<span class="text-danger">* {{ $message
                                                }}</span>@enderror
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer bg-light flex-column flex-sm-row">
                        <button type="button" class="btn btn-secondary w-100 w-sm-auto mb-2 mb-sm-0"
                            data-bs-dismiss="modal">Close</button>
                        <button type="button" class="btn btn-primary w-100 w-sm-auto" wire:click="saveStaff">Add
                            Staff</button>
                    </div>
                </div>
            </div>
        </div>
    </div>
    {{-- Edit Staff Modal --}}
    <div wire:ignore.self wire:key="edit-modal-{{ $editStaffId ?? 'new' }}" class="modal fade hidden"
        id="editStaffModal" tabindex="-1" aria-labelledby="editStaffModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h1 class="modal-title fs-5" id="editStaffModalLabel">Edit Staff</h1>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label for="editName" class="form-label">Staff Name</label>
                            <input type="text" class="form-control" id="editName" wire:model="editName">
                            @error('editName')
                            <span class="text-danger">* {{ $message }}</span>
                            @enderror
                        </div>
                        <div class="col-md-6 mb-3">
                            <label for="editContactNumber" class="form-label">Contact Number</label>
                            <input type="text" class="form-control" id="editContactNumber"
                                wire:model="editContactNumber">
                            @error('editContactNumber')
                            <span class="text-danger">* {{ $message }}</span>
                            @enderror
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label for="editEmail" class="form-label">Email</label>
                            <input type="email" class="form-control" id="editEmail" wire:model="editEmail">
                            @error('editEmail')
                            <span class="text-danger">* {{ $message }}</span>
                            @enderror
                        </div>
                        <div class="col-md-6 mb-3">
                            <label for="editPassword" class="form-label">Password (leave blank to keep
                                current)</label>
                            <div class="input-group">
                                <input type="password" class="form-control" id="editPassword" wire:model="editPassword">
                                <button class="btn btn-outline-secondary" type="button"
                                    onclick="togglePasswordVisibility('editPassword')">
                                    <i class="bi bi-eye" id="editPasswordToggleIcon"></i>
                                </button>
                            </div>
                            @error('editPassword')
                            <span class="text-danger">* {{ $message }}</span>
                            @enderror
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label for="editConfirmPassword" class="form-label">Confirm Password</label>
                            <div class="input-group">
                                <input type="password" class="form-control" id="editConfirmPassword"
                                    wire:model="editConfirmPassword">
                                <button class="btn btn-outline-secondary" type="button"
                                    onclick="togglePasswordVisibility('editConfirmPassword')">
                                    <i class="bi bi-eye" id="editConfirmPasswordToggleIcon"></i>
                                </button>
                            </div>
                            @error('editConfirmPassword')
                            <span class="text-danger">* {{ $message }}</span>
                            @enderror
                        </div>
                    </div>
                </div>
                {{-- @dump($editStaffId, $editName, $editContactNumber, $editEmail, $editBussinessName, $editStaffType,
                $editAddress) --}}
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    <button type="button" class="btn btn-primary" wire:click="updateStaff({{ $editStaffId }})">Update
                        Staff</button>
                </div>
            </div>
        </div>
    </div>
</div>
@push('scripts')
<script>
    window.addEventListener('confirm-delete', event => {
            Swal.fire({
                title: "Are you sure?",
                text: "You won't be able to revert this!",
                icon: "warning",
                showCancelButton: true,
                confirmButtonColor: "#3085d6",
                cancelButtonColor: "#d33",
                confirmButtonText: "Yes, delete it!"
            }).then((result) => {
                if (result.isConfirmed) {
                    // call component's function deleteOffer
                    Livewire.dispatch('confirmDelete');
                    Swal.fire({
                        title: "Deleted!",
                        text: "Staff has been deleted.",
                        icon: "success"
                    });
                }
            });
        });

        window.addEventListener('edit-staff-modal', event => {
            setTimeout(() => {
                const modal = new bootstrap.Modal(document.getElementById('editStaffModal'));
                modal.show();
            }, 500); // 500ms delay before showing the modal
        });

        // Password toggle visibility function
        function togglePasswordVisibility(inputId) {
            const passwordInput = document.getElementById(inputId);
            const toggleIcon = document.getElementById(inputId + 'ToggleIcon');

            if (passwordInput.type === "password") {
                passwordInput.type = "text";
                toggleIcon.classList.remove("bi-eye");
                toggleIcon.classList.add("bi-eye-slash");
            } else {
                passwordInput.type = "password";
                toggleIcon.classList.remove("bi-eye-slash");
                toggleIcon.classList.add("bi-eye");
            }
        }
</script>
@endpush
@push('styles')
<style>
    /* Make modals more mobile-friendly */
    @media (max-width: 575.98px) {
        .modal-dialog {
            margin: 0.5rem;
            max-width: calc(100% - 1rem);
        }

        .modal-header {
            padding: 0.75rem 1rem;
        }

        .modal-body {
            padding: 1rem;
        }

        .modal-footer {
            padding: 0.75rem 1rem;
        }

        .btn {
            padding: 0.375rem 0.5rem;
        }
    }

    /* Improve table display on smaller screens */
    @media (max-width: 767.98px) {
        .table {
            font-size: 0.85rem;
        }

        .table td,
        .table th {
            padding: 0.5rem 0.25rem;
        }

        .btn-sm {
            padding: 0.2rem 0.4rem;
            font-size: 0.75rem;
        }
    }

    /* Focus on most important content for very small screens */
    @media (max-width: 400px) {

        /* Option to hide less important columns if needed */
        .table td:nth-child(4),
        .table th:nth-child(4) {
            display: none;
            /* Hides email column on very small screens */
        }
    }

    /* Ensure password toggle button is properly sized */
    .input-group .btn-outline-secondary {
        display: flex;
        align-items: center;
        justify-content: center;
    }
</style>
@endpush