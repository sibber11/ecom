<script setup>
import {InertiaLink} from "@inertiajs/inertia-vue3";

</script>
<template>
    <nav class="bg-gray-800">
        <div class="container flex">
            <div class="px-8 py-4 bg-primary flex items-center cursor-pointer relative group">
                <span class="text-white">
                    <i class="fa-solid fa-bars"></i>
                </span>
                <span class="capitalize ml-2 text-white">All Categories</span>

                <!-- dropdown -->
                <div
                    class="absolute w-full left-0 top-full bg-white shadow-md py-3 divide-y divide-gray-300 divide-dashed opacity-0 group-hover:opacity-100 transition duration-300 invisible group-hover:visible">
                    <template v-for="category in $page.props.categories" :key="category.id">
                        <InertiaLink href="#" class="flex items-center px-6 py-3 hover:bg-gray-100 transition">
                            <img src="" alt="sofa" class="w-5 h-5 object-contain">
                            <span class="ml-6 text-gray-600 text-sm">{{ category.name }}</span>
                        </InertiaLink>
                    </template>

                </div>
            </div>

            <div class="flex items-center justify-between flex-grow pl-12">
                <div class="flex items-center space-x-6 capitalize">
                    <InertiaLink :href="route('home')" class="text-gray-200 hover:text-white transition">Home
                    </InertiaLink>
                    <InertiaLink href="pages/shop.html" class="text-gray-200 hover:text-white transition">Shop
                    </InertiaLink>
                    <InertiaLink href="#" class="text-gray-200 hover:text-white transition">About us</InertiaLink>
                    <InertiaLink href="#" class="text-gray-200 hover:text-white transition">Contact us</InertiaLink>
                </div>
                <div class="flex justify-end space-x-6">
                    <InertiaLink
                        :href="route('login')"
                        class="text-gray-200 hover:text-white transition"
                        v-if="!$page.props.auth.user"
                    >
                        Login
                    </InertiaLink>
                    <InertiaLink
                        :href="route('register')"
                        class="text-gray-200 hover:text-white transition"
                        v-if="!$page.props.auth.user"
                    >
                        Register
                    </InertiaLink>
                    <InertiaLink
                        :href="route('logout')"
                        class="text-gray-200 hover:text-white transition"
                        v-if="$page.props.auth.user"
                        as="button"
                        method="post"
                    >
                        Logout
                    </InertiaLink>
                </div>
            </div>
        </div>
    </nav>
</template>
