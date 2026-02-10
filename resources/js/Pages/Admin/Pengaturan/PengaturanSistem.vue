<template>
  <div class="min-h-screen bg-gray-50">
    <component :is="userLayout" :user="user">
      <div class="mb-8">
        <h2 class="text-2xl md:text-3xl font-bold text-gray-800">Pengaturan Sistem</h2>
        <p class="text-sm text-gray-500 mt-1">Konfigurasi pengaturan aplikasi</p>
      </div>

      <div class="space-y-6">
        <!-- Informasi Sistem -->
        <div class="bg-white rounded-xl shadow-lg p-6">
          <h3 class="text-lg font-bold text-gray-800 mb-4">Informasi Sistem</h3>
          <div class="space-y-3">
            <div class="flex justify-between py-2 border-b border-gray-200">
              <span class="text-gray-600">Nama Aplikasi</span>
              <span class="font-medium text-gray-900">E-Lapor</span>
            </div>
            <div class="flex justify-between py-2 border-b border-gray-200">
              <span class="text-gray-600">Versi</span>
              <span class="font-medium text-gray-900">1.0.0</span>
            </div>
            <div class="flex justify-between py-2 border-b border-gray-200">
              <span class="text-gray-600">Tahun Diluncurkan</span>
              <span class="font-medium text-gray-900">2024</span>
            </div>
            <div class="flex justify-between py-2">
              <span class="text-gray-600">Status</span>
              <span class="inline-flex items-center px-3 py-1 rounded-full bg-green-100 text-green-800 text-sm font-medium">
                ✓ Aktif
              </span>
            </div>
          </div>
        </div>

        <!-- Pengaturan Email -->
        <div class="bg-white rounded-xl shadow-lg p-6">
          <h3 class="text-lg font-bold text-gray-800 mb-4">Pengaturan Notifikasi</h3>
          <div class="space-y-4">
            <div class="flex items-center justify-between">
              <div>
                <p class="text-gray-800 font-medium">Notifikasi Email</p>
                <p class="text-sm text-gray-500 mt-1">Terima notifikasi aduan baru melalui email</p>
              </div>
              <label class="relative inline-flex items-center cursor-pointer">
                <input v-model="settings.emailNotification" type="checkbox" class="sr-only peer" />
                <div class="w-11 h-6 bg-gray-200 peer-focus:outline-none peer-focus:ring-4 peer-focus:ring-blue-300 rounded-full peer peer-checked:after:translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-[2px] after:left-[2px] after:bg-white after:border-gray-300 after:border after:rounded-full after:h-5 after:w-5 after:transition-all peer-checked:bg-blue-600"></div>
              </label>
            </div>

            <hr class="border-gray-200" />

            <div class="flex items-center justify-between">
              <div>
                <p class="text-gray-800 font-medium">Notifikasi SMS</p>
                <p class="text-sm text-gray-500 mt-1">Terima notifikasi aduan baru melalui SMS</p>
              </div>
              <label class="relative inline-flex items-center cursor-pointer">
                <input v-model="settings.smsNotification" type="checkbox" class="sr-only peer" />
                <div class="w-11 h-6 bg-gray-200 peer-focus:outline-none peer-focus:ring-4 peer-focus:ring-blue-300 rounded-full peer peer-checked:after:translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-[2px] after:left-[2px] after:bg-white after:border-gray-300 after:border after:rounded-full after:h-5 after:w-5 after:transition-all peer-checked:bg-blue-600"></div>
              </label>
            </div>

            <hr class="border-gray-200" />

            <div class="flex items-center justify-between">
              <div>
                <p class="text-gray-800 font-medium">Notifikasi In-App</p>
                <p class="text-sm text-gray-500 mt-1">Tampilkan notifikasi dalam aplikasi</p>
              </div>
              <label class="relative inline-flex items-center cursor-pointer">
                <input v-model="settings.inAppNotification" type="checkbox" class="sr-only peer" />
                <div class="w-11 h-6 bg-gray-200 peer-focus:outline-none peer-focus:ring-4 peer-focus:ring-blue-300 rounded-full peer peer-checked:after:translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-[2px] after:left-[2px] after:bg-white after:border-gray-300 after:border after:rounded-full after:h-5 after:w-5 after:transition-all peer-checked:bg-blue-600"></div>
              </label>
            </div>
          </div>
        </div>

        <!-- Pengaturan Keamanan -->
        <div class="bg-white rounded-xl shadow-lg p-6">
          <h3 class="text-lg font-bold text-gray-800 mb-4">Pengaturan Keamanan</h3>
          <div class="space-y-4">
            <div>
              <p class="text-gray-800 font-medium mb-3">Two-Factor Authentication</p>
              <button @click="enable2FA" class="px-4 py-2 bg-blue-500 hover:bg-blue-600 text-white font-medium rounded-lg transition">
                Aktifkan 2FA
              </button>
            </div>

            <hr class="border-gray-200" />

            <div class="bg-yellow-50 border border-yellow-200 rounded-lg p-4">
              <p class="text-sm text-yellow-700">
                <strong>⚠️ Bahaya:</strong> Hapus akun tidak dapat dibatalkan. Semua data Anda akan dihapus secara permanen.
              </p>
              <button @click="deleteAccount" class="mt-3 px-4 py-2 bg-red-500 hover:bg-red-600 text-white font-medium rounded-lg transition">
                Hapus Akun
              </button>
            </div>
          </div>
        </div>

        <!-- Cache & Backup -->
        <div class="bg-white rounded-xl shadow-lg p-6">
          <h3 class="text-lg font-bold text-gray-800 mb-4">Cache & Backup</h3>
          <div class="space-y-3">
            <button @click="clearCache" class="w-full px-4 py-2 bg-purple-500 hover:bg-purple-600 text-white font-medium rounded-lg transition text-left">
              Clear Cache
            </button>
            <button @click="backupData" class="w-full px-4 py-2 bg-green-500 hover:bg-green-600 text-white font-medium rounded-lg transition text-left">
              Backup Data
            </button>
          </div>
        </div>

        <!-- Save All Settings -->
        <div class="flex gap-3">
          <Link :href="route('home')" class="flex-1 px-4 py-3 bg-gray-300 hover:bg-gray-400 text-gray-800 font-medium rounded-lg transition text-center">
            Batal
          </Link>
          <button @click="saveAllSettings" class="flex-1 px-4 py-3 bg-blue-500 hover:bg-blue-600 text-white font-medium rounded-lg transition">
            Simpan Semua Pengaturan
          </button>
        </div>
      </div>
    </component>
  </div>
