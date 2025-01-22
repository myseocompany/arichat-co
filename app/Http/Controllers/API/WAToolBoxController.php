<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Models\User;
use App\Models\Lead;
use App\Models\Message;
use App\Events\MessageReceived;
use App\Services\MessageService;
use App\Models\MessageSource;


use Illuminate\Support\Facades\Log;

class WAToolBoxController extends Controller{


    public function receiveMessage(Request $request){
    Log::info('Receiving data at WAToolBoxController receiveMessage:', [$request->all()]);

    // Validar los datos del request
    $validatedData = $request->validate([
        'id' => 'required|string',
        'type' => 'required|string',
        'user' => 'required|string',
        'phone' => 'required|string',
        'content' => 'required|string',
        'name' => 'required|string',
        'name2' => 'string|nullable',
        'image' => 'string|nullable',
        'APIKEY' => 'required|string'
    ]);

    // Identificar el Message Source
    $messageSource = MessageSource::where('APIKEY', $validatedData['APIKEY'])->first();

    
    if (!$messageSource) {
        Log::warning('Message source no encontrado para APIKEY: ' . $validatedData['APIKEY']);
        return response()->json(['message' => 'Fuente del mensaje no encontrada'], 404);
    }

    // Obtener el team_id desde la fuente
    $teamId = $messageSource->team_id;

    // Buscar o crear el Lead
    $lead = Lead::firstOrCreate(
        ['phone' => $validatedData['phone']],
        [
            'name' => $validatedData['name'] ?? $validatedData['name2'],
            'team_id' => $teamId,
        ]
    );

    // Si el lead existe pero no tiene nombre, actualizarlo
    if (is_null($lead->name)) {
        $lead->name = $validatedData['name2'];
        $lead->save();
    }

    // Almacenar la imagen si está presente
    $imageUrl = null;
    if (!empty($validatedData['image'])) {
        try {
            // Decodificar la imagen Base64 y guardarla
            $imageData = base64_decode($validatedData['image']);
            $tempFile = tempnam(sys_get_temp_dir(), 'img_'); // Crear un archivo temporal
            file_put_contents($tempFile, $imageData);
            $messageService = new MessageService();
            // Usar el servicio MessageService para guardar la imagen
            $imageUrl = $messageService->saveImage(new \Illuminate\Http\UploadedFile(
                $tempFile,
                'image.jpg'
            ));

            Log::info('Imagen almacenada con éxito: ' . $imageUrl);
        } catch (\Exception $e) {
            Log::error('Error al guardar la imagen: ' . $e->getMessage());
        }
    }

    // Crear el mensaje asociado al Lead
    $type_id = $this->determineMessageType($validatedData['type']);
    $message = $lead->messages()->create([
        'lead_id' => $lead->id,
        'type_id' => $type_id,
        'content' => $validatedData['content'],
        'message_source_id' => $messageSource->id, // Asocia la fuente del mensaje
        'message_type_id' => 1,
        'user_id' => 1, // Ajusta según corresponda el usuario relacionado
        'is_outgoing' => false,
    ]);

    Log::info('Mensaje creado:', [
        'team_id' => $teamId,
        'message_source_id' => $messageSource->id,
        'lead_id' => $lead->id,
        'message_id' => $message->id,
    ]);

    // Emitir el evento MessageReceived
    MessageReceived::dispatch($validatedData['content'], $validatedData['phone']);

    return response()->json([
        'message' => 'Data processed successfully',
        'team_id' => $teamId,
        'message_source' => $messageSource,
        'customer' => $lead,
        'message' => $message,
    ], 200);
}



    public function test(){
        // Emitir el evento DataReceived
        $lead = Lead::find(1);
        $message = Message::find(1);
        Log::info('test', ["action"=>"action test"]);
        $e = event(new MessageReceived($lead, $message));

        return $e;
    }

    private function determineMessageType($type)
    {
        // Asigna un tipo de acción según el tipo recibido en WAToolbox
        // Ejemplo simple: chat, ptt, image
        $type_id = "";
        switch ($type) {
            case "text":
                $type_id = 1;
                break;
            case "image":
                $type_id = 2;
                break;
            case "audio":
                $type_id = 3;
                break;
        }

        return $type_id;
    }
}
