<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class ProductResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param \Illuminate\Http\Request $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
//        $dots = strlen($this->text)>20 ? '...' : '';
        $images= [];
        if ($this->images){
            $images = explode(',',$this->images);
        }
        return [
            "id" => (string)$this->id,
//            "image" => $this->images[0],
            "images" => $images,
            "title" => $this->title,
            "subTitle" => $this->subTitle,
            "stock" => $this->stock,
            "active" => (boolean)$this->active,
            "text" => $this->text,
            "category" => [
                'id' => $this->category->id,
                'title' => $this->category->title,
                'active' => $this->category->active,
            ],
            "sizes" => $this->sizes,


            "features" => $this->features,
            "price" => $this->price,
            "off" => $this->off,
            "view" => $this->view,
            "score" => $this->score,
            "score_count" => $this->score_count,
//            "views" => $this->views,
//            "likes" => $this->likes,
//            "dislikes" => $this->dislikes,
            "created_at" => date('Y-m-d', strtotime($this->created_at)),
            "updated_at" => date('Y-m-d', strtotime($this->updated_at)),


        ];
    }
}
