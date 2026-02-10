<template>
  <div class="min-h-screen bg-gray-100">
    <OpdLayout :user="user">
      <!-- Header dengan Tombol Kembali -->
      <div class="mb-8">
        <div class="flex items-center justify-between mb-6">
          <div>
            <h1 class="text-3xl font-bold text-gray-800">Detail Laporan Pengaduan</h1>
            <p class="text-gray-600 mt-2">No. Laporan: {{ laporan.nomor_laporan }}</p>
          </div>
          <Link
            :href="route('laporan.fixlaporan')"
            class="px-6 py-3 bg-gray-500 hover:bg-gray-600 text-white font-medium rounded-lg transition"
          >
            ← Kembali
          </Link>
        </div>
      </div>

      <div class="grid grid-cols-1 lg:grid-cols-4 gap-6">
        <!-- Main Content -->
        <div class="lg:col-span-3 space-y-6">
          <!-- Status Badge -->
          <div class="bg-white rounded-lg shadow-lg p-6">
            <div class="flex items-center justify-between">
              <div>
                <p class="text-gray-600 text-sm font-medium">Status Saat Ini</p>
                <h3 class="text-2xl font-bold text-gray-800 mt-2">{{ laporan.status_aduan }}</h3>
              </div>
              <span :class="getStatusColor(laporan.status_aduan)" class="px-4 py-2 rounded-full text-sm font-semibold">
                {{ laporan.status_aduan }}
              </span>
            </div>
          </div>

          <!-- Data Pelapor -->
          <div class="bg-white rounded-lg shadow-lg p-6">
            <h2 class="text-xl font-bold text-gray-800 mb-6 pb-4 border-b-2 border-gray-300">
              IDENTITAS PELAPOR
            </h2>
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
              <div>
                <label class="text-gray-600 text-sm font-medium">Nama Lengkap</label>
                <p class="text-gray-900 font-medium mt-1">{{ laporan.nama_lengkap }}</p>
              </div>
              <div>
                <label class="text-gray-600 text-sm font-medium">Nomor Identitas</label>
                <p class="text-gray-900 font-medium mt-1">{{ laporan.nomor_identitas }}</p>
              </div>
              <div>
                <label class="text-gray-600 text-sm font-medium">Email</label>
                <p class="text-gray-900 font-medium mt-1">{{ laporan.email }}</p>
              </div>
              <div>
                <label class="text-gray-600 text-sm font-medium">Nomor Telepon</label>
                <p class="text-gray-900 font-medium mt-1">{{ laporan.nomor_telepon }}</p>
              </div>
              <div>
                <label class="text-gray-600 text-sm font-medium">Alamat</label>
                <p class="text-gray-900 font-medium mt-1">{{ laporan.alamat }}</p>
              </div>
              <div>
                <label class="text-gray-600 text-sm font-medium">Status Pelapor</label>
                <p class="text-gray-900 font-medium mt-1">{{ laporan.status }}</p>
              </div>
              <div>
                <label class="text-gray-600 text-sm font-medium">Sumber Pengaduan</label>
                <p class="text-gray-900 font-medium mt-1">{{ laporan.sumber_pengaduan }}</p>
              </div>
              <div>
                <label class="text-gray-600 text-sm font-medium">Tanggal Laporan</label>
                <p class="text-gray-900 font-medium mt-1">{{ formatDate(laporan.tanggal_lapor) }}</p>
              </div>
            </div>
          </div>

          <!-- Detail Pengaduan -->
          <div class="bg-white rounded-lg shadow-lg p-6">
            <h2 class="text-xl font-bold text-gray-800 mb-6 pb-4 border-b-2 border-gray-300">
              DETAIL PENGADUAN
            </h2>
            <div class="space-y-6">
              <div>
                <label class="text-gray-600 text-sm font-medium">Perihal/Judul</label>
                <p class="text-gray-900 font-medium mt-2 p-3 bg-gray-50 rounded">{{ laporan.perihal }}</p>
              </div>
              <div>
                <label class="text-gray-600 text-sm font-medium">Uraian Lengkap</label>
                <p class="text-gray-900 mt-2 p-4 bg-gray-50 rounded whitespace-pre-wrap">{{ laporan.uraian }}</p>
              </div>
              <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <div>
                  <label class="text-gray-600 text-sm font-medium">Kategori</label>
                  <p class="text-gray-900 font-medium mt-1">{{ laporan.kategori }}</p>
                </div>
                <div>
                  <label class="text-gray-600 text-sm font-medium">Tingkat Akses</label>
                  <p class="text-gray-900 font-medium mt-1">{{ laporan.akses_aduan }}</p>
                </div>
              </div>
              <div>
                <label class="text-gray-600 text-sm font-medium">Lokasi Kejadian</label>
                <p class="text-gray-900 font-medium mt-1">{{ laporan.lokasi }}</p>
              </div>
              <div v-if="laporan.latitude && laporan.longitude" class="bg-blue-50 p-4 rounded border border-blue-200">
                <p class="text-sm text-gray-600">
                  <strong>Koordinat:</strong> {{ laporan.latitude }}, {{ laporan.longitude }}
                </p>
              </div>
              <div v-if="laporan.foto" class="border border-gray-300 rounded overflow-hidden">
                <img
                  :src="`/storage/${laporan.foto}`"
                  :alt="laporan.perihal"
                  class="w-full h-auto max-h-96 object-cover"
                />
              </div>
            </div>
          </div>

          <!-- Riwayat Status -->
          <div v-if="laporan.riwayat_status && laporan.riwayat_status.length > 0" class="bg-white rounded-lg shadow-lg p-6">
            <h2 class="text-xl font-bold text-gray-800 mb-6 pb-4 border-b-2 border-gray-300">
              RIWAYAT STATUS
            </h2>
            <div class="space-y-4">
              <div
                v-for="(riwayat, idx) in laporan.riwayat_status"
                :key="idx"
                class="flex gap-4 p-4 bg-gray-50 rounded-lg border-l-4 border-blue-500"
              >
                <div class="flex-shrink-0">
                  <div class="w-10 h-10 rounded-full bg-blue-100 flex items-center justify-center">
                    <span class="text-lg">📋</span>
                  </div>
                </div>
                <div class="flex-1">
                  <p class="font-bold text-gray-800">{{ riwayat.status_aduan?.nama_status || 'N/A' }}</p>
                  <p v-if="riwayat.catatan" class="text-gray-700 text-sm mt-1">{{ riwayat.catatan }}</p>
                  <p class="text-xs text-gray-500 mt-2">{{ formatDate(riwayat.waktu_status_aduan) }}</p>
                </div>
              </div>
            </div>
          </div>

          <!-- Tanggapan -->
          <div v-if="laporan.tanggapan && laporan.tanggapan.length > 0" class="bg-white rounded-lg shadow-lg p-6">
            <h2 class="text-xl font-bold text-gray-800 mb-6 pb-4 border-b-2 border-gray-300">
              TANGGAPAN DAN RESPONS
            </h2>
            <div class="space-y-4">
              <div
                v-for="tanggapan in laporan.tanggapan"
                :key="tanggapan.id"
                class="p-4 bg-green-50 rounded-lg border-l-4 border-green-500"
              >
                <div class="flex items-start justify-between">
                  <p class="font-bold text-gray-800">Respons dari OPD</p>
                  <span class="text-xs text-gray-500">{{ formatDate(tanggapan.created_at) }}</span>
                </div>
                <p class="text-gray-700 mt-3 whitespace-pre-wrap">{{ tanggapan.isi_tanggapan }}</p>
              </div>
            </div>
          </div>
        </div>

        <!-- Sidebar Actions -->
        <div class="lg:col-span-1">
          <div class="bg-white rounded-lg shadow-lg p-6 sticky top-6 space-y-4">
            <h3 class="text-lg font-bold text-gray-800 mb-4">AKSI</h3>

            <button
              @click="printLaporan"
              class="w-full px-4 py-3 bg-blue-500 hover:bg-blue-600 text-white font-medium rounded-lg transition flex items-center justify-center gap-2"
            >
              <span>🖨️</span> Cetak
            </button>

            <button
              @click="exportPdf"
              class="w-full px-4 py-3 bg-red-500 hover:bg-red-600 text-white font-medium rounded-lg transition flex items-center justify-center gap-2"
            >
              <span>📥</span> Unduh PDF
            </button>

            <!-- Info Box -->
            <div class="mt-6 p-4 bg-blue-50 rounded-lg border border-blue-200">
              <p class="text-sm font-medium text-gray-800">Nomor Laporan</p>
              <p class="text-lg font-bold text-blue-600 mt-2">{{ laporan.nomor_laporan }}</p>
            </div>

            <div class="p-4 bg-purple-50 rounded-lg border border-purple-200">
              <p class="text-sm font-medium text-gray-800">Status Laporan</p>
              <p :class="getStatusColorSmall(laporan.status_aduan)" class="text-lg font-bold mt-2">
                {{ laporan.status_aduan }}
              </p>
            </div>

            <div v-if="laporan.tanggal_selesai" class="p-4 bg-green-50 rounded-lg border border-green-200">
              <p class="text-sm font-medium text-gray-800">Tanggal Selesai</p>
              <p class="text-gray-700 font-medium mt-2">{{ formatDate(laporan.tanggal_selesai) }}</p>
            </div>
          </div>
        </div>
      </div>

      <!-- Hidden Print Template -->
      <div id="print-template" class="hidden">
        <div
          style="
            font-family: Arial, sans-serif;
            padding: 40px;
            color: #333;
            line-height: 1.6;
            font-size: 12pt;
          "
        >
          <!-- Header -->
          <div style="text-align: center; margin-bottom: 30px; border-bottom: 2px solid #000; padding-bottom: 20px">
            <div style="font-size: 18pt; font-weight: bold; margin-bottom: 5px">E-LAPORAN</div>
            <div style="font-size: 18pt; font-weight: bold">PEMERINTAH KABUPATEN PAMALANG</div>
            <div style="font-size: 14pt; font-weight: bold; margin-top: 15px">LAPORAN PENGADUAN</div>
            <div style="font-size: 12pt; margin-top: 10px; color: #666">
              No. Laporan: <strong>{{ laporan.nomor_laporan }}</strong>
            </div>
          </div>

          <!-- Identitas Pelapor -->
          <div style="margin-bottom: 25px">
            <div style="font-weight: bold; font-size: 13pt; margin-bottom: 10px; border-bottom: 1px solid #000; padding-bottom: 5px">
              IDENTITAS PELAPOR
            </div>
            <table style="width: 100%; border-collapse: collapse; font-size: 11pt">
              <tr>
                <td style="padding: 5px 0; width: 30%">Nama Lengkap</td>
                <td style="padding: 5px 0">: {{ laporan.nama_lengkap }}</td>
              </tr>
              <tr>
                <td style="padding: 5px 0">Nomor Identitas</td>
                <td style="padding: 5px 0">: {{ laporan.nomor_identitas }}</td>
              </tr>
              <tr>
                <td style="padding: 5px 0">Alamat</td>
                <td style="padding: 5px 0">: {{ laporan.alamat }}</td>
              </tr>
              <tr>
                <td style="padding: 5px 0">Nomor Telepon</td>
                <td style="padding: 5px 0">: {{ laporan.nomor_telepon }}</td>
              </tr>
              <tr>
                <td style="padding: 5px 0">Email</td>
                <td style="padding: 5px 0">: {{ laporan.email }}</td>
              </tr>
              <tr>
                <td style="padding: 5px 0">Tanggal Laporan</td>
                <td style="padding: 5px 0">: {{ formatDate(laporan.tanggal_lapor) }}</td>
              </tr>
            </table>
          </div>

          <!-- Detail Pengaduan -->
          <div style="margin-bottom: 25px">
            <div style="font-weight: bold; font-size: 13pt; margin-bottom: 10px; border-bottom: 1px solid #000; padding-bottom: 5px">
              DETAIL PENGADUAN
            </div>
            <table style="width: 100%; border-collapse: collapse; font-size: 11pt">
              <tr>
                <td style="padding: 5px 0; width: 30%">Perihal</td>
                <td style="padding: 5px 0">: {{ laporan.perihal }}</td>
              </tr>
              <tr>
                <td style="padding: 5px 0; vertical-align: top">Uraian</td>
                <td style="padding: 5px 0; word-wrap: break-word">: {{ laporan.uraian }}</td>
              </tr>
              <tr>
                <td style="padding: 5px 0">Kategori</td>
                <td style="padding: 5px 0">: {{ laporan.kategori }}</td>
              </tr>
              <tr>
                <td style="padding: 5px 0">Lokasi</td>
                <td style="padding: 5px 0">: {{ laporan.lokasi }}</td>
              </tr>
              <tr>
                <td style="padding: 5px 0">Status</td>
                <td style="padding: 5px 0; font-weight: bold">: {{ laporan.status_aduan }}</td>
              </tr>
            </table>
          </div>

          <div style="margin-top: 50px; padding-top: 20px; border-top: 1px solid #999; text-align: center; font-size: 10pt; color: #666">
            <p>Dokumen ini dihasilkan oleh Sistem E-Laporan</p>
            <p>{{ new Date().toLocaleDateString('id-ID') }}</p>
          </div>
        </div>
      </div>
    </OpdLayout>
  </div>
