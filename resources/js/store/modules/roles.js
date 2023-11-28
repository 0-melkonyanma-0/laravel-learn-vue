import axios from "axios";

export const state = {
  roles: [],
  permissions: [],
  errors: [],
  loading: true,
}

export const getters = {
  roles: state => state.roles,
  permissions: state => state.permissions,
  errors: state => state.errors,
  loading: state => state.loading,
}

export const actions = {
  fetchRoles(ctx) {
    axios.get('/api/roles').then((response) => {
      ctx.commit('updateRoles', response.data);
    });
  },
  fetchPermissions(ctx) {
    axios.get('/api/roles/permissions').then((response) => {
      ctx.commit('updatePermissions', response.data)
    });
  },
  deleteRole(ctx, id) {
    axios.delete(`/api/roles/${id}`).then(() => {
      ctx.commit('deleteRoles', id)
    });
  },
  updateRole(ctx, department) {
    axios.patch(`/api/roles/${department.id}`, department).then(() => {
      ctx.dispatch('fetchRoles');
    }).catch((err) => {
      ctx.commit('setErrors', err.response.data.errors);
    });
  },
  createRole(ctx, body) {
    axios.post('/api/departments', {...body}).then((response) => {
      ctx.dispatch('fetchDepartments');
      body.title = '';
      ctx.commit('clearErrors');
    }).catch((err) => {
      ctx.commit('setErrors', err.response.data.errors);
    });
  }
}

export const mutations = {
  updateRoles(state, roles) {
    state.roles = roles
    state.loading = false
  },
  updatePermissions(state, permissions) {
    permissions = permissions.map(permission => ({
      id: permission.id,
      name: permission.name,
    }));

    let permissionsGroup = [];

    permissions.forEach(el => {
      name = el.name.split(' ')

      if (!permissionsGroup.includes(name)) {
        permissionsGroup.push({name: [el]});
      } else {
        permissionsGroup[name].push(el);
      }
    });

    console.log(permissionsGroup);

    state.permissions = permissions;
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
  }
}
