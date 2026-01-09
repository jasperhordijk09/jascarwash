<template>
  <v-main>
    <router-view />
  </v-main>

  <AppFooter v-if="route.path !== '/login'" />
</template>

<script lang="ts" setup>
import { useRoute } from 'vue-router'

const route = useRoute()
</script>
