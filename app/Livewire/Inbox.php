<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\Lead;
use App\Models\Message;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use App\Events\MessageProcessed;
use App\Services\WAToolboxService;
 

class Inbox extends Component
{
    public $leads;
    public $messages = [];
    public $selectedLeadId;
    public $newMessageContent = "";
    

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
        $waToolboxService = new WAToolboxService();

        
        $message = Message::create([
            'lead_id' => $this->selectedLeadId,
            'user_id' => Auth::id(),
            'message_source_id' => 1, // Suponiendo un canal por defecto
            'message_type_id' => 1, // Suponiendo un tipo de mensaje por defecto
            'content' => $this->newMessageContent,
            'is_outgoing' => true,
        ]);

        $this->messages->push($message);
        $this->newMessageContent = '';
        $lead = Lead::find($this->selectedLeadId);
        $data = [];
        $data['phone_number'] = $lead->phone;
        $data['message'] = $message;
        
 

        if($lead)
            $waToolboxService->sendToWhatsApp($data);
        
        $user = Auth::user();

        if ($user) {
            
            if($this->leads->first())
                $this->selectLead($this->leads->first()->id);
        } else {
            $this->leads = collect();
        }
        
        //MessageProcessed::dispatch($message);
         
        $this->dispatch('scrollbottom');
    }

    public function render()
    {
        return view('livewire.inbox', [
            'messages' => $this->messages
        ]);
    }
}