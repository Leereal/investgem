<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class BonusResource extends JsonResource
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
            'username' => $this->user->username,
            'amount' => $this->amount,
            'created_at' => $this->created_at,
            'referral' => $this->investment->user->username,
            'investment' => $this->investment->amount,
        ];
    } 
}
