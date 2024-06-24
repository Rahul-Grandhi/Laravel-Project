<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\MorphOne;

class Customer extends Model
{
    use HasFactory;

    protected $table = "customer";

    protected $fillable = [
        'phone',
    ];

    public function user(): MorphOne
    {
        return $this->morphOne(User::class, 'resource');
    }

    public function tripRequests()
    {
        return $this->hasMany(TripRequest::class);
    }
}
