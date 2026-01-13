/**
 * main.ts
 *
 * Bootstraps Vuetify and other plugins then mounts the App`
 */

// Plugins
import { registerPlugins } from "@/plugins";

// Components
import App from "./App.vue";

// Composables
import { createApp } from "vue";

// Styles
import "unfonts.css";

const app = createApp(App);

registerPlugins(app);

app.mount("#app");

import { useAppStore } from "@/stores/app";
import { useAuthApi } from "./lib/api";
const authApi = useAuthApi();
const AppStore = useAppStore();
authApi.whoIsCurrentUserAuthWhoamiGet().then((response) => {
  if (response) {
    AppStore.me = response;
  }
});
