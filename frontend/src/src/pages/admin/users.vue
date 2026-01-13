<template>
  <v-main>
    <router-view />
    <nav-bar />
    <v-list>
      <v-list-item prepend-icon="mdi-user" title={{appStore.me.username}}>
        <v-list-item-subtitle>
          {{ appStore.me.email }}
          {{ appStore.me.full_name }}
        </v-list-item-subtitle>
      </v-list-item>
    </v-list>
  </v-main>
</template>

<script lang="ts" setup>
import { useAppStore } from '@/stores/appStore';
const appStore = useAppStore();
</script>
