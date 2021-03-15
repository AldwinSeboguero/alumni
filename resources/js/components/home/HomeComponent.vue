<template>
  <v-app id="inspire">
    <v-main>
      <v-container class="fill-height" fluid>
        <v-row align="center" justify="center">
          <v-col cols="12" sm="8" md="8">
            <v-card class="elevation-0">
              <v-row>
                <v-progress-linear
                  :active="loading"
                  :indeterminate="loading"
                  absolute
                  top
                  color="blue accent-3"
                ></v-progress-linear>
                <v-col cols="12" lg="6">
                  <v-card-text class="mt-12">
                    <div class="text-center pb-5 mt-12">
                      <v-btn class="mt-12 pb-8" icon>
                        <v-img
                          src="images/psu_logo.png"
                          alt="Parsu"
                          width="100px"
                        ></v-img>
                      </v-btn>
                    </div>
                    <h3
                      class="text-center display-2 primary--text text--accent-4"
                    >
                      Sign in to ParSU Alumni
                    </h3>
                  </v-card-text>
                </v-col>

                <v-col cols="12" lg="6">
                  <v-card
                    class="mx-auto rounded-xl"
                    style="padding: 20px"
                    elevation="1"
                    default
                  >
                    <v-card-text class="mt-6">
                      <h1
                        class="text-center desplay-2 black--text text--accent3"
                      >
                        Login
                      </h1>
                    </v-card-text>
                    <v-list-item three-line>
                      <v-list-item-content>
                        <div class="text-center pb-5 mt-4">
                          <v-form>
                            <v-text-field
                              label="Email"
                              name="Email"
                              v-model="user.email"
                              type="text"
                              color="teal accent-4"
                              dense
                              filled
                              rounded
                            />
                            <v-text-field
                              dense
                              filled
                              rounded
                              :type="showPassword ? 'text' : 'password'"
                              label="Password"
                              v-model="user.password"
                              color="teal accent-4"
                              :append-icon="
                                showPassword ? 'mdi-eye' : 'mdi-eye-off'
                              "
                              @click:append="showPassword = !showPassword"
                            />
                          </v-form>

                          <div class="text-center mt-3 pb-3">
                            <v-btn
                              block
                              x-large
                              rounded
                              color="blue accent-3"
                              @click="login"
                              dark
                              >SIGN IN</v-btn
                            >
                            <h5
                              class="primary--text text--accent-4 text-center mt-3"
                            >
                              Forgot your password?
                            </h5>
                          </div>
                          <v-divider />
                        </div>
                      </v-list-item-content>
                    </v-list-item>

                    <v-card-actions>
                      <v-dialog v-model="dialog" persistent max-width="400px">
                        <template v-slot:activator="{ on, attrs }">
                          <v-btn
                            v-bind="attrs"
                            v-on="on"
                            block
                            color="success"
                            x-large
                            >Create Account</v-btn
                          >
                        </template>
                        <div v-slimscroll="scrollOptions">
                          <v-card>
                            <v-card-title
                              class="headline font-weight-500 justify-space-between"
                            >
                              <span>
                                <v-list-item-title class="headline">
                                  {{ currentTitle }}
                                </v-list-item-title>
                                <v-list-item-subtitle>{{
                                  currentTitleSub
                                }}</v-list-item-subtitle>
                              </span>

                              <v-btn icon @click="dialog = false"
                                ><v-icon dark> mdi-close </v-icon></v-btn
                              >
                            </v-card-title>
                            <v-divider />
                            <v-window v-model="step">
                              <v-window-item :value="1">
                                <v-card-text>
                                  <v-text-field
                                    label="First name"
                                    type="FName"
                                    dense
                                    filled
                                    rounded
                                  ></v-text-field>
                                  <v-text-field
                                    label="Last name"
                                    type="LName"
                                    dense
                                    filled
                                    rounded
                                  ></v-text-field>
                                  <v-text-field
                                    label="Middle name"
                                    type="MName"
                                    dense
                                    filled
                                    rounded
                                  ></v-text-field>
                                  <v-dialog
                                    ref="dialog"
                                    v-model="modal"
                                    :return-value.sync="date"
                                    persistent
                                    width="290px"
                                  >
                                    <template v-slot:activator="{ on, attrs }">
                                      <v-text-field
                                        v-model="date"
                                        label="Birthday"
                                        readonly
                                        v-bind="attrs"
                                        v-on="on"
                                        filled
                                        rounded
                                      ></v-text-field>
                                    </template>
                                    <v-date-picker v-model="date" scrollable>
                                      <v-spacer></v-spacer>
                                      <v-btn
                                        text
                                        color="primary"
                                        @click="modal = false"
                                      >
                                        Cancel
                                      </v-btn>
                                      <v-btn
                                        text
                                        color="primary"
                                        @click="$refs.dialog.save(date)"
                                      >
                                        OK
                                      </v-btn>
                                    </v-date-picker>
                                  </v-dialog>
                                </v-card-text>
                              </v-window-item>
                              <v-window-item :value="2">
                                <v-card-text>
                                  <v-text-field
                                    label="Student Number"
                                    type="SNumber"
                                    dense
                                    filled
                                    rounded
                                  ></v-text-field>
                                  <v-select
                                    v-model="editedItem.batch"
                                    :items="batchtypes"
                                    menu-props="auto"
                                    label="Select Batch Type"
                                    hide-details
                                    class="pb-3"
                                    single-line
                                    item-value="id"
                                    item-text="name"
                                    color="primary"
                                    @change="batchTypeListener"
                                    filled
                                    rounded
                                  ></v-select>

                                  <v-select
                                    v-if="batchIndex == 1"
                                    v-model="editedItem.h_year"
                                    :items="h_years"
                                    item-value="id"
                                    item-text="year"
                                    menu-props="auto"
                                    label="Select High School Batch Year"
                                    hide-details
                                    class="pb-3"
                                    single-line
                                    filled
                                    rounded
                                  ></v-select>

                                  <v-select
                                    v-if="batchIndex == 2"
                                    v-model="editedItem.c_year"
                                    :items="c_years"
                                    item-value="id"
                                    item-text="year"
                                    menu-props="auto"
                                    label="Select College Batch Year"
                                    hide-details
                                    class="pb-3"
                                    single-line
                                    filled
                                    rounded
                                  ></v-select>
                                </v-card-text>
                              </v-window-item>
                              <v-window-item :value="3">
                                <v-card-text>
                                  <v-text-field
                                    label="Email"
                                    type="Email"
                                    dense
                                    filled
                                    rounded
                                  ></v-text-field>
                                  <span
                                    class="caption grey--text text--darken-1"
                                  >
                                    This is the email you will use to login to
                                    your Alumni account
                                  </span>
                                </v-card-text>
                              </v-window-item>
                              <v-window-item :value="4">
                                <v-card-text>
                                  <v-text-field
                                    label="Password"
                                    type="password"
                                    dense
                                    filled
                                    rounded
                                  ></v-text-field>
                                  <v-text-field
                                    label="Confirm Password"
                                    type="password"
                                    dense
                                    filled
                                    rounded
                                  ></v-text-field>
                                  <span
                                    class="caption grey--text text--darken-1"
                                  >
                                    Please enter a password for your account
                                  </span>
                                </v-card-text>
                              </v-window-item>

                              <v-window-item :value="5">
                                <div class="pa-4 text-center">
                                  <v-img
                                    class="mb-4"
                                    contain
                                    height="128"
                                    src="images/psu_logo.png"
                                  ></v-img>
                                  <h3 class="title font-weight-light mb-2">
                                    Welcome to ParsU Alumni
                                  </h3>
                                  <span class="caption grey--text"
                                    >Thanks for signing up!</span
                                  >
                                </div>
                              </v-window-item>
                            </v-window>

                            <v-divider></v-divider>

                            <v-card-actions align="center" justify="center">
                              <v-spacer />
                              <v-btn
                                :disabled="step === 1"
                                text
                                rounded
                                large
                                @click="step--"
                              >
                                Back
                              </v-btn>
                              <v-btn
                                v-if="step !== 5"
                                color="primary"
                                depressed
                                rounded
                                @click="step++"
                              >
                                Next
                              </v-btn>
                              <v-spacer />
                            </v-card-actions>
                          </v-card>
                        </div>
                      </v-dialog>
                    </v-card-actions>
                    <div class="text-center font-italic">
                      <h5>For Inquiries: alumni.support@parsu.edu.ph</h5>
                    </div>
                  </v-card>
                </v-col>
              </v-row>
            </v-card>
            <v-snackbar v-model="snackbar" top>
              {{ text }}

              <template v-slot:action="{ attrs }">
                <v-btn
                  color="pink"
                  text
                  v-bind="attrs"
                  @click="snackbar = false"
                >
                  Close
                </v-btn>
              </template>
            </v-snackbar>
          </v-col>
        </v-row>
      </v-container>
    </v-main>
  </v-app>
