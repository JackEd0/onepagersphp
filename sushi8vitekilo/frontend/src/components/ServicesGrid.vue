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
    image: 'https://images.unsplash.com/photo-1504674900247-0877df9cc836?q=80&w=2070&auto=format&fit=crop&ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D',
  },
  {
    name: 'Dragon Roll',
    price: '$18.00',
    description: 'Eel, avocado, cucumber, and flying fish roe.',
    image: 'https://images.unsplash.com/photo-1582092790000-252120100000?q=80&w=2070&auto=format&fit=crop&ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D',
  },
  {
    name: 'Spicy Tuna Roll',
    price: '$15.00',
    description: 'Tuna, spicy mayo, and cucumber.',
    image: 'https://images.unsplash.com/photo-1579871702107-87e1667981c8?q=80&w=2070&auto=format&fit=crop&ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D',
  },
  {
    name: 'California Roll',
    price: '$12.00',
    description: 'Crab, avocado, and cucumber.',
    image: 'https://images.unsplash.com/photo-1559306060-e426a577184c?q=80&w=2070&auto=format&fit=crop&ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D',
  },
  {
    name: 'Tempura Udon',
    price: '$16.00',
    description: 'Udon noodles in broth with shrimp tempura.',
    image: 'https://images.unsplash.com/photo-1563612116625-30123797572f?q=80&w=2070&auto=format&fit=crop&ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D',
  },
]);
</script>

<style scoped>
/* Scoped styles for ServicesGrid component */
</style>