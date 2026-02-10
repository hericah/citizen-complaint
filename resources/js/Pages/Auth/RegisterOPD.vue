<template>
  <div class="min-h-screen flex items-center justify-center bg-gray-100 p-4">
    <div
      class="w-full max-w-sm md:max-w-md lg:max-w-lg bg-white rounded-2xl shadow-lg p-6 space-y-4"
    >
      <!-- Header Logo & Title -->
      <div class="flex items-center gap-2 border-b pb-3">
        <img src="/logo.png" alt="Logo" class="h-14 w-14 object-contain" />
        <div class="flex flex-col">
          <h1 class="font-bold text-gray-800 text-base leading-tight">E-Lapor</h1>
          <p class="text-gray-500 text-xs leading-tight">Pemkab Pemalang</p>
        </div>
      </div>

      <!-- Title -->
      <div class="text-center -mt-1">
        <h2 class="font-semibold text-gray-800 text-lg">REGISTRASI OPD</h2>
        <p class="text-gray-500 text-xs mt-1">Buat akun untuk mengelola pengaduan</p>
      </div>

      <!-- Error Message -->
      <div
        v-if="form.errors.error"
        class="p-3 bg-red-50 border border-red-200 text-red-700 rounded-xl text-sm"
      >
        {{ form.errors.error }}
      </div>

      <!-- Form -->
      <form @submit.prevent="submit" class="space-y-4">
        <!-- Pilih OPD -->
        <div>
          <label for="opd_id" class="block text-gray-700 text-sm font-medium mb-1.5">
            OPD <span class="text-red-500">*</span>
          </label>
          <select
            id="opd_id"
            v-model="form.opd_id"
            class="w-full rounded-lg border border-gray-300 py-3 px-4 focus:ring-2 focus:ring-purple-400 focus:border-purple-400"
            :class="{ 'border-red-500': form.errors.opd_id }"
          >
            <option value="">-- Pilih OPD --</option>
            <option v-for="opd in opdList" :key="opd.id" :value="opd.id">
              {{ opd.nama_opd }}
            </option>
          </select>
          <p v-if="form.errors.opd_id" class="text-red-500 text-xs mt-1">
            {{ form.errors.opd_id }}
          </p>
        </div>

        <!-- Info OPD Terpilih -->
        <div
          v-if="selectedOPD"
          class="bg-purple-50 border border-purple-200 rounded-lg p-3 text-sm"
        >
          <p class="text-purple-900"><strong>Nama:</strong> {{ selectedOPD.nama_opd }}</p>
          <p class="text-purple-900 mt-1">
            <strong>Telepon:</strong> {{ selectedOPD.no_telp }}
          </p>
          <p class="text-purple-900 mt-1">
            <strong>Alamat:</strong> {{ selectedOPD.alamat }}
          </p>
        </div>

        <!-- Email -->
        <div>
          <label for="email" class="block text-gray-700 text-sm font-medium mb-1.5">
            Email <span class="text-red-500">*</span>
          </label>
          <input
            id="email"
            v-model="form.email"
            type="email"
            class="w-full rounded-lg border border-gray-300 py-3 px-4 focus:ring-2 focus:ring-purple-400 focus:border-purple-400"
            :class="{ 'border-red-500': form.errors.email }"
            placeholder="email@opd.go.id"
            autocomplete="email"
          />
          <p v-if="form.errors.email" class="text-red-500 text-xs mt-1">
            {{ form.errors.email }}
          </p>
        </div>

        <!-- Password -->
        <div>
          <label for="password" class="block text-gray-700 text-sm font-medium mb-1.5">
            Password <span class="text-red-500">*</span>
          </label>
          <input
            id="password"
            v-model="form.password"
            type="password"
            class="w-full rounded-lg border border-gray-300 py-3 px-4 focus:ring-2 focus:ring-purple-400 focus:border-purple-400"
            :class="{ 'border-red-500': form.errors.password }"
            placeholder="Minimal 6 karakter"
            autocomplete="new-password"
          />
          <p v-if="form.errors.password" class="text-red-500 text-xs mt-1">
            {{ form.errors.password }}
          </p>
        </div>

        <!-- Konfirmasi Password -->
        <div>
          <label
            for="password_confirmation"
            class="block text-gray-700 text-sm font-medium mb-1.5"
          >
            Konfirmasi Password <span class="text-red-500">*</span>
          </label>
          <input
            id="password_confirmation"
            v-model="form.password_confirmation"
            type="password"
            class="w-full rounded-lg border border-gray-300 py-3 px-4 focus:ring-2 focus:ring-purple-400 focus:border-purple-400"
            placeholder="Ulangi password"
            autocomplete="new-password"
          />
        </div>

        <!-- Buttons -->
        <div class="flex gap-3 mt-6">
          <Link
            href="/register"
            class="flex-1 bg-gray-300 hover:bg-gray-400 text-gray-800 font-semibold rounded-full py-3 transition text-center"
          >
            Kembali
          </Link>
          <button
            type="submit"
            :disabled="form.processing"
            class="flex-1 bg-purple-500 hover:bg-purple-600 text-white font-semibold rounded-full py-3 transition disabled:opacity-50 disabled:cursor-not-allowed"
          >
            <span v-if="form.processing">Memproses...</span>
            <span v-else>Daftar</span>
          </button>
        </div>
      </form>

      <!-- Login Link -->
      <div class="text-center pt-2">
        <p class="text-gray-600 text-sm">
          Sudah punya akun?
          <Link href="/login" class="text-purple-600 hover:text-purple-700 font-semibold">
            Login sekarang
          </Link>
        </p>
      </div>
    </div>
  </div>
</template>

<script setup>
import { useForm, Link } from "@inertiajs/vue3";
import Swal from "sweetalert2";
import { computed } from "vue";

defineProps({
  opdList: Array,
});

const form = useForm({
  opd_id: null,
  email: '',
  password: '',
  password_confirmation: '',
});

const selectedOPD = computed(() => {
  if (!form.opd_id) return null;
  return opdList.find(opd => Number(opd.id) === Number(form.opd_id));
});

const submit = () => {
  // Ensure opd_id is an integer
  const submitData = {
    ...form.data(),
    opd_id: Number(form.opd_id),
  };
  
  form.post('/register/opd', {
    preserveScroll: true,
    data: submitData,
    onSuccess: (response) => {
      Swal.fire({
        icon: 'success',
        title: 'Registrasi Berhasil!',
        text: 'Akun OPD Anda telah berhasil dibuat. Silakan login untuk melanjutkan.',
        confirmButtonText: 'Login Sekarang',
        confirmButtonColor: '#A855F7',
        allowOutsideClick: false,
      }).then((result) => {
        if (result.isConfirmed) {
          window.location.href = '/login';
        }
      });
    },
    onError: () => {
      form.password = '';
      form.password_confirmation = '';
    },
  });
};
</script>
