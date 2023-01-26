<script setup>
import {inject} from "vue";

const categories = inject('categories');

</script>
<template>
  <div class="container py-16">
    <h2 class="text-2xl font-medium text-gray-800 uppercase mb-6">shop by category</h2>
    <div class="grid grid-cols-3 gap-3">
      <div class="relative rounded-sm overflow-hidden group" v-for="category in categories">
        <img :src="category.media[0]?.original_url" :alt="category.name" class="w-full">
        <a href="#"
           class="absolute inset-0 bg-black bg-opacity-40 flex items-center justify-center text-xl text-white font-roboto font-medium group-hover:bg-opacity-60 transition">
            {{category.name}}
        </a>
      </div>
    </div>
  </div>
</template>
