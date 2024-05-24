<div>
    <div class="card mt-5">
        <form wire:submit.prevent="updateCalendar">
            <div class="row p-3">
                <div class="col">
                    <div class="input-group">
                        <span class="input-group-text text-white">From</span>
                        <input type="date" class="form-control" wire:model="from_date">
                    </div>
                </div>

                <div class="col">
                    <div class="input-group">
                        <span class="input-group-text text-white">To</span>
                        <input type="date" class="form-control" wire:model="to_date">

                    </div>
                </div>
                <div class="col">
                    <button type="submit" class="btn btn-success">Filter</button>
                </div>
            </div>
        </form>
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
        <div class="modal-dialog modal-dialog-scrollable modal-lg">
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

                    @if($feedback == 0 && Auth::user()->account_type !== 0)
                    <hr>
                    <div class="form-check form-switch mb-2">
                        <input class="form-check-input" type="checkbox" id="flexSwitchCheckDefault" wire:model="representative">
                        <label class="form-check-label" for="flexSwitchCheckDefault">Send a representative?</label>
                    </div>
                    <div class="col-md-12">
                        <label for="representative_name" class="form-label">Representative's Name</label>
                        <input type="text" class="form-control" id="representative_name" data-ddg-inputtype="identities.representative_name" wire:model="representative_name" @if(!$representative) disabled @endif>
                    </div>
                    @endif

                </div>
                <div class="modal-footer">
                    @if($feedback == 0 && Auth::user()->account_type !== 0)
                    <a href="#" role="button" class="btn btn-primary" style="background-color: #0a927c; border-color:#0a927c" wire:click="confirmApproveMeeting">Accept</a>
                    <a href="#" role="button" class="btn btn-danger" wire:click="confirmDeclineMeeting">Decline</a>
                    @elseif($feedback == 1 && Auth::user()->account_type !== 0)
                    <span class="badge rounded-pill bg-success">You already responded to this meeting.</span>
                    @elseif( Auth::user()->account_type == 0)
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal" wire:click="clear">Close</button>
                    @endif
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