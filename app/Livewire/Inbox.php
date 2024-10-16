<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\Lead;
use App\Models\Message;
use App\Services\LeadOrderService;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use App\Services\WAToolboxService;
use Illuminate\Support\Facades\Log;


class Inbox extends Component
{
    public $leads;
    public $messages = [];
    public $selectedLeadId = null;
    public $selectedLead;
    public $viewMode = 'team'; // Puede ser 'team' o 'user'


    public $newMessageContent = "";

    protected $leadOrderService;

    public function __construct()
    {
        $this->leadOrderService = new LeadOrderService(); // Inyección de dependencia
    }

    public function getListeners()
    {
        return [
            // Public Channel
            "echo:chat,MessageReceived" => 'handleMessageReceived',
        ];
    }

        // Escuchar el evento con #[On]
        #[On('lead-selected')]
        public function selectLeadHandler($leadId)
        {
            $this->selectLead( $leadId );
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

    foreach ($this->leads as $index => $lead) {
        if ($lead->phone == $data['phoneNumber']) {
            if ($this->selectedLead && $this->selectedLead->phone == $data['phoneNumber']) {
                $this->messages[] = [
                    'is_outgoing' => false,
                    'content' => $data['message'],
                    'time' => now()->format('H:i'), // Asume que el mensaje fue recibido en el momento actual
                    'lead_id' => $this->selectedLeadId
                ];
            }

            $selectedLead = $this->leads->splice($index, 1)->first();
            $this->leads->prepend($selectedLead);
            $this->dispatch('scrollbottom');
            break;
        }
    }
}

public function setViewMode($mode)
{
    if (in_array($mode, ['team', 'user'])) {
        $this->viewMode = $mode;
        $this->loadMessages();
    }
}

    public function loadMessages()
    {
        /*
        $messages = Message::where('lead_id', $this->selectedLeadId)
            ->orderBy('created_at', 'asc') // Asegura que los mensajes se ordenen por la hora de creación
            ->get(['content', 'is_outgoing', 'created_at']); // Selecciona también la hora de creación
        */

        if ($this->viewMode === 'team') {
            // Cargar mensajes de todos los leads asociados al equipo actual del usuario y sus fuentes
            $messages = Message::where('lead_id', $this->selectedLeadId)
                ->whereHas('messageSource', function ($query) {
                    $query->where('team_id', Auth::user()->current_team_id);
                })
                ->orderBy('created_at', 'asc')
                ->get(['content', 'is_outgoing', 'created_at']);
        } elseif ($this->viewMode === 'user') {
            // Cargar solo mensajes de los leads asignados directamente al usuario autenticado y sus fuentes
            $messages = Message::where('lead_id', $this->selectedLeadId)
                ->whereHas('messageSource', function ($query) {
                    $query->where('user_id', Auth::id());
                })
                ->orderBy('created_at', 'asc')
                ->get(['content', 'is_outgoing', 'created_at']);
        }

        $this->messages = $messages->map(function ($message) {
            return [
                'content' => $message->content,
                'is_outgoing' => $message->is_outgoing,
                'time' => $message->created_at->format('H:i'), // Formatea la hora
            ];
        })->toArray();
    }

    // public function mount()
    // {
    //     // Obtener el usuario autenticado
    //     $user = Auth::user();

    //     if ($user) {
    //         // Ordenar los leads por el tiempo del último mensaje en orden descendente
    //         $this->leads = Lead::where('team_id', $user->current_team_id)
    //             ->leftJoin('messages', 'leads.id', '=', 'messages.lead_id')
    //             ->select('leads.*', DB::raw('MAX(messages.created_at) as last_message_time'))
    //             ->groupBy('leads.id')
    //             ->orderBy('last_message_time', 'desc')
    //             ->get();

    //         if ($this->leads->first()) {
    //             if ($this->selectedLeadId == null) {
    //                 $this->selectLead($this->leads->first()->id);
    //             } else {
    //                 $this->selectLead($this->selectedLeadId);
    //             }
    //         }
    //     } else {
    //         $this->leads = collect();
    //     }
    // }

    public function mount()
    {
        
        // Obtener el usuario autenticado
        $user = Auth::user();

        if ($user) {
            // Ordenar los leads por el tiempo del último mensaje en orden descendente
            // Utiliza el servicio para obtener los leads ordenados
            $this->leads = $this->leadOrderService->getOrderedLeads();


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

        // Agregar el nuevo mensaje al array `messages` (Livewire se encargará de actualizar la vista)
        //$this->messages[] = $message->toArray();

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
