<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import {Head, Link} from '@inertiajs/inertia-vue3';
import SecondaryButton from '@/components/SecondaryButton.vue'
import Category from '@/Pages/Category/Model.vue'
import Pagination from '@/components/Pagination.vue'
import FlashMessage from "@/components/FlashMessage.vue";


defineProps({
    categories: Object,
});
</script>

<template>
    <Head title="Create Category" />

    <AuthenticatedLayout>
        <template #header>
            <div class="flex justify-between">
                <h2 class="font-semibold text-xl text-gray-800 leading-tight">Create Category</h2>
                <Link :href="route('categories.create')">
                    <SecondaryButton type="button">
                        Create New Category
                    </SecondaryButton>
                </Link>
            </div>
        </template>
        <FlashMessage/>

        <div class="py-5">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">
                <Category v-for="category in categories.data" :category="category" :key="category.id"/>
                <Pagination :links="categories.links"/>
            </div>
        </div>
    </AuthenticatedLayout>
</template>
