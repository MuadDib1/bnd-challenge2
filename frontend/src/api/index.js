import axios from 'axios';

const api = axios.create({
  baseURL: 'http://bnd-challenge2.test/api',
});

export default api;
