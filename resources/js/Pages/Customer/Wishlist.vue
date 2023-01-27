<script setup>
import ProfileLayout from "@/Pages/Customer/partial/ProfileLayout.vue"
import {InertiaLink} from "@inertiajs/inertia-vue3";

defineProps(['products'])
</script>

<template>
    <ProfileLayout>
        <div class="col-span-9 space-y-4">
            <template v-for="product in products.data" :key="product.id">
                <div class="flex items-center justify-between border gap-6 p-4 border-gray-200 rounded">
                    <div class="w-28">
                        <img :src="product.resource.media[0]?.original_url" alt="product 6" class="w-full">
                    </div>
                    <div class="w-1/3">
                        <h2 class="text-gray-800 text-xl font-medium uppercase">{{ product.name }}</h2>
                        <p class="text-gray-500 text-sm">Availability: <span class="text-green-600">In Stock</span></p>
                    </div>
                    <div class="text-primary text-lg font-semibold">${{ product.price }}</div>
                    <InertiaLink :href="route('cart.store', product.id)" preserve-scroll as="button" method="post"
                                 class="px-6 py-2 text-center text-sm text-white bg-primary border border-primary rounded hover:bg-transparent hover:text-primary transition uppercase font-roboto font-medium">
                        add to cart
                    </InertiaLink>

                    <InertiaLink :href="route('wishlist.delete', product.rowId)" preserve-scroll as="button"
                                 method="delete"
                                 class="text-gray-600 cursor-pointer hover:text-primary">
                        <i class="fa-solid fa-trash"></i>
                    </InertiaLink>
                </div>
            </template>
        </div>
    </ProfileLayout>
</template>
