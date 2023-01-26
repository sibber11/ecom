<script setup>
import NavHeader from "@/Pages/Partials/NavHeader.vue";
import NavBar from "@/Pages/Partials/NavBar.vue";
import Copyright from "@/Pages/Partials/Copyright.vue";
import FooterComponent from "@/Pages/Partials/FooterComponent.vue";
</script>

<template>
    <!-- header -->
    <NavHeader/>
    <!-- ./header -->

    <!-- navbar -->
    <NavBar/>
    <!-- ./navbar -->
    <slot />

    <!-- footer -->
    <FooterComponent/>
    <!-- ./footer -->

    <!-- copyright -->
    <Copyright/>
    <!-- ./copyright -->
</template>
