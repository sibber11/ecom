<script setup>
import InputError from '@/Components/InputError.vue';
import InputLabel from '@/Components/InputLabel.vue';
import PrimaryButton from '@/Components/PrimaryButton.vue';
import TextInput from '@/Components/TextInput.vue';
import {useForm} from '@inertiajs/inertia-vue3';
import debounce from "lodash/debounce";
import {onMounted} from "vue";
import {submitForm} from "@/helper";
import {ref} from "vue";
import {InertiaLink} from "@inertiajs/inertia-vue3";


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
    parent: ''
});
onMounted(()=>{
    if (!props.category){
        return
    }

    form.name = props.category.name;
    form.parent = props.category.parent;
})

//data property named as parent_categories
const parent_categories = ref([]);
//fetch parent categories using a function with debounce
const fetchParentCategories = debounce(()=>{
    axios.post(route('categories.parent',{
        parent_name: form.parent
    }))
        .then((r) => {
            parent_categories.value = r.data
        })
}, 300)


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
                    required
                    autofocus
                    autocomplete="name"
                />

                <InputError class="mt-2" :message="form.errors.name"/>
            </div>
            <div>
                <InputLabel for="parent_name" value="Parent"/>

                <TextInput
                    id="parent_name"
                    type="text"
                    class="mt-1 block w-full"
                    v-model="form.parent"
                    @input="fetchParentCategories"
                    list="parent-name"
                />

                <datalist id="parent-name">
                    <option v-for="parent in parent_categories" :value="parent.name"></option>
                </datalist>
                <InputError class="mt-2" :message="form.errors.parent"/>

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
