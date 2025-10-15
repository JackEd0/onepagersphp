<template>
  <v-container class="my-12">
    <h2 class="text-h3 text-center mb-8">Contact Us & Hours</h2>
    <v-row justify="center">
      <v-col cols="12" md="6" lg="4">
        <v-card class="mx-auto pa-4 d-flex flex-column" max-width="400" height="100%">
          <v-card-title class="text-h5">Contact Information</v-card-title>
          <v-card-text>
            <p class="mb-2">
              <v-icon left>mdi-phone</v-icon>
              Phone: (123) 456-7890
            </p>
            <p class="mb-2">
              <v-icon left>mdi-email</v-icon>
              Email: info@sushibar.com
            </p>
            <p class="mb-2">
              <v-icon left>mdi-map-marker</v-icon>
              Address: 123 Sushi Lane, Flavor Town, ST 12345
            </p>
          </v-card-text>
        </v-card>
      </v-col>
      <v-col cols="12" md="6" lg="4">
        <v-card class="mx-auto pa-4 d-flex flex-column" max-width="400" height="100%">
          <v-card-title class="text-h5">Operating Hours</v-card-title>
          <v-card-text>
            <p class="mb-2">
              <v-icon left>mdi-calendar-today</v-icon>
              Monday - Friday: 11:30 AM - 10:00 PM
            </p>
            <p class="mb-2">
              <v-icon left>mdi-calendar-today</v-icon>
              Saturday: 12:00 PM - 11:00 PM
            </p>
            <p class="mb-2">
              <v-icon left>mdi-calendar-today</v-icon>
              Sunday: 12:00 PM - 9:00 PM
            </p>
          </v-card-text>
        </v-card>
      </v-col>
    </v-row>
  </v-container>
</template>

<script setup lang="ts">
// Script for ContactHours component
</script>

<style scoped>
/* Scoped styles for ContactHours component */
</style>