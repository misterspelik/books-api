<?php

namespace App\Http\Resources\User;

use Illuminate\Http\Resources\Json\JsonResource;

class UserResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        self::withoutWrapping();
    
        $this->load('role');

        return [
            "id"    => $this->id,
            "name"  => $this->name,
            "family"  => $this->family,
            "email" => $this->email,
            "role" => $this->role->name,
            "role_id" => $this->role_id,
            "is_email_verified" => $this->hasVerifiedEmail(),
            "gender" => $this->gender,
            "birth" => $this->birth
        ];
    }
}
