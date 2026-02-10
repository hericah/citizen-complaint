<template>
  <div class="min-h-screen bg-gray-50">
    <StaffLayout :user="user">
      <div class="mb-8">
        <div class="flex items-start justify-between">
          <div>
            <h2 class="text-2xl md:text-3xl font-bold text-gray-800">Master Unit OPD</h2>
            <p class="text-sm text-gray-500 mt-1">Kelola unit-unit di bawah OPD</p>
          </div>
          <Link href="/master/unit-opd/create" class="px-6 py-3 bg-blue-500 hover:bg-blue-600 text-white font-medium rounded-xl transition">Tambah Unit</Link>
        </div>
      </div>

      <div class="bg-white rounded-xl shadow-lg p-6 mb-8">
        <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
          <div>
            <input v-model="searchQuery" type="text" placeholder="Cari nama unit..." class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-400" />
          </div>
          <div class="flex gap-2">
            <button @click="resetSearch" class="flex-1 px-4 py-2 bg-gray-500 hover:bg-gray-600 text-white font-medium rounded-lg transition">Reset</button>
          </div>
        </div>
      </div>

      <div class="bg-white rounded-xl shadow-lg overflow-hidden">
        <div class="px-6 py-4 border-b border-gray-200"><h3 class="text-lg font-bold text-gray-800">Daftar Unit OPD</h3></div>
        <div class="overflow-x-auto">
          <table class="w-full">
            <thead class="bg-gray-50">
              <tr>
                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">No</th>
                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">OPD</th>
                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Nama Unit</th>
                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Kode</th>
                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Aksi</th>
              </tr>
            </thead>
            <tbody class="divide-y divide-gray-200">
              <tr v-if="units.data.length === 0" class="hover:bg-gray-50 transition"><td colspan="5" class="px-6 py-4 text-center text-gray-500">Tidak ada data Unit</td></tr>
              <tr v-for="(item, index) in units.data" :key="item.id" class="hover:bg-gray-50 transition">
                <td class="px-6 py-4 text-sm font-medium text-gray-900">{{ units.from + index }}</td>
                <td class="px-6 py-4 text-sm font-medium text-gray-900">{{ item.opd?.nama_opd ?? '-' }}</td>
                <td class="px-6 py-4 text-sm text-gray-600">{{ item.nama_unit }}</td>
                <td class="px-6 py-4 text-sm text-gray-600">{{ item.kode_unit ?? '-' }}</td>
                <td class="px-6 py-4 text-sm space-x-2">
                  <Link :href="`/master/unit-opd/${item.id}/edit`" class="text-blue-600 hover:text-blue-800 font-medium">Edit</Link>
                  <button @click="deleteUnit(item.id)" class="text-red-600 hover:text-red-800 font-medium">Hapus</button>
                </td>
              </tr>
            </tbody>
          </table>
        </div>

        <div class="px-6 py-4 bg-gray-50 border-t border-gray-200 flex items-center justify-between">
          <p class="text-sm text-gray-600">Menampilkan {{ units.from }} hingga {{ units.to }} dari {{ units.total }} Unit</p>
          <div class="flex gap-2">
            <Link v-if="units.prev_page_url" :href="units.prev_page_url" class="px-3 py-1 text-sm bg-white border border-gray-300 rounded-lg hover:bg-gray-50">Sebelumnya</Link>
            <Link v-if="units.next_page_url" :href="units.next_page_url" class="px-3 py-1 text-sm bg-blue-500 text-white rounded-lg hover:bg-blue-600">Berikutnya</Link>
          </div>
        </div>
      </div>
    </StaffLayout>
  </div>
</template>

<script setup>
import { Link } from "@inertiajs/vue3";
import StaffLayout from "@/Layouts/StaffLayout.vue";
import Swal from "sweetalert2";
import { router } from "@inertiajs/vue3";
import { ref, watch } from "vue";

defineProps({
  user: Object,
  units: Object,
});

const searchQuery = ref("");
let timer = null;
watch(searchQuery, (val) => {
  clearTimeout(timer);
  timer = setTimeout(() => {
    router.get('/master/unit-opd', { q: val }, { replace: true, preserveState: true });
  }, 350);
});

const resetSearch = () => {
  searchQuery.value = "";
  router.get('/master/unit-opd');
};

const deleteUnit = (id) => {
  Swal.fire({
    title: "Hapus Unit?",
    text: "Data tidak bisa dikembalikan!",
    icon: "warning",
    showCancelButton: true,
    confirmButtonColor: "#EF4444",
    cancelButtonColor: "#6B7280",
    confirmButtonText: "Ya, hapus!",
  }).then((result) => {
    if (result.isConfirmed) {
      router.delete(`/master/unit-opd/${id}`);
    }
  });
};
</script>
