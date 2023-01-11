<?php

namespace App\Http\Livewire;

use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;

class HeaderComponent extends Component
{
    public $locale;
    public function logout()
    {
        Auth::logout();
        return redirect(route('dashboard'));

    }
    public function updatedLocale()
    {
        session()->put('locale', $this->locale);
        return redirect()->to(url()->previous());
    }
    public function render()
    {

        return view('livewire.header-component');
    }
}
