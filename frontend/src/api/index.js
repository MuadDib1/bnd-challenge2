import axios from 'axios';

const token = localStorage.getItem('token'); // assume stored on login

const api = axios.create({
  baseURL: 'http://bnd-challenge2.test/api',
  headers: {
    Authorization: `Bearer ${token}`,
  },
});

export default api;
