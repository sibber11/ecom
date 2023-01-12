<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import {Head, Link} from '@inertiajs/inertia-vue3';
import SecondaryButton from '@/components/SecondaryButton.vue'
import FlashMessage from "@/components/FlashMessage.vue";
import {Table} from "@protonemedia/inertiajs-tables-laravel-query-builder";
import EditButton from "@/components/EditButton.vue";
import DeleteButton from "@/components/DeleteButton.vue";


defineProps({
    brands: Object,
});
</script>

<template>
    <Head title="Create Brand"/>

    <AuthenticatedLayout>
        <template #header>
            <div class="flex justify-between">
                <h2 class="font-semibold text-xl text-gray-800 leading-tight">Create Brand</h2>
                <Link :href="route('brands.create')">
                    <SecondaryButton type="button">
                        Create New Brand
                    </SecondaryButton>
                </Link>
            </div>
        </template>
        <FlashMessage/>

        <div class="py-5">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">
                <Table :resource="brands" :striped="true">
                    <template #cell(actions)="{ item: category }">
                        <EditButton :url="route('brands.edit', category)"/>
                        <DeleteButton :url="route('brands.destroy', category)"/>
                    </template>
                </Table>
            </div>
        </div>
    </AuthenticatedLayout>
</template>
