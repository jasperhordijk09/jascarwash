<template>
  <v-navigation-drawer expand-on-hover permanent location="right" rail>
    <v-list>
      <user-button />
    </v-list>

    <v-divider />
    <template v-if="appStore.me?.permissions ?? 0 > 0">

      <v-list density="compact" nav>
        <v-list-item prepend-icon="mdi-view-dashboard" title="Admin Dashboard" @click="router.push('/admin/dashboard')" />
        <v-list-item prepend-icon="mdi-account-multiple" title="Users" @click="router.push('/admin/users')" />
        <v-list-item prepend-icon="mdi-calendar-month" title="Appointments" @click="router.push('/admin/appointments')" />
        <v-list-item prepend-icon="mdi-car" title="Cars" @click="router.push('/admin/cars')" />
      </v-list>
      <v-divider />
    </template>
      <v-list density="compact" nav>
        <v-list-item prepend-icon="mdi-view-dashboard" title="Dashboard" @click="router.push('/user/dashboard')" />
        <v-list-item prepend-icon="mdi-calendar-check" title="My Appointments" @click="router.push('/user/appointments')" />
        <v-list-item prepend-icon="mdi-car" title="My Cars" @click="router.push('/user/cars')" />
      </v-list>
    <v-divider />
    <v-list>

      <v-list-item prepend-icon="mdi-logout" title="Logout" @click="logout" v-if="appStore.me" />
      <v-list-item prepend-icon="mdi-account-plus" title="Register" @click="router.push('/register')" v-else />
    </v-list>
  </v-navigation-drawer>
</template>

<script lang="ts" setup>
import router from "@/router";
import { useAppStore } from "@/stores/app";
import { ref } from "vue";
import UserButton from "./userButton.vue";
import { useAuthApi } from "@/lib/api";
const drawer = ref(false);
const appStore = useAppStore();
const authApi = useAuthApi();
async function logout() {
  await authApi.logoutAuthLogoutPost();
  appStore.me = null;
}
</script>
