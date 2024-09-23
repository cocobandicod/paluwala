<script setup>
import { ref, defineEmits } from "vue";
import api from "../../../api";
import { showToast } from "../../../utils/globalFunctions";

const btnloading = ref(false);
const tautan = ref({
    id: null,
    judul: "",
    link: "",
});

const emit = defineEmits(["refreshTabel"]);

//method "INSERT"
const add_tautan = async () => {
    btnloading.value = true;
    let formData = new FormData();
    formData.append("judul", tautan.value.judul);
    formData.append("link", tautan.value.link);
    try {
        await api.post(`/api/tautanform`, formData);
        showToast("Data berhasil disimpan", "#4fbe87");
        emit("refreshTabel");
        clearFormInput();
        // Close modal (optional)
        const modalElement = document.getElementById("FormTautanAdd");
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
    tautan.value = {
        id: null,
        judul: "",
        link: "",
    };
};
</script>
<template>
    <div
        class="modal fade zoomIn"
        data-bs-backdrop="static"
        id="FormTautanAdd"
        tabindex="-1"
        aria-labelledby="exampleModalLabel"
        aria-hidden="true"
        ref="modalRef"
    >
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header p-3 bg-success-subtle">
                    <h5 class="modal-title" id="createFolderModalLabel">
                        Tambah Tautan
                    </h5>
                </div>
                <form @submit.prevent="add_tautan()">
                    <div class="modal-body">
                        <div class="row">
                            <div class="col-lg-12 mb-2">
                                <label class="form-label">Judul</label>
                                <input
                                    type="text"
                                    class="form-control"
                                    v-model="tautan.judul"
                                    required
                                />
                            </div>
                            <div class="col-lg-12 mb-2">
                                <label for="nameInput" class="form-label"
                                    >Link</label
                                >
                                <input
                                    type="text"
                                    class="form-control"
                                    v-model="tautan.link"
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
