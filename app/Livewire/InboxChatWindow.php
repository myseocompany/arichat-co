<?php

namespace App\Livewire;

use Livewire\Component;

class InboxChatWindow extends Component
{
    public $selectedLead;
    public $messages;

    public function render()
    {
        return view('livewire.inbox-chat-window');
    }
}
