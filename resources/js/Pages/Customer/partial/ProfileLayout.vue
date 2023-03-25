<script setup>
import CustomerLayout from "@/Layouts/CustomerLayout.vue"
import ProfileSideLinks from "@/Pages/Customer/partial/ProfileSideLinks.vue";
import {InertiaLink} from "@inertiajs/inertia-vue3";
</script>

<template>
    <CustomerLayout>
        <!-- account wrapper -->
        <div class="container grid grid-cols-12 items-start gap-6 pt-4 pb-16">

            <!-- sidebar -->
            <div class="col-span-3">
                <div class="px-4 py-3 shadow flex items-center gap-4">
                    <div class="flex-shrink-0">
                        <img src="/assets/avatar.png" alt="profile"
                             class="rounded-full w-14 h-14 border border-gray-200 p-1 object-cover">
                    </div>
                    <div class="flex-grow">
                        <p class="text-gray-600">Hello,</p>
                        <h4 class="text-gray-800 font-medium">{{$page.props.auth.user.name}}</h4>
                    </div>
                </div>

                <div class="mt-6 bg-white shadow rounded p-4 divide-y divide-gray-200 space-y-4 text-gray-600">
                    <div class="space-y-1 pl-8">
                        <ProfileSideLinks url="profile" label="Manage account">
                            <i class="fa-regular fa-address-card"></i>
                        </ProfileSideLinks>
<!--                        <ProfileSideLinks url="profile" label="Profile information"/>-->
                        <ProfileSideLinks url="address" label="Manage addresses"/>
                        <ProfileSideLinks url="password" label="Change Password"/>
                    </div>

                    <div class="space-y-1 pl-8 pt-4">
                        <ProfileSideLinks url="orders.index" label="My Order History">
                            <i class="fa-solid fa-box-archive"></i>
                        </ProfileSideLinks>
                        <a href="#" class="relative hover:text-primary block capitalize transition">
                            My returns
                        </a>
                        <a href="#" class="relative hover:text-primary block capitalize transition">
                            My Cancellations
                        </a>
                        <ProfileSideLinks url="reviews.index" label="My reviews"/>
                    </div>

                    <div class="space-y-1 pl-8 pt-4">
                        <a href="#" class="relative hover:text-primary block font-medium capitalize transition">
                        <span class="absolute -left-8 top-0 text-base">
                            <i class="fa-regular fa-credit-card"></i>
                        </span>
                            Payment methods
                        </a>
                        <a href="#" class="relative hover:text-primary block capitalize transition">
                            voucher
                        </a>
                    </div>

                    <div class="space-y-1 pl-8 pt-4">
                        <ProfileSideLinks url="wishlist" label="My wishlist">
                            <i class="fa-regular fa-heart"></i>
                        </ProfileSideLinks>
                    </div>

                    <div class="space-y-1 pl-8 pt-4">
                        <InertiaLink :href="route('logout')"
                                     method="post"
                                     as="button"
                                     class="relative hover:text-primary block font-medium capitalize transition">
                        <span class="absolute -left-8 top-0 text-base">
                            <i class="fa fa-arrow-right-from-bracket"></i>
                        </span>
                            Logout
                        </InertiaLink>
                    </div>

                </div>
            </div>
            <!-- ./sidebar -->

            <slot></slot>

        </div>
        <!-- ./account wrapper -->
    </CustomerLayout>
</template>
