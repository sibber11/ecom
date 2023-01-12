<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import {Head, Link} from '@inertiajs/inertia-vue3';
import SecondaryButton from '@/components/SecondaryButton.vue'
import FlashMessage from "@/components/FlashMessage.vue";
import {Table} from "@protonemedia/inertiajs-tables-laravel-query-builder";
import EditButton from "@/components/EditButton.vue";
import DeleteButton from "@/components/DeleteButton.vue";


defineProps({
    products: Object,
});
</script>

<template>
    <Head title="Create Product" />

    <AuthenticatedLayout>
        <template #header>
            <div class="flex justify-between">
                <h2 class="font-semibold text-xl text-gray-800 leading-tight">Create Product</h2>
                <Link :href="route('products.create')">
                    <SecondaryButton type="button">
                        Create New Product
                    </SecondaryButton>
                </Link>
            </div>
        </template>
        <FlashMessage/>

        <div class="py-5">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">
                <Table :resource="products" :striped="true">
                    <template #cell(actions)="{ item: product}">
                        <EditButton :url="route('products.edit', product)"/>
                        <DeleteButton :url="route('products.destroy', product)"/>
                    </template>
                    <template #cell(category)="{ item: product}">
                        {{product.category.name}}
                    </template>
                    <template #cell(brand)="{ item: product}">
                        {{product.brand.name}}
                    </template>
                </Table>
            </div>
        </div>
    </AuthenticatedLayout>
</template>
