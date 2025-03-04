<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';

import { useForm } from '@inertiajs/vue3';

const form = useForm({
    name: '',
    email: '',
    password: '',
});

const submit = () => {
    form.post(route('users.store'), {
        onFinish: () => {
            alert("test ");
        }
    });
};

</script>

<template>
    <AuthenticatedLayout>
        <template #header>
            <h2
                class="text-xl font-semibold leading-tight text-gray-800"
            >
                Create user
            </h2>
        </template>
        <div class="max-w-6xl mx-auto bg-white w-full shadow-sm mt-4 p-4">
            <form @submit.prevent="submit" class="">
                <div class="mt-4">
                    <label class="block">Name</label>
                    <input type="text" v-model="form.name" class="border w-full">
                </div>

                <div class="mt-4">
                    <label class="block">Email</label>
                    <input type="email" v-model="form.email" class="border w-full">
                </div>

                <div class="mt-4">
                    <label class="block">Password</label>
                    <input type="password" v-model="form.password" class="border w-full">
                </div>
                <div class="mt-4">
                    <button type="submit" class="bg-blue-500 text-white p-2 rounded border">Submit </button>
                </div>
            </form>
        </div>
    </AuthenticatedLayout>
</template>
