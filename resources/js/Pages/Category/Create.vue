<script setup>
import CreateEdit from "@/components/CreateEdit.vue"
import Fields from "@/Pages/Category/Partials/Fields.vue";

defineProps({
    category: Object,
});
</script>

<template>
    <CreateEdit title="Create Category">
        <Fields
            method="post"
            :url="route('categories.store')"
        />
    </CreateEdit>
</template>
