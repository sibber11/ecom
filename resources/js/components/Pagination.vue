<script setup>
import {InertiaLink} from "@inertiajs/inertia-vue3";

const props = defineProps({
    links: Array,
})
</script>
<template>
    <div>
        <ul class="flex pl-0 list-none rounded my-2">
            <li
                class="border-r-0 relative block py-2 px-3 leading-tight bg-white border border-gray-300 text-blue-700 hover:bg-gray-200"
                :class="{
                'rounded-l':index === 0,
                'rounded-r !border-r':index === links.length - 1,
                'bg-blue-500 text-white': link.active === true
            }"
                v-for="(link, index) in links"
                :key="link.index"
            >
                 <span>
                    <InertiaLink
                        :href="link.url"
                        class="page-link"
                        v-html="link.label"
                        :disabled="link.url"
                    />
                 </span>
            </li>
        </ul>
    </div>
</template>
