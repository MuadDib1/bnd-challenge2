<template>
  <div>
    <h2>All Tasks</h2>
    <div v-if="loading">Loading...</div>
    <ul v-else>
      <li v-for="task in tasks" :key="task.id">
        <strong>{{ task.title }}</strong> - {{ task.status }} - {{ task.due_date }}
      </li>
    </ul>
    <div class="pagination">
      <button :disabled="!links.prev" @click="goToPage(meta.current_page - 1)">Previous</button>
      <span>Page {{ meta.current_page }} of {{ meta.last_page }}</span>
      <button :disabled="!links.next" @click="goToPage(meta.current_page + 1)">Next</button>
    </div>
  </div>
</template>

<script setup>
import { onMounted, ref } from 'vue';
import api from '../api';

const tasks = ref([]);
const meta = ref({});
const links = ref({});
const loading = ref(true);
const perPage = 5;

const fetchTasks = async (page = 1) => {
  loading.value = true;
  try {
    const res = await api.get(`/tasks?page=${page}&per_page=${perPage}`);
    tasks.value = res.data.data;
    meta.value = res.data.meta;
    links.value = res.data.links;
  } catch (err) {
    console.error(err);
  } finally {
    loading.value = false;
  }
};

const goToPage = (page) => {
  fetchTasks(page);
};

onMounted(() => {
  fetchTasks();
});
</script>
