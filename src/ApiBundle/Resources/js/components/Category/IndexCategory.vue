<template>
    <div>
        <h1>Categories</h1>
        <router-link :to="{name: 'addCategory'}">Add Category</router-link>
        <table>
            <thead>
                <tr>
                    <th>id</th>
                    <th>name</th>
                    <th>created</th>
                    <th>modified</th>
                    <th>action</th>
                </tr>
            </thead>
            <tbody>
                <tr v-for="category in categories">
                    <td>{{category.id}}</td>
                    <td>{{category.name}}</td>
                    <td>{{category.created}}</td>
                    <td>{{category.modified}}</td>
                    <td>
                        <router-link :to="{name: 'editCategory', params: {id: category.id}}" style="background: orange">
                            Edit
                        </router-link>
                        <button @click="destroy(category.id)" style="background: red">
                            Delete
                        </button>
                    </td>
                </tr>
            </tbody>
        </table>

        <router-link :to="{name: 'indexTodo'}">Todos</router-link>
    </div>
</template>

<script>
    import * as collectionHelpers from '../../collectionHelpers';

    export default {
        data() {
            return {
                categories: []
            }
        },
        mounted() {
            this.loadCategories();
        },
        methods: {
            loadCategories() {
                axios.get('/api/categories').then(({data}) => {
                    this.categories = data;
                });
            },
            destroy(id) {
                axios.delete('/api/categories/'+id).then(_ => {
                    const category = collectionHelpers.findById(id, this.categories);

                    collectionHelpers.removeObjectFromCollection(category, this.categories);
                });
            },
        }
    }
</script>