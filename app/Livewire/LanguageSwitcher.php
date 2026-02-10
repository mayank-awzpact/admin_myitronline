<?php

namespace App\Livewire;

use Livewire\Component;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Session;

class LanguageSwitcher extends Component
{
    public $locale;

    public function mount()
    {
        $this->locale = session('locale', config('app.locale'));
    }

    public function switchLanguage($lang)
    {
        if (in_array($lang, ['en', 'hi'])) {
            session()->put('locale', $lang);
            App::setLocale($lang);
            $this->locale = $lang;
    
            // Force refresh to apply changes in Laravel 11
            $this->dispatch('refreshPage');
        }
    }
    
    

    public function render()
    {
        return view('livewire.language-switcher');
    }
}
