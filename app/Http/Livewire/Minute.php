<?php

namespace App\Http\Livewire;

use Livewire\Component;

class Minute extends Component
{
    
    public function render()
    {
        return view('livewire.minute')
           ->layout('components.layouts.app');
    }
}
