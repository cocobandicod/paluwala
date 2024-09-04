import OperatorDashboard from '../views/operator/dashboard.vue';

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
  ];