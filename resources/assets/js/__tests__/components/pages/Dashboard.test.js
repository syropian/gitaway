import { shallow, createLocalVue } from "@vue/test-utils"
import Vuex from "vuex"
import Dashboard from "@/components/pages/Dashboard"

const localVue = createLocalVue()
localVue.use(Vuex)

describe("Dashboard", () => {
  let store, actions

  beforeEach(() => {
    actions = {
      fetchUser: jest.fn()
    }

    store = new Vuex.Store({
      state: {},
      getters: {
        user: () => {
          return { username: "octocat" }
        }
      },
      actions
    })
  })

  describe("on mount", () => {
    it("fetches the authenticated user", () => {
      shallow(Dashboard, {
        localVue,
        store
      })

      expect(actions.fetchUser).toHaveBeenCalled()
    })
  })
})
