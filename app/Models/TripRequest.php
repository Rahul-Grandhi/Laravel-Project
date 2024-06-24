<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class TripRequest extends Model
{
    use HasFactory, SoftDeletes;
    protected $table="trip_request";
    protected $fillable = [
        'customer_id',
        'transporter_id',
        'source',
        'destination',
        'amount',
        'status',
    ];

    public function customer()
    {
        return $this->belongsTo(Customer::class);
    }

    public function transporter()
    {
        return $this->belongsTo(Transporter::class);
    }
}
