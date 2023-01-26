<script setup>
import {InertiaLink, useForm} from "@inertiajs/inertia-vue3";
defineProps({
    product:Object
})

const form = useForm({
    quantity: 1
})
</script>
<template>
    <div class="bg-white shadow rounded overflow-hidden group">
        <div class="relative">
            <img :src="product.media[0]?.original_url" :alt="product.media[0]?.name" class="w-full">
            <div class="absolute inset-0 bg-black bg-opacity-40 flex items-center
                    justify-center gap-2 opacity-0 group-hover:opacity-100 transition">
                <InertiaLink :href="route('products.show', product)"
                   class="text-white text-lg w-9 h-8 rounded-full bg-primary flex items-center justify-center hover:bg-gray-800 transition"
                   title="view product">
                    <i class="fa fa-magnifying-glass"></i>
                </InertiaLink>
                <InertiaLink :href="route('wishlist.store', product)" as="button" method="post" preserve-scroll
                   class="text-white text-lg w-9 h-8 rounded-full bg-primary flex items-center justify-center hover:bg-gray-800 transition"
                   title="add to wishlist">
                    <i class="fa fa-heart"></i>
                </InertiaLink>
            </div>
        </div>
        <div class="pt-4 pb-3 px-4">
            <InertiaLink :href="route('products.show', product)">
                <h4 class="uppercase font-medium text-xl mb-2 text-gray-800 hover:text-primary transition">
                    {{product.name}}
                </h4>
            </InertiaLink>
            <div class="flex items-baseline mb-1 space-x-2">
                <p class="text-xl text-primary font-semibold">${{ product.price }}</p>
                <p class="text-sm text-gray-400 line-through">${{ product.old_price }}</p>
            </div>
            <div class="flex items-center">
                <div class="flex gap-1 text-sm text-yellow-400">
                    <span><i class="fa fa-star"></i></span>
                    <span><i class="fa fa-star"></i></span>
                    <span><i class="fa fa-star"></i></span>
                    <span><i class="fa fa-star"></i></span>
                    <span><i class="fa fa-star"></i></span>
                </div>
                <div class="text-xs text-gray-500 ml-3">(150)</div>
            </div>
        </div>
        <button type="button" @click="form.post(route('cart.store', product),{preserveScroll: true})"
           class="block w-full py-1 text-center text-white bg-primary border border-primary rounded-b hover:bg-transparent hover:text-primary transition">
            Add to cart
        </button>
    </div>
</template>
