<template>
  <v-main>
    <router-view />
  </v-main>
  <template v-if="route.path !== '/login'">
    <nav-bar />
    <AppFooter />
    <TopBar />
  </template>
</template>

<script lang="ts" setup>
import { useRoute } from 'vue-router'

const route = useRoute()
</script>
