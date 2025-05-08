<template>
    <v-container class="pt-14 pb-10">
        <h1 class="text-h4 mb-6 text-center">Trash Bin</h1>
        <v-table>
            <thead>
                <tr>
                    <th>Title</th>
                    <th>Deleted At</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                <tr v-for="task in tasks" :key="task.id">
                    <td>{{ task.title }}</td>
                    <td>{{ new Date(task.deleted_at).toLocaleString() }}</td>
                    <td>
                        <v-btn small color="green" @click="restore(task.id)">
                            Restore
                        </v-btn>
                        <v-btn small color="red" @click="forceDelete(task.id)">
                            Delete Forever
                        </v-btn>
                    </td>
                </tr>
            </tbody>
        </v-table>
    </v-container>
</template>

<script setup>
import { Inertia } from '@inertiajs/inertia'
import { defineProps } from 'vue'

defineProps({ tasks: Array })

function restore(id) {
    Inertia.post(`/tasks/${id}/restore`, {}, {
        onSuccess: () => Inertia.reload()
    })
}

function forceDelete(id) {
    Inertia.delete(`/tasks/${id}/force-delete`, {
        onSuccess: () => Inertia.reload()
    })
}

</script>