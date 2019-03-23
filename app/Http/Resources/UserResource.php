<?php

namespace Bassoumi\Http\Resources;

use Carbon\Carbon;
use Illuminate\Http\Resources\Json\JsonResource;

class UserResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request $request
     * @return array
     */
    public function toArray($request)
    {
//        return parent::toArray($request);

        return [
            'id' => $this->id,
            'name' => $this->name,
            'email' => $this->email,
            'has_car' => rand(1, 2) == 1 ? 'yes' : 'no',
            'created_at' => [
                'display' => Carbon::parse($this->created_at)->format('d M Y'),
                'timestamp' => $this->created_at
            ],
            'updated_at' => [
                'display' => Carbon::parse($this->updatet_at)->format('d M Y'),
                'timestamp' => $this->updatet_at
            ],
        ];
    }
}
