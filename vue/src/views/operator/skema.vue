<script setup>
import { ref, onMounted } from "vue";
import api from "../../api";
import "datatables.net-bs5";
import $ from "jquery";
import { showToast, confirmDelete } from "../../utils/globalFunctions";
import FormSkemaAdd from "./form/form_skema_add.vue";
import FormSkemaEdit from "./form/form_skema_edit.vue";

const isLoading = ref(true);
const skema = ref([]);
const pilkegiatan = ref("Penelitian");
const piltahun = ref("2024");
const selectedId = ref(0);

const edit_data = (id) => {
    selectedId.value = id;
};

// Function to fetch data based on selected category and year
const detail_skema = async () => {
    try {
        // Check if DataTable is already initialized, destroy it if exists
        if ($.fn.DataTable.isDataTable("#DTableSkema")) {
            $("#DTableSkema").DataTable().destroy();
        }
        // Re-initialize DataTable after data is loaded
        initializeDataTable();
        isLoading.value = true; // Set loading to true before fetching
        const response = await api.get(
            `/api/skemaform/${piltahun.value}/${pilkegiatan.value}`
        );
        skema.value = response.data.data;
    } catch (error) {
        console.error("Error fetching data:", error);
    } finally {
        isLoading.value = false; // Set loading to false after fetching
    }
};

// Function to initialize DataTable
const initializeDataTable = () => {
    $("#DTableSkema").DataTable({
        stateSave: true,
        autoWidth: true,
        processing: true,
        ordering: false,
        responsive: true,
        columnDefs: [
            {
                className: "text-center p-2",
                width: "3%",
                targets: [0, 4],
            },
            {
                className: "text-center p-2",
                width: "10%",
                targets: [2],
            },
            {
                className: "p-2",
                targets: [0, 1, 2, 3, 4],
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

// Combined function for handling both category and year changes
const pilih_kategori_dan_tahun = async () => {
    await detail_skema(); // Fetch data based on new selections
    initializeDataTable();
};

// Fetch initial data when component is mounted
onMounted(async () => {
    await detail_skema();
    initializeDataTable(); // Initialize the data table after fetching
});

const refreshDataTable = async () => {
    await detail_skema();
    initializeDataTable();
};

const hapus_data = async (id, nama) => {
    // Tampilkan dialog konfirmasi menggunakan SweetAlert
    const result = await confirmDelete("Menghapus data ini?", nama);

    // Jika pengguna mengonfirmasi penghapusan
    if (result.isConfirmed) {
        try {
            // Hapus dari database
            await api.delete(`/api/skemaform/${id}`);
            await detail_skema(); // Refresh data setelah penghapusan
            initializeDataTable();
            // Tampilkan toast sukses
            showToast("Data berhasil dihapus", "#4fbe87");
        } catch (error) {
            console.error("Error delete data:", error);
            // Tampilkan toast error jika gagal menghapus
            showToast("Gagal menghapus data", "#ff6b6b");
        }
    }
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
                                        Skema Penelitian Pengabdian
                                    </h4>
                                </div>
                                <!-- end card header -->
                                <div class="card-body">
                                    <div class="row">
                                        <div class="col-sm-auto">
                                            <div>
                                                <button
                                                    type="button"
                                                    class="btn btn-success mb-2"
                                                    data-bs-toggle="modal"
                                                    data-bs-target="#FormSkemaAdd"
                                                >
                                                    <i
                                                        class="ri-add-circle-line align-bottom me-1"
                                                    ></i>
                                                    Skema
                                                </button>
                                            </div>
                                        </div>
                                        <div class="col-sm">
                                            <div
                                                class="d-flex justify-content-sm-end"
                                            >
                                                <div class="search-box ms-0">
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
                                                        <option
                                                            value="Penelitian"
                                                        >
                                                            Penelitian
                                                        </option>
                                                        <option
                                                            value="Pengabdian"
                                                        >
                                                            Pengabdian
                                                        </option>
                                                    </select>
                                                </div>
                                                <div class="search-box ms-2">
                                                    <label
                                                        for="labelInput"
                                                        class="form-label"
                                                        >Tahun</label
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
                                    <div v-else class="mt-3">
                                        <div class="row">
                                            <div class="table-responsive">
                                                <table
                                                    id="DTableSkema"
                                                    class="table table-bordered dt-responsive table-striped align-middle fs-12 mb-0"
                                                    style="width: 100%"
                                                >
                                                    <thead class="table-light">
                                                        <tr>
                                                            <th>No</th>
                                                            <th>Nama Skema</th>
                                                            <th>Tahun</th>
                                                            <th>Kegiatan</th>
                                                            <th>Action</th>
                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                        <tr
                                                            v-for="(
                                                                item, index
                                                            ) in skema"
                                                            :key="index"
                                                        >
                                                            <td>
                                                                {{ index + 1 }}
                                                            </td>
                                                            <td>
                                                                {{
                                                                    item.nama_skema
                                                                }}
                                                            </td>
                                                            <td>
                                                                {{ item.tahun }}
                                                            </td>
                                                            <td>
                                                                {{
                                                                    item.kegiatan
                                                                }}
                                                            </td>
                                                            <td>
                                                                <div
                                                                    class="dropdown"
                                                                >
                                                                    <span
                                                                        class="btn btn-soft-secondary btn-sm dropdown"
                                                                        id="dropdownMenuLink"
                                                                        data-bs-toggle="dropdown"
                                                                        aria-expanded="false"
                                                                    >
                                                                        <i
                                                                            class="ri-more-2-fill"
                                                                        ></i>
                                                                    </span>
                                                                    <ul
                                                                        class="dropdown-menu"
                                                                        aria-labelledby="dropdownMenuLink"
                                                                    >
                                                                        <li>
                                                                            <button
                                                                                class="dropdown-item"
                                                                                data-bs-toggle="modal"
                                                                                data-bs-target="#FormSkemaEdit"
                                                                                @click="
                                                                                    edit_data(
                                                                                        item.id
                                                                                    )
                                                                                "
                                                                            >
                                                                                <i
                                                                                    class="ri-pencil-fill align-bottom me-2 text-muted"
                                                                                ></i>
                                                                                Ubah
                                                                            </button>
                                                                        </li>
                                                                        <li>
                                                                            <button
                                                                                class="dropdown-item"
                                                                                @click.prevent="
                                                                                    hapus_data(
                                                                                        item.id,
                                                                                        item.judul
                                                                                    )
                                                                                "
                                                                            >
                                                                                <i
                                                                                    class="ri-delete-bin-fill align-bottom me-2 text-muted"
                                                                                ></i>
                                                                                Hapus
                                                                            </button>
                                                                        </li>
                                                                    </ul>
                                                                </div>
                                                            </td>
                                                        </tr>
                                                    </tbody>
                                                </table>
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
    <FormSkemaAdd @refresh="refreshDataTable" />
    <FormSkemaEdit :dataId="selectedId" @refresh="refreshDataTable" />
</template>
<style lang=""></style>
