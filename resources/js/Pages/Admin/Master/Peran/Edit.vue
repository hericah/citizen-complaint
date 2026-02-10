<template>
  <div class="min-h-screen bg-gray-50">
    <StaffLayout :user="user">
      <div class="mb-8">
        <div class="flex items-start justify-between">
          <div>
            <h2 class="text-2xl md:text-3xl font-bold text-gray-800">Edit Peran</h2>
            <p class="text-sm text-gray-500 mt-1">Perbarui nama peran</p>
          </div>
          <Link href="/master/peran" class="px-6 py-3 bg-gray-500 hover:bg-gray-600 text-white font-medium rounded-xl transition">
            Kembali
          </Link>
        </div>
      </div>

      <!-- Form -->
      <div class="bg-white rounded-xl shadow-lg p-8 max-w-2xl">
        <form @submit.prevent="submit" class="space-y-6">
          <!-- Nama Peran -->
          <div>
            <label class="block text-gray-700 text-sm font-medium mb-2">Nama Peran</label>
            <input v-model="form.nama_peran" type="text" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-400" :class="{ 'border-red-500': form.errors.nama_peran }" />
            <p v-if="form.errors.nama_peran" class="text-red-500 text-xs mt-1">{{ form.errors.nama_peran }}</p>
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
  peran: Object,
})

const form = useForm({
  nama_peran: props.peran.nama_peran,
})

const submit = () => {
  form.put(`/master/peran/${props.peran.id}`)
}
</script>
