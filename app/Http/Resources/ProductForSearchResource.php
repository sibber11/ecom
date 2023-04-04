<?php

namespace App\Http\Resources;

use App\Models\Product;
use Illuminate\Http\Resources\Json\JsonResource;

class ProductForSearchResource extends JsonResource
{
    public static $wrap = false;
    /**
     * Transform the resource into an array.
     */
    public function toArray($request)
    {
        /**
         * @var Product $this
         */
        return [
            'id' => $this->id,
            'name' => $this->name,
            'slug' => $this->slug,
            'reviews_avg_rating' => $this->reviews_avg_rating,
            'reviews_count' => $this->reviews_count,
            'price' => $this->price,
            'image' => $this->getFirstMedia(Product::MEDIA_COLLECTION)?->getUrl('thumbnail'),
        ];
    }
}
