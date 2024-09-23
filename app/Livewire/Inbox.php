<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\Lead;
use App\Models\Message;
use Illuminate\Support\Facades\Auth;

class Inbox extends Component
{
    public $leads;
    public $messages = [];
    public $selectedLeadId;
    public $newMessageContent;

    public function mount()
    {
        // Obtener el usuario autenticado
        $user = Auth::user();

        if ($user) {
            $this->leads = Lead::where('team_id', $user->current_team_id)->get();
            if($this->leads->first())
                $this->selectLead($this->leads->first()->id);
        } else {
            $this->leads = collect();
        }
    }

    public function selectLead($leadId)
    {
        $this->selectedLeadId = $leadId;
        $this->loadMessages();
    }

    public function loadMessages()
    {
        $this->messages = Message::where('lead_id', $this->selectedLeadId)->get();
    }

    public function sendMessage()
    {
        $content = $this->newMessageContent;

        // Agregar el mensaje a la lista de mensajes en memoria
        $this->messages[] = (object)[
            'content' => $content,
            'is_outgoing' => true,
        ];

        // Limpiar el contenido del nuevo mensaje
        $this->newMessageContent = '';
    }

    public function render()
    {
        return view('livewire.inbox', [
            'messages' => $this->messages
        ]);
    }
}