<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Requests\Auth\Sessions\Store as LoginRequest;
use Illuminate\Support\Facades\Auth;

class Sessions extends Controller
{

    public function create()
    {
        return view('auth.sessions.create');
    }

    public function store(LoginRequest $request)
    {
        $request->tryAuthUser();

        $request->session()->regenerate();
        return redirect()->intended('/'); // mb to profile page
    }

    public function destroy(Request $request)
    {
        Auth::guard('web')->logout();

        $request->session()->invalidate();

        $request->session()->regenerateToken();

        return redirect()->route('auth.sessions.create');
    }
}
