<template>
  <div class="min-h-screen bg-gray-50">
    <StaffLayout :user="user">
      <div class="mb-8">
        <div class="flex items-start justify-between">
          <div>
            <h2 class="text-2xl md:text-3xl font-bold text-gray-800">Manajemen Aduan</h2>
            <p class="text-sm text-gray-500 mt-1">Kelola dan proses pengaduan masyarakat</p>
          </div>
        </div>
      </div>

      <!-- Statistik Status Cards -->
      <div class="grid grid-cols-1 md:grid-cols-5 gap-4 mb-8">
        <!-- Diajukan Card -->
        <div class="bg-gradient-to-br from-yellow-400 to-yellow-500 rounded-xl shadow-lg p-6 text-white">
          <div class="flex items-center justify-between">
            <div>
              <p class="text-yellow-100 text-sm font-medium">Diajukan</p>
              <h3 class="text-4xl font-bold mt-2">{{ stats?.diajukan || 0 }}</h3>
            </div>
            <div class="bg-white bg-opacity-20 p-4 rounded-lg">
              <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4v2m0-10a7 7 0 110 14 7 7 0 010-14z" />
              </svg>
            </div>
          </div>
        </div>

        <!-- Diverifikasi Card -->
        <div class="bg-gradient-to-br from-blue-400 to-blue-500 rounded-xl shadow-lg p-6 text-white">
          <div class="flex items-center justify-between">
            <div>
              <p class="text-blue-100 text-sm font-medium">Diverifikasi</p>
              <h3 class="text-4xl font-bold mt-2">{{ stats?.diverifikasi || 0 }}</h3>
            </div>
            <div class="bg-white bg-opacity-20 p-4 rounded-lg">
              <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
              </svg>
            </div>
          </div>
        </div>

        <!-- Ditolak Card -->
        <div class="bg-gradient-to-br from-red-400 to-red-500 rounded-xl shadow-lg p-6 text-white">
          <div class="flex items-center justify-between">
            <div>
              <p class="text-red-100 text-sm font-medium">Ditolak</p>
              <h3 class="text-4xl font-bold mt-2">{{ stats?.ditolak || 0 }}</h3>
            </div>
            <div class="bg-white bg-opacity-20 p-4 rounded-lg">
              <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4v.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
              </svg>
            </div>
          </div>
        </div>

        <!-- Diproses Card -->
        <div class="bg-gradient-to-br from-purple-400 to-purple-500 rounded-xl shadow-lg p-6 text-white">
          <div class="flex items-center justify-between">
            <div>
              <p class="text-purple-100 text-sm font-medium">Diproses</p>
              <h3 class="text-4xl font-bold mt-2">{{ stats?.diproses || 0 }}</h3>
            </div>
            <div class="bg-white bg-opacity-20 p-4 rounded-lg">
              <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
              </svg>
            </div>
          </div>
        </div>

        <!-- Selesai Card -->
        <div class="bg-gradient-to-br from-green-400 to-green-500 rounded-xl shadow-lg p-6 text-white">
          <div class="flex items-center justify-between">
            <div>
              <p class="text-green-100 text-sm font-medium">Selesai</p>
              <h3 class="text-4xl font-bold mt-2">{{ stats?.selesai || 0 }}</h3>
            </div>
            <div class="bg-white bg-opacity-20 p-4 rounded-lg">
              <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
              </svg>
            </div>
          </div>
        </div>
      </div>

      <!-- Filter & Search -->
      <div class="bg-white rounded-xl shadow-lg p-6 mb-8">
        <div class="grid grid-cols-1 md:grid-cols-4 gap-4">
          <div>
            <label class="block text-sm font-medium text-gray-700 mb-2">Cari Aduan</label>
            <input v-model="searchQuery" type="text" placeholder="No aduan atau lokasi..." class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-400 focus:border-transparent transition" />
          </div>
          <div>
            <label class="block text-sm font-medium text-gray-700 mb-2">Status</label>
            <select v-model="filterStatus" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-400 focus:border-transparent transition">
              <option value="">Semua Status</option>
              <option value="Diajukan">Diajukan</option>
              <option value="Diverifikasi">Diverifikasi</option>
              <option value="Diproses">Diproses</option>
              <option value="Selesai">Selesai</option>
              <option value="Ditolak">Ditolak</option>
            </select>
          </div>
          <div>
            <label class="block text-sm font-medium text-gray-700 mb-2">Kategori</label>
            <select v-model="filterKategori" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-400 focus:border-transparent transition">
              <option value="">Semua Kategori</option>
            </select>
          </div>
          <div class="flex items-end">
            <button @click="resetFilter" class="w-full px-4 py-2 bg-gray-500 hover:bg-gray-600 text-white font-medium rounded-lg transition">
              Reset
            </button>
          </div>
        </div>
      </div>

      <!-- Table Aduan -->
      <div class="bg-white rounded-xl shadow-lg overflow-hidden">
        <div class="px-6 py-4 border-b border-gray-200">
          <h3 class="text-lg font-bold text-gray-800">Daftar Pengaduan</h3>
        </div>

        <div class="overflow-x-auto">
          <table class="w-full">
            <thead class="bg-gray-50">
              <tr>
                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">No. Aduan</th>
                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Tanggal</th>
                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Kategori</th>
                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Lokasi</th>
                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Status</th>
                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Aksi</th>
              </tr>
            </thead>
            <tbody class="divide-y divide-gray-200">
              <tr v-for="item in aduan.data" :key="item.id" class="hover:bg-gray-50 transition">
                <td class="px-6 py-4 text-sm font-medium text-gray-900">#{{ item.no_aduan }}</td>
                <td class="px-6 py-4 text-sm text-gray-600">{{ formatDate(item.tanggal_lapor) }}</td>
                <td class="px-6 py-4 text-sm text-gray-600">{{ item.kategori_aduan?.nama_kategori }}</td>
                <td class="px-6 py-4 text-sm text-gray-600">{{ item.lokasi }}</td>
                <td class="px-6 py-4">
                  <span :class="getStatusColor(item.status_aduan?.nama_status)" class="px-3 py-1 inline-flex text-xs leading-5 font-semibold rounded-full">
                    {{ item.status_aduan?.nama_status }}
                  </span>
                </td>
                <td class="px-6 py-4 text-sm space-x-2">
                  <Link :href="`/manajemenaduan/daftaraduan/${item.id}`" class="text-blue-600 hover:text-blue-800 font-medium">Detail</Link>
                  <button @click="updateStatusModal(item)" class="text-purple-600 hover:text-purple-800 font-medium">Ubah Status</button>
                </td>
              </tr>
            </tbody>
          </table>
        </div>

        <!-- Pagination -->
        <div class="px-6 py-4 bg-gray-50 border-t border-gray-200 flex items-center justify-between">
          <p class="text-sm text-gray-600">
            Menampilkan {{ aduan.from }} hingga {{ aduan.to }} dari {{ aduan.total }} aduan
          </p>
          <div class="flex gap-2">
            <Link v-if="aduan.prev_page_url" :href="aduan.prev_page_url" class="px-3 py-1 text-sm bg-white border border-gray-300 rounded-lg hover:bg-gray-50">Sebelumnya</Link>
            <Link v-if="aduan.next_page_url" :href="aduan.next_page_url" class="px-3 py-1 text-sm bg-yellow-500 text-white rounded-lg hover:bg-yellow-600">Berikutnya</Link>
          </div>
        </div>
      </div>
    </StaffLayout>
  </div>
