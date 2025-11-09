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

const prompts = ref([])

onMounted(async () => {
  try {
    const response = await fetch('/api/prompts.php')
    prompts.value = await response.json()
  } catch (error) {
    console.error('Error fetching prompts:', error)
  }
})
</script>
<script setup>
  //
</script>