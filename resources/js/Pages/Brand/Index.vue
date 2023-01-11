<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import {Head, Link} from '@inertiajs/inertia-vue3';
import SecondaryButton from '@/components/SecondaryButton.vue'
import Brand from '@/Pages/Brand/Model.vue'
import Pagination from '@/components/Pagination.vue'
import FlashMessage from "@/components/FlashMessage.vue";


defineProps({
    brands: Object,
});
</script>

<template>
    <Head title="Create Brand" />

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
                <Brand v-for="brand in brands.data" :brand="brand" :key="brand.id"/>
                <Pagination :links="brands.links"/>
            </div>
        </div>
    </AuthenticatedLayout>
</template>
