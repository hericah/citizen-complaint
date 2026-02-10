<template>
  <div class="min-h-screen bg-gray-50">
    <StaffLayout :user="user">
      <div class="mb-8">
        <div class="flex items-start justify-between">
          <div>
            <h2 class="text-2xl md:text-3xl font-bold text-gray-800">Master Pengguna</h2>
            <p class="text-sm text-gray-500 mt-1">Kelola data pengguna sistem</p>
          </div>
          <Link href="/master/pengguna/create" class="px-6 py-3 bg-blue-500 hover:bg-blue-600 text-white font-medium rounded-xl transition">
            Tambah Pengguna
          </Link>
        </div>
      </div>

      <!-- Table -->
      <div class="bg-white rounded-xl shadow-lg overflow-hidden">
        <div class="px-6 py-4 border-b border-gray-200">
          <h3 class="text-lg font-bold text-gray-800">Daftar Pengguna</h3>
        </div>

        <div class="overflow-x-auto">
          <table class="w-full">
            <thead class="bg-gray-50">
              <tr>
                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Nama Pengguna</th>
                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Email</th>
                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Peran</th>
                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Status</th>
                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Aksi</th>
              </tr>
            </thead>
            <tbody class="divide-y divide-gray-200">
              <tr v-for="user in pengguna.data" :key="user.id" class="hover:bg-gray-50 transition">
                <td class="px-6 py-4 text-sm font-medium text-gray-900">{{ user.nama_pengguna }}</td>
                <td class="px-6 py-4 text-sm text-gray-600">{{ user.email }}</td>
                <td class="px-6 py-4 text-sm">
                  <div class="flex gap-1">
                    <span v-for="role in user.peran" :key="role.id" class="px-2 py-1 bg-blue-100 text-blue-800 text-xs rounded-full">
                      {{ role.nama_peran }}
                    </span>
                  </div>
                </td>
                <td class="px-6 py-4 text-sm">
                  <span :class="user.status_aktif ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-800'" class="px-3 py-1 inline-flex text-xs rounded-full font-semibold">
                    {{ user.status_aktif ? 'Aktif' : 'Nonaktif' }}
                  </span>
                </td>
                <td class="px-6 py-4 text-sm space-x-2">
                  <Link :href="`/master/pengguna/${user.id}/edit`" class="text-blue-600 hover:text-blue-800 font-medium">Edit</Link>
                  <button @click="deleteUser(user.id)" class="text-red-600 hover:text-red-800 font-medium">Hapus</button>
                </td>
              </tr>
            </tbody>
          </table>
        </div>

        <!-- Pagination -->
        <div class="px-6 py-4 bg-gray-50 border-t border-gray-200 flex items-center justify-between">
          <p class="text-sm text-gray-600">
            Menampilkan {{ pengguna.from }} hingga {{ pengguna.to }} dari {{ pengguna.total }} pengguna
          </p>
          <div class="flex gap-2">
            <Link v-if="pengguna.prev_page_url" :href="pengguna.prev_page_url" class="px-3 py-1 text-sm bg-white border border-gray-300 rounded-lg hover:bg-gray-50">Sebelumnya</Link>
            <Link v-if="pengguna.next_page_url" :href="pengguna.next_page_url" class="px-3 py-1 text-sm bg-yellow-500 text-white rounded-lg hover:bg-yellow-600">Berikutnya</Link>
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
  pengguna: Object,
})

const deleteUser = (id) => {
  Swal.fire({
    title: 'Hapus Pengguna?',
    text: 'Data tidak bisa dikembalikan!',
    icon: 'warning',
    showCancelButton: true,
    confirmButtonColor: '#d33',
    cancelButtonColor: '#3085d6',
    confirmButtonText: 'Ya, hapus!'
  }).then((result) => {
    if (result.isConfirmed) {
      router.delete(`/master/pengguna/${id}`)
    }
  })
}
</script>
