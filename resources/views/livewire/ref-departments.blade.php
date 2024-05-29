<div>
    <div class="card mt-5 text-start">

        <div class="card-body">

            <h5 class="card-title" style="color: #0A927C;">Departments</h5>

            @if(session('success'))
            <div class="alert alert-success alert-dismissible fade show" role="alert">
                <i class="bi bi-check-circle me-1"></i>
                {{session('success')}}
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
            @endif

            <div class="text-end">
                <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#addDepartmentModal" wire:click="clear">
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
                            <th scope="col">Department</th>
                            <th scope="col">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($departments as $index => $item)
                        <tr wire:key="item-{{ $item->id }}">
                            <th scope="row">{{$index+1}}</th>
                            <td>{{$item->department_name}}</td>
                            <td>
                                <a href="#" role="button" class="btn btn-sm btn-warning" wire:click="edit('{{$item->id}}')">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none">
                                        <path d="M11 2H9C4 2 2 4 2 9v6c0 5 2 7 7 7h6c5 0 7-2 7-7v-2" stroke="#ffffff" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"></path>
                                        <path d="M16.04 3.02 8.16 10.9c-.3.3-.6.89-.66 1.32l-.43 3.01c-.16 1.09.61 1.85 1.7 1.7l3.01-.43c.42-.06 1.01-.36 1.32-.66l7.88-7.88c1.36-1.36 2-2.94 0-4.94-2-2-3.58-1.36-4.94 0Z" stroke="#ffffff" stroke-width="1.5" stroke-miterlimit="10" stroke-linecap="round" stroke-linejoin="round"></path>
                                        <path d="M14.91 4.15a7.144 7.144 0 0 0 4.94 4.94" stroke="#ffffff" stroke-width="1.5" stroke-miterlimit="10" stroke-linecap="round" stroke-linejoin="round"></path>
                                    </svg>
                                </a>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="3">No data</td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
                {{ $departments->links('livewire.custom-pagination.custom-pagination') }}
            </div>
        </div>
    </div>

    <!-- addDepartmentModal -->
    <div wire:ignore.self class="modal fade" id="addDepartmentModal" tabindex="-1" data-bs-backdrop="static" data-bs-keyboard="false" aria-labelledby="addDepartmentModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content text-start">
                <div class="modal-header">
                    <h1 class="modal-title fs-5" id="addDepartmentModalLabel">{{ !$editModal ? 'Add' : 'Edit' }} department</h1>
                    <button type="button" class="btn-close btn-light" data-bs-dismiss="modal" aria-label="Close" wire:click="clear"></button>
                </div>
                <div class="modal-body">
                    <form wire:submit.prevent="{{!$editModal ? 'save' : 'update'}}" class="row g-3" data-bitwarden-watching="1">
                        <div class="col-md-12">
                            <label for="inputName5" class="form-label">Department Name</label>
                            <input type="text" class="form-control @error('department_name') is-invalid @enderror" wire:model="department_name">
                            @error('department_name') <span class="invalid-feedback"> {{$message}} </span> @enderror
                        </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal" wire:click="clear">Close</button>
                    <button type="submit" class="btn btn-primary" style="background-color: #0A927C; border-color: #0A927C;">Save changes</button>
                </div>
                </form>
            </div>
        </div>
    </div>

</div>