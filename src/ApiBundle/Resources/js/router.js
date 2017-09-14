import Vue from 'vue';
import VueRouter from 'vue-router';

Vue.use(VueRouter);

const routes = [
    { path: '/', redirect: {name: 'indexTodo'} },

    { path: '/categories', name: 'indexCategory', component: require('./components/Category/IndexCategory.vue') },
    { path: '/categories/add', name: 'addCategory', component: require('./components/Category/EditCategory.vue') },
    { path: '/categories/:id', name: 'editCategory', component: require('./components/Category/EditCategory.vue') },

    { path: '/todos', name: 'indexTodo', component: require('./components/Todo/IndexTodo.vue') },
    { path: '/todos/add', name: 'addTodo', component: require('./components/Todo/EditTodo.vue') },
    { path: '/todos/:id', name: 'editTodo', component: require('./components/Todo/EditTodo.vue') },

    { path: '*', redirect: {name: 'indexTodo'} }
];

const router = new VueRouter({
    mode: 'history',
    routes
});

router.beforeEach((to, from, next) => {
    next();
});

export default router
