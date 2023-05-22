<script setup>

import {ref} from "vue";
import {InertiaLink, useForm} from "@inertiajs/inertia-vue3";
import {Inertia} from "@inertiajs/inertia";
import RatingStars from "@/Pages/Customer/partial/RatingStars.vue";

const props = defineProps({
    product: {
        type: Object,
        required: true
    }
})
const reviews = ref(props.product.latest_reviews);
const ratingHover = ref(0);
const form = useForm({
    rating: 0,
    body: '',
    product_id: props.product.id
});

function getPercent(star) {
    let percent = Math.round(star / props.product.reviews_count * 100);
    if (isNaN(percent)) {
        return 0;
    }
    return percent;
}

function submitReview() {
    form.post(route('review.store'), {
        preserveScroll: true,
        onSuccess: (page) => {
            console.log(page)
            Inertia.reload({preserveState: true, preserveScroll: true})
            form.reset('rating', 'body');
        },
        onError: (page) => {
            console.log(page)
        }
    })
}
//set offset to the number of reviews from the url
const offset = ref(props.product.latest_reviews.length + 3);
const loadMore = ref(true);

</script>

<template>
    <section class="container mb-4">
        <!-- component -->
        <!-- review item -->
        <h2 class="border-b border-gray-200 font-roboto text-gray-800 pb-3 font-medium mb-3">Ratings</h2>

        <div class="flex mb-3 justify-between">
            <div class="w-1/2">
                <div class="flex items-center mb-3">
                    <RatingStars :rating="product.reviews_avg_rating"/>
                    <p class="ml-2 text-sm font-medium text-gray-900">{{ Math.floor(product.reviews_avg_rating, 2) }} out of 5 stars</p>
                </div>
                <p class="text-sm font-medium text-gray-500">{{ product.reviews_count }} total ratings</p>
                <div class="flex flex-col-reverse">
                    <template v-for="i in 5" :key="i">
                        <div class="flex items-center mt-4">
                            <span class="text-sm font-medium text-blue-600">{{ i }} star</span>
                            <div class="w-2/3 h-5 mx-4 bg-gray-200 rounded">
                                <div :style="{width:getPercent(product.ratings[i])+'%'}" class="h-5 bg-yellow-400 rounded"></div>
                            </div>
                            <span class="text-sm font-medium text-blue-600">{{ getPercent(product.ratings[i]) }}%</span>
                        </div>
                    </template>
                </div>
            </div>
            <form class="max-w-lg my-4 w-1/2" method="post" @submit.prevent="submitReview">
                <h3 class="font-bold text-lg">Write a Review</h3>
                <div class="flex justify-between">
                    <span class="text-md font-bold">Rate us</span>
                    <span class="text-gray-500" @mouseleave="ratingHover=0">
                    <template v-for="i in 5" :key="i">
                        <i
                            :class="{'text-red-400':ratingHover>=i, 'text-red-600':form.rating>=i}"
                            class="fa fa-star"
                            @click="form.rating=i"
                            @mouseover="ratingHover=i"
                        ></i>
                    </template>
                </span>
                </div>
                <div>
                    <template v-if="form.errors.body">
                        <span class="text-red-500 text-sm">{{ form.errors.body }}</span>
                    </template>
                    <template v-if="form.errors.rating">
                        <span class="text-red-500 text-sm">{{ form.errors.rating }}</span>
                    </template>
                </div>
                <div class="my-2">
                    <textarea v-model="form.body" class="w-full border border-gray-300 p-2 my-2" rows="3"></textarea>
                    <button class="w-full bg-primary text-white p-2">Post Review</button>
                </div>
            </form>
        </div>
        <div>
            <h3 class="font-bold text-lg">Reviews</h3>
        </div>
        <div class="flex gap-6 my-4 flex-col my-6">
            <template v-for="review in reviews" :key="review.id">
                <div class="w-full bg-gray-50 border border-gray-300 p-2">
                    <div>
                    <span>
                    <i v-for="i in 5" :key="i" :class="{'text-red-600':review.rating >= i}"
                       class="fa fa-star text-gray-500"></i>
                </span>
                        <span class="text-sm mx-3">
                    {{ review.rating }} out of 5 stars
                </span>
                    </div>
                    <div>
                        <span class="font-bold">{{ review.user?.name }}</span> - <span
                        class="text-xs text-gray-600">{{ review.created_at }}</span>
                    </div>
                    <p>
                        {{ review.body }}
                    </p>
                </div>

            </template>
        </div>
        <!--load more button-->
        <div class="flex justify-center">
            <InertiaLink
                :disabled="loadMore === false"
                :href="route('products.show', {product: product.slug, reviews:offset})"
                :preserve-scroll="true"
                class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded disabled:bg-blue-300"
            >
                Load more
            </InertiaLink>
        </div>
    </section>
</template>
