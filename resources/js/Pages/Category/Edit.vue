<script setup>
import CreateEdit from '@/components/CreateEdit.vue'
import Fields from '@/Pages/Category/Partials/Fields.vue';

defineProps({
    category: Object,
});
</script>

<template>
    <CreateEdit title="Edit Category">
        <Fields
            :category="category"
            method="patch"
            :url="route('categories.update', category)"
        />
    </CreateEdit>
</template>
