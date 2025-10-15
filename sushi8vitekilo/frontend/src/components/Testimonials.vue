<template>
  <v-container class="my-12">
    <h2 class="text-h3 text-center mb-8">What Our Customers Say</h2>
    <v-row justify="center">
      <v-col
        v-for="(testimonial, i) in testimonials"
        :key="i"
        cols="12"
        md="6"
        lg="4"
      >
        <v-card class="mx-auto pa-4 d-flex flex-column" max-width="400" height="100%">
          <v-card-text class="text-center">
            <v-avatar size="80" class="mb-4">
              <v-img :src="testimonial.avatar" :alt="testimonial.name"></v-img>
            </v-avatar>
            <p class="text-body-1 mb-4">"{{ testimonial.quote }}"</p>
            <p class="font-weight-bold">{{ testimonial.name }}</p>
            <p class="text-caption text-grey">{{ testimonial.title }}</p>
          </v-card-text>
        </v-card>
      </v-col>
    </v-row>
  </v-container>
</template>

<script setup lang="ts">
import { ref } from 'vue';

const testimonials = ref([
  {
    name: 'Jane Doe',
    title: 'Food Critic',
    quote: 'The best sushi I\'ve ever had! Fresh, flavorful, and beautifully presented.',
    avatar: 'https://randomuser.me/api/portraits/women/1.jpg',
  },
  {
    name: 'John Smith',
    title: 'Local Enthusiast',
    quote: 'A true hidden gem. The ambiance is perfect, and the sushi is out of this world.',
    avatar: 'https://randomuser.me/api/portraits/men/1.jpg',
  },
  {
    name: 'Emily White',
    title: 'Regular Customer',
    quote: 'Always a fantastic experience. The staff are friendly, and the quality is consistently high.',
    avatar: 'https://randomuser.me/api/portraits/women/2.jpg',
  },
]);
</script>

<style scoped>
/* Scoped styles for Testimonials component */
</style>