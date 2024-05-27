<?php

namespace App\Http\Livewire;

use App\Models\RefDepartmentsModel;
use App\Models\User;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Livewire\Component;

class UserManagement extends Component
{
    # modal
    public $editModal = false;

    # wire:model
    public $first_name, $middle_name, $last_name, $extension, $sex, $email, $id_department, $account_type;

    # Validation
    protected $rules = [
        'first_name'    =>  'required',
        'last_name'     =>  'required',
        'email'         =>  'required|string',
        'sex'           =>  'required',
        'id_department' =>  'required',
        'account_type'  =>  'required'
    ];

    public function render()
    {
        $ref_departments = RefDepartmentsModel::select('id', 'department_name')->get(); # for id_department (select)

        $query = User::join('ref_departments', 'users.id_department', '=', 'ref_departments.id')
            ->select(
                'users.id AS user_id',
                DB::raw("CONCAT(users.first_name, ' ', COALESCE(users.middle_name, ''), ' ', users.last_name, IF(users.extension IS NOT NULL, CONCAT(', ', users.extension), '')) AS full_name"),
                'ref_departments.department_name',
                DB::raw("CASE 
                WHEN users.account_type = 1 THEN 'Admin'
                WHEN users.account_type = 2 THEN 'Editor'
                ELSE 'Unknown'
                END AS account_type")
            );
        $users = $query->get();

        return view('livewire.user-management', [
            'departments'   =>  $ref_departments,
            'users'         =>  $users
        ]);
    }

    public function save()
    {
        $this->validate();
        User::create([
            'first_name'    =>  $this->first_name,
            'middle_name'   =>  $this->middle_name,
            'last_name'     =>  $this->last_name,
            'extension'     =>  $this->extension,
            'email'         =>  $this->email . '@email.com',
            'sex'           =>  $this->sex,
            'id_department' =>  $this->id_department,
            'password'      =>  Hash::make('password'),
            'account_type'  =>  $this->account_type
        ]);
        $this->emit('hideaddUserModal');
        session()->flash('success', 'User added successfully.');
        $this->reset();
    }

    //TODO: Edit, update, and reset password to default P@ssw0rd
    public function edit($key)
    {
        dd($key);
    }
}
