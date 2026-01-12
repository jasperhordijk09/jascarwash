<template>
  <v-app-bar app color="primary" elevate-on-scroll class="d-flex align-center justify-space-between">

    <v-toolbar-title class="text-h6">
      Jascarwash
    </v-toolbar-title>

    <v-spacer />
    <v-toolbar-title class="text-h6" v-if="appStore.me">
      Welcome, {{ appStore.me.full_name ?? appStore.me.username }}
    </v-toolbar-title>
    <v-btn icon @click="router.push('/login')">
      <v-icon icon="mdi-account" />
    </v-btn>
    <top-bar-menu />
  </v-app-bar>
</template>

<script setup lang="ts">
import router from '@/router';
import { useAppStore } from '@/stores/app';
import { ref } from 'vue'
const drawer = ref(false)
const appStore = useAppStore()
</script>
