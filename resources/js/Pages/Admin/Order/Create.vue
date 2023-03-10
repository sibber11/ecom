<script setup>

import Fields from "@/Pages/Admin/User/Partials/Fields.vue";
import CreateEdit from "@/components/CreateEdit.vue";

defineProps({
    user: Object,
});
</script>

<template>
    <CreateEdit title="Create User">
        <Fields
            method="post"
            :url="route('admin.orders.store')"
        />
    </CreateEdit>
</template>
