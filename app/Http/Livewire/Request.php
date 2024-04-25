<?php

namespace App\Http\Livewire;

use App\Models\TblBookedMeetingsModel;
use Illuminate\Support\Facades\DB;
use Livewire\Component;

class Request extends Component
{
    public function render()
    {
        $query = TblBookedMeetingsModel::select(
            'booking_no',
            DB::raw("DATE_FORMAT(start_date_time, '%b %d, %Y %h:%i%p') AS start"),
            DB::raw("DATE_FORMAT(end_date_time, '%b %d, %Y %h:%i%p') AS end"),
            'subject',
            'type_of_attendees'
        );

        $request = $query->get();
        return view('livewire.request', [
            'request'   =>  $request
        ]);
    }
}
