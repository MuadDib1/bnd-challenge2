<template>
  <div class="container py-4">
    <h2 class="mb-4">Task Manager</h2>

    <!-- Edit Task Form -->
    <div v-if="editingTask" class="card mb-4">
      <div class="card-header">Edit Task</div>
      <div class="card-body">
        <form @submit.prevent="updateTask">
          <div class="mb-3">
            <label class="form-label">Title</label>
            <input v-model="editingTask.title" class="form-control" required />
          </div>
          <div class="mb-3">
            <label class="form-label">Description</label>
            <textarea v-model="editingTask.description" class="form-control"></textarea>
          </div>
          <div class="mb-3">
            <label class="form-label">Status</label>
            <select v-model="editingTask.status" class="form-select">
              <option value="pending">Pending</option>
              <option value="in_progress">In Progress</option>
              <option value="completed">Completed</option>
            </select>
          </div>
          <div class="mb-3">
            <label class="form-label">Due Date</label>
            <input v-model="editingTask.due_date" type="date" class="form-control" />
          </div>
          <button type="submit" class="btn btn-primary me-2">Update</button>
          <button @click="cancelEdit" type="button" class="btn btn-secondary">Cancel</button>
        </form>
      </div>
    </div>

    <!-- Task List -->
    <ul class="list-group mb-4">
      <TaskItem
        v-for="task in tasks"
        :key="task.id"
        :task="task"
        @deleted="fetchTasks"
        @edit="editTask"
        class="list-group-item"
      />
    </ul>

    <!-- Pagination -->
    <div class="d-flex justify-content-between align-items-center">
      <button
        class="btn btn-outline-primary"
        :disabled="!links.prev"
        @click="changePage(meta.current_page - 1)"
      >
        &laquo; Previous
      </button>
      <span>Page {{ meta.current_page }} of {{ meta.last_page }}</span>
      <button
        class="btn btn-outline-primary"
        :disabled="!links.next"
        @click="changePage(meta.current_page + 1)"
      >
        Next &raquo;
      </button>
    </div>
  </div>
</template>

<script setup>
import { ref, onMounted } from 'vue';
import api from '../api';
import TaskItem from './TaskItem.vue';

const tasks = ref([]);
const meta = ref({});
const links = ref({});
const editingTask = ref(null);
const userId = 1;
const perPage = 5;

const fetchTasks = async (page = 1) => {
  try {
    const response = await api.get(`/users/${userId}/tasks?page=${page}&per_page=${perPage}`);
    tasks.value = response.data.data;
    meta.value = response.data.meta;
    links.value = response.data.links;
  } catch (error) {
    console.error('Fetch error:', error);
  }
};

const changePage = (page) => {
  if (page >= 1 && page <= meta.value.last_page) {
    fetchTasks(page);
  }
};

const editTask = (task) => {
  editingTask.value = { ...task };
};

const cancelEdit = () => {
  editingTask.value = null;
};

const updateTask = async () => {
  try {
    await api.put(`/tasks/${editingTask.value.id}`, editingTask.value);
    cancelEdit();
    fetchTasks(meta.value.current_page);
  } catch (err) {
    console.error('Update failed:', err);
  }
};

onMounted(() => fetchTasks());
</script>
