<script setup>
import { Link } from '@inertiajs/vue3'

defineProps({
    links: Array
});


</script>

<template>
    <div v-if="links.length > 5">
        <div class="flex flex-wrap -mb-1">
            <template v-for="(link, key) in links">
                <div v-if="link.url === null" :key="key"
                    class="mb-1 mr-1 px-4 py-3 text-gray-400 text-sm leading-4 border rounded" v-html="link.label" />
                <Link v-else :key="`link-${key}`"
                    class="mb-1 mr-1 px-4 py-3 text-sm leading-4 border rounded transition-all duration-200" :class="{
                        'bg-indigo-500 text-white border-indigo-500 shadow-lg': link.active,
                        'bg-gray-50 text-gray-700 hover:bg-indigo-500 hover:text-white hover:border-indigo-500 hover:shadow-lg': !link.active
                    }" :href="link.url" v-html="link.label" />
            </template>
        </div>
    </div>
</template>