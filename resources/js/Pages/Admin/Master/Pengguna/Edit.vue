<template>
  <div class="min-h-screen bg-gray-50">
    <StaffLayout :user="user">
      <div class="mb-8">
        <div class="flex items-start justify-between">
          <div>
            <h2 class="text-2xl md:text-3xl font-bold text-gray-800">Edit Pengguna</h2>
            <p class="text-sm text-gray-500 mt-1">Perbarui data pengguna</p>
          </div>
          <Link href="/master/pengguna" class="px-6 py-3 bg-gray-500 hover:bg-gray-600 text-white font-medium rounded-xl transition">
            Kembali
          </Link>
        </div>
      </div>

      <!-- Form -->
      <div class="bg-white rounded-xl shadow-lg p-8 max-w-2xl">
        <form @submit.prevent="submit" class="space-y-6">
          <!-- Nama Pengguna -->
          <div>
            <label class="block text-gray-700 text-sm font-medium mb-2">Nama Pengguna</label>
            <input v-model="form.nama_pengguna" type="text" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-400" :class="{ 'border-red-500': form.errors.nama_pengguna }" />
            <p v-if="form.errors.nama_pengguna" class="text-red-500 text-xs mt-1">{{ form.errors.nama_pengguna }}</p>
          </div>

          <!-- Email -->
          <div>
            <label class="block text-gray-700 text-sm font-medium mb-2">Email</label>
            <input v-model="form.email" type="email" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-400" :class="{ 'border-red-500': form.errors.email }" />
            <p v-if="form.errors.email" class="text-red-500 text-xs mt-1">{{ form.errors.email }}</p>
          </div>

          <!-- Peran -->
          <div>
            <label class="block text-gray-700 text-sm font-medium mb-2">Peran</label>
            <div class="space-y-2">
              <label v-for="role in peran" :key="role.id" class="flex items-center gap-2">
                <input v-model="form.peran_ids" type="checkbox" :value="role.id" class="w-4 h-4" />
                <span class="text-gray-700">{{ role.nama_peran }}</span>
              </label>
            </div>
          </div>

          <!-- Status -->
          <div>
            <label class="flex items-center gap-2">
              <input v-model="form.status_aktif" type="checkbox" class="w-4 h-4" />
              <span class="text-gray-700 text-sm font-medium">Aktif</span>
            </label>
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

const props = defineProps({
  user: Object,
  pengguna: Object,
  peran: Array,
  selectedPeran: Array,
})

const form = useForm({
  nama_pengguna: props.pengguna.nama_pengguna,
  email: props.pengguna.email,
  status_aktif: props.pengguna.status_aktif,
  peran_ids: props.selectedPeran,
})

const submit = () => {
  form.put(`/master/pengguna/${props.pengguna.id}`)
}
</script>
