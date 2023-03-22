<script setup>
import ProfileLayout from "@/Pages/Customer/partial/ProfileLayout.vue";
import {useForm} from "@inertiajs/inertia-vue3";
const props = defineProps({
    order: {
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
                {{order}}
            </div>
        </section>
    </ProfileLayout>
</template>
