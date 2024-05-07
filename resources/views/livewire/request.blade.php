<div>
    <style>
        .select2-container--open .select2-dropdown {
            z-index: 9999;
            /**increasing the z-index of the Select2 dropdown to ensure it appears above the modal. */
        }
    </style>

    <div class="card mt-5">
        <div class="row m-3">
            <div class="col-lg-6">
                <div class="input-group">
                    <span class="input-group-text text-white">Search</span>
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
                            <a href="#" role="button" data-bs-toggle="modal" data-bs-target="#addMemoModal" wire:click="memo('{{ $item->booking_no }}')">
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
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close" wire:click="hideAttachedFileModal"></button>
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
                    <div class="my-5 py-5" wire:loading>
                        <div class="spinner-grow text-success" role="status">
                            <span class="visually-hidden">Loading...</span>
                        </div>
                    </div>
                    @if($previewFile)
                    <div wire:loading.remove>
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
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close" wire:click="clear"></button>
                </div>
                <div class="modal-body">
                    <table class="table table-borderless">
                        <tr>
                            <th scope="col" width="10%">Date:</th>
                            <th><span class="fw-light">{{ $created_at_date }}</span></th>
                        </tr>
                        <tr>
                            <th scope="col" width="10%">Attendees:</th>
                            <th>
                                <span class="text-uppercase fw-light">
                                    @if($attendees)
                                    @foreach($attendees as $item)
                                    <span class="fw-bold">{{ ($item['sex'] == 'M') ? 'Mr.' : 'Ms.' }} {{ $item['full_name'] }}</span>, <span class="fst-italic fw-lighter">{{ $item['department_name'] }}</span> <br>
                                    @endforeach
                                    @endif
                                </span>
                            </th>
                        </tr>
                        <tr>
                            <th scope="col" width="10%">Subject:</th>
                            <th><span class="text-uppercase fw-light">{{ $subject }}</span></th>
                        </tr>
                        <tr>
                            <th scope="col" width="10%">Message:</th>
                            <th>
                                <div wire:ignore>
                                    <textarea class="form-control note-editable" id="memo_message" wire:model="memo_message"></textarea>
                                    <!-- <textarea wire:model="memo_message"></textarea> -->
                                </div>
                                @error('memo_message')
                                <span style="color: red;">{{ $message }}</span>
                                @enderror
                            </th>
                        </tr>
                    </table>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal" wire:click="clear" wire:loading.attr="disabled">Close</button>
                    <button type="button" class="btn btn-primary" style="background-color: #0A927C; border-color: #0A927C;" wire:click="saveMemo" wire:loading.attr="disabled">Add Memo</button>
                    <div class="spinner-grow text-success" role="status" wire:loading wire:target="saveMemo">
                        <span class="visually-hidden">Loading...</span>
                    </div>
                </div>
            </div>
        </div>
    </div>

</div>

@push('scripts')
<!-- Summernote initialization script -->
<script>
    $(document).ready(function() {
        $('#memo_message').summernote({
            placeholder: '...',
            tabsize: 2,
            height: 300,
            toolbar: [
                ['style', ['style']],
                ['font', ['bold', 'italic', 'underline', 'clear']],
                ['fontname', ['fontname']], // Add font name option here
                ['color', ['color']],
                ['para', ['ul', 'ol', 'paragraph']],
                ['table', ['table']],
                ['view', ['fullscreen', 'help']]
            ],
            fontNames: ['Arial', 'Arial Black', 'Comic Sans MS', 'Courier New', 'Georgia', 'Impact', 'Lucida Console', 'Tahoma', 'Times New Roman', 'Trebuchet MS', 'Verdana'], // Define the font names here
            callbacks: {
                onChange: function(contents, $editable) {
                    @this.set('memo_message', contents);
                }
            }
        });

        $('.note-editable').css({
            'font-weight': 'normal',
            'background-color': 'white'
        });
    });
</script>
@endpush