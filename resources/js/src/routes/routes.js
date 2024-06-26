const routes = [
  {
    path: '/',
    redirect: {
      name: 'login-page',
    },
  },
  {
    path: '/auth',
    component: () => import('@Components/__pages/__layouts/Authentication.vue'),
    children: [
      {
        path: 'login',
        name: 'login-page',
        component: () =>
          import('@Components/__pages/__authentication/Login.vue'),
        meta: {
          auth: false,
          title: 'Login',
        },
      },
    ],
  },
  {
    path: '/dashboard',
    component: () => import('@Components/__pages/__layouts/Dashboard.vue'),
    children: [
      {
        path: 'homepage',
        name: 'homepage',
        component: () =>
          import('@Components/__pages/__dashboard/home/Index.vue'),
        meta: {
          auth: true,
          title: 'Homepage',
        },
      },
      {
        path: 'pengguna',
        name: 'user',
        component: () =>
          import('@Components/__pages/__dashboard/master-data/user/Index.vue'),
        meta: {
          auth: true,
          title: 'Pengguna',
        },
      },
      {
        path: 'guru',
        name: 'teacher',
        component: () =>
          import(
            '@Components/__pages/__dashboard/master-data/teacher/Index.vue'
          ),
        meta: {
          auth: true,
          title: 'Guru',
        },
      },
      {
        path: 'mata-pelajaran',
        name: 'lesson',
        component: () =>
          import(
            '@Components/__pages/__dashboard/master-data/lesson/Index.vue'
          ),
        meta: {
          auth: true,
          title: 'Mata Pelajaran',
        },
      },
      {
        path: 'kategori-pelajaran',
        name: 'lesson-category',
        component: () =>
          import(
            '@Components/__pages/__dashboard/master-data/lesson-category/Index.vue'
          ),
        meta: {
          auth: true,
          title: 'Kategori Mata Pelajaran',
        },
      },
      {
        path: 'hak-akses-pengguna',
        name: 'user-role-access',
        component: () =>
          import(
            '@Components/__pages/__dashboard/master-data/user-role-access/Index.vue'
          ),
        meta: {
          auth: true,
          title: 'Hak Akses Pengguna',
        },
      },
      {
        path: 'status-guru',
        name: 'user-status',
        component: () =>
          import(
            '@Components/__pages/__dashboard/master-data/user-status/Index.vue'
          ),
        meta: {
          auth: true,
          title: 'Status Guru',
        },
      },
      {
        path: 'tahun-ajaran',
        name: 'year-of-education',
        component: () =>
          import(
            '@Components/__pages/__dashboard/master-data/year-of-education/Index.vue'
          ),
        meta: {
          auth: true,
          title: 'Tahun Ajaran',
        },
      },
      {
        path: 'hari',
        name: 'schedule-day',
        component: () =>
          import(
            '@Components/__pages/__dashboard/master-data/schedule-day/Index.vue'
          ),
        meta: {
          auth: true,
          title: 'Hari',
        },
      },
      {
        path: 'jam-pelajaran',
        name: 'schedule-lesson-hour',
        component: () =>
          import(
            '@Components/__pages/__dashboard/master-data/schedule-hour/Index.vue'
          ),
        meta: {
          auth: true,
          title: 'Jam Pelajaran',
        },
      },
      {
        path: 'kelas',
        name: 'classroom',
        component: () =>
          import(
            '@Components/__pages/__dashboard/master-data/classroom/Index.vue'
          ),
        meta: {
          auth: true,
          title: 'Kelas',
        },
      },
      {
        path: 'struktur-kurikulum',
        name: 'curriculum',
        component: () =>
          import(
            '@Components/__pages/__dashboard/master-data/curriculum/Index.vue'
          ),
        meta: {
          auth: true,
          title: 'Struktur Kurikulum',
        },
      },
      {
        path: 'jadwal-mata-pelajaran',
        name: 'schedule-lesson',
        component: () =>
          import(
            '@Components/__pages/__dashboard/scheduling/schedule-lesson/Index.vue'
          ),
        meta: {
          auth: true,
          title: 'Jadwal Mata Pelajaran',
        },
      },
      {
        path: 'penjadwal-mata-pelajaran',
        name: 'schedule',
        component: () =>
          import(
            '@Components/__pages/__dashboard/scheduling/schedule/Index.vue'
          ),
        meta: {
          auth: true,
          title: 'Penjadwalan Mata Pelajaran',
        },
      },
      {
        path: 'tabu-search',
        name: 'tabu-search',
        component: () =>
          import(
            '@Components/__pages/__dashboard/scheduling/tabu-search/Index.vue'
          ),
        meta: {
          auth: true,
          title: 'Metode Tabu Search',
        },
      },
      {
        path: 'criteria-constraint',
        name: 'criteria-constraint',
        component: () =>
          import(
            '@Components/__pages/__dashboard/scheduling/criteria-constraint/Index.vue'
          ),
        meta: {
          auth: true,
          title: 'Criteria Constraint',
        },
      },
      {
        path: 'laporan-penjadwalan',
        name: 'schedule-report',
        component: () =>
          import(
            '@Components/__pages/__dashboard/reporting/schedule-report/Index.vue'
          ),
        meta: {
          auth: true,
          title: 'Laporan Penjadwalan',
        },
      },
      {
        path: 'detail-laporan-penjadwalan/:id',
        name: 'detail-schedule-report',
        component: () =>
          import(
            '@Components/__pages/__dashboard/reporting/schedule-report-detail/Index.vue'
          ),
        meta: {
          auth: true,
          title: 'Detail Laporan Penjadwalan',
        },
      },
      {
        path: 'laporan-beban-mengajar',
        name: 'teaching-load',
        component: () =>
          import(
            '@Components/__pages/__dashboard/reporting/teaching-load/Index.vue'
          ),
        meta: {
          auth: true,
          title: 'Laporan Beban Mengajar',
        },
      },
      {
        path: 'jadwal-mata-pelajaran/:id',
        name: 'detail-schedule-lesson',
        component: () =>
          import(
            '@Components/__pages/__dashboard/scheduling/schedule-lesson-detail/Index.vue'
          ),
        meta: {
          auth: true,
          title: 'Detail Jadwal Mata Pelajaran',
        },
      },
    ],
  },
  {
    path: '/errors',
    component: () => import('@Components/__pages/__layouts/ErrorPage.vue'),
    children: [
      {
        path: '/:pathMatch(.*)*',
        name: 'page-not-found',
        component: () => import('@Components/__pages/__errors/404.vue'),
        meta: {
          auth: false,
        },
      },
    ],
  },
]

export default routes
