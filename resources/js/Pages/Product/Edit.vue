<script setup>

import Fields from "@/Pages/Product/Partials/Fields.vue";
import CreateEdit from "@/components/CreateEdit.vue";

defineProps({
    product: Object,
});
</script>

<template>
    <CreateEdit title="Edit Product">
        <Fields
            :product="product"
            method="patch"
            :url="route('products.update', product)"
        />
    </CreateEdit>
</template>
