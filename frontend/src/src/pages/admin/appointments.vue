<template>
  <v-container>
    <h1>Manage Appointments</h1>

      <v-row>
        <v-col cols="12" md="6">
          <v-card class="pa-4" elevation="4">
            <v-card-title>
              <v-icon>mdi-calendar-plus</v-icon>
              Add Timeslot
            </v-card-title>
            <v-card-text>
              <v-text-field
                v-model="newSlot.date"
                label="Date"
                :min="today"
                type="date"
              />
              <v-text-field
                v-model="newSlot.time"
                label="Time"
                type="time"
              />
              <v-btn
                color="primary"
                :disabled="!newSlot.date || !newSlot.time"
                @click="addTimeslot"
              >
                Add Timeslot
              </v-btn>
            </v-card-text>
          </v-card>
        </v-col>

        <v-col cols="12" md="6">
          <v-card class="pa-4" elevation="4">
            <v-card-title>
              <v-icon>mdi-calendar-month</v-icon>
              Available Timeslots
            </v-card-title>
            <v-card-text>
              <div v-if="availableSlots.length === 0">
                <p>No timeslots added yet.</p>
              </div>
              <div v-else>
                <v-list>
                  <v-list-item
                    v-for="slot in availableSlots"
                    :key="slot.id"
                  >
                    <v-list-item-title>{{ slot.date }} at {{ slot.time }}</v-list-item-title>
                    <v-list-item-action>
                      <v-btn
                        color="error"
                        icon="mdi-delete"
                        @click="removeTimeslot(slot.id)"
                      />
                    </v-list-item-action>
                  </v-list-item>
                </v-list>
              </div>
            </v-card-text>
          </v-card>
        </v-col>
      </v-row>

      <v-row class="mt-4">
        <v-col cols="12">
          <v-card class="pa-4" elevation="4">
            <v-card-title>
              <v-icon>mdi-calendar-check</v-icon>
              Booked Appointments
            </v-card-title>
            <v-card-text>
              <div v-if="bookedAppointments.length === 0">
                <p>No appointments booked yet.</p>
              </div>
              <div v-else>
                <v-list>
                  <v-list-item
                    v-for="appointment in bookedAppointments"
                    :key="appointment.id"
                  >
                    <v-list-item-title>{{ appointment.date }} at {{ appointment.time }}</v-list-item-title>
                    <v-list-item-subtitle>Customer: {{ appointment.customer }}</v-list-item-subtitle>
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
  import { computed, onMounted, ref } from 'vue'

  const newSlot = ref({
    date: '',
    time: '',
  })

  const availableSlots = ref<any[]>([])
  const bookedAppointments = ref<any[]>([])

  const today = computed(() => {
    const now = new Date()
    return now.toISOString().split('T')[0]
  })

  onMounted(() => {
    loadSlots()
  })

  function addTimeslot () {
    if (newSlot.value.date && newSlot.value.time) {
      const slot = {
        id: Date.now(),
        date: newSlot.value.date,
        time: newSlot.value.time,
      }
      availableSlots.value.push(slot)
      saveSlots()
      newSlot.value = { date: '', time: '' }
    }
  }

  function removeTimeslot (id: number) {
    availableSlots.value = availableSlots.value.filter(slot => slot.id !== id)
    saveSlots()
  }

  function loadSlots () {
    const stored = localStorage.getItem('admin-timeslots')
    if (stored) {
      availableSlots.value = JSON.parse(stored)
    }
  }

  function saveSlots () {
    localStorage.setItem('admin-timeslots', JSON.stringify(availableSlots.value))
  }

  // In real app, load booked appointments from API
</script>
