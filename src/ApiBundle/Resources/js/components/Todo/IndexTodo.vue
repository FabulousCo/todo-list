<template>
    <div>
        <h1>Todos</h1>
        <router-link :to="{name: 'addTodo'}">Add Todo</router-link>
        <table>
            <thead>
                <tr>
                    <th>id</th>
                    <th>name</th>
                    <th>categories</th>
                    <th>created</th>
                    <th>modified</th>
                    <th>action</th>
                </tr>
            </thead>
            <tbody>
                <tr v-for="todo in todos">
                    <td>{{todo.id}}</td>
                    <td>{{todo.title}}</td>
                    <td>
                        <span v-for="category in todo.categories">
                            {{category.name}}
                        </span>
                    </td>
                    <td>{{todo.created}}</td>
                    <td>{{todo.modified}}</td>
                    <td>
                        <router-link :to="{name: 'editTodo', params: {id: todo.id}}" style="background: orange">
                            Edit
                        </router-link>
                        <button @click="destroy(todo.id)" style="background: red">
                            Delete
                        </button>
                    </td>
                </tr>
            </tbody>
        </table>

        <router-link :to="{name: 'indexCategory'}">Categories</router-link>
    </div>
</template>

<script>
    import * as collectionHelpers from '../../collectionHelpers';

    export default {
        data() {
            return {
                todos: []
            }
        },
        mounted() {
            this.loadCategories();
        },
        methods: {
            loadCategories() {
                axios.get('/api/todos').then(({data}) => {
                    this.todos = data;
                });
            },
            destroy(id) {
                axios.delete('/api/todos/'+id).then(_ => {
                    const todo = collectionHelpers.findById(id, this.todos);

                    collectionHelpers.removeObjectFromCollection(todo, this.todos);
                });
            }
        }
    }
</script>