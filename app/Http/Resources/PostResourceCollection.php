<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\ResourceCollection;

class PostResourceCollection extends ResourceCollection
{
    public $status;
    public $message;

    /**
     * PostResourceCollection constructor.
     *
     * @param mixed $resource
     * @param bool $status
     * @param string $message
     */
    // public function __construct($resource, $status = true, $message = 'Success')
    // {
    //     parent::__construct($resource);
    //     $this->status = $status;
    //     $this->message = $message;
    // }

    /**
     * Transform the resource collection into an array.
     *
     * @param \Illuminate\Http\Request $request
     * @return array
     */
    public function toArray($request)
    {
        return parent::toArray($request);
    }
}
