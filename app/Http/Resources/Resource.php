<?php

namespace App\Http\Resources;

use App\Models\Resource as AppResource;
use Illuminate\Http\Resources\Json\JsonResource;

class Resource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        $data = parent::toArray($request);
        unset($data['created_at']);
        unset($data['updated_at']);
        $data['video']=$this->when($this->type===AppResource::VIDEO,new resourceVideo($this->resourceVideo));
        $data['doc']=$this->when($this->type===AppResource::DOC,new resourceDoc($this->resourceDoc));
        return $data;
    }
}
