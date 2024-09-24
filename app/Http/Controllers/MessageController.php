<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\DB;
use App\Services\WAToolBoxService;

class MessageController extends Controller
{
    protected $waToolBoxService;


    public function __construct(WAToolBoxService $waToolBoxService)
    {
        $this->waToolBoxService = $waToolBoxService;
    }

    public function sendMessage(Request $request)
    {
        // Recuperar la URL del webhook desde la base de datos
        $channel = DB::table('channels')->where('type', 'WhatsApp')->first();
        $webhookUrl = json_decode($channel->settings)->webhook_url;
        $response = $this->waToolBoxService->sendToWhatsApp([
            'phone_number' => $request->input('phone_number'),
            'message' => $request->input('message'),
        ]);

        return response()->json($response);

        
    }

    public function receiveMessage(Request $request)
    {
        $message = $request->input('message');
        $phoneNumber = $request->input('phone_number');

        // Guarda el mensaje en la base de datos
        \App\Models\Message::create([
            'content' => $message,
            'phone_number' => $phoneNumber,
            'is_outgoing' => false,
        ]);

        // Emite un evento para actualizar la interfaz de usuario
        broadcast(new \App\Events\MessageReceived($message, $phoneNumber))->toOthers();

        return response()->json(['status' => 'success']);
    }
}