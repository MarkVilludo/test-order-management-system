<script setup>
import { ref, onMounted, defineProps } from "vue";
import Echo from "laravel-echo";
import Pusher from "pusher-js";

import AuthenticatedLayout from "@/Layouts/AuthenticatedLayout.vue";
import PaginatedOrders from "@/Components/PaginatedOrders.vue";

window.Pusher = Pusher;

const props = defineProps({
  deliveryOrders: { type: Object, default: () => ({ data: [] }) },
  user: { type: Object, default: null },
  notifications: { type: Array, default: () => [] },
});

const deliveryOrders = ref({ ...props.deliveryOrders });

</script>

<template>
  <AuthenticatedLayout>
    <template #header>
      <h2 class="text-xl font-semibold leading-tight text-gray-800">Delivery Dashboard</h2>

    </template>

    <!-- Dashboard Grid with Paginated Order Lists -->
    <div class="py-12">
      <div class="mx-auto max-w-7xl sm:px-6 lg:px-8">
        <!-- Dashboard Grid with Paginated Order Lists -->
        <div class="grid">

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
