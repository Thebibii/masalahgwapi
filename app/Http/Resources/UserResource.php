<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class UserResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'name' => $this->name,
            'email' => $this->email,
            'bio' => $this->bio,
            // 'password' => $this->password,
            'role' => $this->when(
                $this->resource->relationLoaded('role'),
                function () {
                    return $this->resource->role->name;
                }
            ),
            'notif' => $this->when(
                $this->resource->relationLoaded('notification'),
                function () {
                    return $this->resource->notification;
                }
            ),
        ];
    }
}
