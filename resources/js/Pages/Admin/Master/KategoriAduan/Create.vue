<template>
  <div class="min-h-screen bg-gray-50">
    <StaffLayout :user="user">
      <div class="mb-8">
        <div class="flex items-start justify-between">
          <div>
            <h2 class="text-2xl md:text-3xl font-bold text-gray-800">Tambah Kategori Aduan Baru</h2>
            <p class="text-sm text-gray-500 mt-1">Buat kategori aduan baru</p>
          </div>
          <Link href="/master/kategori" class="px-6 py-3 bg-gray-500 hover:bg-gray-600 text-white font-medium rounded-xl transition">
            Kembali
          </Link>
        </div>
      </div>

      <!-- Form -->
      <div class="bg-white rounded-xl shadow-lg p-8 max-w-2xl">
        <form @submit.prevent="submit" class="space-y-6">
          <!-- Nama Kategori -->
          <div>
            <label class="block text-gray-700 text-sm font-medium mb-2">Nama Kategori</label>
            <input v-model="form.nama_kategori" type="text" placeholder="contoh: Infrastruktur Jalan" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-400" :class="{ 'border-red-500': form.errors.nama_kategori }" />
            <p v-if="form.errors.nama_kategori" class="text-red-500 text-xs mt-1">{{ form.errors.nama_kategori }}</p>
          </div>

          <!-- Keterangan -->
          <div>
            <label class="block text-gray-700 text-sm font-medium mb-2">Keterangan</label>
            <textarea v-model="form.keterangan" rows="5" placeholder="Masukkan keterangan kategori..." class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-400" :class="{ 'border-red-500': form.errors.keterangan }"></textarea>
            <p v-if="form.errors.keterangan" class="text-red-500 text-xs mt-1">{{ form.errors.keterangan }}</p>
          </div>

          <!-- Submit -->
          <button type="submit" :disabled="form.processing" class="w-full px-4 py-3 bg-blue-500 hover:bg-blue-600 text-white font-medium rounded-lg transition disabled:opacity-50">
            {{ form.processing ? 'Menyimpan...' : 'Simpan' }}
          </button>
        </form>
      </div>
    </StaffLayout>
  </div>
</template>

<script setup>
import { Link, useForm } from '@inertiajs/vue3'
import StaffLayout from '@/Layouts/StaffLayout.vue'

defineProps({
  user: Object,
})

const form = useForm({
  nama_kategori: '',
  keterangan: '',
})

const submit = () => {
  form.post('/master/kategori')
}
</script>
