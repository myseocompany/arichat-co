<?php
namespace App\Services;

use App\Models\Lead;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class LeadService
{
    public function getTeamsLeads()
    {
        $user = Auth::user();

        if ($user) {
            return Lead::where('leads.team_id', $user->current_team_id)
                ->leftJoin('messages', 'leads.id', '=', 'messages.lead_id')
                ->select('leads.id', 'leads.name', 'leads.phone', 'leads.email', 'leads.user_id', 'leads.team_id', DB::raw('MAX(messages.created_at) as last_message_time'))
                ->groupBy('leads.id', 'leads.name', 'leads.phone', 'leads.email', 'leads.user_id', 'leads.team_id')
                ->orderBy('last_message_time', 'desc')
                ->get();
        }

        return collect(); // Retorna una colección vacía si no hay usuario autenticado
    }

    public function getUserLeads()
    {
        $user = Auth::user();

        if ($user) {
            return Lead::where('leads.user_id', $user->id)
                ->leftJoin('messages', 'leads.id', '=', 'messages.lead_id')
                ->select('leads.id', 'leads.name', 'leads.phone', 'leads.email', 'leads.user_id', 'leads.team_id', DB::raw('MAX(messages.created_at) as last_message_time'))
                ->groupBy('leads.id', 'leads.name', 'leads.phone', 'leads.email', 'leads.user_id', 'leads.team_id')
                ->orderBy('last_message_time', 'desc')
                ->get();
        }

        return collect(); // Retorna una colección vacía si no hay usuario autenticado
    }

    public function getAllLeads()
    {
        return Lead::all(); // Retorna todos los leads sin filtros
    }

    public function getAllLeadsForUser($userId)
    {
        return Lead::where('user_id', $userId)->get(); // Todos los leads asociados a un usuario
    }

}