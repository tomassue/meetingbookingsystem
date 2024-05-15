<div>
    <div class="card mt-5 text-start">

        <div class="card-body">

            <h5 class="card-title">Signatories</h5>

            @if(session('success'))
            <div class="alert alert-success alert-dismissible fade show" role="alert">
                <i class="bi bi-check-circle me-1"></i>
                {{session('success')}}
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
            @endif

            <div class="text-end">
                <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#addSignatoryModal" wire:click="clear">
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
                            <th scope="col">Full Name</th>
                            <th scope="col">Signature</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($signatories as $index => $item)
                        <tr>
                            <td>{{ $index+1 }}</td>
                            <td>{{ $item->full_name }}</td>
                            <td><img src="data:img/png;base64,{{base64_encode($item->signature)}}" alt="" class="img-fluid img-thumbnail" width="90"></td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <!-- addSignatoryModal -->
    <div wire:ignore.self class="modal fade" id="addSignatoryModal" tabindex="-1" data-bs-backdrop="static" data-bs-keyboard="false" aria-labelledby="addSignatoryModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content text-start">
                <div class="modal-header">
                    <h1 class="modal-title fs-5" id="addSignatoryModalLabel">{{ !$editModal ? 'Add' : 'Edit' }} a signatory</h1>
                    <button type="button" class="btn-close btn-light" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form wire:submit.prevent="{{!$editModal ? 'save' : 'update'}}" class="row g-3" data-bitwarden-watching="1">
                        <div class="col-md-12">
                            <label for="inputHonorifics" class="form-label">Honorifics</label>
                            <input type="text" class="form-control @error('honorifics') is-invalid @enderror" wire:model="honorifics">
                            @error('honorifics') <span class="invalid-feedback"> {{$message}} </span> @enderror
                        </div>
                        <div class="col-md-12">
                            <label for="inputFull_name" class="form-label">Full Name</label>
                            <input type="text" class="form-control @error('full_name') is-invalid @enderror" wire:model="full_name">
                            @error('full_name') <span class="invalid-feedback"> {{$message}} </span> @enderror
                        </div>
                        <div class="col-md-12 text-center" wire:loading wire:target="signature">
                            <div class="spinner-grow text-success" role="status">
                                <span class="visually-hidden">Loading...</span>
                            </div>
                        </div>
                        @if ($signature)
                        <div class="col-md-12" wire:loading.remove wire:target="signature">
                            <label for="preview" class="form-label">Signature Preview:</label>
                            <img src="{{ $signature->temporaryUrl() }}" class="img-thumbnail">
                        </div>
                        @endif
                        <div class="col-md-12">
                            <label for="uploadSignature" class="form-label">Upload signature</label>
                            <input type="file" class="form-control @error('signature') is-invalid @enderror" wire:model="signature">
                            @error('signature') <span class="invalid-feedback"> {{$message}} </span> @enderror
                        </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-primary" style="background-color: #0A927C; border-color: #0A927C;" wire:loading.attr="disabled" wire:target="signature">Save changes</button>
                </div>
                </form>
            </div>
        </div>
    </div>

</div>