<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Books extends Model
{
    use HasFactory;
    protected $table = 'books';
    protected $fillable = ['id','name'];
    public $timestamps = false;

    public function shelf()
    {
        return $this->belongsToMany(Shelf::class, 'shelfhasbooks','book_id','shelf_id');
    }
}
