<template>
    <v-navigation-drawer
        expand-on-hover
        permanent
        rail>
      <v-list>
        <v-list-item
            prepend-icon="mdi-home"
            title="Home"
            value="home"
            @click="router.push('/')"
        >
        </v-list-item>
      </v-list>

      <v-divider></v-divider>

      <v-list density="compact" nav>
        <v-list-item prepend-icon="mdi-folder" title="My Files" value="myfiles"></v-list-item>
        <v-list-item prepend-icon="mdi-account-multiple" title="Shared with me" value="shared"></v-list-item>
        <v-list-item prepend-icon="mdi-star" title="Starred" value="starred"></v-list-item>
      </v-list>
    </v-navigation-drawer>
</template>

<script lang="ts" setup>
import router from "@/router";
import { useAppStore } from "@/stores/app";
import { ref } from "vue";
const drawer = ref(false);
const appStore = useAppStore();
</script>
