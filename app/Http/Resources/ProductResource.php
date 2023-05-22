<?php

namespace App\Http\Resources;

use App\Models\Product;
use Illuminate\Http\Resources\Json\JsonResource;

class ProductResource extends JsonResource
{
    // this is the resource for the product model
    // this is used to transform the product model into a json response
    public static $wrap = null;

    public function toArray($request): array
    {
        /**
         * @var Product $this
         */
        // check if the media collection is empty
        // if empty return fallback image
        $first_media = $this->getFirstMediaUrl(Product::MEDIA_COLLECTION);
        if (empty($first_media)) {
            $first_media = asset('images/fallback.jpg');
        }
        // return the product with the following attributes
        return [
            'id' => $this->id,
            'name' => $this->name,
            'slug' => $this->slug, // slug is the url friendly name of the product
            'sku' => $this->sku,
            'description' => $this->description,
            'price' => $this->price,
            'old_price' => $this->old_price,
            'quantity' => $this->quantity,
            'stock' => $this->stock,
            'is_active' => $this->is_active,
            'reviews_count' => $this->reviews_count,
            'reviews_avg_rating' => round($this->reviews_avg_rating, 1),
            'ratings' => $this->ratings,
            'brand' => $this->brand,
            'category' => $this->category,
            'media' => ProductMediaResource::collection($this->media),
            'latest_reviews' => $this->latestReviews,
            'attributes' => $this->attributes,
            'tags' => $this->tags,
        ];
    }
}