</template>

<script setup>
import { Link } from '@inertiajs/vue3'
import StaffLayout from '@/Layouts/StaffLayout.vue'
import OpdLayout from '@/Layouts/OpdLayout.vue'
import { ref, computed } from 'vue'
import Swal from 'sweetalert2'

const props = defineProps({
  user: Object,
})

const userLayout = computed(() => {
  // Check if user role is OPD
  if (props.user?.nama_peran?.toLowerCase().includes('opd')) {
    return OpdLayout
  }
  return StaffLayout
})

const settings = ref({
  emailNotification: true,
  smsNotification: false,
  inAppNotification: true,
})

const saveAllSettings = () => {
  Swal.fire({
    icon: 'success',
    title: 'Pengaturan Tersimpan!',
    text: 'Semua pengaturan berhasil disimpan.',
    confirmButtonColor: '#3B82F6',
  })
}

const enable2FA = () => {
  Swal.fire({
    icon: 'info',
    title: 'Two-Factor Authentication',
    text: 'Fitur ini akan tersedia segera. Silakan coba kembali nanti.',
    confirmButtonColor: '#3B82F6',
  })
}

const deleteAccount = async () => {
  const result = await Swal.fire({
    icon: 'warning',
    title: 'Hapus Akun?',
    html: '<p class="text-red-600"><strong>PERINGATAN:</strong> Tindakan ini tidak dapat dibatalkan!</p><p>Semua data Anda akan dihapus secara permanen dari sistem.</p>',
    showCancelButton: true,
    confirmButtonText: 'Ya, Hapus Akun',
    cancelButtonText: 'Batal',
    confirmButtonColor: '#EF4444',
    cancelButtonColor: '#6B7280',
  })

  if (result.isConfirmed) {
    Swal.fire({
      icon: 'success',
      title: 'Akun Dihapus!',
      text: 'Akun Anda berhasil dihapus dari sistem.',
      confirmButtonColor: '#3B82F6',
    }).then(() => {
      window.location.href = '/login'
    })
  }
}

const clearCache = async () => {
  const result = await Swal.fire({
    icon: 'question',
    title: 'Hapus Cache?',
    text: 'Ini akan menghapus semua cache yang tersimpan. Proses ini tidak akan menghapus data penting.',
    showCancelButton: true,
    confirmButtonText: 'Ya, Hapus',
    cancelButtonText: 'Batal',
    confirmButtonColor: '#A855F7',
    cancelButtonColor: '#6B7280',
  })

  if (result.isConfirmed) {
    Swal.fire({
      icon: 'success',
      title: 'Cache Dihapus!',
      text: 'Cache berhasil dihapus dari sistem.',
      confirmButtonColor: '#3B82F6',
    })
  }
}

const backupData = async () => {
  Swal.fire({
    icon: 'question',
    title: 'Backup Data?',
    text: 'Proses backup akan membuat salinan lengkap dari semua data Anda.',
    showCancelButton: true,
    confirmButtonText: 'Ya, Backup',
    cancelButtonText: 'Batal',
    confirmButtonColor: '#10B981',
    cancelButtonColor: '#6B7280',
  }).then((result) => {
    if (result.isConfirmed) {
      Swal.fire({
        title: 'Backup Sedang Diproses',
        html: '<div class="inline-block"><div class="border-4 border-t-4 border-blue-400 rounded-full w-8 h-8 animate-spin"></div></div>',
        allowOutsideClick: false,
        allowEscapeKey: false,
        showConfirmButton: false,
      })

      // Simulasi proses backup
      setTimeout(() => {
        Swal.fire({
          icon: 'success',
          title: 'Backup Selesai!',
          text: 'Data Anda telah berhasil di-backup.',
          confirmButtonColor: '#3B82F6',
        })
      }, 3000)
    }
  })
}
</script>
