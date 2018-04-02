import { Promise } from 'es6-promise'
import ls from 'local-storage'
import { SET_USER } from '@/store/mutation-types'
import client from '@/store/client'

const state = {
  user: {}
}

const getters = {
  user: state => state.user,
  isAuthenticated: state => !!ls('jwt')
}

const mutations = {
  [SET_USER](state, user) {
    state.user = user
  }
}

const actions = {
  fetchUser({ commit }) {
    return client
      .withAuth()
      .get('/api/auth/me')
      .then(res => {
        commit(SET_USER, res)
      })
  }
}

export default {
  state,
  getters,
  actions,
  mutations
}
