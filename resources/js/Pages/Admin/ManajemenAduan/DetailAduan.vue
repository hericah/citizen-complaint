<template>
  <div class="min-h-screen bg-gray-50">
    <StaffLayout :user="user">
      <div class="mb-8 flex items-center justify-between">
        <div>
          <h2 class="text-2xl md:text-3xl font-bold text-gray-800">Detail Aduan</h2>
          <p class="text-sm text-gray-500 mt-1">No. Aduan: #{{ aduan.no_aduan }}</p>
        </div>
        <Link :href="route('manajemenaduan.daftaraduan')" class="px-6 py-3 bg-gray-500 hover:bg-gray-600 text-white font-medium rounded-xl transition">
          Kembali
        </Link>
      </div>

      <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
        <!-- Left Column - Main Info -->
        <div class="lg:col-span-2 space-y-6">
          <!-- Status Card -->
          <div class="bg-white rounded-xl shadow-lg p-6">
            <div class="flex items-center justify-between">
              <div>
                <p class="text-gray-500 text-sm font-medium">Status</p>
                <h3 class="text-2xl font-bold mt-1">{{ aduan.status_aduan?.nama_status }}</h3>
              </div>
              <span :class="getStatusColor(aduan.status_aduan?.nama_status)" class="px-4 py-2 rounded-full text-sm font-semibold">
                {{ aduan.status_aduan?.nama_status }}
              </span>
            </div>
          </div>

          <!-- Informasi Aduan -->
          <div class="bg-white rounded-xl shadow-lg p-6">
            <h3 class="text-lg font-bold text-gray-800 mb-4">Informasi Aduan</h3>
            <div class="space-y-4">
              <div class="grid grid-cols-2 gap-4">
                <div>
                  <p class="text-gray-500 text-sm">Tanggal Lapor</p>
                  <p class="text-gray-900 font-medium">{{ formatDate(aduan.tanggal_lapor) }}</p>
                </div>
                <div>
                  <p class="text-gray-500 text-sm">Kategori</p>
                  <p class="text-gray-900 font-medium">{{ aduan.kategori_aduan?.nama_kategori }}</p>
                </div>
              </div>
              <div>
                <p class="text-gray-500 text-sm">Lokasi</p>
                <p class="text-gray-900 font-medium">{{ aduan.lokasi }}</p>
              </div>
              <div>
                <p class="text-gray-500 text-sm">Isi Aduan</p>
                <p class="text-gray-900 font-medium mt-2 p-3 bg-gray-50 rounded">{{ aduan.isi_aduan }}</p>
              </div>
              <div>
                <p class="text-gray-500 text-sm">Akses</p>
                <p class="text-gray-900 font-medium">{{ aduan.akses_aduan?.nama_akses }}</p>
              </div>
            </div>
          </div>

          <!-- Informasi Pelapor -->
          <div class="bg-white rounded-xl shadow-lg p-6">
            <h3 class="text-lg font-bold text-gray-800 mb-4">Informasi Pelapor</h3>
            <div class="space-y-3">
              <div>
                <p class="text-gray-500 text-sm">Nama</p>
                <p class="text-gray-900 font-medium">{{ aduan.masyarakat?.nama_lengkap }}</p>
              </div>
              <div>
                <p class="text-gray-500 text-sm">Email</p>
                <p class="text-gray-900 font-medium">{{ aduan.masyarakat?.email }}</p>
              </div>
              <div>
                <p class="text-gray-500 text-sm">Nomor Telepon</p>
                <p class="text-gray-900 font-medium">{{ aduan.masyarakat?.no_telepon }}</p>
              </div>
            </div>
          </div>

          <!-- Riwayat Status -->
          <div class="bg-white rounded-xl shadow-lg p-6">
            <h3 class="text-lg font-bold text-gray-800 mb-4">Riwayat Status</h3>
            <div class="space-y-3">
              <div v-for="riwayat in aduan.riwayat_status" :key="riwayat.id" class="flex items-start gap-4 p-4 bg-gray-50 rounded-lg">
                <div class="w-12 h-12 rounded-full bg-blue-100 flex items-center justify-center flex-shrink-0">
                  <span class="text-xl">📋</span>
                </div>
                <div class="flex-1">
                  <p class="font-medium text-gray-900">{{ riwayat.status_aduan?.nama_status }}</p>
                  <p class="text-sm text-gray-600 mt-1">{{ riwayat.keterangan }}</p>
                  <p class="text-xs text-gray-500 mt-2">{{ formatDate(riwayat.created_at) }}</p>
                </div>
              </div>
            </div>
          </div>

          <!-- Tanggapan Aduan -->
          <div class="bg-white rounded-xl shadow-lg p-6">
            <h3 class="text-lg font-bold text-gray-800 mb-4">Tanggapan</h3>
            <div v-if="aduan.tanggapan && aduan.tanggapan.length > 0" class="space-y-4">
              <div v-for="tanggapan in aduan.tanggapan" :key="tanggapan.id" class="p-4 bg-blue-50 rounded-lg border border-blue-200">
                <div class="flex items-start justify-between">
                  <p class="font-medium text-gray-900">{{ tanggapan.nama_pengguna }}</p>
                  <span class="text-xs text-gray-500">{{ formatDate(tanggapan.created_at) }}</span>
                </div>
                <p class="text-gray-700 mt-2">{{ tanggapan.isi_tanggapan }}</p>
              </div>
            </div>
            <div v-else class="text-center py-8">
              <p class="text-gray-500">Belum ada tanggapan</p>
            </div>
          </div>
        </div>

        <!-- Right Column - Actions -->
        <div class="lg:col-span-1">
          <div class="bg-white rounded-xl shadow-lg p-6 sticky top-6">
            <h3 class="text-lg font-bold text-gray-800 mb-4">Aksi</h3>
            <div class="space-y-3">
              <button @click="openUpdateStatusModal" class="w-full px-4 py-3 bg-blue-500 hover:bg-blue-600 text-white font-medium rounded-lg transition">
                Ubah Status
              </button>
              <button @click="printAduan" class="w-full px-4 py-3 bg-purple-500 hover:bg-purple-600 text-white font-medium rounded-lg transition">
                Cetak
              </button>
              <button @click="deleteAduan" class="w-full px-4 py-3 bg-red-500 hover:bg-red-600 text-white font-medium rounded-lg transition">
                Hapus
              </button>
            </div>
          </div>
        </div>
      </div>

      <!-- Update Status Modal -->
      <div v-if="showModal" class="fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center z-50">
        <div class="bg-white rounded-xl shadow-lg p-8 max-w-md w-full mx-4">
          <h3 class="text-xl font-bold text-gray-800 mb-4">Ubah Status Aduan</h3>
          <p class="text-sm text-gray-600 mb-6">Nomor Aduan: #{{ aduan.no_aduan }}</p>
          
          <div class="space-y-4">
            <div>
              <label class="block text-gray-700 text-sm font-medium mb-2">Status Baru</label>
              <select v-model="newStatus" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-400">
                <option value="">Pilih Status</option>
                <option value="1">Diajukan</option>
                <option value="2">Diverifikasi</option>
                <option value="3">Diproses</option>
                <option value="4">Selesai</option>
                <option value="5">Ditolak</option>
              </select>
            </div>

            <div>
              <label class="block text-gray-700 text-sm font-medium mb-2">Keterangan</label>
              <textarea v-model="statusNote" rows="4" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-400" placeholder="Masukkan keterangan..."></textarea>
            </div>

            <div class="flex gap-3 pt-4">
              <button @click="showModal = false" class="flex-1 px-4 py-2 bg-gray-300 hover:bg-gray-400 text-gray-800 font-medium rounded-lg transition">
                Batal
              </button>
              <button @click="submitStatusUpdate" class="flex-1 px-4 py-2 bg-blue-500 hover:bg-blue-600 text-white font-medium rounded-lg transition">
                Simpan
              </button>
            </div>
          </div>
        </div>
      </div>
    </StaffLayout>
  </div>