</template>

<script>
export default {
  data: () => ({
    step: 1,
    batchIndex: 0,
    dialog: false,
    scrollOptions: {
      height: "100%",
    },
    date: new Date().toISOString().substr(0, 10),
    menu: false,
    modal: false,
    menu2: false,
    showPassword: false,
    showPasswordc: false,
    email: "",
    password: "",
    loading: false,
    snackbar: false,
    text: "",
    user: {
      email: "",
      password: "",
    },
    valid: true,
    dialog: false,
    loading: false,
    snackbar: false,
    selected: [],
    text: "",
    success: "",
    error: "",
    headers: [
      {
        text: "No",
        align: "left",
        value: "id",
      },
      { text: "Name", value: "name" },
      { text: "Total Working", value: "working" },
      { text: "Total Not Working", value: "notworking" },
      { text: "Total", value: "total" },
    ],
    page: 0,
    totalOffices: 0,
    numberOfPages: 0,
    options: {},
    batchtypes: {},
    h_years: {},
    c_years: {},
    c_year: "",
    h_year: "",
    student_number: "",
    lname: "",
    mname: "",
    fname: "",
    email: "",
    password: "",
    confirmPassword: "",

    officess: {},
    rules: {
      required: (v) => !!v || "This Field is Required",
      min: (v) => v.length >= 5 || "Minimum 5 Characters Required",
      validEmail: (v) => /.+@.+\..+/.test(v) || "Email must be valid",
    },
    editedIndex: -1,
    editedItem: {
      id: "",
      batch: "",
      c_year: "",
      h_year: "",
      student_number: "",
      lname: "",
      mname: "",
      fname: "",
      email: "",
      password: "",
      confirmPassword: "",
      created_at: "",
    },
    defaultItem: {
      id: "",
      batch: "",
      c_year: "",
      h_year: "",
      student_number: "",
      lname: "",
      mname: "",
      fname: "",
      email: "",
      password: "",
      confirmPassword: "",
      created_at: "",
    },
  }),

  computed: {
    formTitle() {
      return this.editedIndex === -1 ? "New Office" : "Edit Office";
    },
    formIcon() {
      return this.editedIndex === -1 ? "mdi-plus" : "mdi-pen";
    },
    currentTitle() {
      switch (this.step) {
        case 1:
          return "Sign Up";
        case 2:
          return "Email";
        case 3:
          return "Student Information";
        case 4:
          return "Create a password";
        default:
          return "Account created";
      }
    },
    currentTitleSub() {
      switch (this.step) {
        case 1:
          return "It’s quick and easy.";
        case 2:
          return "Provide your student information.";
        case 3:
          return "Ensure your email address.";
        case 4:
          return "Use a secure password.";
        default:
          return "Account created";
      }
    },
  },

  watch: {
    dialog(val) {
      val || this.close();
    },
    options: {
      handler() {
        this.readDataFromAPI();
      },
    },
    deep: true,
  },

  created() {
    this.initialize();
  },

  methods: {
    batchTypeListener() {
      this.batchIndex = this.editedItem.batch;
      console.log(this.editedItem.batch);
    },
    readDataFromAPI() {
      this.loading = true;
      const { page, itemsPerPage } = this.options;
      let pageNumber = page;
      axios
        .get(`/api/v1/goaOffices?page=` + pageNumber, {
          params: { per_page: itemsPerPage },
        })
        .then((response) => {
          //Then injecting the result to datatable parameters.
          this.loading = false;
          //  this.page = response.data.students;
          this.offices = response.data.offices;
          this.officess = response.data.officess;
          this.totalOffices = response.data.offices.total;
          this.numberOfPages = response.data.offices.last_page;
        })
        .catch((err) => {
          console.error(err);
        });
    },

    searchIt(d) {
      if (d.length > 3) {
        const { page, itemsPerPage } = this.options;
        axios
          .get(`/api/v1/offices/${d}`)
          .then((res) => {
            this.loading = false;
            // this.page = response.data.students;

            this.offices = res.data.offices;
            this.totalOffices = res.data.offices.total;
            this.numberOfPages = res.data.offices.last_page;
          })
          .catch((err) => {
            console.error(err);
          });
      }
      if (d.length <= 0) {
        axios
          .get(`/api/v1/offices?page=${d.page}`, {
            params: { per_page: d.itemsPerPage },
          })
          .then((res) => {
            this.loading = false;
            this.offices = res.data.offices;
            this.totalOffices = res.data.offices.total;
            this.numberOfPages = res.data.offices.last_page;
          })
          .catch((err) => {
            console.error(err);
          });
      }
    },
    initialize() {
      axios
        .get(`/api/v1/users`)
        .then((res) => {
          this.h_years = res.data.h_years;
          this.c_years = res.data.c_years;
          this.batchtypes = res.data.batches;
        })
        .catch((err) => {
          console.error(err);
        });
      axios.interceptors.request.use(
        (config) => {
          this.loading = true;
          return config;
        },
        (error) => {
          this.loading = false;
          return Promise.reject(error);
        }
      );

      axios.interceptors.response.use(
        (response) => {
          this.loading = false;
          return response;
        },
        (error) => {
          this.loading = false;
          return Promise.reject(error);
        }
      );
    },

    editItem(item) {
      this.editedIndex = this.offices.data.indexOf(item);
      this.editedItem = Object.assign({}, item);
      this.dialog = true;
    },

    deleteItem(item) {
      const index = this.offices.data.indexOf(item);
      let decide = confirm("Are you sure you want to delete this item?");
      if (decide) {
        axios
          .delete("/api/v1/offices/" + item.id)
          .then((res) => {
            this.text = "Record Deleted Successfully!";
            this.snackbar = true;
            this.offices.data.splice(index, 1);
          })
          .catch((err) => {
            console.log(err.response);
            this.text = "Error Deleting Record";
            this.snackbar = true;
          });
      }
    },

    close() {
      this.dialog = false;
      setTimeout(() => {
        this.editedItem = Object.assign({}, this.defaultItem);
        this.editedIndex = -1;
        this.step = 0;
      }, 300);
    },

    save() {
      if (this.editedIndex > -1) {
        const index = this.editedIndex;
        axios
          .put("/api/v1/offices/" + this.editedItem.id, this.editedItem)
          .then((res) => {
            this.text = "Record Updated Successfully!";
            this.snackbar = true;
            Object.assign(this.offices.data[index], res.data.office);
          })
          .catch((err) => {
            console.log(err.response);
            this.text = "Error Updating Record";
            this.snackbar = true;
          });
      } else {
        axios
          .post("/api/v1/register", this.editedItem)
          .then((res) => {
            this.text = "Record Added Successfully!";
            this.snackbar = true;
            // // this.campuses.data.push(res.data.campus);
            // this.offices = res.data.offices;
            // this.editedItem.name = this.defaultItem.name;
            console.log(res);
          })
          .catch((err) => {
            console.dir(err);
            this.text = "Error Inserting Record";
            this.snackbar = true;
          });
      }
      if (this.editedIndex != -1) {
        this.close();
      }
    },
  },
};
</script>