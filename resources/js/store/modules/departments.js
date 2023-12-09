import axios from "axios";
import i18n from "../../plugins/i18n";

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
    axios.delete(`/api/departments/${id}`).then(({data}) => {
      this.commit('app/SET_RESPONSE_MESSAGE', {message: data.message, color: 'green'}, {root: true});

      ctx.commit('deleteDepartment', id)
    }).catch(() => {
      this.commit('app/SET_RESPONSE_MESSAGE', {
        message: i18n.t('err_del_msg'),
        color: 'red',
        status: 'err'
      }, {root: true});
    });
  },
  updateDepartment(ctx, department) {
    axios.patch(`/api/departments/${department.id}`, department).then(({data}) => {
      this.commit('app/SET_RESPONSE_MESSAGE', {message: data.message, color: 'green'}, {root: true});

      ctx.dispatch('fetchDepartments');
      ctx.commit('clearErrors');
    }).catch((err) => {
      ctx.commit('setErrors', err.response.data.errors);
      this.commit('app/SET_RESPONSE_MESSAGE', {
        message: i18n.t('err_edit_msg'),
        color: 'red',
        status: 'err'
      }, {root: true});
    });
  },
  createDepartment(ctx, body) {
    axios.post('/api/departments', {...body}).then(({data}) => {
      this.commit('app/SET_RESPONSE_MESSAGE', {message: data.message, color: 'green'}, {root: true});

      ctx.dispatch('fetchDepartments');
      body.title = '';
      ctx.commit('clearErrors');
    }).catch((err) => {
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
