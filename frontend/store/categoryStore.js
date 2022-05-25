import axios from 'axios';
import {RESOURCE_CATEGORY} from '../assets/api';

const categoryStore = {
  namespaced: true,
  state: {
    categories: [],
    category: {},
    loading: false
  },
  mutations: {
    FETCH(state, categories) {
      state.categories = categories;
    },
    FETCH_ONE(state, category) {
      state.category = category;
    },
    LOADING(state, loading) {
      state.loading = loading;
    },
  },
  getters: {
    getCategories(state) {
      return state.categories;
    },
    getCategory(state) {
      return state.category;
    },
    isLoading(state) {
      return state.loading;
    }
  },
  actions: {
    fetch({ commit }) {
      return axios.get(RESOURCE_CATEGORY)
        .then(response => {
          commit('FETCH', response.data);
          commit('LOADING', true);
        })
        .catch();
    },
    fetchOne({ commit }, id) {
      axios.get(`${RESOURCE_CATEGORY}/${id}`)
        .then( response => {
          commit('FETCH_ONE', response.data);
          commit('LOADING', true);
        }).catch();
    },
    deleteProduct({}, id) {
      axios.delete(`${RESOURCE_CATEGORY}/${id}`)
      .then( res =>{
        if (res.data.success) {
          this.dispatch('category/fetch');
          this.$toast.show(res.data.message, {
              type: "success",
              duration: 600
          });
        }
      }).catch();
    },
    editProduct({}, category) {
      axios.put(`${RESOURCE_CATEGORY}/${category.id}`, {
        name: category.name,
        image: category.image,
      })
      .then();
    },
    addProduct({}, category) {
      const config = {
        headers: { 'content-type': 'multipart/form-data' }
      }
      axios.post(RESOURCE_CATEGORY,category,config).then(res => {
        if (res.data.success) {
          this.$toast.show(res.data.message, {
              type: "success",
              duration: 600
          });
          this.$router.push('/admin/category')
        } else {
          this.$toast.show(res.data.message, {
              type: "error",
              duration: 600
          });
        }
      });
    },
    changeStatusProduct({}, id) {
      axios.patch(`http://127.0.0.1:8000/api/admin/changeStatus/${id}`)
      .then( res =>{
        if (res.data.success) {
          this.dispatch('category/fetch');
          this.$toast.show(res.data.message, {
              type: "success",
              duration: 600
          });
        }
      }).catch();
    }
  }
};

export default categoryStore;
