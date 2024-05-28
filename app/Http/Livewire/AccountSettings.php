<?php

namespace App\Http\Livewire;

use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Livewire\Component;

class AccountSettings extends Component
{
    //* wire:model [Change Password]
    public $current_password, $new_password, $confirm_password;

    public function render()
    {
        return view('livewire.account-settings');
    }

    public function updatePassword()
    {
        $rules = [
            'current_password' => 'required|current_password',
            'new_password'  =>  'required|min:8|regex:/^(?=.*[a-zA-Z])(?=.*\d)(?=.*[@$!%*?&])[A-Za-z\d@$!%*?&]{8,}$/',
            'confirm_password' => 'required|same:new_password',
        ];

        $this->validate($rules);

        $query = User::findOrFail(Auth::user()->id);
        $data = [
            'password' => Hash::make($this->new_password)
        ];
        $query->update($data);
        $this->reset();
        session()->flash('success', 'Password is updated successfully.');
    }
}
