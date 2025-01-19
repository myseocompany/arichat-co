<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Auth;

class TeamController extends Controller
{

    public function select()
    {
        $teams = Auth::user()->teams;
        return view('teams.select', compact('teams'));
    }

}
