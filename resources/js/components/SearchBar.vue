<script setup>
import {ref} from "vue";
import debounce from "lodash/debounce";

const query = ref('')
const products = ref([]);

//use debounce for the getProducts function by 300ms
const getProducts = debounce(() => {
    if (query.value.length < 3) return
    axios.get(route('search'), {
        params: {
            query: query.value
        }
    }).then((response) => {
        console.log(response.data)
        products.value = response.data.data;
    })
}, 300)

const focused = ref(true);
</script>

<template>
    <div class="w-full max-w-xl relative px-4" >
        <a class="absolute right-8 top-3 text-lg text-gray-400" href="#">
            <i class="fa fa-magnifying-glass"></i>
        </a>
        <input id="search" v-model="query" :class="{ 'rounded-b-none': focused && products.length }"
               class="w-full border border-primary py-3 pr-3 rounded-md focus:outline-none"
               placeholder="Search"
               type="text" @input="getProducts">
        <div class="absolute w-full left-0 z-10 px-4">
            <ul class="bg-white border shadow-2xl rounded-b-md w-full p-1 ">
                <li v-for="product in products" :key="product.id" class="hover:bg-red-200 bg-white p-1 m-1 border">
                    <a :href="route('products.show', product)" class="flex justify-between items-center">
                    <span class="inline-flex items-center">
                        <img :src="product.image" alt="product image" class="w-12 h-12">
                        <span class="ml-2 text-sm text-gray-600">{{ product.name }}</span>
                    </span>
                        <div>
                        <span class="ml-2 text-sm text-gray-600">
                            {{ product.reviews_avg_rating }}
                            <i class="fa fa-star text-primary"></i>
                        </span>
                            <span class="text-sm text-gray-600">
                            ({{ product.reviews_count }})
                        </span>
                        </div>
                        <span class="text-sm text-gray-600">${{ product.price }}</span>
                    </a>
                </li>
            </ul>
        </div>
    </div>
</template>
