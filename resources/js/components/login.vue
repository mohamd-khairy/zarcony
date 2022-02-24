<template>
  <div class="container">
    <div class="row justify-content-center">
      <div class="col-md-8">
        <div class="card">
          <div class="card-header">Login</div>

          <div class="card-body">
            <form
              method="POST"
              @submit.prevent="login"
              @keydown="form.onKeydown($event)"
            >
              <div class="row mb-3">
                <label for="email" class="col-md-4 col-form-label text-md-end"
                  >Email Address</label
                >

                <div class="col-md-6">
                  <input
                    v-model="form.email"
                    id="email"
                    type="email"
                    class="form-control"
                    name="email"
                    required
                    autocomplete="email"
                    autofocus
                  />
                </div>
              </div>

              <div class="row mb-3">
                <label
                  for="password"
                  class="col-md-4 col-form-label text-md-end"
                  >Password</label
                >

                <div class="col-md-6">
                  <input
                    v-model="form.password"
                    id="password"
                    type="password"
                    class="form-control"
                    name="password"
                    required
                    autocomplete="current-password"
                  />
                </div>
              </div>

              <div class="row mb-0">
                <div class="col-md-8 offset-md-4">
                  <button
                    type="submit"
                    class="btn btn-primary"
                    :disabled="form.busy"
                  >
                    Login
                  </button>
                </div>
              </div>
            </form>
          </div>
        </div>
      </div>
    </div>
  </div>
</template>
<script>
import Form from "vform";

export default {
  data: () => ({
    form: new Form({
      email: "",
      password: "",
    }),
  }),
  methods: {
    async login() {
      const response = await this.form.post("/api/login").then((data) => {
        console.log(data.data);
        localStorage.setItem("token", data.data.data.token);
        localStorage.setItem("user", data.data.data);
      });
      this.form.reset();
    },
  },
};
</script>