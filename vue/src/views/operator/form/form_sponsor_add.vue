<script setup>
import { ref, defineEmits } from "vue";
import api from "../../../api";
import { showToast, showAlert } from "../../../utils/globalFunctions";

const btnloading = ref(false);
const sponsor = ref({
    id: null,
    judul: "",
    image: null,
});

const emit = defineEmits(["refreshTabel"]);

const allowedFormats = ["image/jpeg", "image/png"]; // Allowed formats
const maxSize = 1 * 1024 * 1024; // 2MB in bytes

const handleFileChange = (e) => {
    const file = e.target.files[0];

    if (!file) {
        sponsor.value.image = null; // Clear file if no file is selected
        return;
    }

    // Check file size
    if (file.size > maxSize) {
        showAlert("Perhatian!", "Ukuran file harus kurang dari 1MB", "info");
        e.target.value = null; // Clear file input
        return;
    }

    // Check file format
    if (!allowedFormats.includes(file.type)) {
        showAlert("Perhatian!", "Format file harus JPG atau PNG", "info");
        e.target.value = null; // Clear file input
        return;
    }

    // Assign valid file to sponsor.image
    sponsor.value.image = file;
};

//method "INSERT"
const add_sponsor = async () => {
    btnloading.value = true;
    let formData = new FormData();
    formData.append("judul", sponsor.value.judul);
    formData.append("image", sponsor.value.image);
    try {
        await api.post(`/api/sponsorform`, formData);
        showToast("Data berhasil disimpan", "#4fbe87");
        emit("refreshTabel");

        clearFormInput();

        // Close modal (optional)
        const modalElement = document.getElementById("FormSponsorAdd");
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
    sponsor.value = {
        id: null,
        judul: "",
        image: null,
    };
    document.querySelector('input[type="file"]').value = "";
};
</script>
<template>
    <div
        class="modal fade zoomIn"
        data-bs-backdrop="static"
        id="FormSponsorAdd"
        tabindex="-1"
        aria-labelledby="exampleModalLabel"
        aria-hidden="true"
        ref="modalRef"
    >
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header p-3 bg-success-subtle">
                    <h5 class="modal-title" id="createFolderModalLabel">
                        Tambah Sponsor
                    </h5>
                </div>
                <form @submit.prevent="add_sponsor()">
                    <div class="modal-body">
                        <div class="row">
                            <div class="col-lg-12 mb-2">
                                <label class="form-label">Judul</label>
                                <input
                                    type="text"
                                    class="form-control"
                                    v-model="sponsor.judul"
                                    required
                                />
                            </div>
                            <div class="col-lg-12 mb-2">
                                <label for="nameInput" class="form-label"
                                    >Upload Gambar</label
                                >
                                <input
                                    type="file"
                                    class="form-control"
                                    @change="handleFileChange($event)"
                                    required
                                />
                                <div class="form-text">
                                    * Format JPG, PNG, dengan ukuran kurang 1 Mb
                                </div>
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
