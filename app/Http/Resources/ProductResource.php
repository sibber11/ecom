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

        if ($this->hasMedia(Product::MEDIA_COLLECTION))
            $media = ProductMediaResource::collection($this->media);
        else
            asset('assets/fallback_image.jpg');
            $media = [
                [
                    'size' => getimagesize(public_path('assets/fallback_image.jpg')),
                    'original_url' => asset('assets/fallback_image.jpg'),
                    'name' => 'fallback image',
                    'thumbnail_url' => asset('assets/fallback_image_thumbnail.jpg'),
                ]
            ];
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
            'media' => $media,
            'latest_reviews' => $this->latestReviews,
            'attributes' => $this->attributes,
            'tags' => $this->tags,
        ];
    }
}
