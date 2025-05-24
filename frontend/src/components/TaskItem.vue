<template>
  <div class="d-flex justify-content-between align-items-start w-100">
    <div>
      <h5 class="mb-1">{{ task.title }}</h5>
      <p class="mb-1">{{ task.description }}</p>
      <span class="badge bg-secondary me-2">{{ task.status }}</span>
      <small class="text-muted">Due: {{ task.due_date || 'N/A' }}</small>
    </div>
    <!-- 📌 Wrap buttons in a horizontal flex container -->
    <div class="btn-group ms-3" role="group">
      <button class="btn btn-sm btn-outline-primary" @click="$emit('edit', task)">Edit</button>
      <button class="btn btn-sm btn-outline-danger" @click="deleteTask">Delete</button>
    </div>
  </div>
</template>

<script setup>
const { task } = defineProps(['task']);
const emit = defineEmits(['deleted', 'edit']);
import api from '../api';

const deleteTask = async () => {
  if (confirm('Are you sure you want to delete this task?')) {
    await api.delete(`/tasks/${task.id}`);
    emit('deleted');
  }
};
</script>
