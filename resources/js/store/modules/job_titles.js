import axios from "axios";

export const state = {
  jobTitles: [],
  errors: [],
  loading: true,
}

export const getters = {
  jobTitles: state => state.jobTitles,
  errors: state => state.errors,
  loading: state => state.loading,
}

export const actions = {
  fetchJobTitles(ctx) {
    ctx.state.loading = true;

    axios.get('/api/job-titles').then((response) => {
      ctx.commit('updateJobTitles', response.data);
    })
  },
  deleteJobTitle({commit, dispatch, state}, id) {
    axios.delete(`/api/job-titles/${id}`).then(({data}) => {
      this.commit('app/SET_RESPONSE_MESSAGE', {message: data.message, color: 'green'}, {root: true});
      commit('deleteJobTitle', id);
    }).catch(() => {
      this.commit('app/SET_RESPONSE_MESSAGE', {message: 'err_del_msg', color: 'red', status: 'err'}, {root: true});
    });
  },
  updateJobTitle(ctx, department) {
    axios.patch(`/api/job-titles/${department.id}`, department).then(({data}) => {
      this.commit('app/SET_RESPONSE_MESSAGE', {message: data.message, color: 'green'}, {root: true});
      ctx.commit('clearErrors');
      ctx.dispatch('fetchJobTitles');
    }).catch((err) => {
      ctx.commit('setErrors', err.response.data.errors);
      this.commit('app/SET_RESPONSE_MESSAGE', {message: 'err_edit_msg', color: 'red', status: 'err'}, {root: true});
    });
  },
  createJobTitle(ctx, body) {
    axios.post('/api/job-titles', {...body}).then(({data}) => {
      body.title = '';
      this.commit('app/SET_RESPONSE_MESSAGE', {message: data.message, color: 'green'}, {root: true});
      ctx.dispatch('fetchJobTitles');
      ctx.commit('clearErrors');
    }).catch((err) => {
      ctx.commit('setErrors', err.response.data.errors);
      this.commit('app/SET_RESPONSE_MESSAGE', {message: 'err_save_msg', color: 'red', status: 'err'}, {root: true});
    });
  }
}

export const mutations = {
  updateJobTitles(state, jobTitles) {
    state.jobTitles = jobTitles
    state.loading = false
  },
  deleteJobTitle(state, id) {
    state.jobTitles = state.jobTitles.filter((dep) => dep.id !== id)
  },
  setErrors(state, err) {
    state.errors = [err]
  },
  clearErrors(state) {
    state.errors = []
  },
}
