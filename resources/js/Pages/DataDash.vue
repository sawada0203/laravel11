<script setup>
import { Head } from '@inertiajs/vue3';
import Navmenu from '@/Layouts/Navmenu.vue';
import { computed } from 'vue';
import ColumnChart from '@/Components/LineChart.vue'
import PieChart from '@/Components/PieChart.vue';
import { all } from 'axios';
import { faAmbulance } from '@fortawesome/free-solid-svg-icons';

defineOptions({ layout: Navmenu });


const props = defineProps({
  alldataOPD: Object,
  alldataIPD: Object,
  alldataER: Object,
  alldataTele: Object,
  chartData: Object,
  chartData2: Object,
  fever506Table: Object,
  bedward: Object,
  pttipd: Object,
  pttopd: Object

});

const am = 'am.png';
const tele = 'tele.png';
const st = 'stethoscope.png';
const bed = 'bed.png';

const totalAdmitNow = computed(() =>
  Array.isArray(props.bedward)
    ? props.bedward.reduce((sum, b) => sum + (b.admitnow || 0), 0)
    : 0
);

const cardColors = [
  'bg-pink-600',
  'bg-blue-500',
  'bg-pink-500',
  'bg-orange-400',
  'bg-purple-500',
  'bg-green-800'
];

</script>

