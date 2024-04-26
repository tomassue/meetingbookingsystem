<?php

namespace App\Http\Livewire;

use App\Models\TblBookedMeetingsModel;
use App\Models\TblFileDataModel;
use Illuminate\Support\Facades\DB;
use Livewire\Component;
use Livewire\WithFileUploads;

class Request extends Component
{
    use WithFileUploads;

    # viewAttachedFileModal
    public $files, $previewFile, $title;

    # addMemoModal
    public $memo;

    protected $rules = [
        'memo' => 'required'
    ];

    public function render()
    {
        $query = TblBookedMeetingsModel::select(
            'booking_no',
            DB::raw("DATE_FORMAT(start_date_time, '%c/%d/%Y %h:%i %p') AS start"),
            DB::raw("DATE_FORMAT(end_date_time, '%c/%d/%Y %h:%i %p') AS end"),
            'subject',
            'type_of_attendees',
            'id_file_data'
        )
            ->orderBy('start_date_time', 'ASC');
        $request = $query->get();
        return view('livewire.request', [
            'request'   =>  $request
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

    public function addMemo()
    {
        $this->validate();
        dd($this->memo);
    }
}
