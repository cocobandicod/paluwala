<script setup>
import { ref, defineEmits } from "vue";
import api from "../../../api";
import { showToast } from "../../../utils/globalFunctions";

const btnloading = ref(false);
const rab = ref({
    id: null,
    kelompok_rab: "",
});

const emit = defineEmits(["refreshTabel"]);

//method "INSERT"
const add_rab = async () => {
    btnloading.value = true;
    let formData = new FormData();
    formData.append("kelompok_rab", rab.value.kelompok_rab);
    try {
        await api.post(`/api/kelompokrabform`, formData);
        showToast("Data berhasil disimpan", "#4fbe87");
        emit("refreshTabel");
        clearFormInput();
        // Close modal (optional)
        const modalElement = document.getElementById("FormRabAdd");
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
</script>
<template>
    <div
        class="modal fade zoomIn"
        data-bs-backdrop="static"
        id="FormRabAdd"
        tabindex="-1"
        aria-labelledby="exampleModalLabel"
        aria-hidden="true"
        ref="modalRef"
    >
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header p-3 bg-success-subtle">
                    <h5 class="modal-title" id="createFolderModalLabel">
                        Tambah Kelompok RAB
                    </h5>
                </div>
                <form @submit.prevent="add_rab()">
                    <div class="modal-body">
                        <div class="row">
                            <div class="col-lg-12 mb-2">
                                <label class="form-label">Kelompok RAB</label>
                                <input
                                    type="text"
                                    class="form-control"
                                    v-model="rab.kelompok_rab"
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
