<div>
    <div class="card mt-5">
        <div class="row col-md-12 py-3 px-3 g-3">
            <div class="col-md-12 col-lg-6">
                <div class="input-group">
                    <span class="input-group-text">Department</span>
                    <select class="form-select">
                        <option>Test</option>
                        <option>Sample</option>
                    </select>
                </div>
            </div>

            <div class="col-md-12 col-lg-6">
                <div class="input-group">
                    <span class="input-group-text">Search</span>
                    <input type="text" class="form-control">
                </div>
            </div>
        </div>

        <div class="row col-md-6 py-3 ps-3">
            <div class="col">
                <div class="input-group">
                    <span class="input-group-text">From</span>
                    <input type="date" class="form-control">
                </div>
            </div>

            <div class="col">
                <div class="input-group">
                    <span class="input-group-text">To</span>
                    <input type="date" class="form-control">

                </div>
            </div>
        </div>

        <div class="text-start p-3">
            <button type="submit" class="btn btn-success">FIlter</button>
        </div>
    </div>

    <div class="card" wire:ignore>
        <div id="wrap">
            <div id='calendar'></div>
            <div style='clear:both'></div>
        </div>
    </div>

    <!-- Calendar Script -->
    @include('livewire.calendar-script.calendar-script-2')
</div>