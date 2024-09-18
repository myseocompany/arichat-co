<?php

namespace App\Livewire;

use Livewire\Component;

class Inbox extends Component
{
    public $messages;

    public function mount()
    {
        // Aquí puedes cargar mensajes desde una base de datos, por ejemplo
        $this->messages = [
            ['id' => 1, 'body' => 'Hola, ¿cómo estás?', 'created_at' => now()],
            ['id' => 2, 'body' => '¡Recuerda la reunión mañana!', 'created_at' => now()->subDay()],
        ];
    }

    public function render()
    {
        return view('livewire.inbox');
    }
}
