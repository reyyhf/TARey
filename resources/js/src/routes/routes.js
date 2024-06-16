const routes = [
    {
        path: '/',
        redirect: {
            name: 'login-page'
        },
    },
    {
        path: '/auth',
        component: () => import('@Components/__pages/__layouts/Authentication.vue'),
        children: [
            {
                path: 'login',
                name: 'login-page',
                component: () => import('@Components/__pages/__authentication/Login.vue'),
                meta: {
                    auth: false,
                    title: 'Login'
                }
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
                component: () => import('@Components/__pages/__dashboard/home/Index.vue'),
                meta: {
                    auth: true,
                    title: 'Homepage'
                }
            },
            {
                path: 'pengguna',
                name: 'user',
                component: () => import('@Components/__pages/__dashboard/master-data/user/Index.vue'),
                meta: {
                    auth: true,
                    title: 'Pengguna'
                }
            },
            {
                path: 'guru',
                name: 'teacher',
                component: () => import('@Components/__pages/__dashboard/master-data/teacher/Index.vue'),
                meta: {
                    auth: true,
                    title: 'Guru'
                }
            },
            {
                path: 'mata-pelajaran',
                name: 'lesson',
                component: () => import('@Components/__pages/__dashboard/master-data/lesson/Index.vue'),
                meta: {
                    auth: true,
                    title: 'Mata Pelajaran'
                }
            },
            {
                path: 'kategori-pelajaran',
                name: 'lesson-category',
                component: () => import('@Components/__pages/__dashboard/master-data/lesson-category/Index.vue'),
                meta: {
                    auth: true,
                    title: 'Kategori Mata Pelajaran'
                }
            },
            {
                path: 'hak-akses-pengguna',
                name: 'user-role-access',
                component: () => import('@Components/__pages/__dashboard/master-data/user-role-access/Index.vue'),
                meta: {
                    auth: true,
                    title: 'Hak Akses Pengguna'
                }
            },
            {
                path: 'status-guru',
                name: 'user-status',
                component: () => import('@Components/__pages/__dashboard/master-data/user-status/Index.vue'),
                meta: {
                    auth: true,
                    title: 'Status Guru'
                }
            },
            {
                path: 'tahun-ajaran',
                name: 'year-of-education',
                component: () => import('@Components/__pages/__dashboard/master-data/year-of-education/Index.vue'),
                meta: {
                    auth: true,
                    title: 'Tahun Ajaran'
                }
            },
            {
                path: 'hari',
                name: 'schedule-day',
                component: () => import('@Components/__pages/__dashboard/master-data/schedule-day/Index.vue'),
                meta: {
                    auth: true,
                    title: 'Hari'
                }
            },
            {
                path: 'jam-pelajaran',
                name: 'schedule-lesson-hour',
                component: () => import('@Components/__pages/__dashboard/master-data/schedule-hour/Index.vue'),
                meta: {
                    auth: true,
                    title: 'Jam Pelajaran'
                }
            },
            {
                path: 'kelas',
                name: 'classroom',
                component: () => import('@Components/__pages/__dashboard/master-data/classroom/Index.vue'),
                meta: {
                    auth: true,
                    title: 'Kelas'
                }
            },
            {
                path: 'struktur-kurikulum',
                name: 'curriculum',
                component: () => import('@Components/__pages/__dashboard/master-data/curriculum/Index.vue'),
                meta: {
                    auth: true,
                    title: 'Struktur Kurikulum'
                }
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
                }
            },
        ],
    },
];

export default routes;
