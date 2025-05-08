<template>
    <v-dialog v-model="isOpen" persistent max-width="500px">
        <v-card>
            <v-card-title class="text-h6">Edit Task</v-card-title>
            <v-card-text>
                <v-form @submit.prevent="submit">
                    <v-text-field v-model="form.title" label="Title" required />
                    <v-textarea v-model="form.description" label="Description" rows="3" />
                </v-form>
            </v-card-text>
            <v-card-actions>
                <v-spacer />
                <v-btn text @click="close">Cancel</v-btn>
                <v-btn
                color="primary"
                :loading="form.processing"
                :disabled="form.processing"
                @click="submit"
                >
                Save
                </v-btn>
            </v-card-actions>
        </v-card>
    </v-dialog>

    <!-- Success Snackbar -->
    <v-snackbar v-model="snackbar" :timeout="3000" color="success" top>
        Task updated successfully!
        <template #actions>
            <v-btn text @click="snackbar = false">Close</v-btn>
        </template>
    </v-snackbar>
</template>

<script setup>
import { ref, watch } from "vue";
import { useForm } from "@inertiajs/inertia-vue3";

const props = defineProps({
    modelValue: Boolean,
    task: Object,
});
const emit = defineEmits(["update:modelValue", "updated"]);

const isOpen = ref(props.modelValue);
const snackbar = ref(false);

const form = useForm({
    title: "",
    description: "",
});

// Sync modal visibility and initialize form fields
watch(
    () => props.modelValue,
    (val) => {
        isOpen.value = val;
        if (val && props.task) {
            form.title = props.task.title;
            form.description = props.task.description;
        }
    }
);

// Emit visibility changes
watch(isOpen, (val) => emit("update:modelValue", val));

const close = () => {
    isOpen.value = false;
};

const submit = () => {
    form.patch(`/tasks/${props.task.id}`, {
        onSuccess: () => {
            close();
            snackbar.value = true;
            emit("updated");
        },
    });
};
</script>
