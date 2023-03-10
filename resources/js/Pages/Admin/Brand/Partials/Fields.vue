<script setup>
import {onMounted, ref} from "vue";
import {submitForm} from "@/helper";
import InputError from '@/components/InputError.vue';
import InputLabel from '@/components/InputLabel.vue';
import PrimaryButton from '@/components/PrimaryButton.vue';
import TextInput from '@/components/TextInput.vue';
import {useForm} from '@inertiajs/inertia-vue3';
import CancelButton from "@/components/CancelButton.vue";
import SlugInput from '@/components/SlugInput.vue';


const props = defineProps({
    method: {
        default: 'post',
        type: String
    },
    url: String,
    brand: Object
});

const form = useForm({
    name: '',
    slug: ''
});
onMounted(()=>{
    if (!props.brand){
        return
    }
    form.name = props.brand.name;
    form.slug = props.brand.slug;
})

const slug_input = ref(null);

</script>

<template>
    <section>
        <header>
            <h2 class="text-lg font-medium text-gray-900">Brand Information</h2>

            <p class="mt-1 text-sm text-gray-600">
                Update brand information.
            </p>
        </header>

        <form @submit.prevent="submitForm(method, form, url)" class="mt-6 space-y-6">
            <div>
                <InputLabel for="name" value="Name"/>

                <TextInput
                    id="name"
                    type="text"
                    class="mt-1 block w-full"
                    autocomplete="name"
                    v-model="form.name"
                    @input="slug_input.get_slug($event.target.value)"
                    required
                    autofocus
                />

                <InputError class="mt-2" :message="form.errors.name"/>
            </div>

            <div>
                <InputLabel for="slug" value="Slug"/>

                <SlugInput class="mt-1 block w-full" :url="route('admin.brands.get_slug')" v-model="form.slug" ref="slug_input"/>

                <InputError class="mt-2" :message="form.errors.slug"/>
            </div>

            <div class="flex items-center gap-4">
                <PrimaryButton :disabled="form.processing">Save</PrimaryButton>
                <CancelButton :url="route('admin.brands.index')"/>

                <Transition enter-from-class="opacity-0" leave-to-class="opacity-0" class="transition ease-in-out">
                    <p v-if="form.recentlySuccessful" class="text-sm text-gray-600">Brand Added.</p>
                </Transition>
            </div>
        </form>
    </section>
</template>
