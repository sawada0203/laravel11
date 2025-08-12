<script setup>
import { Pie } from 'vue-chartjs';
import {
  Chart as ChartJS,
  Title,
  Tooltip,
  Legend,
  ArcElement
} from 'chart.js';
import { defineProps, computed } from 'vue';

ChartJS.register(Title, Tooltip, Legend, ArcElement);

const props = defineProps({
  chartData: {
    type: Object,
    required: true
  }
});

const pieChartData = computed(() => ({
  labels: props.chartData.labels,
  datasets: [
    {
      label: 'จำนวน',
      data: props.chartData.data,
      backgroundColor: ['#60a5fa', '#f87171'] // ฟ้า แดง
    }
  ]
}));

const pieChartOptions = {
  responsive: true,
  plugins: {
    legend: {
      position: 'bottom'
    }
  }
};
</script>

<template>
  <Pie :data="pieChartData" :options="pieChartOptions" />
</template>
