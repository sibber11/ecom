<script setup>
import CreateEdit from "@/components/CreateEdit.vue"
import Fields from "@/Pages/Brand/Partials/Fields.vue";

defineProps({
    brand: Object,
});
</script>

<template>
    <CreateEdit title="Create Brand">
        <Fields
            :brand="brand"
            method="patch"
            :url="route('brands.update',brand)"
        />
    </CreateEdit>
</template>
