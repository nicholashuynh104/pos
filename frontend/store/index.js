import categoryStore from './categoryStore'
import Vuex from 'vuex'

const createStore = () => {
  return new Vuex.Store({
    state: {
    },
    mutations: {
    },
    getters: {
    },
    modules: {
      category: categoryStore
    }
  })
}

export default createStore