<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Player extends Model
{
    use HasFactory;

    protected $table = "players";

    protected $fillable=[
        "name",
        "position"
    ];
    public function game()
    {
        return $this->belongsTo(Game::class);
    }
}
