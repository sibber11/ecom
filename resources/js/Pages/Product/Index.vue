<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import {Head, Link} from '@inertiajs/inertia-vue3';
import SecondaryButton from '@/components/SecondaryButton.vue'
import Product from '@/Pages/Product/Model.vue'
import Pagination from '@/components/Pagination.vue'
import FlashMessage from "@/components/FlashMessage.vue";


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
                <Product v-for="product in products.data" :product="product" :key="product.id"/>
                <Pagination :links="products.links"/>
            </div>
        </div>
    </AuthenticatedLayout>
</template>
