<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import {router} from '@inertiajs/vue3';

defineProps({
    orders: Object
});

</script>

<template>
    <AuthenticatedLayout>
        <template #header>
            <h2
                class="text-xl font-semibold leading-tight text-gray-800"
            >
                Orders
            </h2>
        </template>

        <div class="max-w-6xl mx-auto p-6 shadow-md bg-white mt-4">
            <table class="w-full text-center">
                <thead>
                    <tr class="p-2 border text-center">
                        <td class="p-2 border">#</td>
                        <td class="p-2 border">Customer Name</td>
                        <td class="p-2 border">Menu Order</td>
                        <td class="p-2 border">Price</td>
                        <td class="p-2 border">Status</td>
                    </tr>
                </thead>
                <tbody>
                    <tr v-for="order in orders.data">
                        <td class="p-2 border">{{ order.id }}</td>
                        <td class="p-2 border">{{ order.customer.name }}</td>
                        <td class="p-2 border">{{ order.menu_item.name }}</td>
                        <td class="p-2 border">{{ order.total_price }}</td>
                        <td class="p-2 border">{{ order.status }}</td>
                    </tr>
                </tbody>
            </table>
            <div class="flex justify-between p-4">
                <button class="bg-blue-500 rounded border p-2 text-white" v-if="orders.prev_page_url" @click="router.get(orders.prev_page_url)">Prev</button>
                <button class="bg-blue-500 rounded border p-2 text-white"  v-if="orders.next_page_url" @click="router.get(orders.next_page_url)">Next</button>
                </div>
            </div>
        <div class="flex justify-center p-4">
          Page  {{ orders.current_page}} of {{ orders.last_page }}
        </div>

    </AuthenticatedLayout>
</template>
