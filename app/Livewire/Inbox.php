<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\Lead;
use App\Models\Message;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
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

        // Encuentra el lead correspondiente al número de teléfono
        $lead = Lead::where('phone', $data['phone_number'])->first();
        if ($lead) {
            // Marca el lead como que tiene un nuevo mensaje
            $lead->has_new_message = true;
            $lead->save();
        }

        // Asegurarse de que el mensaje recibido pertenece al lead seleccionado actualmente
        if ($this->selectedLead && $this->selectedLead->phone == $data['phone_number']) {
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
            if ($this->leads->first()) {
                if ($this->selectedLeadId == null) {
                    $this->selectLead($this->leads->first()->id);
                } else {
                    $this->selectLead($this->selectedLeadId);
                }
            }
        } else {
            $this->leads = collect();
        }
    }

    public function selectLead($leadId)
    {
        $this->selectedLeadId = $leadId;
        $this->selectedLead = Lead::find($leadId);

        // Marca el lead como que no tiene nuevos mensajes
        $this->selectedLead->has_new_message = false;
        $this->selectedLead->save();

        $this->loadMessages();
    }



    public function sendMessage()
    {
        // Verificar que hay un mensaje antes de continuar
        if (trim($this->newMessageContent) === '') {
            return;
        }

        $waToolboxService = new WAToolboxService();

        // Crear el nuevo mensaje en la base de datos
        $message = Message::create([
            'lead_id' => $this->selectedLeadId,
            'user_id' => Auth::id(),
            'message_source_id' => 1, // Suponiendo un canal por defecto
            'message_type_id' => 1, // Suponiendo un tipo de mensaje por defecto
            'content' => $this->newMessageContent,
            'is_outgoing' => true,
        ]);

        // Enviar el mensaje a través del servicio externo
        if ($this->selectedLead) {
            $data = [
                'phone_number' => $this->selectedLead->phone,
                'message' => $this->newMessageContent,
            ];
            $waToolboxService->sendToWhatsApp($data);
        }

        // Limpiar el campo de entrada después de enviar el mensaje
        $this->newMessageContent = '';

        // Despachar el evento de desplazamiento para hacer scroll hacia abajo
        $this->dispatch('scrollbottom');
    }


    public function render()
    {
        return view('livewire.inbox', [
            'messages' => $this->messages
        ]);
    }
}
