<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import {Head} from '@inertiajs/inertia-vue3';
import FlashMessage from "@/components/FlashMessage.vue";
import {Table} from "@protonemedia/inertiajs-tables-laravel-query-builder";
import DeleteButton from "@/components/DeleteButton.vue";


defineProps({
    orders: Object,
});
</script>

<template>
    <Head title="Create User" />

    <AuthenticatedLayout>
        <template #header>
            <div class="flex justify-between">
                <h2 class="font-semibold text-xl text-gray-800 leading-tight">Orders</h2>
            </div>
        </template>
        <FlashMessage/>

        <div class="py-5">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">
                <Table :resource="orders" :striped="true">
                    <template #cell(actions)="{ item: order}">
                        <DeleteButton :url="route('admin.orders.destroy', order)"/>
                    </template>
                </Table>
            </div>
        </div>
    </AuthenticatedLayout>
</template>
