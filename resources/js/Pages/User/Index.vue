<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import {router} from '@inertiajs/vue3';

defineProps({
    users: Object
});

</script>

<template>
    <AuthenticatedLayout>
        <template #header>
            <h2
                class="text-xl font-semibold leading-tight text-gray-800"
            >
                Users
            </h2>
        </template>

        <div class="max-w-6xl mx-auto p-6 shadow-md bg-white mt-4">
            <table class="w-full text-center">
                <thead>
                    <tr class="p-2 border text-center">
                        <td class="p-2 border">ID</td>
                        <td class="p-2 border">Name</td>
                        <td class="p-2 border">Email</td>
                    </tr>
                </thead>
                <tbody>
                    <tr v-for="user in users.data">
                        <td class="p-2 border">{{ user.id }}</td>
                        <td class="p-2 border">{{ user.name }}</td>
                        <td class="p-2 border">{{ user.email }}</td>
                    </tr>
                </tbody>
            </table>
            <div class="flex justify-between p-4">
                <button class="bg-blue-500 rounded border p-2 text-white" v-if="users.links.prev" @click="router.get(users.links.prev)">Prev</button>
                <button class="bg-blue-500 rounded border p-2 text-white"  v-if="users.links.next" @click="router.get(users.links.next)">Next</button>
                </div>
            </div>
        <div class="flex justify-center p-4">
            {{ users.meta.current_page}} of {{ users.meta.last_page }}
        </div>

    </AuthenticatedLayout>
</template>
