<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Conversation extends Model
{
    use HasFactory;
//    protected $guarded = [];
    protected $fillable = ['user1_id', 'user2_id'];


    public function users()
    {
        return $this->belongsToMany(User::class);
    }

    public function messages()
    {
        return $this->hasMany(Message::class);
    }

    public function getRecipientName()
    {
        // Проверяем, какой пользователь не является отправителем и возвращаем его имя
        if ($this->user1_id != auth()->user()->id) {
            return User::findOrFail($this->user1_id)->name;
        } else {
            return User::findOrFail($this->user2_id)->name;
        }
    }
}
