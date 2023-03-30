<?php

use App\Models\Order;
use App\Models\Product;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('orders', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained();
//            $table->json('products');
            $table->decimal('total', 8, 2);
            $table->decimal('tax', 8, 2);
            $table->decimal('subtotal', 8, 2);
            $table->decimal('discount', 8, 2);
            $table->decimal('shipping', 8, 2);
            $table->string('status')->default('pending');
            $table->string('payment_method')->default('cash');
            $table->string('payment_status')->default('pending');
            $table->string('payment_id')->nullable();
            $table->json('billing_address')->nullable();
            $table->json('shipping_address');
            $table->text('qr_code')->nullable();
            $table->timestamps();
        });

        Schema::create('order_product', function (Blueprint $table){
            $table->foreignIdFor(Order::class)->constrained();
            $table->foreignIdFor(Product::class)->constrained();
            $table->integer('quantity');
            $table->decimal('price', 8, 2);
            $table->decimal('total', 8, 2);
            $table->json('options')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('orders');
    }
};
