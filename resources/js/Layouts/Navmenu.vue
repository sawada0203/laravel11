<script setup>
import { ref } from 'vue';
import { Link, usePage } from '@inertiajs/vue3';

const page = usePage();
const isSidebarOpen = ref(true);

const isActive = (routeName) => route().current(routeName);
const toggleSidebar = () => {
  isSidebarOpen.value = !isSidebarOpen.value;
};
</script>

<template>
  <div class="grid min-h-screen bg-gray-50 dark:bg-gray-900"
       :class="isSidebarOpen ? 'grid-cols-[16rem,1fr]' : 'grid-cols-[5rem,1fr]'">
    <!-- Sidebar -->
    <aside class="custom-sidebar-gradient dark:bg-green-900 border-r border-gray-200 dark:border-gray-700
      transition-all duration-300 ease-in-out shadow-lg h-screen z-30 sticky top-0">
      <!-- Logo & Toggle -->
      <div class="flex items-center justify-between px-4 py-3 border-b border-gray-200 dark:border-gray-700">
        <Link href="/" class="flex items-center space-x-3">
          <img
            src="https://upload.wikimedia.org/wikipedia/commons/f/fe/Seal_of_the_Ministry_of_Public_Health_of_Thailand.svg"
            class="h-8" alt="Logo" />
          <span v-if="isSidebarOpen" class="text-xl font-semibold text-gray-800 dark:text-white">ThaTum HIS DataView</span>
        </Link>
        <button @click="toggleSidebar"
          class="p-2 rounded-lg text-gray-500 hover:bg-gray-100 dark:text-gray-400 dark:hover:bg-gray-700">
          <svg v-if="isSidebarOpen" class="w-6 h-6" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
            <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
              d="M6 18L18 6M6 6l12 12" />
          </svg>
          <svg v-else class="w-6 h-6" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 17 14">
            <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
              d="M1 1h15M1 7h15M1 13h15" />
          </svg>
        </button>
      </div>
      <!-- Menu -->
      <nav class="px-3 py-4">
        <ul class="space-y-2">
          <li v-for="item in [
            { name: 'Home', route: 'home', icon: 'home' },
            { name: 'Dashboard', route: 'datadash', icon: 'chart-pie' },
            { name: 'Table', route: 'table', icon: 'table' },
            { name: 'Register', route: 'register', icon: 'user-plus' },
            { name: 'Login', route: 'login', icon: 'log-in' }
          ]" :key="item.name">
            <Link :href="route(item.route)"
              :class="[isActive(item.route) ? 'bg-blue-700 text-white' : 'text-gray-900 dark:text-white hover:bg-gray-100 dark:hover:bg-gray-700', 'flex items-center p-2 rounded-lg transition-all']">
              <svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"
                xmlns="http://www.w3.org/2000/svg">
                <path v-if="item.icon === 'home'" stroke-linecap="round" stroke-linejoin="round"
                  d="M3 9.75L12 4l9 5.75M4.5 10.5V19a2.25 2.25 0 002.25 2.25H9.75v-6h4.5v6h3A2.25 2.25 0 0021 19v-8.5" />
                <path v-else-if="item.icon === 'chart-pie'" stroke-linecap="round" stroke-linejoin="round"
                  d="M11.25 3v9.75H21M4.5 12A7.5 7.5 0 0012 19.5v0A7.5 7.5 0 0112 4.5v0a7.5 7.5 0 00-7.5 7.5z" />
                <path v-else-if="item.icon === 'table'" stroke-linecap="round" stroke-linejoin="round"
                  d="M3 7.5h18m-18 9h18M3 12h18" />
                <path v-else-if="item.icon === 'user-plus'" stroke-linecap="round" stroke-linejoin="round"
                  d="M18 9v6M15 12h6M6 21v-1.5a4.5 4.5 0 014.5-4.5h3a4.5 4.5 0 014.5 4.5V21M12 12a4.5 4.5 0 100-9 4.5 4.5 0 000 9z" />
                <path v-else stroke-linecap="round" stroke-linejoin="round"
                  d="M15.75 9V6.75a3.75 3.75 0 00-7.5 0V9m0 0H6.75A2.25 2.25 0 004.5 11.25v6A2.25 2.25 0 006.75 19.5h10.5A2.25 2.25 0 0019.5 17.25v-6a2.25 2.25 0 00-2.25-2.25H15z" />
              </svg>
              <span v-if="isSidebarOpen" class="ml-3">{{ item.name }}</span>
            </Link>
          </li>
        </ul>
      </nav>
    </aside>

    <!-- Content -->
    <main class="flex flex-col p-4 md:p-8 overflow-auto bg-white dark:bg-gray-800 min-h-screen">
      <slot />
    </main>
  </div>
</template>

<style scoped>
/* ปรับให้ Scroll นุ่มขึ้น */
::-webkit-scrollbar {
  width: 6px;
}

::-webkit-scrollbar-thumb {
  background: #cbd5e1;
  border-radius: 3px;
}

.custom-sidebar-gradient {
  background: linear-gradient(180deg, #4ade80 0%, #bbf7d0 60%, #f0fdf4 100%);
}

</style>
