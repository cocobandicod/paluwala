<template>
    <div>
        <nav
            class="navbar navbar-expand-lg navbar-landing fixed-top"
            id="navbar"
        >
            <div class="container">
                <a class="navbar-brand" href="">
                    <img
                        src="/src/assets/images/logo-dark.png"
                        class="card-logo card-logo-dark"
                        alt="logo dark"
                        height="25"
                    />
                </a>
                <button
                    class="navbar-toggler fs-24 text-body"
                    type="button"
                    data-bs-toggle="collapse"
                    data-bs-target="#navbarSupportedContent"
                    aria-controls="navbarSupportedContent"
                    aria-expanded="false"
                    aria-label="Toggle navigation"
                >
                    <i class="mdi mdi-menu"></i>
                </button>

                <div
                    class="collapse navbar-collapse"
                    id="navbarSupportedContent"
                >
                    <ul
                        class="navbar-nav mx-auto mt-2 mt-lg-0"
                        id="navbar-example"
                    >
                        <li class="nav-item">
                            <router-link
                                type="button"
                                :to="{ name: 'home' }"
                                class="nav-link"
                                :class="{ active: isActive('/') }"
                            >
                                Home
                            </router-link>
                        </li>
                        <li class="nav-item">
                            <router-link
                                type="button"
                                :to="{ name: 'panduan' }"
                                class="nav-link"
                                :class="{ active: isActive('/panduan') }"
                            >
                                Panduan
                            </router-link>
                        </li>
                        <li class="nav-item">
                            <router-link
                                type="button"
                                :to="{ name: 'berita' }"
                                class="nav-link"
                                :class="{ active: isActive('/berita') }"
                            >
                                Berita
                            </router-link>
                        </li>
                        <li class="nav-item">
                            <router-link
                                type="button"
                                :to="{ name: 'pengumuman' }"
                                class="nav-link"
                                :class="{ active: isActive('/pengumuman') }"
                            >
                                Pengumuman
                            </router-link>
                        </li>
                    </ul>

                    <div class="">
                        <router-link
                            type="button"
                            :to="{ name: 'Login' }"
                            class="btn btn-success"
                        >
                            Login
                        </router-link>
                    </div>
                </div>
            </div>
        </nav>
        <!-- end navbar -->
        <div
            class="vertical-overlay"
            data-bs-toggle="collapse"
            data-bs-target="#navbarSupportedContent.show"
        ></div>
    </div>
</template>
<script>
export default {
    methods: {
        isActive(route) {
            return this.$route.path === route;
        },
    },
};
</script>
<style lang=""></style>
