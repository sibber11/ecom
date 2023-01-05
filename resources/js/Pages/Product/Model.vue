<script setup>
import {Link} from "@inertiajs/inertia-vue3";

const props = defineProps({
    product: Object
})
</script>

<template>
    <div class="p-2 sm:p-4 bg-white shadow sm:rounded-lg">
        <div class="">
            <h3 class="text-xl font-bold text-gray-800 capitalize">{{ product.name }}</h3>
        </div>
        <div class="pt-2">
            <div class="text-sm text-gray-600">SKU: {{ product.sku }}</div>
            <div class="text-sm text-gray-600" v-if="product.category">Category: {{ product.category.name }}</div>
            <div class="text-sm text-gray-600">Price: {{ product.price }}</div>
            <!--            <div class="text-sm text-gray-600">Brand: {{product.brand}}</div>-->
            <p class="text-gray-800">Description: {{ product.description }}</p>
            <div class="text-sm text-gray-600">
                <span>Tags: </span>
                <template v-if="product.tags.length > 0">
                    <span v-for="tag in product.tags" :key="tag.id" class="text-cyan-500"> {{ tag.name.en }},  </span>
                </template>
                <span v-else> No Tags </span>
            </div>
            <Link :href="route('products.edit',product)" class="text-blue-500 hover:underline">
                Edit
            </Link>
            <Link :href="route('products.destroy',product)" as="button" method="delete"
                  class="text-red-600 hover:underline">
                Delete
            </Link>
        </div>
    </div>

</template>
