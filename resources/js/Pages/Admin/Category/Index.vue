<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import {Head, Link} from '@inertiajs/inertia-vue3';
import SecondaryButton from '@/components/SecondaryButton.vue'
import FlashMessage from "@/components/FlashMessage.vue";
import {Table} from '@protonemedia/inertiajs-tables-laravel-query-builder'
import EditButton from "@/components/EditButton.vue";
import DeleteButton from "@/components/DeleteButton.vue";

defineProps({
    categories: Object,
});
</script>

<template>
    <Head title="Create Category" />

    <AuthenticatedLayout>
        <template #header>
            <div class="flex justify-between">
                <h2 class="font-semibold text-xl text-gray-800 leading-tight">Categories</h2>
                <Link :href="route('admin.categories.create')">
                    <SecondaryButton type="button">
                        Create New Category
                    </SecondaryButton>
                </Link>
            </div>
        </template>
        <FlashMessage/>

        <div class="py-5">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">
<!--                <Model v-for="category in categories.data" :category="category" :key="category.id"/>-->
                <Table :resource="categories" :striped="true">
                    <template #cell(image)="{ item: category }">
                        <img :src="category.media[0]?.original_url" v-show="category.media[0]" alt="category image" class="w-28">
                    </template>
                    <template #cell(actions)="{ item: category }">
                        <EditButton :url="route('admin.categories.edit', category)"/>
                        <DeleteButton :url="route('admin.categories.destroy', category)" />
                    </template>
                </Table>
            </div>
        </div>
    </AuthenticatedLayout>
</template>
