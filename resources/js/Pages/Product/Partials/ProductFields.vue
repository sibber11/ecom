<script setup>
import InputError from '@/Components/InputError.vue';
import InputLabel from '@/Components/InputLabel.vue';
import PrimaryButton from '@/Components/PrimaryButton.vue';
import TextInput from '@/Components/TextInput.vue';
import {useForm} from '@inertiajs/inertia-vue3';
import TextArea from "@/components/TextArea.vue";
import debounce from "lodash/debounce";
import {onMounted} from "vue";



const props = defineProps({
    method: {
        default: 'post',
        type: String
    },
    url: String,
    product: Object
});

const form = useForm({
    name: '',
    description: '',
    sku: '',
    slug: ''
});
onMounted(()=>{
    if (!props.product){
        return
    }

    form.name = props.product.name;
    form.description = props.product.description;
    form.sku = props.product.sku;
    form.slug = props.product.slug;
})
function getslug(event) {
    if (event.target.value === '') {
        return;
    }
    processApiCall();
}

function submitForm(){
    if (props.method === 'post'){
        form.post(props.url)
    }
    if (props.method === 'patch'){
        form.patch(props.url)
    }
}

const processApiCall = debounce(()=>{
    axios.post(route('product.getslug'), {
        name: form.name
    })
        .then((r) => {
            form.slug = r.data.slug
        })
}, 300)

</script>

<template>
    <section>
        <header>
            <h2 class="text-lg font-medium text-gray-900">Product Information</h2>

            <p class="mt-1 text-sm text-gray-600">
                Update your account's profile information and email address.
            </p>
        </header>

        <form @submit.prevent="submitForm" class="mt-6 space-y-6">
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
                    @input="getslug"
                />

                <InputError class="mt-2" :message="form.errors.name"/>
            </div>

            <div>
                <InputLabel for="slug" value="Slug"/>

                <TextInput
                    id="slug"
                    type="text"
                    class="mt-1 block w-full"
                    v-model="form.slug"
                    disabled
                />

                <InputError class="mt-2" :message="form.errors.slug"/>
            </div>

            <div>
                <InputLabel for="sku" value="SKU"/>

                <TextInput
                    id="sku"
                    type="text"
                    class="mt-1 block w-full"
                    v-model="form.sku"
                    autocomplete="sku"
                />

                <InputError class="mt-2" :message="form.errors.sku"/>
            </div>

            <div>
                <InputLabel for="description" value="Description"/>

                <TextArea
                    id="description"
                    type="text"
                    class="mt-1 block w-full"
                    v-model="form.description"
                    required
                    autocomplete="description"
                />

                <InputError class="mt-2" :message="form.errors.description"/>
            </div>

            <div class="flex items-center gap-4">
                <PrimaryButton :disabled="form.processing">Save</PrimaryButton>

                <Transition enter-from-class="opacity-0" leave-to-class="opacity-0" class="transition ease-in-out">
                    <p v-if="form.recentlySuccessful" class="text-sm text-gray-600">Product Added.</p>
                </Transition>
            </div>
        </form>
    </section>
</template>
