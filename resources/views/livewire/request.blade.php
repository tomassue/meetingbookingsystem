<div>

    <div class="card mt-5">
        <div class="row m-3">
            <div class="col-lg-6">
                <div class="input-group">
                    <span class="input-group-text">Search</span>
                    <input type="text" class="form-control">
                </div>
            </div>
        </div>
    </div>

    <div class="card mt-2" style="margin-bottom: 13px;">
        <div class="m-3">
            <table class="table table-borderless" style="margin-bottom: 0px;">
                <thead>
                    <tr>
                        <th scope="col" width="10%">Booking No.</th>
                        <th scope="col">Meeting Date & Time</th>
                        <th scope="col">Subject</th>
                        <th scope="col">Type of Attendees</th>
                        <th scope="col">Attached File</th>
                        <th scope="col">Memo</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($request as $item)
                    <tr wire:key="item-{{ $item->booking_no }}">
                        <td>{{ $item->booking_no }}</td>
                        <td width="15%">{{ $item->start }}<br>{{ $item->end }}</td>
                        <td>{{ $item->subject }}</td>
                        <td>{{ $item->type_of_attendees }}</td>
                        <td width="9%">
                            <a href="#" role="button">
                                <img src="{{asset('images/file-plus.png')}}" alt="attach-file">
                            </a>
                        </td>
                        <td width="5%">
                            <a href="#" role="button">
                                <img src="{{asset('images/file-text.png')}}" alt="attach-file">
                            </a>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>

</div>