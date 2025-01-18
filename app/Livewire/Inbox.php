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
            "echo:chat,MessageReceived" => 'handleMessageReceived',
        ];
    }

    #[On('lead-selected')]
    public function selectLeadHandler($leadId)
    {
        $this->selectLead($leadId);
    }

    public function handleMessageReceived($data)
    {
        Log::info('Evento en el componente:', ['evento' => 'MessageReceived']);

        foreach ($this->leads as $index => $lead) {
            if ($lead->phone == $data['phoneNumber']) {
                if ($this->selectedLead && $this->selectedLead->phone == $data['phoneNumber']) {
                    // Verificar si el mensaje ya existe para evitar duplicados
                    $exists = collect($this->messages)->contains(function ($message) use ($data) {
                        return $message['content'] === $data['message'] && !$message['is_outgoing'];
                    });

                    if (!$exists) {
                        $this->messages[] = [
                            'is_outgoing' => false,
                            'content' => $data['message'],
                            'time' => now()->format('H:i'),
                            'lead_id' => $this->selectedLeadId
                        ];
                    }
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
            $this->loadLeads();
        }
    }

    public function loadLeads()
    {
        if ($this->viewMode === 'team') {
            $this->leads = $this->leadOrderService->getTeamLeads();
        } elseif ($this->viewMode === 'user') {
            $this->leads = $this->leadOrderService->getUserLeads();
        }

        if ($this->leads->first()) {
            if ($this->selectedLeadId == null) {
                $this->selectLead($this->leads->first()->id);
            } else {
                $this->selectLead($this->selectedLeadId);
            }
        } else {
            $this->leads = collect();
        }
    }

    public function loadMessages()
    {
        $messages = Message::where('lead_id', $this->selectedLeadId)
            ->where(function ($query) {
                $query->where('user_id', Auth::id())
                      ->orWhere('is_outgoing', true);
            })
            ->orderBy('created_at', 'asc')
            ->get(['content', 'is_outgoing', 'created_at']);

        $this->messages = $messages->map(function ($message) {
            return [
                'content' => $message->content,
                'is_outgoing' => $message->is_outgoing,
                'time' => $message->created_at->format('H:i a'), // Formato de hora
            ];
        })->toArray();
    }

    public function mount()
    {
        $this->loadLeads();
    }

    public function selectLead($leadId)
    {
        $this->selectedLeadId = $leadId;
        $this->selectedLead = Lead::find($leadId);
        $this->loadMessages();
    }

    public function sendMessage()
    {
        if (trim($this->newMessageContent) === '') {
            return;
        }

        $waToolboxService = new WAToolboxService();

        $message = Message::create([
            'lead_id' => $this->selectedLeadId,
            'user_id' => Auth::id(),
            'message_source_id' => 1,
            'message_type_id' => 1,
            'content' => $this->newMessageContent,
            'is_outgoing' => true,
        ]);

        if ($this->selectedLead) {
            $data = [
                'phone_number' => $this->selectedLead->phone,
                'message' => $this->newMessageContent,
            ];
            $waToolboxService->sendToWhatsApp($data);
        }

        // Añadir el mensaje a la lista de mensajes con la hora de creación
        $this->messages[] = [
            'content' => $this->newMessageContent,
            'is_outgoing' => true,
            'time' => now()->format('H:i a'), // Formato de hora
        ];

        $this->newMessageContent = '';
        $this->dispatch('scrollbottom');
    }

    public function render()
    {
        return view('livewire.inbox', [
            'messages' => $this->messages
        ]);
    }
}