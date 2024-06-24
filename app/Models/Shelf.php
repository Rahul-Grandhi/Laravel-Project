<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Shelf extends Model
{
    use HasFactory;

    protected $table = "shelf";

    protected $fillable = [
        'name',
        'user_id',
    ];

    public $timestamps = false;

    /*public function user()
    {
        return $this->belongsTo(User::class);
    }*/

    public function books(){
        return $this->belongsToMany(Books::class, 'shelfhasbooks','shelf_id','book_id');
    }
}
