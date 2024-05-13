<script setup>
import AuthenticatedLayout from "@/Layouts/AuthenticatedLayout.vue";
import { Head, useForm } from "@inertiajs/vue3";

defineProps({
    categories: Array,
});

const form = useForm({
    name: '',
});

</script>

<template>
    <Head title="Category" />

    <AuthenticatedLayout>
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                Kategorie
            </h2>
        </template>

        <div class="py-12">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6 text-gray-900">
                        <form @submit.prevent = ""submitForm >
                            <input v-model="form.name" type="text" placeholder="wpisz nazwę kategorii" required>
                            <button type="submit" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">
                                Dodaj kategorię
                            </button>

                        </form>
<div class="grid grid-cols-3 gap-4 mt-8">
    <div v-for="category in categories" :key="category.id" class="p-4 border rounded cursor-pointer hover:bg-gray-200">
        <router-link :to="`/categories/${category.id}`">
            {{ category.name }}
        </router-link>
    </div>
</div>


                    </div>
                </div>
            </div>
        </div>
    </AuthenticatedLayout>
</template>

<script>
import axios from 'axios';

export default {
    data() {
        return {
            form: {
                name: '',
            },
        };
    },
    methods: {
        submitForm() {
            axios.post('/categories', this.form)
                .then(response => {

                    this.form.name = '';
                })
                .catch(error => {

                    console.error(error);
                });
        },
    },
};
</script>

