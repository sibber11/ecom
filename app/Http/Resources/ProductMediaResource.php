<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;
use Spatie\MediaLibrary\MediaCollections\Models\Media;

class ProductMediaResource extends JsonResource
{

    public function toArray($request): array
    {
        /**
         * @var Media $this
         */
        return [
            'size' => $this->size,
            'original_url' => $this->getUrl(),
            'name' => $this->name,
            'thumbnail_url' => $this->getFullUrl('thumbnail'),
        ];
    }
}
