<template>
  <div class="min-h-screen bg-gray-50">
    <component :is="userLayout" :user="user">
      <div class="mb-8">
        <h2 class="text-2xl md:text-3xl font-bold text-gray-800">Ubah Password</h2>
        <p class="text-sm text-gray-500 mt-1">Perbarui keamanan akun Anda</p>
      </div>

      <div class="bg-white rounded-xl shadow-lg p-8 max-w-2xl">
        <form @submit.prevent="submitPasswordChange" class="space-y-6">
          <div>
            <label class="block text-gray-700 text-sm font-medium mb-2">Password Lama</label>
            <input 
              v-model="form.password_lama" 
              type="password" 
              class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-400"
              placeholder="Masukkan password lama"
            />
            <p v-if="errors.password_lama" class="text-red-500 text-sm mt-1">{{ errors.password_lama }}</p>
          </div>

          <div>
            <label class="block text-gray-700 text-sm font-medium mb-2">Password Baru</label>
            <input 
              v-model="form.password_baru" 
              type="password" 
              class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-400"
              placeholder="Masukkan password baru (minimal 6 karakter)"
            />
            <p v-if="errors.password_baru" class="text-red-500 text-sm mt-1">{{ errors.password_baru }}</p>
          </div>

          <div>
            <label class="block text-gray-700 text-sm font-medium mb-2">Konfirmasi Password</label>
            <input 
              v-model="form.password_baru_confirmation" 
              type="password" 
              class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-400"
              placeholder="Konfirmasi password baru"
            />
          </div>

          <div class="bg-blue-50 border border-blue-200 rounded-lg p-4">
            <p class="text-sm text-blue-700">
              <strong>Tips Keamanan:</strong> Gunakan password yang kuat dengan kombinasi huruf besar, huruf kecil, angka, dan simbol.
            </p>
          </div>

          <div class="flex gap-4 pt-4">
            <Link :href="route('home')" class="flex-1 px-4 py-3 bg-gray-300 hover:bg-gray-400 text-gray-800 font-medium rounded-lg transition text-center">
              Batal
            </Link>
            <button type="submit" class="flex-1 px-4 py-3 bg-blue-500 hover:bg-blue-600 text-white font-medium rounded-lg transition">
              Ubah Password
            </button>
          </div>
        </form>
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

const form = ref({
  password_lama: '',
  password_baru: '',
  password_baru_confirmation: '',
})

const errors = ref({})

const submitPasswordChange = async () => {
  errors.value = {}

  // Validasi frontend
  if (!form.value.password_lama) {
    errors.value.password_lama = 'Password lama harus diisi'
    return
  }

  if (!form.value.password_baru || form.value.password_baru.length < 6) {
    errors.value.password_baru = 'Password baru minimal 6 karakter'
    return
  }

  if (form.value.password_baru !== form.value.password_baru_confirmation) {
    errors.value.password_baru_confirmation = 'Konfirmasi password tidak sesuai'
    return
  }

  // Konfirmasi sebelum submit
  const result = await Swal.fire({
    icon: 'question',
    title: 'Ubah Password?',
    text: 'Apakah Anda yakin ingin mengubah password?',
    showCancelButton: true,
    confirmButtonText: 'Ya, Ubah',
    cancelButtonText: 'Batal',
    confirmButtonColor: '#3B82F6',
    cancelButtonColor: '#EF4444',
  })

  if (!result.isConfirmed) return

  // Submit ke backend
  try {
    // Placeholder untuk axios/fetch call
    Swal.fire({
      icon: 'success',
      title: 'Password Diubah!',
      text: 'Password Anda berhasil diperbarui.',
      confirmButtonColor: '#3B82F6',
    }).then(() => {
      form.value = {
        password_lama: '',
        password_baru: '',
        password_baru_confirmation: '',
      }
    })
  } catch (error) {
    Swal.fire({
      icon: 'error',
      title: 'Terjadi Kesalahan',
      text: 'Gagal mengubah password. Silakan coba lagi.',
      confirmButtonColor: '#EF4444',
    })
  }
}
</script>
