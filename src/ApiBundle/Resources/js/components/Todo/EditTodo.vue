<template>
    <div>
        <h2>{{title}}</h2>

        <form @submit.prevent>
            <label for="title">Title</label>
            <input v-model="todo.title" id="title"/>

            <label for="status">Done</label>
            <input type="checkbox" v-model="todo.done" id="status"/>

            <label for="categories">Categories</label>
            <select multiple v-model="selectedCategories" id="categories">
                <option :value="category.id" v-for="category in categories">
                    {{category.name}}
                </option>
            </select>

            <button @click="submit">{{title}}</button>
            <button v-if="isEditing()" @click="destroy">Delete</button>
        </form>
    </div>
</template>

<script>
    export default {
        data() {
            return {
                todo: {},
                categories: [],
                selectedCategories: []
            }
        },
        computed: {
            title() {
                return (this.isEditing() ? 'Edit' : 'Create')+' Todo';
            }
        },
        mounted() {
            if (this.$route.params.id) {
                this.loadTodo();
            }
            this.loadCategories();
        },
        methods: {
            isEditing() {
                return !! this.$route.params.id;
            },
            loadTodo() {
                axios.get('/api/todos/'+this.$route.params.id).then(({data}) => {
                    this.todo = data;
                    if (this.todo.categories instanceof Array) {
                        this.selectedCategories = this.todo.categories.map(function(category) {
                            return category.id;
                        });
                    }
                });
            },
            loadCategories() {
                axios.get('/api/categories').then(({data}) => {
                    this.categories = data;
                });
            },
            submit() {
                const payload = qs.stringify({
                    title: this.todo.title,
                    done: this.todo.done,
                    categories: this.selectedCategories
                });

                if (this.isEditing()) {
                    axios.put('/api/todos/'+this.todo.id, payload).then(_ => {
                        this.$router.replace('/todos');
                    });
                } else {
                    axios.post('/api/todos', payload).then(_ => {
                        this.$router.replace('/todos');
                    });
                }
            },
            destroy() {
                axios.delete('/api/todos/'+this.todo.id).then(_ => {
                    this.$router.replace('/todos');
                });
            },
        }
    }
</script>
