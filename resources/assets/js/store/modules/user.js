import { Promise } from "es6-promise"
import ls from "local-storage"
import { SET_USER, SET_REPOS } from "@/store/mutation-types"
import client from "@/store/client"

const state = {
  user: {},
  repos: []
}

const getters = {
  user: state => state.user,
  repos: state => state.repos,
  isAuthenticated: state => !!ls("jwt")
}

const mutations = {
  [SET_USER](state, user) {
    state.user = user
  },
  [SET_REPOS](state, repos) {
    state.repos = repos
  }
}

const actions = {
  fetchUser({ commit }) {
    return client
      .withAuth()
      .get("/api/auth/me")
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
