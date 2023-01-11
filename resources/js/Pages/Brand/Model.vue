<script setup>
import Model from "@/components/Model.vue"

const props = defineProps({
    brand: Object
})

</script>

<template>
    <Model :model="brand" route_name="brands">
        <template #name>
            {{ brand.name }}
        </template>
    </Model>
</template>
