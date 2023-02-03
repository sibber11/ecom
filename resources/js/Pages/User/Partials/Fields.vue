<script setup>
import {useForm} from '@inertiajs/inertia-vue3';
import {onMounted} from "vue";
import {submitForm} from "@/helper";
import InputError from '@/components/InputError.vue';
import InputLabel from '@/components/InputLabel.vue';
import PrimaryButton from '@/components/PrimaryButton.vue';
import TextInput from '@/components/TextInput.vue';

const props = defineProps({
    method: {
        default: 'post',
        type: String
    },
    url: String,
    user: Object,
});

const form = useForm({
    name: '',
    email: '',
    password: '',
    password_confirmation: ''

});
let required = true;
onMounted(() => {
    required = window.location.pathname.endsWith('edit');
    if (!props.user) {
        return
    }
    form.name = props.user.name;
    form.email = props.user.email;
})

</script>

<template>
    <section>
        <header>
            <h2 class="text-lg font-medium text-gray-900">User Information</h2>

            <p class="mt-1 text-sm text-gray-600">
                Update user information.
            </p>
        </header>

        <form @submit.prevent="submitForm(method,form,url)" class="mt-6 space-y-6">
            <div>
                <InputLabel for="name" value="Name"/>

                <TextInput
                    id="name"
                    type="text"
                    class="mt-1 block w-full"
                    autocomplete="name"
                    placeholder="User Name"
                    v-model="form.name"
                    @input="slug_input.get_slug($event.target.value)"
                    required
                    autofocus
                />

                <InputError class="mt-2" :message="form.errors.name"/>
            </div>

            <div>
                <InputLabel for="email" value="Email"/>

                <TextInput
                    id="email"
                    type="email"
                    class="mt-1 block w-full"
                    autocomplete="email"
                    placeholder="Email"
                    v-model="form.email"
                    required
                />

                <InputError class="mt-2" :message="form.errors.email"/>
            </div>

            <div>
                <InputLabel for="password" value="Password"/>

                <TextInput
                    id="password"
                    type="password"
                    class="mt-1 block w-full"
                    autocomplete="password"
                    placeholder="enter password"
                    v-model="form.password"
                    :required="!required"
                />

                <InputError class="mt-2" :message="form.errors.password"/>
            </div>

            <div>
                <InputLabel for="password_confirmation" value="Password Confirmation"/>

                <TextInput
                    id="password_confirmation"
                    type="password"
                    class="mt-1 block w-full"
                    autocomplete="password_confirmation"
                    placeholder="Retype Password"
                    v-model="form.password_confirmation"
                    :required="!required"
                />

                <InputError class="mt-2" :message="form.errors.password_confirmation"/>
            </div>

            <div class="flex items-center gap-4">
                <PrimaryButton :disabled="form.processing">Save</PrimaryButton>

                <Transition enter-from-class="opacity-0" leave-to-class="opacity-0" class="transition ease-in-out">
                    <p v-if="form.recentlySuccessful" class="text-sm text-gray-600">User Added.</p>
                </Transition>
            </div>
        </form>
    </section>
</template>
