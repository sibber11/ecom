<script setup>
import { ref } from 'vue';
import Dropdown from "@/components/Dropdown.vue";
import {usePage, InertiaLink} from "@inertiajs/inertia-vue3";

// console.log()

const messages = ref(usePage().props.value.notifications);

Echo.private('admin-notifications')
    .notification((notification) => {
        console.log(notification);
        messages.value.push(notification);
    });

</script>

<template>
    <Dropdown>
        <template #trigger>
                    <i class="fa fa-bell hover:text-blue-700 cursor-pointer"></i>
                    <div class="absolute top-0 right-0 bg-red-500 rounded-full w-2 h-2" v-show="messages.length"></div>
        </template>
        <template #content>
            <div class="text-right">
                <InertiaLink class="" :href="route('admin.read-notifications')" as="button" method="post" type="button">
                    Mark all as read
                </InertiaLink>
            </div>
            <ul v-if="messages.length" class="m-1">
                <li v-for="message in messages" :key="message" class="border-b p-2 flex gap-4 justify-between">
                    <InertiaLink :href="message.data.link" >
                        {{ message.data.message }}
                    </InertiaLink>
<!--                    <InertiaLink :href="message.data.link" >-->
<!--                        <i class="fa fa-check"></i>-->
<!--                    </InertiaLink>-->
<!--                    <InertiaLink :href="message.data.link" >-->
<!--                        <i class="fa fa-trash-alt text-red-500"></i>-->
<!--                    </InertiaLink>-->
                </li>
            </ul>
            <div v-else class="m-1">
                No new notifications
            </div>
        </template>
    </Dropdown>
</template>
