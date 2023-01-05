<script setup>
import {useForm} from '@inertiajs/inertia-vue3';
import debounce from "lodash/debounce";
import {onMounted} from "vue";
import {submitForm} from "@/helper";
import InputError from '@/Components/InputError.vue';
import InputLabel from '@/Components/InputLabel.vue';
import PrimaryButton from '@/Components/PrimaryButton.vue';
import TextInput from '@/Components/TextInput.vue';
import TextArea from "@/components/TextArea.vue";
import SelectCategories from "@/Pages/Category/Partials/SelectCategories.vue";

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
    slug: '',
    price: '',
    category: '',
    tags: [],
});
onMounted(()=>{
    if (!props.product){
        return
    }

    form.name = props.product.name;
    form.description = props.product.description;
    form.sku = props.product.sku;
    form.slug = props.product.slug;
    form.price = props.product.price;
    form.category = props.product.category.name;
    // check if the tags array is empty, if not, then map the tags array and return the name of each tag
    form.tags = props.product.tags.length > 0 ? props.product.tags.map(tag => tag.name.en) : [];

})
function getslug(event) {
    if (event.target.value === '') {
        return;
    }
    processApiCall();
}


const processApiCall = debounce(()=>{
    axios.post(route('products.getslug'), {
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
                Update product information.
            </p>
        </header>

        <form @submit.prevent="submitForm(method,form,url)" class="mt-6 space-y-6">
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
                    placeholder="Product Name"
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
                <InputLabel for="slug" value="Category"/>

                <SelectCategories v-model="form.category"/>

                <InputError class="mt-2" :message="form.errors.category"/>
            </div>

            <div>
                <InputLabel for="slug" value="Price"/>

                <TextInput
                    id="price"
                    type="number"
                    class="mt-1 block w-full"
                    v-model="form.price"
                    placeholder="Product Price"
                />

                <InputError class="mt-2" :message="form.errors.price"/>
            </div>

            <div>
                <InputLabel for="sku" value="SKU"/>

                <TextInput
                    id="sku"
                    type="text"
                    class="mt-1 block w-full"
                    v-model="form.sku"
                    autocomplete="sku"
                    placeholder="Product SKU"
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
                    autocomplete="description"
                    placeholder="Product Description"
                    required
                />

                <InputError class="mt-2" :message="form.errors.description"/>
            </div>

            <div>
                <InputLabel for="sku" value="Tags"/>

                <TextInput
                    id="tags"
                    type="text"
                    class="mt-1 block w-full"
                    v-model="form.tags"
                    autocomplete="tags"
                    placeholder="Enter tags separated by comma"
                />

                <InputError class="mt-2" :message="form.errors.tags"/>
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
