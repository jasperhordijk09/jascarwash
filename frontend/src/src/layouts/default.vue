<template>
  <v-main>
    <router-view />
  </v-main>
  <template v-if="route.path !== '/login'">
    <AppFooter />
    <TopBar />
  </template>
</template>

<script lang="ts" setup>
import { useRoute } from 'vue-router'

const route = useRoute()
</script>
