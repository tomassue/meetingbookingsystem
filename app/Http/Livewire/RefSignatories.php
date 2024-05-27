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

        // Get the content of the uploaded file
        $SignaturefileContent = file_get_contents($this->signature->getRealPath());

        // Encode the file content in Base64
        $Signaturebase64FileContent = base64_encode($SignaturefileContent);

        // Store the Base64-encoded string in the database
        RefSignatoriesModel::create([
            'honorifics'    =>  $this->honorifics,
            'full_name'     =>  $this->full_name,
            'title'         =>  $this->title,
            'signature'     =>  $Signaturebase64FileContent
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

        $this->editModal = true;
    }

    public function update()
    {
        $rules = [
            'honorifics' => 'required',
            'full_name'  => 'required',
            'title'      => 'required',
        ];

        $this->validate($rules);

        $signatory = RefSignatoriesModel::findOrFail($this->id_signatory); // Find the specific signatory by ID, or fail if not found

        $data = [
            'honorifics' => $this->honorifics,
            'full_name' => $this->full_name,
            'title' => $this->title
        ];

        if ($this->signature) {
            $SignaturefileContent = file_get_contents($this->signature->getRealPath()); // Get the content of the uploaded file
            $data['signature'] = base64_encode($SignaturefileContent); // Encode the file content in Base64
        }

        // Update the record with new values
        $signatory->update($data);

        $this->reset();
        session()->flash('success', 'You have successfully added a signatory.');
        return redirect()->route('ref-signatories');
    }
}
