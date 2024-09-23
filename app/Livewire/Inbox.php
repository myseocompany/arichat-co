<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\Lead;
use App\Models\Message;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\DB;

class Inbox extends Component
{
    public $leads;
    public $messages = [];
    public $selectedLeadId;

    public function mount()
    {
        // Obtain the authenticated user
        $user = Auth::user();

        if ($user) {
            $this->leads = Lead::where('team_id', $user->current_team_id)->get();
            if ($this->leads->first())
                $this->selectLead($this->leads->first()->id);
        } else {
            $this->leads = collect();
        }
    }

    public function selectLead($leadId)
    {
        $this->selectedLeadId = $leadId;
        $this->loadMessages();
    }

    public function loadMessages()
    {
        $this->messages = Message::where('lead_id', $this->selectedLeadId)->get();
    }

    public function sendMessage($content)
    {
        // Obtener el canal de WhatsApp desde la base de datos
        $channel = DB::table('channels')->where('type', 'WhatsApp')->first();

        // Verificar si el canal existe
        if (!$channel) {
            session()->flash('error', 'No se encontró un canal de WhatsApp configurado.');
            return;
        }

        // Decodificar los ajustes del canal
        $settings = json_decode($channel->settings);

        // Verificar si el webhook_url y el número de teléfono existen en los ajustes
        if (!isset($settings->webhook_url) || !isset($settings->phone_number)) {
            session()->flash('error', 'La configuración del canal de WhatsApp es incorrecta.');
            return;
        }

        // Enviar el mensaje al webhook de WAToolbox
        $response = Http::post($settings->webhook_url, [
            'phone_number' => $settings->phone_number, // Utilizar el número desde los settings
            'message' => $content,
        ]);

        // Verificar si la solicitud fue exitosa
        if ($response->successful()) {
            // Guardar el mensaje en la base de datos
            Message::create([
                'lead_id' => $this->selectedLeadId,
                'content' => $content,
                'is_outgoing' => true,
            ]);

            // Recargar los mensajes
            $this->loadMessages();
        } else {
            // Manejar el error en caso de que falle el envío
            session()->flash('error', 'No se pudo enviar el mensaje.');
        }
    }

    public function render()
    {
        return view('livewire.inbox', [
            'messages' => $this->messages
        ]);
    }
}