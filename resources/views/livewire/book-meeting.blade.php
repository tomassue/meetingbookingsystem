<div>
    <div class="card mt-5 ">
        <div class="card-body">
            <h5 class="text-start text-uppercase card-title" style="color: #0A927C;">Book a Meeting</h5>

            @if(session('success'))
            <div class="alert alert-success alert-dismissible fade show" role="alert">
                <i class="bi bi-check-circle me-1"></i>
                {{session('success')}}
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
            @endif

            <form wire:submit.prevent="save" novalidate>
                <div class="row mt-3 p-3">
                    <div class="col-md-3">
                        <label for="start_date_time" class="form-label">Start Date</label>
                        <input type="datetime-local" class="form-control @error('start_date_time') is-invalid @enderror" wire:model="start_date_time">
                        @error('start_date_time')
                        <div class="invalid-feedback text-start">
                            <span>{{$message}}</span>
                        </div>
                        @enderror
                    </div>
                    <div class="col-md-3">
                        <label for="end_date_time" class="form-label">End Date</label>
                        <input type="datetime-local" class="form-control @error('end_date_time') is-invalid @enderror" wire:model="end_date_time">
                        @error('end_date_time')
                        <div class="invalid-feedback text-start">
                            <span>{{$message}}</span>
                        </div>
                        @enderror
                    </div>
                    <div class="col-md-6">
                        <label for="type_of_attendees" class="form-label">Type of Attendees</label>
                        <select id="type_of_attendees" class="form-select @error('type_of_attendees') is-invalid @enderror" wire:model="type_of_attendees">
                            <option selected>Choose...</option>
                            <option value="Department Heads">Department Head</option>
                            <option value="Assistant Head">Assistant Head</option>
                            <option value="Representative">Representative</option>
                        </select>
                        @error('type_of_attendees')
                        <div class="invalid-feedback text-start">
                            <span>{{$message}}</span>
                        </div>
                        @enderror
                    </div>
                </div>

                <div class="row mt-3 p-3">
                    <div class="col-12" wire:ignore>
                        <label for="attendees" class="form-label">Attendees</label>
                        <select class="form-select multiple @error('attendees') is-invalid @enderror" id="multiple-select" multiple="multiple" wire:loading.remove>
                            @foreach($users as $item)
                            <option value="{{ $item->id }}">{{ $item->department_name }}</option>
                            @endforeach
                        </select>
                    </div>
                    @error('attendees')
                    <div class="text-start">
                        <span style="color: red;">{{$message}}</span>
                    </div>
                    @enderror
                </div>

                <div class="row p-3">
                    <div class="col-md-6">
                        <label for="inputPassword5" class="form-label">Subject</label>
                        <input type="text" class="form-control @error('subject') is-invalid @enderror" wire:model="subject">
                        @error('subject')
                        <div class="invalid-feedback text-start">
                            <span>{{$message}}</span>
                        </div>
                        @enderror
                    </div>
                    <div class="col-md-6">
                        <div>
                            <label class="form-label">Attach File</label>
                        </div>
                        <div>
                            <input type="file" id="myFile" class="form-control @error('files') is-invalid @enderror" accept="application/pdf" wire:model="files" multiple hidden />
                            <label for="myFile" role="button" class="btn" style="background-color: #0A927C; border-color: #0A927C; color: #ffffff" wire:loading.remove wire:target="files" @if(!empty($files)) hidden @endif>
                                Upload file
                            </label>
                            @error('files')
                            <div class="invalid-feedback text-start">
                                <span>{{$message}}</span>
                            </div>
                            @enderror
                        </div>
                        <!-- Spinner -->
                        <br>
                        <div wire:loading wire:target="files">
                            <div class="spinner-border text-success" role="status">
                                <span class="visually-hidden">Loading...</span>
                            </div>
                        </div>
                        @if($files)
                        <table class="table table-borderless">
                            <thead>
                                <tr>
                                    <th scope="col">File Name</th>
                                    <th scope="col">Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($files as $index => $item)
                                <tr>
                                    <td>{{$item->getClientOriginalName()}}</td>
                                    <td>
                                        <a href="#" role="button" class="btn btn-danger btn-sm" wire:click="removeFile({{$index}})">
                                            <svg xmlns="http://www.w3.org/2000/svg" width="32" height="32" viewBox="0 0 24 24" fill="none">
                                                <path d="M21 5.98c-3.33-.33-6.68-.5-10.02-.5-1.98 0-3.96.1-5.94.3L3 5.98M8.5 4.97l.22-1.31C8.88 2.71 9 2 10.69 2h2.62c1.69 0 1.82.75 1.97 1.67l.22 1.3M18.85 9.14l-.65 10.07C18.09 20.78 18 22 15.21 22H8.79C6 22 5.91 20.78 5.8 19.21L5.15 9.14M10.33 16.5h3.33M9.5 12.5h5" stroke="#ffffff" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"></path>
                                            </svg>
                                        </a>
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                        @endif
                        @if($files)
                        <div>
                            <button type="button" class="btn btn-primary" style="background-color: #0A927C; border-color: #0A927C;" data-bs-toggle="modal" data-bs-target="#addNewFileModal">
                                <svg xmlns="http://www.w3.org/2000/svg" width="32" height="32" viewBox="0 0 24 24" fill="none">
                                    <path d="M12 22c5.5 0 10-4.5 10-10S17.5 2 12 2 2 6.5 2 12s4.5 10 10 10ZM8 12h8M12 16V8" stroke="#ffffff" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"></path>
                                </svg></button>
                        </div>
                        @endif
                    </div>
                </div>

                <div class="row p-3">
                    <div class="col-md-12">
                        <label for="inputPassword5" class="form-label">Meeting Discription</label>
                        <textarea class="form-control @error('meeting_description') is-invalid @enderror" style="height: 100px" spellcheck="false" wire:model="meeting_description"></textarea>
                        @error('meeting_description')
                        <div class="invalid-feedback text-start">
                            <span>{{$message}}</span>
                        </div>
                        @enderror
                    </div>
                </div>

                <div class="col-12 d-flex justify-content-center mb-2">
                    <button type="submit" class="btn btn-primary col-md-3" style="background-color: #0A927C; border-color: #0A927C; color: #ffffff">Book Meeting</button>
                </div>
            </form>
        </div>

        <!-- addNewFileModal -->
        <div wire:ignore.self class="modal fade" id="addNewFileModal" tabindex="-1" data-bs-backdrop="static" data-bs-keyboard="false" aria-labelledby="addNewFileModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-sm">
                <div class="modal-content text-start">
                    <div class="modal-header">
                        <h1 class="modal-title fs-5" id="addNewFileModalLabel">Additonal File</h1>
                        <button type="button" class="btn-close btn-light" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <form wire:submit.prevent="addAdditionalFile" class="row g-3" data-bitwarden-watching="1" novalidate>
                            <div class="col" wire:loading.remove wire:target="newFile">
                                <input type="file" class="form-control @error('newFile') is-invalid @enderror" accept="application/pdf" wire:model="newFile" multiple>
                                @error('newFile') <div class="invalid-feedback"> {{$message}} </div> @enderror
                            </div>
                            <div class="col text-center" wire:loading wire:target="newFile">
                                <div class="spinner-border text-success" role="status">
                                    <span class="visually-hidden">Loading...</span>
                                </div>
                            </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-primary" style="background-color: #0A927C; border-color: #0A927C;" wire:loading.attr="disabled">Add file</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

