<script setup>

import Fields from "@/Pages/User/Partials/Fields.vue";
import CreateEdit from "@/components/CreateEdit.vue";

defineProps({
    user: Object,
});
</script>

<template>
    <CreateEdit title="Create User">
        <Fields
            method="post"
            :url="route('users.store')"
        />
    </CreateEdit>
</template>
