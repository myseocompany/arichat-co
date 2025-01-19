<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\User;
use App\Models\Lead;
use App\Models\Message;
use App\Models\MessageSource;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

use Illuminate\Support\Facades\Log;
use Livewire\Attributes\On; 
use Livewire\WithFileUploads;
use Livewire\Attributes\Validate;
use Illuminate\Support\Facades\Storage;

use App\Services\LeadService;
use App\Services\MessageService;
use App\Services\WAToolboxService;


class Inbox extends Component
{
    use WithFileUploads;

    protected $leadService;
    protected $messageService;
    protected $waToolboxService;

    public $leads;
    public $messages = [];
    public $selectedLeadId = null;
    public $selectedLead;
    public $viewMode = 'team'; // Puede ser 'team' o 'user'
    public $newMessageContent = "";
    
    public $mediaUrl;
    public $messageSource;
    public $viewOwnSourcesOnly = true;
    public $defaultMessageSource;
    public $showImagePopUp;
    public $messageType;

    public $filterAllLeads = false;
    public $filterAllSources = false;


    
    

    #[Validate('image|max:1024')] // 1MB Max
    public $photo;
 
    public function toggleAllLeads(){
        $this->filterAllLeads = !$this->filterAllLeads;
        Log::info('Filtro updatedFilterAllLeads actualizado con '. $this->filterAllLeads);
        $this->loadLeads(); 
    }

    public function toggleAllSources(){
        $this->filterAllSources = !$this->filterAllSources;
        Log::info('Filtro updatedFilterAllLeads actualizado con '. $this->filterAllSources);
        if ($this->selectedLeadId) {
            $this->messageService->loadMessages($this->messages, $this->selectedLeadId, $this->filterAllSources);
        }
        $this->loadLeads(); 
    }



    public function __construct()
    {
        $user = User::find(Auth::id());
        $this->defaultMessageSource = $user->getDefaultMessageSource();
        $this->waToolboxService = new WAToolboxService($this->defaultMessageSource);
        $this->messageService = new MessageService($this->waToolboxService);
        $this->leadService = new LeadService();

    }

    
    #[On('filter-updated')]
    public function updateFilter($filterName, $value)
    {
        $this->$filterName = $value;
        //$this.filterMessages(); // Aplicar el filtro dinámico
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
                    $exists = $this->messageService->isDuplicateMessage($this, $data);

                    if (!$exists) {
                        $this->messageService->addMessageUI($this);
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
        // Verificar si se deben cargar todos los leads o solo los asignados
        if ($this->filterAllLeads) {
            // Cargar todos los leads del equipo o usuario según corresponda
            $this->leads = $this->leadService->getAllLeads(Auth::id());
        } else {
            // Cargar solo los leads asignados al equipo o usuario
            $this->leads = $this->leadService->getUserLeads(Auth::id());
        }
    
        // Verificar si hay leads y seleccionar el primero como predeterminado
        if ($this->leads->first()) {
            if ($this->selectedLeadId == null) {
                $this->selectLead($this->leads->first()->id);
            } else {
                $this->selectLead($this->selectedLeadId);
            }
        } else {
            // Si no hay leads, inicializar como colección vacía
            $this->leads = collect();
        }
    }
    
    

 

    public function mount()
    {

        // Cargar el Message Source predeterminado del usuario



        

        if (!$this->defaultMessageSource) {
            Log::warning('No se encontró un MessageSource predeterminado para el usuario ' );
        }else{
            Log::info('Se encontró un MessageSource predeterminado para el usuario: ' . $this->defaultMessageSource->settings);
        }

 

        $this->loadLeads();

    }
    public function saveImage(){
        $this->mediaUrl = $this->messageService->saveImage($this->photol);
        $this->sendMessage();
        $this->photo = null;
        
    }

    public function selectLead($leadId)
    {
        $this->selectedLeadId = $leadId;
        $this->selectedLead = Lead::find($leadId);
        $this->messageService->loadMessages($this->messages, $this->selectedLeadId, $this->filterAllSources);
    
    }

    public function sendMessage()
    {
        Log::info('Enviado mensaje desde inbox '. $this->defaultMessageSource->settings);
        if (trim($this->newMessageContent) === '') {
            return; // Evita enviar si no hay contenido
        }
        


        try {
            // Llamar al servicio con los datos adecuados
            $this->waToolboxService->sendMessageToWhatsApp([
                'phone_number' => $this->selectedLead->phone,
                'message' => $this->newMessageContent,
                'media_url' => $this->mediaUrl ?? null, // Pasar la URL si es un mensaje multimedia
            ]);
    
            $this->dispatch('scrollbottom');
        } catch (\Exception $e) {
            Log::error('Error enviando mensaje: ' . $e->getMessage());
            session()->flash('error', 'Error enviando el mensaje.');
        }

        $this->messageService->storeMessage($this);
        $this->messageService->addMessageUI($this);
    }

    public function render()
    {
        return view('livewire.inbox', [
            'messages' => $this->messages
        ]);
    }
}