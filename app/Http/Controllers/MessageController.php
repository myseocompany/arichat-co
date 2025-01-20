<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Services\WAToolboxService;
use App\Models\Lead;
use App\Models\Message;

class MessageController extends Controller
{
    protected $waToolboxService;

    public function __construct(WAToolboxService $waToolboxService)
    {
        $this->waToolboxService = $waToolboxService;
    }

    public function sendMessage(Request $request)
    {
        // Recuperar la URL del webhook desde la base de datos
        $channel = DB::table('channels')->where('type', 'WhatsApp')->first();
        $response = $this->waToolboxService->sendToWhatsApp([
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
