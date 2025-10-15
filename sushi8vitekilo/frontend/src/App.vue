<script setup lang="ts">
import Header from './components/Header.vue';
import Hero from './components/Hero.vue';
import ServicesGrid from './components/ServicesGrid.vue';
import Testimonials from './components/Testimonials.vue';
import ContactHours from './components/ContactHours.vue';
</script>

<template>
  <v-app>
    <Header />
    <v-main>
      <v-container fluid class="pa-0">
        <Hero id="home" />
        <ServicesGrid id="menu" />
        <Testimonials id="testimonials" />
        <ContactHours id="contact" />
      </v-container>
    </v-main>
  </v-app>
</template>

<style scoped>
/* No scoped styles yet */
</style>
