<?php

namespace App\Http\Livewire;

use App\Models\TblAttendeesModel;
use App\Models\TblBookedMeetingsModel;
use App\Models\TblMeetingFeedbackModel;
use App\Models\User;
use Carbon\Carbon;
use DateTime;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Livewire\Component;

class Schedule extends Component
{
    public $booked_meetings;

    # Event Details
    public $id_booked_meeting, $created_at_date, $start_date_time, $end_date_time, $type_of_attendees, $attendees, $subject, $meeting_description, $representative = false, $representative_name, $attendee, $feedback;

    // wire:model [filter]
    public $from_date, $to_date;

    # Listens for an event and proceed to the method.
    protected $listeners = [
        'viewBookMeetingModal' => 'viewMeetingDetails',
        'approveMeeting'       => 'approveMeeting',
        'declineMeeting'       => 'declineMeeting'
    ];

    public function render()
    {
        # Fetch data from DB and display it to fullcalendar
        if (Auth::user()->account_type == 0) {
            $TblBookedMeetingsQuery = TblBookedMeetingsModel::query();

            if ($this->from_date) {
                $fromDate = Carbon::parse($this->from_date)->startOfDay();
                $TblBookedMeetingsQuery->where('start_date_time', '>=', $fromDate);
            }

            if ($this->to_date) {
                $toDate = Carbon::parse($this->to_date)->endOfDay();
                $TblBookedMeetingsQuery->where('end_date_time', '<=', $toDate);
            }

            //* Fetch the filtered results
            $TblBookedMeetingsModel = $TblBookedMeetingsQuery->get();
        } else {
            $id_attendees = Auth::user()->id;

            $TblBookedMeetingsQuery = TblBookedMeetingsModel::join('tbl_attendees', 'tbl_attendees.id_booking_no', '=', 'tbl_booked_meetings.booking_no')
                ->join('users', 'users.id', '=', 'tbl_attendees.id_users')
                ->where('tbl_attendees.id_users', $id_attendees);

            //* Fetch the filtered results
            $TblBookedMeetingsModel = $TblBookedMeetingsQuery->get();
        }

        $this->booked_meetings = $TblBookedMeetingsModel->map(function ($meetings) {
            $start_date_time = Carbon::parse($meetings->start_date_time)->toIso8601String();
            $end_date_time = Carbon::parse($meetings->end_date_time)->toIso8601String();
            return [
                'id'    => $meetings->booking_no,
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

    public function clear()
    {
        # booted() runs on every request, after the component is mounted or hydrated, but before any update methods are called
        # We'll have to reset this property since it holds the data we are using for displaying the meeting details.
        # Changed it from booted() since there are other requests that are being done. Such as the feedback.
        //// $this->reset('attendees', 'representative', 'representative_name', 'feedback');
        $this->reset();
    }

    public function updateCalendar()
    {
        // Emit an event with a parameter to trigger JavaScript to refresh the calendar.
        $this->emit('refreshCalendar2', json_encode($this->booked_meetings));
    }

    public function updatedRepresentative()
    {
        # When the $representative is updated, it will clear the $representative_name value.
        $this->reset('representative_name');
    }

    public function approveMeeting()
    {
        TblMeetingFeedbackModel::create([
            'id_booking_no' =>  $this->id_booked_meeting,
            'attendee'   =>  $this->attendee,
            'meeting_status'    =>  1, # Accepted
            'proxy' =>  $this->representative_name
        ]);
        $this->emit('hideviewBookMeetingModal');
        session()->flash('success', 'You successfully approved the meeting.');
        $this->reset('id_booked_meeting', 'attendee', 'representative_name');
        return redirect()->route('schedule');
    }

    public function confirmApproveMeeting()
    {
        $this->emit('showApproveConfirmationAlert');
    }

    public function confirmDeclineMeeting()
    {
        $this->emit('showDeclineConfirmationAlert');
    }

    public function declineMeeting()
    {
        TblMeetingFeedbackModel::create([
            'id_booking_no' =>  $this->id_booked_meeting,
            'attendee'   =>  $this->attendee,
            'meeting_status'    =>  0, # Declined
        ]);
        $this->emit('hideviewBookMeetingModal');
        session()->flash('success', 'You successfully declined the meeting.');
        $this->reset('id_booked_meeting', 'attendee');
        return redirect()->route('schedule');
    }

    public function viewMeetingDetails($id)
    {
        $meeting = TblBookedMeetingsModel::findOrFail($id);
        $start_datetime = new DateTime($meeting->start_date_time);
        $end_datetime = new DateTime($meeting->end_date_time);
        $created_at = new DateTime($meeting->created_at);

        //// $e_attendees = explode(',', $meeting->attendees);
        //// foreach ($e_attendees as $item) {
        ////     $query = User::join('ref_departments', 'users.id_department', '=', 'ref_departments.id')
        ////         ->where('users.id', $item)
        ////         ->select(
        ////             DB::raw("CONCAT(users.first_name, COALESCE(users.middle_name, ''), ' ',users.last_name, IF(users.extension IS NOT NULL, CONCAT(', ', users.extension), '')) as full_name"),
        ////             'users.sex',
        ////             'ref_departments.department_name'
        ////         )
        ////         ->first(); 
        ////          Using first() to get a single result
        ////     if ($query) {
        ////         # Data remains in these array causing it to stack and data that aren't supposed to be shown are shown between subsequent requests. To solve this, I have a closeMeetingDetails() method to reset everytime user closes the modal that displays the meeting details.
        ////         $this->attendees[] = $query;
        ////     }
        //// }

        $e_attendees = TblAttendeesModel::join('users', 'users.id', '=', 'tbl_attendees.id_users')
            ->join('ref_departments', 'users.id_department', '=', 'ref_departments.id')
            ->where('id_booking_no', $id)
            ->select(
                DB::raw("CONCAT(users.first_name, COALESCE(users.middle_name, ''), ' ',users.last_name, IF(users.extension IS NOT NULL, CONCAT(', ', users.extension), '')) as full_name"),
                'users.sex',
                'ref_departments.department_name'
            )
            ->get();
        foreach ($e_attendees as $item) {
            if ($item) {
                $this->attendees[] = $item;
            }
        }

        $this->id_booked_meeting = $meeting->booking_no;
        $this->attendee = Auth::user()->id;
        $this->start_date_time = $start_datetime->format('M d, Y h:i A');
        $this->end_date_time = $end_datetime->format('M d, Y h:i A');
        $this->created_at_date = $created_at->format('M d, Y h:i A');
        $this->subject = $meeting->subject;
        $this->type_of_attendees = $meeting->type_of_attendees;
        $this->meeting_description = $meeting->meeting_description;

        # Let's check if the user already responded to the meeting
        $this->feedback = TblMeetingFeedbackModel::where('id_booking_no', $meeting->booking_no)
            ->where('attendee', Auth::user()->id)
            ->count();
        $this->emit('showMeetingModal');
    }
}
