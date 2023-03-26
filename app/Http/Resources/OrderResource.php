<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class OrderResource extends JsonResource
{
    public static $wrap = null;
    /**
     * Transform the resource into an array.
     */
    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'customer_name' => $this->user->name,
            'customer_email' => $this->user->email,
            'customer_phone' => $this->user->phone,
            'shipping_address' => $this->shipping_address,
            'billing_address' => $this->billing_address,
            'user_id' => $this->user_id,
            'total' => $this->total,
            'tax' => $this->tax,
            'subtotal' => $this->subtotal,
            'discount' => $this->discount,
            'shipping' => $this->shipping,
            'status' => $this->status,
            'payment_status' => $this->payment_status,
            'payment_method' => $this->payment_method,
            'created_at' => $this->created_at->format('d M Y'),
            'qr_code' => $this->qr_code,
            'statuses' => [
                'pending', 'confirmed', 'processing', 'completed', 'declined', 'cancelled'
            ],
            'payment_statuses' => [
                'pending', 'paid', 'failed', 'refunded'
            ],
            'products' => $this->products,
        ];
    }
}
