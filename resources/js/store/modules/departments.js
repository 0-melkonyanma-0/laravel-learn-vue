import axios from "axios";

export const state = {
  departments: [],
  errors: [],
  loading: true,
  search: '',
  body: {
    title: ''
  }
}

export const getters = {
  departments: state => state.departments,
  errors: state => state.errors,
  loading: state => state.loading,
}

export const actions = {
  fetchDepartments(ctx) {
    axios.get('/api/departments').then((response) => {
      ctx.commit('updateDepartments', response.data);
    })
  },
  deleteDepartment(ctx, dep_id) {
    axios.delete(`/api/departments/${dep_id}`).then(() => {
      ctx.commit('deleteDepartment', dep_id)
    });
  },
  createDepartment(ctx, body) {
    axios.post('/api/departments', {...body}).then((response) => {
      ctx.dispatch('fetchDepartments')
      body.title = '';
    }).catch((err) => {
      ctx.commit('setErrors', err.response.data.errors)
    });
  }
}

export const mutations = {
  updateDepartments(state, departments) {
    state.departments = departments
    state.loading = false
  },
  deleteDepartment(state, departmentId) {
    state.departments = state.departments.filter((dep) => dep.id !== departmentId)
  },
  setErrors(state, err) {
    state.errors = [err]
  }
}
