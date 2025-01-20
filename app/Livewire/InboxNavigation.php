<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\Lead;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;

class InboxNavigation extends Component
{


    public function render()
    {
        return view('livewire.inbox-navigation');
    }
}
