<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class PostResource extends JsonResource
{
    public $pesan;
    public function pesan($value = 'Success')
    {
        $this->pesan = $value;
        return $this;
    }

    public function toArray(Request $request): array
    {
        $data = [
            'id' => $this->id,
            'content' => $this->content,
            'user' => !$this->anonymous ? new UserResource($this->whenLoaded('user')) : null,
            'anonymous' => $this->anonymous ? ($this->resource->relationLoaded('user') ? ['name' => $this->resource->user->anonymous] : null) : null,
            'comment' => CommentsResource::collection($this->whenLoaded('comment')),
            'comments_count' => $this->whenCounted('comment'),
            'created_at' => $this->created_at
        ];

        if (!is_null($this->pesan)) {
            $data = ['pesan' => $this->pesan] + $data;
        }

        return $data;
    }
}
