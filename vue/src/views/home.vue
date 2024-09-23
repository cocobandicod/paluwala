<script setup>
import { ref, onMounted } from "vue";
import api from "../api";
import GlobalFooter from "../components/footer.vue";

const sponsor = ref([]);
const berita = ref([]);
const pengumuman = ref([]);
const isLoading = ref(true);

const fetchDataHome = async () => {
    try {
        const response = await api.get("/api/home");
        sponsor.value = response.data.data.sponsor;
        berita.value = response.data.data.berita;
        pengumuman.value = response.data.data.pengumuman;
    } catch (error) {
        console.error("Error fetching sponsor data:", error);
    } finally {
        isLoading.value = false;
    }
};

const isFileAvailable = (url) => {
    // Memastikan URL tidak hanya mengarah ke direktori
    return url && !url.endsWith("/storage/pengumuman");
};

onMounted(() => {
    fetchDataHome();
});
</script>
<template>
    <!-- start hero section -->
    <section class="section pb-0 hero-section pb-5">
        <div class="bg-overlay bg-overlay-pattern"></div>
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-lg-8 col-sm-10">
                    <div class="text-center mt-lg-5 pt-5">
                        <h1 class="display-6 fw-semibold mb-3 lh-base">
                            Selamat Datang di Aplikasi
                            <span class="text-success">Paluwala </span>
                        </h1>
                        <p class="lead text-muted lh-base">
                            Penelitian, Pengabdian, Luaran, Pengawasan dan Tata
                            Kelola<br />Lembaga Penelitian dan Pengabdian Kepada
                            Masyarakat<br />Universitas Negeri Gorontalo
                        </p>

                        <div class="d-flex gap-2 justify-content-center mt-5">
                            <router-link
                                :to="{ name: 'LowonganPenelitian' }"
                                class="btn btn-danger"
                            >
                                Lowongan Penelitian
                                <i class="ri-eye-line align-middle ms-1"></i>
                            </router-link>
                            <router-link
                                :to="{ name: 'Login' }"
                                class="btn btn-info"
                            >
                                Ajukan Proposal
                                <i
                                    class="ri-arrow-right-line align-middle ms-1"
                                ></i>
                            </router-link>
                            <router-link
                                :to="{ name: 'LowonganPengabdian' }"
                                class="btn btn-warning"
                            >
                                Lowongan Pengabdian
                                <i class="ri-eye-line align-middle ms-1"></i>
                            </router-link>
                        </div>
                    </div>
                </div>
            </div>
            <!-- end row -->
        </div>
        <!-- end container -->
        <div class="pb-5"></div>
    </section>
    <!-- end hero section -->

    <!-- start client section -->
    <div class="mt-2 bg-white">
        <div class="container">
            <div class="row">
                <div class="col-lg-12">
                    <div class="text-center mt-5 mb-5">
                        <!-- Swiper -->
                        <div
                            v-if="isLoading"
                            class="d-flex justify-content-center"
                        >
                            <div class="spinner-border" role="status">
                                <span class="visually-hidden">Loading...</span>
                            </div>
                        </div>
                        <swiper
                            :slides-per-view="5"
                            :space-between="50"
                            :autoplay="{
                                delay: 100,
                                disableOnInteraction: false,
                            }"
                            @swiper="onSwiper"
                            @slideChange="onSlideChange"
                        >
                            <swiper-slide
                                v-for="(item, index) in sponsor"
                                :key="index"
                            >
                                <div class="client-images">
                                    <img
                                        :src="item.image"
                                        alt="client-img"
                                        class="mx-auto img-fluid d-block"
                                    />
                                </div>
                            </swiper-slide>
                            ...
                        </swiper>
                    </div>
                </div>
            </div>
            <!-- end row -->
        </div>
        <!-- end container -->
    </div>
    <!-- end client section -->
    <!-- start plan -->
    <section class="section bg-light">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-lg-8">
                    <div class="text-center mb-5">
                        <h3 class="mb-3 fw-semibold">Berita Terbaru</h3>
                        <p class="text-muted mb-4">
                            Berita terbaru terkait dengan aturan maupun
                            informasi Penelitian dan Pengabdian kepada
                            Masyarakat.
                        </p>
                    </div>
                </div>
                <!-- end col -->
            </div>
            <!-- end row -->

            <div class="row gy-4">
                <div v-if="isLoading" class="d-flex justify-content-center">
                    <div class="spinner-border" role="status">
                        <span class="visually-hidden">Loading...</span>
                    </div>
                </div>
                <div
                    v-else
                    class="col-lg-4"
                    v-for="(berita, index) in berita"
                    :key="index"
                >
                    <div class="card mb-0">
                        <div class="card-body p-2 m-2">
                            <img
                                :src="berita.image"
                                class="img-fluid rounded"
                                alt="Responsive image"
                            />
                            <div class="d-flex align-items-center pt-3">
                                <div class="flex-grow-1">
                                    <router-link
                                        :to="{
                                            name: 'BeritaDetail',
                                            params: {
                                                slug: berita.judul_seo,
                                            },
                                        }"
                                        class="text-decoration-none"
                                    >
                                        <h4 class="mb-1 fw-semibold">
                                            {{ berita.judul_berita }}
                                        </h4>
                                    </router-link>
                                    <p class="text-muted fs-13 mb-0 mt-2">
                                        <i
                                            class="ri-calendar-todo-fill me-1"
                                        ></i>
                                        {{
                                            formatTanggalsaja(berita.tgl_berita)
                                        }}
                                        {{ berita.jam_berita }}
                                        <i
                                            class="ri-account-circle-line ms-2 me-1"
                                        ></i>
                                        {{ berita.user.name }}
                                    </p>
                                </div>
                            </div>
                            <p class="pt-2 text-muted">
                                {{
                                    stripHtmlTags(
                                        truncateText(berita.isi_berita, 120)
                                    )
                                }}
                            </p>
                            <div>
                                <div class="mt-4">
                                    <router-link
                                        :to="{
                                            name: 'BeritaDetail',
                                            params: {
                                                slug: berita.judul_seo,
                                            },
                                        }"
                                        class="btn btn-soft-success w-100"
                                    >
                                        Read More
                                    </router-link>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <!--end col-->

                <div class="hstack gap-2 justify-content-center">
                    <router-link
                        type="button"
                        :to="{ name: 'berita' }"
                        class="btn btn-success btn-label rounded-pill"
                    >
                        <i
                            class="ri-newspaper-line label-icon align-middle rounded-pill fs-16 me-2"
                        ></i>
                        Lihat Berita lainnya
                    </router-link>
                </div>

                <!--end col-->
            </div>
            <!--end row-->
        </div>
        <!-- end container -->
    </section>
    <!-- end plan -->
    <!-- start plan -->
    <section class="section bg-white">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-lg-8">
                    <div class="text-center mb-5">
                        <h3 class="mb-3 fw-semibold">Pengumuman Terbaru</h3>
                        <p class="text-muted mb-4">
                            Pengumuman Terbaru terkait dengan aturan maupun
                            informasi Penelitian dan Pengabdian kepada
                            Masyarakat.
                        </p>
                    </div>
                </div>
                <!-- end col -->
            </div>
            <!-- end row -->

            <div class="row gy-4 pt-4">
                <div v-if="isLoading" class="d-flex justify-content-center">
                    <div class="spinner-border" role="status">
                        <span class="visually-hidden">Loading...</span>
                    </div>
                </div>
                <div
                    v-else
                    class="accordion custom-accordionwithicon custom-accordion-border accordion-border-box mt-2"
                    id="genques-accordion"
                    v-for="(pengumuman, index) in pengumuman"
                    :key="index"
                >
                    <div class="accordion-item">
                        <h2
                            class="accordion-header"
                            :id="'genques-heading' + index"
                        >
                            <button
                                class="accordion-button collapsed"
                                type="button"
                                data-bs-toggle="collapse"
                                :data-bs-target="'#genques-collapse' + index"
                                aria-expanded="false"
                                :aria-controls="'genques-collapse' + index"
                            >
                                <div class="row">
                                    <div class="col-lg-12 fs-14">
                                        {{ pengumuman.judul_pengumuman }}
                                    </div>
                                    <div class="col-lg-12 pt-2 text-muted">
                                        <i
                                            class="ri-calendar-todo-fill me-1"
                                        ></i>
                                        {{
                                            formatTanggalsaja(
                                                pengumuman.tgl_pengumuman
                                            )
                                        }}
                                        <i
                                            class="ri-account-circle-line ms-2 me-1"
                                        ></i>
                                        {{ pengumuman.user.name }}
                                    </div>
                                </div>
                            </button>
                        </h2>
                        <div
                            :id="'genques-collapse' + index"
                            class="accordion-collapse collapse"
                            :aria-labelledby="'genques-heading' + index"
                            data-bs-parent="#genques-accordion"
                        >
                            <div class="accordion-body ff-secondary text-black">
                                <p v-html="pengumuman.isi_pengumuman"></p>
                                <div
                                    class="col-lg-12 pt-2 text-muted"
                                    v-if="
                                        isFileAvailable(
                                            pengumuman.file_pengumuman
                                        )
                                    "
                                >
                                    <a
                                        :href="pengumuman.file_pengumuman"
                                        class="btn btn-danger btn-label rounded-pill"
                                        target="_blank"
                                        download
                                    >
                                        <i
                                            class="ri-file-download-line label-icon align-middle rounded-pill me-2"
                                        ></i>
                                        Unduh Dokumen
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <!--end col-->

                <div class="hstack gap-2 justify-content-center">
                    <router-link
                        type="button"
                        :to="{ name: 'pengumuman' }"
                        class="btn btn-success btn-label rounded-pill"
                    >
                        <i
                            class="ri-newspaper-line label-icon align-middle rounded-pill fs-16 me-2"
                        ></i>
                        Lihat Pengumuman lainnya
                    </router-link>
                </div>
                <!--end col-->
            </div>
            <!--end row-->
        </div>
        <!-- end container -->
    </section>
    <!-- end plan -->

    <!-- start Work Process -->
    <section class="section bg-light">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-lg-8">
                    <div class="text-center mb-5">
                        <h3 class="mb-3 fw-semibold">
                            Bagaimana Paluwala Bekerja?
                        </h3>
                        <p class="text-muted mb-4 ff-secondary">
                            Paluwala memiliki fitur-fitur yang mudah digunakan
                            untuk membantu Anda mengatur dan mengontrol akun
                            Anda secara online.
                        </p>
                    </div>
                </div>
            </div>
            <!-- end row -->

            <div class="row text-center">
                <div class="col-lg-4">
                    <div class="process-card mt-4">
                        <div class="process-arrow-img d-none d-lg-block">
                            <img
                                src="/src/assets/images/landing/process-arrow-img.png"
                                alt=""
                                class="img-fluid"
                            />
                        </div>
                        <div class="avatar-sm icon-effect mx-auto mb-4">
                            <div
                                class="avatar-title bg-transparent text-success rounded-circle h1"
                            >
                                <i class="ri-quill-pen-line"></i>
                            </div>
                        </div>

                        <h5>
                            Usulan Proposal Penelitian dan Pengabdian kepada
                            Masyarakat
                        </h5>
                        <p class="text-muted ff-secondary">
                            Dosen membuat Usulan Proposal Penelitian dan
                            Pengabdian kepada Masyarakat untuk diajukan kepada
                            Kemdikbudristek
                        </p>
                    </div>
                </div>
                <!-- end col -->
                <div class="col-lg-4">
                    <div class="process-card mt-4">
                        <div class="process-arrow-img d-none d-lg-block">
                            <img
                                src="/src/assets/images/landing/process-arrow-img.png"
                                alt=""
                                class="img-fluid"
                            />
                        </div>
                        <div class="avatar-sm icon-effect mx-auto mb-4">
                            <div
                                class="avatar-title bg-transparent text-success rounded-circle h1"
                            >
                                <i class="ri-user-follow-line"></i>
                            </div>
                        </div>

                        <h5>Review Usulan Proposal</h5>
                        <p class="text-muted ff-secondary">
                            Usulan Proposal Penelitian dan Pengabdian kepada
                            Masyarakat dinilai oleh Reviewer Universitas Negeri
                            Gorontalo
                        </p>
                    </div>
                </div>
                <!-- end col -->
                <div class="col-lg-4">
                    <div class="process-card mt-4">
                        <div class="avatar-sm icon-effect mx-auto mb-4">
                            <div
                                class="avatar-title bg-transparent text-success rounded-circle h1"
                            >
                                <i class="ri-book-mark-line"></i>
                            </div>
                        </div>

                        <h5>Laporan Pelaksanaan Kegiatan</h5>
                        <p class="text-muted ff-secondary">
                            Laporan pelaksanaan Kegiatan Proposal Penelitian dan
                            Pengabdian kepada Masyarakat yang didanai tercatat
                            dengan baik
                        </p>
                    </div>
                </div>
                <!-- end col -->
            </div>
            <!-- end row -->
        </div>
        <!-- end container -->
    </section>
    <!-- end Work Process -->

    <!-- Start footer -->
    <GlobalFooter />
    <!-- end footer -->

    <!-- Include the Modal Component -->
</template>
<script>
// Import Swiper Vue.js components
import { Swiper, SwiperSlide } from "swiper/vue";
import {
    formatTanggal,
    formatTanggalsaja,
    truncateText,
    stripHtmlTags,
} from "../utils/globalFunctions";

// Import Swiper styles
import "swiper/css";

export default {
    name: "home",
    components: {
        Swiper,
        SwiperSlide,
    },
    setup() {
        const onSwiper = (swiper) => {
            console.log(swiper);
        };

        const onSlideChange = () => {
            console.log("slide change");
        };

        return {
            onSwiper,
            onSlideChange,
        };
    },

    methods: {
        formatTanggal,
        truncateText,
    },
};
</script>
