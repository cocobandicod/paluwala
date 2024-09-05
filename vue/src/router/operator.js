import OperatorDashboard from '../views/operator/dashboard.vue';
import OperatorPerbaikanUsulan from '../views/operator/perbaikan_usulan.vue';
import OperatorCatatanHarian from '../views/operator/perbaikan_usulan.vue';
import OperatorLaporanKemajuan from '../views/operator/perbaikan_usulan.vue';
import OperatorLaporanAkhir from '../views/operator/perbaikan_usulan.vue';
import OperatorMonevInternal from '../views/operator/perbaikan_usulan.vue';
import OperatorProfilLembaga from '../views/operator/perbaikan_usulan.vue';
import OperatorRab from '../views/operator/perbaikan_usulan.vue';
import OperatorBerita from '../views/operator/perbaikan_usulan.vue';
import OperatorPengumuman from '../views/operator/perbaikan_usulan.vue';
import OperatorPanduan from '../views/operator/perbaikan_usulan.vue';
import OperatorLink from '../views/operator/perbaikan_usulan.vue';
import OperatorBorangPenilaian from '../views/operator/perbaikan_usulan.vue';
import OperatorDaftarReviewer from '../views/operator/perbaikan_usulan.vue';
import OperatorPenugasanReview from '../views/operator/perbaikan_usulan.vue';
import OperatorPlotingReviewer from '../views/operator/perbaikan_usulan.vue';
import OperatorReviewerExternal from '../views/operator/perbaikan_usulan.vue';
import OperatorMonitoringPenilaian from '../views/operator/perbaikan_usulan.vue';

