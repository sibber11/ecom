<script setup>
import {Link} from "@inertiajs/inertia-vue3";
import {onMounted, ref} from "vue";
const props = defineProps({
    category: Object
})
// data property named as parent_name
const parent_name = ref('');
onMounted(() => {
    if (props.category.ancestors.length > 0) {
        parent_name.value = props.category.ancestors.reduce(
            (accumulator,currentValue, currentIndex, array) => {
                let temp = (currentIndex === array.length - 1)?'':' -> '
                return accumulator + currentValue.name + temp
            },'')
    }else {
        return ''
    }
})
</script>

<template>
    <div class="p-2 sm:p-4 bg-white shadow sm:rounded-lg">
        <div class="">
            <h3 class="text-xl font-bold text-gray-800 capitalize">{{ category.name }}</h3>
        </div>
        <div class="pt-2">
            <div class="text-sm text-gray-600" v-if="parent_name">Parent: {{ parent_name }}</div>
<!--            <div class="text-sm text-gray-600">Category: {{category.category}}</div>-->
<!--            <div class="text-sm text-gray-600">Brand: {{category.brand}}</div>-->
<!--            <p class="text-gray-800">{{ category.description }}</p>-->
            <Link :href="route('categories.edit',category)" class="text-blue-500">
                Edit
            </Link>
            <Link :href="route('categories.destroy',category)" as="button" method="delete" class="text-red-600">
                Delete
            </Link>
        </div>
    </div>

</template>
