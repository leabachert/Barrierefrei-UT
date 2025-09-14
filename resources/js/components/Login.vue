<template>
    <div class="wrap">
        <h1>Login</h1>
        <form @submit.prevent="submit">
            <label>Email<br>
                <input v-model="email" type="email" required />
            </label><br>

            <label>Passwort<br>
                <input v-model="password" type="password" required />
            </label><br><br>

            <button :disabled="loading">{{ loading ? '...' : 'Einloggen' }}</button>
            <p v-if="error" class="error">{{ error }}</p>
        </form>
    </div>
</template>

<script setup>
import { ref } from 'vue'
import axios from 'axios'
import { useRouter, useRoute } from 'vue-router'
import { auth } from '../auth'

const router = useRouter()
const route  = useRoute()

const email = ref('')
const password = ref('')
const loading = ref(false)
const error = ref('')

async function submit() {
    error.value = ''
    loading.value = true
    try {
        const { data } = await axios.post('/api/login', {
            email: email.value,
            password: password.value
        })
        auth.set(data.token, data.user)

        const redirect = route.query.redirect || (auth.isEditorOrAdmin() ? '/admin' : '/')
        router.replace(redirect)
    } catch (e) {
        error.value = e.response?.data?.message || 'Login fehlgeschlagen'
    } finally {
        loading.value = false
    }
}
</script>
