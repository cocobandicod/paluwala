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

const rab = ref({
    id: null,
    kelompok_rab: "",
});

const detail_edit_rab = async () => {
    if (!props.dataId) return; // Make sure exists
    try {
        isLoading.value = true;
        const response = await api.get(`/api/kelompokrabform/${props.dataId}`);
        rab.value = response.data.data;
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
const update_rab = async () => {
    btnloading.value = true;
    let formData = new FormData();
    formData.append("kelompok_rab", rab.value.kelompok_rab);
    formData.append("_method", "PATCH");
    try {
        await api.post(`/api/kelompokrabform/${props.dataId}`, formData);
        showToast("Data berhasil disimpan", "#4fbe87");
        emit("refreshTabel");
        // Close modal (optional)
        const modalElement = document.getElementById("FormRabEdit");
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
    rab.value = {
        id: null,
        kelompok_rab: "",
    };
};

watch(
    () => props.dataId,
    (newId) => {
        if (newId) {
            detail_edit_rab(); // Load data whenever Id changes
        }
    }
);
</script>
<template>
    <div
        class="modal fade zoomIn"
        data-bs-backdrop="static"
        id="FormRabEdit"
        tabindex="-1"
        aria-labelledby="exampleModalLabel"
        aria-hidden="true"
        ref="modalRef"
    >
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header p-3 bg-success-subtle">
                    <h5 class="modal-title" id="createFolderModalLabel">
                        Ubah Kelompok RAB
                    </h5>
                </div>
                <form @submit.prevent="update_rab()">
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
                                        >Kelompok RAB</label
                                    >
                                    <input
                                        type="text"
                                        class="form-control"
                                        v-model="rab.kelompok_rab"
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
