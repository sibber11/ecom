<script setup>

import {InertiaLink} from "@inertiajs/inertia-vue3";

defineProps({
    url: String
})

</script>

<template>
    <InertiaLink :href="url" as="button" method="delete" class="px-2 py-1 border mx-1 rounded bg-red-600 text-white">
        Delete
    </InertiaLink>
</template>
