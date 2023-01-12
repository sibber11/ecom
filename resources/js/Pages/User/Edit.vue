<script setup>
import Fields from "@/Pages/User/Partials/Fields.vue";
import CreateEdit from "@/components/CreateEdit.vue";

    defineProps

({
    user: Object,
});
</script>

<template>
    <CreateEdit title="Edit User">
        <Fields
            :user="user"
            method="patch"
            :url="route('users.update', user)"
        />
    </CreateEdit>
</template>
