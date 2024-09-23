<script setup>
import { ref, defineEmits } from "vue";
import api from "../../../api";
import { showToast } from "../../../utils/globalFunctions";

const btnloading = ref(false);
const skema = ref({
    id: null,
    nama_skema: "",
    tahun: "",
    kegiatan: "",
});

const emit = defineEmits(["refresh"]);

//method "INSERT"
const add_skema = async () => {
    btnloading.value = true;
    let formData = new FormData();
    formData.append("nama_skema", skema.value.nama_skema);
    formData.append("tahun", skema.value.tahun);
    formData.append("kegiatan", skema.value.kegiatan);
    try {
        await api.post(`/api/skemaform`, formData);
        showToast("Data berhasil disimpan", "#4fbe87");
        emit("refresh");
        clearFormInput();
        // Close modal (optional)
        const modalElement = document.getElementById("FormSkemaAdd");
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
</script>
<template>
    <div
        class="modal fade zoomIn"
        data-bs-backdrop="static"
        id="FormSkemaAdd"
        tabindex="-1"
        aria-labelledby="exampleModalLabel"
        aria-hidden="true"
        ref="modalRef"
    >
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header p-3 bg-success-subtle">
                    <h5 class="modal-title" id="createFolderModalLabel">
                        Tambah Skema
                    </h5>
                </div>
                <form @submit.prevent="add_skema()">
                    <div class="modal-body">
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
                    <div class="modal-footer">
                        <button
                            type="button"
                            class="btn btn-light"
                            data-bs-dismiss="modal"
                            @click="clearFormInput"
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
