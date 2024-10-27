<?php

namespace App\Services;

use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Http;

class WAToolboxService {
    public $end_point = "";
    
    public function __construct()
    {
        // Asegúrate de que haya un usuario autenticado
        if ($user = Auth::user()) {
            // Asignar el canal predeterminado del equipo actual, si existe
            $defaultChannel = $user->getDefaultChannel();
            if ($defaultChannel) {
                // Suponiendo que $defaultChannel es una instancia del modelo MessageSource que ya has obtenido de alguna manera
                $settings = json_decode($defaultChannel->settings);

                // Acceder al campo webhook_url del JSON
                $webhookUrl = $settings->webhook_url;
                // Establecer el endpoint según algún atributo del canal, ej. 'endpoint'
                $this->end_point = $webhookUrl ?? '';
            }
        }

        // Log para debug si es necesario
        Log::info('WAToolBox endpoint set to: ' . $this->end_point);
    }
    
    public function sendToWhatsApp($data)
    {
        $response = Http::asJson()->post($this->end_point, [
            'action' => 'send-message',
            'type' => 'text',
            'phone' => $data['phone_number'],
            'content' => $data['message'],
            'is_outgoing' => true,
        ]);

        return $response->json();
    }

    public function sendMedia($dataIn){
        $url = $this->end_point;
        
        Log::info('sendMedia-antes:', ['phone' => $dataIn['phone_number'], 
                'text' => $dataIn['message'],
                'watoolbox' => $url
            ]);
        
        $data = [
            'action' => 'send-message',
            'type' => 'text',
            'content' => $dataIn['message'],
            'phone' => $dataIn['phone_number'],
        ];
        
        $res = $this->sendHttp($url, $data);
        Log::info("sendMedia-despues: content: ".
            $data['content'].", phone: ". 
            $data['phone']);
        return $res;
    }

    public function sendHttp($url, $data){
        try {
            $response = Http::asJson()->post($url, $data);

            if ($response->failed()) {
                throw new \Exception("HTTP status code: " . $response->status());
            }

            $responseData = $response->json();
            if (isset($responseData['error'])) {
                throw new \Exception("API error: " . $responseData['error']);
            }

            return redirect()->back()->with('success', 'Mensaje enviado exitosamente a ' . $data['phone']);
        } catch (\Exception $e) {
            Log::error("Error sending WhatsApp message: " . $e->getMessage(), [
                'response' => $response->body(),
                'httpCode' => $response->status()
            ]);
            return redirect()->back()->with('error', 'Error al enviar el mensaje: ' . $e->getMessage());
        }
    }
}