<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use App\Http\Requests\Auth\Registers\Store as LoginRequest;

class Registers extends Controller
{

    public function create()
    {
        return view("auth.registers.create");
    }

    public function store(LoginRequest $request)
    {
        $data = $request->validated();
        $data['password'] = Hash::make($data['password']);

        User::create($data);
        return redirect()->route('auth.sessions.create');
    }

}
