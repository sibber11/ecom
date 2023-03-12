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
    order: Object,
});

const form = useForm({
    name: '',
    email: '',
    password: '',
    password_confirmation: ''

});
let required = true;

</script>

<template>
    <section>
        <header>
            <h2 class="text-lg font-medium text-gray-900">Order Information</h2>

            <p class="mt-1 text-sm text-gray-600">
                Update order information.
            </p>
        </header>

        <form @submit.prevent="submitForm(method,form,url)" class="mt-6 space-y-6">
            

            <div class="flex items-center gap-4">
                <PrimaryButton :disabled="form.processing">Save</PrimaryButton>

                <Transition enter-from-class="opacity-0" leave-to-class="opacity-0" class="transition ease-in-out">
                    <p v-if="form.recentlySuccessful" class="text-sm text-gray-600">User Added.</p>
                </Transition>
            </div>
        </form>
    </section>
</template>
