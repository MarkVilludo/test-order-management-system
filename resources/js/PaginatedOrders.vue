<template>
    <div class="bg-white shadow sm:rounded-lg p-6">
      <h3 class="text-xl font-semibold mb-4">{{ title }}</h3>
      <ul>
        <li
          v-for="order in orders.data"
          :key="order.id"
          class="mb-2 border-b pb-2"
        >
          <p class="font-bold">Order #{{ order.id }}</p>
          <p class="text-sm text-gray-600">
            {{ order?.menu_item.name  || 'TESt'}} - test
            <span class="font-semibold">{{ order.status }}</span>
          </p>
        </li>
      </ul>
      <div class="flex justify-between p-4">
        <button
          class="bg-blue-500 rounded border p-2 text-white"
          v-if="orders.prev_page_url"
          @click="goTo(orders.prev_page_url)"
        >
          Prev
        </button>
        <button
          class="bg-blue-500 rounded border p-2 text-white"
          v-if="orders.next_page_url"
          @click="goTo(orders.next_page_url)"
        >
          Next
        </button>
      </div>
    </div>
  </template>

  <script setup>
  import { defineProps } from 'vue';
  import { router } from '@inertiajs/vue3';

  const props = defineProps({
    orders: { type: Object, default: () => ({ data: [] }) },
    title: { type: String, default: '' },
  });

  function goTo(url) {
    router.get(url);
  }
  </script>
