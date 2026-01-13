<template>
  <v-container>
    <h1>Users</h1>
    <v-row>
      <v-col v-for="user in users" :key="user.id" cols="12" md="4" sm="6">
        <v-card elevation="8" color="primary-darken-1" class="user-card">
          <v-card-title>
            <v-icon>mdi-user</v-icon>
            {{ user.username }}
          </v-card-title>
          <v-card-text>
            Email: {{ user.email }}<br>
            Full Name: {{ user.full_name }}<br>
            Phone: {{ user.phone }}<br>
            Disabled: {{ user.disabled ? 'Yes' : 'No' }}<br>
            Created At: {{ user.created_at ? new Date(user.created_at).toLocaleDateString() : 'N/A' }}<br>
            Permissions: {{ user.permissions }}<br>
            <span v-if="user.carData">
              Car Brand: {{ user.carData.merk }}<br>
              Car Model: {{ user.carData.handelsbenaming }}<br>
              License Plate: {{ user.carData.kenteken }}
            </span>
          </v-card-text>
        </v-card>
      </v-col>
    </v-row>
  </v-container>
</template>

<script lang="ts" setup>
  import { onMounted, ref } from 'vue'
  import { RouterView } from 'vue-router'
  import { useAuthApi, useV1Api } from '@/lib/api'
  import type { User, NumberplateData } from '@/api/models'

  const authApi = useAuthApi()
  const v1Api = useV1Api()
  const users = ref<(User & { carData?: NumberplateData })[]>([])

  onMounted(async () => {
    try {
      users.value = await authApi.listUsersAuthListUsersGet()
      // Fetch car data for each user with numberplate
      for (const user of users.value) {
        if ((user as any).numberplate) {
          try {
            const carData = await v1Api.getNumberplateV1NumberplateNumberplateGet({ numberplate: (user as any).numberplate })
            user.carData = carData[0] // Assuming array, take first
          } catch (error) {
            console.error(`Failed to fetch car data for ${user.username}:`, error)
          }
        }
      }
    } catch (error) {
      console.error('Failed to fetch users:', error)
    }
  })
</script>

<style scoped>
.user-card {
  transition: transform 0.2s, box-shadow 0.2s;
}

.user-card:hover {
  transform: translateY(-4px);
  box-shadow: 0 8px 16px rgba(0, 0, 0, 0.2) !important;
}
</style>
