<template>
    <v-snackbar v-model="modelValue" :timeout="timeout" :color="color" top>
        {{ message }}
        <template #actions><v-btn text @click="modelValue = false">Close</v-btn></template>
    </v-snackbar>
</template>

<script setup>
    const props = defineProps({
        modelValue: Boolean,
        message: String,
        color: { type: String, default: 'success' },
        timeout: { type: Number, default: 3000 }
    })
    const emit = defineEmits(['update:modelValue'])
    watch(() => props.modelValue, v => emit('update:modelValue', v))
</script>