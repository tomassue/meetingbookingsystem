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
    <div wire:ignore.self class="modal fade" id="createBookMeetingModal" tabindex="-1" aria-labelledby="createBookMeetingModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h1 class="modal-title fs-5" id="createBookMeetingModalLabel">Meeting Details</h1>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body text-start">
                    <table class="table table-borderless">
                        <tr>
                            <th scope="col" width="10%">Date:</th>
                            <th><span class="text-uppercase fw-light">{{$start_date_time . ' - ' . $end_date_time}}</span></th>
                        </tr>
                        <tr>
                            <th scope="col" width="10%">To:</th>
                            <th>
                                <span class="text-uppercase fw-light">
                                    @if($attendees)
                                    @foreach($attendees as $item)
                                    <span class="fw-bold">{{ ($item->sex == 'M') ? 'Mr.' : 'Ms.' }}</span> {{ $item->full_name }} <br>
                                    @endforeach
                                    @endif
                                </span>
                            </th>
                        </tr>
                        <tr>
                            <th scope="col" width="10%">Re:</th>
                            <th><span class="text-uppercase fw-light">Subject</span></th>
                        </tr>
                        <tr>
                            <th></th>
                            <th><span class="fw-light">Contrary to popular belief, Lorem Ipsum is not simply random text. It has roots in a piece of classical Latin literature from 45 BC, making it over 2000 years old. Richard McClintock, a Latin professor at Hampden-Sydney College in Virginia, looked up one of the more obscure Latin words, consectetur, from a Lorem Ipsum passage, and going through the cites of the word in classical literature, discovered the undoubtable source. Lorem Ipsum comes from sections 1.10.32 and 1.10.33 of "de Finibus Bonorum et Malorum" (The Extremes of Good and Evil) by Cicero, written in 45 BC. This book is a treatise on the theory of ethics, very popular during the Renaissance. The first line of Lorem Ipsum, "Lorem ipsum dolor sit amet..", comes from a line in section 1.10.32. The standard chunk of Lorem Ipsum used since the 1500s is reproduced below for those interested. Sections 1.10.32 and 1.10.33 from "de Finibus Bonorum et Malorum" by Cicero are also reproduced in their exact original form, accompanied by English versions from the 1914 translation by H. Rackham.</span></th>
                        </tr>
                    </table>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    <button type="button" class="btn btn-primary">Save changes</button>
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