<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ShelfHasBooks extends Model
{
    use HasFactory;

    protected $table='shelfhasbooks';

    protected $fillable = ['shelf_id','book_id'];
}
