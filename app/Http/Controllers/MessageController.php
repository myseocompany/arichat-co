<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\DB;
use App\Services\WAToolboxService;

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
        $message = $request->input('message');
        $phoneNumber = $request->input('phone_number');

        // Guarda el mensaje en la base de datos
        \App\Models\Message::create([
            'content' => $message,
            'phone_number' => $phoneNumber,
            'is_outgoing' => false,
        ]);

        // Emite un evento para actualizar la interfaz de usuario
        //broadcast(new \App\Events\MessageReceived($message, $phoneNumber))->toOthers();
        //MessageReceived::dispatch($message, $phoneNumber);
        //MessageReceived::dispatch('mreceived');
        

        return response()->json(['status' => 'success']);
    }
}