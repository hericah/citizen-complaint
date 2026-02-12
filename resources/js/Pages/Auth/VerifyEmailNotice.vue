<template>
  <div class="min-h-screen flex items-center justify-center bg-gray-100 p-4">
    <div class="w-full max-w-sm md:max-w-md lg:max-w-lg bg-white rounded-2xl shadow-lg p-6 space-y-6 text-center">
      <!-- Header Logo & Title -->
      <div class="flex flex-col items-center gap-2 border-b pb-4">
        <img src="/logo.png" alt="Logo" class="h-16 w-16 object-contain" />
        <div class="flex flex-col">
          <h1 class="font-bold text-gray-800 text-lg leading-tight">E-Lapor</h1>
          <p class="text-gray-500 text-sm leading-tight">Pemkab Pemalang</p>
        </div>
      </div>

      <!-- Icon -->
      <div class="flex justify-center">
        <div class="bg-green-100 p-4 rounded-full">
            <svg class="w-16 h-16 text-green-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z" />
            </svg>
        </div>
      </div>

      <!-- Content -->
      <div class="space-y-3">
        <h2 class="font-bold text-gray-800 text-xl">Cek Email Anda</h2>
        <p class="text-gray-600 text-sm leading-relaxed">
            Terima kasih telah mendaftar! Kami telah mengirimkan tautan verifikasi ke alamat email Anda.
            Silakan periksa kotak masuk (atau folder spam) dan klik tautan tersebut untuk mengaktifkan akun Anda.
        </p>
      </div>

      <!-- Action Button -->
       <div>
        <Link
            href="/login"
            class="inline-block w-full bg-yellow-400 hover:bg-yellow-500 text-gray-900 font-bold rounded-full py-3 transition duration-200"
        >
            Kembali ke Halaman Login
        </Link>
       </div>

      <!-- Footer -->
      <div class="text-center pt-2 border-t text-xs text-gray-400">
        &copy; {{ new Date().getFullYear() }} E-Lapor Pemkab Pemalang
      </div>
    </div>
  </div>
</template>

<script setup>
import { Link } from '@inertiajs/vue3';
</script>
