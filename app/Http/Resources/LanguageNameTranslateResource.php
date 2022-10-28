<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class LanguageNameTranslateResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param \Illuminate\Http\Request $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
        return [
            "id" => (string)$this->id,
            "language_id" => $this->language_id,
            "to_language_id" => $this->to_language_id,
            "translate" => $this->translate,
            "language" => [
                "name" => $this->language->name,
            ],
            "toLanguage" => [
                "name" => $this->toLanguage->name,
            ],
//            "subsets" => ProductResource::collection($this->articles),
            "created_at" => date('Y-m-d', strtotime($this->created_at)),
            "updated_at" => date('Y-m-d', strtotime($this->updated_at)),
        ];
    }
}
