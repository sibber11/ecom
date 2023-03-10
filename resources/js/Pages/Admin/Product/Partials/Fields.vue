<script setup>
import {useForm} from '@inertiajs/inertia-vue3';
import {onMounted, ref, watch} from "vue";
import {submitForm} from "@/helper";
import InputError from '@/components/InputError.vue';
import InputLabel from '@/components/InputLabel.vue';
import PrimaryButton from '@/components/PrimaryButton.vue';
import TextInput from '@/components/TextInput.vue';
import TextArea from "@/components/TextArea.vue";
import SelectModels from '@/components/SelectModels.vue'
import SlugInput from '@/components/SlugInput.vue'
import PreviewImage from "@/components/PreviewImage.vue";
import CancelButton from "@/components/CancelButton.vue"

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
    quantity: '',
    category: '',
    brand: '',
    tags: [],
    images: null,
});
onMounted(() => {

    if (!props.product) {
        return
    }
    form.name = props.product.name;
    form.description = props.product.description;
    form.sku = props.product.sku;
    form.slug = props.product.slug;
    form.price = props.product.price;
    form.quantity = props.product.quantity;
    form.category = props.product.category.name;
    form.brand = props.product.brand.name;
    form.tags = tags.value;
})
const tags = ref(props.product?.tags.length > 0 ? props.product.tags.map(tag => tag.name.en) : '');

function extractTags() {
    form.tags = tags.value.split(',').map(e => e.trim()).filter(e => e)
}

watch(tags, extractTags)

const slug_input = ref(null);
const imageViewer = ref(null);
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
                    autocomplete="name"
                    placeholder="Product Name"
                    v-model="form.name"
                    @input="slug_input.get_slug($event.target.value)"
                    required
                    autofocus
                />

                <InputError class="mt-2" :message="form.errors.name"/>
            </div>

            <div>
                <InputLabel for="slug" value="Slug"/>

                <SlugInput class="mt-1 block w-full" :url="route('products.get_slug')" v-model="form.slug"
                           ref="slug_input"/>

                <InputError class="mt-2" :message="form.errors.slug"/>
            </div>

            <div>
                <InputLabel for="category_name" value="Category"/>

                <SelectModels v-model="form.category" :url="route('admin.categories.get_names')" model-name="Category"/>

                <InputError class="mt-2" :message="form.errors.category"/>
            </div>

            <div>
                <InputLabel for="category_name" value="Brand"/>

                <SelectModels v-model="form.brand" :url="route('admin.brands.get_names')" model-name="Brand"/>

                <InputError class="mt-2" :message="form.errors.brand"/>
            </div>

            <div>
                <InputLabel for="price" value="Price"/>

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
                <InputLabel for="quantity" value="Quantity"/>

                <TextInput
                    id="quantity"
                    type="number"
                    class="mt-1 block w-full"
                    v-model="form.quantity"
                    placeholder="Product quantity"
                />

                <InputError class="mt-2" :message="form.errors.quantity"/>
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
                    class="mt-1 block w-full"
                    v-model="form.description"
                    autocomplete="description"
                    placeholder="Product Description"
                    required
                />

                <InputError class="mt-2" :message="form.errors.description"/>
            </div>

            <div>
                <InputLabel for="tags" value="Tags"/>

                <TextInput
                    id="tags"
                    type="text"
                    class="mt-1 block w-full"
                    v-model="tags"
                    autocomplete="tags"
                    placeholder="Enter tags separated by comma"
                />

                <InputError class="mt-2" :message="form.errors.tags"/>
            </div>

            <div>
                <InputLabel for="images" value="Images"/>

                <input type="file" id="images" @change="form.images = $event.target.files; imageViewer.preview($event)"
                       multiple>

                <InputError class="mt-2" :message="form.errors.images"/>

                <PreviewImage ref="imageViewer" :model="product" url-name="products.deleteMedia"/>

            </div>

            <div class="flex items-center gap-4">
                <PrimaryButton :disabled="form.processing">Save</PrimaryButton>
                <CancelButton :url="route('admin.products.index')" />

                <Transition enter-from-class="opacity-0" leave-to-class="opacity-0" class="transition ease-in-out">
                    <p v-if="form.recentlySuccessful" class="text-sm text-gray-600">Product Added.</p>
                </Transition>
            </div>
        </form>
    </section>
</template>
