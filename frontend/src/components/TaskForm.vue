<template>
  <form @submit.prevent="submitTask">
    <h3>Create Task</h3>
    <input v-model="task.title" placeholder="Title" required />
    <textarea v-model="task.description" placeholder="Description"></textarea>
    <select v-model="task.status">
      <option value="pending">Pending</option>
      <option value="in_progress">In Progress</option>
      <option value="completed">Completed</option>
    </select>
    <input v-model="task.due_date" type="date" />
    <button type="submit">Save</button>
  </form>
</template>

<script setup>
import { ref } from 'vue';
import api from '../api';

const task = ref({
  title: '',
  description: '',
  status: 'pending',
  due_date: '',
});

const submitTask = async () => {
  try {
    await api.post(`/users/1/tasks`, task.value); // hardcoded user_id for simplicity
    alert('Task created!');
  } catch (err) {
    console.error(err);
  }
};
</script>
