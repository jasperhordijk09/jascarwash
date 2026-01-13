<template>
  <v-main>
    <router-view />
    <nav-bar />
    <v-list density="compact" nav>
      <v-list-item prepend-icon="mdi-calendar-month" title="my Appointments"></v-list-item>
      <v-list-item prepend-icon="mdi-car" title="My Cars"></v-list-item>
    </v-list>
  </v-main>
</template>

<script lang="ts" setup>

</script>
