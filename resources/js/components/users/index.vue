<template>
  <div class="">
    <button
      type="button"
      class="btn btn-success"
      data-bs-toggle="modal"
      data-bs-target="#exampleModal"
    >
      Add New
    </button>

    <div class="row mt-2">
      <!-- Button trigger modal -->
      <div class="col-12">
        <div class="card">
          <div class="card-header">
            <h3 class="card-title">Responsive Hover Table</h3>
          </div>
          <!-- /.card-header -->
          <div class="card-body table-responsive p-0">
            <table class="table table-hover">
              <tbody>
                <tr>
                  <th>ID</th>
                  <th>Name</th>
                  <th>Email</th>
                  <th>Date</th>
                </tr>
                <tr v-for="user in users.data" :key="user.id">
                  <td>{{ user.id }}</td>
                  <td>{{ user.name }}</td>
                  <td>{{ user.email }}</td>
                  <td>{{ user.created_at }}</td>
                  <td>
                    <a href="#"> edit </a>
                    /
                    <a href="#"> delete </a>
                  </td>
                </tr>
              </tbody>
            </table>
          </div>

          <pagination
            v-model="page"
            :records="total"
            :per-page="10"
            @paginate="getResults"
          />

          <!-- /.card-body -->
        </div>
        <!-- /.card -->
      </div>
    </div>

    <!-- Modal -->
    <div
      class="modal fade"
      id="exampleModal"
      tabindex="-1"
      aria-labelledby="exampleModalLabel"
      aria-hidden="true"
    >
      <div class="modal-dialog">
        <div class="modal-content">
          <div class="modal-header">Create New User</div>
          <form
            @submit.prevent="new_user"
            @keydown="form.onKeydown($event)"
            class="m-4"
          >
            <input
              v-model="form.name"
              type="text"
              name="name"
              placeholder="name"
            />
            <div
              v-if="form.errors.has('name')"
              v-html="form.errors.get('name')"
            />

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

            <button type="submit" class="mt-4" :disabled="form.busy">
              Create
            </button>
            <button
              type="button"
              class="btn btn-secondary"
              data-bs-dismiss="modal"
            >
              Close
            </button>
          </form>
        </div>
      </div>
    </div>
  </div>
</template>

<script>
import Form from "vform";
import axios from "axios";

export default {
  data: () => ({
    total: 0,
    page: 1,
    pagination: {},
    users: {},
    form: new Form({
      name: "",
      email: "",
      password: "",
    }),
  }),

  methods: {
    getResults(page = 1) {
      axios.get("api/users?page=" + page).then((data) => {
        console.log(data.data.data);
        this.users = data.data.data;
        this.total = data.data.data.total;
      });
    },
    async new_user() {
      const response = await this.form.post("/api/register");
      this.form.reset();
    },
  },
  mounted() {
    // Fetch initial results
    this.getResults();
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