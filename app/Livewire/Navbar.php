<?php

namespace App\Livewire;

use Livewire\Component;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;

class Navbar extends Component
{
    public function logout()
    {
        Auth::logout();
        Session::invalidate();
        Session::regenerateToken();

        // Use Livewire's redirect method
        return redirect()->to('/'); // Proper redirect for Livewire
    }

    public function render()
    {
        return view('livewire.navbar');
    }
}
