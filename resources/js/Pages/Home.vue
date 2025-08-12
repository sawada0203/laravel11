<script setup>
import { Head } from '@inertiajs/vue3';
import Navmenu from '@/Layouts/Navmenu.vue';

defineOptions({ layout: Navmenu});


</script>

<template>
    <Head title="หน้าแรก" />
        
<div class="h-10 bg-red-500 sm:bg-yellow-500 md:bg-green-500 lg:bg-blue-500 xl:bg-purple-500">
    <section>
        <h1 class="text-2xl font-bold mb-4">ยินดีต้อนรับสู่หน้าแรก</h1>
        <p class="text-gray-700">นี่คือเนื้อหาของหน้าแรกของคุณ</p>
    </section>
</div>

</template>
