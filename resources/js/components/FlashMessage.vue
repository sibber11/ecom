<script setup>

import {Inertia} from "@inertiajs/inertia";
import {ref} from "vue";

const show = ref(true);
const timeout = ref(null);
Inertia.on('finish', function () {
    show.value = true;
    clearTimeout(timeout.value);
    timeout.value = setTimeout(() => {
        show.value = false;
    }, 3000);
});

</script>

<template>

    <transition
        enter-active-class="transition ease-out duration-300"
        enter-from-class="transform opacity-0 translate-y-20"
        enter-to-class="transform opacity-100 translate-y-0"
        leave-active-class="transition ease-in duration-300"
        leave-from-class="transform opacity-100 translate-y-0"
        leave-to-class="transform opacity-0 translate-y-20"
        appear
    >
        <div class="fixed right-4 bottom-4 z-10" v-if="show && ($page.props.flash.error || $page.props.flash.success)">
        <p class="p-3 rounded font-bold border-2"
           v-show="show"
           :class="{'border-green-600 bg-green-400': $page.props.flash.success, 'border-red-600 bg-red-400': $page.props.flash.error,}">
            <span>{{ $page.props.flash.error }}</span>
            <span>{{ $page.props.flash.success }}</span>
            <button class="text-red-500 ml-4" @click="show = false">x</button>
        </p>
    </div>
    </transition>
</template>
