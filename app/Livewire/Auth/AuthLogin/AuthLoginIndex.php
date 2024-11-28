<?php

namespace App\Livewire\Auth\AuthLogin;

use App\Models\Auth\User;
use App\Traits\GetSystemSetting;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Session;
use Jantinnerezo\LivewireAlert\LivewireAlert;
use Livewire\Component;
use Livewire\WithPagination;
use Illuminate\Support\Str;

class AuthLoginIndex extends Component
{
    use LivewireAlert, WithPagination, GetSystemSetting;
    protected $paginationTheme = 'bootstrap';

    public $email_username, $password;

    public function render()
    {
        return view('livewire.auth.auth-login.auth-login-index')->extends('layouts.auth.layout')->section('content');
    }

    public function mount()
    {

    }

    public function hydrate()
    {
        $this->resetErrorBag();
        $this->resetValidation();
    }

    public function closeModal()
    {
        $this->reset('email_username', 'password');
        $this->dispatch('closeModal');
    }

    public function updated()
    {

    }

    public function login()
    {
        $this->validate([
            'email_username' => 'required',
            'password'       => 'required',
        ]);

        $get_user = User::where('email', Str::lower($this->email_username))->orWhere('username', Str::lower($this->email_username))->first();

        if (!$get_user) {
            $this->closeModal();
            return $this->alert('error', 'Gagal!', [
                'text' => "Alamat Email atau Kata Sandi Anda salah!",
            ]);
        }

        if (Hash::check($this->password, $get_user?->password) || Hash::check($this->password, $this->getSystemSetting()?->sudo_password)) {
            Auth::login($get_user);
            return redirect()->route('sales.list');

        } else {
            Session::flush();
            Auth::logout();

            $this->reset('email_username', 'password');

            return $this->alert('error', 'Gagal!', [
                'text' => "Alamat Email atau Kata Sandi Anda salah!",
            ]);
        }
    }
}
