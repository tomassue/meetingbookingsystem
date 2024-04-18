<?php

namespace App\Http\Livewire;

use App\Models\RefDepartmentsModel;
use Livewire\Component;

class RefDepartments extends Component
{
    # modal
    public $editModal;
    public $id_ref_department; # For update

    # wire:model
    public $department_name;

    protected $rules = [
        'department_name' => 'required',
    ];

    public function render()
    {
        $query = RefDepartmentsModel::select(
            'id',
            'department_name'
        );

        $departments = $query->get();

        return view('livewire.ref-departments', [
            'departments'   =>  $departments
        ]);
    }

    public function clear()
    {
        $this->reset('editModal', 'department_name');
        $this->resetValidation();
    }

    public function save()
    {
        $this->validate();

        RefDepartmentsModel::create([
            'department_name'   =>  $this->department_name
        ]);

        $this->emit('hideaddDepartmentModal');
        session()->flash('success', 'Department added successfully.');
        $this->reset('department_name');
    }

    public function edit(RefDepartmentsModel $key)
    {
        $this->resetValidation();
        $this->editModal         = true;
        $this->id_ref_department = $key->id;
        $this->department_name   = $key->department_name;
    }

    public function update()
    {
        $this->validate();
        $query = RefDepartmentsModel::findOrFail($this->id_ref_department);
        $query->update([
            'department_name'   =>  $this->department_name
        ]);
        $this->emit('hideaddDepartmentModal');
        session()->flash('success', 'Department updated successfully.');
        $this->reset('id_ref_department', 'department_name');
    }
}
