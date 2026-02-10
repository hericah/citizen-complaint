<script>
import Swal from "sweetalert2";

export default {
  data() {
    return {
      searchQuery: "",
      currentPage: 1,
      perPage: 5,
      headers: ["ID", "Judul Aduan", "Kategori", "Status", "OPD", "Tanggal", "Aksi"],
      complaints: [
        { id: 1, judul: "Jalan rusak", kategori: "Infrastruktur", status: "Pending", opd: "Dinas PU", tanggal: "2026-02-01" },
        { id: 2, judul: "Lampu jalan mati", kategori: "Listrik", status: "Selesai", opd: "Dinas Perhubungan", tanggal: "2026-02-02" },
        { id: 3, judul: "Sampah menumpuk", kategori: "Lingkungan", status: "Pending", opd: "DLH", tanggal: "2026-02-03" },
        { id: 4, judul: "Air tidak mengalir", kategori: "PDAM", status: "Proses", opd: "PDAM", tanggal: "2026-02-04" },
        { id: 5, judul: "Trotoar rusak", kategori: "Infrastruktur", status: "Pending", opd: "Dinas PU", tanggal: "2026-02-05" },
        { id: 6, judul: "Pohon tumbang", kategori: "Lingkungan", status: "Selesai", opd: "DLH", tanggal: "2026-02-06" },
      ],
    };
  },
  computed: {
    filteredComplaints() {
      return this.complaints.filter(c =>
        c.judul.toLowerCase().includes(this.searchQuery.toLowerCase())
      );
    },
    totalPages() {
      return Math.ceil(this.filteredComplaints.length / this.perPage);
    },
    paginatedComplaints() {
      const start = (this.currentPage - 1) * this.perPage;
      return this.filteredComplaints.slice(start, start + this.perPage);
    },
  },
  methods: {
    getStatusColor(status) {
      return status === "Pending" ? "bg-yellow-100 text-yellow-800" :
             status === "Selesai" ? "bg-green-100 text-green-800" :
             status === "Proses" ? "bg-purple-100 text-purple-800" :
             "bg-gray-100 text-gray-800";
    },
    nextPage() {
      if (this.currentPage < this.totalPages) this.currentPage++;
    },
    prevPage() {
      if (this.currentPage > 1) this.currentPage--;
    },
    addComplaint() {
      Swal.fire("Tambah Aduan", "Form tambah aduan akan ditampilkan.", "info");
    },
    editComplaint(complaint) {
      Swal.fire("Edit Aduan", `Edit aduan: ${complaint.judul}`, "warning");
    },
    deleteComplaint(id) {
      Swal.fire({
        title: "Yakin hapus?",
        text: "Data tidak bisa dikembalikan!",
        icon: "warning",
        showCancelButton: true,
        confirmButtonColor: "#d33",
        cancelButtonColor: "#3085d6",
        confirmButtonText: "Ya, hapus!"
      }).then(result => {
        if (result.isConfirmed) {
          this.complaints = this.complaints.filter(c => c.id !== id);
          Swal.fire("Terhapus!", "Data berhasil dihapus.", "success");
        }
      });
    },
    detailComplaint(complaint) {
      Swal.fire("Detail Aduan", `Judul: ${complaint.judul}\nKategori: ${complaint.kategori}`, "info");
    },
    exportData() {
      const header = this.headers.join(",") + "\n";
      const rows = this.complaints.map(c =>
        [c.id, c.judul, c.kategori, c.status, c.opd, c.tanggal].join(",")
      ).join("\n");

      const csvContent = header + rows;
      const blob = new Blob([csvContent], { type: "text/csv;charset=utf-8;" });
      const link = document.createElement("a");
      link.href = URL.createObjectURL(blob);
      link.setAttribute("download", "complaints.csv");
      document.body.appendChild(link);
      link.click();
      document.body.removeChild(link);

      Swal.fire("Export Data", "Data berhasil diexport ke CSV.", "success");
    }
  }
};
</script>

<template>
  <div class="bg-white rounded-xl shadow-lg overflow-hidden">
    <div class="px-6 py-4 border-b border-gray-200 flex items-center justify-between">
      <div>
        <h3 class="text-lg font-bold text-gray-800">Semua Pengaduan</h3>
        <p class="text-sm text-gray-500 mt-1">Kelola dan tugaskan pengaduan ke OPD terkait</p>
      </div>
      
      <div class="flex gap-2">
        <input v-model="searchQuery" type="text" placeholder="Cari aduan..."
               class="px-3 py-2 border rounded-lg text-sm focus:ring focus:ring-yellow-300" />
        <button @click="addComplaint"
                class="px-4 py-2 bg-blue-500 hover:bg-blue-600 text-white text-sm font-medium rounded-lg transition">
          Tambah
        </button>
        <button @click="exportData"
                class="px-4 py-2 bg-green-500 hover:bg-green-600 text-white text-sm font-medium rounded-lg transition">
          Export
        </button>
      </div>
    </div>

    <!-- Table Wrapper with Horizontal Scroll -->
    <div class="overflow-x-auto">
      <table class="min-w-[900px] w-full">
        <thead class="bg-gray-50">
          <tr>
            <th v-for="header in headers" :key="header"
                class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
              {{ header }}
            </th>
          </tr>
        </thead>
        <tbody class="bg-white divide-y divide-gray-200">
          <tr v-for="complaint in paginatedComplaints" :key="complaint.id" class="hover:bg-gray-50 transition">
            <td class="px-6 py-4 text-sm font-medium text-gray-900">#{{ complaint.id }}</td>
            <td class="px-6 py-4 text-sm text-gray-900">{{ complaint.judul }}</td>
            <td class="px-6 py-4 text-sm text-gray-600">{{ complaint.kategori }}</td>
            <td class="px-6 py-4">
              <span :class="getStatusColor(complaint.status)"
                    class="px-3 py-1 inline-flex text-xs leading-5 font-semibold rounded-full">
                {{ complaint.status }}
              </span>
            </td>
            <td class="px-6 py-4 text-sm text-gray-600">{{ complaint.opd || '-' }}</td>
            <td class="px-6 py-4 text-sm text-gray-600">{{ complaint.tanggal }}</td>
            <td class="px-6 py-4 text-sm space-x-2">
              <button @click="detailComplaint(complaint)" class="text-blue-600 hover:text-blue-800 font-medium transition">Detail</button>
              <button @click="editComplaint(complaint)" class="text-purple-600 hover:text-purple-800 font-medium transition">Edit</button>
              <button @click="deleteComplaint(complaint.id)" class="text-red-600 hover:text-red-800 font-medium transition">Hapus</button>
            </td>
          </tr>
        </tbody>
      </table>
    </div>

    <!-- Table Footer -->
    <div class="px-6 py-4 bg-gray-50 border-t border-gray-200">
      <div class="flex items-center justify-between">
        <p class="text-sm text-gray-500">
          Menampilkan <span class="font-medium">{{ paginatedComplaints.length }}</span> dari 
          <span class="font-medium">{{ complaints.length }}</span> pengaduan
        </p>
        <div class="flex gap-2">
          <button @click="prevPage" :disabled="currentPage === 1"
                  class="px-3 py-1 text-sm bg-white border border-gray-300 rounded-lg hover:bg-gray-50 disabled:opacity-50 transition">
            Previous
          </button>
          <button @click="nextPage" :disabled="currentPage === totalPages"
                  class="px-3 py-1 text-sm bg-yellow-500 text-white rounded-lg hover:bg-yellow-600 disabled:opacity-50 transition">
            Next
          </button>
        </div>
      </div>
    </div>
  </div>
</template>