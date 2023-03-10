<script setup>
import Model from '@/components/Model.vue';

const props = defineProps({
    product: Object
})
</script>

<template>
    <Model :model="product" route_name="products">
        <template #name>{{product.name}}</template>
        <div class="text-sm text-gray-600"><strong>SKU:</strong> {{ product.sku }}</div>
        <div class="text-sm text-gray-600" v-if="product.category"><strong>Category:</strong> {{ product.category.name }}</div>
        <div class="text-sm text-gray-600" v-if="product.brand"><strong>Brand:</strong> {{product.brand.name}}</div>
        <div class="text-sm"><strong>Price:</strong> {{ product.price }}</div>
        <div class="text-sm"><strong>Stock:</strong> {{ product.quantity }}</div>
        <p class="text-gray-800"><strong>Description:</strong> {{ product.description }}</p>
        <div class="text-sm text-gray-600" v-if="product.tags">
            <span><strong>Tags: </strong> </span>
            <span v-for="tag in product.tags" :key="tag.id" class="text-cyan-500"> {{ tag.name.en }},  </span>
        </div>
    </Model>
</template>
