<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class TaskResource extends JsonResource
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
            'cod' => $this->cod,
            'title' => $this->title,
            'description' => $this->description,
            'status' => $this->status,
            'created' => $this->created_at->format('d/m/Y')
        ];
        
        // return parent::toArray($request);
    }
}
