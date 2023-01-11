<script setup>
import {Link, InertiaLink} from "@inertiajs/inertia-vue3";
defineProps({
    model: Object,
    route_name: String
})
</script>

<template>
    <div class="p-2 sm:p-4 bg-white shadow sm:rounded-lg">
        <div class="">
            <h3 class="text-xl font-bold text-gray-800 capitalize">
                <slot name="name"></slot>
            </h3>
        </div>
        <div class="pt-2">
            <slot></slot>
            <Link :href="route(route_name+'.edit',model)" class="text-blue-500">
                Edit
            </Link>
            <InertiaLink :href="route(route_name+'.destroy',model)" as="button" method="delete" class="text-red-600">
                Delete
            </InertiaLink>
        </div>
    </div>

</template>
