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

const form = useForm({
    name: user.value.name,
    address: user.value.address.address,
    city: user.value.address.city,
    state: user.value.address.state,
    zip: user.value.address.zip,
    country: user.value.address.country,
    phone: user.value.phone,
    email: user.value.email,
    notes: '',
    payment_method: 'cash_on_delivery',
    shipping_method: 'free_shipping',
    terms: null,
});

</script>

<template>
    <!-- wrapper -->
    <CustomerLayout>
        <div class="container grid grid-cols-12 items-start pb-16 pt-4 gap-6">

            <form class="col-span-8 border border-gray-200 p-4 rounded"
                  @submit.prevent="form.post(route('checkout.store'))">
                <h3 class="text-lg font-medium capitalize mb-4">Checkout</h3>
                <div class="space-y-4">
                    <div>
                        <label class="text-gray-600" for="name">Name <span
                            class="text-primary">*</span></label>
                        <input id="name" v-model="form.name" class="input-box disabled:bg-gray-200" disabled
                               name="name" type="text">
                    </div>
                    <div class="space-y-4">
                        <div class="grid grid-cols-2 gap-4">
                            <div>
                                <label for="country">Country</label>
                                <input id="country" v-model="form.country" class="input-box" name="country" type="text">
                                <template v-if="form.errors.country">
                                    <span class="text-red-500 text-xs italic">{{ form.errors.country }}</span>
                                </template>
                            </div>
                            <div>
                                <label for="city">City</label>
                                <input id="city" v-model="form.city" class="input-box" name="city" type="text">
                                <template v-if="form.errors.city">
                                    <span class="text-red-500 text-xs italic">{{ form.errors.city }}</span>
                                </template>
                            </div>
                        </div>
                        <div class="grid grid-cols-2 gap-4">
                            <div>
                                <label for="state">State</label>
                                <input id="state" v-model="form.state" class="input-box" name="state" type="text">
                                <template v-if="form.errors.state">
                                    <span class="text-red-500 text-xs italic">{{ form.errors.state }}</span>
                                </template>
                            </div>
                            <div>
                                <label for="zip">Zip Code</label>
                                <input id="zip" v-model="form.zip" class="input-box" name="zip" type="text">
                                <template v-if="form.errors.zip">
                                    <span class="text-red-500 text-xs italic">{{ form.errors.zip }}</span>
                                </template>
                            </div>
                        </div>
                        <div>
                            <label for="address">Street</label>
                            <input id="address" v-model="form.address" class="input-box" name="address" type="text">
                            <template v-if="form.errors.address">
                                <span class="text-red-500 text-xs italic">{{ form.errors.address }}</span>
                            </template>
                        </div>
                    </div>
                    <div>
                        <label class="text-gray-600" for="phone">Phone number</label>
                        <input id="phone" v-model="form.phone" class="input-box" name="phone" type="text">
                    </div>
                    <div>
                        <label class="text-gray-600" for="email">Email address</label>
                        <input id="email" v-model="form.email" class="input-box disabled:bg-gray-200" disabled
                               name="email"
                               type="email">
                    </div>
                    <div>
                        <label class="text-gray-600" for="phone">notes</label>
                        <textarea v-model="form.notes" class="input-box" cols="30" rows="10"></textarea>
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
                                    {{ product.name }}
                                </h5>
                                <p class="text-sm text-gray-600">Size: M</p>
                            </div>
                            <p class="text-gray-600">
                                {{ product.quantity }}
                            </p>
                            <p class="text-gray-800 font-medium">
                                ${{ product.price }}
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
                    <p>${{ total }}</p>
                </div>

                <div class="flex items-center mb-4 mt-2">
                    <input id="agreement" v-model="form.terms"
                           class="text-primary focus:ring-0 rounded-sm cursor-pointer w-3 h-3" name="agreement"
                           type="checkbox">
                    <label class="text-gray-600 ml-3 cursor-pointer text-sm" for="agreement">
                        I agree to the <a class="text-primary" href="#">terms & conditions</a>
                    </label>
                </div>

                <button
                    class="block w-full py-3 px-4 text-center text-white bg-primary border border-primary rounded-md hover:bg-transparent hover:text-primary transition font-medium"
                    type="submit"
                    @click="form.post(route('checkout.store'))">
                    Place order
                </button>
            </div>

        </div>
    </CustomerLayout>
    <!-- ./wrapper -->

</template>
