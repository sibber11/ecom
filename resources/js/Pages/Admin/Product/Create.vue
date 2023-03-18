<script setup>

import Fields from "@/Pages/Admin/Product/Partials/Fields.vue";
import CreateEdit from "@/components/CreateEdit.vue";

defineProps({
    options: Array,
});
</script>

<template>
    <CreateEdit title="Create Product">
        <Fields
            method="post"
            :url="route('admin.products.store')"
            :options="options"
        />
    </CreateEdit>
</template>
