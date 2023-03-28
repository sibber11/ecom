<script setup>
import ProfileLayout from "@/Pages/Customer/partial/ProfileLayout.vue"
import {useForm} from "@inertiajs/inertia-vue3";
const props = defineProps({
    address: Object,
})
const form = useForm({
    country: props.address.country,
    city: props.address.city,
    state: props.address.state,
    zip: props.address.zip,
    address: props.address.address,
})
</script>

<template>
    <ProfileLayout>
        <section class="col-span-9">
            <form class="shadow rounded px-6 pt-5 pb-7" @submit.prevent="form.post(route('address.store'))">
                <h4 class="text-lg font-medium capitalize mb-4">
                    Manage Addresses
                </h4>
                <div class="space-y-4">
                    <div class="grid grid-cols-2 gap-4">
                        <div>
                            <label for="country">Country</label>
                            <input type="text" name="country" id="country" class="input-box" v-model="form.country">
                            <template v-if="form.errors.country">
                                <span class="text-red-500 text-xs italic">{{ form.errors.country }}</span>
                            </template>
                        </div>
                        <div>
                            <label for="city">City</label>
                            <input type="text" name="city" id="city" class="input-box" v-model="form.city">
                            <template v-if="form.errors.city">
                                <span class="text-red-500 text-xs italic">{{ form.errors.city }}</span>
                            </template>
                        </div>
                    </div>
                    <div class="grid grid-cols-2 gap-4">
                        <div>
                            <label for="state">State</label>
                            <input type="text" name="state" id="state" class="input-box" v-model="form.state">
                            <template v-if="form.errors.state">
                                <span class="text-red-500 text-xs italic">{{ form.errors.state }}</span>
                            </template>
                        </div>
                        <div>
                            <label for="zip">Zip Code</label>
                            <input type="text" name="zip" id="zip" class="input-box" v-model="form.zip">
                            <template v-if="form.errors.zip">
                                <span class="text-red-500 text-xs italic">{{ form.errors.zip }}</span>
                            </template>
                        </div>
                    </div>
                    <div>
                        <label for="address">Street</label>
                        <input type="text" name="address" id="address" class="input-box" v-model="form.address">
                        <template v-if="form.errors.address">
                            <span class="text-red-500 text-xs italic">{{ form.errors.address }}</span>
                        </template>
                    </div>
                </div>

                <div class="mt-4 flex items-center gap-4">
                    <button type="submit" :disabled="form.processing"
                            class="py-3 px-4 text-center text-white bg-primary border border-primary rounded-md hover:bg-opacity-25 disabled:bg-opacity-25 hover:text-primary transition font-medium">save
                        changes</button>
                    <Transition enter-from-class="opacity-0" leave-to-class="opacity-0" class="transition ease-in-out">
                        <p v-if="form.recentlySuccessful" class="text-sm text-gray-600">Information Saved.</p>
                    </Transition>
                </div>
            </form>
        </section>
    </ProfileLayout>
</template>
