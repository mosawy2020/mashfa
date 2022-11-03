<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class EServiceEProVidersResources extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        return [

            'id' => $this->id,
            'e_provider_id' => optional($this->eProvider)->name,
            'e_services_id' => $this->eService->name,
            'price' => $this->price,
            'discount_price' => $this->discount_price,
            'price_unit' => $this->price_unit,
            'quantity_unit' => $this->quantity_unit,
            'duration' =>  $this->duration,  
            'user_id' => $this->UserName->name,
            
        ];
    }
}
