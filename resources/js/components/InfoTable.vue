<template>
    <table>
        <tbody>
        <tr v-for="(row, idx) in rows" :key="idx">
        <td>{{ row.label }}</td>
        <td>
          <template v-if="$slots[row.slotName]">
            <slot :name="row.slotName" :value="row.value" />
          </template>

          <template v-else-if="asLines(row.value)">
            <div v-for="(line,i) in asLines(row.value)" :key="i">
              {{ formatValue(line) }}
            </div>
          </template>

          <template v-else>
            {{ formatValue(row.value) }}
          </template>
        </td>
      </tr>
        </tbody>
    </table>
</template>

<script setup>
defineProps({
    rows: {
        type: Array,
        required: true
    }
})

function formatValue(val) {
    if (val === null || val === undefined) return 'Keine Informationen vorhanden'
    if (val === 1) return 'Ja'
    if (val === 0) return 'Nicht vorhanden'
    return val.toString()
}

function asLines(val) {
  if (Array.isArray(val)) return val
  if (typeof val === 'string' && val.includes(',')) {
    return val.split(/\s*,\s*/)
  }
  return null
}
</script>
