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
import Multiselect from "@vueform/multiselect/src/Multiselect.vue";

const props = defineProps({
    method: {
        default: 'post',
        type: String
    },
    url: String,
    product: Object,
    options: Array,
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
    attributes: [],
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
    form.attributes = props.product.attributes.map((item)=>item.id);
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

        <form class="mt-6 space-y-6" @submit.prevent="submitForm(method,form,url)">
            <div>
                <InputLabel for="name" value="Name"/>

                <TextInput
                    id="name"
                    v-model="form.name"
                    autocomplete="name"
                    autofocus
                    class="mt-1 block w-full"
                    placeholder="Product Name"
                    required
                    type="text"
                    @input="slug_input.get_slug($event.target.value)"
                />

                <InputError :message="form.errors.name" class="mt-2"/>
            </div>

            <div>
                <InputLabel for="slug" value="Slug"/>

                <SlugInput ref="slug_input" v-model="form.slug" :url="route('admin.products.get_slug')"
                           class="mt-1 block w-full"/>

                <InputError :message="form.errors.slug" class="mt-2"/>
            </div>

            <div>
                <InputLabel for="sku" value="SKU"/>

                <TextInput
                    id="sku"
                    v-model="form.sku"
                    autocomplete="sku"
                    class="mt-1 block w-full"
                    placeholder="Product SKU"
                    type="text"
                />

                <InputError :message="form.errors.sku" class="mt-2"/>
            </div>

            <div class="sm:grid grid-cols-2 gap-4">
                <div>
                    <InputLabel for="category_name" value="Category"/>

                    <SelectModels v-model="form.category" :url="route('admin.categories.get_names')"
                                  model-name="Category"/>

                    <InputError :message="form.errors.category" class="mt-2"/>
                </div>

                <div>
                    <InputLabel for="category_name" value="Brand"/>

                    <SelectModels v-model="form.brand" :url="route('admin.brands.get_names')" model-name="Brand"/>

                    <InputError :message="form.errors.brand" class="mt-2"/>
                </div>
            </div>

            <div class="sm:grid grid-cols-2 gap-4">
                <div>
                    <InputLabel for="price" value="Price"/>

                    <TextInput
                        id="price"
                        v-model="form.price"
                        class="mt-1 block w-full"
                        placeholder="Product Price"
                        type="number"
                    />

                    <InputError :message="form.errors.price" class="mt-2"/>
                </div>

                <div>
                    <InputLabel for="quantity" value="Quantity"/>

                    <TextInput
                        id="quantity"
                        v-model="form.quantity"
                        class="mt-1 block w-full"
                        placeholder="Product quantity"
                        type="number"
                    />

                    <InputError :message="form.errors.quantity" class="mt-2"/>
                </div>
            </div>

            <div>
                <InputLabel for="description" value="Description"/>

                <TextArea
                    id="description"
                    v-model="form.description"
                    autocomplete="description"
                    class="mt-1 block w-full"
                    placeholder="Product Description"
                    required
                />

                <InputError :message="form.errors.description" class="mt-2"/>
            </div>

            <div>
                <InputLabel :value="'Options'" for="options"/>
                <div class="flex gap-3">
                    <Multiselect
                        v-model="form.attributes"
                        :close-on-select="false"
                        :options="options"
                        label="name"
                        mode="multiple"
                        value-prop="id"
                    />
                </div>

                <InputError :message="form.errors.attributes" class="mt-2"/>
            </div>

            <div>
                <InputLabel for="tags" value="Tags"/>

                <TextInput
                    id="tags"
                    v-model="tags"
                    autocomplete="tags"
                    class="mt-1 block w-full"
                    placeholder="Enter tags separated by comma"
                    type="text"
                />

                <InputError :message="form.errors.tags" class="mt-2"/>
            </div>

            <div>
                <InputLabel for="images" value="Images"/>

                <input id="images" multiple type="file"
                       @change="form.images = $event.target.files; imageViewer.preview($event)">

                <InputError :message="form.errors.images" class="mt-2"/>

                <PreviewImage ref="imageViewer" :model="product" url-name="admin.products.deleteMedia"/>

            </div>

            <div class="flex items-center gap-4">
                <PrimaryButton :disabled="form.processing">Save</PrimaryButton>
                <CancelButton :url="route('admin.products.index')"/>

                <Transition class="transition ease-in-out" enter-from-class="opacity-0" leave-to-class="opacity-0">
                    <p v-if="form.recentlySuccessful" class="text-sm text-gray-600">Product Added.</p>
                </Transition>
            </div>
        </form>
    </section>
</template>
