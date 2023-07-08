<script setup>
import {InertiaLink, useForm} from "@inertiajs/inertia-vue3";
import CustomerLayout from "@/Layouts/CustomerLayout.vue"
import Review from "@/Pages/Customer/partial/Review.vue";
import RatingStars from "@/Pages/Customer/partial/RatingStars.vue";
import ProductCluster from "@/Pages/Partials/ProductCluster.vue";
import {ref} from "vue";
import Atrribute from "@/components/Attribute.vue";

const props = defineProps({
    product: Object,
    relatedProducts: Object,
})
const form = useForm({
    quantity: 1,
    options: Object.fromEntries(props.product.attributes.map(item => [item.name, null]))
})

const selectedMedia = ref(props.product.media[0]);

</script>

<template>
    <CustomerLayout>
        <!-- breadcrumb -->
        <div class="container py-4 flex items-center gap-3">
            <InertiaLink :href="route('home')" class="text-primary text-base">
                <i class="fa-solid fa-house"></i>
            </InertiaLink>
            <span class="text-sm text-gray-400">
            <i class="fa-solid fa-chevron-right"></i>
        </span>
            <p class="text-gray-600 font-medium">{{product.category.name}}</p>
        </div>
        <!-- ./breadcrumb -->

        <!-- product-detail -->
        <div class="container grid grid-cols-2 gap-6">
            <div>
                <img :src="selectedMedia?.original_url" alt="product" class="w-full">
                <div class="grid grid-cols-5 gap-4 mt-4">
                    <template v-for="media in product.media">
                        <div class="aspect-w-1 aspect-h-1">
                            <img :src="media.thumbnail_url??media.original_url" alt="product" class="w-full cursor-pointer" :class="media === selectedMedia ? 'border border-primary' : ''"
                                 @click="selectedMedia = media">
                        </div>
                    </template>
                </div>
            </div>

            <div>
                <h2 class="text-3xl font-medium uppercase mb-2">{{ product.name }}</h2>
                <div class="flex items-center mb-4">
                    <div class="flex gap-1 text-sm">
                        <RatingStars :rating="product.reviews_avg_rating"/>
                    </div>
                    <div class="text-xs text-gray-500 ml-3">({{product.reviews_count}} Reviews)</div>
                </div>
                <div class="space-y-2">
                    <p class="text-gray-800 font-semibold space-x-2">
                        <span>Availability: </span>
                        <span class="text-green-600" v-if="product.quantity > 0">In Stock</span>
                        <span class="text-red-600" v-else>Out of Stock</span>
                    </p>
                    <p class="space-x-2">
                        <span class="text-gray-800 font-semibold">Brand: </span>
                        <span class="text-gray-600">{{ product.brand.name }}</span>
                    </p>
                    <p class="space-x-2">
                        <span class="text-gray-800 font-semibold">Category: </span>
                        <span class="text-gray-600">{{ product.category.name }}</span>
                    </p>
                    <p class="space-x-2">
                        <span class="text-gray-800 font-semibold">SKU: </span>
                        <span class="text-gray-600 uppercase">{{ product.sku }}</span>
                    </p>
                </div>
                <div class="flex items-baseline mb-1 space-x-2 font-roboto mt-4">
                    <p class="text-xl text-primary font-semibold">${{ product.price }}</p>
                    <p class="text-base text-gray-400 line-through">${{ product.old_price }}</p>
                </div>

                <p class="mt-4 text-gray-600">{{ product.description }}</p>


                <div class="" v-for="attribute in product.attributes">
                    <div v-if="attribute.name === 'size'" class="mt-4">
                        <h3 class="text-xl text-gray-800 mb-3 uppercase font-medium">Size</h3>
                        <div class="flex items-center gap-2">
                            <div class="size-selector" v-for="option in attribute.options">
                                <input type="radio" :name="attribute.name" :id="option.name" :value="option.name" class="hidden" v-model="form.options[attribute.name]" required>
                                <label :for="option.name"
                                       class="text-xs border border-gray-200 rounded-sm h-6 w-6 flex items-center justify-center cursor-pointer shadow-sm text-gray-600">
                                    {{option.name}}
                                </label>
                            </div>
                        </div>
                    </div>
                    <div v-else-if="attribute.name === 'color'" class="mt-4">
                        <h3 class="text-xl text-gray-800 mb-3 uppercase font-medium">Color</h3>
                        <div class="flex items-center gap-2">
                            <div class="color-selector" v-for="option in attribute.options">
                                <input type="radio" :name="attribute.name" :id="option.name" :value="option.name" class="hidden" v-model="form.options[attribute.name]" required>
                                <label :for="option.name"
                                       class="border border-gray-200 rounded-sm h-6 w-6  cursor-pointer shadow-sm block"
                                       :style="{'background-color': option.name}"></label>
                            </div>

                        </div>
                    </div>
                    <Atrribute v-else :attribute="attribute" v-model="form.options[attribute.name]" required></Atrribute>
                </div>

                <div class="mt-4">
                    <h3 class="text-sm text-gray-800 uppercase mb-1">Quantity</h3>
                    <div class="flex border border-gray-300 text-gray-600 divide-x divide-gray-300 w-max">
                        <button type="button" class="h-8 w-8 text-xl flex items-center justify-center"
                                @click="form.quantity--">-
                        </button>
                        <input type="text" class="h-8 w-9 px-2 text-right" v-model="form.quantity">
                        <button type="button" class="h-8 w-8 text-xl flex items-center justify-center"
                                @click="form.quantity++">+
                        </button>
                    </div>
                </div>

                <div class="mt-6 flex gap-3 border-b border-gray-200 pb-5 pt-5">
                    <button type="button" @click="form.post(route('cart.store', product),{preserveScroll:true})"
                            :disabled="product.quantity === 0"
                                 class="bg-primary border border-primary text-white px-8 py-2 font-medium rounded uppercase flex items-center gap-2 hover:bg-transparent hover:text-primary transition
                                        disabled:hover:bg-red-400 disabled:border-red-400 disabled:hover:text-white disabled:bg-red-400">
                        <i class="fa-solid fa-bag-shopping"></i> Add to cart
                    </button>
                    <InertiaLink :href="route('wishlist.store', product)" as="button" method="post" preserve-scroll
                                 class="border border-gray-300 text-gray-600 px-8 py-2 font-medium rounded uppercase flex items-center gap-2 hover:text-primary transition">
                        <i class="fa-solid fa-heart"></i> Wishlist
                    </InertiaLink>
                </div>

                <div class="flex gap-3 mt-4">
                    <a href="#"
                       class="text-gray-400 hover:text-gray-500 h-8 w-8 rounded-full border border-gray-300 flex items-center justify-center">
                        <i class="fa-brands fa-facebook-f"></i>
                    </a>
                    <a href="#"
                       class="text-gray-400 hover:text-gray-500 h-8 w-8 rounded-full border border-gray-300 flex items-center justify-center">
                        <i class="fa-brands fa-twitter"></i>
                    </a>
                    <a href="#"
                       class="text-gray-400 hover:text-gray-500 h-8 w-8 rounded-full border border-gray-300 flex items-center justify-center">
                        <i class="fa-brands fa-instagram"></i>
                    </a>
                </div>
            </div>
        </div>
        <!-- ./product-detail -->

        <!-- description -->
        <div class="container pb-16">
            <h3 class="border-b border-gray-200 font-roboto text-gray-800 pb-3 font-bold text-lg mt-6">Product details</h3>
            <div class="pt-6">
                <div class="text-gray-600">
                    <p>{{ product.description }}</p>
                </div>

                <table class="table-auto border-collapse w-full text-left text-gray-600 text-sm mt-6">
                    <tr>
                        <th class="py-2 px-4 border border-gray-300 w-40 font-medium">Color</th>
                        <th class="py-2 px-4 border border-gray-300 ">Blank, Brown, Red</th>
                    </tr>
                    <tr>
                        <th class="py-2 px-4 border border-gray-300 w-40 font-medium">Material</th>
                        <th class="py-2 px-4 border border-gray-300 ">Latex</th>
                    </tr>
                    <tr>
                        <th class="py-2 px-4 border border-gray-300 w-40 font-medium">Weight</th>
                        <th class="py-2 px-4 border border-gray-300 ">55kg</th>
                    </tr>
                </table>
            </div>
        </div>
        <!-- ./description -->

        <Review :reviews="product.latest_reviews" :product="product"></Review>
        <!-- related product -->
        <ProductCluster :products="relatedProducts" title="Related Products">
            Related Products
        </ProductCluster>
<!--        {{similarProducts}}-->
        <!-- ./related product -->
    </CustomerLayout>
</template>
