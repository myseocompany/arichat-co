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
        // Obtener el usuario autenticado
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
        $channel = DB::table('channels')->where('type', 'WhatsApp')->first();
        $webhookUrl = json_decode($channel->settings)->webhook_url;

        $response = Http::post($webhookUrl, [
            'phone_number' => '+57 300 4410097', // Número de teléfono especificado
            'message' => $content,
        ]);

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
            // Manejar el error
            session()->flash('error', 'No se pudo enviar el mensaje.');
        }
    }

    public function render()
    {
        return view('livewire.inbox');
    }
}