export default [
    // ----------------------------------------------------------------------------------- Operator Page
    {
      path: '/operator/dashboard',
      name: 'OperatorDashboard',
      component: OperatorDashboard,
      meta: { 
          title: 'Operator | Paluwala LPPM Universitas Negeri Gorontalo', 
          requiresAuth: true // Memerlukan autentikasi
      }
    },
    {
      path: '/operator/monitoring/perbaikan-usulan',
      name: 'OperatorPerbaikanUsulan',
      component: OperatorPerbaikanUsulan,
      meta: { 
          title: 'Operator Perbaikan Usulan | Paluwala LPPM Universitas Negeri Gorontalo', 
          requiresAuth: true // Memerlukan autentikasi
      }
    },
    {
      path: '/operator/monitoring/catatan-harian',
      name: 'OperatorCatatanHarian',
      component: OperatorCatatanHarian,
      meta: { 
          title: 'Operator Catatan Harian | Paluwala LPPM Universitas Negeri Gorontalo', 
          requiresAuth: true // Memerlukan autentikasi
      }
    },
    {
      path: '/operator/monitoring/laporan-kemajuan',
      name: 'OperatorLaporanKemajuan',
      component: OperatorLaporanKemajuan,
      meta: { 
          title: 'Operator Laporan Kemajuan | Paluwala LPPM Universitas Negeri Gorontalo', 
          requiresAuth: true // Memerlukan autentikasi
      }
    },
    {
      path: '/operator/monitoring/laporan-akhir',
      name: 'OperatorLaporanAkhir',
      component: OperatorLaporanAkhir,
      meta: { 
          title: 'Operator Laporan Akhir | Paluwala LPPM Universitas Negeri Gorontalo', 
          requiresAuth: true // Memerlukan autentikasi
      }
    },
    {
      path: '/operator/monitoring/monev-internal',
      name: 'OperatorMonevInternal',
      component: OperatorMonevInternal,
      meta: { 
          title: 'Operator Monev Internal | Paluwala LPPM Universitas Negeri Gorontalo', 
          requiresAuth: true // Memerlukan autentikasi
      }
    },
    // ----------------------------------------------------------------------------------- Pendukung Page
    {
      path: '/operator/pendukung/profil-lembaga',
      name: 'OperatorProfilLembaga',
      component: OperatorProfilLembaga,
      meta: { 
          title: 'Operator Profil Lembaga | Paluwala LPPM Universitas Negeri Gorontalo', 
          requiresAuth: true // Memerlukan autentikasi
      }
    },
    {
      path: '/operator/pendukung/rab',
      name: 'OperatorRab',
      component: OperatorRab,
      meta: { 
          title: 'Operator RAB | Paluwala LPPM Universitas Negeri Gorontalo', 
          requiresAuth: true // Memerlukan autentikasi
      }
    },
    {
      path: '/operator/pendukung/berita',
      name: 'OperatorBerita',
      component: OperatorBerita,
      meta: { 
          title: 'Operator Berita | Paluwala LPPM Universitas Negeri Gorontalo', 
          requiresAuth: true // Memerlukan autentikasi
      }
    },
    {
      path: '/operator/pendukung/pengumuman',
      name: 'OperatorPengumuman',
      component: OperatorPengumuman,
      meta: { 
          title: 'Operator Pengumuman | Paluwala LPPM Universitas Negeri Gorontalo', 
          requiresAuth: true // Memerlukan autentikasi
      }
    },
    {
      path: '/operator/pendukung/panduan',
      name: 'OperatorPanduan',
      component: OperatorPanduan,
      meta: { 
          title: 'Operator Panduan | Paluwala LPPM Universitas Negeri Gorontalo', 
          requiresAuth: true // Memerlukan autentikasi
      }
    },
    {
      path: '/operator/pendukung/link',
      name: 'OperatorLink',
      component: OperatorLink,
      meta: { 
          title: 'Operator Link | Paluwala LPPM Universitas Negeri Gorontalo', 
          requiresAuth: true // Memerlukan autentikasi
      }
    },
    // ----------------------------------------------------------------------------------- Reviewer Page
    {
      path: '/operator/reviewer/borang-penilaian',
      name: 'OperatorBorangPenilaian',
      component: OperatorBorangPenilaian,
      meta: { 
          title: 'Operator Borang Penilaian | Paluwala LPPM Universitas Negeri Gorontalo', 
          requiresAuth: true // Memerlukan autentikasi
      }
    },
    {
      path: '/operator/reviewer/daftar-reviewer',
      name: 'OperatorDaftarReviewer',
      component: OperatorDaftarReviewer,
      meta: { 
          title: 'Operator Daftar Reviewer | Paluwala LPPM Universitas Negeri Gorontalo', 
          requiresAuth: true // Memerlukan autentikasi
      }
    },
    {
      path: '/operator/reviewer/reviewer-external',
      name: 'OperatorReviewerExternal',
      component: OperatorReviewerExternal,
      meta: { 
          title: 'Operator Reviewer External | Paluwala LPPM Universitas Negeri Gorontalo', 
          requiresAuth: true // Memerlukan autentikasi
      }
    },
    {
      path: '/operator/reviewer/penugasan-reviewer',
      name: 'OperatorPenugasanReview',
      component: OperatorPenugasanReview,
      meta: { 
          title: 'Operator Penugasan Reviewer | Paluwala LPPM Universitas Negeri Gorontalo', 
          requiresAuth: true // Memerlukan autentikasi
      }
    },
    {
      path: '/operator/reviewer/ploting-reviewer',
      name: 'OperatorPlotingReviewer',
      component: OperatorPlotingReviewer,
      meta: { 
          title: 'Operator Ploting Reviewer | Paluwala LPPM Universitas Negeri Gorontalo', 
          requiresAuth: true // Memerlukan autentikasi
      }
    },
    {
      path: '/operator/reviewer/monitoring-penilaian',
      name: 'OperatorMonitoringPenilaian',
      component: OperatorMonitoringPenilaian,
      meta: { 
          title: 'Operator Monitoring Penilaian | Paluwala LPPM Universitas Negeri Gorontalo', 
          requiresAuth: true // Memerlukan autentikasi
      }
    },
  ];