<script setup>
import {InertiaLink} from "@inertiajs/inertia-vue3";

const props = defineProps({
    url: String
})
</script>
<template>
    <InertiaLink :href="url" class="px-1 py-0.5 border rounded bg-blue-500 text-white">
        <i class="fa fa-sm fa-eye"></i>
    </InertiaLink>
</template>
