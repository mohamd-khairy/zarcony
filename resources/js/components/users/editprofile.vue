<template>
  <div class="container">
    <div class="row">
      <h1>Edit Profile</h1>
      <form
        @submit.prevent="edit_user"
        @keydown="form.onKeydown($event)"
        class="m-4"
      >
        <input v-model="form.name" type="text" name="name" placeholder="name" />
        <div v-if="form.errors.has('name')" v-html="form.errors.get('name')" />

        <input
          v-model="form.email"
          type="email"
          name="email"
          placeholder="email"
        />
        <div
          v-if="form.errors.has('email')"
          v-html="form.errors.get('email')"
        />

        <input
          v-model="form.password"
          type="password"
          name="password"
          placeholder="Password"
        />
        <div
          v-if="form.errors.has('password')"
          v-html="form.errors.get('password')"
        />

        <button type="submit" class="mt-4" :disabled="form.busy">Edit</button>
      </form>
    </div>
  </div>
</template>

<script>
import Form from "vform";
export default {
  data: () => ({
    baseUrl: "http://zarcony.test",
    form: new Form({
      name: "",
      email: "",
      password: "",
    }),
  }),

  methods: {
    async edit_user() {
      const response = await this.form.put(
        "/api/user/edit/" + this.$route.params.id
      );
      this.$router.push({ path: "/profile/" + this.$route.params.id });
    },
  },
  mounted() {
    axios
      .get(this.baseUrl + "/api/users?user_id=" + this.$route.params.id)
      .then((data) => {
        this.form.name = data.data.data.name;
        this.form.email = data.data.data.email;
      });
  },
};
</script>


<style scoped>
form {
  background: #fff;
  text-align: left;
  border-radius: 10px;
}

label {
  color: #aaa;
  display: inline-block;
  margin: 25px 0 15px;
  text-transform: uppercase;
}

input,
select {
  display: block;
  padding: 10px 6px;
  width: 100%;
  box-sizing: bordre-box;
  border: none;
  border-bottom: 1px solid #ddd;
  color: #555;
}

input[type="checkbox"] {
  display: inline-block;
  width: 16px;
  margin: 0 10px 0;
  position: relative;
  top: 2px;
}

.pill {
  display: inline-block;
  margin: 20px 10px 0 0;
  padding: 6px 12px;
  border-radius: 20px;
  font-size: 12px;
  cursor: pointer;
  background: #eee;
}

button {
  background: rgb(7, 24, 7);
  border: 0;
  padding: 10px 20px;
  color: white;
  border-radius: 20px;
}

.submit {
  text-align: center;
}

.error {
  color: #ff0000;
  margin-top: 10px;
  font-size: 0.8em;
  font-weight: bold;
}
</style>