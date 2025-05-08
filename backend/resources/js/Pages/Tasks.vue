<template>
  <v-container class="pt-14 pb-10">
    <h1 class="text-h4 mb-6 text-center">Your Tasks</h1>

    <v-btn color="primary" class="mb-6" @click="showAddModal = true">
      <v-icon left>mdi-plus</v-icon>
      Add New Task
    </v-btn>

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
            <!-- Toggle complete -->
            <v-btn icon small :color="task.completed ? 'grey' : 'green'" @click="toggleComplete(task)">
              <v-icon size="18">
                {{ task.completed ? 'mdi-checkbox-blank-outline' : 'mdi-checkbox-marked' }}
              </v-icon>
            </v-btn>

            <!-- Edit -->
            <v-btn icon small color="blue" @click="openEdit(task)">
              <v-icon size="18">mdi-pencil</v-icon>
            </v-btn>

            <!-- Delete -->
            <v-btn icon small color="red" @click="remove(task.id)">
              <v-icon size="18">mdi-delete</v-icon>
            </v-btn>
          </td>
        </tr>
      </tbody>
    </v-table>

    <!-- Delete Success Snackbar -->
    <v-snackbar v-model="snackbarDelete" :timeout="3000" color="success" top>
      Task deleted successfully!
      <template #actions>
        <v-btn text @click="snackbarDelete = false">Close</v-btn>
      </template>
    </v-snackbar>

    <!-- Complete Toggle Snackbar -->
    <v-snackbar v-model="snackbarComplete" :timeout="3000" color="success" top>
      Task status updated!
      <template #actions>
        <v-btn text @click="snackbarComplete = false">Close</v-btn>
      </template>
    </v-snackbar>
  </v-container>
</template>

<script setup>
import { ref } from 'vue'
import { Inertia } from '@inertiajs/inertia'
import TaskModal from '@/Components/TaskModal.vue'
import EditTaskModal from '@/Components/EditTaskModal.vue'

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
</script>