</div>

@push('scripts')
<script>
    // $(document).ready(function() {
    //     function formatState(state) {
    //         if (!state.id) {
    //             return state.text;
    //         }
    //         var isSelected = state.selected ? 'checked' : '';
    //         var $state = $(
    //             '<div class="option-content">' +
    //             '<input type="checkbox" class="checkbox-select2" ' + isSelected + ' />' +
    //             '<span class="text-start option-text">' + state.text + '</span>' +
    //             '</div>'
    //         );
    //         return $state;
    //     }

    //     function formatStateSelection(state) {
    //         if (!state.id) {
    //             return state.text;
    //         }
    //         // Only show the text without the checkbox in the selected option
    //         var $state = $(
    //             '<div class="option-content">' +
    //             '<span class="text-start option-text">' + state.text + '</span>' +
    //             '</div>'
    //         );
    //         return $state;
    //     }

    //     $(document).ready(function() {
    //         $('#multiple-select').select2({
    //             closeOnSelect: false,
    //             dropdownAutoWidth: true,
    //             width: '100%',
    //             templateResult: formatState,
    //             templateSelection: formatStateSelection
    //         });

    //         $('#multiple-select').on('change', function(e) {
    //             var selectedValues = [];
    //             $('#multiple-select option:selected').each(function() {
    //                 selectedValues.push($(this).val());
    //             });
    //             @this.set('attendees', selectedValues);
    //         });
    //     });

    // });

    $(document).ready(function() {
        function formatState(state) {
            if (!state.id) {
                return state.text;
            }
            var isSelected = $('#multiple-select').find('option[value="' + state.id + '"]').prop('selected') ? 'checked' : '';
            var $state = $(
                '<div class="option-content">' +
                '<input type="checkbox" class="checkbox-select2" ' + isSelected + ' />' +
                '<span class="text-start option-text">' + state.text + '</span>' +
                '</div>'
            );
            return $state;
        }

        function formatStateSelection(state) {
            if (!state.id) {
                return state.text;
            }
            var $state = $(
                '<div class="option-content">' +
                '<span class="text-start option-text">' + state.text + '</span>' +
                '</div>'
            );
            return $state;
        }

        $('#multiple-select').select2({
            closeOnSelect: false,
            dropdownAutoWidth: true,
            width: '100%',
            templateResult: formatState,
            templateSelection: formatStateSelection
        });

        // Update checkboxes on change event
        $('#multiple-select').on('change', function() {
            var selectedValues = [];

            $('#multiple-select option:selected').each(function() {
                selectedValues.push($(this).val());
            });
            @this.set('attendees', selectedValues);

            $('#multiple-select option').each(function() {
                var optionValue = $(this).val();
                var isSelected = $(this).prop('selected');
                $('.select2-results__option').each(function() {
                    var $option = $(this);
                    if ($option.attr('id') && $option.attr('id').endsWith(optionValue)) {
                        var $checkbox = $option.find('.checkbox-select2');
                        $checkbox.prop('checked', isSelected);
                    }
                });
            });
        });

        // Toggle the checkbox state and update the selection
        $(document).on('click', '.checkbox-select2', function(e) {
            e.stopPropagation();
            var $checkbox = $(this);
            var $option = $checkbox.closest('.select2-results__option');
            var optionValue = $option.attr('id').split('-').pop();

            if ($checkbox.is(':checked')) {
                $('#multiple-select').find('option[value="' + optionValue + '"]').prop('selected', true);
            } else {
                $('#multiple-select').find('option[value="' + optionValue + '"]').prop('selected', false);
            }

            $('#multiple-select').trigger('change');
        });
    });
