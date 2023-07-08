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
    public function toArray($request): array
    {
        /** @var Product $this */
        return [
            'id' => $this->id,
            'name' => $this->name,
            'url' => route('products.show', $this->slug),
            'first_media' => $this->getImage(),
            'first_media_name' => $this->getFirstMedia(Product::MEDIA_COLLECTION)?->name,
            'quantity' => $this->quantity,
        ];
    }
}
