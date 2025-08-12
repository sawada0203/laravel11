<script setup>
import { Head } from '@inertiajs/vue3';
import Pagination from '@/Components/Pagination.vue';
import Navmenu from '@/Layouts/Navmenu.vue';

defineOptions({ layout: Navmenu });

defineProps({
    users: Object,
});


</script>

<template>

    <Head title="ข้อมูลผู้ใช้" />
    <section>




        <div class="relative overflow-x-auto shadow-md sm:rounded-lg">
            <table class="w-full text-sm text-left rtl:text-right text-gray-500 dark:text-gray-400">
                <thead class="text-xs text-gray-700 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-400">
                    <tr>
                        <th scope="col" class="px-6 py-3">
                            #
                        </th>
                        <th scope="col" class="px-6 py-3">
                            Name
                        </th>
                        <th scope="col" class="px-6 py-3">
                            E-Mail
                        </th>
                        <th scope="col" class="px-6 py-3">
                            วันที่การสร้าง
                        </th>
                        <th scope="col" class="px-6 py-3">
                            <span class="sr-only">Edit</span>
                        </th>
                    </tr>
                </thead>
                <tbody>
                    <tr v-for="(item, index) in users.data" :key="item.id"
                        class="bg-white border-b dark:bg-gray-800 dark:border-gray-700 border-gray-200 hover:bg-gray-50 dark:hover:bg-gray-600">
                        <th scope="row" class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap dark:text-white">
                            {{ (users.current_page - 1) * users.per_page + index + 1 }}
                        </th>
                        <td class="px-6 py-4">
                            {{ item.name }}
                        </td>
                        <td class="px-6 py-4">
                            {{ item.email }}
                        </td>
                        <td class="px-6 py-4">
                            {{
                            new Date(item.created_at).toLocaleDateString('th-TH', {
                            day: '2-digit',
                            month: '2-digit',
                            year: 'numeric'
                            }).replace(/(\d{2})\/(\d{2})\/(\d{4})/, '$1/$2/$3')
                            }}
                        </td>
                        <td class="px-6 py-4 text-right">
                            <a href="#" class="font-medium text-blue-600 dark:text-blue-500 hover:underline">Edit</a> |
                            <a href="#" class="font-medium text-red-600 dark:text-red-500 hover:underline">Delete</a>
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>

        <div class="mt-4">
            <Pagination :links="users.links" />
        </div>

    </section>



</template>
