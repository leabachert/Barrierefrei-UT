<template>
    <div class="wrap">
        <h1>Adminbereich</h1>

        <nav class="tabs" v-if="auth.user?.role === 'admin'">
            <button
                class="tab"
                :class="{active: tab==='gebaeude'}"
                @click="tab='gebaeude'">
                Gebäude bearbeiten
            </button>

            <button
                class="tab"
                :class="{active: tab==='users'}"
                @click="tab='users'">
                Nutzer verwalten
            </button>
        </nav>

        <section v-if="tab==='gebaeude'">
            <AdminGebaeudeListe/>
        </section>

        <section v-if="tab==='users' && auth.user?.role==='admin'">
            <AdminUsers/>
        </section>

        <div class="logout">
            <button @click="handleLogout">Logout</button>
            <button @click="app">Zurück zur App</button>
        </div>
    </div>
</template>

<script setup>
import { ref } from 'vue'
import { auth } from '@/auth'
import AdminUsers from './AdminUsers.vue'
import AdminGebaeudeListe from "./AdminGebaeudeListe.vue";
import axios from "axios";
import { useRouter } from 'vue-router'

const router = useRouter()
const tab = ref('gebaeude')

async function logout() {
    try { await axios.post('/api/logout') } catch {}
    auth.clear()
}

function handleLogout() {
    logout()
    router.push('/')
}

function app() {
    router.push('/')
}
</script>
