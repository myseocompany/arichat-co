<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class AudioController extends Controller
{
    public function store(Request $request)
    {
        if ($request->hasFile('audio')) {
            // Guardar el archivo de audio
            $path = $request->file('audio')->store('audios', 'public');

            // Retornar la URL del archivo guardado (puedes hacer ajustes según sea necesario)
            return response()->json(['message' => 'Audio guardado correctamente', 'url' => Storage::url($path)], 200);
        }

        return response()->json(['message' => 'No se recibió ningún archivo'], 400);
    }
}

