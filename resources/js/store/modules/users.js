import axios from "axios";

const default_erorr_state = {
  name: '',
  sex: '',
  role: '',
  email: '',
  job_title_id: '',
  department_id: '',
  password: '',
}

export const state = {
  users: [],
  errors: default_erorr_state,
  loading: true,
}

export const getters = {
  users: state => state.users,
  errors: state => state.errors,
  loading: state => state.loading,
}

export const actions = {
  fetchUsers(ctx) {
    ctx.state.loading = true;

    axios.get('/api/users').then((response) => {
      ctx.commit('updateUsers', Object.values(response.data));
    })
  },
  deleteUser(ctx, id) {
    axios.delete(`/api/users/${id}`).then(() => {
      ctx.commit('deleteUser', id)
    });
  },
  updateUser(ctx, user) {
    axios.patch(`/api/users/${user.id}`, user).then(() => {
      ctx.dispatch('fetchUsers');
    }).catch((err) => {
      ctx.commit('setErrors', err.response.data.errors);
    });
  },
  createUser(ctx, body) {
    axios.post('/api/users', {...body}).then((response) => {
      ctx.dispatch('fetchUsers');
      ctx.commit('clearErrors');
    }).catch((err) => {
      ctx.commit('setErrors', err.response.data.errors);
    });
  }
}

export const mutations = {
  updateUsers(state, users) {
    state.users = users;
    state.loading = false
  },
  deleteUser(state, userId) {
    state.users = state.users.filter((user) => user.id !== userId)
  },
  setErrors(state, err) {
    state.errors = [err]
  },
  clearErrors(state) {
    state.errors = default_erorr_state;
  }
}
