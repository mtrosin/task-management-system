<template>
    <v-dialog v-model="isOpen" persistent max-width="500px">
        <v-card>
            <v-card-title class="text-h6">New Task</v-card-title>
            <v-card-text>
                <v-form @submit.prevent="submit">
                    <v-text-field v-model="form.title" label="Title" required />
                    <v-textarea v-model="form.description" label="Description" rows="3" />
                </v-form>
            </v-card-text>
            <v-card-actions>
                <v-spacer />
                <v-btn text @click="close">Cancel</v-btn>
                <v-btn color="primary" :loading="form.processing" :disabled="form.processing" @click="submit">
                    Save
                </v-btn>
            </v-card-actions>
        </v-card>
    </v-dialog>

    <!-- Success Snackbar -->
    <v-snackbar v-model="snackbar" :timeout="3000" color="success" top>
        Task created successfully!
        <template #actions>
            <v-btn text @click="snackbar = false">Close</v-btn>
        </template>
    </v-snackbar>
</template>

<script setup>
import { ref, watch } from 'vue'
import { useForm } from '@inertiajs/inertia-vue3'

// Control modal visibility
const props = defineProps({ modelValue: Boolean })
const emit = defineEmits(['update:modelValue', 'success'])
const isOpen = ref(props.modelValue)

// Success snackbar state
const snackbar = ref(false)

// Inertia form
const form = useForm({
    title: '',
    description: ''
})

// Keep modal in sync with parent
watch(() => props.modelValue, val => isOpen.value = val)
watch(isOpen, val => {
    emit('update:modelValue', val)
    if (val) form.reset()  // reset inputs each time you open
})

// Close modal
const close = () => {
    isOpen.value = false
}

// Submit form
const submit = () => {
    form.post('/tasks', {
        onSuccess: () => {
            close()
            snackbar.value = true
            emit('success')
        }
    })
}
</script>