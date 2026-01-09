<template>
  <v-container class="d-flex justify-center align-center fill-height">
    <v-card class="pa-6" width="400" elevation="4">
      <v-img :src="logo" aspect-ratio="16/9"></v-img>
      <v-card-text>
        <form @submit.prevent="login">
          <v-text-field v-model="username" label="Username" autocomplete="username" name="username" type="text" outlined density="comfortable" />

          <v-text-field v-model="password" label="Password" autocomplete="password" type="password" outlined density="comfortable" />

          <v-alert v-if="error" type="error" dense class="mt-2">
            {{ error }}
          </v-alert>

          <v-card-actions class="d-flex justify-center mt-2">
            <v-btn variant="tonal" :loading="loading" color="primary" type="submit">
              Login
            </v-btn>
          </v-card-actions>
        </form>
      </v-card-text>
    </v-card>
  </v-container>
</template>

<script lang="ts" setup>
import { ref } from "vue";
import logo from "@/assets/jascarwashLogo.png";
import { useAuthApi, useV1Api } from "@/lib/api";
import router from "@/router";
import { useAppStore } from "@/stores/app";
const AppStore = useAppStore()
const username = ref("");
const password = ref("");
const error = ref("");
const loading = ref(false);
const authApi = useAuthApi();
async function login() {
  loading.value = true;
  try {
    await authApi.loginForAccessTokenAuthLoginPost({
      username: username.value,
      password: password.value,
    });
  } catch (e: any) {
    loading.value = false;
    if (e.response.status === 401) {
      error.value = "Invalid username or password";
      return;
    }
    error.value = e.message || "Login failed";
  }
  router.push("/");
  loading.value = false;
}
onMounted(async () => {
  try {
    const response = await authApi.whoIsCurrentUserAuthWhoamiGet();
    if (response
    ) {
      router.push("/");
      AppStore.me = response;
    }
  } catch (e) { }
});
</script>
