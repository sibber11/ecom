<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import {Head, Link} from '@inertiajs/inertia-vue3';
import SecondaryButton from '@/components/SecondaryButton.vue'
import FlashMessage from "@/components/FlashMessage.vue";
import {Table} from "@protonemedia/inertiajs-tables-laravel-query-builder";
import EditButton from "@/components/EditButton.vue";
import DeleteButton from "@/components/DeleteButton.vue";


defineProps({
    attributes: Object,
});
</script>

<template>
    <Head title="Create Product" />

    <AuthenticatedLayout>
        <template #header>
            <div class="flex justify-between">
                <h2 class="font-semibold text-xl text-gray-800 leading-tight">Attributes</h2>
                <Link :href="route('admin.attributes.create')">
                    <SecondaryButton type="button">
                        Create New Product Attribute
                    </SecondaryButton>
                </Link>
            </div>
        </template>
        <FlashMessage/>

        <div class="py-5">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">
                <Table :resource="attributes" :striped="true">
                    <template #cell(actions)="{ item: attribute}">
                        <EditButton :url="route('admin.attributes.edit', attribute)"/>
                        <DeleteButton :url="route('admin.attributes.destroy', attribute)"/>
                    </template>
                    <template #cell(options)="{item:arrtibute}">
                        <ul class="flex flex-wrap">
                            <li v-for="option in arrtibute.options"
                                class="inline bg-gray-200 text-gray-800 rounded px-2 py-1 text-sm font-semibold m-1"
                            >
                                {{ option.name }}
                            </li>
                        </ul>
                    </template>
                </Table>
            </div>
        </div>
    </AuthenticatedLayout>
</template>
