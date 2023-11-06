<?php
namespace App\Http\Resources;

use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class Resource extends JsonResource {
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request) {
        $this->withoutWrapping();
        return parent::toArray($request);
    }

    public function withResponse(Request $request, JsonResponse $response) {
        if(isset($response->getData()->status_code)){
            $response->setStatusCode($response->getData()->status_code, 'Precondition Required');
        }
    }
}