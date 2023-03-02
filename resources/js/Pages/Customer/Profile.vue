<script setup>
import ProfileLayout from "@/Pages/Customer/partial/ProfileLayout.vue"
import {useForm} from "@inertiajs/inertia-vue3";
import {usePage} from "@inertiajs/inertia-vue3";
import {computed} from "vue";

const user = computed(() => usePage().props.value.auth.user);
const form = useForm({
    name: user.value.name,
    email: user.value.email,
    phone: user.value.phone,

})
</script>

<template>
    <ProfileLayout>
        <section class="col-span-9">
            <form class="shadow rounded px-6 pt-5 pb-7" @submit.prevent="form.post(route('profile'))">
                <h4 class="text-lg font-medium capitalize mb-4">
                    Profile information
                </h4>
                <div class="space-y-4">
                    <div>
                        <label for="name">First name</label>
                        <input type="text" name="name" id="name" class="input-box" v-model="form.name">
                    </div>
                    <div class="grid grid-cols-2 gap-4">
                        <div>
                            <label for="email">Email Address</label>
                            <input type="email" name="email" id="email" class="input-box" v-model="form.email">
                        </div>
                        <div>
                            <label for="phone">Phone number</label>
                            <input type="text" name="phone" id="phone" class="input-box" v-model="form.phone">
                        </div>
                    </div>
                    <!--                <div class="grid grid-cols-2 gap-4">-->
                    <!--                    <div>-->
                    <!--                        <label for="birthday">Birthday</label>-->
                    <!--                        <input type="date" name="birthday" id="birthday" class="input-box">-->
                    <!--                    </div>-->
                    <!--                    <div>-->
                    <!--                        <label for="gender">Gender</label>-->
                    <!--                        <select name="gender" id="gender" class="input-box">-->
                    <!--                            <option value="male">Male</option>-->
                    <!--                            <option value="female">Female</option>-->
                    <!--                        </select>-->
                    <!--                    </div>-->
                    <!--                </div>-->

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
