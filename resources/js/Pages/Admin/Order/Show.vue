<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import {Head, useForm} from '@inertiajs/inertia-vue3';
import FlashMessage from "@/components/FlashMessage.vue";
import {InertiaLink} from "@inertiajs/inertia-vue3";

const props = defineProps({
    order: Object,
});

const form = useForm({
    status: props.order.status,
    payment_status: props.order.payment_status,
});

function printComponent() {
    window.print();
}

function updateStatus() {
    form.patch(route('admin.orders.update', props.order.id), {
        preserveScroll: true,
        onSuccess: () => {

        },
        onError: () => {

        }
    });
}

</script>

<template>
    <Head :title="'Order ID - ' + order.id"  />

    <AuthenticatedLayout>
        <template #header>
            <div class="flex justify-between print:hidden">
                <h2 class="font-semibold text-xl text-gray-800 leading-tight">Order View</h2>
            </div>
        </template>
        <FlashMessage/>

        <div class="py-5" id="print">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6" >
                <div class="bg-white overflow-hidden shadow-xl print:shadow-none sm:rounded-lg">
                    <section class="flex justify-between p-6 print:hidden">
                        <div class="inline-flex justify-start">
                            <div class="flex gap-3">
                                <InertiaLink :href="route('admin.orders.index')" class="bg-gray-200 hover:bg-gray-300 text-gray-800 font-bold py-2 px-4 rounded inline-flex items-center">
                                    <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"></path>
                                    </svg>
                                    <span>Back</span>
                                </InertiaLink>
                                <button class="bg-gray-200 hover:bg-gray-300 text-gray-800 font-bold py-2 px-4 rounded inline-flex items-center"
                                        @click="printComponent"
                                >
                                    <i class="fa fa-print"></i>
                                </button>
                                <button class="bg-gray-200 hover:bg-gray-300 text-gray-800 font-bold py-2 px-4 rounded inline-flex items-center"
                                        @click="printComponent"
                                >
                                    <i class="fa fa-download"></i>
                                </button>
                            </div>
                        </div>
                        <div class="inline-flex justify-end">
                            <div class="mx-2">
                                <label for="">
                                    Order Status:
                                </label>
                                <select name="status" id="status" class="capitalize rounded border-gray-500" v-model="form.status" @change="updateStatus">
                                    <option v-for="status in order.statuses" :key="status" :value="status" :selected="order.status === status">{{ status }}</option>
                                </select>
                            </div>
                            <div class="mx-2">
                                <label for="">
                                    Payment Status:
                                </label>
                                <select name="payment_status" id="payment_status" class="capitalize rounded border-gray-500" v-model="form.payment_status" @change="updateStatus">
                                    <option v-for="status in order.payment_statuses" :key="status" :value="status" :selected="order.payment_status === status">{{ status }}</option>
                                </select>
                            </div>
                        </div>
                    </section>
                    <div class="border-t border-gray-200 print:hidden"></div>
                    <section class="grid grid-cols-3 grid-rows-2 p-6 text-gray-700 mb-6">
                        <div class="row-span-2 border-r-2 border-teal-600 m-4">
                            <h2 class="text-teal-600 font-bold text-4xl pb-4">INVOICE</h2>
                            <div class="pb-4">
                                <div class="text-teal-600 font-bold">Order ID:</div>
                                <div>{{order.id}}</div>
                            </div>
                            <div class="pb-4">
                                <div class="text-teal-600 font-bold">Payment:</div>
                                <div><span class="text-teal-600">Method: </span><span>{{order.payment_method}}</span></div>
                                <div><span class="text-teal-600">Status: </span><span>{{order.payment_status}}</span></div>
                            </div>
                            <div class="pb-4">
                                <div class="text-teal-600 font-bold">Order Date:</div>
                                <div>{{order.created_at}}</div>
                            </div>
                            <div class="">
                                <img :src="order.qr_code" alt="QR Code">
                            </div>
                        </div>
                        <div class="col-span-2 m-2">
                            <h3 class="text-2xl text-teal-600">Ultimate Ecommerce</h3>
                            <p>
                                todo: add company address
                            </p>
                        </div>
                        <div class="border-teal-600 border-r-2 pr-2">
                            <div class="text-teal-600 font-bold">Bill TO</div>
                            <div class="font-bold">{{order.customer_name}}</div>
                            <div>{{order.customer_email}}</div>
                            <div>{{order.customer_phone}}</div>
                            <div>
                                {{order.shipping_address.address}} , {{order.shipping_address.city}} , {{order.shipping_address.state}} , {{order.shipping_address.country}} , {{order.shipping_address.zip}}
                            </div>
                        </div>
                        <div class="m-2">
                            <div class="text-teal-600 font-bold">Ship To</div>
                            <div class="font-bold">{{order.customer_name}}</div>
                            <div>{{order.customer_email}}</div>
                            <div>{{order.customer_phone}}</div>
                            <div>
                                {{order.shipping_address.address}} , {{order.shipping_address.city}} , {{order.shipping_address.state}} , {{order.shipping_address.country}} , {{order.shipping_address.zip}}
                            </div>
                        </div>
                    </section>
                    <section class="p-6">
                        <table class="w-full">
                            <thead class="text-left border-b-2 border-teal-600 text-teal-600">
                            <tr>
                                <th class="">Product</th>
                                <th class="">Quantity</th>
                                <th class="">Price</th>
                                <th class="text-right">Total</th>
                            </tr>
                            </thead>
                            <tbody>
                            <tr v-for="item in order.products" :key="item.id" class="pb-2">
                                <td class="border-b border-gray-200 pt-2">
                                    <div class="text-sm font-medium text-gray-900">
                                        {{item.name}}
                                    </div>
                                </td>
                                <td class="border-b border-gray-200 pt-2">
                                    <div class="text-sm text-gray-900">{{item.pivot.quantity}}</div>
                                </td>
                                <td class="border-b border-gray-200 pt-2">
                                    <div class="text-sm text-gray-900">{{item.price}} $</div>
                                </td>
                                <td class="border-b border-gray-200 pt-2 text-right">
                                    <div class="text-sm text-gray-900">{{item.pivot.total}} $</div>
                                </td>
                            </tr>
                            </tbody>
                        </table>
                    </section>
                    <section class="flex justify-end p-6">
                        <div class="flex flex-col w-1/2 gap-2">
                            <div class="flex justify-between border-b pb-2">
                                <div class="text-gray-700 font-bold">Subtotal</div>
                                <div class="text-gray-700">{{order.subtotal}}</div>
                            </div>
                            <div class="flex justify-between border-b pb-2">
                                <div class="text-gray-700 font-bold">Shipping</div>
                                <div class="text-gray-700">{{order.shipping}}</div>
                            </div>
                            <div class="flex justify-between border-b pb-2">
                                <div class="text-gray-700 font-bold">Tax()</div>
                                <div class="text-gray-700">{{order.tax}}</div>
                            </div>
                            <div class="flex justify-between border-b pb-2">
                                <div class="text-gray-700 font-bold">Total</div>
                                <div class="text-gray-700">{{order.total}}</div>
                            </div>
                        </div>
                    </section>
                </div>
            </div>
        </div>
    </AuthenticatedLayout>
</template>
