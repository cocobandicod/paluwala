<script setup>
import { ref, onMounted } from "vue";
import api from "../../api";
import "datatables.net-bs5";
import $ from "jquery";
import { showToast, confirmDelete } from "../../utils/globalFunctions";
import FormRabAdd from "./form/form_kelompok_rab_add.vue";
import FormRabEdit from "./form/form_kelompok_rab_edit.vue";

const isLoading = ref(true);
const rab = ref([]);
const selectedId = ref(0);

const edit_data = (id) => {
    selectedId.value = id;
};

const detailrab = async () => {
    try {
        if ($.fn.DataTable.isDataTable("#DTableRab")) {
            $("#DTableRab").DataTable().destroy();
        }
        // Re-initialize DataTable after data is loaded
        initializeDataTable();
        isLoading.value = true; // Set loading to true before fetching
        const response = await api.get("/api/kelompokrabform");
        rab.value = response.data.data;
    } catch (error) {
        console.error("Error fetching data:", error);
    } finally {
        isLoading.value = false;
    }
};

onMounted(async () => {
    await detailrab();
    initializeDataTable();
});

const refreshDataTable = async () => {
    await detailrab();
    initializeDataTable();
};

const initializeDataTable = () => {
    $("#DTableRab").DataTable({
        stateSave: true,
        autoWidth: true,
        processing: true,
        ordering: false,
        responsive: true,
        columnDefs: [
            {
                className: "text-center p-2",
                width: "3%",
                targets: [0, 2],
            },
            {
                className: "p-2",
                targets: [0, 1, 2],
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

const delete_rab = async (id, nama) => {
    // Tampilkan dialog konfirmasi menggunakan SweetAlert
    const result = await confirmDelete("Menghapus data ini?", nama);

    // Jika pengguna mengonfirmasi penghapusan
    if (result.isConfirmed) {
        try {
            // Hapus dari database
            await api.delete(`/api/kelompokrabform/${id}`);
            await detailrab(); // Refresh data setelah penghapusan
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
                                        Kelompok RAB
                                    </h4>
                                </div>
                                <!-- end card header -->
                                <div class="card-body">
                                    <button
                                        type="button"
                                        class="btn btn-success mb-2"
                                        data-bs-toggle="modal"
                                        data-bs-target="#FormRabAdd"
                                    >
                                        <i
                                            class="ri-add-circle-line align-bottom me-1"
                                        ></i>
                                        Kelompok RAB
                                    </button>
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
                                                    id="DTableRab"
                                                    class="table table-bordered dt-responsive table-striped align-middle fs-12 mb-0"
                                                    style="width: 100%"
                                                >
                                                    <thead class="table-light">
                                                        <tr>
                                                            <th>No</th>
                                                            <th>
                                                                Kelompok RAB
                                                            </th>
                                                            <th>Action</th>
                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                        <tr
                                                            v-for="(
                                                                item, index
                                                            ) in rab"
                                                            :key="index"
                                                        >
                                                            <td>
                                                                {{ index + 1 }}
                                                            </td>
                                                            <td>
                                                                {{
                                                                    item.kelompok_rab
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
                                                                                data-bs-target="#FormRabEdit"
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
                                                                                    delete_rab(
                                                                                        item.id,
                                                                                        item.kelompok_rab
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
    <FormRabAdd @refreshTabel="refreshDataTable" />
    <FormRabEdit :dataId="selectedId" @refreshTabel="refreshDataTable" />
</template>
<style lang=""></style>
