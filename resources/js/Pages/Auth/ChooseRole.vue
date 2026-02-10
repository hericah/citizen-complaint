<template>
  <div
    class="min-h-screen flex items-center justify-center bg-gradient-to-br from-blue-50 to-indigo-100 p-4"
  >
    <div class="w-full max-w-2xl">
      <!-- Header -->
      <div class="text-center mb-12">
        <div class="flex items-center justify-center gap-3 mb-4">
          <img src="/logo.png" alt="Logo" class="h-16 w-16 object-contain" />
          <div class="flex flex-col">
            <h1 class="font-bold text-gray-800 text-2xl">E-Lapor</h1>
            <p class="text-gray-500 text-sm">Pemkab Pemalang</p>
          </div>
        </div>
        <h2 class="font-semibold text-gray-800 text-2xl mb-2">Pilih Tipe Akun</h2>
        <p class="text-gray-600">Daftar sebagai Masyarakat atau OPD</p>
      </div>

      <!-- Role Selection Cards -->
      <div class="grid md:grid-cols-2 gap-6 mb-8">
        <!-- Masyarakat Card -->
        <Link href="/register/masyarakat" class="block">
          <div
            class="bg-white rounded-2xl shadow-lg p-8 hover:shadow-xl transition duration-300 cursor-pointer border-2 border-transparent hover:border-blue-400"
          >
            <div class="text-center">
              <!-- Icon -->
              <div
                class="w-20 h-20 bg-blue-100 rounded-full flex items-center justify-center mx-auto mb-4"
              >
                <svg
                  class="w-10 h-10 text-blue-600"
                  fill="none"
                  stroke="currentColor"
                  viewBox="0 0 24 24"
                >
                  <path
                    stroke-linecap="round"
                    stroke-linejoin="round"
                    stroke-width="2"
                    d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"
                  ></path>
                </svg>
              </div>

              <!-- Title -->
              <h3 class="text-xl font-semibold text-gray-800 mb-3">Masyarakat</h3>

              <!-- Description -->
              <p class="text-gray-600 text-sm mb-4">
                Buat laporan pengaduan dan pantau status penyelesaiannya secara real-time
              </p>

              <!-- Benefits -->
              <ul class="text-left space-y-2 mb-6">
                <li class="flex items-start gap-2 text-sm text-gray-600">
                  <span class="text-blue-500 mt-1">✓</span>
                  <span>Lapor masalah dengan mudah</span>
                </li>
                <li class="flex items-start gap-2 text-sm text-gray-600">
                  <span class="text-blue-500 mt-1">✓</span>
                  <span>Pantau progress aduan</span>
                </li>
                <li class="flex items-start gap-2 text-sm text-gray-600">
                  <span class="text-blue-500 mt-1">✓</span>
                  <span>Terima feedback & respons</span>
                </li>
              </ul>

              <!-- Button -->
              <button
                class="w-full bg-blue-500 hover:bg-blue-600 text-white font-semibold py-3 rounded-lg transition"
              >
                Daftar sebagai Masyarakat
              </button>
            </div>
          </div>
        </Link>

        <!-- OPD Card -->
        <Link href="/register/opd" class="block">
          <div
            class="bg-white rounded-2xl shadow-lg p-8 hover:shadow-xl transition duration-300 cursor-pointer border-2 border-transparent hover:border-purple-400"
          >
            <div class="text-center">
              <!-- Icon -->
              <div
                class="w-20 h-20 bg-purple-100 rounded-full flex items-center justify-center mx-auto mb-4"
              >
                <svg
                  class="w-10 h-10 text-purple-600"
                  fill="none"
                  stroke="currentColor"
                  viewBox="0 0 24 24"
                >
                  <path
                    stroke-linecap="round"
                    stroke-linejoin="round"
                    stroke-width="2"
                    d="M19 21H5a2 2 0 01-2-2V5a2 2 0 012-2h11l5 5v11a2 2 0 01-2 2z"
                  ></path>
                </svg>
              </div>

              <!-- Title -->
              <h3 class="text-xl font-semibold text-gray-800 mb-3">OPD</h3>

              <!-- Description -->
              <p class="text-gray-600 text-sm mb-4">
                Kelola dan proses pengaduan dari masyarakat dengan mudah
              </p>

              <!-- Benefits -->
              <ul class="text-left space-y-2 mb-6">
                <li class="flex items-start gap-2 text-sm text-gray-600">
                  <span class="text-purple-500 mt-1">✓</span>
                  <span>Terima & proses aduan</span>
                </li>
                <li class="flex items-start gap-2 text-sm text-gray-600">
                  <span class="text-purple-500 mt-1">✓</span>
                  <span>Kelola status pengaduan</span>
                </li>
                <li class="flex items-start gap-2 text-sm text-gray-600">
                  <span class="text-purple-500 mt-1">✓</span>
                  <span>Lapor progress dengan detail</span>
                </li>
              </ul>

              <!-- Button -->
              <button
                class="w-full bg-purple-500 hover:bg-purple-600 text-white font-semibold py-3 rounded-lg transition"
              >
                Daftar sebagai OPD
              </button>
            </div>
          </div>
        </Link>
      </div>

      <!-- Login Link -->
      <div class="text-center">
        <p class="text-gray-600 text-sm">
          Sudah punya akun?
          <Link href="/login" class="text-blue-600 hover:text-blue-700 font-semibold">
            Login sekarang
          </Link>
        </p>
      </div>
    </div>
  </div>
</template>

<script setup>
import { Link } from "@inertiajs/vue3";
</script>
