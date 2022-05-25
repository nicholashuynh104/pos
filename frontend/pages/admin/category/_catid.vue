<template >
  <div>
    <SidebarVue />
    <v-container>
      <v-row justify="center">
        <v-col xl="6" lg="6" md="6" sm="8" xs="12">
          <nuxt-link to="/admin/category">
            <v-btn color="secondary" class="mb-4">Go Back</v-btn></nuxt-link
          >
          <v-card>
            <v-card-title> Update Category</v-card-title>
            <v-card-title v-if="isloading">Loading....</v-card-title>
            <v-card-subtitle>
              <el-form :inline="true" class="demo-form-inline form">
                <el-form-item label="Category Name">
                  <el-input placeholder="Name" v-model="category.name"></el-input>
                </el-form-item><br>
                <el-form-item label="Category Image">
                  <el-upload
                    class="avatar-uploader"
                    :show-file-list="false"
                    :on-success="handleAvatarSuccess"
                    :before-upload="beforeAvatarUpload">
                    <img v-if="imageUrl" :src="imageUrl" class="avatar" @onChangeFile="changeFile">
                    <img v-else :src="'http://localhost:8000/storage/' + category.image" @onChangeFile="changeFile" class="avatar">
                    <!-- <i v-else class="el-icon-plus avatar-uploader-icon"></i> -->
                  </el-upload>
                </el-form-item><br>
                <el-form-item>
                  <el-button type="primary" @click="update">Update</el-button>
                </el-form-item>{{'ss'+this.$store.LOADING}}
              </el-form>
            </v-card-subtitle>
          </v-card>
        </v-col>
      </v-row>
    </v-container>
  </div>
</template>
<script>
import SidebarVue from "../../../components/admin/Sidebar.vue";
import axios from "axios";
import { mapActions, mapState, mapGetters } from "vuex";
export default {
  name: "EditCategoryPage",
  components: {
    SidebarVue,
  },
  data: () => ({
    // isloading: false,
    imageUrl: ''
  }),
  beforeCreate() {
    this.$store.dispatch('category/fetchOne', this.$route.params.catid);
  },
  computed: {
    ...mapState('category', {
      category: 'category'
    }),
    ...mapGetters({isLoading : 'isLoading'})
  },
  methods: {
    changeFile(e) {
      this.imageUrl = e;
    },
    handleAvatarSuccess(res, file) {
      this.imageUrl = URL.createObjectURL(file.raw);
    },
    update: function() {
      this.$store.dispatch('category/editProduct', this.category);
      // this.$router.push({name: 'productIndex'});
    }
  }
};
</script>

<style>
  .avatar-uploader .el-upload {
    border: 1px dashed #d9d9d9;
    border-radius: 6px;
    cursor: pointer;
    position: relative;
    overflow: hidden;
  }
  .avatar-uploader .el-upload:hover {
    border-color: #409EFF;
  }
  .avatar-uploader-icon {
    font-size: 28px;
    color: #8c939d;
    width: 178px;
    height: 178px;
    line-height: 178px;
    text-align: center;
  }
  .avatar {
    width: 178px;
    height: 178px;
    display: block;
  }
</style>
