<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Models\User;
use App\Models\Lead;
use App\Models\Message;

class WAToolBoxController extends Controller
{
    public function receiveMessage(Request $request)
    {
        $data = $request->validate([
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
        }
        $message = "";
        if (!$lead) {
            return response()->json(['message' => 'Lead no encontrado'], 404);
        } else {
            $message = $lead->actions()->create([
                'lead_id' => $lead->id,
                'type_id' => $this->determineActionType($validatedData['type']),
                'description' => $validatedData['content'],
                'user_id' => 1
                
            ]);

            
        }
        // Emitir el evento DataReceived
        //broadcast(new DataReceived($message));
        MessageReceived::dispatch($message);
        
        return response()->json([
            'message' => 'Data processed successfully',
            'customer' => $lead,
            'action' => $message,
        ], 200);
    }

    public function test(){
        // Emitir el evento DataReceived
        $lead = Lead::find(1);
        $message = Action::find(1);
        Log::info('test', ["action"=>"action test"]);
        $e = event(new DataReceived($lead, $message));

        return $e;
    }

    private function determineActionType($type)
    {
        // Asigna un tipo de acción según el tipo recibido en WAToolbox
        // Ejemplo simple: chat, ptt, image
        $type_id = "";
        switch ($type) {
            case "chat":
                $type_id = 5;
                break;
            case "image":
                $type_id = 17;
                break;
            case "ptt":
                $type_id = 18;
                break;
        }

        return $type_id;
    }
}