</template>

<script setup>
import { Link } from '@inertiajs/vue3'
import StaffLayout from '@/Layouts/StaffLayout.vue'
import { ref } from 'vue'
import { router } from '@inertiajs/vue3'
import Swal from 'sweetalert2'

defineProps({
  user: Object,
  aduan: Object,
})

const showModal = ref(false)
const newStatus = ref('')
const statusNote = ref('')

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

const openUpdateStatusModal = () => {
  showModal.value = true
}

const submitStatusUpdate = async () => {
  if (!newStatus.value) {
    Swal.fire({
      icon: 'warning',
      title: 'Pilih Status',
      text: 'Silakan pilih status terlebih dahulu',
      confirmButtonColor: '#3B82F6',
    })
    return
  }

  const result = await Swal.fire({
    icon: 'question',
    title: 'Konfirmasi Perubahan Status',
    text: `Ubah status aduan menjadi status yang dipilih?`,
    showCancelButton: true,
    confirmButtonText: 'Ya, Ubah',
    cancelButtonText: 'Batal',
    confirmButtonColor: '#10B981',
    cancelButtonColor: '#EF4444',
  })

  if (result.isConfirmed) {
    try {
      await router.put(`/manajemenaduan/daftaraduan/${aduan.id}/status`, {
        status_aduan_id: newStatus.value,
        keterangan: statusNote.value,
      })

      Swal.fire({
        icon: 'success',
        title: 'Status Diperbarui!',
        text: 'Status aduan telah berhasil diubah.',
        confirmButtonColor: '#3B82F6',
      })

      showModal.value = false
    } catch (e) {
      Swal.fire({
        icon: 'error',
        title: 'Gagal',
        text: 'Terjadi kesalahan saat mengubah status.',
        confirmButtonColor: '#3B82F6',
      })
    }
  }
}

const printAduan = () => {
  window.print()
}

const deleteAduan = async () => {
  const result = await Swal.fire({
    icon: 'warning',
    title: 'Hapus Aduan?',
    text: 'Apakah Anda yakin ingin menghapus aduan ini? Tindakan ini tidak dapat dibatalkan.',
    showCancelButton: true,
    confirmButtonText: 'Ya, Hapus',
    cancelButtonText: 'Batal',
    confirmButtonColor: '#EF4444',
    cancelButtonColor: '#6B7280',
  })

  if (result.isConfirmed) {
    Swal.fire({
      icon: 'success',
      title: 'Aduan Dihapus!',
      text: 'Aduan berhasil dihapus dari sistem.',
      confirmButtonColor: '#3B82F6',
    }).then(() => {
      window.location.href = '/manajemenaduan/daftaraduan'
    })
  }
}
</script>
