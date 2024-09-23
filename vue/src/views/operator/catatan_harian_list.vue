<script setup>
import { ref, onMounted } from "vue";
import { useRoute, useRouter } from "vue-router";
import api from "../../api";
import "datatables.net-bs5";
import $ from "jquery";
import { formatRupiah } from "../../utils/globalFunctions";

const route = useRoute();
const router = useRouter(); // Inisialisasi router
const isLoading = ref(true);
const usulan = ref([]);
const skema = ref([]);

const catatan_harian = async () => {
    try {
        const response = await api.get(
            `/api/catatanharianlist/${route.params.kode}`
        );
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
                className: "text-center p-2",
                width: "8%",
                targets: [4],
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
                                        {{ skema.nama_skema }} Tahun Pelaksanaan
                                        {{ skema.tahun }}
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
                                            <div class="table-responsive">
                                                <table
                                                    id="DTable1"
                                                    class="table table-bordered dt-responsive table-striped align-middle fs-12 mb-0"
                                                    style="width: 100%"
                                                >
                                                    <thead class="table-light">
                                                        <tr>
                                                            <th>No</th>
                                                            <th>Pengusul</th>
                                                            <th>Judul</th>
                                                            <th>Keterangan</th>
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
                                                                {{ index + 1 }}
                                                            </td>
                                                            <td>
                                                                <p class="mb-0">
                                                                    <b>
                                                                        {{
                                                                            item.nama_ketua
                                                                        }}
                                                                    </b>
                                                                </p>
                                                                NIDN :
                                                                {{
                                                                    item.nomor_nidn
                                                                }}
                                                            </td>
                                                            <td>
                                                                <b>{{
                                                                    item.judul
                                                                }}</b>
                                                                <div
                                                                    class="flex-grow-1"
                                                                >
                                                                    Dana Hibah :
                                                                    <b
                                                                        class="text-success-emphasis"
                                                                        >Rp.
                                                                        {{
                                                                            formatRupiah(
                                                                                item.dana_disetujui
                                                                            )
                                                                        }}</b
                                                                    >
                                                                </div>
                                                            </td>
                                                            <td>
                                                                <p class="mb-0">
                                                                    Jumlah
                                                                    Catatan :
                                                                    {{
                                                                        item.jumlah_catatan
                                                                    }}
                                                                </p>
                                                                <p class="mb-0">
                                                                    Persentase
                                                                    Capaian :
                                                                    {{
                                                                        item.jumlah_persentase
                                                                    }}%
                                                                </p>
                                                            </td>
                                                            <td>
                                                                <router-link
                                                                    type="button"
                                                                    class="btn btn-soft-secondary btn-sm"
                                                                    :to="{
                                                                        name: 'OperatorCatatanHarianDetail',
                                                                        params: {
                                                                            kode: skema.kode_skema,
                                                                            id: item.kode_usulan,
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
