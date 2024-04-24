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
    public $start_date_time, $end_date_time, $type_of_attendees, $subject, $files = [], $newFile = [], $meeting_description, $attendees = [];

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
        # Attendees
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

    public function addAdditionalFile()
    {
        $rules = [
            'newFile'                =>  'required'
        ];
        $this->validate($rules);
        $this->files = array_merge($this->files, $this->newFile);
        $this->newFile = []; // Clear additionalFiles array
        $this->reset('newFile');
        $this->emit('hideaddNewFileModal');
    }

    public function removeFile($index)
    {
        unset($this->files[$index]);
        $this->files = array_values($this->files); // Re-index the array
    }

    public function save()
    {
        $this->validate();
        if ($this->files) {
            # Iterate over each file.
            # Uploading small files is okay with BLOB data type. I encountered an error where uploading bigger size such as PDF won't upload in the database which is resulting an error.
            try {
                foreach ($this->files as $file) {
                    $savedFile = TblFileDataModel::create([
                        'file_name' => $file->getClientOriginalName(),
                        'file_size' => $file->getSize(),
                        'file_type' => $file->extension(),
                        'file_data' => file_get_contents($file->path())
                    ]);
                    // Store the ID of the saved file
                    $fileDataIds[] = $savedFile->id;
                }
            } catch (\Exception $e) {
                dd($e->getMessage());
            }
            TblBookedMeetingsModel::create([
                'start_date_time'       =>  $this->start_date_time,
                'end_date_time'         =>  $this->end_date_time,
                'type_of_attendees'     =>  $this->type_of_attendees,
                'attendees'             =>  implode(',', $this->attendees),
                'subject'               =>  $this->subject,
                'id_file_data'          =>  implode(',', $fileDataIds),
                'meeting_description'   =>  $this->meeting_description
            ]);
            $this->reset();
            session()->flash('success', 'You have successfully booked a meeting.');
            return redirect()->route('book');
        }
    }
}
