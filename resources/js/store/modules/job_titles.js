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
  deleteJobTitle(ctx, id) {
    axios.delete(`/api/job-titles/${id}`).then(() => {
      ctx.commit('deleteJobTitle', id)
    });
  },
  updateJobTitle(ctx, department) {
    axios.patch(`/api/job-titles/${department.id}`, department).then(() => {
      ctx.commit('clearErrors');
      ctx.dispatch('fetchJobTitles');
    }).catch((err) => {
      ctx.commit('setErrors', err.response.data.errors);
    });
  },
  createJobTitle(ctx, body) {
    axios.post('/api/job-titles', {...body}).then((response) => {
      body.title = '';
      ctx.dispatch('fetchJobTitles');
      ctx.commit('clearErrors');
    }).catch((err) => {
      ctx.commit('setErrors', err.response.data.errors);
    });
  }
}

export const mutations = {
  updateJobTitles(state, jobTitles) {
    state.jobTitles = jobTitles
    state.loading = false
  },
  deleteJobTitle(state, jobTitleId) {
    state.jobTitles = state.jobTitles.filter((dep) => dep.id !== jobTitleId)
  },
  setErrors(state, err) {
    state.errors = [err]
  },
  clearErrors(state) {
    state.errors = []
  }
}
