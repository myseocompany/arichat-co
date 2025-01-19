<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Models\User;
use App\Models\Lead;
use App\Models\Message;
use App\Events\MessageReceived;


use Illuminate\Support\Facades\Log;

class WAToolBoxController extends Controller
{
    public function receiveMessage(Request $request)
    {
        Log::info('Receiving data at WAToolBoxController receiveMessage:', [$request->all()]);

        $validatedData = $request->validate([
            'id' => 'required|string',
            'type' => 'required|string',
            'user' => 'required|string',
            'phone' => 'required|string',
            'content' => 'required|string',
            'name' => 'required|string',
            'name2' => 'string|nullable',
            'image' => 'string|nullable'
        ]);

    

        $lead = Lead::where('phone', $validatedData['phone'])->first();
        if(($lead) && ($lead->name == null)){
            $lead->name = $validatedData['name2'];
            $lead->save();
        }
        $message = "";
        if (!$lead) {
            return response()->json(['message' => 'Lead no encontrado'], 404);
        } else {
            $type_id =  $this->determineMessageType($validatedData['type']);
            $message = $lead->messages()->create([
                'lead_id' => $lead->id,
                'type_id' => $type_id,
                'content' => $validatedData['content'],
                'message_source_id' => 1,
                'message_type_id' => 1,
                'user_id' => 1,
                'is_outgoing' => false,
                
            ]);

            
        }
        // Emitir el evento DataReceived
        //broadcast(new DataReceived($message));
        MessageReceived::dispatch( $validatedData['content'], $validatedData['phone']);
        
        return response()->json([
            'message' => 'Data processed successfully',
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
