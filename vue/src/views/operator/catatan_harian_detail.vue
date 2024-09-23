<script setup>
import { ref, onMounted } from "vue";
import { useRoute, useRouter } from "vue-router";
import api from "../../api";
import "datatables.net-bs5";
import $ from "jquery";

const route = useRoute();
const router = useRouter(); // Inisialisasi router
const isLoading = ref(true);
const catatan = ref([]);
const usulan = ref([]);
const skema = ref([]);

const catatan_harian = async () => {
    try {
        const response = await api.get(
            `/api/catatanhariandetail/${route.params.kode}/${route.params.id}`
        );
        catatan.value = response.data.data.catatan;
        usulan.value = response.data.data.usulan;
        skema.value = response.data.data.skema;
    } catch (error) {
        if (error.response && error.response.status === 404) {
            router.push({ name: "NotFound" });
        } else {
            console.error("Error fetching data:", error);
        }
    } finally {
        isLoading.value = false;
    }
};

onMounted(async () => {
    await catatan_harian();
    initializeDataTable();
});

const initializeDataTable = () => {
    $("#DTable1").DataTable({
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
                className: "p-2",
                targets: [0, 1, 2, 3, 4, 5, 6],
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
                                        Data Kegiatan
                                        {{ skema.kegiatan }}
                                    </h4>
                                </div>
                                <!-- end card header -->
                                <div class="card-body">
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
                                            <div>
                                                <h5 class="fw-bold">
                                                    {{ usulan.judul }}
                                                </h5>
                                                <div
                                                    class="hstack gap-3 flex-wrap"
                                                >
                                                    <div>
                                                        <i
                                                            class="ri-book-open-line align-bottom me-1"
                                                        ></i>
                                                        {{ skema.nama_skema }}
                                                    </div>
                                                    <div class="vr"></div>
                                                    <div>
                                                        Tahun Pelaksanaan :
                                                        <span
                                                            class="fw-medium"
                                                            >{{
                                                                skema.tahun
                                                            }}</span
                                                        >
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="table-responsive">
                                                <table
                                                    id="DTable1"
                                                    class="table table-bordered dt-responsive table-striped align-middle fs-12 mb-0"
                                                    style="width: 100%"
                                                >
                                                    <thead class="table-light">
                                                        <tr>
                                                            <th>No</th>
                                                            <th>Tanggal</th>
                                                            <th>Kegiatan</th>
                                                            <th>Persentase</th>
                                                            <th>
                                                                Berkas Kegiatan
                                                            </th>
                                                            <th>Ukuran</th>
                                                            <th>
                                                                Tanggal Upload
                                                            </th>
                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                        <tr
                                                            v-for="(
                                                                item, index
                                                            ) in catatan"
                                                            :key="index"
                                                        >
                                                            <td>
                                                                {{ index + 1 }}
                                                            </td>
                                                            <td>
                                                                {{
                                                                    item.tgl_kegiatan
                                                                }}
                                                            </td>
                                                            <td>
                                                                {{
                                                                    item.uraian_kegiatan
                                                                }}
                                                            </td>
                                                            <td>
                                                                {{
                                                                    item.persentase_kegiatan
                                                                }}%
                                                            </td>
                                                            <td>
                                                                Berkas Kegiatan
                                                            </td>
                                                            <td>Ukuran</td>
                                                            <td>
                                                                Tanggal Upload
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
</template>
<style lang=""></style>
