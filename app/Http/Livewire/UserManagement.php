<?php

namespace App\Http\Livewire;

use App\Models\RefDepartmentsModel;
use App\Models\User;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Livewire\Component;
use Livewire\WithPagination;

class UserManagement extends Component
{
    use WithPagination;

    # modal
    public $editModal = false;

    # wire:model
    public $first_name, $middle_name, $last_name, $extension, $sex, $email, $id_department, $account_type, $user_id;

    protected $listeners = [
        'confirmResetPasswordAlert' => 'confirmResetPassword',
        'resetPassword'             => 'resetPassword'
    ];

    # Validation
    protected $rules = [
        'first_name'    =>  'required',
        'last_name'     =>  'required',
        'email'         =>  'required|email:rfc,dns',
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
                WHEN users.account_type = 2 THEN 'Regular User'
                ELSE 'Unknown'
                END AS account_type")
            );
        $users = $query->paginate(10);

        return view('livewire.user-management', [
            'departments'   =>  $ref_departments,
            'users'         =>  $users
        ]);
    }

    public function updated()
    {
        $this->resetPage();
    }

    public function clear()
    {
        $this->reset();
    }

    public function save()
    {
        $this->validate();
        User::create([
            'first_name'    =>  $this->first_name,
            'middle_name'   =>  $this->middle_name,
            'last_name'     =>  $this->last_name,
            'extension'     =>  $this->extension,
            'email'         =>  $this->email,
            'sex'           =>  $this->sex,
            'id_department' =>  $this->id_department,
            'password'      =>  Hash::make('password'),
            'account_type'  =>  $this->account_type
        ]);
        $this->emit('hideaddUserModal');
        session()->flash('success', 'User added successfully.');
        $this->reset();
    }

    public function edit(User $key)
    {
        $this->resetValidation();
        $this->user_id = $key->id;
        $this->first_name = $key->first_name;
        $this->middle_name = $key->middle_name;
        $this->last_name = $key->last_name;
        $this->extension = $key->extension;
        $this->email = $key->email;
        $this->sex = $key->sex;
        $this->id_department = $key->id_department;
        $this->account_type = $key->account_type;

        $this->editModal = true;

        $this->emit('showaddUserModal');
    }

    public function update()
    {
        $this->validate();
        $query = User::findOrFail($this->user_id);
        $data = [
            'first_name' => $this->first_name,
            'middle_name' => $this->middle_name,
            'last_name' => $this->last_name,
            'extension' => $this->extension,
            'email' => $this->email,
            'sex' => $this->sex,
            'id_department' => $this->id_department
        ];
        $query->update($data);
        $this->emit('hideaddUserModal');
        session()->flash('success', 'User updated successfully.');
        $this->reset();
    }

    public function confirmResetPassword($key)
    {
        $this->user_id = $key;
        $this->emit('showResetPasswordConfirmationAlert');
    }

    public function resetPassword()
    {
        $query = User::findOrFail($this->user_id);
        $data = [
            'password' => Hash::make('password')
        ];
        $query->update($data);
        session()->flash('success', 'Success! The password has been reset successfully.');
        $this->reset();
    }
}
