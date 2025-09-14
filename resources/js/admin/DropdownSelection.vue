<template>
    <select :value="modelValue" @change="update($event.target.value)">
        <option :value="null">Keine Infos</option>
        <option :value="1">Ja/Vorhanden</option>
        <option :value="0">Nein/Nicht vorhanden</option>
    </select>
</template>

<script>
export default {
    props: {
        modelValue: [Number, null]
    },
    emits: ['update:modelValue'],
    methods: {
        update(value) {
            const parsed = value === '' ? null : Number(value)
            this.$emit('update:modelValue', parsed)
        }
    }
}
</script>
