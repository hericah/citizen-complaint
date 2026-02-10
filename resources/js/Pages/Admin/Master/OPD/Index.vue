<template>
  <div class="min-h-screen bg-gray-50">
    <StaffLayout :user="user">
      <div class="mb-8">
        <div class="flex items-start justify-between">
          <div>
            <h2 class="text-2xl md:text-3xl font-bold text-gray-800">Master OPD</h2>
            <p class="text-sm text-gray-500 mt-1">
              Kelola data organisasi perangkat daerah
            </p>
          </div>
          <Link
            href="/master/opd/create"
            class="px-6 py-3 bg-blue-500 hover:bg-blue-600 text-white font-medium rounded-xl transition"
          >
            Tambah OPD
          </Link>
        </div>
      </div>

      <!-- Search & Filter -->
      <div class="bg-white rounded-xl shadow-lg p-6 mb-8">
        <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
          <div>
            <input
              v-model="searchQuery"
              type="text"
              placeholder="Cari nama OPD..."
              class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-400"
            />
          </div>
          <div class="flex gap-2">
            <button
              @click="resetSearch"
              class="flex-1 px-4 py-2 bg-gray-500 hover:bg-gray-600 text-white font-medium rounded-lg transition"
            >
              Reset
            </button>
          </div>
        </div>
      </div>

      <!-- Table OPD -->
      <div class="bg-white rounded-xl shadow-lg overflow-hidden">
        <div class="px-6 py-4 border-b border-gray-200">
          <h3 class="text-lg font-bold text-gray-800">Daftar OPD</h3>
        </div>

        <div class="overflow-x-auto">
          <table class="w-full">
            <thead class="bg-gray-50">
              <tr>
                <th
                  class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase"
                >
                  No
                </th>
                <th
                  class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase"
                >
                  Nama OPD
                </th>
                <th
                  class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase"
                >
                  No. Telepon
                </th>
                <th
                  class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase"
                >
                  Alamat
                </th>
                <th
                  class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase"
                >
                  Tanggal Dibuat
                </th>
                <th
                  class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase"
                >
                  Aksi
                </th>
              </tr>
            </thead>
            <tbody class="divide-y divide-gray-200">
              <tr v-if="opd.data.length === 0" class="hover:bg-gray-50 transition">
                <td colspan="6" class="px-6 py-4 text-center text-gray-500">
                  Tidak ada data OPD
                </td>
              </tr>
              <tr
                v-for="(item, index) in opd.data"
                :key="item.id"
                class="hover:bg-gray-50 transition"
              >
                <td class="px-6 py-4 text-sm font-medium text-gray-900">
                  {{ opd.from + index }}
                </td>
                <td class="px-6 py-4 text-sm font-medium text-gray-900">
                  {{ item.nama_opd }}
                </td>
                <td class="px-6 py-4 text-sm text-gray-600">{{ item.no_telp }}</td>
                <td class="px-6 py-4 text-sm text-gray-600">
                  {{ truncateText(item.alamat, 50) }}
                </td>
                <td class="px-6 py-4 text-sm text-gray-600">
                  {{ formatDate(item.tanggal_dibuat) }}
                </td>
                <td class="px-6 py-4 text-sm space-x-2">
                  <Link
                    :href="`/master/opd/${item.id}/edit`"
                    class="text-blue-600 hover:text-blue-800 font-medium"
                    >Edit</Link
                  >
                  <button
                    @click="deleteOPD(item.id)"
                    class="text-red-600 hover:text-red-800 font-medium"
                  >
                    Hapus
                  </button>
                </td>
              </tr>
            </tbody>
          </table>
        </div>

        <!-- Pagination -->
        <div
          class="px-6 py-4 bg-gray-50 border-t border-gray-200 flex items-center justify-between"
        >
          <p class="text-sm text-gray-600">
            Menampilkan {{ opd.from }} hingga {{ opd.to }} dari {{ opd.total }} OPD
          </p>
          <div class="flex gap-2">
            <Link
              v-if="opd.prev_page_url"
              :href="opd.prev_page_url"
              class="px-3 py-1 text-sm bg-white border border-gray-300 rounded-lg hover:bg-gray-50"
              >Sebelumnya</Link
            >
            <Link
              v-if="opd.next_page_url"
              :href="opd.next_page_url"
              class="px-3 py-1 text-sm bg-blue-500 text-white rounded-lg hover:bg-blue-600"
              >Berikutnya</Link
            >
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
  opd: Object,
});

const searchQuery = ref("");

let opdSearchTimer = null;

watch(searchQuery, (val) => {
  clearTimeout(opdSearchTimer);
  opdSearchTimer = setTimeout(() => {
    router.get('/master/opd', { q: val }, { replace: true, preserveState: true });
  }, 350);
});

const formatDate = (date) => {
  return new Date(date).toLocaleDateString("id-ID", {
    year: "numeric",
    month: "long",
    day: "numeric",
  });
};

const truncateText = (text, length) => {
  return text.length > length ? text.substring(0, length) + "..." : text;
};

const resetSearch = () => {
  searchQuery.value = "";
  router.get("/master/opd");
};

const deleteOPD = (id) => {
  Swal.fire({
    title: "Hapus OPD?",
    text: "Data tidak bisa dikembalikan!",
    icon: "warning",
    showCancelButton: true,
    confirmButtonColor: "#EF4444",
    cancelButtonColor: "#6B7280",
    confirmButtonText: "Ya, hapus!",
  }).then((result) => {
    if (result.isConfirmed) {
      router.delete(`/master/opd/${id}`);
    }
  });
};
</script>
