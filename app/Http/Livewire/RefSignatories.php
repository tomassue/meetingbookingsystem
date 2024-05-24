<?php

namespace App\Http\Livewire;

use App\Models\RefSignatoriesModel;
use Livewire\Component;
use Livewire\WithFileUploads;

class RefSignatories extends Component
{
    # id
    public $id_signatory;

    # Modal
    public $editModal = false, $prev_signature;

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
            'id',
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
        $this->resetValidation();
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

    public function edit(RefSignatoriesModel $query)
    {
        $this->id_signatory = $query->id;
        $this->honorifics = $query->honorifics;
        $this->full_name = $query->full_name;
        $this->title = $query->title;
        $this->prev_signature = $query->signature;

        //TODO: Display the data in the signature input field type.

        $this->editModal = true;
    }

    public function update()
    {
        $this->validate();

        $query = RefSignatories::findOrFail($this->id_signatory);
        $query->update([
            'honorifics' => $this->honorifics,
            'full_name' =>  $this->full_name,
            'title' =>  $this->title,
            'signature' => file_get_contents($this->signature->path())
        ]);
    }
}
