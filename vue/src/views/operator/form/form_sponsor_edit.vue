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

const sponsor = ref({
    id: null,
    judul: "",
    image: null,
});

const detail_edit_sponsor = async () => {
    if (!props.dataId) return; // Make sure id exists
    try {
        isLoading.value = true;
        const response = await api.get(`/api/sponsorform/${props.dataId}`);
        sponsor.value = response.data.data;
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

const allowedFormats = ["image/jpeg", "image/png"]; // Allowed formats
const maxSize = 1 * 1024 * 1024; // 2MB in bytes

const fileInput = ref(null);
const selectedFileName = ref(null); // Nama file yang dipilih
const handleFileChange = (e) => {
    const file = e.target.files[0];

    if (!file) {
        selectedFileName.value = null; // Clear file name if no file is selected
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
    selectedFileName.value = file.name;
    sponsor.value.image = file;
};

const clearFormInput = () => {
    fileInput.value.value = null; // Clear file input by resetting its value
    selectedFileName.value = null;
};

const emit = defineEmits(["refreshTabel"]);

//method "UPDATE"
const update_sponsor = async () => {
    btnloading.value = true;
    let formData = new FormData();
    formData.append("judul", sponsor.value.judul);
    if (sponsor.value.image && sponsor.value.image instanceof File) {
        formData.append("image", sponsor.value.image);
    }
    formData.append("_method", "PATCH");
    try {
        await api.post(`/api/sponsorform/${props.dataId}`, formData);
        showToast("Data berhasil disimpan", "#4fbe87");
        emit("refreshTabel");

        // Close modal (optional)
        const modalElement = document.getElementById("FormSponsorEdit");
        const modalInstance = bootstrap.Modal.getInstance(modalElement);
        if (modalInstance) {
            modalInstance.hide();
        }
    } catch (error) {
        console.error("Error updating data:", error);
        showToast("Gagal menyimpan data", "#ff6b6b");
    } finally {
        btnloading.value = false;
        clearFormInput();
    }
};

const isFileAvailable = (url) => {
    return (
        typeof url === "string" && url.endsWith("/storage/sponsor") === false
    );
};

watch(
    () => props.dataId,
    (newId) => {
        if (newId) {
            detail_edit_sponsor(); // Load data whenever Id changes
        }
    }
);
</script>
<template>
    <div
        class="modal fade zoomIn"
        data-bs-backdrop="static"
        id="FormSponsorEdit"
        tabindex="-1"
        aria-labelledby="exampleModalLabel"
        aria-hidden="true"
        ref="modalRef"
    >
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header p-3 bg-success-subtle">
                    <h5 class="modal-title" id="createFolderModalLabel">
                        Ubah Sponsor
                    </h5>
                </div>
                <form @submit.prevent="update_sponsor()">
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
                                    <div
                                        v-if="
                                            isFileAvailable(sponsor.image) &&
                                            !selectedFileName
                                        "
                                    >
                                        <img
                                            class="img-thumbnail mb-2"
                                            width="600"
                                            :src="sponsor.image"
                                        />
                                    </div>
                                    <!-- Display the selected file name if a new file is chosen -->
                                    <div
                                        v-if="selectedFileName"
                                        class="text-success-emphasis pt-0 pb-2"
                                    >
                                        File yang dipilih:
                                        {{ selectedFileName }}
                                    </div>
                                    <div
                                        v-else
                                        class="text-danger-emphasis pt-2 pb-2"
                                    >
                                        Silahkan upload kembali untuk merubah
                                        File
                                    </div>
                                    <!-- Input file -->
                                    <input
                                        type="file"
                                        ref="fileInput"
                                        class="form-control"
                                        @change="handleFileChange"
                                    />
                                    <div class="form-text">
                                        * Format JPG, PNG, dengan ukuran kurang
                                        1 Mb
                                    </div>
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
