<script setup>
import {InertiaLink} from "@inertiajs/inertia-vue3";
import SearchBar from "@/components/SearchBar.vue";
</script>
<template>
    <header class="py-4 shadow-sm bg-white">
        <div class="container flex items-center justify-between">
            <InertiaLink :href="route('home')">
                <img src="/assets/logo.svg" alt="Logo" class="w-32">
            </InertiaLink>

            <SearchBar/>

            <div class="flex items-center space-x-4">
                <InertiaLink :href="route('wishlist')" class="text-center text-gray-700 hover:text-primary transition relative">
                    <div class="text-2xl">
                        <i class="fa fa-heart"></i>
                    </div>
                    <div class="text-xs leading-3">Wishlist</div>
                    <div
                        class="absolute right-0 -top-1 w-5 h-5 rounded-full flex items-center justify-center bg-primary text-white text-xs">
                        {{ $page.props.wishlist }}
                    </div>
                </InertiaLink>
                <InertiaLink :href="route('cart')" class="text-center text-gray-700 hover:text-primary transition relative">
                    <div class="text-2xl">
                        <i class="fa fa-shopping-cart"></i>
                    </div>
                    <div class="text-xs leading-3">Cart</div>
                    <div
                        class="absolute -right-3 -top-1 w-5 h-5 rounded-full flex items-center justify-center bg-primary text-white text-xs">
                        {{ $page.props.cart }}
                    </div>
                </InertiaLink>
                <InertiaLink :href="route('profile')" class="text-center text-gray-700 hover:text-primary transition relative" v-if="$page.props.auth.user">
                        <div class="text-2xl">
                            <i class="fa fa-user"></i>
                        </div>
                        <div class="text-xs leading-3">
                            Account
                        </div>
                </InertiaLink>

            </div>
        </div>
    </header>
</template>