</template>

<script setup>
import OpdLayout from "@/Layouts/OpdLayout.vue";
import { Link } from "@inertiajs/vue3";
import Swal from "sweetalert2";

defineProps({
  user: Object,
  laporan: Object,
});

const formatDate = (dateString) => {
  if (!dateString) return "N/A";
  const date = new Date(dateString);
  return date.toLocaleDateString("id-ID", {
    year: "numeric",
    month: "long",
    day: "numeric",
    hour: "2-digit",
    minute: "2-digit",
  });
};

const getStatusColor = (status) => {
  const colors = {
    "Diajukan": "bg-yellow-100 text-yellow-800",
    "Diverifikasi": "bg-blue-100 text-blue-800",
    "Diproses": "bg-purple-100 text-purple-800",
    "Selesai": "bg-green-100 text-green-800",
    "Ditolak": "bg-red-100 text-red-800",
  };
  return colors[status] || "bg-gray-100 text-gray-800";
};

const getStatusColorSmall = (status) => {
  const colors = {
    "Diajukan": "text-yellow-600",
    "Diverifikasi": "text-blue-600",
    "Diproses": "text-purple-600",
    "Selesai": "text-green-600",
    "Ditolak": "text-red-600",
  };
  return colors[status] || "text-gray-600";
};

