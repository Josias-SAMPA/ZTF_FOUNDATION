<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;

class StaffDashboardController extends Controller
{
    public function index()
    {
        $user = Auth::user();
        
        // Charger l'utilisateur avec ses relations
        $user->load([
            'department',
            'services',
            'roles'
        ]);
        
        return view('staff.dashboard', compact('user'));
    }
}
