<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class TripRequestResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'trip_request_id' => $this->id,
            'customer' => [
                'name' => $this->customer->user->name,
                'phone' => $this->customer->phone,
            ],
            'transporter' => [
                'name' => $this->transporter->user->name,
                'phone' => $this->transporter->phone,
            ],
            'source' => $this->source,
            'destination' => $this->destination,
            'amount' => $this->amount,
            'status' => $this->status,
        ];
    }
}
