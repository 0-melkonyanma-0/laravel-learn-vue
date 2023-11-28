import axios from "axios";

export const state = {
  roles: [],
  permissions: [],
  errors: [],
  loading: false,
}

export const getters = {
  roles: state => state.roles,
  permissions: state => state.permissions,
  errors: state => state.errors,
  loading: state => state.loading,
}

export const actions = {
  fetchRoles(ctx) {
    ctx.commit('loading');
    axios.get('/api/roles').then((response) => {
      ctx.commit('updateRoles', response.data);
    });
  },
  fetchPermissions(ctx) {
    ctx.commit('loading');
    axios.get('/api/roles/permissions').then((response) => {
      ctx.commit('updatePermissions', response.data)
    });
  },
  deleteRole(ctx, id) {
    axios.delete(`/api/roles/${id}`).then(() => {
      ctx.commit('deleteRole', id)
    });
  },
  updateRole(ctx, role) {
    axios.patch(`/api/roles/${role.id}`, role).then(() => {
      window.location.href = '/users/roles';
      ctx.dispatch('fetchRoles');
    }).catch((err) => {
      ctx.commit('setErrors', err.response.data.errors);
    });
  },
  createRole(ctx, body) {
    window.location.href = '/users/roles';

    axios.post('/api/roles', {...body}).then((response) => {
      body.title = '';
      body.permissions = [];
      ctx.commit('clearErrors');
      ctx.dispatch('fetchRoles');
    }).catch((err) => {
      ctx.commit('setErrors', err.response.data.errors);
    });
  }
}

export const mutations = {
  updateRoles(state, roles) {
    state.roles = roles;
    state.loading = false
  },
  updatePermissions(state, permissions) {
    permissions = permissions.map(permission => ({
      id: permission.id,
      name: permission.name,
    }));

    let groupedPermissions = [];

    permissions.forEach(el => {
      let title = el.name.split(' ');

      if (!groupedPermissions.includes(title[1])) {
        groupedPermissions.push(title[1]);
        groupedPermissions[title[1]] = [[title[0], el.id]];
      } else {
        groupedPermissions[title[1]].push([title[0], el.id]);
      }
    });

    state.permissions = groupedPermissions;
    state.loading = false;
  },
  permissions(state, roles) {
    state.roles = roles
    state.loading = false
  },
  deleteRole(state, roleId) {
    state.roles = state.roles.filter((dep) => dep.id !== roleId)
  },
  setErrors(state, err) {
    state.errors = [err]
  },
  clearErrors(state) {
    state.errors = []
  },
  loading(state) {
    state.loading = !state.loading;
  }
}
