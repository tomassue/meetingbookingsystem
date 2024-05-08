<?php

namespace App\Http\Livewire;

use App\Models\TblBookedMeetingsModel;
use App\Models\TblFileDataModel;
use App\Models\TblMeetingFeedbackModel;
use App\Models\User;
use DateTime;
use Illuminate\Support\Facades\DB;
use Livewire\Component;
use Livewire\WithFileUploads;

class Request extends Component
{
    use WithFileUploads;

    # viewAttachedFileModal
    public $files, $previewFile, $title;

    # addMemoModal
    public $created_at_date, $attendees, $subject, $memo_message;

    protected $rules = [
        'memo_message' => 'required'
    ];

    public function render()
    {
        # Upcoming Meetings
        $query = TblBookedMeetingsModel::select(
            'booking_no',
            DB::raw("DATE_FORMAT(start_date_time, '%c/%d/%Y %h:%i %p') AS start"),
            DB::raw("DATE_FORMAT(end_date_time, '%c/%d/%Y %h:%i %p') AS end"),
            'subject',
            'type_of_attendees',
            'id_file_data'
        )
            ->whereExists(function ($query) {
                $query->select(DB::raw(1))
                    ->from('tbl_meeting_feedback')
                    ->whereRaw('tbl_meeting_feedback.id_booking_no = tbl_booked_meetings.booking_no')
                    ->whereRaw('FIND_IN_SET(tbl_meeting_feedback.attendee, tbl_booked_meetings.attendees)') // Check if attendee responded
                    ->groupBy('tbl_meeting_feedback.id_booking_no')
                    ->havingRaw('COUNT(DISTINCT tbl_meeting_feedback.attendee) = LENGTH(tbl_booked_meetings.attendees) - LENGTH(REPLACE(tbl_booked_meetings.attendees, ",", "")) + 1'); // Ensure all attendees have responded
            })
            ->orderBy('start_date_time', 'ASC');
        $request = $query->get();

        return view('livewire.request', [
            'request'   =>  $request,
        ]);
    }

    public function clear()
    {
        $this->reset();
        $this->resetValidation();
    }

    public function hideAttachedFileModal()
    {
        # booted() runs on every request, after the component is mounted or hydrated, but before any update methods are called
        $this->reset('files', 'previewFile');
    }

    public function viewAttachedFile($id)
    {
        # Explode the data into an array an loop them using foreach to look for it.
        $id_file_data = explode(',', $id);
        foreach ($id_file_data as $item) {
            $query = TblFileDataModel::where('id', $item)
                ->select(
                    'id',
                    'file_name'
                );
            $getfiles = $query->first();
            $this->files[] = $getfiles; # Data that were found from the loop, we store them in an array property. This way, we can display them in our blade using foreach.
        }
    }

    public function previewAttachedFile($id)
    {
        $file = TblFileDataModel::findOrFail($id);
        $this->title = $file->file_name;
        $file_content = base64_encode($file['file_data']);
        $this->previewFile = $file_content;
    }

    public function memo($booking_no)
    {
        $booked_meeting = TblBookedMeetingsModel::where('booking_no', $booking_no)->first();
        $this->created_at_date = (new DateTime($booked_meeting->created_at))->format('F d, Y');
        // $e_attendees = explode(',', $booked_meeting->attendees);
        // foreach ($e_attendees as $item) {
        //     $query = User::join('ref_departments', 'users.id_department', '=', 'ref_departments.id')
        //         ->where('users.id', $item)
        //         ->select(
        //             DB::raw("CONCAT(users.first_name, COALESCE(users.middle_name, ''), ' ',users.last_name, IF(users.extension IS NOT NULL, CONCAT(', ', users.extension), '')) as full_name"),
        //             'users.sex',
        //             'ref_departments.department_name'
        //         )
        //         ->first(); // Using first() to get a single result
        //     if ($query) {
        //         # Data remains in these array causing it to stack and data that aren't supposed to be shown are shown between subsequent requests. To solve this, I have a closeMeetingDetails() method to reset everytime user closes the modal that displays the meeting details.
        //         $this->attendees[] = $query;
        //     }
        // }
        $one = TblMeetingFeedbackModel::join('users', 'tbl_meeting_feedback.attendee', '=', 'users.id')
            ->join('ref_departments', 'users.id_department', '=', 'ref_departments.id')
            ->where('tbl_meeting_feedback.id_booking_no', $booking_no)
            ->select(
                DB::raw("CONCAT(users.first_name, COALESCE(users.middle_name, ''), ' ',users.last_name, IF(users.extension IS NOT NULL, CONCAT(', ', users.extension), '')) as full_name"),
                'users.sex',
                'ref_departments.department_name',
                'proxy'
            )
            ->get();
        foreach ($one as $item) {
            $this->attendees[] = $item;
        }

        $this->subject = $booked_meeting->subject;
    }

    public function saveMemo()
    {
        $this->validate();
        dd($this->memo_message);
    }
}
