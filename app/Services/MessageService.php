<?php 

namespace App\Services;

use App\Models\Message;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Log;
use App\Livewire\Inbox; 

use App\Models\User;

use App\Services\WAToolboxService;

class MessageService
{
    public $waToolBoxService;

    public function setWAToolbox(WAToolboxService $waToolBoxService )
    {
        $this->waToolBoxService = $waToolBoxService;
        
    }
    public function saveImage($photo)
    {   
        Log::info('Guardando la foto:', [$photo]);
        $fileName = $photo->store('photos', 'public');
        return Storage::url($fileName);
    }

    public function loadMessages(&$messages, $selectedLeadId, $filterAllSources)
    {
        // Obtener el modelo del usuario autenticado
        $userId = Auth::id(); // Obtener el ID del usuario autenticado
        $user = User::find($userId); // Recuperar el modelo completo del usuario
    
        if (!$user) {
            Log::error("Usuario no encontrado con ID: $userId");
            $messages = []; // Retornar vacío si no se encuentra el usuario
            return;
        }
    
        // Obtener las fuentes del usuario autenticado
        $userSources = $user->messageSources->pluck('id')->toArray(); // Obtener IDs de las fuentes
    
        // Consulta de los mensajes
        $messages = Message::where('lead_id', $selectedLeadId)
            ->where(function ($query) use ($filterAllSources, $userSources) {
                if (!$filterAllSources) {
                    $query->whereIn('message_source_id', $userSources); // Filtrar por fuentes del usuario
                }
            })
            ->orderBy('created_at', 'asc')
            ->get(['content', 'media_url', 'is_outgoing', 'created_at']);
    
        // Mapear los mensajes al formato esperado
        $messages = $messages->map(function ($message) {
            return [
                'content' => $message->content,
                'media_url' => $message->media_url, // URL de la imagen o multimedia
                'is_outgoing' => $message->is_outgoing,
                'time' => $message->created_at->format('H:i a'), // Formato de hora
            ];
        })->toArray();
    }
    
    

    public function storeMessage(Inbox $inbox ){
        if($inbox->mediaUrl)
            $inbox->messageType = 2;
        else
            $inbox->messageType = 1;

        Message::create([
            'lead_id' => $inbox->selectedLeadId,
            'user_id' => Auth::id(),
            'message_source_id' => $inbox->defaultMessageSource->id,
            'message_type_id' => $inbox->messageType,
            'content' => $inbox->newMessageContent,
            'is_outgoing' => true,
            'media_url' => $inbox->mediaUrl ?? null,
        ]);

    }

    public function addMessageUI(Inbox $inbox){
        // Añadir el mensaje a la interfaz
        $inbox->messages[] = [
            'content' => $inbox->newMessageContent,
            'media_url' => $inbox->mediaUrl ?? null,
            'is_outgoing' => true,
            'time' => now()->format('H:i a'),
            'lead_id' => $inbox->selectedLeadId,
        ];

        // Limpiar los campos después de enviar
        $inbox->newMessageContent = '';
        $inbox->mediaUrl = null;
    }

    public function isDuplicateMessage(Inbox $inbox, $data){
        return collect($inbox->messages)->contains(function ($message) use ($data) {
            return $message['content'] === $data['message'] && !$message['is_outgoing'];
        });
    }


    
}
