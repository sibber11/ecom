<script setup>
import CreateEdit from "@/components/CreateEdit.vue"
import Fields from "@/Pages/Admin/Brand/Partials/Fields.vue";

defineProps({
    brand: Object,
});
</script>

<template>
    <CreateEdit title="Create Brand">
        <Fields
            :brand="brand"
            method="post"
            :url="route('admin.brands.store')"
        />
    </CreateEdit>
</template>
