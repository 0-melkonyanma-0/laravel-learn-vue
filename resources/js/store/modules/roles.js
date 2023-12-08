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
  fetchRolesAndPermissions(ctx) {
    ctx.state.loading = true;

    axios.get('/api/roles').then((response) => {
      ctx.commit('updateRoles', response.data);
    });

    axios.get('/api/roles/permissions').then((response) => {
      ctx.commit('updatePermissions', response.data)
    });
  },
  deleteRole(ctx, id) {
    axios.delete(`/api/roles/${id}`).then(({data}) => {
      this.commit('app/SET_RESPONSE_MESSAGE', {message: data.message, color: 'green'}, {root: true});

      ctx.commit('deleteRole', id)
    });
  },
  updateRole(ctx, role) {
    axios.patch(`/api/roles/${role.id}`, role).then(({data}) => {
      this.commit('app/SET_RESPONSE_MESSAGE', {message: data.message, color: 'green'}, {root: true});

      ctx.dispatch('fetchRolesAndPermissions');
    }).catch((err) => {
      ctx.commit('setErrors', err.response.data.errors);
    });
  },
  createRole(ctx, body) {
    axios.post('/api/roles', {...body}).then(({data}) => {
      this.commit('app/SET_RESPONSE_MESSAGE', {message: data.message, color: 'green'}, {root: true});

      body.title = '';
      body.permissions = [];
      ctx.commit('clearErrors');
      ctx.dispatch('fetchRolesAndPermissions');
    }).catch((err) => {
      ctx.commit('setErrors', err.response.data.errors);
    });
  }
}

export const mutations = {
  updateRoles(state, roles) {
    state.roles = roles;
    state.loading = false
  }, updatePermissions(state, permissions) {
    permissions = permissions.map(permission => ({
      id: permission.id, name: permission.name,
    }));

    let groupedPermissions = [];

    permissions.forEach(el => {
      let title = el.name.split(' ');

      if (!groupedPermissions.includes(title[1])) {
        groupedPermissions.push(title[1]);
        groupedPermissions[title[1]] = [{id: el.id, title: title[1].concat('_', title[0])}];
      } else {
        groupedPermissions[title[1]].push({id: el.id, title: title[1].concat('_', title[0])});
      }
    });

    state.permissions = groupedPermissions;
    state.loading = false;
  },
  deleteRole(state, roleId) {
    state.roles = state.roles.filter((dep) => dep.id !== roleId)
  }, setErrors(state, err) {
    state.errors = [err]
  }, clearErrors(state) {
    state.errors = []
  },
  resetRequestStatus(state) {
    state.request_done = false;
  }
}
