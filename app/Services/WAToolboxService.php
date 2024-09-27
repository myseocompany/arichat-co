<?php

namespace App\Services;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Http;
use App\Models\User;


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
        
        //WAToolBoxService::sendCurl($url, $data);
        //dd(json_encode($data));
        $res = $this->sendCurl($url, $data);
        Log::info("sendMedia-despues: content: ".
            $data['content'].", phone: ". 
            $data['phone']);
        return $res;
    }

    public function sendCurl($url, $data){
        $ch = curl_init();

        curl_setopt_array($ch, [
            CURLOPT_URL => $url,
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => '',
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 60,  // Aumentar el tiempo de espera a 60 segundos
            CURLOPT_FOLLOWLOCATION => true,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => 'POST',
            CURLOPT_POSTFIELDS => json_encode($data),
            CURLOPT_HTTPHEADER => ['Content-Type: application/json'],
        ]);

        try {
            $response = curl_exec($ch);
            if ($response === false) {
                throw new \Exception(curl_error($ch), curl_errno($ch));
            }

            $httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
            if ($httpCode != 200) {
                throw new \Exception("HTTP status code: " . $httpCode);
            }

            // Verificar la respuesta de la API
            $responseData = json_decode($response, true);
            if (isset($responseData['error'])) {
                throw new \Exception("API error: " . $responseData['error']);
            }

            return redirect()->back()->with('success', 'Mensaje enviado exitosamente a ' . $data['phone']);
        } catch (\Exception $e) {
            // Registrar el error para depuración
            Log::error("Error sending WhatsApp message: " . $e->getMessage(), [
                'curl_error' => curl_error($ch),
                'curl_errno' => curl_errno($ch),
                'response' => $response,
                'httpCode' => $httpCode ?? 'N/A'
            ]);
            return redirect()->back()->with('error', 'Error al enviar el mensaje: ' . $e->getMessage());
        } finally {
            curl_close($ch);
        }
    }
}
