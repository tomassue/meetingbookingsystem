<div>
    <div class="card mt-5">

        <div class="row p-3">
            <div class="col">
                <div class="input-group">
                    <span class="input-group-text text-white">From</span>
                    <input type="date" class="form-control">
                </div>
            </div>

            <div class="col">
                <div class="input-group">
                    <span class="input-group-text text-white">To</span>
                    <input type="date" class="form-control">

                </div>
            </div>

            <div class="col">
                <button type="submit" class="btn btn-success">Filter</button>
            </div>
        </div>

    </div>

    <div class="card">
        <div id="wrap">
            <div id='calendar'></div>
            <div style='clear:both'></div>
        </div>
    </div>

    <!-- createBookMeetingModal -->
    <div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h1 class="modal-title fs-5" id="exampleModalLabel">Modal title</h1>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    ...
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    <button type="button" class="btn btn-primary">Save changes</button>
                </div>
            </div>
        </div>
    </div>

    <!-- Calendar Script -->
    @include('livewire.calendar-script.calendar-script')

</div>