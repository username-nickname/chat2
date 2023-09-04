<?php

namespace App\Http\Requests\Conversation;

use App\Models\Conversation;
use Illuminate\Foundation\Http\FormRequest;

class Store extends FormRequest
{

    public function authorize(): bool
    {
        $user = $this->user();
        $conversationId = $this->route('conversation');
        $conversation = Conversation::findOrFail($conversationId);

        return $user->id === $conversation->user1_id || $user->id === $conversation->user2_id;

    }

    public function rules(): array
    {
        return [
            'body' => ['required', 'min:1','max:2000'],
        ];
    }

    public function attributes()
    {
        return [
            'body' => 'Сообщение',
        ];
    }

}
