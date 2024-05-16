<?php

namespace App\Http\Livewire;

use App\Models\RefSignatoriesModel;
use Livewire\Component;
use Livewire\WithFileUploads;

class RefSignatories extends Component
{
    # Modal
    public $editModal = false;

    # wire:model
    public $honorifics, $full_name, $title, $signature;

    protected $rules = [
        'honorifics' => 'required',
        'full_name'  => 'required',
        'title'      => 'required',
        'signature'  => 'required|image|mimes:png'
    ];

    use WithFileUploads;

    public function render()
    {
        $query = RefSignatoriesModel::select(
            'honorifics',
            'full_name',
            'title',
            'signature'
        )
            ->orderBy('created_at', 'desc');

        $signatories = $query->get();

        $data = [
            'signatories' => $signatories
        ];

        return view('livewire.ref-signatories', $data);
    }

    public function clear()
    {
        $this->reset();
    }

    public function save()
    {
        $this->validate();
        RefSignatoriesModel::create([
            'honorifics'    =>  $this->honorifics,
            'full_name'     =>  $this->full_name,
            'title'         =>  $this->title,
            'signature'     =>  file_get_contents($this->signature->path())
        ]);
        $this->reset();
        session()->flash('success', 'You have successfully added a signatory.');
        return redirect()->route('ref-signatories');
    }
}
