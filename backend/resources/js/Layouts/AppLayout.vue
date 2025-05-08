<template>
    <v-app>
        <!-- Global loading bar -->
        <v-progress-linear
        v-if="loading.active"
        indeterminate
        color="primary"
        absolute
        top
        height="3"
        />

        <!-- App Bar -->
        <v-app-bar app color="primary" dark>
            <v-app-bar-nav-icon @click="drawer = !drawer" />
            <v-toolbar-title>Task Manager</v-toolbar-title>
            <v-spacer />
            <v-btn icon @click="toggleDark">
                <v-icon>{{ isDark ? 'mdi-white-balance-sunny' : 'mdi-moon-waning-crescent' }}</v-icon>
            </v-btn>
        </v-app-bar>

        <!-- Page Content -->
        <v-main class="pa-4">
            <slot />
        </v-main>
    </v-app>
</template>

<script setup>
import { ref } from 'vue'
import { useTheme } from 'vuetify'
import { useLoadingStore } from '@/stores/loading'

const loading = useLoadingStore()
const drawer = ref(true)
const theme = useTheme()
const isDark = ref(theme.global.name.value === 'dark')

const toggleDark = () => {
    isDark.value = !isDark.value
    theme.global.name.value = isDark.value ? 'dark' : 'light'
}
</script>