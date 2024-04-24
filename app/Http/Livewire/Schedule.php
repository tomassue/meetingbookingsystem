<?php

namespace App\Http\Livewire;

use App\Models\TblBookedMeetingsModel;
use App\Models\User;
use Carbon\Carbon;
use DateTime;
use Illuminate\Support\Facades\DB;
use Livewire\Component;

class Schedule extends Component
{
    public $booked_meetings;

    # Event Details
    public $start_date_time, $end_date_time, $attendees = [], $subject, $meeting_description;

    # Listens for an event and proceed to the method.
    protected $listeners = ['createBookMeetingModal' => 'viewMeetingDetails'];

    public function render()
    {
        # Fetch data from DB
        $TblBookedMeetingsModel = TblBookedMeetingsModel::all();
        $this->booked_meetings = $TblBookedMeetingsModel->map(function ($meetings) {
            $start_date_time = Carbon::parse($meetings->start_date_time)->toIso8601String();
            $end_date_time = Carbon::parse($meetings->end_date_time)->toIso8601String();
            return [
                'id'    => $meetings->id,
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

    public function viewMeetingDetails(TblBookedMeetingsModel $id)
    {
        $start_datetime = new DateTime($id->start_date_time);
        $end_datetime = new DateTime($id->end_date_time);

        $e_attendees = explode(',', $id->attendees);
        foreach ($e_attendees as $item) {
            $query = User::where('id', $item)
                ->select(
                    DB::raw("CONCAT(first_name, COALESCE(middle_name, ''), ' ',last_name, IF(extension IS NOT NULL, CONCAT(', ', extension), '')) as full_name"),
                    'sex'
                )
                ->first(); // Using first() to get a single result
            if ($query) {
                $this->attendees[] = $query;
            }
        }
        $this->start_date_time = $start_datetime->format('M d, Y h:i A');
        $this->end_date_time = $end_datetime->format('M d, Y h:i A');
        $this->subject = $id->subject;
        $this->meeting_description = $id->meeting_description;
    }
}
