<template>
  <v-app id="inspire">
    <v-main>
      <v-container class="fill-height" fluid>
        <v-row align="center" justify="center">
          <v-col cols="12" sm="8" md="5">
            <v-card class="elevation-12"  >
              <v-window v-model="step">
                <v-window-item :value="1">
                  <v-row>
                    <v-progress-linear
                      :active="loading"
                      :indeterminate="loading"
                      absolute
                      top
                      color="blue accent-3"
                    ></v-progress-linear>
                    <v-col cols="12" md="8" >
                      <v-card-text class="mt-12">
                        <div class="text-center pb-5 mt-4">
                          <v-btn class="mx-2 pb-5" icon>
                            <v-img
                              src="http://oscs.parsu.edu.ph/img/psulogo.png"
                              alt="Parsu"
                              width="100px"
                            ></v-img>
                          </v-btn>
                        </div>
                        <h1
                          class="text-center display-2 primary--text text--accent-4"
                        >
                          Sign in to ParSU Alumni
                        </h1>
                       
                        <h4 class="text-center mt-4">
                          Ensure your email for sign in
                        </h4>
                        <v-form>
                          <v-text-field
                            label="Email"
                            name="Email"
                            v-model="user.email"
                            prepend-icon="mdi-email"
                            type="text"
                            color="teal accent-4"
                            :rules="[rules.required, rules.validEmail]"
                          />
                          <v-text-field
                            :type="showPassword ? 'text' : 'password'"
                            label="Password"
                            v-model="user.password"
                            color="teal accent-4"
                            prepend-icon="mdi-account-lock-outline"
                            :append-icon="
                              showPassword ? 'mdi-eye' : 'mdi-eye-off'
                            "
                              :rules="[rules.required]"
                            @click:append="showPassword = !showPassword"
                          />
                        </v-form>
                        <h3 class="text-center mt-3">Forgot your password?</h3>
                      </v-card-text>
                      <div class="text-center mt-3 pb-3">
                        <v-btn rounded color="blue accent-3" @click="login" dark
                          >SIGN IN</v-btn
                        >
                      </div>
                    </v-col>
                     <v-col cols="12" md="4" class="primary accent-3">
                          <v-card-text class="white--text mt-12">
                            <h1 class="text-center display-1">Hello, Friends !</h1>
                            <h5 class="text-center">Enter your personal details and start journey with us</h5>
                          </v-card-text>
                          <div class="text-center">
                            <v-btn rounded outlined="" dark @click="step++">SIGN UP</v-btn>
                          </div> 
                        </v-col>
                  </v-row>
                </v-window-item> <v-window-item :value="2">
                      <v-row class="fill-height">
                        <v-col cols="12" md="4" class="teal accent-3" >
                          <v-card-text class="white--text mt-12">
                            <h1 class="text-center display-1">Welcome Back!</h1>
                            <h5 class="text-center">To Keep connected with us please login with your personal info</h5>
                          </v-card-text>
                          <div class="text-center">
                            <v-btn rounded outlined dark @click="step--">SIGN IN</v-btn>
                          </div>
                        </v-col>
                        <v-col cols="12" md="8">
                           <v-form
                              v-model="valid"
                              method="post"
                              v-on:submit.stop.prevent="save" 
                            >
                          <v-card-text class="mt-12">
                            <h1 class="text-center desplay-2 teal--text text--accent3">Create Account</h1>
                            
                            <h4 class="text-center mt-4">Ensure your email for registration</h4> 
                           
                              <v-text-field
                              label="Student ID Number"
                              name="student_id"
                              prepend-icon="mdi-ticket-account"
                              type="text"
                              v-model="editedItem.student_number"
                              color="teal accent-3" /> 
                                <v-text-field
                              label="First Name"
                              name="FName"
                              prepend-icon="mdi-account"
                              type="text"
                              color="teal accent-3"
                              v-model="editedItem.fname"
                              :error-messages="fnameErrors" 
                              required
                              @input="$v.fname.$touch()"
                              @blur="$v.fname.$touch()"
                             /> 
                                <v-text-field
                              label="Last Name"
                              name="LName"
                              prepend-icon="mdi-account"
                              type="text"
                              color="teal accent-3"
                              v-model="editedItem.lname"
                              :error-messages="lnameErrors" 
                              required
                              @input="$v.lname.$touch()"
                              @blur="$v.lname.$touch()"
                             /> 
                             <v-text-field
                              label="Middle Name"
                              name="MName"
                              prepend-icon="mdi-account"
                              type="text"
                              color="teal accent-3"
                              v-model="editedItem.mname"
                              :error-messages="mnameErrors"  
                              @input="$v.mname.$touch()"
                              @blur="$v.mname.$touch()"
                             /> 
                             
                                <v-select
                                v-model="editedItem.batch"
                                :items="batchtypes"
                                menu-props="auto"
                                label="Select Batch Type"
                                hide-details
                                prepend-icon="mdi-clipboard-account"
                                class="pb-3"
                                single-line   
                                item-value="id"
                                item-text="name" 
                                color="primary"
                                @change="batchTypeListener"
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
                                prepend-icon="mdi-group"
                                class="pb-3"
                                single-line
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
                                prepend-icon="mdi-group"
                                class="pb-3"
                                single-line
                              ></v-select>    
                               <v-text-field
                              label="Email"
                              name="Email"
                              prepend-icon="mdi-mail"
                              type="text"
                              color="teal accent-3" 
                              v-model="editedItem.email"
                              :error-messages="emailErrors" 
                              required
                              @input="$v.email.$touch()"
                              @blur="$v.email.$touch()"
                              />
                              <v-text-field 
                              :type="showPassword ? 'text' : 'password'" 
                              label="Password"
                              prepend-icon="mdi-account-lock-outline"
                              :append-icon="showPassword ? 'mdi-eye' : 'mdi-eye-off'"
                              @click:append="showPassword = !showPassword"
                              v-model="editedItem.password" 
                              :error-messages="passwordErrors" 
                              required
                              @input="$v.password.$touch()"
                              @blur="$v.password.$touch()"
                            />
                            <v-text-field 
                              :type="showPasswordc ? 'text' : 'password'" 
                              label="Confirm Password"
                              prepend-icon="mdi-account-lock-outline"
                              :append-icon="showPasswordc ? 'mdi-eye' : 'mdi-eye-off'"
                              @click:append="showPasswordc = !showPasswordc"
                              v-model="editedItem.confirmPassword" 
                              :error-messages="confirmPasswordErrors" 
                              required
                              @input="$v.confirmPassword.$touch()"
                              @blur="$v.confirmPassword.$touch()"
                            />
                            
                          </v-card-text>
                          <div class="text-center mt-3 pb-3">
                            <v-btn rounded color="blue accent-3" 
                             type="submit"
                            :disabled="!valid"
                            @click.prevent="save"
                            dark>SIGN UP</v-btn>
                          </div>
                          </v-form>
                        </v-col>
                      </v-row>
                  </v-window-item>
              </v-window>
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
    showPassword: false,
    showPasswordc: false,
    email: "",
    password: "",
    loading: false,
    snackbar: false,
    showPassword: false,
    showPasswordc: false,
    loginloading: false,
    email: "",
    password: "",
    student: {
      student_number: "",
    },
     rules: {
      required: (v) => !!v || "This Field is Required",
      // min: (v) => v.length >= 5|| "Minimum 5 Characters Required",
      min: (v) => v.length >= 5 || "Minimum 5 Characters Required",
      validEmail: (v) => /.+@.+\..+/.test(v) || "Email must be valid",
    },
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
    c_year:'',
    h_year:'',
    student_number:'',
    lname:'',
    mname:'',
    fname:'',
    email:'',
    password:'',
    confirmPassword:'',

    officess: {}, 
    rules: {
      required: (v) => !!v || "This Field is Required",
      min: (v) => v.length >= 5 || "Minimum 5 Characters Required",
      validEmail: (v) => /.+@.+\..+/.test(v) || "Email must be valid",
    },
    editedIndex: -1,
    editedItem: {
      id: "",
      batch:'',
       c_year:'',
    h_year:'',
    student_number:'',
    lname:'',
    mname:'',
    fname:'',
    email:'',
    password:'',
    confirmPassword:'',
      created_at: "",
    },
    defaultItem: {
      id: "",
      batch:'',
       c_year:'',
    h_year:'',
    student_number:'',
    lname:'',
    mname:'',
    fname:'',
    email:'',
    password:'',
    confirmPassword:'',
      created_at: "",
    },
  }),
