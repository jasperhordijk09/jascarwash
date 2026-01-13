<template>
  <v-container>
    <h1>Welcome to your Dashboard, {{ appStore.me?.username }}</h1>

    <v-row>
      <v-col cols="12" md="6">
        <v-card class="pa-4" elevation="4">
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
        <v-card class="pa-4" elevation="4">
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
            <v-btn
              class="mt-2"
              color="primary"
              text="Add Car"
              variant="flat"
              @click="addCarDialog = true"
            />
          </v-card-text>
        </v-card>
      </v-col>
    </v-row>

    <v-row class="mt-4">
      <v-col cols="12">
        <v-card class="pa-4" elevation="4">
          <v-card-title>
            <v-icon>mdi-calendar</v-icon>
            Upcoming Appointments
          </v-card-title>
          <v-card-text>
            <p>No upcoming appointments.</p>
            <v-btn
              color="primary"
              @click="bookAppointment"
            >
              Book Appointment
            </v-btn>
          </v-card-text>
        </v-card>
      </v-col>
    </v-row>

    <!-- Add Car Dialog -->
    <v-dialog v-model="addCarDialog" max-width="500">
      <v-card
        class="pa-4"
        title="Add a car"
      >
        <!-- Horizontal layout for text field + button -->
        <div style="display: flex; align-items: center; gap: 32px;">
          <v-text-field
            v-model="newLicensePlate"
            density="comfortable"
            label="License Plate"
            max-length="6"
            outlined
            style="flex: 1;"
          />
        </div>
        <v-card-actions>
          <v-btn
            color="primary"
            variant="flat"
            @click="addCar(newLicensePlate)"
          >
            Add
          </v-btn>
          <v-btn
            color="primary"
            variant="flat"
            @click="addCarDialog = false"
          >
            cancel
          </v-btn>
        </v-card-actions>
      </v-card>
    </v-dialog>
  </v-container>
</template>

<script lang="ts" setup>
  import type { NumberplateData } from '@/api/models'
  import { onMounted, ref } from 'vue'
  import { useRouter } from 'vue-router'
  import { useV1Api } from '@/lib/api'
  import { useAppStore } from '@/stores/app'

  const router = useRouter()

  const appStore = useAppStore()
  const v1Api = useV1Api()
  const userCars = ref<NumberplateData[]>([])
  const newLicensePlate = ref('')
  const addCarDialog = ref(false)

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

  async function addCar (licensePlate: string) {
    if (!licensePlate || typeof licensePlate !== 'string' || !licensePlate.trim()) {
      alert('Please enter a valid license plate.')
      return
    }
    try {
      console.log('Attempting to add car with license plate:', licensePlate.trim().toUpperCase())
      await v1Api.registerCarV1CarRegisterPost({
        licensePlate: licensePlate.trim().toUpperCase(),
      })
      console.log('Car added successfully')
      addCarDialog.value = false
      newLicensePlate.value = ''
      // Refresh cars
      if ((appStore.me as any)?.numberplate) {
        const carData = await v1Api.getNumberplateV1NumberplateNumberplateGet({ numberplate: (appStore.me as any).numberplate })
        userCars.value = carData
      }
    } catch (error: any) {
      console.error('Full error:', error)
      if (error.response) {
        console.error('Response status:', error.response.status)
        console.error('Response data:', error.response.data)
        if (error.response.status === 401) {
          alert('You are not logged in. Please log in first.')
        } else if (error.response.status === 400) {
          alert('Invalid license plate or already registered.')
        } else {
          alert(`Failed to add car: ${error.response.status} ${error.response.statusText}`)
        }
      } else {
        alert('Network error. Please check your connection.')
      }
    }
  }

  function bookAppointment () {
    // Navigate to appointments page
    router.push('/user/appointments')
  }
</script>
