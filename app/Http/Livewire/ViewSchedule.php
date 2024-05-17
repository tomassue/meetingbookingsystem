<?php

namespace App\Http\Livewire;

use App\Models\RefDepartmentsModel;
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
        # Departments *dropdown
        $departments = RefDepartmentsModel::select('id', 'department_name')->get();

        //* Meetings
        // Filter Meetings

        $TblBookedMeetingsModel = TblBookedMeetingsModel::all();

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

    public function viewMeetingModal(TblBookedMeetingsModel $id)
    {
        $start_datetime = new DateTime($id->start_date_time);
        $end_datetime = new DateTime($id->end_date_time);
        $created_at = new DateTime($id->created_at);

        $e_attendees = explode(',', $id->attendees);
        foreach ($e_attendees as $item) {
            $query = User::join('ref_departments', 'users.id_department', '=', 'ref_departments.id')
                ->where('users.id', $item)
                ->select(
                    DB::raw("CONCAT(users.first_name, COALESCE(users.middle_name, ''), ' ',users.last_name, IF(users.extension IS NOT NULL, CONCAT(', ', users.extension), '')) as full_name"),
                    'users.sex',
                    'ref_departments.department_name'
                )
                ->first(); // Using first() to get a single result
            if ($query) {
                # Data remains in these array causing it to stack and data that aren't supposed to be shown are shown between subsequent requests. To solve this, I have a closeMeetingDetails() method to reset everytime user closes the modal that displays the meeting details.
                $this->attendees[] = $query;
            }
        }
        $this->id_booked_meeting = $id->booking_no;
        $this->attendee = Auth::user()->id;
        $this->start_date_time = $start_datetime->format('M d, Y h:i A');
        $this->end_date_time = $end_datetime->format('M d, Y h:i A');
        $this->created_at_date = $created_at->format('M d, Y h:i A');
        $this->subject = $id->subject;
        $this->type_of_attendees = $id->type_of_attendees;
        $this->meeting_description = $id->meeting_description;

        $this->emit('showViewMeetingModal');
    }
}
