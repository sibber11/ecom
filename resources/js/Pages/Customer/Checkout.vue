<script setup>

import CustomerLayout from "@/Layouts/CustomerLayout.vue";
import {useForm, usePage} from "@inertiajs/inertia-vue3";
import {computed} from "vue";
const props = defineProps({
    products: {
        type: Object,
        required: true
    },
    total: {
        type: String,
        required: true
    },
    tax: {
        type: String,
        required: true
    },
    subtotal: {
        type: String,
        required: true
    },
    discount: {
        type: String,
        required: true
    }
});
const user = computed(() => usePage().props.value.auth.user);
console.log(user.value)
const form = useForm({
    name: user.value.name,
    address: user.value.address,
    city: '',
    state: '',
    zip: '',
    country: '',
    phone: user.value.phone,
    email: user.value.email,
    notes: '',
    payment_method: 'cash_on_delivery',
    shipping_method: 'free_shipping',
    terms: false
});

</script>

<template>
    <!-- wrapper -->
    <CustomerLayout>
        <div class="container grid grid-cols-12 items-start pb-16 pt-4 gap-6">

            <form @submit.prevent="form.post(route('checkout.store'))" class="col-span-8 border border-gray-200 p-4 rounded">
                <h3 class="text-lg font-medium capitalize mb-4">Checkout</h3>
                <div class="space-y-4">
                    <div>
                        <label for="name" class="text-gray-600">Name <span
                            class="text-primary">*</span></label>
                        <input type="text" name="name" id="name" class="input-box" v-model="form.name">
                    </div>
                    <div>
                        <label for="region" class="text-gray-600">Country/Region</label>
                        <input type="text" name="region" id="region" class="input-box" v-model="form.region">
                    </div>
                    <div>
                        <label for="address" class="text-gray-600">Street address</label>
                        <input type="text" name="address" id="address" class="input-box" v-model="form.address">
                    </div>
                    <div>
                        <label for="city" class="text-gray-600">City</label>
                        <input type="text" name="city" id="city" class="input-box" v-model="form.city">
                    </div>
                    <div>
                        <label for="phone" class="text-gray-600">Phone number</label>
                        <input type="text" name="phone" id="phone" class="input-box" v-model="form.phone">
                    </div>
                    <div>
                        <label for="email" class="text-gray-600">Email address</label>
                        <input type="email" name="email" id="email" class="input-box" v-model="form.email">
                    </div>
                </div>

            </form>

            <div class="col-span-4 border border-gray-200 p-4 rounded">
                <h4 class="text-gray-800 text-lg mb-4 font-medium uppercase">order summary</h4>
                <div class="space-y-2">
                    <template v-for="product in products.data">

                        <div class="flex justify-between">
                            <div>
                                <h5 class="text-gray-800 font-medium">
                                    {{product.name}}
                                </h5>
                                <p class="text-sm text-gray-600">Size: M</p>
                            </div>
                            <p class="text-gray-600">
                                {{product.quantity}}
                            </p>
                            <p class="text-gray-800 font-medium">
                                ${{product.price}}
                            </p>
                        </div>
                    </template>

                </div>
                <div class="flex justify-between border-b border-gray-200 mt-1 text-gray-800 font-medium py-3 uppercas">
                    <p>Subtotal</p>
                    <p>${{ subtotal }}</p>
                </div>

                <div class="flex justify-between border-b border-gray-200 mt-1 text-gray-800 font-medium py-3 uppercas">
                    <p>Shipping</p>
                    <p>Free</p>
                </div>
                <div class="flex justify-between border-b border-gray-200 mt-1 text-gray-800 font-medium py-3 uppercas">
                    <p>Tax</p>
                    <p>${{ tax }}</p>
                </div>
                <div class="flex justify-between border-b border-gray-200 mt-1 text-gray-800 font-medium py-3 uppercas">
                    <p>Discount</p>
                    <p>${{ discount }}</p>
                </div>

                <div class="flex justify-between text-gray-800 font-medium py-3 uppercas">
                    <p class="font-semibold">Total</p>
                    <p>${{total}}</p>
                </div>

                <div class="flex items-center mb-4 mt-2">
                    <input type="checkbox" name="aggrement" id="aggrement"
                           class="text-primary focus:ring-0 rounded-sm cursor-pointer w-3 h-3">
                    <label for="aggrement" class="text-gray-600 ml-3 cursor-pointer text-sm">I agree to the <a href="#"
                                                                                                               class="text-primary">terms & conditions</a></label>
                </div>

                <button type="submit" @click="form.post(route('checkout.store'))"
                   class="block w-full py-3 px-4 text-center text-white bg-primary border border-primary rounded-md hover:bg-transparent hover:text-primary transition font-medium">
                    Place order
                </button>
            </div>

        </div>
    </CustomerLayout>
    <!-- ./wrapper -->

</template>
