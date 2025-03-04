<script setup>
import { ref, computed, onMounted } from 'vue';
import { defineProps } from '@inertiajs/inertia-vue3';
import Echo from 'laravel-echo';
import Pusher from 'pusher-js';

window.Pusher = Pusher;

const props = defineProps({
  auth: {
    type: Object,
    default: null,
  },
  notifications: {
    type: Array,
    default: () => [],
  },
});

// Dropdown visibility flag.
const dropdownVisible = ref(false);
function toggleDropdown() {
  dropdownVisible.value = !dropdownVisible.value;
}

// Get shared props from Inertia (if any). For public channel events, you may not even need user data.

// If you need user info for private channels, compute it; here we are using a public channel, so it's optional.
const auth = computed(() => props.auth);
const userId = computed(() => auth.value?.user?.id);

// Create a reactive local notifications array, initialized with any preloaded notifications.
const localNotifications = ref([...props.notifications]);

onMounted(() => {
  console.log("Initializing Echo on channel 'orders'");
  const echo = new Echo({
    broadcaster: 'pusher',
    key: import.meta.env.VITE_PUSHER_APP_KEY,
    cluster: import.meta.env.VITE_PUSHER_APP_CLUSTER,
    forceTLS: false,
  });

  echo.connector.pusher.connection.bind('state_change', (states) => {
  console.log('Pusher connection state:', states);
});

  console.log(echo);
  // Listen on the public channel 'orders' for the OrderPlaced event.
  echo.channel('orders')
    .listen('.OrderPlaced', (event) => {
      console.log('New order received:', event);
      // Update the reactive notifications array.
      localNotifications.value.unshift(event.order);
    });
});
</script>

<template>
  <div class="relative inline-block">
    <!-- Notification Button (Bell Icon) -->
    <button @click="dropdownVisible = !dropdownVisible" class="relative focus:outline-none">
      <svg class="w-8 h-8 text-gray-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
          d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6 6 0 00-5-5.917V4a1 1 0 10-2 0v1.083A6 6 0 006 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1" />
      </svg>
      <!-- Badge showing number of notifications -->
      <span v-if="localNotifications.length > 0" class="absolute top-0 right-0 inline-flex items-center justify-center px-2 py-1 text-xs font-bold leading-none text-white bg-red-600 rounded-full">
        {{ localNotifications.length }}
      </span>
    </button>
    <!-- Dropdown Panel -->
    <div v-if="dropdownVisible" class="absolute right-0 mt-2 w-80 bg-white border border-gray-200 rounded-lg shadow-lg z-20">
      <div class="p-4 border-b">
        <span class="text-lg font-bold">Notifications</span>
      </div>
      <ul class="max-h-60 overflow-y-auto">
        <li v-for="(notification, index) in localNotifications" :key="notification.id || index" class="p-4 border-b last:border-b-0">
          <div class="flex justify-between items-center">
            <span class="font-semibold">
              Order #{{ notification.data?.order_id || notification.id }}
            </span>
            <span class="text-xs text-gray-500">
              {{ notification.data?.created_at ? new Date(notification.data.created_at).toLocaleString() : '' }}
            </span>
          </div>
          <p class="text-gray-700 mt-2">
            {{ notification.data?.message || "New order placed:  Order # "+ notification.id }}
          </p>
        </li>
        <li v-if="localNotifications.length === 0" class="p-4 text-gray-600">
          No notifications yet.
        </li>
      </ul>
    </div>
  </div>
</template>
