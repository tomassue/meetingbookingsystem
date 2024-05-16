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

    @if(session('success'))
    <div class="alert alert-success alert-dismissible fade show text-start" role="alert">
        {{ session('success') }}
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
    @endif

    <!-- <div class="card mt-2" style="margin-bottom: 13px;">
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
    </div> -->

    <div class="card">
        <div class="card-body" wire:ignore>
            <h5 class="card-title text-start fw-bold" style="color: #0A927C;">Meeting Requests</h5>

            <!-- Bordered Tabs Justified -->
            <ul class="nav nav-tabs nav-tabs-bordered d-flex" id="borderedTabJustified" role="tablist">
                <li class="nav-item flex-fill" role="presentation">
                    <button class="nav-link w-100 active" id="upcomingMeetings-tab" data-bs-toggle="tab" data-bs-target="#bordered-justified-upcomingMeetings" type="button" role="tab" aria-controls="upcomingMeetings" aria-selected="true">Upcoming Meetings</button>
                </li>
                <li class="nav-item flex-fill" role="presentation">
                    <button class="nav-link w-100" id="withMemo-tab" data-bs-toggle="tab" data-bs-target="#bordered-justified-withMemo" type="button" role="tab" aria-controls="withMemo" aria-selected="false" tabindex="-1">With Memo</button>
                </li>
            </ul>

            <div class="tab-content pt-2" id="borderedTabJustifiedContent">
                <div class="tab-pane fade active show" id="bordered-justified-upcomingMeetings" role="tabpanel" aria-labelledby="upcomingMeetings-tab">
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
                <div class="tab-pane fade" id="bordered-justified-withMemo" role="tabpanel" aria-labelledby="withMemo-tab">
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
                            @foreach($request2 as $item)
                            <tr wire:key="item-{{ $item->id_booking_no }}">
                                <td>
                                    {{ $item->id_booking_no }}
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
                                    <a href="#" role="button" data-bs-toggle="modal" data-bs-target="#memoModal" wire:click="generateMemo('{{ $item->id_booking_no }}')">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="22" height="22" class="bi bi-printer" viewBox="0 0 16 16">
                                            <path d="M2.5 8a.5.5 0 1 0 0-1 .5.5 0 0 0 0 1" />
                                            <path d="M5 1a2 2 0 0 0-2 2v2H2a2 2 0 0 0-2 2v3a2 2 0 0 0 2 2h1v1a2 2 0 0 0 2 2h6a2 2 0 0 0 2-2v-1h1a2 2 0 0 0 2-2V7a2 2 0 0 0-2-2h-1V3a2 2 0 0 0-2-2zM4 3a1 1 0 0 1 1-1h6a1 1 0 0 1 1 1v2H4zm1 5a2 2 0 0 0-2 2v1H2a1 1 0 0 1-1-1V7a1 1 0 0 1 1-1h12a1 1 0 0 1 1 1v3a1 1 0 0 1-1 1h-1v-1a2 2 0 0 0-2-2zm7 2v3a1 1 0 0 1-1 1H5a1 1 0 0 1-1-1v-3a1 1 0 0 1 1-1h6a1 1 0 0 1 1 1" />
                                        </svg>
                                    </a>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div><!-- End Bordered Tabs Justified -->
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
                    @elseif(!$files)
                    <p wire:loading.remove class="my-5">No files attached.</p>
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
                                    <span class="fw-bold">{{ ($item['sex'] == 'M') ? 'Mr.' : 'Ms.' }} {{ $item['full_name'] }}</span>,
                                    <span class="fst-italic fw-lighter">{{ $item['department_name'] }}</span>
                                    <span class="fst-italic">{{ $item['proxy'] ? '['.$item['proxy'].']' : '' }}</span>
                                    <br>
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
                                <span style="color: red;">{{ $message }}</span> <br>
                                @enderror
                                @error('booking_no')
                                <span style="color: red;">{{ $message }}</span>
                                @enderror
                            </th>
                        </tr>
                        <tr>
                            <th scope="col" width="10%">Signatory:</th>
                            <th>
                                <div wire:ignore>
                                    <select class="form-select @error('signatory') is-invalid @enderror" id="signatory-select">
                                        <option></option>
                                        @foreach($signatories as $item)
                                        <option value="{{ $item->id }}">{{ $item->honorifics . ' ' . $item->full_name }}</option>
                                        @endforeach
                                    </select>
                                </div>
                                @error('signatory')
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

    <!-- memoModal -->
    <div wire:ignore.self class="modal fade" id="memoModal" tabindex="-1" data-bs-backdrop="static" data-bs-keyboard="false" aria-labelledby="memoModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content text-start">
                <div class="modal-header">
                    <h1 class="modal-title fs-5" id="memoModalLabel">Generate Memo</h1>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close" wire:click="clear"></button>
                </div>
                <div class="modal-body">
                    <embed src="{{ $pdfMemo }}" type="application/pdf" width="100%" height="680px">
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal" wire:click="clear" wire:loading.attr="disabled">Close</button>
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
            tabsize: 2,
            height: 300,
            toolbar: [
                ['style', ['style']],
                ['font', ['bold', 'italic', 'underline', 'clear']],
                // ['fontname', ['fontname']], // Add font name option here
                ['color', ['color']],
                ['para', ['ul', 'ol', 'paragraph']],
                ['table', ['table']],
                ['insert', ['link', 'picture']],
                ['view', ['fullscreen', 'help']]
            ],
            // fontNames: ['Arial', 'Arial Black', 'Comic Sans MS', 'Courier New', 'Georgia', 'Impact', 'Lucida Console', 'Tahoma', 'Times New Roman', 'Trebuchet MS', 'Verdana'], // Define the font names here
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

        $('#signatory-select').select2({
            dropdownParent: $('#addMemoModal'),
            dropdownAutoWidth: true,
            width: '100%',
            placeholder: 'Select a signatory'
        });

        $('#signatory-select').on('change', function(e) {
            var selectedValue = $(this).val();
            @this.set('signatory', selectedValue); // If you're using Livewire or a similar framework, use @this.set or an equivalent method.
        });
    });
</script>
@endpush