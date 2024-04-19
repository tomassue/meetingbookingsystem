<div>
    <div class="card mt-5 ">
        <div class="card-body">
            <h5 class="text-start card-title">DILI NA NI SIYA MANUAL.</h5>

            <form wire:submit.prevent="save">
                <div class="row mt-3 p-3">
                    <div class="col-md-3">
                        <label for="start_date_time" class="form-label">Start Date</label>
                        <input type="datetime-local" class="form-control" wire:model="start_date_time">
                    </div>
                    <div class="col-md-3">
                        <label for="end_date_time" class="form-label">End Date</label>
                        <input type="datetime-local" class="form-control" wire:model="end_date_time">
                    </div>
                    <div class="col-md-6">
                        <label for="type_of_attendees" class="form-label">Type of Attendees</label>
                        <select id="type_of_attendees" class="form-select" wire:model="type_of_attendees">
                            <option selected>Choose...</option>
                            <option value="Department Heads">Department Heads</option>
                            <option value="Department Shoulders">Department Shoulders</option>
                            <option value="Department Knees">Department Knees</option>
                            <option value="Department Toes">Department Toes</option>
                        </select>
                    </div>
                </div>

                <div class="row mt-3 p-3">
                    <div class="col-12" wire:ignore>
                        <label for="attendees" class="form-label">Attendees</label>
                        <select class="form-select multiple" id="multiple-select" multiple="multiple">
                            @foreach($users as $item)
                            <option value="{{ $item->id }}">{{ $item->full_name . ' - ' . $item->id_department }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>

                <div class="row p-3">
                    <div class="col-md-6">
                        <label for="inputPassword5" class="form-label">Subject</label>
                        <input type="text" class="form-control" wire:model="subject">
                    </div>
                    <div class="col-md-6">
                        <label class="form-label">Attach File</label>
                        <input type="file" class="form-control" wire:model="file">
                    </div>
                </div>

                <div class="row p-3">
                    <div class="col-md-6">
                        <label for="inputPassword5" class="form-label">Meeting Discription</label>
                        <input type="text" class="form-control" wire:model="meeting_description">
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
            $('#multiple-select').select2();

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