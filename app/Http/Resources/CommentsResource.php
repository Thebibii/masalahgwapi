<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class CommentsResource extends JsonResource
{
    public $pesan;
    public function pesan($value = 'Success')
    {
        $this->pesan = $value;
        return $this;
    }
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {

        return [
            'id' => $this->id,
            'content' => $this->content,
            'created_at' => $this->created_at,
            'user' => new UserResource($this->user)
        ];
    }
}
