<script setup>
import { ref, watch, defineEmits } from "vue";
import api from "../../../api";
import { showToast } from "../../../utils/globalFunctions";

const isLoading = ref(true);
const btnloading = ref(false);
const props = defineProps({
    dataId: {
        type: Number,
        required: true,
    },
});

const skema = ref({
    id: null,
    nama_skema: "",
    tahun: "",
    kegiatan: "",
});

const detail_edit_skema = async () => {
    if (!props.dataId) return; // Make sure exists
    try {
        isLoading.value = true;
        const response = await api.get(`/api/skemaform/${props.dataId}`);
        skema.value = response.data.data;
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

const emit = defineEmits(["refresh"]);

//method "INSERT"
const update_skema = async () => {
    btnloading.value = true;
    let formData = new FormData();
    formData.append("nama_skema", skema.value.nama_skema);
    formData.append("tahun", skema.value.tahun);
    formData.append("kegiatan", skema.value.kegiatan);
    formData.append("_method", "PATCH");

    try {
        await api.post(`/api/skemaform/${props.dataId}`, formData);
        showToast("Data berhasil disimpan", "#4fbe87");
        emit("refresh");
        // Close modal (optional)
        const modalElement = document.getElementById("FormSkemaEdit");
        const modalInstance = bootstrap.Modal.getInstance(modalElement);
        if (modalInstance) {
            modalInstance.hide();
        }
    } catch (error) {
        console.error("Error updating data:", error);
        showToast("Gagal menyimpan data", "#ff6b6b");
    } finally {
        btnloading.value = false;
    }
};

const clearFormInput = () => {
    skema.value = {
        id: null,
        nama_skema: "",
        tahun: "",
        kegiatan: "",
    };
};

watch(
    () => props.dataId,
    (newId) => {
        if (newId) {
            detail_edit_skema(); // Load data whenever Id changes
        }
    }
);
</script>
<template>
    <div
        class="modal fade zoomIn"
        data-bs-backdrop="static"
        id="FormSkemaEdit"
        tabindex="-1"
        aria-labelledby="exampleModalLabel"
        aria-hidden="true"
        ref="modalRef"
    >
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header p-3 bg-success-subtle">
                    <h5 class="modal-title" id="createFolderModalLabel">
                        Ubah Skema
                    </h5>
                </div>
                <form @submit.prevent="update_skema()">
                    <div class="modal-body">
                        <div
                            v-if="isLoading"
                            class="d-flex justify-content-center mt-4 mb-4"
                        >
                            <div class="spinner-border" role="status">
                                <span class="visually-hidden">Loading...</span>
                            </div>
                        </div>
                        <div v-else>
                            <div class="row">
                                <div class="col-lg-12 mb-2">
                                    <label class="form-label">Nama Skema</label>
                                    <input
                                        type="text"
                                        class="form-control"
                                        v-model="skema.nama_skema"
                                        required
                                    />
                                </div>
                                <div class="col-lg-6 mb-2">
                                    <label for="nameInput" class="form-label"
                                        >Tahun</label
                                    >
                                    <input
                                        type="number"
                                        class="form-control"
                                        v-model="skema.tahun"
                                        required
                                    />
                                </div>
                                <div class="col-lg-6 mb-2">
                                    <label for="nameInput" class="form-label"
                                        >Kegiatan</label
                                    >
                                    <select
                                        class="form-select"
                                        v-model="skema.kegiatan"
                                        required
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
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button
                            type="button"
                            class="btn btn-light"
                            data-bs-dismiss="modal"
                        >
                            Close
                        </button>
                        <button type="submit" class="btn btn-success">
                            <span v-if="btnloading">
                                <i class="mdi mdi-spin mdi-loading"></i>
                                Loading...
                            </span>
                            <span v-else>
                                <i class="ri-save-line align-bottom me-1"></i>
                                Simpan
                            </span>
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</template>
<style lang=""></style>
