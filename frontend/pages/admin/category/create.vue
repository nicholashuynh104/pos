<template >
  <div>
    <SidebarVue />
    <v-container>
      <v-row justify="center" class="mt-10">
        <v-col xl="6" lg="6" md="6" sm="8" xs="12">
          <nuxt-link to="/admin/category/">
            <v-btn color="secondary" class="mb-4">Go Back</v-btn></nuxt-link
          >
          <v-card>
            <v-card-title> Add Category</v-card-title>
            <v-card-subtitle>
              <form action="" class="form" @submit.prevent="addCategory">
                <v-text-field
                  label="Enter Category"
                  class="form__control"
                  hide-details="auto"
                  v-model="name"
                >
                </v-text-field>
                <br/>
                <v-file-input
                  accept="image/*"
                  label="File input"
                  outlined
                  @change="onChangeFile"
                ></v-file-input>
                <br/>
                <v-btn color="error" type="submit" class="login__btn">
                  {{ $store.state.isloading ? "Saveing..." : "Save" }}</v-btn
                >
              </form>
            </v-card-subtitle>
          </v-card>
        </v-col>
      </v-row>
    </v-container>
  </div>
</template>
<script>
import SidebarVue from "../../../components/admin/Sidebar.vue";
import { mapActions } from "vuex";

export default {
  name: "createCategoryPage",
  components: {
    SidebarVue,
  },
  data: () => ({
    name: "",
    image: ""
  }),
  methods: {
    onChangeFile(e) {
      this.image = e
    },
    addCategory: function() {
      const formdata = new FormData();
      formdata.append("name", this.name);
      formdata.append("image", this.image);
      this.$store.dispatch('category/addProduct', formdata);
    }
  },
};
</script>
<style>
</style>
