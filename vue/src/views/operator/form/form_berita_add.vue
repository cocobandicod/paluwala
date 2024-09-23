<script setup>
import { ref, defineEmits } from "vue";
import api from "../../../api";
import { showToast, showAlert } from "../../../utils/globalFunctions";
import Editor from "@tinymce/tinymce-vue";

const btnloading = ref(false);
const idUser = ref(localStorage.getItem("id_user"));
const berita = ref({
    id: null,
    judul_berita: "",
    tgl_berita: "",
    isi_berita: "",
    image: null,
});

const emit = defineEmits(["refreshTabel"]);

// TinyMCE
const content = ref(); // Initialize with berita data
const editorInit = {
    height: 500,
    menubar: "edit view format",
    plugins: "image media code table link lists",
    toolbar:
        "undo redo | styles | bold italic | alignleft aligncenter alignright alignjustify | outdent indent | numlist bullist | table | link | code",
    table_toolbar:
        "tableprops tabledelete | tableinsertrowbefore tableinsertrowafter tabledeleterow | tableinsertcolbefore tableinsertcolafter tabledeletecol",
    content_style:
        "body { font-family:Helvetica,Arial,sans-serif; font-size:14px }",
};

const allowedFormats = ["image/jpeg", "image/png"]; // Allowed formats
const maxSize = 2 * 1024 * 1024; // 2MB in bytes

const handleFileChange = (e) => {
    const file = e.target.files[0];

    if (!file) {
        berita.value.image = null; // Clear file if no file is selected
        return;
    }

    // Check file size
    if (file.size > maxSize) {
        showAlert("Perhatian!", "Ukuran file harus kurang dari 2MB", "info");
        e.target.value = null; // Clear file input
        return;
    }

    // Check file format
    if (!allowedFormats.includes(file.type)) {
        showAlert("Perhatian!", "Format file harus JPG atau PNG", "info");
        e.target.value = null; // Clear file input
        return;
    }

    // Assign valid file to berita.image
    berita.value.image = file;
};

//method "INSERT"
const add_berita = async () => {
    btnloading.value = true;
    let formData = new FormData();
    formData.append("id_user", idUser.value);
    formData.append("judul_berita", berita.value.judul_berita);
    formData.append("tgl_berita", berita.value.tgl_berita);
    //formData.append("isi_berita", berita.value.isi_berita);
    formData.append("isi_berita", content.value);
    formData.append("image", berita.value.image);

    // Only append the file if it exists
    if (berita.value.file_berita && berita.value.file_berita instanceof File) {
        formData.append("file_berita", berita.value.file_berita);
    }
    try {
        await api.post(`/api/beritaform`, formData);
        showToast("Data berhasil disimpan", "#4fbe87");
        emit("refreshTabel");
        clearFormInput();
        // Close modal (optional)
        const modalElement = document.getElementById("FormBeritaAdd");
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
    berita.value = {
        id: null,
        judul_berita: "",
        tgl_berita: "",
        isi_berita: "",
        image: null,
    };
    content.value = "";

    document.querySelector('input[type="file"]').value = "";
};
</script>
<template>
    <div
        class="modal fade zoomIn"
        data-bs-backdrop="static"
        id="FormBeritaAdd"
        tabindex="-1"
        aria-labelledby="exampleModalLabel"
        aria-hidden="true"
        ref="modalRef"
    >
        <div class="modal-dialog modal-dialog-centered modal-lg">
            <div class="modal-content">
                <div class="modal-header p-3 bg-success-subtle">
                    <h5 class="modal-title" id="createFolderModalLabel">
                        Tambah berita
                    </h5>
                </div>
                <form @submit.prevent="add_berita()">
                    <div class="modal-body">
                        <div class="row">
                            <div class="col-lg-8 mb-2">
                                <label class="form-label">Judul berita</label>
                                <input
                                    type="text"
                                    class="form-control"
                                    v-model="berita.judul_berita"
                                    required
                                />
                            </div>
                            <div class="col-lg-4 mb-2">
                                <label for="nameInput" class="form-label"
                                    >Tanggal</label
                                >
                                <input
                                    type="date"
                                    class="form-control"
                                    v-model="berita.tgl_berita"
                                    required
                                />
                            </div>
                            <div class="col-lg-12 mb-2">
                                <label for="nameInput" class="form-label"
                                    >Isi Berita</label
                                >
                                <Editor
                                    v-model="content"
                                    api-key="qw6kskzpvqfx4s36csfnlp9jzmhswei0su32l30dl9jvd4sa"
                                    :init="editorInit"
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
                                    * Format JPG, PNG, dengan ukuran kurang 2 Mb
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
