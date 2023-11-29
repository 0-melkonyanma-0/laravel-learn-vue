import axios from "axios";

export const state = {
  users: [],
  errors: [],
  loading: true,
}

export const getters = {
  users: state => state.users,
  errors: state => state.errors,
  loading: state => state.loading,
}

export const actions = {
  fetchUsers(ctx) {
    axios.get('/api/users').then((response) => {
      ctx.commit('updateUsers', response.data);
    })
  },
  deleteUser(ctx, id) {
    axios.delete(`/api/users/${id}`).then(() => {
      ctx.commit('deleteUser', id)
    });
  },
  updateUser(ctx, department) {
    axios.patch(`/api/users/${department.id}`, department).then(() => {
      ctx.dispatch('fetchUsers');
    }).catch((err) => {
      ctx.commit('setErrors', err.response.data.errors);
    });
  },
  createUser(ctx, body) {
    axios.post('/api/users', {...body}).then((response) => {
      ctx.dispatch('fetchUsers');
      body.title = '';
      ctx.commit('clearErrors');
    }).catch((err) => {
      ctx.commit('setErrors', err.response.data.errors);
    });
  }
}

export const mutations = {
  updateUsers(state, users) {
    state.users = users
    state.loading = false
  },
  deleteUser(state, userId) {
    state.users = state.users.filter((dep) => dep.id !== userId)
  },
  setErrors(state, err) {
    state.errors = [err]
  },
  clearErrors(state) {
    state.errors = []
  }
}
