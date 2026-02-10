<template>
  <div class="min-h-screen bg-gray-50">
    <StaffLayout :user="user">
      <div class="mb-8">
        <div class="flex items-start justify-between">
          <div>
            <h2 class="text-2xl md:text-3xl font-bold text-gray-800">Ubah Unit OPD</h2>
            <p class="text-sm text-gray-500 mt-1">Perbarui data unit OPD</p>
          </div>
          <Link href="/master/unit-opd" class="px-6 py-3 bg-gray-500 hover:bg-gray-600 text-white font-medium rounded-xl transition">Kembali</Link>
        </div>
      </div>

      <div class="bg-white rounded-xl shadow-lg p-8 max-w-2xl">
        <form @submit.prevent="submit" class="space-y-6">
          <div>
            <label class="block text-gray-700 text-sm font-medium mb-2">OPD</label>
            <select v-model="form.opd_id" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-400" :class="{'border-red-500': form.errors.opd_id}">
              <option value="">Pilih OPD</option>
              <option v-for="o in opdList" :value="o.id" :key="o.id">{{ o.nama_opd }}</option>
            </select>
            <p v-if="form.errors.opd_id" class="text-red-500 text-xs mt-1">{{ form.errors.opd_id }}</p>
          </div>

          <div>
            <label class="block text-gray-700 text-sm font-medium mb-2">Nama Unit</label>
            <input v-model="form.nama_unit" type="text" placeholder="Contoh: Sekretariat" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-400" :class="{'border-red-500': form.errors.nama_unit}" />
            <p v-if="form.errors.nama_unit" class="text-red-500 text-xs mt-1">{{ form.errors.nama_unit }}</p>
          </div>

          <div>
            <label class="block text-gray-700 text-sm font-medium mb-2">Kode Unit (opsional)</label>
            <input v-model="form.kode_unit" type="text" placeholder="Contoh: U01" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-400" />
          </div>

          <button type="submit" :disabled="form.processing" class="w-full px-4 py-3 bg-blue-500 hover:bg-blue-600 text-white font-medium rounded-lg transition disabled:opacity-50">{{ form.processing ? 'Menyimpan...' : 'Perbarui Unit' }}</button>
        </form>
      </div>
    </StaffLayout>
  </div>
</template>

<script setup>
import { Link, useForm } from "@inertiajs/vue3";
import StaffLayout from "@/Layouts/StaffLayout.vue";
import Swal from "sweetalert2";
import { watch } from "vue";

const props = defineProps({ user: Object, unit: Object, opdList: Array });

const form = useForm({ opd_id: "", nama_unit: "", kode_unit: "" });

watch(() => props.unit, (newUnit) => {
  if (newUnit) {
    form.opd_id = newUnit.opd_id;
    form.nama_unit = newUnit.nama_unit;
    form.kode_unit = newUnit.kode_unit || "";
  }
}, { immediate: true });

const submit = () => {
  form.put(`/master/unit-opd/${props.unit.id}`, {
    onSuccess: () => {
      Swal.fire({ icon: 'success', title: 'Unit Berhasil Diperbarui', confirmButtonColor: '#3B82F6' }).then(() => {
        window.location.href = '/master/unit-opd';
      });
    },
  });
};
</script>
