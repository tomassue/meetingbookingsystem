<div>

    <div class="card mt-5">
        <div class="row m-3">
            <div class="col-lg-6">
                <div class="input-group">
                    <span class="input-group-text">Search</span>
                    <input type="text" class="form-control">
                </div>
            </div>
        </div>
    </div>

    <div class="card mt-2" style="margin-bottom: 13px;">
        <div class="m-3">
            <table class="table table-borderless" style="margin-bottom: 0px;">
                <thead>
                    <tr>
                        <th class="fs-6" scope="col" width="10%" style="align-content: baseline;">Booking No.</th>
                        <th class="fs-6" scope="col">Meeting Date <br> & Time</th>
                        <th class="fs-6" scope="col" style="align-content: center;">Subject</th>
                        <th class="fs-6" scope="col" width="15%">Type of <br> Attendees</th>
                        <th class="fs-6" scope="col">Attached <br> File</th>
                        <th class="fs-6" scope="col" style="align-content: baseline;">Memo</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($request as $item)
                    <tr wire:key="item-{{ $item->booking_no }}">
                        <td>
                            {{ $item->booking_no }}
                        </td>
                        <td width="15%">
                            <span class="text-lowercase">
                                {{ $item->start }}<br>{{ $item->end }}
                            </span>
                        </td>
                        <td>
                            {{ $item->subject }}
                        </td>
                        <td>
                            <span class="badge bg-primary" style="background-color: #0a927c !important;">
                                {{ $item->type_of_attendees }}
                            </span>
                        </td>
                        <td width="9%">
                            <a href="#" role="button" data-bs-toggle="modal" data-bs-target="#attachedFileModal" wire:click="viewAttachedFile('{{ $item->id_file_data }}')">
                                <img src="{{asset('images/file-plus.png')}}" alt="attach-file">
                            </a>
                        </td>
                        <td width="5%">
                            <a href="#" role="button" data-bs-toggle="modal" data-bs-target="#addMemoModal" wire:click="addMemo('{{ $item->booking_no }}')">
                                <img src="{{asset('images/file-text.png')}}" alt="attach-file">
                            </a>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>

    <!-- attachedFileModal -->
    <div wire:ignore.self class="modal fade" id="attachedFileModal" data-bs-backdrop="static" tabindex="-1" aria-labelledby="attachedFileModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-scrollable modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h1 class="modal-title fs-5" id="attachedFileModalLabel">Attached File</h1>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close" wire:click="hideAttachedFileModal"></button>
                </div>
                <div class="modal-body text-center">
                    @if($files)
                    <table class="table table-borderless">
                        <thead>
                            <tr>
                                <th scope="col">File Name</th>
                                <th scope="col">Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($files as $item)
                            <tr wire:key="item-{{ $item['id'] }}">
                                <td>{{ $item['file_name'] }}</td>
                                <td>
                                    <a href="#" role="button" class="btn btn-primary btn-sm" style="background-color: #0a927c !important; border-color:#0a927c;" wire:click="previewAttachedFile({{ $item['id'] }})">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none">
                                            <path d="M15.58 12c0 1.98-1.6 3.58-3.58 3.58S8.42 13.98 8.42 12s1.6-3.58 3.58-3.58 3.58 1.6 3.58 3.58Z" stroke="#ffffff" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"></path>
                                            <path d="M12 20.27c3.53 0 6.82-2.08 9.11-5.68.9-1.41.9-3.78 0-5.19-2.29-3.6-5.58-5.68-9.11-5.68-3.53 0-6.82 2.08-9.11 5.68-.9 1.41-.9 3.78 0 5.19 2.29 3.6 5.58 5.68 9.11 5.68Z" stroke="#ffffff" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"></path>
                                        </svg>
                                    </a>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                    @endif
                    @if($previewFile)
                    <div>
                        <embed src="data:application/pdf;base64,{{ $previewFile }}" title="{{ $title }}" type="application/pdf" style="height: 70vh; width: 100%;">
                    </div>
                    @endif
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal" wire:click="hideAttachedFileModal">Close</button>
                    <!-- <button type="button" class="btn btn-primary">Save changes</button> -->
                </div>
            </div>
        </div>
    </div>

    <!-- addMemoModal -->
    <div wire:ignore.self class="modal fade" id="addMemoModal" tabindex="-1" data-bs-backdrop="static" data-bs-keyboard="false" aria-labelledby="addMemoModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content text-start">
                <div class="modal-header">
                    <h1 class="modal-title fs-5" id="addMemoModalLabel">Add Memo</h1>
                    <button type="button" class="btn-close btn-light" data-bs-dismiss="modal" aria-label="Close" wire:click="clear"></button>
                </div>
                <div class="modal-body">
                    <form wire:submit.prevent="addMemo" data-bitwarden-watching="1" novalidate>
                        <div class="row mb-3">
                            <label for="Date" class="col-sm-2 col-form-label">
                                Date
                                <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24" fill="none" data-bs-toggle="tooltip" data-bs-placement="right" data-bs-original-title="The date is based on when the request is created.">
                                    <path d="M12 22c5.5 0 10-4.5 10-10S17.5 2 12 2 2 6.5 2 12s4.5 10 10 10ZM12 8v5" stroke="#555555" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"></path>
                                    <path d="M11.995 16h.009" stroke="#555555" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"></path>
                                </svg>
                            </label>
                            <div class="col-sm-10">
                                <input type="date" class="form-control" wire:model="created_at_date" readonly>
                            </div>
                        </div>
                        <div class="row mb-3">
                            <label for="inputEmail3" class="col-sm-2 col-form-label">Attendees</label>
                            <div class="col-sm-10" wire:ignore>
                                <select class="form-select multiple @error('attendees') is-invalid @enderror" id="multiple-select2" multiple="multiple" wire:loading.remove>
                                    @foreach($users as $item)
                                    <option value="{{ $item->id }}">{{ $item->full_name . ' - ' . $item->department_name }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="row mb-3">
                            <label for="inputSubject" class="col-sm-2 col-form-label">Subject</label>
                            <div class="col-sm-10">
                                <input type="text" class="form-control" wire:model="subject">
                            </div>
                        </div>
                        <div class="row mb-3">
                            <label for="inputPassword3" class="col-sm-2 col-form-label">Message</label>
                            <div class="col-sm-10">
                                <textarea class="form-control" style="height: 190px" spellcheck="false" wire:model="message"></textarea>
                            </div>
                        </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal" wire:click="clear">Close</button>
                    <button type="submit" class="btn btn-primary" style="background-color: #0A927C; border-color: #0A927C;" wire:loading.attr="disabled">Add Memo</button>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <script>
        $(document).ready(function() {
            $('#multiple-select2').select2({
                dropdownAutoWidth: true,
                width: '100%'
            });

            $('#multiple-select2').on('change', function(e) {
                var selectedValues = [];
                $('#multiple-select2 option:selected').each(function() {
                    selectedValues.push($(this).val());
                    // console.log(typeof selectedValues);
                });
                @this.set('attendees', selectedValues);
            });
        });
    </script>

</div>