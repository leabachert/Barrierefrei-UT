<template>
    <div class="wrap" v-if="gebaeude">
            <div class="header">
                <button class="back-button" @click="router.back()">‹</button>
                <div class="divider"></div>
                <h2 class="title">{{ gebaeude.name }}</h2>
            </div>

            <table>
                <tbody>
                <tr v-if="gebaeude.adressen">
                    <td><strong>Adresse</strong></td>
                    <td>{{ gebaeude.adressen.adresse }}</td>
                </tr>
                <tr v-if="gebaeude.grundrisse?.grundriss">
                    <td><strong>Grundriss</strong></td>
                    <td>
                        <a
                            :href="`/storage/${gebaeude.grundrisse.grundriss}`"
                            target="_blank"
                        >Grundriss ansehen</a>
                    </td>
                </tr>
                <tr v-else>
                    <td><strong>Grundriss</strong></td>
                    <td><em>Kein Grundriss vorhanden</em></td>
                </tr>
                </tbody>
            </table>

            <table class="building-table">
                <tbody>
                <tr>
                    <td><strong>Barrierefrei Zugänglich</strong></td>
                    <td>{{ gebaeude.infos_aussen?.barrierefrei ? 'Ja' : 'Nein' }}</td>
                </tr>
                <tr>
                    <td><strong>Stufenloser Eingang</strong></td>
                    <td>{{ gebaeude.infos_aussen?.eingang }}</td>
                </tr>
                </tbody>
            </table>

            <div v-if="!gebaeude.infos"><em>Für dieses Gebäude liegen aktuell nur Grundinformationen vor.</em></div>

            <h3 v-if="gebaeude.infos">Außerhalb des Gebäudes:</h3>
            <InfoTable v-if="gebaeude.infos" :rows="infosAussenRows">
            </InfoTable>

            <h3 v-if="gebaeude.infos">Innerhalb des Gebäudes:</h3>
            <InfoTable v-if="gebaeude.infos" :rows="infosInnenRows">
            </InfoTable>
    </div>
</template>


<script setup>
import { ref, onMounted, computed } from 'vue'
import { useRoute, useRouter } from 'vue-router'
import axios from 'axios'
import InfoTable from '@/components/InfoTable.vue'

const route = useRoute()
const router = useRouter()
const gebaeude = ref(null)

onMounted(async () => {
    const res = await axios.get(`/api/gebaeude/${route.params.id}`)
    gebaeude.value = res.data
})

const infosAussenRows = computed(() => {
    const aussen = gebaeude.value?.infos_aussen || {}
    return [
        { label: 'Türöffner vorhanden', value: aussen.tueroeffner, slotName: 'tueroeffner' },
        { label: 'Haltestelle', value: aussen.haltestelle },
        {
            label: 'Behindertengerechter Parkplatz',
            value: aussen.parkplatz
                ? aussen.parkplatz_ort?.trim() || 'Vorhanden'
                : 'Nicht vorhanden'
        },
        { label: 'Wegbeschaffenheit', value: aussen.wegbeschaffenheit },
        { label: 'Blindenleitsystem', value: aussen.blindenleitsystem, slotName: 'blindenleitsystem' },
        {
            label: 'Infosäule',
            value: aussen.infosaeule
                ? aussen.infosaeule_ort?.trim() || 'Vorhanden'
                : 'Nicht vorhanden'
        }
    ]
})

const infosInnenRows = computed(() => {
    const innen = gebaeude.value?.infos_innen || {}
    return [
        { label: 'Aufzug', value: innen.aufzug },
        { label: 'Behindertengerechte Toilette', value: innen.toilette },
        {
            label: 'Infosäule',
            value: innen.infosaeule
                ? innen.infosaeule_ort?.trim() || 'Vorhanden'
                : 'Nicht vorhanden'
        },
        { label: 'Blindenleitsystem', value: innen.blindenleitsystem, slotName: 'blindenleitsystem' },
        { label: 'Raumzugang', value: innen.raumzugang },
        {
            label: 'Rollstuhlgerechte Sitzplätze',
            value: innen.sitzplaetze
                ? innen.sitzplaetze_raum?.trim() || 'Vorhanden'
                : 'Nicht vorhanden'
        },
        {
            label: 'Induktionsschleife',
            value: innen.induktionsschleife
                ? innen.induktionsschleife_raum?.trim() || 'Vorhanden'
                : 'Nicht vorhanden'
        },
        {
            label: 'Ruheraum',
            value: innen.ruheraum
                ? innen.ruheraum_raum?.trim() || 'Vorhanden'
                : 'Nicht vorhanden'
        },
        {
            label: 'Sanitätsraum',
            value: innen.sanitaetsraum
                ? innen.sanitaetsraum_raum?.trim() || 'Vorhanden'
                : 'Nicht vorhanden'
        }
    ]
})
</script>
