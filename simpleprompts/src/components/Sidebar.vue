<template>
  <v-navigation-drawer permanent>
    <v-list>
      <v-list-item title="Simple Prompts" subtitle="Your prompt library"></v-list-item>
    </v-list>

    <v-divider></v-divider>

    <v-text-field
      label="Search"
      variant="solo"
      class="mx-4 my-4"
    ></v-text-field>

    <v-list-item>
      <v-checkbox label="Filter by favorites"></v-checkbox>
    </v-list-item>

    <v-list-subheader>Tags</v-list-subheader>
    <v-list-item v-for="n in 5" :key="n" :title="`Tag ${n}`" link>
    </v-list-item>

  </v-navigation-drawer>
</template>

<script setup>
  //
</script>