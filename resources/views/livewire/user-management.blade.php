<div>
    <div class="card mt-5 text-start">
        <div class="card-body">
            <h5 class="card-title" style="color: #0A927C;">User Management</h5>
            @if(session('success'))
            <div class="alert alert-success alert-dismissible fade show" role="alert">
                <i class="bi bi-check-circle me-1"></i>
                {{session('success')}}
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
            @endif
            <div class="text-end">
                <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#addUserModal" wire:click="clear">
                    <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none">
                        <path d="M12 12a5 5 0 1 0 0-10 5 5 0 0 0 0 10ZM3.41 22c0-3.87 3.85-7 8.59-7 .96 0 1.89.13 2.76.37" stroke="#ffffff" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"></path>
                        <path d="M22 18c0 .32-.04.63-.12.93-.09.4-.25.79-.46 1.13A3.97 3.97 0 0 1 18 22a3.92 3.92 0 0 1-2.66-1.03c-.3-.26-.56-.57-.76-.91A3.92 3.92 0 0 1 14 18a3.995 3.995 0 0 1 4-4c1.18 0 2.25.51 2.97 1.33.64.71 1.03 1.65 1.03 2.67ZM19.49 17.98h-2.98M18 16.52v2.99" stroke="#ffffff" stroke-width="1.5" stroke-miterlimit="10" stroke-linecap="round" stroke-linejoin="round"></path>
                    </svg>
                </button>
            </div>
            <div class="table-responsive">
                <table class="table table-hover">
                    <thead>
                        <tr>
                            <th scope="col">#</th>
                            <th scope="col">Name</th>
                            <th scope="col">Department</th>
                            <th scope="col">Role</th>
                            <th scope="col">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($users as $index => $item)
                        <tr wire:key="item-{{ $item->user_id }}">
                            <th scope="row">{{$index+1}}</th>
                            <td>{{$item->full_name}}</td>
                            <td>{{$item->department_name}}</td>
                            <td>{{$item->account_type}}</td>
                            <td>
                                <a href="#" role="button" class="btn btn-sm btn-warning" title="Update User" wire:click="edit('{{ $item->user_id }}')">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none">
                                        <path d="M11 2H9C4 2 2 4 2 9v6c0 5 2 7 7 7h6c5 0 7-2 7-7v-2" stroke="#ffffff" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"></path>
                                        <path d="M16.04 3.02 8.16 10.9c-.3.3-.6.89-.66 1.32l-.43 3.01c-.16 1.09.61 1.85 1.7 1.7l3.01-.43c.42-.06 1.01-.36 1.32-.66l7.88-7.88c1.36-1.36 2-2.94 0-4.94-2-2-3.58-1.36-4.94 0Z" stroke="#ffffff" stroke-width="1.5" stroke-miterlimit="10" stroke-linecap="round" stroke-linejoin="round"></path>
                                        <path d="M14.91 4.15a7.144 7.144 0 0 0 4.94 4.94" stroke="#ffffff" stroke-width="1.5" stroke-miterlimit="10" stroke-linecap="round" stroke-linejoin="round"></path>
                                    </svg>
                                </a>
                                <a href="#" role="button" class="btn btn-sm btn-danger" title="Reset Password" wire:click="$emit('confirmResetPasswordAlert', '{{ $item->user_id }}')">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none">
                                        <path stroke="#ffffff" stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M22 12c0 5.52-4.48 10-10 10s-8.89-5.56-8.89-5.56m0 0h4.52m-4.52 0v5M2 12C2 6.48 6.44 2 12 2c6.67 0 10 5.56 10 5.56m0 0v-5m0 5h-4.44"></path>
                                    </svg>
                                </a>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="5">No data</td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
                {{ $users->links('livewire.custom-pagination.custom-pagination') }}
            </div>
        </div>
    </div>

    <!-- addUserModal -->
    <div wire:ignore.self class="modal fade" id="addUserModal" tabindex="-1" data-bs-backdrop="static" data-bs-keyboard="false" aria-labelledby="addUserModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content text-start">
                <div class="modal-header">
                    <h1 class="modal-title fs-5" id="addUserModalLabel">{{ !$editModal ? 'Add' : 'Edit' }} User</h1>
                    <button type="button" class="btn-close btn-light" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form wire:submit.prevent="{{ !$editModal ? 'save' : 'update' }}" class="row g-3" data-bitwarden-watching="1" novalidate>
                        <div class="col-md-6">
                            <label for="inputName5" class="form-label">First Name</label>
                            <input type="text" class="form-control @error('first_name') is-invalid @enderror" wire:model="first_name">
                            @error('first_name') <div class="invalid-feedback"> {{$message}} </div> @enderror
                        </div>
                        <div class="col-md-6">
                            <label for="inputName5" class="form-label">Middle Name</label>
                            <input type="text" class="form-control @error('middle_name') is-invalid @enderror" wire:model="middle_name">
                            @error('middle_name') <div class="invalid-feedback"> {{$message}} </div> @enderror
                        </div>
                        <div class="col-md-6">
                            <label for="inputName5" class="form-label">Last Name</label>
                            <input type="text" class="form-control @error('last_name') is-invalid @enderror" wire:model="last_name">
                            @error('last_name') <div class="invalid-feedback"> {{$message}} </div> @enderror
                        </div>
                        <div class="col-md-3">
                            <label for="inputName5" class="form-label">Extension Name</label>
                            <select class="form-select @error('extension') is-invalid @enderror" name="extension" id="extension" aria-label="extension" wire:model="extension">
                                <option value="" {{ old('extension') ? '' : 'selected' }}>Select...</option>

                                @php
                                // Function to convert Arabic numbers to Roman numerals
                                function arabicToRoman($num) {
                                $roman = '';
                                $lookup = array(
                                'L' => 50, 'XL' => 40, 'X' => 10, 'IX' => 9,
                                'V' => 5, 'IV' => 4, 'I' => 1
                                );

                                foreach ($lookup as $symbol => $value) {
                                while ($num >= $value) {
                                $roman .= $symbol;
                                $num -= $value;
                                }
                                }
                                return $roman;
                                }

                                // Loop for Jr. and Sr.
                                $suffixes = ['Jr.', 'Sr.'];
                                foreach ($suffixes as $suffix) {
                                echo "<option value=\"$suffix\" " . (old('extension') == $suffix ? 'selected' : '') . ">$suffix</option>";
                                }

                                // Loop for Roman numerals up to 50
                                for ($i = 1; $i <= 50; $i++) { $romanNumeral=arabicToRoman($i); echo "<option value=\" $romanNumeral\" " . (old('extension') == $romanNumeral ? 'selected' : '') . ">$romanNumeral</option>";
                                    }
                                    @endphp

                            </select>
                            @error('extension') <div class="invalid-feedback"> {{$message}} </div> @enderror
                        </div>
                        <div class="col-md-3">
                            <label for="sex" class="form-label">Sex</label>
                            <select class="form-select @error('sex') is-invalid @enderror" name="sex" id="sex" aria-label="sex" wire:model="sex">
                                <option value="">Choose...</option>
                                <option value="M">Male</option>
                                <option value="F">Female</option>
                            </select>
                            @error('sex') <div class="invalid-feedback"> {{$message}} </div> @enderror
                        </div>
                        <div class="col-12">
                            <label for="inputEmail5" class="form-label">
                                Username (Email)
                                <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24" fill="none" data-bs-toggle="tooltip" data-bs-placement="top" data-bs-title="Please enter only your username without the @ sign and the domain. Your username will be username@email.com.">
                                    <path d="M12 22c5.5 0 10-4.5 10-10S17.5 2 12 2 2 6.5 2 12s4.5 10 10 10ZM12 8v5" stroke="#697689" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"></path>
                                    <path d="M11.995 16h.009" stroke="#697689" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"></path>
                                </svg>
                            </label>
                            <div class="input-group">
                                <input type="text" class="form-control @error('email') is-invalid @enderror" aria-describedby="basic-addon2" wire:model="email">
                                <span class="input-group-text" id="basic-addon2">@email.com</span>
                                @error('email') <div class="invalid-feedback"> {{$message}} </div> @enderror
                            </div>
                        </div>
                        <div class="col-12">
                            <label for="inputAddress5" class="form-label">Department</label>
                            <select class="form-select @error('id_department') is-invalid @enderror" wire:model="id_department">
                                <option selected="">Choose...</option>
                                @foreach($departments as $item)
                                <option value="{{$item->id}}">{{$item->department_name}}</option>
                                @endforeach
                            </select>
                            @error('id_department') <div class="invalid-feedback"> {{$message}} </div> @enderror
                        </div>
                        <div class="col-12">
                            <label for="inputAddress2" class="form-label">User Role</label>
                            <select class="form-select @error('account_type') is-invalid @enderror" wire:model="account_type">
                                <option selected="">Choose...</option>
                                <option value="1">Admin</option>
                                <option value="2">Regular User</option>
                            </select>
                            @error('account_type') <div class="invalid-feedback"> {{$message}} </div> @enderror
                        </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-primary" style="background-color: #0A927C; border-color: #0A927C;">Save changes</button>
                    </form>
                </div>
            </div>
        </div>
    </div>

</div>