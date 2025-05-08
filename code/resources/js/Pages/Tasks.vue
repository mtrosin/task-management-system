<template>
  <v-container class="pt-14 pb-10">
    <h1 class="text-h4 mb-6 text-center">Your Tasks</h1>

    <div class="d-flex align-center mb-6">
      <v-btn color="primary" class="me-4" @click="showAddModal = true">
        <v-icon left>mdi-plus</v-icon>
        Add New Task
      </v-btn>

      <v-btn text color="grey" @click="visitTrash">
        <v-icon left>mdi-trash-can-outline</v-icon>
        View Trash
      </v-btn>
    </div>

    <!-- Add and Edit modals -->
    <TaskModal v-model="showAddModal" @success="reload" />
    <EditTaskModal v-model="showEditModal" :task="selectedTask" @updated="reload" />

    <!-- Task Table -->
    <v-table>
      <thead>
        <tr>
          <th class="text-left">Title</th>
          <th class="text-left">Description</th>
          <th class="text-left">Status</th>
          <th class="text-left">Actions</th>
        </tr>
      </thead>
      <tbody>
        <tr v-for="task in tasks" :key="task.id">
          <td>{{ task.title }}</td>
          <td>{{ task.description }}</td>
          <td>
            <v-chip :color="task.completed ? 'green' : 'grey'" dark>
              {{ task.completed ? 'Completed' : 'Pending' }}
            </v-chip>
          </td>
          <td>
            <TaskActions :task="task" @toggle="toggleComplete(task)" @edit="openEdit(task)" @delete="remove(task.id)" />
          </td>
        </tr>
      </tbody>
    </v-table>

    <Snackbar v-model="snackbarDelete" message="Task deleted!" />
    <Snackbar v-model="snackbarComplete" message="Status updated!" />

  </v-container>
</template>

<script setup>
import { ref } from 'vue'
import { Inertia } from '@inertiajs/inertia'
import TaskModal from '@/Components/TaskModal.vue'
import EditTaskModal from '@/Components/EditTaskModal.vue'
import TaskActions from '@/Components/TaskActions.vue'
import Snackbar from '@/Components/Snackbar.vue'

// Props from Laravel
defineProps({ tasks: Array })

// Modals
const showAddModal = ref(false)
const showEditModal = ref(false)
const selectedTask = ref(null)

// Snackbars
const snackbarDelete = ref(false)
const snackbarComplete = ref(false)

// Open edit modal
function openEdit(task) {
  selectedTask.value = task
  showEditModal.value = true
}

// Delete task via Inertia
function remove(id) {
  if (!confirm('Are you sure you want to delete this task?')) return

  Inertia.delete(`/tasks/${id}`, {
    onSuccess: () => {
      snackbarDelete.value = true
      Inertia.reload({ preserveScroll: true })
    }
  })
}

// Toggle completed flag via PATCH
function toggleComplete(task) {
  Inertia.patch(`/tasks/${task.id}`, {
    completed: !task.completed
  }, {
    onSuccess: () => {
      snackbarComplete.value = true
      Inertia.reload({ preserveScroll: true })
    }
  })
}

// After create/edit, reload
function reload() {
  Inertia.reload({ preserveScroll: true })
}

function visitTrash() {
  Inertia.visit('/tasks/trash')
}
</script>
