<template>
  <v-container fluid>
    <v-row>
      <v-col
        v-for="prompt in prompts"
        :key="prompt.id"
        cols="12"
        sm="6"
        md="4"
        lg="3"
      >
        <v-card>
          <v-card-title>{{ prompt.title }}</v-card-title>
          <v-card-subtitle>{{ prompt.instructions }}</v-card-subtitle>
          <v-card-text>{{ prompt.content }}</v-card-text>
          <v-card-actions>
            <v-chip
              v-for="tag in prompt.tags"
              :key="tag"
              class="mr-2"
            >
              {{ tag }}
            </v-chip>
            <v-spacer></v-spacer>
            <v-btn icon @click="prompt.favorite = !prompt.favorite">
              <v-icon>{{ prompt.favorite ? 'mdi-heart' : 'mdi-heart-outline' }}</v-icon>
            </v-btn>
            <v-btn icon>
              <v-icon>mdi-content-copy</v-icon>
            </v-btn>
            <v-btn icon>
              <v-icon>mdi-code-json</v-icon>
            </v-btn>
          </v-card-actions>
        </v-card>
      </v-col>
    </v-row>
  </v-container>
</template>

<script setup>
import { ref, onMounted } from 'vue'
import { prompts as mockPrompts } from '../mock-data.js'

const prompts = ref([])
const apiUrl = import.meta.env.VITE_PHP_API_URL

onMounted(async () => {
  if (apiUrl) {
    try {
      const response = await fetch(apiUrl)
      console.log('Raw API Response:', await response.clone().text());
      if (!response.ok) {
        throw new Error(`HTTP error! status: ${response.status}`)
      }
      prompts.value = await response.json()
    } catch (error) {
      console.error('Error fetching prompts from API:', error)
      // Fallback to mock data if API fails
      prompts.value = mockPrompts
    }
  } else {
    // Use mock data if no API URL is provided
    prompts.value = mockPrompts
    console.warn('No API URL provided. Using mock data.')
  }
})
</script>