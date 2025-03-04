<template>
    <div class="bg-white shadow sm:rounded-lg p-6">
      <h3 class="text-xl font-semibold mb-4">{{ title }}</h3>
      <ul>
        <li
          v-for="order in localOrders.data"
          :key="order.id"
          class="mb-2 border-b pb-2"
        >
          <p class="font-bold">Order #{{ order.id }}</p>
          <p class="text-sm text-gray-600">
            {{ order?.menu_item?.name || "test" }}
            <span class="font-semibold">{{ order.status }}</span>
          </p>
        </li>
      </ul>
      <div class="flex justify-between p-4">
        <button
          v-if="localOrders.prev_page_url"
          class="bg-blue-500 rounded border p-2 text-white"
          @click="paginate(localOrders.prev_page_url)"
        >
          Prev
        </button>
        <button
          v-if="localOrders.next_page_url"
          class="bg-blue-500 rounded border p-2 text-white"
          @click="paginate(localOrders.next_page_url)"
        >
          Next
        </button>
      </div>

    </div>
  </template>

  <script setup>
  import { ref } from 'vue';
  import { defineProps } from 'vue';
  import { router } from '@inertiajs/vue3';

  // Define props passed from the parent Inertia page:
  // - orders: The paginated orders object (with data, prev_page_url, etc.)
  // - title: A header title for this order list
  // - propName: The name of the property in the parent's props that this list corresponds to.
  const props = defineProps({
    orders: { type: Object, default: () => ({ data: [] }) },
    title: { type: String, default: '' },
    propName: { type: String, default: 'orders' },
  });

  // Create a local reactive copy of the orders prop.
  const localOrders = ref({ ...props.orders });

  // The paginate function uses Inertia's router.visit with the "only" option
  // to update only the specified prop in the parent without a full page reload.
  function paginate(url) {
    router.visit(url, {
      preserveState: true,
      // Tell Inertia to only update the specified prop from the server.
      only: [props.propName],
      replace: true,
      onSuccess: (page) => {
        // Update the local orders with the new paginated data.
        localOrders.value = page.props[props.propName];
      },
    });
  }
  </script>
