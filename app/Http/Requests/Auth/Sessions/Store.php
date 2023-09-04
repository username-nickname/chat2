<?php

namespace App\Http\Requests\Auth\Sessions;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\ValidationException;

class Store extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
            'email' => ['required', 'string', 'email'],
            'password' => ['required', 'string'],
        ];
    }

    public function attributes()
    {
        return [
            'email' => 'Email',
            'password' => 'Пароль',
        ];
    }

    public function tryAuthUser()
    {
        if (!Auth::attempt($this->only(['email', 'password']),$this->boolean('remember'))) {
            throw ValidationException::withMessages([
                'email' => trans('auth.failed'),
            ]);
        }
    }
}
