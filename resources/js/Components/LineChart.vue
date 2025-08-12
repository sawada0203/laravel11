<script setup>
import { onMounted, ref, watch } from 'vue'

const props = defineProps({
  labels: Array,
  datasets: Array
})

const chartRef = ref(null)
let chartInstance = null

const fullscreen = ref(false)
const showMenu = ref(false)

function toggleFullscreen() {
  fullscreen.value = !fullscreen.value
  showMenu.value = false
}

function downloadChart() {
  const link = document.createElement('a')
  link.download = 'chart.png'
  link.href = chartRef.value.toDataURL('image/png')
  link.click()
  showMenu.value = false
}

function toggleMenu() {
  showMenu.value = !showMenu.value
}

onMounted(() => renderChart())
watch(() => props.datasets, () => {
  if (chartInstance) chartInstance.destroy()
  renderChart()
})

function renderChart() {
  const ctx = chartRef.value.getContext('2d')
  chartInstance = new window.Chart(ctx, {
    type: 'line',
    data: {
      labels: props.labels,
      datasets: props.datasets.map(ds => ({
        ...ds,
        fill: false,
        tension: 0.4,
        borderColor: ds.backgroundColor,
        backgroundColor: 'transparent',
        pointBackgroundColor: ds.backgroundColor,
      }))
    },
    options: {
      responsive: true,
      maintainAspectRatio: false,
      plugins: {
        title: {
          display: true,
          text: 'ข้อมูลโรคไข้เลือดออกรวม'
        },
        legend: {
          position: 'top'
        },
        tooltip: {
          enabled: true,
          filter: function (context) {
            return context.raw !== null && context.raw !== undefined;
          },
          callbacks: {
            label: function (context) {
              if (context.raw == null) return '';
              return `${context.dataset.label}: ${context.raw} คน`;
            },
            beforeBody: function (tooltipItems) {
              const allNull = tooltipItems.every(i => i.raw === null || i.raw === undefined);
              return allNull ? false : undefined;
            }
          }
        }
      },
      interaction: {
        mode: 'index',
        intersect: false
      },
      scales: {
        y: {
          beginAtZero: true
        }
      }
    }
  })
}
</script>

<template>
  <div class="relative w-full overflow-x-auto"
    :style="{height: fullscreen ? '100vh' : '400px', width: 'auto', background: '#fff', zIndex: fullscreen ? 50 : 'auto', position: fullscreen ? 'fixed' : 'relative', top: 0, left: 0, right: 0}">
    <!-- Hamburger Button -->
    <button   @click="toggleMenu"
  class="absolute top-1 right-1 bg-white border border-gray-300 shadow-md rounded-full w-8 h-8 flex flex-col items-center justify-center z-50 hover:bg-gray-100 transition"
  aria-label="เมนูกราฟ"
>
  <span class="block w-4 h-0.5 bg-gray-700 mb-0.5 rounded transition"></span>
  <span class="block w-4 h-0.5 bg-gray-700 mb-0.5 rounded transition"></span>
  <span class="block w-4 h-0.5 bg-gray-700 rounded transition"></span>
</button>
<!-- Dropdown Menu -->
<div
  v-if="showMenu"
  class="absolute top-14 right-3 bg-white border border-gray-200 rounded-lg shadow-lg z-50 min-w-[120px] animate-fade-in"
>
  <button
    @click="toggleFullscreen"
    class="block w-full text-left px-4 py-2 hover:bg-blue-50 rounded-t-lg transition"
  >
    {{ fullscreen ? 'ปิดเต็มจอ' : 'เต็มจอ' }}
  </button>
  <button
    @click="downloadChart"
    class="block w-full text-left px-4 py-2 hover:bg-blue-50 rounded-b-lg transition"
  >
    ดาวน์โหลด
  </button>
    </div>
    <canvas ref="chartRef" class="w-full"></canvas>
  </div>
</template>
