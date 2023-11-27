function page(path) {
    return () => import(/* webpackChunkName: '' */ `~/pages/${path}`).then(m => m.default || m)
}

export default [
    {path: '/', name: 'login', component: page('auth/login.vue')},
    {path: '/home', name: 'home', component: page('home.vue')},

    {path: '/users', name: 'users.index', component: page('users/index.vue'),},
    {path: '/users/:id/edit', name: 'users.index', component: page('users/edit.vue'),},

    {path: '/users/departments', name: 'users.departments', component: page('departments/index.vue')},
    {path: '/users/job-titles', name: 'users.job-titles', component: page('jobtitles/index.vue')},
    {path: '/users/roles', name: 'users.roles', component: page('roles/index.vue')},

    {path: '/events/calendar', name: 'events.calendar', component: page('events/calendar.vue')},
    {path: '/events/statistics', name: 'events.statistics', component: page('events/statistics.vue')},

    {path: '/settlements/regions', name: 'settlements.regions', component: page('settlements/regions.vue')},
    {path: '/settlements/cities', name: 'settlements.cities', component: page('settlements/cities.vue')},

    {
        path: '*', component:
            page('errors/404.vue')
    }
]
