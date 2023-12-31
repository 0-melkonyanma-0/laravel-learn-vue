import axios from 'axios'
import Cookies from 'js-cookie'
import * as types from '../mutation-types'
import {Exception} from "sass";

// state
export const state = {
  user: null,
  permissions: [],
  token: Cookies.get('token')
}

// getters
export const getters = {
  user: state => state.user,
  permissions: state => state.permissions,
  token: state => state.token,
  check: state => state.user !== null
}

// mutations
export const mutations = {
  [types.SAVE_TOKEN](state, {token, remember}) {
    state.token = token
    Cookies.set('token', token, {expires: remember ? 365 : null})
  },

  [types.FETCH_USER_SUCCESS](state, {user}) {
    state.user = user
  },

  setPermissions(state, {permissions}) {
    state.permissions = permissions
  },

  [types.FETCH_USER_FAILURE](state) {
    state.token = null
    Cookies.remove('token')
  },

  [types.LOGOUT](state) {
    state.user = null
    state.token = null
    state.permissions = []

    Cookies.remove('token')
  },

  [types.UPDATE_USER](state, {user}) {
    state.user = user
  }
}

// actions
export const actions = {
  saveToken({commit, dispatch}, payload) {
    commit(types.SAVE_TOKEN, payload)
  },

  async fetchUser({commit}) {
    try {
      const {data} = await axios.get('/api/user')


      if (!data.hasOwnProperty('errors')) {
        commit(types.FETCH_USER_SUCCESS, {user: data[0]})
        commit('setPermissions', {permissions: data[1]})
      }

    } catch (e) {
      commit(types.FETCH_USER_FAILURE)
    }
  },

  updateUser({commit}, payload) {
    commit(types.UPDATE_USER, payload)
  },

  async logout({commit}) {
    try {
      await axios.post('/api/logout')
    } catch (e) {
    }

    commit(types.LOGOUT)
  },

  async fetchOauthUrl(ctx, {provider}) {
    const {data} = await axios.post(`/api/oauth/${provider}`)

    return data.url
  }
}
