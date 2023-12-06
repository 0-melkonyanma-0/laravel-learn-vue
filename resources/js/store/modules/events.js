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
  loading: false,
  events: [],
  errors: default_erorr_state,
}

export const getters = {
  events: state => state.events
}

export const actions = {
  fetchEvents({commit, state}) {
    state.loading = true;
    axios.get(`/api/events`).then((response) => {
      state.loading = false;
      commit('updateEvents', response.data);
    });
  },
  createEvent({commit, state, dispatch}, body) {
    state.loading = true;

    axios.post('/api/events', body).then((response) => {
      state.loading = false;
      commit('clearErrors');
      dispatch('fetchEvents');
    }).catch((err) => {
      commit('setErrors', err.response.data.errors);
    });
  },
  updateEvent({commit, state, dispatch}, body) {
    state.loading = true;

    axios.patch(`/api/events/${body.id}`, body).then((response) => {
      state.loading = false;
      commit('clearErrors');
      dispatch('fetchEvents');
    }).catch((err) => {
      commit('setErrors', err.response.data.errors);
    });
  },
  updateEventStatus({commit, state, dispatch}, id) {
    state.loading = true;
    axios.patch(`/api/events-status/${id}`).then((response) => {
      state.loading = false;
      commit('clearErrors');
      dispatch('fetchEvents');
    }).catch((err) => {
      commit('setErrors', err.response.data.errors);
    });
  },
  deleteEvent({commit, state}, id) {
    state.loading = true;
    axios.delete(`/api/events/${id}`).then((response) => {
      state.loading = false;
      commit('clearErrors');
    }).catch((response) => {
      commit('setErrors', response.data.errors);
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
  }
}
