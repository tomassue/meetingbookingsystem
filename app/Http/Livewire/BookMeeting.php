<?php

namespace App\Http\Livewire;

use App\Models\TblBookedMeetingsModel;
use App\Models\TblFileDataModel;
use App\Models\User;
use Illuminate\Support\Facades\DB;
use Livewire\Component;
use Livewire\WithFileUploads;

class BookMeeting extends Component
{
    use WithFileUploads;

    # wire:model
    public $start_date_time, $end_date_time, $type_of_attendees, $subject, $files, $meeting_description, $attendees = [];

    # Validation
    protected $rules = [
        'start_date_time'        =>  'required',
        'end_date_time'          =>  'required',
        'type_of_attendees'      =>  'required',
        'attendees'              =>  'required',
        'subject'                =>  'required',
        'files'                  =>  'required',
        'meeting_description'    =>  'required'
    ];

    public function render()
    {
        $users = User::join('ref_departments', 'users.id_department', '=', 'ref_departments.id')
            ->select(
                'users.id',
                DB::raw("CONCAT(users.first_name, ' ', COALESCE(users.middle_name, ''), ' ', users.last_name, IF(users.extension IS NOT NULL, CONCAT(', ', users.extension), '')) AS full_name"),
                'ref_departments.department_name'
            )
            ->where('account_type', '!=',  0)
            ->get();

        return view('livewire.book-meeting', [
            'users' =>  $users
        ]);
    }

    // public function addAttendee()
    // {
    //     $this->attendees[] = ['users_id' => null];
    //     $this->emit('attendeeAdded');
    // }

    // public function removeAttendee($index)
    // {
    //     unset($this->attendees[$index]);
    //     $this->attendees = array_values($this->attendees);
    // }

    public function save()
    {
        $this->validate();

        if ($this->files) {
            $save_file = TblFileDataModel::create([
                'file_name' =>  $this->files->getClientOriginalName(),
                'file_size' =>  $this->files->getSize(),
                'file_type' =>  $this->files->extension(),
                'file_data' =>  file_get_contents($this->files->path())
            ]);

            // Retrieve the ID of the recently saved record
            // The id of the recent saved record.
            $id_file_data = $save_file->id;

            dd($id_file_data);

            // TblBookedMeetingsModel::create([
            //     'start_date_time'    =>  $this->start_date_time,
            //     'end_date_time'      =>  $this->end_date_time,
            //     'type_of_attendees'  =>  $this->type_of_attendees,
            //     'attendees'          =>  implode(',', $this->attendees),
            //     'subject'            =>  $this->subject,
            //     'id_file_data'       =>  $id_file_data,
            // ]);

            $this->reset();
            session()->flash('success', 'You have successfully booked a meeting.');
        }
    }
}
