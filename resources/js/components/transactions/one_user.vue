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
            <h3 class="card-title">All Transactions</h3>
          </div>
          <!-- /.card-header -->

          <div class="card-body table-responsive p-0">
            <table class="table table-hover">
              <tbody>
                <tr>
                  <th>ID</th>
                  <th>From User Name</th>
                  <th>To User Name</th>
                  <th>Transaction Number</th>
                  <th>Amount</th>
                  <th>Status</th>
                  <th>Created At</th>
                </tr>
                <tr v-for="item in payments" :key="item.id">
                  <td>{{ item.id }}</td>
                  <td>{{ item.user.name }}</td>
                  <td>{{ item.to_user.name }}</td>
                  <td>{{ item.transaction_number }}</td>
                  <td>{{ item.balance }}</td>
                  <td>{{ item.status }}</td>
                  <td>{{ item.created_at }}</td>
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
            @submit.prevent="new_payment"
            @keydown="form.onKeydown($event)"
            class="m-4"
          >
            <select v-model="form.to_user_id" name="to_user_id">
              <option v-for="item in users" :key="item.id" :value="item.id">
                {{ item.name }}
              </option>
            </select>

            <div
              v-if="form.errors.has('to_user_id')"
              v-html="form.errors.get('to_user_id')"
            />

            <input
              v-model="form.balance"
              type="number"
              name="balance"
              placeholder="balance"
            />
            <div
              v-if="form.errors.has('balance')"
              v-html="form.errors.get('balance')"
            />

            <input
              v-model="form.card_number"
              type="number"
              name="card_number"
              placeholder="card_number"
            />
            <div
              v-if="form.errors.has('card_number')"
              v-html="form.errors.get('card_number')"
            />

            <input
              v-model="form.expiry_date"
              type="month"
              id="start"
              name="expiry_date"
              placeholder="expiry_date"
              min="2018-03"
              value="2018-05"
            />
            <div
              v-if="form.errors.has('expiry_date')"
              v-html="form.errors.get('expiry_date')"
            />

            <input
              v-model="form.cvv"
              type="number"
              name="cvv"
              placeholder="cvv"
            />
            <div
              v-if="form.errors.has('cvv')"
              v-html="form.errors.get('cvv')"
            />

            <input
              v-model="form.holder_name"
              type="text"
              name="holder_name"
              placeholder="holder_name"
            />
            <div
              v-if="form.errors.has('holder_name')"
              v-html="form.errors.get('holder_name')"
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
    baseUrl: "http://infinite-coast-03874.herokuapp.com",
    total: 0,
    page: 1,
    payments: {},
    users: {},
    form: new Form({
      to_user_id: "",
      balance: "",
      card_number: "",
      expiry_date: "",
      cvv: "",
      expiry_date: "",
      holder_name: "",
    }),
  }),

  methods: {
    get_users(page_size = 1000) {
      axios
        .get(this.baseUrl + "/api/users?page_size=" + page_size)
        .then((data) => {
          this.users = data.data.data.data;
        });
    },
    getResults(page = 1) {
      axios
        .get(
          this.baseUrl +
            "/api/payments?user_id=" +
            this.$route.params.user_id +
            "&page=" +
            page
        )
        .then((data) => {
          this.payments = data.data.data.data;
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
    async new_payment() {
      const response = await this.form
        .post(this.baseUrl + "/api/payment/" + this.$route.params.user_id)
        .then((data) => {
          this.form.reset();
          location.reload();
        })
        .catch((error) => {
          this.$toasted.show(error.response.data.message, {
            theme: "warning",
            position: "top-right",
            duration: 10000,
          });
          return false;
        });
    },
  },
  mounted() {
    // Fetch initial results
    this.user_id = this.$route.params.user_id;
    this.getResults();
    this.get_users();
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