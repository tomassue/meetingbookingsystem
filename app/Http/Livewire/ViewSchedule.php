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
    # wire:model [filter]
    public $department, $search, $from_date, $to_date;

    # Event Details
    public $id_booked_meeting, $created_at_date, $start_date_time, $end_date_time, $type_of_attendees, $attendees, $subject, $meeting_description, $representative_name, $attendee, $feedback;

    public $listeners = [
        'viewBookMeetingModal' => 'viewMeetingModal'
    ];

    public function render()
    {
        /** 
         * * Departments *dropdown 
         */
        $departments = RefDepartmentsModel::select('id', 'department_name')->get();

        /**
         * Filter Meetings
         * * Filtering will be based on our wire:model
         * // Filtering based on the department is tricky. tbl_booked_meetings stores array of attendees. Each attendees came from different departments. If I want to filter it based on the department, I'll have to look for sets of attendees with matching department. The code FIND_IN_SET is helpful in joining the two tables.
         * // FIND_IN_SET(), The FIND_IN_SET function in MySQL is used to check if an integer (user ID) is present in the comma-separated string (foreign_keys). This function will return the position of the first occurrence of users.id in table2.foreign_keys.
         */
        //// $TblBookedMeetingsModel = TblBookedMeetingsModel::whereExists(function ($query) {
        ////     $query->select(DB::raw(1))
        ////         ->from('users')
        ////         ->whereRaw("FIND_IN_SET(users.id, tbl_booked_meetings.attendees)")
        ////         ->where('users.id_department', 4);
        //// })
        ////     ->get();

        $TblBookedMeetingsModel = TblBookedMeetingsModel::join('tbl_attendees', 'tbl_attendees.id_booking_no', '=', 'tbl_booked_meetings.booking_no')
            ->join('users', 'users.id', '=', 'tbl_attendees.id_users')
            ->where('users.id_department', 2)
            ->get();

        /**
         * TODO: filter
         */

        // dd($TblBookedMeetingsModel);

        // $TblBookedMeetingsModel = TblBookedMeetingsModel::all();
        $meetings = $TblBookedMeetingsModel->map(function ($query) {
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
            'meetings' => $meetings,
            'departments' => $departments,
        ];
        return view('livewire.view-schedule', $data);
    }

    public function clear()
    {
        # booted() runs on every request, after the component is mounted or hydrated, but before any update methods are called
        # We'll have to reset this property since it holds the data we are using for displaying the meeting details.
        # Changed it from booted() since there are other requests that are being done. Such as the feedback.
        // $this->reset('attendees', 'representative', 'representative_name', 'feedback');
        $this->reset();
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
