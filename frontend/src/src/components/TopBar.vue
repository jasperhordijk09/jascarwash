<template>
  <v-app-bar app color="primary" elevate-on-scroll class="d-flex align-center justify-space-between">
    <v-toolbar-title class="text-h6">
      Jascarwash
    </v-toolbar-title>

    <v-spacer />
  </v-app-bar>
</template>

<script setup lang="ts">
import router from '@/router';
import { useAppStore } from '@/stores/app';
import { ref } from 'vue'
const drawer = ref(false)
const appStore = useAppStore()
</script>
