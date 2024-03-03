<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class NotificationResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return
            [
                'id' => $this->id,
                'is_seen' => $this->is_seen,
                'post' => [
                    'id' => $this->when(
                        $this->resource->relationLoaded('posts'),
                        function () {
                            return $this->resource->posts->id;
                        }
                    ),
                ],
                'user' => [
                    'name' => $this->when(
                        $this->resource->relationLoaded('user'),
                        function () {
                            return $this->resource->user->name;
                        }
                    ),
                ],
            ];
    }
}
