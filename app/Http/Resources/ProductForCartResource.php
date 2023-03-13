<?php

namespace App\Http\Resources;

use App\Models\Product;
use Illuminate\Http\Resources\Json\JsonResource;

class ProductForCartResource extends JsonResource
{
    public static $wrap = null;

    /**
     * Transform the resource into an array.
     *
     */
    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'name' => $this->name,
            'url' => route('products.show', $this->slug),
            'price' => $this->price,
            'first_media' => $this->getFirstMediaUrl(Product::MEDIA_COLLECTION),
            'first_media_name' => $this->getFirstMedia(Product::MEDIA_COLLECTION)->name,
            'rating' => $this->rating,
            'stock' => $this->stock,
        ];
    }
}
