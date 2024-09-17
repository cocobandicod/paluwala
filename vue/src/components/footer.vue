<script setup>
import { ref, onMounted } from "vue";
import api from "../api";
import { thnsekarang } from "../utils/globalFunctions";
const link = ref([]);
const fetchDataLink = async () => {
    try {
        const response = await api.get("/api/link");
        link.value = response.data.data.data;
    } catch (error) {
        console.error("Error fetching link data:", error);
    }
};

onMounted(() => {
    fetchDataLink();
});
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
                                    <li
                                        v-for="(link, index) in link"
                                        :key="index"
                                    >
                                        <a :href="link.link" target="_blank">{{
                                            link.judul
                                        }}</a>
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
