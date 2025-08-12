<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import { Head } from '@inertiajs/vue3';
import { usePage } from '@inertiajs/vue3';

const page = usePage();

</script>

<template>

    <Head title="Dashboard" />

    <AuthenticatedLayout>
        <template #header>
            <h2 class="text-xl font-semibold leading-tight text-gray-800">
                Dashboard
            </h2>
        </template>

        <div class="py-12">
            <div class="mx-auto max-w-7xl sm:px-6 lg:px-8">
                <div class="overflow-hidden bg-white shadow-sm sm:rounded-lg">
                    <div class="p-2 text-gray-900">
                        UserID: {{ page.props.auth.user.id }}
                    </div>
                    <div class="p-2 text-gray-900">
                        ยินดีต้อนรับเข้าสู่ระบบ {{ page.props.auth.user.name }}
                    </div>
                </div>
            </div>
        </div>
    </AuthenticatedLayout>
</template>
