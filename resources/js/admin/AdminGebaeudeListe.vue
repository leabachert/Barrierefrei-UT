<template>
    <div>
        <h2>Gebäudeübersicht</h2>

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
                    <RouterLink :to="`/admin/gebaeude/${g.id}`" class="building-link">
                        {{ g.name }}
                    </RouterLink>
                </td>
            </tr>
            </tbody>
        </table>

    </div>
</template>

<script setup>
import { ref, computed, onMounted } from 'vue'
import axios from 'axios'
import {RouterLink} from "vue-router";

const gebaeude = ref([])
const suche = ref('')

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

onMounted(ladeAlleGebaeude)
</script>
