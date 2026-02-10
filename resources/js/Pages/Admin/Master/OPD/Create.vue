<template>
  <div class="min-h-screen bg-gray-50">
    <StaffLayout :user="user">
      <div class="mb-8">
        <div class="flex items-start justify-between">
          <div>
            <h2 class="text-2xl md:text-3xl font-bold text-gray-800">Tambah OPD Baru</h2>
            <p class="text-sm text-gray-500 mt-1">
              Isi form di bawah untuk menambahkan OPD baru
            </p>
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

          <!-- Submit -->
          <button
            type="submit"
            :disabled="form.processing"
            class="w-full px-4 py-3 bg-blue-500 hover:bg-blue-600 text-white font-medium rounded-lg transition disabled:opacity-50"
          >
            {{ form.processing ? "Menyimpan..." : "Simpan OPD" }}
          </button>
        </form>
      </div>
    </StaffLayout>
  </div>
</template>

<script setup>
import { Link, useForm } from "@inertiajs/vue3";
import StaffLayout from "@/Layouts/StaffLayout.vue";
import Swal from "sweetalert2";

defineProps({
  user: Object,
});

const form = useForm({
  nama_opd: "",
  no_telp: "",
  alamat: "",
});

const submit = () => {
  form.post("/master/opd", {
    onSuccess: () => {
      Swal.fire({
        icon: "success",
        title: "OPD Berhasil Ditambahkan!",
        text: "Data OPD baru telah disimpan ke sistem.",
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
</script>
