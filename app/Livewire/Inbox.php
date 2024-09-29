<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\Lead;
use App\Models\Message;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use App\Events\MessageProcessed;
use App\Services\WAToolboxService;
use Illuminate\Support\Facades\Log;
 

class Inbox extends Component
{
    public $leads;
    public $messages = [];
    public $selectedLeadId = null;
    public $selectedLead;
    
    public $newMessageContent = "";
    
    public function getListeners()
    {
        return [
            // Public Channel
            "echo:chat,MessageReceived" => 'handleMessageReceived',
        ];
    }

    public function handleMessageReceivedOld()
    {
        Log::info('Evento en el componente:', ['evento' => 'MessageReceived']);
        //$this->loadMessages(); 
        return "recibido";
    }
    public function handleMessageReceived($data)
{
    Log::info('Evento en el componente:', ['evento' => 'MessageReceived']);
        
    // Asegurarse de que el mensaje recibido pertenece al lead seleccionado actualmente
    if ($this->selectedLead && $this->selectedLead->phone == $data['phoneNumber']) {
        // Agregar el nuevo mensaje al final de la lista de mensajes
        $this->messages[] = [
            'is_outgoing' => false,
            'content' => $data['message'],
            'lead_id' => $this->selectedLeadId
        ];
        
        // Despachar evento para hacer scroll al final de la lista
        $this->dispatch('scrollbottom');
    }
}

    public function loadMessages()
    {
        $messages =  Message::where('lead_id', $this->selectedLeadId)->get();
        $this->messages = $this->messages[] = $messages->toArray();
        
    }




    public function mount()
    {
        // Obtener el usuario autenticado
        $user = Auth::user();

        
        if ($user) {
            $this->leads = Lead::where('team_id', $user->current_team_id)->get();
            if($this->leads->first() )
                if($this->selectedLeadId == null)
                    $this->selectLead($this->leads->first()->id);
                else
                    $this->selectLead($this->selectedLeadId);
        } else {
            $this->leads = collect();
        }
    }

    public function selectLead($leadId)
    {
        $this->selectedLeadId = $leadId;
        $this->selectedLead = Lead::find($leadId);
    
        $this->loadMessages();
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

        
        
        
        
        //$this->messages->push($message);
        // Ahora usando un array en lugar de una colección
        $this->messages[] = $message->toArray();
        
        
        
        if($this->selectedLead){
            $data = [];
            $data['phone_number'] = $this->selectedLead->phone;
            $data['message'] = $this->newMessageContent;
            $waToolboxService->sendToWhatsApp($data);
            //$waToolboxService->sendMedia($data);
        
        }
        $this->newMessageContent = '';
        
        $user = Auth::user();

        /*
        if ($user) {
            
            if($this->leads->first())
                $this->selectLead($this->leads->first()->id);
        } else {
            $this->leads = collect();
        }
            */
        
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