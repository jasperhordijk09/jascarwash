<template>
  <v-menu location="top">
    <template #activator="{ props }">
      <v-btn icon v-bind="props">
        <v-icon icon="mdi-menu" />
      </v-btn>
    </template>

    <v-list>
      <v-list-item link @click="router.push('/menu')">
        <v-list-item-title>Menu</v-list-item-title>
      </v-list-item>
      <v-list-item link @click="router.push('/login')">
        <v-list-item-title>Login</v-list-item-title>
      </v-list-item>
      <v-list-item link @click="router.push('/register')">
        <v-list-item-title>Register</v-list-item-title>
      </v-list-item>
      <v-list-item link @click="router.push('/logout')">
        <v-list-item-title>Logout</v-list-item-title>
      </v-list-item>
    </v-list>
  </v-menu>
</template>

<script setup lang="ts">
import router from '@/router';
import { ref } from 'vue'
import { useAppStore } from '@/stores/app';
const drawer = ref(false)
const appStore = useAppStore()
</script>
