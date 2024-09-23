<script setup>
import { ref, onMounted, watch } from "vue";
import api from "../../api";
import "datatables.net-bs5";
import $ from "jquery";

const isLoading = ref(true);
const usulan = ref([]);
const piltahun = ref("2024");
const pilkegiatan = ref("Penelitian");

const catatan_harian = async () => {
    try {
        isLoading.value = true; // Set loading to true before fetching
        const response = await api.get(
            `/api/catatanharian/${piltahun.value}/${pilkegiatan.value}`
        );
        usulan.value = response.data.data;

        // Check if DataTable is already initialized, destroy it if exists
        if ($.fn.DataTable.isDataTable("#DTableCatatanHarian")) {
            $("#DTableCatatanHarian").DataTable().destroy();
        }

        // Re-initialize DataTable after data is loaded
        initializeDataTable();
    } catch (error) {
        console.error("Error fetching data:", error);
    } finally {
        isLoading.value = false;
    }
};

const pilih_kategori_dan_tahun = async () => {
    await catatan_harian(); // Fetch data based on new selections
    initializeDataTable();
};

onMounted(async () => {
    await catatan_harian();
    initializeDataTable();
});

const initializeDataTable = () => {
    $("#DTableCatatanHarian").DataTable({
        stateSave: true,
        autoWidth: true,
        processing: true,
        ordering: false,
        responsive: true,
        columnDefs: [
            {
                className: "text-center p-2",
                width: "3%",
                targets: [0],
            },
            {
                className: "text-center p-2",
                width: "10%",
                targets: [2, 3],
            },
            {
                className: "p-2",
                targets: [0, 1, 2, 3],
            },
        ],
        language: {
            processing:
                '<span><i class="mdi mdi-spin mdi-loading me-1"></i> Memuat Data..</span>',
            search: "<div class='fs-13'>Pencarian</div> _INPUT_",
            searchPlaceholder: "Masukan Kata Kunci",
            lengthMenu: "<div class='fs-13'>Tampilkan</div> _MENU_",
            info: "<div class='fs-13'>Menampilkan _START_ sampai _END_ dari _TOTAL_ entri</div>",
            zeroRecords: "Tidak ada data yang ditemukan",
            infoEmpty:
                "<div class='fs-13'>Menampilkan 0 sampai 0 dari 0 entri</div>",
            infoFiltered:
                "<div class='fs-13'>(disaring dari total _MAX_ entri)</div>",
        },
    });
};
</script>
<template>
    <div>
        <div class="main-content">
            <div class="page-content">
                <div class="container-fluid">
                    <div class="row">
                        <div class="col-xl-12">
                            <div class="card card-height-100">
                                <div
                                    class="card-header align-items-center d-flex"
                                >
                                    <h4 class="card-title mb-0 flex-grow-1">
                                        Catatan Harian
                                    </h4>
                                </div>
                                <!-- end card header -->
                                <div class="card-body">
                                    <div class="row">
                                        <div
                                            class="col-xxl-3 col-md-3 mt-0 mb-2"
                                        >
                                            <div>
                                                <label
                                                    for="labelInput"
                                                    class="form-label"
                                                    >Jenis Kegiatan</label
                                                >
                                                <select
                                                    v-model="pilkegiatan"
                                                    class="form-select"
                                                    @change.prevent="
                                                        pilih_kategori_dan_tahun()
                                                    "
                                                >
                                                    <option value="Penelitian">
                                                        Penelitian
                                                    </option>
                                                    <option value="Pengabdian">
                                                        Pengabdian
                                                    </option>
                                                </select>
                                            </div>
                                        </div>
                                        <div
                                            class="col-xxl-2 col-md-2 mt-0 mb-2"
                                        >
                                            <div>
                                                <label
                                                    for="labelInput"
                                                    class="form-label"
                                                    >Tahun Pelaksanaan</label
                                                >
                                                <select
                                                    v-model="piltahun"
                                                    class="form-select"
                                                    @change.prevent="
                                                        pilih_kategori_dan_tahun()
                                                    "
                                                >
                                                    <option value="2024">
                                                        2024
                                                    </option>
                                                    <option value="2023">
                                                        2023
                                                    </option>
                                                </select>
                                            </div>
                                        </div>
                                        <div
                                            v-if="isLoading"
                                            class="d-flex justify-content-center mt-4 mb-4"
                                        >
                                            <div
                                                class="spinner-border"
                                                role="status"
                                            >
                                                <span class="visually-hidden"
                                                    >Loading...</span
                                                >
                                            </div>
                                        </div>
                                        <div v-else>
                                            <div class="row">
                                                <div class="table-responsive">
                                                    <table
                                                        id="DTableCatatanHarian"
                                                        class="table table-bordered dt-responsive table-striped align-middle fs-12 mb-0"
                                                        style="width: 100%"
                                                    >
                                                        <thead
                                                            class="table-light"
                                                        >
                                                            <tr>
                                                                <th>No</th>
                                                                <th>
                                                                    Nama Skema
                                                                </th>
                                                                <th>Jumlah</th>
                                                                <th>Action</th>
                                                            </tr>
                                                        </thead>
                                                        <tbody>
                                                            <tr
                                                                v-for="(
                                                                    item, index
                                                                ) in usulan"
                                                                :key="index"
                                                            >
                                                                <td>
                                                                    {{
                                                                        index +
                                                                        1
                                                                    }}
                                                                </td>
                                                                <td>
                                                                    {{
                                                                        item.nama_skema
                                                                    }}
                                                                </td>
                                                                <td>
                                                                    {{
                                                                        item.jumlah_usulan
                                                                    }}
                                                                </td>
                                                                <td>
                                                                    <router-link
                                                                        type="button"
                                                                        class="btn btn-soft-secondary btn-sm"
                                                                        :to="{
                                                                            name: 'OperatorCatatanHarianList',
                                                                            params: {
                                                                                kode: item.kode_skema,
                                                                            },
                                                                        }"
                                                                    >
                                                                        <i
                                                                            class="ri-search-line align-bottom me-0"
                                                                        ></i>
                                                                        View
                                                                    </router-link>
                                                                </td>
                                                            </tr>
                                                        </tbody>
                                                    </table>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <!--end row-->
                                </div>
                                <!-- end card body -->
                            </div>
                            <!-- end card -->
                        </div>
                        <!-- end col -->
                    </div>
                    <!-- end row -->
                </div>
            </div>
        </div>
    </div>
</template>
<style lang=""></style>
