<template>
    <div>
        <h2>Benutzerverwaltung</h2>

        <div class="grid">
            <div class="card">
                <h3>Benutzer</h3>
                <div class="table-scroll">
                    <table>
                        <thead>
                        <tr><th>Name</th><th>Email</th><th>Rolle</th><th>Aktion</th></tr>
                        </thead>
                        <tbody>
                        <tr v-for="u in users" :key="u.id">
                            <td>{{ u.name }}</td>
                            <td>{{ u.email }}</td>
                            <td>
                                <select v-model="u.role">
                                    <option value="editor">Editor</option>
                                    <option value="admin">Admin</option>
                                </select>
                            </td>
                            <td>
                                <button @click="update(u)">Speichern</button><br>
                                <button @click="remove(u)">Entfernen</button>
                            </td>
                        </tr>
                        </tbody>
                    </table>
                </div>
            </div>


            <div class="card">
                <h3>Neuen Benutzer anlegen</h3>
                <form @submit.prevent="create">
                    <label>Name <br><input v-model="createForm.name" required /></label><br>
                    <label>Email <br><input v-model="createForm.email" type="email" required /></label><br>
                    <label>Passwort <br><input v-model="createForm.password" type="password" required /></label><br>
                    <label>Rolle<br>
                        <select v-model="createForm.role" required>
                            <option value="editor">Editor</option>
                            <option value="admin">Admin</option>
                        </select>
                    </label><br><br>
                    <button type="submit">Anlegen</button>
                </form>
                <p v-if="msg">{{ msg }}</p>
            </div>
        </div>
    </div>
</template>

<script setup>
import { ref, onMounted } from 'vue'
import axios from 'axios'

const users = ref([])
const msg = ref('')

const createForm = ref({
    name: '',
    email: '',
    password: '',
    role: 'editor'
})

async function load() {
    const { data } = await axios.get('/api/admin/users')
    users.value = data
}

async function update(u) {
    try {
        await axios.post(`/api/admin/users/${u.id}/role`, { role: u.role })
        alert('Die Rolle wurde gespeichert !')
    } catch (e) {
        alert('Das Ändern der Rolle ist fehlgeschlagen')
    }
}

async function remove(u) {
  const ok = window.confirm(`Soll Benutzer „${u.name}“ wirklich entfernt werden?`)
  if (!ok) return
  try {
    await axios.delete(`/api/admin/users/${u.id}`)
      alert('Der Benutzer wurder erfolgreich gelöscht!')
    await load()
  } catch (e) {
      alert('Das Entfernen ist Fehlgeschlagen!')
  }
}


async function create() {
    try {
        await axios.post('/api/admin/users', createForm.value)
        alert('Benutzer erfolgreich erstellt!')
        createForm.value = { name: '', email: '', password: '', role: 'editor' }
        await load()
    } catch (e) {
        alert('Fehler beim Erstellen des Benutzers')
    }
}

onMounted(load)
</script>
