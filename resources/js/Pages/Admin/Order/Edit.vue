<script setup>
import Fields from "@/Pages/Admin/Order/Partials/Fields.vue";
import CreateEdit from "@/components/CreateEdit.vue";

    defineProps

({
    order: Object,
});
</script>

<template>
    <CreateEdit title="Edit User">
        <Fields
            :order="order"
            method="patch"
            :url="route('admin.orders.update', order)"
        />
    </CreateEdit>
</template>
