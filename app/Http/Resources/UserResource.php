<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Facades\Log;
use App\Models\Customer;
use App\Models\Transporter;

class UserResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    
     public function toArray(Request $request)
    {
        

        if ($this->resource) {
            Log::info('Resource type: ' . $this->resource_type);
            Log::info('Resource id: ' . $this->resource_id);
            Log::info('Resource phone: ' . $this->resource->phone);
        } else {
            Log::info('No resource found for user');
        }

        return [
            "id"=> $this->user_id,
            "name"=> $this->name,
            "resource_type"=> $this->resource_type,
            "resource_id"=> $this->resource_id,
            "phone"=> $this->resource->resource->phone,
        ];
    }
}
