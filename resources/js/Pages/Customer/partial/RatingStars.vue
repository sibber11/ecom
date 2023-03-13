<template>
    <i v-for="i in 5" :class="{'text-red-600':rating >= i}"
       class="fa fa-star">
    </i>
</template>

<script setup>
defineProps({
    rating: {
        type: Number,
        required: true
    }
})
</script>
