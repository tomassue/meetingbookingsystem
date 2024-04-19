<?php

namespace App\Http\Livewire;

use App\Models\User;
use Illuminate\Support\Facades\DB;
use Livewire\Component;
use Livewire\WithFileUploads;

class BookMeeting extends Component
{
    use WithFileUploads;

    # wire:model
    public $start_date_time, $end_date_time, $type_of_attendees, $subject, $file, $meeting_description;
    public $attendees = [];

    public function render()
    {
        $users = User::select(
            'id',
            DB::raw("CONCAT(first_name, ' ', COALESCE(middle_name, ''), ' ', last_name, IF(extension IS NOT NULL, CONCAT(', ', extension), '')) AS full_name"),
            'id_department'
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
        dd($this);
    }
}
