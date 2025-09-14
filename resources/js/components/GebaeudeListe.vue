<template>
  <div class="wrap">
      <h1>Alle Gebäude</h1>
      <div v-if="gebaeudeInDerNahe" class="popup">
      <p>
        📍 Sie befinden sich in der Nähe von: <strong>{{ gebaeudeInDerNahe.name }}</strong>
      </p>
      <div class="popup-buttons">
        <button @click="geheZuGebaeude(gebaeudeInDerNahe.id)">Anzeigen</button>
        <button @click="gebaeudeInDerNahe = null">Nein danke</button>
      </div>
    </div>

    <div>
      <input
        v-model="suche"
        type="text"
        placeholder="Gebäude suchen..."
      />
    </div>

    <table>
      <tbody>
        <tr v-for="g in gefiltert" :key="g.id">
          <td colspan="2">
            <RouterLink :to="`/gebaeude/${g.id}`" class="building-link">
              {{ g.name }}
            </RouterLink>
          </td>
        </tr>
      </tbody>
    </table>
    <div>
        <button @click="admin">
            Adminbereich
        </button>
    </div>
  </div>
</template>

<script setup>
import { ref, computed, onMounted, onUnmounted } from 'vue'
import { useRouter, RouterLink } from 'vue-router'
import axios from 'axios'

const router = useRouter()
const gebaeude = ref([])
const suche = ref('')
const gebaeudeInDerNahe = ref(null)
const interval = 60000
let intervalId;

function geheZuGebaeude(id) {
  router.push(`/gebaeude/${id}`)
}

const gefiltert = computed(() =>
  gebaeude.value.filter(g =>
    g.name?.toLowerCase().includes(suche.value.toLowerCase())
  )
)

async function ladeAlleGebaeude() {
  try {
    const res = await axios.get('/api/gebaeude')
    gebaeude.value = res.data.sort((a, b) =>
      a.name.localeCompare(b.name, 'de', { sensitivity: 'base' })
    )
  } catch (err) {
    console.error('Fehler beim Laden der Gebäude:', err)
  }
}

async function ladeGebaeudeInDerNahe(lat, lng) {
  try {
    const res = await axios.get('/api/gebaeude-in-der-naehe', {
      params: { latitude: lat, longitude: lng }
    })
    gebaeudeInDerNahe.value = res.status === 204 ? null : res.data
  } catch (err) {
    console.error('Fehler bei Standortabfrage:', err)
  }
}

function starteGeolocation() {
  if (!('geolocation' in navigator)) return

  navigator.geolocation.getCurrentPosition(
    pos => ladeGebaeudeInDerNahe(pos.coords.latitude, pos.coords.longitude),
    err => console.warn('Initialer Standort nicht verfügbar:', err),
    { enableHighAccuracy: true, timeout: 5000, maximumAge: 60000 }
  )

  intervalId = setInterval(() => {
    navigator.geolocation.getCurrentPosition(
      pos => ladeGebaeudeInDerNahe(pos.coords.latitude, pos.coords.longitude),
      err => console.warn('Standort nicht verfügbar:', err),
      { enableHighAccuracy: true, timeout: 5000, maximumAge: 60000 }
    );
  }, interval);
}

onMounted(() => {
  ladeAlleGebaeude()
  starteGeolocation()
})

onUnmounted(() => {
  if (intervalId) clearInterval(intervalId)
})

function admin() {
    router.push('/admin')
}
</script>
