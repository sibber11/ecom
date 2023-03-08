<script setup>
import ProfileLayout from "@/Pages/Customer/partial/ProfileLayout.vue"
import {useForm} from "@inertiajs/inertia-vue3";

const form = useForm({
    current_password: '',
    password: '',
    password_confirmation: '',
})

function submit() {
    form.put(route('password.update'), {
        preserveScroll: true,
        onSuccess: () => {
            form.reset('current_password', 'password', 'password_confirmation')
        }
    })

}
</script>

<template>
    <ProfileLayout>
        <section class="col-span-9">
            <form class="shadow rounded px-6 pt-5 pb-7" @submit.prevent="submit">
                <h4 class="text-lg font-medium capitalize mb-4">
                    Change Password
                </h4>
                <div class="space-y-4">
                    <div>
                        <label for="current_password">Current Password</label>
                        <input type="password" id="current_password" class="input-box" v-model="form.current_password">
                        <template v-if="form.errors.current_password">
                            <span class="text-red-500 text-xs italic">{{ form.errors.current_password }}</span>
                        </template>
                    </div>
                    <div>
                        <label for="password">New Password</label>
                        <input type="password" id="password" class="input-box" v-model="form.password">
                        <template v-if="form.errors.password">
                            <span class="text-red-500 text-xs italic">{{ form.errors.password }}</span>
                        </template>
                    </div>
                    <div>
                        <label for="password_confirmation">Confirm New Password</label>
                        <input type="password"  id="password_confirmation" class="input-box" v-model="form.password_confirmation">
                        <template v-if="form.errors.password_confirmation">
                            <span class="text-red-500 text-xs italic">{{ form.errors.password_confirmation }}</span>
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
