<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class LandingController extends Controller
{
    public function index()
    {
        return view('landing');
    }

    public function setPreference(Request $request)
    {
        $request->validate([
            'preference' => 'required|string|in:services,doctors,contact,all',
        ]);

        // Store preference in session
        session(['lmc_preference' => $request->preference]);

        return response()->json(['success' => true, 'message' => 'Preference saved']);
    }
}
