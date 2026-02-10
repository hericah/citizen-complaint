<template>
  <div class="min-h-screen bg-gray-50">
    <StaffLayout :user="user">
      <div class="mb-8">
        <div class="flex items-start justify-between">
          <div>
            <h2 class="text-2xl md:text-3xl font-bold text-gray-800">Master Akses Aduan</h2>
            <p class="text-sm text-gray-500 mt-1">Kelola tingkat akses aduan</p>
          </div>
          <Link href="/master/aksesaduan/create" class="px-6 py-3 bg-blue-500 hover:bg-blue-600 text-white font-medium rounded-xl transition">
            Tambah Akses
          </Link>
        </div>
      </div>

      <!-- Table -->
      <div class="bg-white rounded-xl shadow-lg overflow-hidden">
        <div class="px-6 py-4 border-b border-gray-200">
          <h3 class="text-lg font-bold text-gray-800">Daftar Akses Aduan</h3>
        </div>

        <div class="overflow-x-auto">
          <table class="w-full">
            <thead class="bg-gray-50">
              <tr>
                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Nama Akses</th>
                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Keterangan</th>
                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Tanggal Dibuat</th>
                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Aksi</th>
              </tr>
            </thead>
            <tbody class="divide-y divide-gray-200">
              <tr v-for="akses in aksesAduan.data" :key="akses.id" class="hover:bg-gray-50 transition">
                <td class="px-6 py-4 text-sm font-medium text-gray-900">{{ akses.nama_akses_aduan }}</td>
                <td class="px-6 py-4 text-sm text-gray-600">{{ akses.keterangan.substring(0, 50) }}...</td>
                <td class="px-6 py-4 text-sm text-gray-600">{{ new Date(akses.tanggal_dibuat).toLocaleDateString('id-ID') }}</td>
                <td class="px-6 py-4 text-sm space-x-2">
                  <Link :href="`/master/aksesaduan/${akses.id}/edit`" class="text-blue-600 hover:text-blue-800 font-medium">Edit</Link>
                  <button @click="deleteAkses(akses.id)" class="text-red-600 hover:text-red-800 font-medium">Hapus</button>
                </td>
              </tr>
            </tbody>
          </table>
        </div>

        <!-- Pagination -->
        <div class="px-6 py-4 bg-gray-50 border-t border-gray-200 flex items-center justify-between">
          <p class="text-sm text-gray-600">
            Menampilkan {{ aksesAduan.from }} hingga {{ aksesAduan.to }} dari {{ aksesAduan.total }} akses
          </p>
          <div class="flex gap-2">
            <Link v-if="aksesAduan.prev_page_url" :href="aksesAduan.prev_page_url" class="px-3 py-1 text-sm bg-white border border-gray-300 rounded-lg hover:bg-gray-50">Sebelumnya</Link>
            <Link v-if="aksesAduan.next_page_url" :href="aksesAduan.next_page_url" class="px-3 py-1 text-sm bg-yellow-500 text-white rounded-lg hover:bg-yellow-600">Berikutnya</Link>
          </div>
        </div>
      </div>
    </StaffLayout>
  </div>
</template>

<script setup>
import { Link } from '@inertiajs/vue3'
import StaffLayout from '@/Layouts/StaffLayout.vue'
import Swal from 'sweetalert2'
import { router } from '@inertiajs/vue3'

defineProps({
  user: Object,
  aksesAduan: Object,
})

const deleteAkses = (id) => {
  Swal.fire({
    title: 'Hapus Akses Aduan?',
    text: 'Data tidak bisa dikembalikan!',
    icon: 'warning',
    showCancelButton: true,
    confirmButtonColor: '#d33',
    cancelButtonColor: '#3085d6',
    confirmButtonText: 'Ya, hapus!'
  }).then((result) => {
    if (result.isConfirmed) {
      router.delete(`/master/aksesaduan/${id}`)
    }
  })
}
</script>
