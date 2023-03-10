<script setup>
import CreateEdit from "@/components/CreateEdit.vue"
import Fields from "@/Pages/Admin/Category/Partials/Fields.vue";

defineProps({
    category: Object,
});
</script>

<template>
    <CreateEdit title="Create Category">
        <Fields
            method="post"
            :url="route('admin.categories.store')"
        />
    </CreateEdit>
</template>
