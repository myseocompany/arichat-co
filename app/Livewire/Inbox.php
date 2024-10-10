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

    public $newMessageContent = "";

    protected $leadOrderService;

    public function __construct()
    {
        $this->leadOrderService = new LeadOrderService(); // Inyección de dependencia
    }

    protected $listeners = [
        'testEvent' => 'testEvent',
        'loadAllConversations' => 'loadAllConversations'
    ];

    // Escuchar el evento con #[On]
    #[On('lead-selected')]
    public function selectLeadHandler($leadId)
    {
        $this->selectLead($leadId);
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

    public function testEvent()
    {
        Log::info('El evento de prueba fue ejecutado');
    }


    public function loadMessages()
    {
        $messages = Message::where('lead_id', $this->selectedLeadId)
            ->orderBy('created_at', 'asc')
            ->get(['content', 'is_outgoing', 'created_at']);

        $this->messages = $messages->map(function ($message) {
            return [
                'content' => $message->content,
                'is_outgoing' => $message->is_outgoing,
                'time' => $message->created_at->format('H:i'),
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
        $user = Auth::user();

        if ($user) {
            // Obtener todos los leads que pertenecen al usuario autenticado
            $this->leads = Lead::where('user_id', $user->id)->get();

            // Cargar las conversaciones del primer lead por defecto si hay alguno disponible
            if ($this->leads->first()) {
                $this->selectLead($this->leads->first()->id);
            }
        } else {
            $this->leads = collect();
        }
    }

    public function selectLead($leadId)
    {
        $this->selectedLeadId = $leadId;
        $this->selectedLead = Lead::find($leadId);

        // Cargar los mensajes solo del lead seleccionado
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

    public function loadAllConversations()
    {
        Log::info('Evento loadAllConversations ejecutado');
        $this->selectedLeadId = null;
        $this->selectedLead = null;

        $this->messages = Message::orderBy('created_at', 'asc')
            ->get(['content', 'is_outgoing', 'created_at', 'lead_id'])
            ->map(function ($message) {
                return [
                    'content' => $message->content,
                    'is_outgoing' => $message->is_outgoing,
                    'time' => $message->created_at->format('H:i'),
                    'lead_name' => optional(Lead::find($message->lead_id))->name,
                ];
            })->toArray();
    }



    public function render()
    {
        return view('livewire.inbox', [
            'messages' => $this->messages
        ]);
    }
}
