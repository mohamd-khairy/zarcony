<template>
  <div class="container">
    <div class="row">
      <div class="col-md-12">
        <div class="card card-primary card-outline">
          <div class="card-body box-profile">
            <div class="text-center">
              <img
                class="profile-user-img img-fluid img-circle"
                src="/logo.png"
                alt="User profile picture"
              />
            </div>
            <ul class="list-group list-group-unbordered mb-3">
              <li class="list-group-item">
                <b>Name</b> <a class="float-right">{{ user.name }}</a>
              </li>
              <li class="list-group-item">
                <b>Email</b> <a class="float-right">{{ user.email }}</a>
              </li>
              <li class="list-group-item">
                <b>Created At</b>
                <a class="float-right">{{ user.created_at }}</a>
              </li>
            </ul>
            <router-link
              :to="{ path: '/profile/' + user.id + '/edit' }"
              class="btn btn-primary btn-block"
              ><b>Edit Profile</b>
            </router-link>
          </div>
        </div>
      </div>
    </div>
  </div>
</template>

<script>
import axios from "axios";
export default {
  data: () => ({
    baseUrl: "http://infinite-coast-03874.herokuapp.com",
    user: {},
  }),
  methods: {},
  mounted() {
    axios
      .get(this.baseUrl + "/api/users?user_id=" + this.$route.params.id)
      .then((data) => {
        this.user = data.data.data;
      }) .catch((error) => {
          this.$toasted.show(error.response.data.message, {
            theme: "warning",
            position: "top-right",
            duration: 10000,
          });
        });
  },
};
</script>

