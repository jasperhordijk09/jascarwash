<template>
  <v-main>
    <router-view />
    <nav-bar />
    <v-container>
      <h1>Users</h1>
      <v-row>
        <v-col v-for="user in users" :key="user.id" cols="12" sm="6" md="4">
          <v-card>
            <v-card-title>
              <v-icon>mdi-user</v-icon>
              {{ user.username }}
            </v-card-title>
            <v-card-text>
              Email: {{ user.email }}<br>
              Full Name: {{ user.full_name }}<br>
              Disabled: {{ user.disabled ? 'Yes' : 'No' }}<br>
              Created At: {{ user.created_at ? new Date(user.created_at).toLocaleDateString() : 'N/A' }}<br>
              Permissions: {{ user.permissions }}
            </v-card-text>
          </v-card>
        </v-col>
      </v-row>
    </v-container>
  </v-main>
</template>

<script lang="ts" setup>
  import { onMounted, ref } from 'vue'
  import { RouterView } from 'vue-router'
  import { useAuthApi } from '@/lib/api'
  import type { User } from '@/api/models'

  const authApi = useAuthApi()
  const users = ref<User[]>([])

  onMounted(async () => {
    try {
      users.value = await authApi.listUsersAuthListUsersGet()
    } catch (error) {
      console.error('Failed to fetch users:', error)
    }
  })
</script>
