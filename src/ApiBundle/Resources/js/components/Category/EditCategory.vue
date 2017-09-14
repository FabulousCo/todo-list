<template>
    <div>
        <h2>{{title}}</h2>

        <form @submit.prevent>
            <label for="name">Name</label>
            <input v-model="category.name" id="name"/>

            <button @click="submit">{{title}}</button>
            <button v-if="isEditing()" @click="destroy">Delete</button>
        </form>
    </div>
</template>

<script>
    export default {
        data() {
            return {
                category: {}
            }
        },
        computed: {
            title() {
                return (this.isEditing() ? 'Edit' : 'Create')+' Category';
            },
        },
        mounted() {
            if (this.$route.params.id) {
                this.loadCategory();
            }
        },
        methods: {
            isEditing() {
                return !! this.$route.params.id;
            },
            loadCategory() {
                axios.get('/api/categories/'+this.$route.params.id).then(({data}) => {
                    this.category = data;
                });
            },
            submit() {
                const payload = qs.stringify({name: this.category.name});

                if (this.isEditing()) {
                    axios.put('/api/categories/'+this.category.id, payload).then(_ => {
                        this.$router.replace('/categories');
                    });
                } else {
                    axios.post('/api/categories', payload).then(_ => {
                        this.$router.replace('/categories');
                    });
                }
            },
            destroy() {
                axios.delete('/api/categories/'+this.category.id).then(_ => {
                    this.$router.replace('/categories');
                });
            },
        }
    }
</script>