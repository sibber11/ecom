<script setup>

import {InertiaLink} from "@inertiajs/inertia-vue3";

defineProps({
    url: String
})

</script>

<template>
    <InertiaLink :href="url" as="button" method="delete" class="px-1 py-0.5 border rounded bg-red-600 text-white">
        <i class="fa fa-trash-alt"></i>
    </InertiaLink>
</template>
