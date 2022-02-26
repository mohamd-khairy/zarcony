<template>
  <div class="container">
    <div class="row mb-5">
      <!-- Button trigger modal -->
      <div class="col-12">
        <div class="card mb-5">
          <div class="card-header">
            <h3 class="card-title">All Logs</h3>
          </div>
          <!-- /.card-header -->

          <div class="card-body table-responsive p-0">
            <table class="table table-hover">
              <tbody>
                <tr>
                  <th>ID</th>
                  <th>user_id</th>
                  <th>subject</th>
                  <th>query_request</th>
                  <th>query_type</th>
                  <th>url</th>
                  <th>Created At</th>
                </tr>
                <tr v-for="item in logs" :key="item.id">
                  <td>{{ item.id }}</td>
                  <td v-if="item.user">{{ item.user.name }}</td>
                  <td v-else>-</td>
                  <td>{{ item.subject }}</td>
                  <td>{{ item.query_request }}</td>
                  <td>{{ item.query_type }}</td>
                  <td>{{ item.url }}</td>
                  <td>{{ item.created_at }}</td>
                </tr>
              </tbody>
            </table>
          </div>

          <pagination
            v-model="page"
            :records="total"
            :per-page="4"
            @paginate="getResults"
          />

          <!-- /.card-body -->
        </div>
        <!-- /.card -->
      </div>
    </div>
  </div>
</template>

<script>
import axios from "axios";

export default {
  data: () => ({
    baseUrl: "http://infinite-coast-03874.herokuapp.com",
    total: 0,
    page: 1,
    logs: {},
  }),

  methods: {
    getResults(page = 1) {
      axios
        .get(this.baseUrl + "/api/logs?page=" + page)
        .then((data) => {
          this.logs = data.data.data.data;
          this.total = data.data.data.total;
        })
        .catch((error) => {
          this.$toasted.show(error.response.data.message, {
            theme: "warning",
            position: "top-right",
            duration: 10000,
          });
        });
    },
  },
  mounted() {
    // Fetch initial results
    this.user_id = this.$route.params.user_id;
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