</template>

<script setup>
import { Link } from '@inertiajs/vue3'
import StaffLayout from '@/Layouts/StaffLayout.vue'
import { ref, watch } from 'vue'
import { router } from '@inertiajs/vue3'
import Swal from 'sweetalert2'

defineProps({
  user: Object,
  aduan: Object,
  stats: Object,
})

const searchQuery = ref('')
const filterStatus = ref('')
const filterKategori = ref('')

let aduanSearchTimer = null

watch([searchQuery, filterStatus, filterKategori], ([q, status, kategori]) => {
  clearTimeout(aduanSearchTimer)
  aduanSearchTimer = setTimeout(() => {
    router.get('/manajemenaduan/daftaraduan', { q, status, kategori }, { replace: true, preserveState: true })
  }, 350)
})

const formatDate = (date) => {
  return new Date(date).toLocaleDateString('id-ID', {
    year: 'numeric',
    month: 'long',
    day: 'numeric',
    hour: '2-digit',
    minute: '2-digit',
  })
}

const getStatusColor = (status) => {
  const colors = {
    'Diajukan': 'bg-yellow-100 text-yellow-800',
    'Diverifikasi': 'bg-blue-100 text-blue-800',
    'Diproses': 'bg-purple-100 text-purple-800',
    'Selesai': 'bg-green-100 text-green-800',
    'Ditolak': 'bg-red-100 text-red-800',
  }
  return colors[status] || 'bg-gray-100 text-gray-800'
}

const resetFilter = () => {
  searchQuery.value = ''
  filterStatus.value = ''
  filterKategori.value = ''
}

const updateStatusModal = (item) => {
  Swal.fire({
    title: 'Ubah Status Aduan',
    html: `<div class="text-left">
      <p class="mb-3"><strong>No. Aduan:</strong> ${item.no_aduan}</p>
      <p class="mb-4"><strong>Status Saat Ini:</strong> ${item.status_aduan?.nama_status || 'Tidak ada'}</p>
      <label class="block text-sm font-medium text-gray-700 mb-2">Pilih Status Baru</label>
      <select id="statusSelect" class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-400">
        <option value="">-- Pilih Status --</option>
        <option value="2">Diverifikasi</option>
        <option value="3">Diproses</option>
        <option value="4">Selesai</option>
        <option value="5">Ditolak</option>
      </select>
    </div>`,
    icon: 'info',
    showCancelButton: true,
    confirmButtonText: 'Ubah Status',
    cancelButtonText: 'Batal',
    confirmButtonColor: '#10B981',
    cancelButtonColor: '#EF4444',
    didOpen: () => {
      const selectElement = document.getElementById('statusSelect')
      selectElement?.focus()
    },
  }).then(async (result) => {
    if (result.isConfirmed) {
      const newStatus = document.getElementById('statusSelect')?.value
      if (!newStatus) {
        Swal.fire({
          icon: 'warning',
          title: 'Pilih Status',
          text: 'Silakan pilih status terlebih dahulu',
          confirmButtonColor: '#3B82F6',
        })
        return
      }

      try {
        await router.put(`/manajemenaduan/daftaraduan/${item.id}/status`, {
          status_aduan_id: newStatus,
          keterangan: '',
        })

        Swal.fire({
          icon: 'success',
          title: 'Status Diperbarui!',
          text: `Status aduan berhasil diubah.`,
          confirmButtonColor: '#3B82F6',
        })
      } catch (e) {
        Swal.fire({
          icon: 'error',
          title: 'Gagal',
          text: 'Terjadi kesalahan saat mengubah status.',
          confirmButtonColor: '#3B82F6',
        })
      }
    }
  })
}
</script>
