<script setup>
import ProfileLayout from "@/Pages/Customer/partial/ProfileLayout.vue";
import Pagination from "@/components/Pagination.vue";
const props = defineProps({
    reviews: {
        type: Object,
        required: true
    }
});
</script>

<template>
    <ProfileLayout>
        <section class="col-span-9">
            <h2 class="text-lg font-medium text-gray-800 mb-4 font-">My Reviews</h2>
            <div class="overflow-x-auto shadow-md sm:rounded-lg">
                <div v-for="review in reviews.data" class="m-4">
                    <div class="text-gray-700 font-bold">{{review.product.name}}</div>
                    <div class="flex gap-3">
                        <img :src="review.product.media[0]?.original_url" alt="product image" class="w-1/6 h-full">
                        <div class="">{{review.body}}</div>
                    </div>
                    <div class="border-b"></div>
                </div>
                <div class="flex justify-center">
                    <pagination :links="reviews.links" class="mb-3"/>
                </div>
            </div>
        </section>
    </ProfileLayout>
</template>
