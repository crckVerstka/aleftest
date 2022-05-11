<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class LectureResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
        return [
            'topic' => $this->topic,
            'description' => $this->description,
            'studentListeners' => StudentResource::collection($this->whenLoaded('studentListeners')),
            'groupListeners' => GroupResource::collection($this->whenLoaded('groupListeners')),
        ];
    }
}
