<script setup>
import {InertiaLink} from "@inertiajs/inertia-vue3";

const props = defineProps({
    url: String
})
</script>
<template>
    <InertiaLink :href="url" class="px-2 py-1 border mx-1 rounded">
        Edit
    </InertiaLink>
</template>
