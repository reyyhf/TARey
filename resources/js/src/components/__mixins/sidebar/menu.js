const menus = [
    {
        header: 'Home',
        submenu: [
            {
                title: 'Homepage',
                icon: 'mdi-view-dashboard',
                route: 'homepage'
            }
        ],
    },
    {
        header: 'Master Data',
        submenu: [
            {
                title: 'Pengguna',
                icon: 'mdi-account-group',
                route: 'user'
            },
            {
                title: 'Guru',
                icon: 'mdi-briefcase-account-outline',
                route: 'teacher'
            },
            {
                title: 'Status Guru',
                icon: 'mdi-account-star',
                route: 'user-status'
            },
            {
                title: 'Hak Akses Pengguna',
                icon: 'mdi-account-key',
                route: 'user-role-access'
            },
            {
                title: 'Mata Pelajaran',
                icon: 'mdi-book-check',
                route: 'lesson'
            },
            {
                title: 'Struktur Kurikulum',
                icon: 'mdi-notebook-multiple',
                route: 'curriculum'
            },
            {
                title: 'Kategori Pelajaran',
                icon: 'mdi-cast-education',
                route: 'lesson-category'
            },
            {
                title: 'Tahun Ajaran',
                icon: 'mdi-chair-school',
                route: 'year-of-education'
            },
            {
                title: 'Hari',
                icon: 'mdi-calendar',
                route: 'schedule-day'
            },
            {
                title: 'Jam Pelajaran',
                icon: 'mdi-progress-clock',
                route: 'schedule-lesson-hour'
            },
            {
                title: 'Kelas',
                icon: 'mdi-town-hall',
                route: 'classroom'
            },
        ],
    },
];

export default menus;
