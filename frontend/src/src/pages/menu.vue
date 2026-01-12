<template>
  <div class="menu-page">
    <top-bar />
    <h1>Menu Page</h1>
    <v-box>
      <v-btn variant="tonal" @click"router.push("/login")"  color="primary" type="submit">
        Login
      </v-btn>
    </v-box>
  </div>
</template>

<script lang="ts" setup>
  import router from '@/router';
  import { ref } from 'vue'
  import { useAppStore } from '@/stores/app';
  const drawer = ref(false)
  const appStore = useAppStore()
</script>
