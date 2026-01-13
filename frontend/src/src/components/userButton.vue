<template>
  <v-list-item prepend-icon="mdi-account" @click="router.push('/login')" v-if="appStore.me === null">
    Login
  </v-list-item>
  <v-list-item v-else @click="router.push('/profile')">
    <template #prepend>
      <v-avatar size="32" class="text-white" :color="avatarColor(appStore.me.full_name ?? appStore.me.username)">
        {{ (appStore.me.full_name ?? appStore.me.username)[0]?.toUpperCase() }}
      </v-avatar>
    </template>

    {{ appStore.me.full_name ?? appStore.me.username }}
  </v-list-item>
</template>

<script lang="ts" setup>
import router from "@/router";
import { useAppStore } from "@/stores/app";
import { ref } from "vue";
const drawer = ref(false);
const appStore = useAppStore();
const avatarColor = (name: string) => {
  let hash = 0
  for (let i = 0; i < name.length; i++) {
    hash = name.charCodeAt(i) + ((hash << 5) - hash)
  }

  const hue = Math.abs(hash) % 360
  return `hsl(${hue}, 65%, 50%)`
}
</script>
