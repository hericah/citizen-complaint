<template>
  <div class="min-h-screen bg-gray-50">
    <StaffLayout :user="user">
      <div class="mb-8">
        <div class="flex items-start justify-between">
          <div>
            <h2 class="text-2xl md:text-3xl font-bold text-gray-800">Edit OPD</h2>
            <p class="text-sm text-gray-500 mt-1">Perbarui data OPD</p>
          </div>
          <Link
            href="/master/opd"
            class="px-6 py-3 bg-gray-500 hover:bg-gray-600 text-white font-medium rounded-xl transition"
          >
            Kembali
          </Link>
        </div>
      </div>

      <!-- Form -->
      <div class="bg-white rounded-xl shadow-lg p-8 max-w-2xl">
        <form @submit.prevent="submit" class="space-y-6">
          <!-- Nama OPD -->
          <div>
            <label class="block text-gray-700 text-sm font-medium mb-2">Nama OPD</label>
            <input
              v-model="form.nama_opd"
              type="text"
              placeholder="Contoh: Dinas Pendidikan"
              class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-400"
              :class="{ 'border-red-500': form.errors.nama_opd }"
            />
            <p v-if="form.errors.nama_opd" class="text-red-500 text-xs mt-1">
              {{ form.errors.nama_opd }}
            </p>
          </div>

          <!-- No. Telepon -->
          <div>
            <label class="block text-gray-700 text-sm font-medium mb-2"
              >No. Telepon</label
            >
            <input
              v-model="form.no_telp"
              type="tel"
              placeholder="Contoh: 0274-123456"
              class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-400"
              :class="{ 'border-red-500': form.errors.no_telp }"
            />
            <p v-if="form.errors.no_telp" class="text-red-500 text-xs mt-1">
              {{ form.errors.no_telp }}
            </p>
          </div>

          <!-- Alamat -->
          <div>
            <label class="block text-gray-700 text-sm font-medium mb-2">Alamat</label>
            <textarea
              v-model="form.alamat"
              rows="4"
              placeholder="Masukkan alamat lengkap OPD"
              class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-400 resize-none"
              :class="{ 'border-red-500': form.errors.alamat }"
            ></textarea>
            <p v-if="form.errors.alamat" class="text-red-500 text-xs mt-1">
              {{ form.errors.alamat }}
            </p>
          </div>

          <!-- Info -->
          <div class="bg-blue-50 border border-blue-200 rounded-lg p-4">
            <p class="text-sm text-blue-700">
              <strong>Informasi:</strong> Terakhir diubah
              {{ formatDate(opd.tanggal_diubah) }}
            </p>
          </div>

          <!-- Submit -->
          <div class="flex gap-3">
            <button
              type="button"
              @click="deleteOPD"
              class="flex-1 px-4 py-3 bg-red-500 hover:bg-red-600 text-white font-medium rounded-lg transition"
            >
              Hapus OPD
            </button>
            <button
              type="submit"
              :disabled="form.processing"
              class="flex-1 px-4 py-3 bg-blue-500 hover:bg-blue-600 text-white font-medium rounded-lg transition disabled:opacity-50"
            >
              {{ form.processing ? "Menyimpan..." : "Simpan Perubahan" }}
            </button>
          </div>
        </form>
      </div>
    </StaffLayout>
  </div>
</template>

<script setup>
import { Link, useForm, router } from "@inertiajs/vue3";
import StaffLayout from "@/Layouts/StaffLayout.vue";
import Swal from "sweetalert2";

const props = defineProps({
  user: Object,
  opd: Object,
});

const form = useForm({
  nama_opd: props.opd.nama_opd,
  no_telp: props.opd.no_telp,
  alamat: props.opd.alamat,
});

const formatDate = (date) => {
  return new Date(date).toLocaleDateString("id-ID", {
    year: "numeric",
    month: "long",
    day: "numeric",
    hour: "2-digit",
    minute: "2-digit",
  });
};

const submit = () => {
  form.put(`/master/opd/${props.opd.id}`, {
    onSuccess: () => {
      Swal.fire({
        icon: "success",
        title: "OPD Berhasil Diperbarui!",
        text: "Data OPD telah disimpan ke sistem.",
        confirmButtonColor: "#3B82F6",
      }).then(() => {
        window.location.href = "/master/opd";
      });
    },
    onError: () => {
      Swal.fire({
        icon: "error",
        title: "Gagal Menyimpan",
        text: "Terjadi kesalahan saat menyimpan OPD. Silakan coba lagi.",
        confirmButtonColor: "#EF4444",
      });
    },
  });
};

const deleteOPD = async () => {
  const result = await Swal.fire({
    title: "Hapus OPD?",
    text: "Data tidak bisa dikembalikan!",
    icon: "warning",
    showCancelButton: true,
    confirmButtonColor: "#EF4444",
    cancelButtonColor: "#6B7280",
    confirmButtonText: "Ya, hapus!",
  });

  if (result.isConfirmed) {
    router.delete(`/master/opd/${props.opd.id}`);
  }
};
</script>
