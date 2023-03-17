<script setup>

import Fields from "@/Pages/Admin/ProductAttribute/Partials/Fields.vue";
import CreateEdit from "@/components/CreateEdit.vue";

defineProps({
    product: Object,
});
</script>

<template>
    <CreateEdit title="Create Product">
        <Fields
            method="post"
            :url="route('admin.attributes.store')"
        />
    </CreateEdit>
</template>
