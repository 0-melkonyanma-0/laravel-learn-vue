import axios from "axios";

export const state = {
  departments: [],
  errors: [],
  loading: true,
}

export const getters = {
  departments: state => state.departments,
  errors: state => state.errors,
  loading: state => state.loading,
}

export const actions = {
  fetchDepartments(ctx) {
    ctx.state.loading = true;

    axios.get('/api/departments').then((response) => {
      ctx.commit('updateDepartments', response.data);
    })
  },
  deleteDepartment(ctx, id) {
    axios.delete(`/api/departments/${id}`).then(() => {
      ctx.commit('deleteDepartment', id)
    });
  },
  updateDepartment(ctx, department) {
    axios.patch(`/api/departments/${department.id}`, department).then(() => {
      ctx.dispatch('fetchDepartments');
    }).catch((err) => {
      ctx.commit('setErrors', err.response.data.errors);
    });
  },
  createDepartment(ctx, body) {
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
  updateDepartments(state, departments) {
    state.departments = departments
    state.loading = false
  },
  deleteDepartment(state, departmentId) {
    state.departments = state.departments.filter((dep) => dep.id !== departmentId)
  },
  setErrors(state, err) {
    state.errors = [err]
  },
  clearErrors(state) {
    state.errors = []
  }
}
