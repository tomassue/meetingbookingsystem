<?php

namespace App\Http\Livewire;

use App\Models\RefDepartmentsModel;
use App\Models\TblAttendeesModel;
use App\Models\TblBookedMeetingsModel;
use App\Models\User;
use Carbon\Carbon;
use DateTime;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Livewire\Component;

class ViewSchedule extends Component
{
    // wire:model [for filter]
    public $department, $search, $from_date, $to_date;

    // Event Details
    public $id_booked_meeting, $created_at_date, $start_date_time, $end_date_time, $type_of_attendees, $attendees, $subject, $meeting_description, $representative_name, $attendee, $feedback;

    public $meetings = []; //* IMPORTANT: Holds the data being rendered to the blade.

    public $listeners = [
        'viewBookMeetingModal' => 'viewMeetingModal',
        'refreshCalendar'      =>  '$refresh'
    ];

    public function render()
    {
        //* Departments *dropdown
        $departments = RefDepartmentsModel::select('id', 'department_name')->get();

        /**
         ** Filter Meetings
         *  Filtering will be based on our wire:model
         *? Dunno why the code works ($subquery). XD
         */

        $subquery = DB::table('tbl_booked_meetings')
            ->join('tbl_attendees', 'tbl_attendees.id_booking_no', '=', 'tbl_booked_meetings.booking_no')
            ->join('users', 'users.id', '=', 'tbl_attendees.id_users')
            ->select('tbl_booked_meetings.booking_no', DB::raw('MAX(users.id) as max_user_id'))
            ->groupBy('tbl_booked_meetings.booking_no');

        //* This filter is based on the department.
        if ($this->department) {
            $subquery->where('users.id_department', $this->department);
        }

        $TblBookedMeetingsModel = DB::table('tbl_booked_meetings')
            ->joinSub($subquery, 'max_users', function ($join) {
                $join->on('tbl_booked_meetings.booking_no', '=', 'max_users.booking_no');
            })
            ->join('tbl_attendees', 'tbl_attendees.id_booking_no', '=', 'tbl_booked_meetings.booking_no')
            ->join('users', 'users.id', '=', 'tbl_attendees.id_users')
            ->where('tbl_booked_meetings.subject', 'like', '%' . $this->search . '%') //* Filter through searching the subject.
            //TODO: Filter start and end datetime.
            // ->whereBetween('start_date_time', [Carbon::parse($this->from_date)->startOfDay(), Carbon::parse($this->to_date)->endOfDay()])
            // ->orWhereBetween('end_date_time', [Carbon::parse($this->from_date)->startOfDay(), Carbon::parse($this->to_date)->endOfDay()])
            ->whereColumn('users.id', '=', 'max_users.max_user_id')
            ->select('tbl_booked_meetings.*', 'tbl_attendees.*', 'users.*')
            ->get();

        // if ($this->from_date) {
        //     $TblBookedMeetingsModel->whereDate('tbl_booked_meetings.start_date_time', '>=', $this->from_date);
        // }

        // if ($this->to_date) {
        //     $TblBookedMeetingsModel->whereDate('tbl_booked_meetings.end_date_time', '<=', $this->to_date);
        // }

        /**
         * * Initially, this is not a property but only a variable that is being directly rendered to the blade. There are problems in terms of filtering since even the property used for filtering updates the query that is being rendered, the variable in our script for the fullcalendar doesn't update.
         * * This is because due to Livewire's lifecycle and the timing of when data is available and rendered.
         * * My solution is to store the data to a property and when a filter occurs, we basically update the property based on the filter values and emit it together with the event as a parameter. A listener in the script will listen to the event and do its thing.
         */
        $this->meetings = $TblBookedMeetingsModel->map(function ($query) {
            $start_date_time = Carbon::parse($query->start_date_time)->toIso8601String();
            $end_date_time = Carbon::parse($query->end_date_time)->toIso8601String();
            return [
                'id'    => $query->booking_no,
                'title' => $query->subject,
                'start' => $start_date_time,
                'end'   => $end_date_time,
                'allDay' => false,
                'backgroundColor' => '#0a927c',
                'textColor' => '#ffffff'
            ];
        });

        $data = [
            'meetings' => $this->meetings,
            'departments' => $departments,
        ];
        return view('livewire.view-schedule', $data);
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
        $this->emit('refreshCalendar', json_encode($this->meetings));
    }

    public function viewMeetingModal($id)
    {
        $meeting = TblBookedMeetingsModel::findOrFail($id);
        $start_datetime = new DateTime($meeting->start_date_time);
        $end_datetime = new DateTime($meeting->end_date_time);
        $created_at = new DateTime($meeting->created_at);
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

        $this->emit('showViewMeetingModal');
    }
}
