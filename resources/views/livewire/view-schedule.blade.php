<div>
    <div class="card mt-5">
        <form wire:submit.prevent="updateCalendar">
            <div class="row col-md-12 py-3 px-3 g-3">
                <div class="col-md-12 col-lg-6">
                    <div class="input-group">
                        <span class="input-group-text">Department</span>
                        <select class="form-select" wire:model="department">
                            <option value="" selected>Select...</option>
                            @foreach ($departments as $item)
                            <option value="{{ $item->id }}">{{ $item->department_name }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>

                <div class="col-md-12 col-lg-6">
                    <div class="input-group">
                        <span class="input-group-text">Search</span>
                        <input type="text" class="form-control" wire:model="search">
                    </div>
                </div>
            </div>

            <div class="row col-md-6 py-3 ps-3">
                <div class="col">
                    <div class="input-group">
                        <span class="input-group-text">From</span>
                        <input type="date" class="form-control" wire:model="from_date">
                    </div>
                </div>

                <div class="col">
                    <div class="input-group">
                        <span class="input-group-text">To</span>
                        <input type="date" class="form-control" wire:model="to_date">

                    </div>
                </div>
            </div>

            <div class="text-start p-3">
                <button type="submit" class="btn btn-success">Filter</button>
            </div>
        </form>
    </div>

    <!-- {{ dump($meetings) }} -->

    <div class="card" wire:ignore>
        <div id="wrap">
            <div id='calendar'></div>
            <div style='clear:both'></div>
        </div>
    </div>

    <!-- viewMeetingModal -->
    <div wire:ignore.self class="modal fade" id="viewMeetingModal" data-bs-backdrop="static" tabindex="-1" aria-labelledby="viewMeetingModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-scrollable modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h1 class="modal-title fs-5" id="viewMeetingModalLabel">Meeting Details</h1>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close" wire:click="clear"></button>
                </div>
                <div class="modal-body text-start">
                    <table class="table table-borderless">
                        <tr>
                            <th scope="col" width="10%">Date:</th>
                            <th><span class="fw-light">{{ $created_at_date }}</span></th>
                        </tr>
                        <tr>
                            <th scope="col" width="10%">Schedule:</th>
                            <th><span class="fw-light">{{ $start_date_time }} <br> {{ $end_date_time }}</span></th>
                        </tr>
                        <tr>
                            <th scope="col" width="10%">To:</th>
                            <th>
                                <span class="text-uppercase fw-bold fst-italic">{{ $type_of_attendees }}</span> <br><br>
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
                            <th scope="col" width="10%">Re:</th>
                            <th><span class="text-uppercase fw-light">{{ $subject }}</span></th>
                        </tr>
                        <tr>
                            <th></th>
                            <th><span class="fw-light">{{ $meeting_description }}</span></th>
                        </tr>
                    </table>

                    <!-- <hr> -->

                    <!-- <h1>SHOW MEMO HERE IF THERE'S ANY?</h1> -->

                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal" wire:click="clear">Close</button>
                </div>
            </div>
        </div>
    </div>

    <script>
        var meetings = @json($meetings);
    </script>

    <!-- Calendar Script -->
    @include('livewire.calendar-script.calendar-script-2')
</div>