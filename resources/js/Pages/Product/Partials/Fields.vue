<script setup>
import {useForm} from '@inertiajs/inertia-vue3';
import {onMounted, ref, watch} from "vue";
import {submitForm} from "@/helper";
import InputError from '@/Components/InputError.vue';
import InputLabel from '@/Components/InputLabel.vue';
import PrimaryButton from '@/Components/PrimaryButton.vue';
import TextInput from '@/Components/TextInput.vue';
import TextArea from "@/components/TextArea.vue";
import SelectModels from '@/components/SelectModels.vue'
import SlugInput from '@/components/SlugInput.vue'
import {InertiaLink} from "@inertiajs/inertia-vue3";

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
    _method: 'post'
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

    // check if the tags array is empty, if not, then map the tags array and return the name of each tag
    form.tags = props.product.tags.length > 0 ? props.product.tags.map(tag => tag.name.en) : [];

})

const preview_list = ref([]);
const image_list = ref([]);
const previewMultiImage = function (event) {
    const input = event.target;
    let count = input.files.length;
    let index = 0;
    //empty preview_list and image_list
    preview_list.value = [];
    image_list.value = [];
    if (input.files) {
        while (count--) {
            const reader = new FileReader();
            reader.onload = (e) => {
                preview_list.value.push(e.target.result);
            }
            image_list.value.push(input.files[index]);
            reader.readAsDataURL(input.files[index]);
            index++;
        }
    }
}

const slug_input = ref(null);
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

                <SelectModels v-model="form.category" :url="route('categories.get_names')" model-name="Category"/>

                <InputError class="mt-2" :message="form.errors.category"/>
            </div>

            <div>
                <InputLabel for="category_name" value="Brand"/>

                <SelectModels v-model="form.brand" :url="route('brands.get_names')" model-name="Brand"/>

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
                    v-model="form.tags"
                    autocomplete="tags"
                    placeholder="Enter tags separated by comma"
                />

                <InputError class="mt-2" :message="form.errors.tags"/>
            </div>

            <div>
                <InputLabel for="images" value="Images"/>

                <input type="file" id="images" @change="form.images = $event.target.files; previewMultiImage($event)"
                       multiple>

                <progress v-if="form.progress" :value="form.progress.percentage" max="100" class="">
                    {{ form.progress.percentage }}%
                </progress>

                <InputError class="mt-2" :message="form.errors.images"/>

                <template v-if="preview_list.length">
                    <div class="flex mt-8 flex-wrap justify-start">
                        <div v-for="(item, index) in preview_list" :key="index"
                             class="border-2 p-1 rounded flex flex-col justify-between m-1">
                            <img :src="item" class="w-52" alt="images"/>
                            <div>
                                <p class="">File name: {{ image_list[index].name }}</p>
                                <p class="">Size: {{ Math.floor(image_list[index].size / 1024) }} KB</p>
                            </div>
                        </div>
                    </div>
                </template>

                <template v-if="product?.media">
                    <div class="flex mt-8 flex-wrap justify-start">
                        <div v-for="(item, index) in product.media" :key="index"
                             class="border-2 p-1 rounded flex flex-col justify-between m-1">
                            <img :src="item.original_url" class="w-52" alt="images"/>
                            <InertiaLink :href="route('products.deleteMedia', [product, item])" as="button"
                                         method="delete"
                                         class="text-center border border-red-300 text-red-600 text-3xl">
                                <i class="fa fa-trash"></i>
                                <span class="m-2 font-bold">Delete</span>
                            </InertiaLink>
                        </div>
                    </div>
                </template>
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
