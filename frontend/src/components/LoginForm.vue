<template>
  <div class="container py-5" style="max-width: 400px;">
    <h2 class="mb-4">Login</h2>
    <form @submit.prevent="login">
      <div class="mb-3">
        <label class="form-label">Email</label>
        <input v-model="email" type="email" class="form-control" required />
      </div>
      <div class="mb-3">
        <label class="form-label">Password</label>
        <input v-model="password" type="password" class="form-control" required />
      </div>
      <div class="mb-3 text-danger" v-if="error">{{ error }}</div>
      <button type="submit" class="btn btn-primary w-100">Login</button>
    </form>
  </div>
</template>

<script setup>
import { ref } from 'vue'
import { useRouter } from 'vue-router'
import api from '../api'

const email = ref('')
const password = ref('')
const error = ref(null)
const router = useRouter()

const login = async () => {
  try {
    error.value = null
    const response = await api.post('/login', { email: email.value, password: password.value })
    localStorage.setItem('token', response.data.token)
    router.push('/')
  } catch (err) {
    error.value = 'Invalid email or password.'
    console.error(err)
  }
}
</script>
