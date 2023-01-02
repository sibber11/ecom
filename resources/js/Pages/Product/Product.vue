<script setup>
import {Link} from "@inertiajs/inertia-vue3";
const props = defineProps({
    product: Object
})
</script>

<template>
    <div class="p-2 sm:p-4 bg-white shadow sm:rounded-lg">
        <div class="">
            <h3 class="text-xl font-bold text-gray-800 capitalize">{{product.name}}</h3>
        </div>
        <div class="pt-2">
            <div class="text-sm text-gray-600">SKU: {{product.sku}}</div>
<!--            <div class="text-sm text-gray-600">Category: {{product.category}}</div>-->
<!--            <div class="text-sm text-gray-600">Brand: {{product.brand}}</div>-->
            <p class="text-gray-800">{{product.description}}</p>
            <Link :href="route('product.edit',product)" class="text-blue-500">
                Edit
            </Link>
            <Link :href="route('product.destroy',product)" as="button" method="delete" class="text-red-600">
                Delete
            </Link>
        </div>
    </div>

</template>
