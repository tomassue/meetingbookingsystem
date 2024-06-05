<?php

namespace App\Http\Livewire;

use App\Models\TblAttendeesModel;
use App\Models\TblBookedMeetingsModel;
use App\Models\TblMeetingFeedbackModel;
use App\Models\TblPersonalMeetingsModel;
use App\Models\User;
use Carbon\Carbon;
use DateTime;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Livewire\Component;

class Schedule extends Component
{
    # Variables passed to fullcalendar for rendering data
    public $booked_meetings, $personal_booked_meetings;

    # Event Details
    public $id_booked_meeting, $created_at_date, $start_date_time, $end_date_time, $type_of_attendees, $attendees, $subject, $meeting_description, $representative = false, $representative_name, $attendee, $feedback;

    // wire:model [filter]
    public $from_date, $to_date;

    # addPersonalMeetingModal
    public $p_start_date, $p_end_date, $p_subject, $p_description;

    # Listens for an event and proceed to the method.
    protected $listeners = [
        'viewBookMeetingModal'   => 'viewMeetingDetails',
        'approveMeeting'         => 'approveMeeting',
        'declineMeeting'         => 'declineMeeting',
        'showAddPersonalMeeting' => 'personalMeetingModal'
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

        //! Don't erase!
        //* This commented code is for merely displaying data to the embedded calendar without any special customization.
        // $this->booked_meetings = $TblBookedMeetingsModel->map(function ($meetings) {
        //     $start_date_time = Carbon::parse($meetings->start_date_time)->toIso8601String();
        //     $end_date_time = Carbon::parse($meetings->end_date_time)->toIso8601String();
        //     return [
        //         'id'    => $meetings->booking_no,
        //         'title' => $meetings->subject,
        //         'start' => $start_date_time,
        //         'end'   => $end_date_time,
        //         'allDay' => false,
        //         'backgroundColor' => '#0a927c',
        //         'textColor' => '#ffffff'
        //     ];
        // });

        //* I have added a new feature to color code the meeting displayed based on its status.
        # Color indicators depending on the meetings' status
        $id_booking_no = $TblBookedMeetingsModel->pluck('booking_no')->toArray();
        $approved_feedback = TblMeetingFeedbackModel::where('attendee', Auth::user()->id)->where('meeting_status', 1)->whereIn('id_booking_no', $id_booking_no)->pluck('id_booking_no')->toArray();
        $declined_feedback = TblMeetingFeedbackModel::where('attendee', Auth::user()->id)->where('meeting_status', 0)->whereIn('id_booking_no', $id_booking_no)->pluck('id_booking_no')->toArray();

        $this->booked_meetings = $TblBookedMeetingsModel->map(function ($meetings) use ($approved_feedback, $declined_feedback) {
            $start_date_time = Carbon::parse($meetings->start_date_time)->toIso8601String();
            $end_date_time = Carbon::parse($meetings->end_date_time)->toIso8601String();
            $backgroundColor = '#787878'; // Default color if no condition matches

            if (in_array($meetings->booking_no, $approved_feedback)) {
                $backgroundColor = '#0a927c'; // Color if the attendee approved the meeting
            } elseif (in_array($meetings->booking_no, $declined_feedback)) {
                $backgroundColor = '#d9534f'; // Color if the attendee declined the meeting
            }

            return [
                'id'    => $meetings->booking_no,
                'title' => $meetings->subject,
                'start' => $start_date_time,
                'end'   => $end_date_time,
                'allDay' => false,
                'backgroundColor' => $backgroundColor,
                'textColor' => '#ffffff'
            ];
        });

        $TblPersonalMeetings = TblPersonalMeetingsModel::where('id_user', Auth::user()->id)
            ->get();

        $this->personal_booked_meetings = $TblPersonalMeetings->map(function ($meetings) {
            $start_date_time = Carbon::parse($meetings->start_date_time)->toIso8601String();
            $end_date_time = Carbon::parse($meetings->end_date_time)->toIso8601String();
            return [
                'id'    => $meetings->booking_no,
                'title' => $meetings->subject,
                'start' => $start_date_time,
                'end'   => $end_date_time,
                'allDay' => false,
                'backgroundColor' => '#f0ad4e',
                'textColor' => '#ffffff'
            ];
        });

        return view('livewire.schedule');
    }

