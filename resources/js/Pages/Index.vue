<script setup>
import CustomerLayout from '@/Layouts/CustomerLayout.vue'
import {Head} from "@inertiajs/inertia-vue3";
import Banner from "@/Pages/Partials/Banner.vue";
import Features from "@/Pages/Partials/Features.vue";
import Categories from "@/Pages/Partials/Categories.vue";
import Ads from "@/Pages/Partials/Ads.vue";
import {provide} from "vue";
import ProductCluster from "@/Pages/Partials/ProductCluster.vue"

const props = defineProps({
    categories: Object,
    canLogin: Boolean,
    canRegister: Boolean,
    newArrival: Object,
    recommended: Object,
    cart: Number
})

provide('categories', props.categories);

</script>
<template>
    <CustomerLayout>
        <Head title="Ecommerce Tailwind"/>

        <!-- banner -->
        <Banner/>
        <!-- ./banner -->

        <!-- features -->
        <Features/>
        <!-- ./features -->

        <!-- categories -->
        <Categories/>
        <!-- ./categories -->

        <!-- new arrival -->
        <ProductCluster :products="newArrival">
            top new arrival
        </ProductCluster>
        <!-- ./new arrival -->

        <!-- ads -->
        <Ads/>
        <!-- ./ads -->

        <!-- product -->
        <ProductCluster :products="recommended">
            recommended for you
        </ProductCluster>
        <!-- ./product -->

    </CustomerLayout>
</template>
