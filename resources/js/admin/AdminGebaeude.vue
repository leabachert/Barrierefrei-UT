<template>
    <div class="wrap">
        <div class="header">
            <button class="back-button" @click="router.back()">‹</button>
            <div class="divider"></div>
            <h2 class="title">{{ gebaeude.name || 'Gebäude-Details' }}</h2>
        </div>

        <section>
            <h2>Allgemein</h2>
            <label>Name:<br> <input v-model="gebaeude.name" /></label><br>
            <label>Infos anzeigen?<br> <select v-model="gebaeude.infos">
                <option :value="1">Anzeigen</option>
                <option :value="0">Nicht anzeigen</option>
            </select>
            </label><br>
        </section>

        <section>
            <h2>Adresse</h2>
            <label>Adresse:<br> <input v-model="gebaeude.adressen.adresse" /></label><br>
            <label>Latitude:<br> <input type="number" step="0.000001" v-model="gebaeude.adressen.latitude" /></label><br>
            <label>Longitude:<br> <input type="number" step="0.000001" v-model="gebaeude.adressen.longitude" /></label><br>
        </section>

        <section>
            <h2>Außenbereich</h2>
            <label>Barrierefrei:<br> <DropdownSelection v-model="gebaeude.infos_aussen.barrierefrei" /></label><br>
            <label>Eingang:<br> <input v-model="gebaeude.infos_aussen.eingang" /></label><br>
            <label>Türöffner:<br> <DropdownSelection v-model="gebaeude.infos_aussen.tueroeffner" /></label><br>
            <label>Haltestelle:<br> <input v-model="gebaeude.infos_aussen.haltestelle" /></label><br>
            <label>Parkplatz vorhanden:<br> <DropdownSelection v-model="gebaeude.infos_aussen.parkplatz" /></label><br>
            <label>Parkplatz Ort:<br> <input v-model="gebaeude.infos_aussen.parkplatz_ort" /></label><br>
            <label>Wegbeschaffenheit:<br> <input v-model="gebaeude.infos_aussen.wegbeschaffenheit" /></label><br>
            <label>Blindenleitsystem:<br> <DropdownSelection v-model="gebaeude.infos_aussen.blindenleitsystem" /></label><br>
            <label>Infosäule vorhanden:<br> <DropdownSelection v-model="gebaeude.infos_aussen.infosaeule" /></label><br>
            <label>Infosäule Ort:<br> <input v-model="gebaeude.infos_aussen.infosaeule_ort" /></label><br>
        </section>

        <section>
            <h2>Innenbereich</h2>
            <label>Aufzug:<br> <input v-model="gebaeude.infos_innen.aufzug" /></label><br>
            <label>Toilette:<br> <input v-model="gebaeude.infos_innen.toilette" /></label><br>
            <label>Infosäule vorhanden:<br> <DropdownSelection v-model="gebaeude.infos_innen.infosaeule" /></label><br>
            <label>Infosäule Ort:<br> <input v-model="gebaeude.infos_innen.infosaeule_ort" /></label><br>
            <label>Blindenleitsystem:<br> <DropdownSelection v-model="gebaeude.infos_innen.blindenleitsystem" /></label><br>
            <label>Raumzugang:<br> <input v-model="gebaeude.infos_innen.raumzugang" /></label><br>
            <label>Sitzplätze vorhanden:<br> <DropdownSelection v-model="gebaeude.infos_innen.sitzplaetze" /></label><br>
            <label>Sitzplätze Raum:<br> <input v-model="gebaeude.infos_innen.sitzplaetze_raum" /></label><br>
            <label>Induktionsschleife:<br> <DropdownSelection v-model="gebaeude.infos_innen.induktionsschleife" /></label><br>
            <label>Induktionsschleife Raum:<br> <input v-model="gebaeude.infos_innen.induktionsschleife_raum" /></label><br>
            <label>Ruheraum:<br> <DropdownSelection v-model="gebaeude.infos_innen.ruheraum" /></label><br>
            <label>Ruheraum Raum:<br> <input v-model="gebaeude.infos_innen.ruheraum_raum" /></label><br>
            <label>Sanitätsraum:<br> <DropdownSelection v-model="gebaeude.infos_innen.sanitaetsraum" /></label><br>
            <label>Sanitätsraum Raum:<br> <input v-model="gebaeude.infos_innen.sanitaetsraum_raum" /></label><br><br>
        </section>

        <button @click="save">Speichern</button>
    </div>
</template>

<script setup>
import { ref, onMounted } from 'vue'
import {useRoute} from 'vue-router'
import {useRouter} from "vue-router";
import axios from 'axios'
import DropdownSelection from "./DropdownSelection.vue";

const props = defineProps({ id: Number })
const route = useRoute()
const router = useRouter()
const gebaeudeId = props.id || Number(route.params.id)

const gebaeude = ref({
    name: '',
    infos: false,
    adressen: {},
    grundrisse: {},
    infos_aussen: {},
    infos_innen: {}
})

onMounted(async () => {
    try {
        const result = await axios.get(`/api/admin/gebaeude/${gebaeudeId}`)
        gebaeude.value = result.data
        gebaeude.value.adressen ||= {}
        gebaeude.value.grundrisse ||= {}
        gebaeude.value.infos_aussen ||= {}
        gebaeude.value.infos_innen ||= {}
    } catch (err) {
        console.error('Fehler beim Laden der Gebäudedetails', err)
    }
})

async function save() {
    const id = gebaeude.value.id || gebaeudeId
    gebaeude.value.adressen.gebaeude_id = id
    gebaeude.value.grundrisse.gebaeude_id = id
    gebaeude.value.infos_aussen.gebaeude_id = id
    gebaeude.value.infos_innen.gebaeude_id = id

    try {
        await axios.put(`/api/admin/gebaeude/${id}`, gebaeude.value)
        alert('Erfolgreich Gespeichert!')
    } catch (err) {
        alert('Beim Speichern ist ein Fehler aufgetreten')
    }
}
</script>

