<template>
  <v-container class="d-flex justify-center align-center fill-height">
    <v-card class="pa-6" width="400" elevation="4">
      <v-card-title>My Cars</v-card-title>
      <v-list>
        <v-list-item v-for="car in cars" :key="car.id">
          <v-list-item-title>{{ car.make }} {{ car.model }} ({{ car.color }})</v-list-item-title>
          <v-list-item-subtitle>{{ car.license_plate }}</v-list-item-subtitle>
        </v-list-item>
        <v-list-item>
          <v-dialog max-width="500">
            <template v-slot:activator="{ props: activatorProps }">
              <v-btn v-bind="activatorProps" color="primary" text="ADD CAR" variant="flat"></v-btn>
            </template>

            <template v-slot:default="{ isActive }">
              <v-card title="Add a car" class="pa-4">
                <!-- Horizontal layout for text field + button -->
                <div style="display: flex; align-items: center; gap: 32px;">
                  <v-text-field max-length="6" v-model="newLicensePlate" title="License Plate" label="License Plate" outlined density="comfortable" style="flex: 1;" />
                </div>
                <v-card-actions>
                  <v-btn color="primary" text="Add" variant="flat" @click="addCar(isActive,newLicensePlate)"/>
                  <v-btn color="primary" text="cancel" variant="flat" @click="isActive.value = false"/>
                </v-card-actions>
              </v-card>

            </template>
          </v-dialog>
        </v-list-item>
      </v-list>
    </v-card>
  </v-container>
</template>

<script lang="ts" setup>
import { ref } from "vue";
import { useAppStore } from "@/stores/app";
import { useV1Api } from "@/lib/api";
const appStore = useAppStore();
const cars = ref<any[]>([]);
const api = useV1Api();
const newLicensePlate = ref("");
async function getCars() {
  try {
    const response = await api.getCarsV1CarsGet();
    cars.value = response;
  } catch (e) { }
}
async function addCar(isActive: any, licensePlate: string) {
  try {
    await api.registerCarV1CarRegisterPost({
      licensePlate: licensePlate,
    });
    isActive.value = false;
    await getCars();
  } catch (e) { }
}
onMounted(getCars);
</script>
