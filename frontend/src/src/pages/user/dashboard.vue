<template>
  <v-main>
    <v-container>
      <h1>Welcome to your Dashboard, {{ appStore.me?.username }}</h1>

      <v-row>
        <v-col cols="12" md="6">
          <v-card elevation="4" class="pa-4">
            <v-card-title>
              <v-icon>mdi-account</v-icon>
              Your Profile
            </v-card-title>
            <v-card-text>
              <p><strong>Username:</strong> {{ appStore.me?.username }}</p>
              <p><strong>Email:</strong> {{ appStore.me?.email }}</p>
              <p><strong>Full Name:</strong> {{ appStore.me?.full_name }}</p>
              <p><strong>Phone:</strong> {{ appStore.me?.phone }}</p>
            </v-card-text>
          </v-card>
        </v-col>

        <v-col cols="12" md="6">
          <v-card elevation="4" class="pa-4">
            <v-card-title>
              <v-icon>mdi-car</v-icon>
              Your Cars
            </v-card-title>
            <v-card-text>
              <p v-if="userCars.length === 0">No cars registered yet.</p>
              <div v-else>
                <v-chip v-for="car in userCars" :key="car.kenteken" class="ma-1">
                  {{ car.merk }} {{ car.handelsbenaming }} - {{ car.kenteken }}
                </v-chip>
              </div>
              <v-btn color="primary" @click="registerCar" class="mt-2">
                Register New Car
              </v-btn>
            </v-card-text>
          </v-card>
        </v-col>
      </v-row>

      <v-row class="mt-4">
        <v-col cols="12">
          <v-card elevation="4" class="pa-4">
            <v-card-title>
              <v-icon>mdi-calendar</v-icon>
              Upcoming Appointments
            </v-card-title>
            <v-card-text>
              <p>No upcoming appointments.</p>
              <v-btn color="primary" @click="bookAppointment">
                Book Appointment
              </v-btn>
            </v-card-text>
          </v-card>
        </v-col>
      </v-row>
    </v-container>
  </v-main>
</template>

<script lang="ts" setup>
import { onMounted, ref } from 'vue'
import { useAppStore } from '@/stores/app'
import { useV1Api } from '@/lib/api'
import type { NumberplateData } from '@/api/models'

const appStore = useAppStore()
const v1Api = useV1Api()
const userCars = ref<NumberplateData[]>([])

onMounted(async () => {
  // Assuming user has numberplate, fetch car data
  if ((appStore.me as any)?.numberplate) {
    try {
      const carData = await v1Api.getNumberplateV1NumberplateNumberplateGet({ numberplate: (appStore.me as any).numberplate })
      userCars.value = carData
    } catch (error) {
      console.error('Failed to fetch car data:', error)
    }
  }
})

const registerCar = () => {
  // Navigate to car registration page or open dialog
  console.log('Register car')
}

const bookAppointment = () => {
  // Navigate to booking page
  console.log('Book appointment')
}
</script>
