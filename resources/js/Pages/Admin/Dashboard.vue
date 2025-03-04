<script setup>
import { ref, onMounted, defineProps } from "vue";
import Echo from "laravel-echo";
import Pusher from "pusher-js";

import AuthenticatedLayout from "@/Layouts/AuthenticatedLayout.vue";
import PaginatedOrders from "@/Components/PaginatedOrders.vue";

window.Pusher = Pusher;

const props = defineProps({
  incomingOrders: { type: Object, default: () => ({ data: [] }) },
  kitchenOrders: { type: Object, default: () => ({ data: [] }) },
  deliveryOrders: { type: Object, default: () => ({ data: [] }) },
  user: { type: Object, default: null },
  notifications: { type: Array, default: () => [] },
});

// Create local reactive copies for orders.
const incomingOrders = ref({ ...props.incomingOrders });
const kitchenOrders = ref({ ...props.kitchenOrders });
const deliveryOrders = ref({ ...props.deliveryOrders });

// Set up Laravel Echo for real-time order updates.
onMounted(() => {
  const echo = new Echo({
    broadcaster: "pusher",
    key: import.meta.env.VITE_PUSHER_APP_KEY,
    cluster: import.meta.env.VITE_PUSHER_APP_CLUSTER,
    forceTLS: true,
  });

  // Listen on the public 'orders' channel for the OrderPlaced event.
  echo.channel("orders").listen(".OrderPlaced", (event) => {
    console.log("New order received:", event.order);
    const status = event.order.status;
    if (status === "pending") {
      // Prepend new order into the incoming orders.
      incomingOrders.value.data.unshift(event.order);
    } else if (status === "preparing" || status === "ready") {
      kitchenOrders.value.data.unshift(event.order);
    } else if (status === "out_for_delivery" || status === "delivered") {
      deliveryOrders.value.data.unshift(event.order);
    }
  });
});
</script>

<template>
  <AuthenticatedLayout>
    <template #header>
      <h2 class="text-xl font-semibold leading-tight text-gray-800">Admin Dashboard</h2>
    </template>

    <!-- Dashboard Grid with Paginated Order Lists -->
    <div class="py-12">
      <div class="mx-auto max-w-7xl sm:px-6 lg:px-8">

        <!-- Dashboard Grid with Paginated Order Lists -->
        <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
          <!-- Incoming Orders -->
          <PaginatedOrders
            :orders="incomingOrders"
            title="Incoming Orders"
            propName="incomingOrders"
          />

          <!-- Kitchen Status -->
          <PaginatedOrders
            :orders="kitchenOrders"
            title="Kitchen Status"
            propName="kitchenOrders"
          />

          <!-- Delivery Logistics -->
          <PaginatedOrders
            :orders="deliveryOrders"
            title="Delivery Logistics"
            propName="deliveryOrders"
          />
        </div>
      </div>
    </div>
  </AuthenticatedLayout>
</template>
