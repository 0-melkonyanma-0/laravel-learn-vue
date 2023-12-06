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
  events: [],
  errors: default_erorr_state,
}

export const getters = {
  events: state => state.events
}

export const actions = {
  fetchEvents({commit, state}) {
    axios.get(`/api/events`).then((response) => {
      commit('updateEvents', response.data);
    });
  },
  createEvent({commit, state, dispatch}, body) {
    axios.post('/api/events', body).then((response) => {
      dispatch('fetchEvents');
    }).catch((response) => {

    });
  },
  updateEvent({commit, state, dispatch}, body) {
    axios.patch(`/api/events/${body.id}`, body).then((response) => {
      dispatch('fetchEvents');
    }).catch((response) => {

    });
  },
  updateEventStatus({commit, state, dispatch}, id) {
    axios.patch(`/api/events-status/${id}`).then((response) => {
      dispatch('fetchEvents');
    }).catch((response) => {

    });
  },
  deleteEvent({commit, state}, id) {
    axios.delete(`/api/events/${id}`).then((response) => {
      console.log(response);
    }).catch((response) => {
      console.log(response);
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
