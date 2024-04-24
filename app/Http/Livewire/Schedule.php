<?php

namespace App\Http\Livewire;

use App\Models\TblBookedMeetingsModel;
use Carbon\Carbon;
use Livewire\Component;

class Schedule extends Component
{
    public $booked_meetings;

    public function render()
    {
        # Fetch data from DB
        $TblBookedMeetingsModel = TblBookedMeetingsModel::all();
        $this->booked_meetings = $TblBookedMeetingsModel->map(function ($meetings) {
            $start_date_time = Carbon::parse($meetings->start_date_time)->toIso8601String();
            $end_date_time = Carbon::parse($meetings->end_date_time)->toIso8601String();
            return [
                'title' => $meetings->subject,
                'start' => $start_date_time,
                'end'   => $end_date_time,
                'allDay' => false,
                'backgroundColor' => '#0a927c',
                'textColor' => '#ffffff'
            ];
        });
        return view('livewire.schedule', [
            'booked_meetings'   =>  $this->booked_meetings
        ]);
    }
}
