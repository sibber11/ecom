<script setup>
import {onMounted, ref} from "vue";
import {submitForm} from "@/helper";
import InputError from '@/Components/InputError.vue';
import InputLabel from '@/Components/InputLabel.vue';
import PrimaryButton from '@/Components/PrimaryButton.vue';
import TextInput from '@/Components/TextInput.vue';
import {InertiaLink, useForm} from '@inertiajs/inertia-vue3';
import SelectModels from '@/components/SelectModels.vue';
import SlugInput from '@/components/SlugInput.vue';
import PreviewImage from "@/components/PreviewImage.vue"

const props = defineProps({
    method: {
        default: 'post',
        type: String
    },
    url: String,
    category: Object
});

const form = useForm({
    name: '',
    parent_name: '',
    slug: '',
    images: null,
});
onMounted(()=>{
    if (!props.category){
        return
    }

    form.name = props.category.name;
    form.parent_name = props.category.parent_name;
    form.slug = props.category.slug
})

const slug_input = ref(null);
const imageViewer = ref(null)
</script>

<template>
    <section>
        <header>
            <h2 class="text-lg font-medium text-gray-900">Category Information</h2>

            <p class="mt-1 text-sm text-gray-600">
                Update your account's profile information and email address.
            </p>
        </header>

        <form @submit.prevent="submitForm(method, form, url)" class="mt-6 space-y-6">
            <div>
                <InputLabel for="name" value="Name"/>

                <TextInput
                    id="name"
                    type="text"
                    class="mt-1 block w-full"
                    v-model="form.name"
                    autocomplete="name"
                    @input="slug_input.get_slug($event.target.value)"
                    required
                    autofocus
                />

                <InputError class="mt-2" :message="form.errors.name"/>
            </div>

            <div>
                <InputLabel for="slug" value="Slug"/>

                <SlugInput class="mt-1 block w-full" :url="route('categories.get_slug')" v-model="form.slug" ref="slug_input"/>

                <InputError class="mt-2" :message="form.errors.slug"/>
            </div>

            <div>
                <InputLabel for="parent_name" value="Parent"/>

                <SelectModels v-model="form.parent_name" model-name="Category" :url="route('categories.get_names')"/>

                <InputError class="mt-2" :message="form.errors.parent_name"/>

            </div>
            <div>
                <InputLabel for="images" value="Images"/>

                <input type="file" id="images" @change="form.images = $event.target.files; imageViewer.preview($event)">

                <PreviewImage :model="category" url-name="categories.deleteMedia" ref="imageViewer"/>
            </div>

            <div class="flex items-center gap-4">
                <PrimaryButton :disabled="form.processing">Save</PrimaryButton>
                <InertiaLink :href="route('categories.index')" class="inline-flex items-center px-4 py-2 bg-gray-800 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-gray-700 focus:bg-gray-700 active:bg-gray-900 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 transition ease-in-out duration-150">
                    Cancel
                </InertiaLink>

                <Transition enter-from-class="opacity-0" leave-to-class="opacity-0" class="transition ease-in-out">
                    <p v-if="form.recentlySuccessful" class="text-sm text-gray-600">Category Added.</p>
                </Transition>
            </div>
        </form>
    </section>
</template>
