<?php

namespace App\Http\Livewire;

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
        return view('livewire.book-meeting');
    }

    public function save()
    {
        dd($this->start_date_time, $this->end_date_time, $this->type_of_attendees, $this->attendees[], $this->subject, $this->file, $this->meeting_description);
    }
}
