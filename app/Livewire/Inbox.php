<?php
namespace App\Http\Livewire;

use Livewire\Component;
use App\Models\Message;

class Inbox extends Component
{
    public $messages;
    public $selectedLeadId;

    protected $listeners = ['messageReceived' => 'refreshMessages'];

    public function mount()
    {
        $this->messages = Message::where('lead_id', $this->selectedLeadId)->get();
    }

    public function refreshMessages()
    {
        $this->messages = Message::where('lead_id', $this->selectedLeadId)->get();
    }

    public function render()
    {
        return view('livewire.inbox');
    }
}