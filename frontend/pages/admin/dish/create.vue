<template >
  <div>
    <SidebarVue />
    <v-container>
      <v-row justify="center" class="mt-10">
        <v-col xl="6" lg="6" md="6" sm="8" xs="12">
          <nuxt-link to="/admin/post">
            <v-btn color="secondary" class="mb-4">Go Back</v-btn></nuxt-link
          >
          <v-card>
            <v-card-title> Add Dish</v-card-title>
            <v-card-subtitle>
              <form action="" class="form" @submit.prevent="addPost">
                <v-text-field
                  label="Enter Titile"
                  class="form__control"
                  hide-details="auto"
                  outlined
                  v-model="title"
                >
                </v-text-field><br>
                <el-select v-model="value" placeholder="Select">
                  <el-option
                    v-for="item in getCategories"
                    :key="item.id"
                    :label="item.category_name"
                    :value="item.id"
                    >
                  </el-option>
                </el-select>
                <v-checkbox
                  v-model="checkbox"
                  :label="`Optional`"
                ></v-checkbox>
                <v-textarea
                  class="form__control"
                  label="Enter description"
                  outlined
                  v-model="description"
                ></v-textarea>
                <v-file-input
                  accept="image/*"
                  label="File input"
                  outlined
                  @change="onChangeFile"
                ></v-file-input>
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
import { mapActions, mapGetters } from "vuex";

export default {
  name: "createPostPage",
  components: {
    SidebarVue,
  },
  computed: {
    ...mapGetters(['getCategories']),
  },
  data: () => ({
    cat_id: "",
    title: "",
    file: "",
    description: "",
    checkbox: true,
    value: ''
  }),

  methods: {
    ...mapActions(["getCategory"]),
    ...mapActions(["createDish"]),
    onChangeFile(e) {
      this.file = e;
    },
    addPost() {
      if (!this.title || !this.description) {
        this.$toast.show("Please fill the field", {
          type: "error",
        });
      } else {
        // we use formdata
        const formdata = new FormData();
        formdata.append("title", this.title);
        formdata.append("cat_id", 3);
        formdata.append("description", this.description);
        formdata.append("image", this.file);
        this.createPost(formdata);
      }
    },
  },
  async mounted() {
    this.getCategory();
  }
};
</script>
<style>
</style>
