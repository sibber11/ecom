<script setup>

import Fields from "@/Pages/Admin/ProductAttribute/Partials/Fields.vue";
import CreateEdit from "@/components/CreateEdit.vue";

defineProps({
    attribute: Object,
});
</script>

<template>
    <CreateEdit title="Edit Product">
        <Fields
            :attribute="attribute"
            method="patch"
            :url="route('admin.attributes.update', attribute)"
        />
    </CreateEdit>
</template>
