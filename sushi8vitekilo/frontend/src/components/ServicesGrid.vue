<template>
  <v-container class="my-12">
    <h2 class="text-h3 text-center mb-8">Our Menu</h2>
    <v-row>
      <v-col
        v-for="(item, i) in menuItems"
        :key="i"
        cols="12"
        sm="6"
        md="4"
        lg="3"
      >
        <v-card class="mx-auto" max-width="344">
          <v-img
            :src="item.image"
            height="200px"
            cover
          ></v-img>

          <v-card-title>
            {{ item.name }}
          </v-card-title>

          <v-card-subtitle>
            {{ item.price }}
          </v-card-subtitle>

          <v-card-text>
            {{ item.description }}
          </v-card-text>
        </v-card>
      </v-col>
    </v-row>
  </v-container>
</template>

<script setup lang="ts">
import { ref } from 'vue';

const menuItems = ref([
  {
    name: 'Nigiri Set',
    price: '$25.00',
    description: 'Assortment of fresh fish nigiri.',
    image: 'https://images.unsplash.com/photo-1504674900247-0877df9cc836?q=80&w=2070&auto=format&fit=crop&ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D',
  },
  {
    name: 'Sashimi Platter',
    price: '$30.00',
    description: 'Chef\'s selection of premium sashimi.',
    image: 'https://unsplash.com/photos/-1GEAA8q3wk/download?ixid=M3wxMjA3fDB8MXxzZWFyY2h8M3x8c3VzaGl8ZW58MHwwfHx8MTc2MDQ0NDIyM3ww&force=true',
  },
  {
    name: 'Dragon Roll',
    price: '$18.00',
    description: 'Eel, avocado, cucumber, and flying fish roe.',
    image: 'https://images.unsplash.com/photo-1617196034796-73dfa7b1fd56?ixlib=rb-4.1.0&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D&auto=format&fit=crop&q=80&w=1170',
  },
  {
    name: 'Spicy Tuna Roll',
    price: '$15.00',
    description: 'Tuna, spicy mayo, and cucumber.',
    image: 'https://images.unsplash.com/photo-1611143669185-af224c5e3252?ixlib=rb-4.1.0&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D&auto=format&fit=crop&q=80&w=1332',
  },
  {
    name: 'California Roll',
    price: '$12.00',
    description: 'Crab, avocado, and cucumber.',
    image: 'https://images.unsplash.com/photo-1553621042-f6e147245754?ixlib=rb-4.1.0&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D&auto=format&fit=crop&q=80&w=1025',
  },
  {
    name: 'Tempura Udon',
    price: '$16.00',
    description: 'Udon noodles in broth with shrimp tempura.',
    image: 'https://unsplash.com/photos/MgvByrhYz24/download?ixid=M3wxMjA3fDB8MXxzZWFyY2h8MTB8fHN1c2hpfGVufDB8MHx8fDE3NjA0NDQyMjN8MA&force=true',
  },
]);
</script>

<style scoped>
/* Scoped styles for ServicesGrid component */
</style>