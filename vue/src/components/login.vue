<script setup>
import { ref } from "vue";
import { useRouter } from "vue-router";
import api from "../api"; // Sesuaikan dengan path api Anda
import { thnsekarang } from "../utils/globalFunctions";

const username = ref("");
const password = ref("");
const errorMessage = ref("");
const isLoading = ref(false);
const router = useRouter();

const login = async () => {
    isLoading.value = true; // Set isLoading ke true saat proses login dimulai
    errorMessage.value = ""; // Kosongkan pesan error sebelumnya

    try {
        const response = await api.post("/api/login", {
            username: username.value,
            password: password.value,
        });

        const { token, id_user, hak_akses, nama_pengguna } = response.data;

        // Simpan token, hak_akses, dan nama_pengguna di localStorage
        localStorage.setItem("token", token);
        localStorage.setItem("id_user", id_user);
        localStorage.setItem("hak_akses", hak_akses);
        localStorage.setItem("nama_pengguna", nama_pengguna);

        // Alihkan pengguna berdasarkan hak_akses mereka
        if (hak_akses === "Pengusul") {
            router.push("/pengusul/dashboard").then(() => {
                window.location.reload();
            });
        } else if (hak_akses === "Reviewer") {
            router.push("/reviewer/dashboard").then(() => {
                window.location.reload();
            });
        } else if (hak_akses === "Operator") {
            router.push("/operator/dashboard").then(() => {
                window.location.reload();
            });
        } else {
            errorMessage.value = "Login Gagal! username dan password salah";
        }
    } catch (error) {
        errorMessage.value = "Login Gagal! username dan password salah";
    } finally {
        isLoading.value = false; // Set isLoading ke false setelah proses selesai
    }
};
</script>

<template>
    <div class="auth-page-wrapper pt-5">
        <!-- auth page content -->
        <div class="auth-page-content">
            <div class="container">
                <div class="row justify-content-center">
                    <div class="col-md-8 col-lg-6 col-xl-5">
                        <div class="card mt-4">
                            <div class="card-body p-4">
                                <div class="text-center mt-2">
                                    <img
                                        src="/src/assets/images/logo-dark.png"
                                        height="30"
                                    />
                                    <h5 class="text-primary pt-3">
                                        Selamat Datang di Aplikasi Paluwala
                                    </h5>
                                    <p class="text-muted">
                                        Penelitian, Pengabdian, Luaran,
                                        Pengawasan dan Tata Kelola<br />
                                        Universitas Negeri Gorontalo
                                    </p>
                                </div>
                                <div class="p-2 mt-0">
                                    <form @submit.prevent="login">
                                        <!-- Dark Alert -->
                                        <div
                                            class="alert alert-danger text-center"
                                            role="alert"
                                            v-if="errorMessage"
                                        >
                                            {{ errorMessage }}
                                        </div>
                                        <div class="mb-3">
                                            <label class="form-label"
                                                >Username</label
                                            >
                                            <input
                                                type="text"
                                                class="form-control"
                                                v-model="username"
                                                placeholder="Enter username"
                                                required
                                            />
                                        </div>

                                        <div class="mb-3">
                                            <label
                                                class="form-label"
                                                for="password-input"
                                                >Password</label
                                            >
                                            <div
                                                class="position-relative auth-pass-inputgroup mb-3"
                                            >
                                                <input
                                                    type="password"
                                                    class="form-control pe-5 password-input"
                                                    placeholder="Enter password"
                                                    v-model="password"
                                                    required
                                                />
                                                <button
                                                    class="btn btn-link position-absolute end-0 top-0 text-decoration-none text-muted password-addon"
                                                    type="button"
                                                    id="password-addon"
                                                >
                                                    <i
                                                        class="ri-eye-fill align-middle"
                                                    ></i>
                                                </button>
                                            </div>
                                        </div>
                                        <!--
                                        <div class="form-check">
                                            <input
                                                class="form-check-input"
                                                type="checkbox"
                                                value=""
                                                id="auth-remember-check"
                                            />
                                            <label
                                                class="form-check-label"
                                                for="auth-remember-check"
                                                >Remember me</label
                                            >
                                        </div>
                                        -->
                                        <div class="mt-4">
                                            <button
                                                :disabled="isLoading"
                                                class="btn btn-success w-100"
                                                type="submit"
                                            >
                                                <span v-if="isLoading">
                                                    <i
                                                        class="mdi mdi-spin mdi-loading"
                                                    ></i>
                                                    Loading...
                                                </span>
                                                <span v-else>Log In</span>
                                            </button>
                                            <button
                                                class="btn btn-danger mt-2 w-100"
                                            >
                                                Sambukan ke PlanetUNG
                                            </button>
                                        </div>
                                    </form>
                                </div>
                            </div>
                            <!-- end card body -->
                        </div>
                        <!-- end card -->
                    </div>
                </div>
                <!-- end row -->
            </div>
            <!-- end container -->
        </div>
        <!-- end auth page content -->
        <!-- footer -->
        <footer class="footer">
            <div class="container">
                <div class="row">
                    <div class="col-lg-12">
                        <div class="text-center">
                            <p class="mb-0 text-muted">
                                &copy; {{ thnsekarang() }} Paluwala LPPM
                                Universitas Negeri Gorontalo
                            </p>
                        </div>
                    </div>
                </div>
            </div>
        </footer>
        <!-- end Footer -->
    </div>
    <!-- end auth-page-wrapper -->
</template>
