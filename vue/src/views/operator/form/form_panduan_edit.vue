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

const panduan = ref({
    id: null,
    judul_panduan: "",
    youtube: "",
});

const detail_edit_panduan = async () => {
    if (!props.dataId) return; // Make sure exists
    try {
        isLoading.value = true;
        const response = await api.get(`/api/panduanform/${props.dataId}`);
        panduan.value = response.data.data;
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

const emit = defineEmits(["refreshTabel"]);

//method "INSERT"
const update_panduan = async () => {
    btnloading.value = true;
    let formData = new FormData();
    formData.append("judul_panduan", panduan.value.judul_panduan);
    formData.append("youtube", panduan.value.youtube);
    formData.append("_method", "PATCH");

    try {
        await api.post(`/api/panduanform/${props.dataId}`, formData);
        showToast("Data berhasil disimpan", "#4fbe87");
        emit("refreshTabel");
        // Close modal (optional)
        const modalElement = document.getElementById("FormPanduanEdit");
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

watch(
    () => props.dataId,
    (newId) => {
        if (newId) {
            detail_edit_panduan(); // Load data whenever Id changes
        }
    }
);
</script>
<template>
    <div
        class="modal fade zoomIn"
        data-bs-backdrop="static"
        id="FormPanduanEdit"
        tabindex="-1"
        aria-labelledby="exampleModalLabel"
        aria-hidden="true"
        ref="modalRef"
    >
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header p-3 bg-success-subtle">
                    <h5 class="modal-title" id="createFolderModalLabel">
                        Ubah panduan
                    </h5>
                </div>
                <form @submit.prevent="update_panduan()">
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
                                    <label class="form-label"
                                        >Judul Panduan</label
                                    >
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
