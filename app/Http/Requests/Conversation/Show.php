<?php

namespace App\Http\Requests\Conversation;

use Illuminate\Foundation\Http\FormRequest;
use App\Models\Conversation;

class Show extends FormRequest
{

    public function authorize()
    {
        $user = $this->user();
        $conversationId = $this->route('conversation');
        $conversation = Conversation::findOrFail($conversationId);

        return $user->id === $conversation->user1_id || $user->id === $conversation->user2_id;

    }

    public function rules()
    {
        return [
            //
        ];
    }
}
