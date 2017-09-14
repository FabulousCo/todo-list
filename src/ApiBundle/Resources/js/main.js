import Vue from 'vue';
import App from './App.vue';
import router from './router';

window.axios = require('axios');
window.qs = require('qs');

new Vue({
  router,
  el: '#app',
  render: h => h(App)
});
