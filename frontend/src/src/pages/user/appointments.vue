<template>
  <v-container>
    <h1>My Appointments</h1>

      <v-row>
        <v-col cols="12">
          <v-card class="pa-4" elevation="4">
            <v-card-title>
              <v-icon>mdi-calendar-check</v-icon>
              Book an Appointment
            </v-card-title>
            <v-card-text>
              <p>Select an available timeslot to book your appointment.</p>

              <v-select
                v-model="selectedDate"
                :items="availableDates"
                label="Select Date"
                @update:model-value="loadTimeslots"
              />

              <div v-if="timeslots.length > 0" class="mt-4">
                <h3>Available Timeslots</h3>
                <v-row>
                  <v-col
                    v-for="slot in timeslots"
                    :key="slot.id"
                    cols="12"
                    md="4"
                    sm="6"
                  >
                    <v-card
                      class="pa-2"
                      outlined
                      @click="bookSlot(slot)"
                    >
                      <v-card-text>
                        <p class="text-h6">{{ slot.time }}</p>
                        <p>{{ slot.date }}</p>
                      </v-card-text>
                    </v-card>
                  </v-col>
                </v-row>
              </div>

              <div v-else-if="selectedDate">
                <p>No available timeslots for this date.</p>
              </div>
            </v-card-text>
          </v-card>
        </v-col>
      </v-row>

      <v-row class="mt-4">
        <v-col cols="12">
          <v-card class="pa-4" elevation="4">
            <v-card-title>
              <v-icon>mdi-calendar-month</v-icon>
              My Upcoming Appointments
            </v-card-title>
            <v-card-text>
              <div v-if="myAppointments.length === 0">
                <p>No upcoming appointments.</p>
              </div>
              <div v-else>
                <v-list>
                  <v-list-item
                    v-for="appointment in myAppointments"
                    :key="appointment.id"
                  >
                    <v-list-item-title>{{ appointment.date }} at {{ appointment.time }}</v-list-item-title>
                    <v-list-item-subtitle>Status: {{ appointment.status }}</v-list-item-subtitle>
                  </v-list-item>
                </v-list>
              </div>
            </v-card-text>
          </v-card>
        </v-col>
      </v-row>
    </v-container>
</template>

<script lang="ts" setup>
  import { onMounted, ref } from 'vue'

  const selectedDate = ref('')
  const availableDates = ref<string[]>([])
  const timeslots = ref<any[]>([])
  const myAppointments = ref<any[]>([])

  onMounted(() => {
    loadAvailableDates()
    loadMyAppointments()
  })

  function loadAvailableDates () {
    // Load from localStorage (set by admin)
    const stored = localStorage.getItem('admin-timeslots')
    if (stored) {
      const slots: any[] = JSON.parse(stored)
      const dates = [...new Set(slots.map(slot => slot.date as string))]
      availableDates.value = dates.toSorted()
    } else {
      availableDates.value = []
    }
  }

  function loadTimeslots () {
    if (selectedDate.value) {
      const stored = localStorage.getItem('admin-timeslots')
      if (stored) {
        const slots = JSON.parse(stored)
        timeslots.value = slots.filter((slot: any) => slot.date === selectedDate.value)
      } else {
        timeslots.value = []
      }
    } else {
      timeslots.value = []
    }
  }

  function bookSlot (slot: any) {
    // In real app, call API to book appointment
    alert(`Appointment booked for ${slot.date} at ${slot.time}`)
    // Add to my appointments
    const appointment = {
      id: Date.now(),
      date: slot.date,
      time: slot.time,
      status: 'Confirmed',
    }
    myAppointments.value.push(appointment)
    saveMyAppointments()
    // Remove from available timeslots
    const stored = localStorage.getItem('admin-timeslots')
    if (stored) {
      let slots = JSON.parse(stored)
      slots = slots.filter((s: any) => s.id !== slot.id)
      localStorage.setItem('admin-timeslots', JSON.stringify(slots))
      loadTimeslots() // Refresh
    }
  }

  function loadMyAppointments () {
    // In real app, fetch from API
    // For now, load from localStorage
    const stored = localStorage.getItem('user-appointments')
    if (stored) {
      myAppointments.value = JSON.parse(stored)
    }
  }

  function saveMyAppointments () {
    localStorage.setItem('user-appointments', JSON.stringify(myAppointments.value))
  }
</script>
