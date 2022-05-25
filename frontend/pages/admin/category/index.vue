<template>
  <div>
    <SidebarVue />
    <v-container>
      <v-card>
        <v-card-text class="d-flex justify-space-between align-center">
          <!-- <v-card-title> Category ( {{ totalCategory }} ) </v-card-title> -->
          <v-card-actions>
            <nuxt-link to="/admin/category/create">
                <el-button type="primary" plain>Add new Category</el-button>
            </nuxt-link>
          </v-card-actions>
        </v-card-text>
        <hr />
        <v-card-subtitle>
          <div>
            <v-simple-table
              v-loading="loading"
              element-loading-text="Loading..."
              element-loading-spinner="el-icon-loading"
              style="width: 100%"
            >
              <template v-slot:default>
                <thead>
                  <tr>
                    <th class="text-left">Id</th>
                    <th class="text-left">Category</th>
                    <th class="text-left">Image</th>
                    <th class="text-left">Status</th>
                    <th class="text-left">Edit</th>
                    <th class="text-left">Delete</th>
                  </tr>
                </thead>
                <tbody>
                  <tr
                    v-for="(category, index) in categories"
                    :key="index"
                  >
                    <td class="text-left">{{ category.id }}</td>
                    <td class="text-left">{{ category.name }}</td>
                    <td class="">
                      <v-img
                        :src="'http://localhost:8000/storage/' + category.image"
                        width="70"
                        cover
                      ></v-img>
                    </td>
                    <td class="text-left">
                      <el-switch
                          active-color="#13ce66"
                          inactive-color="#ff4949"
                        @change="changeStatus(category.id)"
                      >
                      </el-switch>
                    </td>
                    <td class="text-left">
                      <nuxt-link :to="`/admin/category/${category.id}`">
                        <el-button type="primary" icon="el-icon-edit" @click="edit_dialog = true" circle></el-button>
                      </nuxt-link>
                    </td>
                    <td class="text-left">
                      <el-button type="danger" icon="el-icon-delete" @click="delCategory(category.id)" circle></el-button>
                    </td>
                  </tr>
                </tbody>
              </template>
            </v-simple-table>
          </div>
        </v-card-subtitle>
        <v-card-subtitle>
        </v-card-subtitle>
      </v-card>
    </v-container>
  </div>
</template>
<script>
import SidebarVue from "../../../components/admin/Sidebar.vue";
import CreateCategory from "./create.vue";
import { mapActions, mapGetters } from "vuex";

export default {
  name: "CategoryPage",
  data: () => ({
    totalCategory: 0,
    loading: false,
  }),
  computed: {
    categories () {
      return this.$store.state.category.categories.categories;
    },
    isLoading () {
      this.loading = this.$store.state.category.loading
    }
  },
  created: function () {
    this.$store.dispatch('category/fetch')
  },
  components: {
    SidebarVue,
  },
  methods: {
    // ...mapActions(["fetch"]),
    delCategory : function (id) {
      this.$store.dispatch('category/deleteProduct', id);
    },
    changeStatus : function (id) {
      this.$store.dispatch('category/changeStatusProduct', id);
    }
  },
};
</script>
<style>
</style>
