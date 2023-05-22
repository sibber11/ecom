<?php

namespace App\Helper;

use App\Models\Order;
use App\Models\Product;
use Illuminate\Contracts\Container\BindingResolutionException;
use LaravelDaily\Invoices\Classes\Buyer;
use LaravelDaily\Invoices\Classes\InvoiceItem;
use LaravelDaily\Invoices\Facades\Invoice;

class InvoiceHandler
{
    /**
     * @throws BindingResolutionException
     */
    public static function generate(Order $order): \LaravelDaily\Invoices\Invoice
    {
        $customer = new Buyer([
            'name' => $order->user->name,
            'phone' => $order->user->phone ?? null,
            'custom_fields' => [
                'email' => $order->user->email,
            ],
        ]);
        $items = [];
        /** @var Product $product */
        foreach ($order->products as $product) {
            $items[] = (new InvoiceItem())
                ->title($product->name)
                ->pricePerUnit($product->pivot->price)
                ->quantity($product->pivot->quantity);
        }

        return Invoice::make('receipt')
            ->buyer($customer)
            ->addItems($items)
            ->filename($order->id . '_invoice')
            ->logo(public_path('assets/logo.svg'))
            ->payUntilDays(14);
    }
}
