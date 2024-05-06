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

    @if(session('success'))
    <div class="text-start alert alert-success alert-dismissible fade show" role="alert">
        {{ session('success') }}
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
    @endif

    <div class="card">
        <div id="wrap">
            <div id='calendar' wire:ignore></div>
            <div style='clear:both'></div>
        </div>
    </div>

    <!-- viewBookMeetingModal -->
    <div wire:ignore.self class="modal fade" id="viewBookMeetingModal" data-bs-backdrop="static" tabindex="-1" aria-labelledby="viewBookMeetingModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h1 class="modal-title fs-5" id="viewBookMeetingModalLabel">Meeting Details</h1>
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


                    <hr>

                    <div class="form-check form-switch mb-2">
                        <input class="form-check-input" type="checkbox" id="flexSwitchCheckDefault" wire:model="representative">
                        <label class="form-check-label" for="flexSwitchCheckDefault">Send a representative?</label>
                    </div>
                    <div class="col-md-12">
                        <label for="representative_name" class="form-label">Representative's Name</label>
                        <input type="text" class="form-control" id="representative_name" data-ddg-inputtype="identities.representative_name" wire:model="representative_name" @if(!$representative) disabled @endif>
                    </div>

                </div>
                <div class="modal-footer">
                    <a href="#" role="button" class="btn btn-primary" style="background-color: #0a927c; border-color:#0a927c" wire:click="confirmApproveMeeting">Accept {{ $feedback }}</a>
                    <a href="#" role="button" class="btn btn-danger" wire:click="confirmDeclineMeeting">Decline</a>
                    <!-- <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button> -->
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