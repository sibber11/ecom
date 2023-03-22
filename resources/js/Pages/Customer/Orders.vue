<script setup>
import ProfileLayout from "@/Pages/Customer/partial/ProfileLayout.vue";
import {InertiaLink} from "@inertiajs/inertia-vue3";
import {useForm} from "@inertiajs/inertia-vue3";
const props = defineProps({
    orders: {
        type: Object,
        required: true
    }
});

const cancelOrder = (order) => {
    useForm({
        id: order.id,
        _method: 'DELETE'
    }).post(route('orders.destroy', order.id), {
        preserveState: true,
    });
}
</script>

<template>
    <ProfileLayout>
        <section class="col-span-9">
            <h2 class="text-lg font-medium text-gray-800 mb-4 font-">Order History</h2>
            <div class="overflow-x-auto shadow-md sm:rounded-lg">
                <table class="w-full text-gray-500 text-sm">
                    <thead class="text-gray-700 uppercase bg-gray-50">
                    <tr>
                        <th scope="col" class="px-6 py-3">ID</th>
                        <th scope="col" class="px-6 py-3">Date</th>
                        <th scope="col" class="px-6 py-3">Total</th>
                        <th scope="col" class="px-6 py-3">Status</th>
                        <th scope="col" class="px-6 py-3">Actions</th>
                    </tr>
                    </thead>
                    <tbody>
                    <tr v-for="order in orders.data" :key="order.id" class="even:bg-gray-100 bg-white border-b">
                        <td class="px-6 py-4">{{order.id}}</td>
                        <td class="px-6 py-4">{{order.created_at}}</td>
                        <td class="px-6 py-4">{{order.total}}</td>
                        <td class="px-6 py-4 text-right">{{order.status}}</td>
                        <td class="px-6 py-4 text-right">
                            <InertiaLink :href="route('orders.show', order)" class="px-2 text-blue-500 hover:text-primary-dark">View</InertiaLink>
                            <button v-if="order.status  !== 'Cancelled' && order.status !== 'Completed'" type="button" class="px-2 text-red-600 hover:text-primary-dark" @click="cancelOrder(order)">
                                Cancel
                            </button>
                        </td>
                    </tr>
                    <tr v-if="!orders.data.length">
                        <td colspan="5">
                            <div class="flex justify-center items-center py-4">
                                <p class="text-gray-500">
                                    <span>No orders found.</span>
                                    <InertiaLink :href="route('home')" class="text-blue-500 hover:text-primary-darker px-2">Continue shopping</InertiaLink>
                                </p>
                            </div>
                        </td>
                    </tr>
                    </tbody>
                </table>
            </div>
        </section>
    </ProfileLayout>
</template>
