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

    <div class="card" wire:ignore>
        <div id="wrap">
            <div id='calendar'></div>
            <div style='clear:both'></div>
        </div>
    </div>

    <!-- createBookMeetingModal -->
    <div wire:ignore.self class="modal fade" id="createBookMeetingModal" data-bs-backdrop="static" tabindex="-1" aria-labelledby="createBookMeetingModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h1 class="modal-title fs-5" id="createBookMeetingModalLabel">Meeting Details</h1>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close" wire:click="closeMeetingDetails"></button>
                </div>
                <div class="modal-body text-start">
                    <table class="table table-borderless">
                        <tr>
                            <th scope="col" width="10%">Date:</th>
                            <th><span class="fw-light">{{$start_date_time . ' - ' . $end_date_time}}</span></th>
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
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal" wire:click="closeMeetingDetails">Close</button>
                    <!-- <button type="button" class="btn btn-primary">Save changes</button> -->
                </div>
            </div>
        </div>
    </div>

    <script>
        var booked_meetings = @json($booked_meetings); // Convert booked_meetings array to JSON
    </script>

    <!-- Calendar Script -->
    @include('livewire.calendar-script.calendar-script')

</div>