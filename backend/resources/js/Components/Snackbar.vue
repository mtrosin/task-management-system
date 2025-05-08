<template>
    <v-snackbar v-model="visible" :timeout="timeout" :color="color" top>
        {{ message }}
        <template #actions>
            <v-btn text @click="visible = false">Close</v-btn>
        </template>
    </v-snackbar>
</template>

<script setup>
import { computed } from 'vue'

const props = defineProps({
    modelValue: Boolean,
    message: String,
    color: { type: String, default: 'success' },
    timeout: { type: Number, default: 3000 }
})
const emit = defineEmits(['update:modelValue'])

// Create a two-way computed wrapper around the prop:
const visible = computed({
    get() {
        return props.modelValue
    },
    set(val) {
        emit('update:modelValue', val)
    }
})
</script>