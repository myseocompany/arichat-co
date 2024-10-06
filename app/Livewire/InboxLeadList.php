<?php

namespace App\Livewire;

use Livewire\Component;

class InboxLeadList extends Component
{
    public $leads;

    public function render()
    {
        return view('livewire.inbox-lead-list');
    }
}