</script>
@endpush

<style>
    /* .checkbox-select2 {
        margin-right: 10px;
    }

    .option-content {
        display: flex;
        align-items: center;
    } */

    /* Align the content inside the select2 container */
    /* .select2-container--default .select2-selection--multiple .select2-selection__choice {
        display: flex;
        align-items: center;
        justify-content: flex-start;
        padding: 0 5px;
        background-color: #e9ecef;
        border-radius: 4px;
        margin-right: 5px;
        margin-top: 5px;
    } */

    /* Style for the text within the selected option */
    /* .select2-container--default .select2-selection--multiple .select2-selection__choice .option-text {
        margin-right: auto;
    } */

    /* Ensure the close button is aligned properly */
    /* .select2-container--default .select2-selection--multiple .select2-selection__choice__remove {
        display: flex;
        align-items: center;
        margin-left: 5px;
    } */

    /* Align the content inside the dropdown options */
    /* .option-content {
        display: flex;
        align-items: center;
        justify-content: flex-start;
    }

    .checkbox-select2 {
        margin-right: 8px;
    }

    .option-text {
        flex-grow: 1;
    } */

    /* Align the content inside the select2 container */
    .select2-container--default .select2-selection--multiple .select2-selection__choice {
        display: flex;
        align-items: center;
        justify-content: flex-start;
        padding: 0 5px;
        background-color: #e9ecef;
        border-radius: 4px;
        margin-right: 5px;
        margin-top: 5px;
    }

    /* Style for the text within the selected option */
    .select2-container--default .select2-selection--multiple .select2-selection__choice .option-text {
        margin-right: auto;
    }

    /* Ensure the close button is aligned properly */
    .select2-container--default .select2-selection--multiple .select2-selection__choice__remove {
        display: flex;
        align-items: center;
        margin-left: 5px;
    }

    /* Align the content inside the dropdown options */
    .option-content {
        display: flex;
        align-items: center;
        justify-content: flex-start;
    }

    .checkbox-select2 {
        margin-right: 8px;
    }

    .option-text {
        flex-grow: 1;
    }
</style>