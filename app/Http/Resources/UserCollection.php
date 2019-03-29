<?php

namespace Bassoumi\Http\Resources;

use Illuminate\Http\Resources\Json\ResourceCollection;

class UserCollection extends ResourceCollection
{
    /**
     * Transform the resource collection into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
//        dd($this->collection);
        return [
            'data' => UserResource::collection($this->collection),
            'recordsTotal' => '',
            'recordsFiltered' => '',

        ];
    }
}
