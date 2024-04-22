<div>
    <div class="card mt-5 ">
        <div class="card-body">
            <h5 class="text-start card-title">DILI NA NI SIYA MANUAL.</h5>

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
                            <option value="Department Heads">Department Heads</option>
                            <option value="Department Shoulders">Department Shoulders</option>
                            <option value="Department Knees">Department Knees</option>
                            <option value="Department Toes">Department Toes</option>
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
                        <select class="form-select multiple @error('attendees') is-invalid @enderror" id="multiple-select" multiple="multiple">
                            @foreach($users as $item)
                            <option value="{{ $item->id }}">{{ $item->full_name . ' - ' . $item->department_name }}</option>
                            @endforeach
                        </select>
                        @error('attendees')
                        <div class="invalid-feedback text-start">
                            <span>{{$message}}</span>
                        </div>
                        @enderror
                    </div>
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
                        <label class="form-label">Attach File</label>
                        <input type="file" class="form-control @error('files') is-invalid @enderror" wire:model="files" wire:loading.remove wire:target="files">
                        @error('files')
                        <div class="invalid-feedback text-start">
                            <span>{{$message}}</span>
                        </div>
                        @enderror
                        <!-- Spinner -->
                        <br>
                        <div wire:loading wire:target="files">
                            <div class="spinner-border text-success" role="status">
                                <span class="visually-hidden">Loading...</span>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="row p-3">
                    <div class="col-md-12">
                        <label for="inputPassword5" class="form-label">Meeting Discription</label>
                        <!-- <input type="text" class="form-control" wire:model="meeting_description"> -->
                        <textarea class="form-control @error('meeting_description') is-invalid @enderror" style="height: 100px" spellcheck="false" wire:model="meeting_description"></textarea>
                        @error('meeting_description')
                        <div class="invalid-feedback text-start">
                            <span>{{$message}}</span>
                        </div>
                        @enderror
                    </div>
                </div>

                <div class="col-12 d-flex justify-content-center mb-2">
                    <button type="submit" class="btn btn-primary col-md-3">Book Meeting</button>
                </div>
            </form>
        </div>
    </div>

    <script>
        $(document).ready(function() {
            $('#multiple-select').select2({
                dropdownAutoWidth: true,
                width: '100%'
            });

            $('#multiple-select').on('change', function(e) {
                var selectedValues = [];
                $('#multiple-select option:selected').each(function() {
                    selectedValues.push($(this).val());
                    // console.log(typeof selectedValues);
                });
                @this.set('attendees', selectedValues);
            });
        });
    </script>
</div>