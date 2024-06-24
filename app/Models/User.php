<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Relations\MorphTo;

class User extends Authenticatable
{
    use HasFactory, Notifiable, SoftDeletes;

    protected $table = "users";

    protected $primaryKey = "user_id";

    protected $fillable = [
        'name',
        'resource_type',
        'resource_id',
    ];

    public function resource(): MorphTo
    {
        return $this->morphTo();
    }

    public function shelf(){
        return $this->hasMany(Shelf::class);
    }

    public function scopeWithShelf($query, $loadbooks=false){
        if($loadbooks){
            return $query->with(['shelf.books']);
        }

        return $query->with(['shelf']);
    }
}
