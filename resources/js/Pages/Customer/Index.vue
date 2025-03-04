<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import {router} from '@inertiajs/vue3';

defineProps({
    customers: Object
});

</script>

<template>
    <AuthenticatedLayout>
        <template #header>
            <h2
                class="text-xl font-semibold leading-tight text-gray-800"
            >
                Customers
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
                    <tr v-for="customer in customers.data">
                        <td class="p-2 border">{{ customer.id }}</td>
                        <td class="p-2 border">{{ customer.name }}</td>
                        <td class="p-2 border">{{ customer.email }}</td>
                    </tr>
                </tbody>
            </table>
            <div class="flex justify-between p-4">
                <button class="bg-blue-500 rounded border p-2 text-white" v-if="customers.links.prev" @click="router.get(customers.links.prev)">Prev</button>
                <button class="bg-blue-500 rounded border p-2 text-white"  v-if="customers.links.next" @click="router.get(customers.links.next)">Next</button>
                </div>
            </div>
        <div class="flex justify-center p-4">
            {{ customers.meta.current_page}} of {{ customers.meta.last_page }}
        </div>

    </AuthenticatedLayout>
</template>
