<template>
  <div class="pt-5" v-if="message && show">
    <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">
      <p class="bg-green-400 p-3 w-full rounded font-bold border-green-600 border-2">
        <span>{{ message }}</span>
        <button class="float-right text-red-500" @click="show = false">x</button>
      </p>
    </div>
  </div>
</template>
<script setup>

import {Inertia} from "@inertiajs/inertia";
import {ref} from "vue";

const props = defineProps({
    message: String
})
let show = ref(true);
Inertia.on('finish', function (){
    show.value=true;
})
</script>
