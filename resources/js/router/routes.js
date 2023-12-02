import store from "../store";

function page(path) {
  return () => import(/* webpackChunkName: '' */ `~/pages/${path}`).then(m => m.default || m)
}

function middleware(next, permission, to = 'home') {
  if (store.getters['auth/permissions'].includes(permission)) {
    next();
  } else {
    next({name: to});
  }
}

export default [
  {path: '/', name: 'login', component: page('auth/login.vue')},
  {path: '/home', name: 'home', component: page('home.vue')},

  {
    path: '/users',
    name: 'users.index',
    component: page('users/index.vue'),
    beforeEnter: (to, from, next) => {
      middleware(next, 'index users')
    }
  },
  {
    path: '/users/create',
    name: 'users.create',
    component: page('users/create.vue'),
    beforeEnter: (to, from, next) => {
      middleware(next, 'create users', 'users.index')
    }
  },
  {
    path: '/users/:id/edit',
    name: 'users.edit',
    component: page('users/edit.vue'),
    beforeEnter: (to, from, next) => {
      middleware(next, 'edit users', 'users.index')
    }
  },

  {
    path: '/users/departments',
    name: 'users.departments',
    component: page('departments/index.vue'),
    beforeEnter: (to, from, next) => {
      middleware(next, 'index departments')
    }
  },
  {
    path: '/users/job-titles',
    name: 'users.job-titles',
    component: page('jobtitles/index.vue'),
    beforeEnter: (to, from, next) => {
      middleware(next, 'index job_titles')
    }
  },
  {
    path: '/users/roles',
    name: 'users.roles',
    component: page('roles/index.vue'),
    beforeEnter: (to, from, next) => {
      middleware(next, 'index roles')
    }
  },
  {
    path: '/users/roles/create',
    name: 'users.roles.create',
    component: page('roles/create.vue'),
    beforeEnter: (to, from, next) => {
      middleware(next, 'create roles', 'users.roles')
    }
  },
  {
    path: '/users/roles/:id/edit',
    name: 'users.roles.edit',
    component: page('roles/edit.vue'),
    beforeEnter: (to, from, next) => {
      middleware(next, 'edit roles', 'users.roles')
    }
  },

  {
    path: '/events/calendar',
    name: 'events.calendar',
    component: page('events/calendar.vue'),
    beforeEnter: (to, from, next) => {
      middleware(next, 'index events')
    }
  },
  {
    path: '/events/statistics',
    name: 'events.statistics',
    component: page('events/statistics.vue'),
    beforeEnter: (to, from, next) => {
      middleware(next, 'index statistics')
    }
  },

  {
    path: '/settlements/regions',
    name: 'settlements.regions',
    component: page('settlements/regions.vue'),
    beforeEnter: (to, from, next) => {
      middleware(next, 'index settlements')
    }
  },
  {
    path: '/settlements/cities',
    name: 'settlements.cities',
    component: page('settlements/cities.vue'),
    beforeEnter: (to, from, next) => {
      middleware(next, 'index settlements')
    }
  },

  {
    path: '*',
    component: page('errors/404.vue')
  }
]
