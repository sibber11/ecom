<script setup>

import {onMounted, ref} from "vue";
import debounce from "lodash/debounce";
import TextInput from "@/Components/TextInput.vue";

defineProps(['modelValue']);

defineEmits(['update:modelValue']);

const categories = ref([]);

//fetch parent categories using a function with debounce
const fetchCategories = debounce((event) => {
    axios.post(route('categories.get_category', {
        category_name: event.target.value
    }))
        .then((r) => {
            categories.value = r.data
        })
}, 300)

onMounted(() => {
    if (categories.value.length === 0) {
        axios.post(route('categories.get_category', {
            category_name: ''
        }))
            .then((r) => {
                categories.value = r.data
            })
    }
})

</script>

<template>

    <TextInput
        id="category_name"
        type="text"
        class="mt-1 block w-full"
        @input="fetchCategories($event); $emit('update:modelValue', $event.target.value)"
        :value="modelValue"
        list="category-name"
        ref="textinput"
        placeholder="Category Name"
    />

    <datalist id="category-name">
        <option v-for="category in categories" :value="category.name" :key="category.id"></option>
    </datalist>

</template>
