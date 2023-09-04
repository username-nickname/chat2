<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Http\Requests\Conversation\Show as ConversationShow;
use App\Http\Requests\Conversation\Store as StoreRequest;
use Illuminate\Http\Request;
use App\Models\Conversation;
use App\Models\Message;
use Illuminate\Support\Facades\Crypt;
use Pusher\Pusher;


class Conversations extends Controller
{
    protected $pusher;

    public function __construct()
    {
        $this->pusher = new Pusher(
            config('broadcasting.connections.pusher.key'),
            config('broadcasting.connections.pusher.secret'),
            config('broadcasting.connections.pusher.app_id'),
            [
                'cluster' => config('broadcasting.connections.pusher.options.cluster'),
                'useTLS' => true,
            ]
        );
    }

    public function index()
    {

        $user = auth()->user();

        $conversations = Conversation::where('user1_id', $user->id)
            ->orWhere('user2_id', $user->id)
            ->get();

        $secondUserIds = [];
        foreach ($conversations as $conversation) {
            if ($conversation->user1_id != $user->id) {
                $secondUserIds[] = $conversation->user1_id;
            }
            if ($conversation->user2_id != $user->id) {
                $secondUserIds[] = $conversation->user2_id;
            }
        }

        $secondUsers = User::whereIn('id', $secondUserIds)->get();
        return view('conversations.index', compact('conversations', 'secondUsers'));

    }

    public function store(StoreRequest $request, $conversation)
    {
        $message = new Message([
            'conversation_id' => $conversation,
            'sender_id' => auth()->user()->id,
            'body' => Crypt::encryptString($request->input('body')),
        ]);
        $message->save();

        $this->pusher->trigger('conversation.'.$conversation, 'new-message', [
            'sender_name' => $message->sender->name,
            'body' => Crypt::decryptString($message->body),
        ]);

//        return redirect()->route('conversations.show', $conversation);
        return response()->json(['message' => 'Message sent successfully']);
    }

    public function show(ConversationShow $request, $conversationId)
    {
        $conversation = Conversation::findOrFail($conversationId);
        $messages = $conversation->messages;

        $otherUserName = $conversation->getRecipientName();
        return view('conversations.show', compact('messages', 'conversationId', 'otherUserName'));
//        dd($user->name);
    }

    public function search(Request $request)
    {
        $query = $request->input('query');

        // Выполните поиск пользователей по имени
//        $users = User::where('name', 'like', '%' . $query . '%')->get();
        $users = User::where('name', 'LIKE', "%$query%")->get();

        return response()->json($users);
    }

    public function showOrCreate($userId)
    {
        $user = User::findOrFail($userId);
        $currentUserId = auth()->user()->id;

        $conversation = Conversation::where(function ($query) use ($currentUserId, $userId) {
            $query->where('user1_id', $currentUserId)->where('user2_id', $userId);
        })->orWhere(function ($query) use ($currentUserId, $userId) {
            $query->where('user1_id', $userId)->where('user2_id', $currentUserId);
        })->first();
        if(!$conversation) {
            $conversation = Conversation::create([
                'user1_id' => $currentUserId,
                'user2_id' => $userId,
            ]);
        }
        return redirect()->route('conversations.show', $conversation->id);
    }
}
