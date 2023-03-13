<script setup>
import ProductModel from "@/Pages/Partials/ProductModel.vue";
defineProps({
    products: Object
})

</script>
<template>
  <div class="container pb-16">
    <h2 class="text-2xl font-medium text-gray-800 uppercase mb-6">
        <slot>
        </slot>
    </h2>
    <div class="grid grid-cols-4 gap-6">
        <ProductModel v-for="product in products.data" :product="product" :key="product.id"/>
    </div>
  </div>
</template>
