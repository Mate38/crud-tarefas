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
            'created' => $this->created_at->format('d/m/Y'),
            'tags' => $this->getTags($this->tags)
        ];
        
        // return parent::toArray($request);
    }

    private function getTags($tags) {
        return $tags->pluck('title','id')->map(function($title, $id) {
                    return ['value' => $id, 'text' => $title];
                })->all();
    }
}
