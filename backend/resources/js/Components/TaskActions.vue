<template>
    <v-btn icon small :color="task.completed ? 'grey' : 'green'" @click="$emit('toggle')">
        <v-icon size="18">{{ task.completed ? 'mdi-checkbox-blank-outline' : 'mdi-checkbox-marked' }}</v-icon>
    </v-btn>
    <v-btn icon small color="blue" @click="$emit('edit')">
        <v-icon size="18">mdi-pencil</v-icon>
    </v-btn>
    <v-btn icon small color="red" @click="$emit('delete')">
        <v-icon size="18">mdi-delete</v-icon>
    </v-btn>
</template>

<script setup>
    defineProps({ task: Object })
</script>