<template>
  <section class="w-full max-w-full">
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6 mb-6">
      <!-- การ์ด 1 -->
      <div class="relative bg-blue-500 text-white p-4 rounded-lg shadow">
        <!-- ไอคอนจาง -->
        <p class="text-md">ผู้รับบริการวันนี้</p>
        <div class="absolute right-4 top-4 opacity-50 text-5xl">
          <img :src="`/storage/icon/${st}`" alt="tele" class="w-16 h-16" />
        </div>
        <p class="text-3xl font-bold">{{ alldataOPD.pt_opd_today.toLocaleString() }}</p>
        <p class="text-sm opacity-90 pt-2">เดือนนี้ {{ alldataOPD.ptm_opd_hn.toLocaleString() }} คน / {{
          alldataOPD.ptm_opd_vn.toLocaleString() }} ครั้ง</p>
        <div class="mt-3 text-sm underline cursor-pointer flex items-center gap-1">
          รายละเอียด
          <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
              d="M15 12H9m12 0a9 9 0 11-18 0 9 9 0 0118 0z" />
          </svg>
        </div>
      </div>

      <!-- การ์ด 2 -->
      <div class="relative bg-pink-500 text-white p-4 rounded-lg shadow">
        <p class="text-md">Admit วันนี้</p>
        <div class="absolute right-4 top-4 opacity-50 text-5xl">
          <img :src="`/storage/icon/${bed}`" alt="รูปภาพ" class="w-16 h-16" />
        </div>
        <p class="text-3xl font-bold">{{ alldataIPD.pt_ipd_today.toLocaleString() }}</p>
        <p class="text-sm opacity-90 pt-2">เดือนนี้ {{ alldataIPD.ptm_ipd_hn.toLocaleString() }} คน / {{
          alldataIPD.ptm_ipd_an.toLocaleString() }} ครั้ง</p>
        <div class="mt-3 text-sm underline cursor-pointer flex items-center gap-1">
          รายละเอียด
          <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
              d="M15 12H9m12 0a9 9 0 11-18 0 9 9 0 0118 0z" />
          </svg>
        </div>
      </div>

      <!-- การ์ด 3 -->
      <div class="relative bg-red-500 text-white p-4 rounded-lg shadow">
        <p class="text-md">ผู้ป่วยฉุกเฉิน วันนี้</p>
        <div class="absolute right-4 top-4 opacity-50 text-5xl">
          <img :src="`/storage/icon/${am}`" alt="รูปภาพ" class="w-16 h-16" />
        </div>
        <p class="text-3xl font-bold">{{ alldataER.pt_er_today.toLocaleString() }}</p>
        <p class="text-sm opacity-90 pt-2">เดือนนี้ {{ alldataER.ptm_er_hn.toLocaleString() }} คน / {{
          alldataER.ptm_er_vn.toLocaleString() }} ครั้ง</p>
        <div class="mt-3 text-sm underline cursor-pointer flex items-center gap-1">
          รายละเอียด
          <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
              d="M15 12H9m12 0a9 9 0 11-18 0 9 9 0 0118 0z" />
          </svg>
        </div>
      </div>

      <!-- การ์ด 4 -->
      <div class="relative bg-orange-400 text-white p-4 rounded-lg shadow">
        <p class="text-md">Telemedicine วันนี้</p>
        <div class="absolute right-4 top-4 opacity-50 text-5xl">
          <img :src="`/storage/icon/${tele}`" alt="tele" class="w-16 h-16" />
        </div>
        <p class="text-3xl font-bold">{{ alldataTele.pt_hn_today.toLocaleString() }}</p>
        <p class="text-sm opacity-90 pt-2">เดือนนี้ {{ alldataTele.pt_hn_month.toLocaleString() }} คน / {{
          alldataTele.pt_vn_month.toLocaleString() }} ครั้ง</p>
        <div class="mt-3 text-sm underline cursor-pointer flex items-center gap-1">
          รายละเอียด
          <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
              d="M15 12H9m12 0a9 9 0 11-18 0 9 9 0 0118 0z" />
          </svg>
        </div>
      </div>
    </div>

    <!-- กราฟ -->
    <div class="grid grid-cols-1 lg:grid-cols-2 gap-6 mb-6">
      <!-- ฝั่งซ้าย: กราฟ -->
      <div class="bg-white rounded-lg shadow p-6 overflow-x-auto">
        <h3 class="text-xl font-semibold mb-4">โรคที่ต้องเฝ้าระวัง</h3>
        <ColumnChart :labels="chartData.labels" :datasets="chartData.datasets" />
      </div>

      <!-- ฝั่งขวา -->
      <div class="relative bg-blue-200 sm:rounded-lg shadow-md p-6 overflow-x-auto scrollbar-thin scrollbar-thumb-blue-400 scrollbar-track-blue-100">
        <h3 class="text-xl font-semibold mb-4">อันดับโรคติดต่อต้องเฝ้าระวัง</h3>
        <table class="w-full text-sm text-left rtl:text-right text-blue-100 dark:text-blue-100">
          <thead class="text-xs text-black uppercase bg-blue-200 border-b border-blue-200 dark:text-white">
            <tr>
              <th scope="col" class="px-6 py-3">รหัสโรค</th>
              <th scope="col" class="px-6 py-3">ชื่อโรค[TH]</th>
              <th scope="col" class="px-6 py-3">ชื่อโรค[EN]</th>
              <th scope="col" class="px-6 py-3">จำนวน</th>
            </tr>
          </thead>
          <tbody>
            <tr v-for="row in fever506Table" :key="row.code506"
              class="bg-blue-300 border-b border-blue-300 hover:bg-blue-400 text-black">
              <td class="px-6 py-4">
                {{ row.code506 }}
              </td>
              <td class="px-6 py-4">
                {{ row.namet }}
              </td>
              <td class="px-6 py-4">
                {{ row.namee }}
              </td>
              <td class="px-6 py-4">
                {{ row.count506 }}
              </td>
            </tr>
          </tbody>
        </table>
      </div>
    </div>


    <div class="bg-white rounded-lg shadow p-6 mb-6">
      <h3 class="text-xl font-semibold mb-4 text-gray-800">ภาพรวมผู้ป่วยในและอัตราการครองเตียง</h3>

      <div class="grid grid-cols-1 lg:grid-cols-[1fr_2fr] gap-4 items-start">
        <!-- ซ้าย: กราฟวงกลม -->
        <div class="flex justify-center items-center">
          <div class="w-[380px] h-[380px]">
            <PieChart :chart-data="chartData2" />
          </div>
        </div>

        <!-- ขวา: การ์ดแผนก -->
        <div class="grid grid-cols-1 sm:grid-cols-3 lg:grid-cols- gap-2">
          <!-- การ์ดแถวแรก (เต็มแถวเดียว) -->
          <div class="col-span-1 sm:col-span-3 flex justify-center">
            <div class="bg-blue-900 text-white p-4 rounded-lg shadow w-full max-w-xs flex items-center gap-2">
              <!-- รูปเตียง -->
              <img :src="`/storage/icon/${bed}`" alt="bed" class="w-10 h-10 flex-shrink-0" />
              <!-- คั่น | -->
              <span class="text-2xl font-bold">|</span>
              <!-- ข้อมูลการ์ด -->
              <div>
                <p class="text-lg font-semibold">•อัตราการครองเตียงรวม•</p>
                <p class="text-2xl font-bold mt-2">Admit {{ totalAdmitNow }} / 140 เตียง</p>
                <p class="mt-1 text-sm">
                  ครองเตียงคิดเป็น
                  {{
                    140 > 0
                      ? Math.round((totalAdmitNow / 140) * 100)
                      : 0
                  }}%
                  <span v-if="totalAdmitNow === 140"> (เต็ม)</span>
                  <span v-else-if="totalAdmitNow < 140">
                    (ว่าง {{ 140 - totalAdmitNow }} เตียง)
                  </span>
                  <span v-else>
                    (ล้น {{ totalAdmitNow - 140 }} เตียง)
                  </span>
                </p>
              </div>
            </div>
          </div>

          <!-- การ์ดแถวถัดไป (หลายคอลัมน์) -->
          <div v-for="(bedwards, idx) in bedward" :key="bedwards.id" :class="[
            'text-white p-4 rounded-lg shadow flex items-center gap-3',
            cardColors[idx % cardColors.length]
          ]">
            <!-- รูปเตียง -->
            <img :src="`/storage/icon/${bed}`" alt="bed" class="w-10 h-10 flex-shrink-0" />
            <!-- คั่น | -->
            <span class="text-2xl font-bold">|</span>
            <!-- ข้อมูลการ์ด -->
            <div>
              <p class="text-lg font-semibold">•{{ bedwards.name }}</p>
              <p class="text-2xl font-bold mt-2">
                Admit {{ bedwards.admitnow }} / {{ bedwards.bedcount }} เตียง
              </p>
              <p class="mt-1 text-sm">
                ครองเตียงคิดเป็น
                {{
                  bedwards.bedcount > 0
                    ? Math.round((bedwards.admitnow / bedwards.bedcount) * 100)
                    : 0
                }}%
                <span v-if="bedwards.admitnow === bedwards.bedcount"> (เต็ม)</span>
                <span v-else-if="bedwards.admitnow < bedwards.bedcount">
                  (ว่าง {{ bedwards.bedcount - bedwards.admitnow }} เตียง)
                </span>
                <span v-else>
                  (ล้น {{ bedwards.admitnow - bedwards.bedcount }} เตียง)
                </span>
              </p>
            </div>
          </div>
        </div>
      </div>
    </div>


    <div class="grid grid-cols-1 md:grid-cols-3 gap-4 mb-6">
      <!-- การ์ด 1: สิทธิ์ทั้งหมดในวันนี้ -->
      <div class="bg-white rounded-lg shadow flex flex-col">
        <div class="bg-blue-300 rounded-t-md px-4 py-2 mb-4">
          <h3 class="text-xl font-semibold text-gray-800">•สิทธิ์ทั้งหมดในวันนี้</h3>
        </div>
        <ul class="text-gray-700 text-base space-y-2 ps-6 pb-4">
          <li>สิทธิ์ UC : <span class="font-bold">{{ pttopd.uc + pttipd.uc }} คน</span></li>
          <li>สิทธิ์ชำระเงินและเบิกได้ : <span class="font-bold">{{ pttopd.mo + pttipd.mo }} คน</span></li>
          <li>สิทธิ์อื่น ๆ : <span class="font-bold">{{ pttopd.ot + pttipd.ot }} คน</span></li>
        </ul>
      </div>
      <!-- การ์ด 2: OPD -->
      <div class="bg-white rounded-lg shadow flex flex-col">
        <div class="bg-red-300 rounded-t-md px-4 py-2 mb-4">
        <h3 class="text-xl font-semibold text-gray-800">•OPD</h3>
        </div>
        <ul class="text-gray-700 text-base space-y-2 ps-6 pb-4">
          <li>สิทธิ์ UC : <span class="font-bold">{{ pttopd.uc }} คน</span></li>
          <li>สิทธิ์ชำระเงินและเบิกได้ : <span class="font-bold">{{ pttopd.mo }} คน</span></li>
          <li>สิทธิ์อื่น ๆ : <span class="font-bold">{{ pttopd.ot }} คน</span></li>
        </ul>
      </div>
      <!-- การ์ด 3: IPD -->
      <div class="bg-white rounded-lg shadow flex flex-col">
        <div class="bg-green-300 rounded-t-md px-4 py-2 mb-4">
        <h3 class="text-xl font-semibold text-gray-800">•IPD</h3>
        </div>
        <ul class="text-gray-700 text-base space-y-2 ps-6 pb-4">
          <li>สิทธิ์ UC : <span class="font-bold">{{ pttipd.uc }} คน</span></li>
          <li>สิทธิ์ชำระเงินและเบิกได้ : <span class="font-bold">{{ pttipd.mo }} คน</span></li>
          <li>สิทธิ์อื่น ๆ : <span class="font-bold">{{ pttipd.ot }} คน</span></li>
        </ul>
      </div>
    </div>



    

  </section>
</template>