const printLaporan = () => {
  try {
    const printElement = document.getElementById("print-template");
    if (!printElement) {
      throw new Error("Print template not found");
    }
    const printWindow = window.open("", "", "width=900,height=700");
    const styleContent = `
      @page { size: A4; margin: 15mm; }
      body { font-family: Arial, sans-serif; font-size: 12px; line-height: 1.5; margin: 0; padding: 0; color: #333; }
      table { width: 100%; border-collapse: collapse; }
      td { padding: 4px 0; }
    `;
    const html = `
      <!DOCTYPE html>
      <html>
        <head>
          <meta charset="UTF-8">
          <title>Laporan ${laporan.nomor_laporan}</title>
          <style>${styleContent}</style>
        </head>
        <body>${printElement.innerHTML}</body>
      </html>
    `;
    printWindow.document.write(html);
    printWindow.document.close();
    setTimeout(() => {
      printWindow.focus();
      printWindow.print();
      setTimeout(() => printWindow.close(), 500);
    }, 300);
  } catch (error) {
    console.error("Print Error:", error);
    Swal.fire({
      icon: "error",
      title: "Error",
      text: "Gagal membuka dialog cetak. Silakan coba lagi.",
      confirmButtonColor: "#EF4444",
    });
  }
};

const exportPdf = () => {
  Swal.fire({
    icon: "info",
    title: "Export PDF",
    text: "Fitur export PDF akan segera tersedia. Gunakan tombol Cetak untuk menyimpan sebagai PDF.",
    confirmButtonColor: "#3B82F6",
  });
};
</script>

<style scoped>
@media print {
  body {
    background: white !important;
    margin: 0 !important;
    padding: 0 !important;
  }

  .min-h-screen {
    background: white !important;
  }

  #print-template {
    display: block !important;
  }

  button,
  .sticky,
  .grid,
  .lg\:col-span-1 {
    display: none !important;
  }
  
  img,
  svg {
    max-width: 100%;
    height: auto;
  }
}

@media print {
  #print-template {
    display: block !important;
  }
}
</style>
