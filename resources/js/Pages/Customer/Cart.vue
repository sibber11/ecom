<script setup>
import ProfileLayout from "@/Pages/Customer/partial/ProfileLayout.vue"
import {InertiaLink, useForm} from "@inertiajs/inertia-vue3";

const props = defineProps(['products']);
const form = useForm({
    qty: 0,
});

function updateItemQuantity(rowId, qty) {
    form.qty = qty;
    form.patch(route('cart.update', rowId), {
        preserveScroll: true,
        onSuccess: () => {
            form.reset('qty');
        }
    });
}
</script>

<template>
    <ProfileLayout>
        <div class="col-span-9 space-y-4">
            <template v-for="product in products.data" :key="product.id">
                <div class="flex items-center justify-between border gap-6 p-4 border-gray-200 rounded">
                    <div class="w-28">
                        <img :src="product.resource.first_media" :alt="product.resource.first_media_name" class="w-full">
                    </div>
                    <div class="w-1/3">
                        <h2 class="text-gray-800 text-xl font-medium capitalize">{{ product.name }}</h2>
                        <p class="text-gray-500 text-sm">Availability:
                            <span class="text-green-600" v-if="product.stock > 0">In Stock</span>
                            <span v-else class="text-red-600">Out of Stock</span></p>
                    </div>
                    <ul>
                        <li v-for="(option, name) in product.options">
<!--                            {{product.options}}-->
                            {{ name }}:
                            {{ option }}

                        </li>
                    </ul>
                    <div class="text-primary text-lg font-semibold">${{ product.price }}</div>
                    <p class="text-sm text-gray-800 mb-1">Quantity</p>
                    <form>
                        <div class="flex border border-gray-300 text-gray-600 divide-x divide-gray-300 w-max">
                            <button type="button" class="h-8 w-8 text-xl flex items-center justify-center"
                                    @click="product.qty--;updateItemQuantity(product.rowId, product.qty)">-
                            </button>
                            <input type="text" class="h-8 w-9 px-2 text-center border-0" v-model="product.qty" @change="">
                            <button type="button" class="h-8 w-8 text-xl flex items-center justify-center"
                                    @click="product.qty++;updateItemQuantity(product.rowId, product.qty)">+
                            </button>
                        </div>
                    </form>
<!--                    <InertiaLink :href="route('cart.store', product.id)" preserve-scroll as="button" method="post"-->
<!--                                 class="px-6 py-2 text-center text-sm text-white bg-primary border border-primary rounded hover:bg-transparent hover:text-primary transition uppercase font-roboto font-medium">-->
<!--                        add to cart-->
<!--                    </InertiaLink>-->

                    <InertiaLink :href="route('cart.delete', product.rowId)" preserve-scroll as="button"
                                 method="delete"
                                 class="text-red-600 cursor-pointer hover:text-primary">
                        <i class="fa-solid fa-trash"></i>
                    </InertiaLink>
                </div>
            </template>

            <article v-if="products.data.length === 0">
                <div class="flex flex-col items-center justify-center space-y-4">
                    <i class="fa-solid fa-shopping-cart text-5xl text-gray-300"></i>
                    <h2 class="text-gray-600 text-xl font-medium">No products in Cart</h2>
                    <p class="text-gray-500 text-sm text-center">You have no items in your Cart. To add items to
                        your
                        cart click on the <button class="px-2">Add to cart</button> on the product page.</p>
                </div>

            </article>
            <InertiaLink :href="route('checkout.show')" class="p-2 bg-primary rounded-md px-4 text-white float-right" v-else>
                Checkout
            </InertiaLink>
        </div>
    </ProfileLayout>
</template>
