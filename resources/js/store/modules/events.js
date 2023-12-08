import axios from "axios";

const default_erorr_state = {
  name: '',
  description: '',
  start: '',
  end: '',
  color: '',
  user_id: '',
}

export const state = {
  start: null,
  end: null,
  request_done: false,
  events: [],
  errors: default_erorr_state,
}

export const getters = {
  events: state => state.events,
  request_done: state => state.request_done,
  errors: state => state.errors,
}

export const actions = {
  fetchEvents({commit, state}) {
    axios.get(`/api/events?start=${state.start}&end=${state.end}`).then((response) => {
      state.request_done = true;
      commit('updateEvents', response.data);
    });
  },
  createEvent({commit, state, dispatch}, body) {
    axios.post('/api/events', body).then(({data}) => {
      this.commit('app/SET_RESPONSE_MESSAGE', {message: data.message, color: 'green'}, {root: true});

      state.request_done = true;
      commit('clearErrors');
      dispatch('fetchEvents');
    }).catch((err) => {
      commit('setErrors', err.response.data.errors);
      this.commit('app/SET_RESPONSE_MESSAGE', {message: 'err_save_msg', color: 'red', status: 'err'}, {root: true});
    });
  },
  updateEvent({commit, state, dispatch}, body) {
    axios.patch(`/api/events/${body.id}`, body).then(({data}) => {
      this.commit('app/SET_RESPONSE_MESSAGE', {message: data.message, color: 'green'}, {root: true});

      state.request_done = true;
      commit('clearErrors');
      dispatch('fetchEvents');
    }).catch((err) => {
      commit('setErrors', err.response.data.errors);
      this.commit('app/SET_RESPONSE_MESSAGE', {message: 'err_edit_msg', color: 'red', status: 'err'}, {root: true});
    });
  },
  updateEventStatus({commit, state, dispatch}, id) {
    state.loading = true;
    axios.patch(`/api/events-status/${id}`).then(({data}) => {
      this.commit('app/SET_RESPONSE_MESSAGE', {message: data.message, color: 'green'}, {root: true});

      state.loading = false;
      commit('clearErrors');
      dispatch('fetchEvents');
    }).catch((err) => {
      commit('setErrors', err.response.data.errors);
      this.commit('app/SET_RESPONSE_MESSAGE', {message: 'err_upd_status', color: 'red', status: 'err'}, {root: true});
    });
  },
  deleteEvent({commit, state, dispatch}, id) {
    state.loading = true;
    axios.delete(`/api/events/${id}`).then(({data}) => {
      this.commit('app/SET_RESPONSE_MESSAGE', {message: data.message, color: 'green'}, {root: true});

      state.loading = false;
      commit('clearErrors');
      dispatch('fetchEvents');
    }).catch((response) => {
      commit('setErrors', response.data.errors);
      this.commit('app/SET_RESPONSE_MESSAGE', {message: 'err_del_msg', color: 'red', status: 'err'}, {root: true});
    });
  }
}

export const mutations = {
  updateEvents(state, events) {
    state.events = events;
  },
  setErrors(state, errors) {
    state.errors = errors;
  },
  clearErrors(state, errors) {
    state.errors = default_erorr_state;
  },
  resetRequestStatus(state) {
    state.request_done = false;
  },
  setStartEnd(state, {start, end}) {
    state.start = start;
    state.end = end;
  }
}
