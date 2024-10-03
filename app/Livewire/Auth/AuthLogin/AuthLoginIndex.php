<?php

namespace App\Livewire\Auth\AuthLogin;

use Livewire\Component;

class AuthLoginIndex extends Component
{
    public function render()
    {
        return view('livewire.auth.auth-login.auth-login-index')->extends('layouts.auth.layout')->section('content');
    }
}