    public function clear()
    {
        # booted() runs on every request, after the component is mounted or hydrated, but before any update methods are called
        # We'll have to reset this property since it holds the data we are using for displaying the meeting details.
        # Changed it from booted() since there are other requests that are being done. Such as the feedback.
        //// $this->reset('attendees', 'representative', 'representative_name', 'feedback');
        $this->reset();
        $this->resetValidation();
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
        // $meeting = TblBookedMeetingsModel::findOrFail($id);
        // if ($meeting) {
        //     $start_datetime = new DateTime($meeting->start_date_time);
        //     $end_datetime = new DateTime($meeting->end_date_time);
        //     $created_at = new DateTime($meeting->created_at);

        //     //// $e_attendees = explode(',', $meeting->attendees);
        //     //// foreach ($e_attendees as $item) {
        //     ////     $query = User::join('ref_departments', 'users.id_department', '=', 'ref_departments.id')
        //     ////         ->where('users.id', $item)
        //     ////         ->select(
        //     ////             DB::raw("CONCAT(users.first_name, COALESCE(users.middle_name, ''), ' ',users.last_name, IF(users.extension IS NOT NULL, CONCAT(', ', users.extension), '')) as full_name"),
        //     ////             'users.sex',
        //     ////             'ref_departments.department_name'
        //     ////         )
        //     ////         ->first(); 
        //     ////          Using first() to get a single result
        //     ////     if ($query) {
        //     ////         # Data remains in these array causing it to stack and data that aren't supposed to be shown are shown between subsequent requests. To solve this, I have a closeMeetingDetails() method to reset everytime user closes the modal that displays the meeting details.
        //     ////         $this->attendees[] = $query;
        //     ////     }
        //     //// }

        //     $e_attendees = TblAttendeesModel::join('users', 'users.id', '=', 'tbl_attendees.id_users')
        //         ->join('ref_departments', 'users.id_department', '=', 'ref_departments.id')
        //         ->where('id_booking_no', $id)
        //         ->select(
        //             DB::raw("CONCAT(users.first_name, COALESCE(users.middle_name, ''), ' ',users.last_name, IF(users.extension IS NOT NULL, CONCAT(', ', users.extension), '')) as full_name"),
        //             'users.sex',
        //             'ref_departments.department_name'
        //         )
        //         ->get();
        //     foreach ($e_attendees as $item) {
        //         if ($item) {
        //             $this->attendees[] = $item;
        //         }
        //     }

        //     $this->id_booked_meeting = $meeting->booking_no;
        //     $this->attendee = Auth::user()->id;
        //     $this->start_date_time = $start_datetime->format('M d, Y h:i A');
        //     $this->end_date_time = $end_datetime->format('M d, Y h:i A');
        //     $this->created_at_date = $created_at->format('M d, Y h:i A');
        //     $this->subject = $meeting->subject;
        //     $this->type_of_attendees = $meeting->type_of_attendees;
        //     $this->meeting_description = $meeting->meeting_description;

        //     # Let's check if the user already responded to the meeting
        //     $this->feedback = TblMeetingFeedbackModel::where('id_booking_no', $meeting->booking_no)
        //         ->where('attendee', Auth::user()->id)
        //         ->count();
        //     $this->emit('showMeetingModal');
        // } else {
        //     dd('luh');
        // }

        // Reset the attendees array to avoid stacking data
        $this->attendees = [];

        try {
            // Find the meeting or return null
            $meeting = TblBookedMeetingsModel::find($id);

            // If the meeting is not found, it might be under personal meeting
            if ($meeting) {
                // Parse date and time
                $start_datetime = new DateTime($meeting->start_date_time);
                $end_datetime = new DateTime($meeting->end_date_time);
                $created_at = new DateTime($meeting->created_at);

                // Fetch attendees with the necessary joins and selections
                $e_attendees = TblAttendeesModel::join('users', 'users.id', '=', 'tbl_attendees.id_users')
                    ->join('ref_departments', 'users.id_department', '=', 'ref_departments.id')
                    ->where('id_booking_no', $id)
                    ->select(
                        DB::raw("CONCAT(users.first_name, COALESCE(users.middle_name, ''), ' ',users.last_name, IF(users.extension IS NOT NULL, CONCAT(', ', users.extension), '')) as full_name"),
                        'users.sex',
                        'ref_departments.department_name'
                    )
                    ->get();

                // Append each attendee to the array
                foreach ($e_attendees as $item) {
                    $this->attendees[] = $item;
                }

                // Set meeting details
                $this->id_booked_meeting = $meeting->booking_no;
                $this->attendee = Auth::user()->id;
                $this->start_date_time = $start_datetime->format('M d, Y h:i A');
                $this->end_date_time = $end_datetime->format('M d, Y h:i A');
                $this->created_at_date = $created_at->format('M d, Y h:i A');
                $this->subject = $meeting->subject;
                $this->type_of_attendees = $meeting->type_of_attendees;
                $this->meeting_description = $meeting->meeting_description;

                // Check if the user has already responded to the meeting
                $this->feedback = TblMeetingFeedbackModel::where('id_booking_no', $meeting->booking_no)
                    ->where('attendee', Auth::user()->id)
                    ->count();

                // Emit event to show the modal
                $this->emit('showMeetingModal');
            } else {
                $personal_meeting = TblPersonalMeetingsModel::find($id);

                $this->created_at_date = (new DateTime($personal_meeting->created_at))->format('M d, Y h:i A');
                $this->start_date_time = (new DateTime($personal_meeting->start_date_time))->format('M d, Y h:i A');
                $this->end_date_time = (new DateTime($personal_meeting->end_date_time))->format('M d, Y h:i A');
                $this->subject = $personal_meeting->subject;
                $this->meeting_description = $personal_meeting->description;

                $this->emit('showViewPersonalMeetingModal');
            }
        } catch (\Exception $e) {
            // Handle the error gracefully
            dd('An error occurred: ' . $e->getMessage());
        }
    }

