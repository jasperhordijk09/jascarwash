<template>
  <v-container class="d-flex justify-center align-center fill-height">
    <v-card class="pa-6" width="400" elevation="4">
      <v-card-title class="text-center">
        <h2>Register Account</h2>
      </v-card-title>
      <v-card-text>
        <v-form @submit.prevent="register" ref="form">
          <v-text-field
            v-model="formData.username"
            label="Username"
            :rules="[rules.required, rules.minLength]"
            autocomplete="username"
            outlined
            density="comfortable"
          />

          <v-text-field
            v-model="formData.email"
            label="Email"
            type="email"
            :rules="[rules.email]"
            autocomplete="email"
            outlined
            density="comfortable"
          />

          <v-text-field
            v-model="formData.fullName"
            label="Full Name"
            :rules="[rules.required]"
            autocomplete="name"
            outlined
            density="comfortable"
          />

          <v-text-field
            v-model="formData.password"
            label="Password"
            type="password"
            :rules="[rules.required, rules.minLength]"
            autocomplete="new-password"
            outlined
            density="comfortable"
          />

          <v-text-field
            v-model="confirmPassword"
            label="Confirm Password"
            type="password"
            :rules="[rules.required, passwordMatch]"
            autocomplete="new-password"
            outlined
            density="comfortable"
          />

          <v-alert v-if="error" type="error" dense class="mt-2">
            {{ error }}
          </v-alert>

          <v-card-actions class="d-flex justify-center mt-2">
            <v-btn variant="tonal" :loading="loading" color="primary" type="submit">
              Register
            </v-btn>
          </v-card-actions>
        </v-form>
      </v-card-text>
    </v-card>
  </v-container>
</template>

<script lang="ts" setup>
import { ref, reactive } from 'vue'
import { useAuthApi } from '@/lib/api'
import router from '@/router'

const authApi = useAuthApi()
const form = ref()
const loading = ref(false)
const error = ref<string | null>(null)
const confirmPassword = ref('')

const formData = reactive({
  username: '',
  email: '',
  fullName: '',
  password: ''
})

const rules = {
  required: (value: string) => !!value || 'Required.',
  minLength: (value: string) => value.length >= 3 || 'At least 3 characters.',
  email: (value: string) => {
    const pattern = /^[^\s@]+@[^\s@]+\.[^\s@]+$/
    return pattern.test(value) || 'Invalid email.'
  }
}

const passwordMatch = (value: string) => value === formData.password || 'Passwords do not match.'

const register = async () => {
  const { valid } = await form.value.validate()
  if (!valid) return

  loading.value = true
  error.value = null

  try {
    await authApi.registerUserAuthRegisterPost({
      username: formData.username,
      password: formData.password,
      fullName: formData.fullName || null,
      email: formData.email || null
    })
    // On success, redirect to login or dashboard
    router.push('/login')
  } catch (err: any) {
    error.value = err.response?.data?.detail || 'Registration failed.'
  } finally {
    loading.value = false
  }
}
</script>
