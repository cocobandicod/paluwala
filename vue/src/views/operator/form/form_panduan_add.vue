<script setup>
import { ref, defineEmits } from "vue";
import api from "../../../api";
import { showToast } from "../../../utils/globalFunctions";

const btnloading = ref(false);
const panduan = ref({
    id: null,
    judul_panduan: "",
    youtube: "",
});

const emit = defineEmits(["refreshTabel"]);

//method "INSERT"
const add_panduan = async () => {
    btnloading.value = true;
    let formData = new FormData();
    formData.append("judul_panduan", panduan.value.judul_panduan);
    formData.append("youtube", panduan.value.youtube);
    try {
        await api.post(`/api/panduanform`, formData);
        showToast("Data berhasil disimpan", "#4fbe87");
        emit("refreshTabel");
        clearFormInput();
        // Close modal (optional)
        const modalElement = document.getElementById("FormPanduanAdd");
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
    panduan.value = {
        id: null,
        judul_panduan: "",
        youtube: "",
    };
};
</script>
<template>
    <div
        class="modal fade zoomIn"
        data-bs-backdrop="static"
        id="FormPanduanAdd"
        tabindex="-1"
        aria-labelledby="exampleModalLabel"
        aria-hidden="true"
        ref="modalRef"
    >
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header p-3 bg-success-subtle">
                    <h5 class="modal-title" id="createFolderModalLabel">
                        Tambah Panduan
                    </h5>
                </div>
                <form @submit.prevent="add_panduan()">
                    <div class="modal-body">
                        <div class="row">
                            <div class="col-lg-12 mb-2">
                                <label class="form-label">Judul Panduan</label>
                                <input
                                    type="text"
                                    class="form-control"
                                    v-model="panduan.judul_panduan"
                                    required
                                />
                            </div>
                            <div class="col-lg-12 mb-2">
                                <label for="nameInput" class="form-label"
                                    >Youtube</label
                                >
                                <input
                                    type="text"
                                    class="form-control"
                                    v-model="panduan.youtube"
                                    required
                                />
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
