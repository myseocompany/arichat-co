<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Services\WAToolboxService;
use App\Models\Lead;
use App\Models\Message;
use App\Models\User;

use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;

class MessageController extends Controller
{
    public $waToolboxService;
    public $defaultMessageSource;

    /*
    public function __construct(WAToolboxService $waToolboxService)
    {
        $this->waToolboxService = $waToolboxService;
    }*/

    public function sendMessage(Request $request)
    {
        Log::info("enviando desde message controller",  ['lead_id' => $request->input('lead_id')]);
        // Verificar si se envió una imagen en base64
        if ($request->has('image')) {
            $base64Image = $request->input('image');
        
            // Validar y procesar el Base64
            if (preg_match('/^data:image\/(\w+);base64,/', $base64Image, $matches)) {
                $imageType = $matches[1]; // Extraer el tipo (png, jpeg, etc.)
                $imageData = preg_replace('/^data:image\/\w+;base64,/', '', $base64Image);
                $imageData = base64_decode($imageData);
        
                if ($imageData === false) {
                    return response()->json(['error' => 'Error al decodificar la imagen'], 400);
                }
        
                // Generar un nombre único para la imagen
                $imageName = uniqid('message_') . '.' . $imageType;
        
                // Ruta de almacenamiento en `public/storage/messages`
                $path = "messages/{$imageName}";
        
                // Guardar la imagen
                $saved = Storage::disk('public')->put($path, $imageData);
        
                if ($saved) {
                    // Generar la URL pública de la imagen
                    $mediaUrl = Storage::url($path);
        
                    // Guardar la URL en la base de datos
                    Message::create([
                        'lead_id' => $request->input('lead_id'),
                        'user_id' => Auth::id(),
                        'message_source_id' => 1, // Ajustar según tu lógica
                        'message_type_id' => 1, // Ajustar según tu lógica
                        'content' => $request->input('message', ''),
                        'media_url' => $mediaUrl,
                        'is_outgoing' => true,
                        'sent_at' => now(),
                    ]);
                } else {
                    return response()->json(['error' => 'Error al guardar la imagen en el servidor'], 500);
                }
            } else {
                return response()->json(['error' => 'Formato de imagen base64 no válido'], 400);
            }
        }
        $user = User::find(Auth::id());

 
        $this->defaultMessageSource = $user->getDefaultMessageSource();
        $this->waToolboxService = new WAToolboxService($this->defaultMessageSource);

        Log::info('WAToolnbox MessageControler', [$this->defaultMessageSource->settings]);
        
        
        $response = $this->waToolboxService->sendMessageToWhatsApp([
            'phone_number' => $request->input('phone_number'),
            'message' => $request->input('message'),
        ]);

        return response()->json($response);
        
    }

    public function receiveMessage(Request $request)
    {
        $messageContent = $request->input('message');
        $phoneNumber = $request->input('phone_number');

        // Verificar si el número de teléfono ya existe en la tabla de leads
        $lead = Lead::where('phone', $phoneNumber)->first();

        // Si no existe, crear un nuevo lead
        if (!$lead) {
            $lead = Lead::create([
                'phone' => $phoneNumber,
                'name' => 'Desconocido', // Puedes cambiar esto si tienes otra lógica para nombres desconocidos
            ]);
        }

        // Verificar si el mensaje ya existe para evitar duplicados
        $exists = Message::where('lead_id', $lead->id)
            ->where('content', $messageContent)
            ->exists();

        if (!$exists) {
            // Guarda el mensaje en la base de datos, asignando el lead_id
            $message = Message::create([
                'lead_id' => $lead->id, // Relacionar el mensaje con el lead
                'content' => $messageContent,
                'is_outgoing' => false, // Es un mensaje entrante, no saliente
            ]);

            // Transmitir evento para actualizar la interfaz de usuario
            broadcast(new \App\Events\MessageReceived($messageContent, $phoneNumber))->toOthers();
        }

        return response()->json(['status' => 'success']);
    }
}