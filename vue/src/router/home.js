import Home from '../views/home.vue';
import Panduan from '../views/panduan.vue';
import Berita from '../views/berita.vue';
import Pengumuman from '../views/pengumuman.vue';
import LowonganPenelitian from '../views/lowongan_penelitian.vue';
import LowonganPengabdian from '../views/lowongan_pengabdian.vue';
import BeritaDetail from '../views/berita_detail.vue';
import NotFound from '../components/NotFound.vue';
import Login from '../components/login.vue';
import Register from '../components/register.vue';
import Logout from '../components/operator_header.vue';

export default [
  {
    path: '/',
    name: 'home',
    component: Home,
    meta: { title: 'Home | Paluwala LPPM Universitas Negeri Gorontalo' }
  },
  {
    path: '/panduan',
    name: 'panduan',
    component: Panduan,
    meta: { title: 'Panduan | Paluwala LPPM Universitas Negeri Gorontalo' }
  },
  {
    path: '/pengumuman',
    name: 'pengumuman',
    component: Pengumuman,
    meta: { title: 'Pengumuman | Paluwala LPPM Universitas Negeri Gorontalo' }
  },
  {
    path: '/lowongan-penelitian',
    name: 'LowonganPenelitian',
    component: LowonganPenelitian,
    meta: { title: 'Lowongan Penelitian | Paluwala LPPM Universitas Negeri Gorontalo' }
  },
  {
    path: '/lowongan-pengabdian',
    name: 'LowonganPengabdian',
    component: LowonganPengabdian,
    meta: { title: 'Lowongan Pengabdian | Paluwala LPPM Universitas Negeri Gorontalo' }
  },
  {
    path: '/berita',
    name: 'berita',
    component: Berita,
    meta: { title: 'Berita | Paluwala LPPM Universitas Negeri Gorontalo' }
  },
  {
    path: '/berita/:slug',
    name: 'BeritaDetail',
    component: BeritaDetail,
    meta: { title: 'Berita | Paluwala LPPM Universitas Negeri Gorontalo' }
  },
  {
    path: '/login',
    name: 'Login',
    component: Login,
    meta: { title: 'Login | Paluwala LPPM Universitas Negeri Gorontalo' }
  },
  {
    path: '/register',
    name: 'Register',
    component: Register,
    meta: { title: 'Register | Paluwala LPPM Universitas Negeri Gorontalo' }
  },
  {
    path: '/logout',
    name: 'Logout',
    component: Logout,
    meta: { title: 'Logout | Paluwala LPPM Universitas Negeri Gorontalo' }
  },
  // Error Page
  {
    path: '/:pathMatch(.*)*',
    name: 'NotFound',
    component: NotFound,
    meta: { title: '404 Halaman Tidak Ditemukan' }
  }
];