computed: {
    formTitle() {
      return this.editedIndex === -1 ? "New User" : "Edit User";
    },
    formIcon() {
      return this.editedIndex === -1 ? "mdi-account-plus" : "mdi-account-edit";
    },
    passwordmatch() {
      return this.editedItem.password != this.editedItem.confirmPassword
        ? "Password Does Not Match"
        : true;
    },
    checkEmail() {
      if (/.+@.+\..+/.test(this.editedItem.email)) {
        axios
          .post("/api/v1/email/verify", { email: this.editedItem.email })
          .then((res) => {
            this.success = res.data.message;
            this.error = "";
          })
          .catch((err) => {
            this.success = "";
            this.error = "Email Already Exist";
          });
      }
    },
    checkUUID() {
      if (this.activationCode != "") {
        axios
          .post("/api/v1/activation/verify", { code: this.activationCode })
          .then((res) => {
            if (this.activationCode != "") {
              this.success = res.data.message;
              this.error = "";

              this.step++;
              this.success = "";
              this.student = res.data.student;
              this.program = res.data.program;
            } else if (this.activationCode == "") {
              this.success = "";
              this.error = "This Field is Required";
            }
          })
          .catch((err) => {
            if (this.activationCode != "") {
              console.log(err);
              this.success = "";
              this.error = "Invalid Code";
            } else if (this.activationCode == "") {
              console.log(err);
              this.success = "";
              this.error = "This Field is Required";
            }
          });
      }
    },
  },

  methods: {
    batchTypeListener() {
      this.batchIndex = this.editedItem.batch;
      console.log(this.editedItem.batch);
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
    loginG() {
      axios.get("/api/v1/auth/google");
    },
    resetPassword() {
      this.$router.push({ name: "reset-password" });
    },
    activate() {
      axios
        .post("/api/v1/user/register", {
          email: this.editedItem.email,
          password: this.editedItem.password,
          rpassword: this.editedItem.rpassword,
          student: this.student.id,
        })
        .then((response) => {
          this.dialog = true;
        })
        .catch((err) => {
          this.snackbar = true;
          this.text = err.response.data.message;
          console.log(err.response.data.message);
        });
    },
    proceedtologin() {
      this.dialog = false;
      this.$router.go(0);
      this.student = "";
      this.activationCode = "";
      this.editedItem = "";
    },

    login() {
      this.loginloading = true;
      axios
        .post("/api/v1/user/login", {
          email: this.user.email,
          password: this.user.password,
        })
        .then((response) => {
          localStorage.setItem("token", response.data.access_token);

          window.location.replace("/#/");
          this.loginloading = false;
        })
        .catch((err) => {
          if (err.response.status == 419) {
            this.$router.push("/");
          } else {
            this.snackbar = true;
            this.text = err.response.data.message;
            console.log(err.response.data.message);
          }
          this.loginloading = false;
        });
    },
    //  dismiss() {
    //   this.$store.state.error = "";
    // }
    save() {
      axios
        .post("/api/v1/register", this.editedItem)
        .then((response) => {
          this.loginloading = true;
          axios
            .post("/api/v1/user/login", {
              email: this.editedItem.email,
              password: this.editedItem.password,
            })
            .then((response) => {
              localStorage.setItem("token", response.data.access_token);

              window.location.replace("/#/");
              this.loginloading = false;
            })
            .catch((err) => {
              if (err.response.status == 419) {
                this.$router.push("/");
              } else {
                this.snackbar = true;
                this.text = err.response.data.message;
                console.log(err.response.data.message);
              }
              this.loginloading = false;
            });
        })
        .catch((err) => {});
    },
  },
  created() {
    this.initialize();
    axios.defaults.headers["Authorization"] =
      "Bearer " + localStorage.getItem("token");
    // this.$store.dispatch('currentUser/getUser');
    if (localStorage.getItem("token")) {
      this.$router
        .push("/")
        .then((res) => console.log("Already login!"))
        .catch((err) => console.log(err));
    }
  },
  props: {
    source: String,
  },
  name: "App",
};
</script>