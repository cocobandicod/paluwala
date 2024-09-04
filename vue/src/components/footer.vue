<script setup>
import { thnsekarang } from "../utils/globalFunctions";
</script>
<template>
    <!-- Start footer -->
    <footer class="custom-footer bg-dark py-5 position-relative">
        <div class="container">
            <div class="row">
                <div class="col-lg-5 mt-4">
                    <div>
                        <div>
                            <img
                                src="/src/assets/images/logo-light.png"
                                alt="logo light"
                                height="25"
                            />
                        </div>
                        <div class="mt-2 fs-13">
                            <p>
                                Penelitian, Pengabdian, Luaran, Pengawasan dan
                                Tata Kelola
                            </p>
                            <p>
                                Lembaga Penelitian dan Pengabdian Kepada
                                Masyarakat<br />Universitas Negeri Gorontalo
                            </p>
                        </div>
                    </div>
                </div>

                <div class="col-lg-7 ms-lg-auto">
                    <div class="row">
                        <div class="col-sm-4 mt-4">
                            <h5 class="text-white mb-0">Menu</h5>
                            <div class="text-muted mt-3">
                                <ul
                                    class="list-unstyled ff-secondary footer-list"
                                >
                                    <li>
                                        <router-link :to="`panduan`">
                                            Panduan
                                        </router-link>
                                    </li>
                                    <li>
                                        <router-link :to="`berita`">
                                            Berita
                                        </router-link>
                                    </li>
                                    <li>
                                        <router-link :to="`pengumuman`">
                                            Pengumuman
                                        </router-link>
                                    </li>
                                </ul>
                            </div>
                        </div>
                        <div class="col-sm-4 mt-4">
                            <h5 class="text-white mb-0">Tautan</h5>
                            <div class="text-muted mt-3">
                                <ul
                                    class="list-unstyled ff-secondary footer-list"
                                >
                                    <li>
                                        <a href="https://ung.ac.id"
                                            >Universitas Negeri Gorontalo</a
                                        >
                                    </li>
                                    <li>
                                        <a href="https://lppm.ung.ac.id"
                                            >LPPM</a
                                        >
                                    </li>
                                    <li>
                                        <a href="https://siat.ung.ac.id"
                                            >SIAT</a
                                        >
                                    </li>
                                    <li>
                                        <a href="https://simlit.ung.ac.id"
                                            >SIMLIT</a
                                        >
                                    </li>
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="row text-center text-sm-start align-items-center mt-5">
                <div class="col-sm-12">
                    <div>
                        <p class="copy-rights mb-0">
                            {{ thnsekarang() }} LP2M - Paluwala
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </footer>
    <!-- end footer -->
</template>
