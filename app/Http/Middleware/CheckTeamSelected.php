<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CheckTeamSelected
{
    public function handle(Request $request, Closure $next)
    {
        $user = Auth::user();

        if ($user) {
            // Verificar si el usuario tiene un equipo seleccionado
            if (!$user->currentTeam) {
                // Si tiene más de un equipo, redirigir a la selección de equipos
                if ($user->teams->count() > 1) {
                    return redirect()->route('teams.select');
                }

                // Si solo tiene un equipo, asignarlo automáticamente
                if ($user->teams->count() === 1) {
                    $user->switchTeam($user->teams->first());
                }
            }
        }

        return $next($request);
    }
}
