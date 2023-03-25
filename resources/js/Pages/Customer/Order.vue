<script setup>
import ProfileLayout from "@/Pages/Customer/partial/ProfileLayout.vue";
import {useForm} from "@inertiajs/inertia-vue3";
import {InertiaLink} from "@inertiajs/inertia-vue3";
const props = defineProps({
    order: {
        type: Object,
        required: true
    }
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
            $refs.flashMessage.show('Order status updated successfully', 'success');
        },
        onError: () => {
            $refs.flashMessage.show('Something went wrong', 'error');
        }
    });
}
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
    <section class="col-span-9">
<!--        <h2 class="text-lg font-medium text-gray-800 mb-4 print:hidden">Order History</h2>-->
        <div class="py-5" id="print">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6" >
                <div class="bg-white overflow-hidden shadow-xl print:shadow-none sm:rounded-lg">
                    <section class="flex justify-between p-6 print:hidden">
                        <div class="inline-flex justify-start">
                            <div class="flex gap-3">
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
                                <span class="bg-blue-300 font-xs px-2 rounded capitalize">{{order.status}}</span>
                            </div>
                            <div class="mx-2">
                                <label for="">
                                    Payment Status:
                                </label>
                                <span class="bg-blue-300 font-xs px-2 rounded capitalize">{{order.payment_status}}</span>
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
                                123, Main Street, New York, USA
                            </p>
                        </div>
                        <div class="border-teal-600 border-r-2 m-2">
                            <div class="text-teal-600 font-bold">Bill TO</div>
                            <div class="font-bold">{{order.customer_name}}</div>
                            <div>{{order.customer_email}}</div>
                            <div>{{order.customer_phone}}</div>
                            <div>{{order.billing_address ?? order.shipping_address}}</div>
                        </div>
                        <div class="m-2">
                            <div class="text-teal-600 font-bold">Ship To</div>
                            <div class="font-bold">{{order.customer_name}}</div>
                            <div>{{order.customer_email}}</div>
                            <div>{{order.customer_phone}}</div>
                            <div>{{order.shipping_address}}</div>
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
                                    <div class="flex">
                                        <div class="flex-shrink-0 h-10 w-10">
                                            <img class="h-10 w-10 rounded-full" :src="item.image" alt="">
                                        </div>
                                        <div class="ml-4">
                                            <div class="text-sm font-medium text-gray-900">
                                                {{item.name}}
                                            </div>
                                            <div class="text-sm text-gray-500">
                                                {{item.sku}}
                                            </div>
                                        </div>
                                    </div>
                                </td>
                                <td class="border-b border-gray-200 pt-2">
                                    <div class="text-sm text-gray-900">{{item.qty}}</div>
                                </td>
                                <td class="border-b border-gray-200 pt-2">
                                    <div class="text-sm text-gray-900">{{item.price}} $</div>
                                </td>
                                <td class="border-b border-gray-200 pt-2 text-right">
                                    <div class="text-sm text-gray-900">{{item.subtotal}} $</div>
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
                                <div class="text-gray-700 font-bold">Tax</div>
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
    </section>
</template>
