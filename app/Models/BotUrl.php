<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BotUrl extends Model
{
    use HasFactory;

    protected $fillable = [
        'bot_id',
        'url',
    ];
}