    # Method to generate a unique number
    private function generateUniqueNumber()
    {
        // Get the current Unix timestamp
        $timestamp = time();

        // Extract the last four digits of the timestamp
        $uniqueIdentifier = substr($timestamp, -4);

        // Generate two random lowercase letters (a-z)
        $randomLetters = '';
        for ($i = 0; $i < 2; $i++) {
            $randomLetters .= strtoupper(chr(mt_rand(97, 122))); // ASCII values for lowercase letters
        }

        // Concatenate the random letters with the four-digit number
        $uniqueNumber = $uniqueIdentifier . $randomLetters;

        // Shuffle the unique number (digits and letters)
        $shuffledNumber = str_shuffle($uniqueNumber);

        return $shuffledNumber;
    }

    public function personalMeetingModal($startDay)
    {
        //* There are instances that the timezone in fullcalendar is different.
        // Parse the date string and convert it to the application's timezone
        $date = Carbon::parse($startDay)->setTimezone('Asia/Singapore');

        // Format the date for the datetime-local input field
        $this->p_start_date = $date->format('Y-m-d\TH:i');
        $this->p_end_date = $date->format('Y-m-d\TH:i');
        $this->emit('showAddPersonalMeetingModal');
    }

    public function savePersonalMeeting()
    {
        /**
         * TODO: Personal meeting functionality
         * //Table
         * // Validation, custome message.
         * // Saving
         * TODO: Displaying
         */

        $rules = [
            'p_start_date'  => 'required',
            'p_end_date'    =>  'required|after_or_equal:p_start_date',
            'p_subject'     =>  'required'
        ];

        $messages = [
            'p_start_date.required'     => 'The start date field is required.',
            'p_end_date.required'       => 'The start date field is required.',
            'p_end_date.after_or_equal' => 'The end date must be a date after or equal to start date.'
        ];

        $this->validate($rules, $messages);

        $data = [
            'booking_no' => $this->generateUniqueNumber(),
            'start_date_time' => $this->p_start_date,
            'end_date_time' =>  $this->p_end_date,
            'subject'   =>  $this->p_subject,
            'description' => $this->p_description,
            'id_user'   =>  Auth::user()->id
        ];

        TblPersonalMeetingsModel::create($data);

        $this->reset();
        $this->emit('hideAddPersonalMeetingModal');
        session()->flash('success', 'Personal meeting is added successfully.');
        return redirect()->route('schedule');
    }
}
