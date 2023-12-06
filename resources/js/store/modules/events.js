import axios from "axios";

export const state = {
  events: [],
  errors: [],
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
  createEvent({commit, state}, body) {
    axios.post('/api/events', body).then((response) => {
      console.log(response);
    }).catch((response) => {
      console.log(response);
    });
  },
  updateEvent({commit, state}, body) {
    axios.post(`/api/events/${body.id}`, body).then((response) => {
      console.log(response);
    }).catch((response) => {
      console.log(response);
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
  }
}
