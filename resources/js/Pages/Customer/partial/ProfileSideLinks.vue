<script setup>
import {InertiaLink} from "@inertiajs/inertia-vue3";

defineProps({
    url: String,
    label:String
})
</script>

<template>
    <InertiaLink :class="{'text-primary':route().current(url)}" :href="route(url)"
                 class="relative hover:text-primary block font-medium capitalize transition">
        <span class="absolute -left-8 top-0 text-base">
            <slot></slot>
        </span>
        {{label}}
    </InertiaLink>
</template>
