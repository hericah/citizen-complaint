<template>
  <div class="min-h-screen bg-gray-50">
    <component :is="userLayout" :user="user">
      <div class="mb-8">
        <h2 class="text-2xl md:text-3xl font-bold text-gray-800">Pengaturan Akun</h2>
        <p class="text-sm text-gray-500 mt-1">Kelola profil dan keamanan akun Anda</p>
      </div>

      <!-- Tab Navigation -->
      <div class="bg-white rounded-xl shadow-lg border-b border-gray-200">
        <div class="flex flex-wrap">
          <button
            @click="activeTab = 'profil'"
            :class="[
              'px-6 py-4 font-medium text-sm border-b-2 transition',
              activeTab === 'profil'
                ? 'text-blue-600 border-blue-600'
                : 'text-gray-600 border-transparent hover:text-gray-800',
            ]"
          >
            Profil
          </button>
          <button
            @click="activeTab = 'password'"
            :class="[
              'px-6 py-4 font-medium text-sm border-b-2 transition',
              activeTab === 'password'
                ? 'text-blue-600 border-blue-600'
                : 'text-gray-600 border-transparent hover:text-gray-800',
            ]"
          >
            Ubah Password
          </button>
          <button
            @click="activeTab = 'sistem'"
            :class="[
              'px-6 py-4 font-medium text-sm border-b-2 transition',
              activeTab === 'sistem'
                ? 'text-blue-600 border-blue-600'
                : 'text-gray-600 border-transparent hover:text-gray-800',
            ]"
          >
            Pengaturan Sistem
          </button>
        </div>
      </div>

      <!-- Tab Content: Profil -->
      <div v-if="activeTab === 'profil'" class="mt-8">
        <div class="bg-white rounded-xl shadow-lg p-8 max-w-2xl">
          <h3 class="text-lg font-bold text-gray-800 mb-6">Informasi Profil</h3>
          <form @submit.prevent="updateProfil" class="space-y-6">
            <div>
              <label class="block text-gray-700 text-sm font-medium mb-2">Nama Pengguna</label>
              <input v-model="formProfil.nama_pengguna" type="text" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-400" />
            </div>

            <div>
              <label class="block text-gray-700 text-sm font-medium mb-2">Email</label>
              <input v-model="formProfil.email" type="email" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-400" />
            </div>

            <div>
              <button type="submit" class="w-full px-4 py-3 bg-blue-500 hover:bg-blue-600 text-white font-medium rounded-lg transition">
                Simpan Profil
              </button>
            </div>
          </form>
        </div>
      </div>

      <!-- Tab Content: Ubah Password -->
      <div v-if="activeTab === 'password'" class="mt-8">
        <div class="bg-white rounded-xl shadow-lg p-8 max-w-2xl">
          <h3 class="text-lg font-bold text-gray-800 mb-6">Ubah Password</h3>
          <form @submit.prevent="updatePassword" class="space-y-6">
            <div>
              <label class="block text-gray-700 text-sm font-medium mb-2">Password Lama</label>
              <input v-model="formPassword.password_lama" type="password" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-400" />
            </div>

            <div>
              <label class="block text-gray-700 text-sm font-medium mb-2">Password Baru</label>
              <input v-model="formPassword.password_baru" type="password" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-400" />
            </div>

            <div>
              <label class="block text-gray-700 text-sm font-medium mb-2">Konfirmasi Password</label>
              <input v-model="formPassword.password_baru_confirmation" type="password" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-400" />
            </div>

            <div class="bg-blue-50 border border-blue-200 rounded-lg p-4">
              <p class="text-sm text-blue-700">
                Password minimal 6 karakter dan harus berbeda dengan password sebelumnya.
              </p>
            </div>

            <div>
              <button type="submit" class="w-full px-4 py-3 bg-blue-500 hover:bg-blue-600 text-white font-medium rounded-lg transition">
                Ubah Password
              </button>
            </div>
          </form>
        </div>
      </div>

      <!-- Tab Content: Pengaturan Sistem -->
      <div v-if="activeTab === 'sistem'" class="mt-8">
        <div class="bg-white rounded-xl shadow-lg p-8 max-w-2xl">
          <h3 class="text-lg font-bold text-gray-800 mb-6">Pengaturan Sistem</h3>
          <div class="space-y-6">
            <div class="flex items-center justify-between">
              <div>
                <p class="text-gray-800 font-medium">Notifikasi Email</p>
                <p class="text-sm text-gray-500 mt-1">Terima notifikasi aduan melalui email</p>
              </div>
              <label class="relative inline-flex items-center cursor-pointer">
                <input v-model="settings.notifEmail" type="checkbox" class="sr-only peer" />
                <div class="w-11 h-6 bg-gray-200 peer-focus:outline-none peer-focus:ring-4 peer-focus:ring-blue-300 rounded-full peer peer-checked:after:translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-[2px] after:left-[2px] after:bg-white after:border-gray-300 after:border after:rounded-full after:h-5 after:w-5 after:transition-all peer-checked:bg-blue-600"></div>
              </label>
            </div>

            <div class="flex items-center justify-between">
              <div>
                <p class="text-gray-800 font-medium">Notifikasi SMS</p>
                <p class="text-sm text-gray-500 mt-1">Terima notifikasi aduan melalui SMS</p>
              </div>
              <label class="relative inline-flex items-center cursor-pointer">
                <input v-model="settings.notifSms" type="checkbox" class="sr-only peer" />
                <div class="w-11 h-6 bg-gray-200 peer-focus:outline-none peer-focus:ring-4 peer-focus:ring-blue-300 rounded-full peer peer-checked:after:translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-[2px] after:left-[2px] after:bg-white after:border-gray-300 after:border after:rounded-full after:h-5 after:w-5 after:transition-all peer-checked:bg-blue-600"></div>
              </label>
            </div>

            <hr class="border-gray-200" />

            <div>
              <p class="text-gray-800 font-medium mb-3">Versi Sistem</p>
              <p class="text-sm text-gray-600">E-Lapor v1.0.0</p>
            </div>

            <div>
              <button @click="saveSetting" class="w-full px-4 py-3 bg-blue-500 hover:bg-blue-600 text-white font-medium rounded-lg transition">
                Simpan Pengaturan
              </button>
            </div>
          </div>
        </div>
      </div>
    </component>
  </div>
</template>

<script setup>
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

const activeTab = ref('profil')

const formProfil = ref({
  nama_pengguna: '',
  email: '',
})

const formPassword = ref({
  password_lama: '',
  password_baru: '',
  password_baru_confirmation: '',
})

const settings = ref({
  notifEmail: true,
  notifSms: false,
})

const updateProfil = () => {
  Swal.fire({
    icon: 'success',
    title: 'Profil Diperbarui!',
    text: 'Data profil Anda berhasil disimpan.',
    confirmButtonColor: '#3B82F6',
  })
}

const updatePassword = () => {
  Swal.fire({
    icon: 'success',
    title: 'Password Diubah!',
    text: 'Password Anda berhasil diperbarui.',
    confirmButtonColor: '#3B82F6',
  })
}

const saveSetting = () => {
  Swal.fire({
    icon: 'success',
    title: 'Pengaturan Disimpan!',
    text: 'Pengaturan sistem berhasil disimpan.',
    confirmButtonColor: '#3B82F6',
  })
}
</script>
