<script setup>
import {ref} from "vue";
import {InertiaLink} from "@inertiajs/inertia-vue3";

defineProps({
    model: Object,
    urlName: String
})

const preview_list = ref([]);
const image_list = ref([]);
const preview = function (event) {
    const input = event.target;
    let count = input.files.length;
    let index = 0;
    //empty preview_list and image_list
    preview_list.value = [];
    image_list.value = [];
    if (input.files) {
        while (count--) {
            const reader = new FileReader();
            reader.onload = (e) => {
                preview_list.value.push(e.target.result);
            }
            image_list.value.push(input.files[index]);
            reader.readAsDataURL(input.files[index]);
            index++;
        }
    }
}

defineExpose({preview})
</script>

<template>
    <template v-if="preview_list.length">
        <div class="flex mt-8 flex-wrap justify-start">
            <div v-for="(item, index) in preview_list" :key="index"
                 class="border-2 p-1 rounded flex flex-col justify-between m-1">
                <img :src="item" class="w-52" alt="images"/>
                <div>
                    <p class="">File name: {{ image_list[index].name }}</p>
                    <p class="">Size: {{ Math.floor(image_list[index].size / 1024) }} KB</p>
                </div>
            </div>
        </div>
    </template>
    <template v-if="model?.media">
        <div class="flex mt-8 flex-wrap justify-start">
            <div v-for="(item, index) in model.media" :key="index"
                 class="border-2 p-1 rounded flex flex-col justify-between m-1">
                <img :src="item.original_url" class="w-52" alt="images"/>
                <InertiaLink :href="route(urlName, [model, item])" as="button" preserve-scroll
                             method="delete"
                             class="text-center border border-red-300 text-red-600 text-3xl">
                    <i class="fa fa-trash"></i>
                    <span class="m-2 font-bold">Delete</span>
                </InertiaLink>
            </div>
        </div>
    </template>
</template>
