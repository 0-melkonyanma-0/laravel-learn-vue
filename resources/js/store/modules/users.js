import axios from "axios";
import i18n from "../../plugins/i18n";

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
    axios.delete(`/api/users/${id}`).then(({data}) => {
      this.commit('app/SET_RESPONSE_MESSAGE', {message: data.message, color: 'green'}, {root: true});

      ctx.commit('deleteUser', id);
    }).catch(() => {
      this.commit('app/SET_RESPONSE_MESSAGE', {
        message: i18n.t('err_del_msg'),
        color: 'red',
        status: 'err'
      }, {root: true});
    });
  },
  updateUser(ctx, user) {
    axios.patch(`/api/users/${user.id}`, user).then(({data}) => {
      this.commit('app/SET_RESPONSE_MESSAGE', {message: data.message, color: 'green'}, {root: true});

      ctx.dispatch('fetchUsers');
    }).catch((err) => {
      ctx.state.request_done = false;

      ctx.commit('setErrors', err.response.data.errors);
      this.commit('app/SET_RESPONSE_MESSAGE', {
        message: i18n.t('err_edit_msg'),
        color: 'red',
        status: 'err'
      }, {root: true});
    });
  },
  createUser(ctx, body) {
    axios.post('/api/users', {...body}).then(({data}) => {
      this.commit('app/SET_RESPONSE_MESSAGE', {message: data.message, color: 'green'}, {root: true});

      ctx.dispatch('fetchUsers');
      ctx.commit('clearErrors');
    }).catch((err) => {
      ctx.state.request_done = false;
      ctx.commit('setErrors', err.response.data.errors);
      this.commit('app/SET_RESPONSE_MESSAGE', {
        message: i18n.t('err_save_msg'),
        color: 'red',
        status: 'err'
      }, {root: true});
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
