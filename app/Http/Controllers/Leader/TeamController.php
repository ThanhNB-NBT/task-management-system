<?php

namespace App\Http\Controllers\Leader;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class TeamController extends Controller
{
    public function index()
    {
        $user = Auth::user();
        
        $members = $user->ledProjects()
            ->with('members')
            ->get()
            ->pluck('members')
            ->flatten()
            ->unique('id');

        return view('leader.team', compact('members'));
    }
}
