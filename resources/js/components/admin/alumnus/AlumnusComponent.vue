<template>
  <v-app id="inspire" class="pr-0">
    <v-sheet dark height="100%" id="scroll-target" class="pa-4">
      <v-row wrap>
        <v-col cols="12" lg="4" class="pa-0 ma-0">
          <v-form v-model="validAlumni">
            <v-card elevation="0" class="pa-5">
              <v-card-title class="overline text-h6"> Add Alumni </v-card-title>
              <v-card-text>
                <v-text-field
                  label="Student ID"
                  type="text"
                  v-model="addedItem.student_number"
                  :success-messages="success"
                  :error-messages="error"
                  :blur="checkStudentNumber"
                  :rules="[rules.required]"
                  dense
                  filled
                  rounded
                ></v-text-field>
                <v-text-field
                  label="First name"
                  v-model="addedItem.fname"
                  type="text"
                  :rules="[rules.required]"
                  dense
                  filled
                  rounded
                  required
                ></v-text-field>
                <v-text-field
                  label="Last name"
                  type="text"
                  :rules="[rules.required]"
                  v-model="addedItem.lname"
                  dense
                  filled
                  rounded
                ></v-text-field>
                <v-text-field
                  label="Middle name"
                  v-model="addedItem.mname"
                  type="text"
                  dense
                  filled
                  rounded
                  class="mb-0"
                ></v-text-field>
                <v-text-field
                  label="Address"
                  type="text"
                  v-model="addedItem.address"
                  dense
                  filled
                  rounded
                ></v-text-field>
                <v-select
                  v-model="addedItem.batch"
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
                  :rules="[rules.required]"
                  filled
                  rounded
                ></v-select>

                <v-select
                  v-if="batchIndex == 1 || batchIndex == 3"
                  v-model="addedItem.h_year"
                  :rules="[rules.required]"
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
                  v-if="batchIndex == 2 || batchIndex == 3"
                  v-model="addedItem.c_year"
                  :rules="[rules.required]"
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
              <v-card-actions class="mt-0 pt-0">
                <v-spacer></v-spacer>
                <v-btn
                  :disabled="!validAlumni"
                  :loading="loadingSaveAlumni"
                  @click="saveAlumni"
                  large
                  class="success accent-4 pa-5"
                  elevation="0"
                >
                  <v-icon class="mr-2">mdi-content-save</v-icon>
                  Save
                </v-btn>
              </v-card-actions>
            </v-card>
          </v-form>
        </v-col>
        <v-col cols="12" lg="8">
          <v-container fluid>
            <v-card dark elevation="0">
              <v-card-title>
                Alumni
                <v-spacer></v-spacer>
                <v-text-field
                  v-model="search"
                  append-icon="mdi-magnify"
                  label="Search"
                  single-line
                  hide-details
                  filled
                  rounded
                  @input="searchIt"
                ></v-text-field>
              </v-card-title>
              <v-data-table
                item-key="id"
                class="elevation-0"
                :loading="loading"
                loading-text="Loading... Please wait"
                :headers="headers"
                :page="page + 1"
                :pageCount="numberOfPages"
                :items="alumni.data"
                :options.sync="options"
                :server-items-length="totalAlumni"
                :items-per-page="10"
                :divider="false"
                :footer-props="{
                  itemsPerPageOptions: [5, 10, 15],
                  itemsPerPageText: 'Alumni Per Page',
                  'show-current-page': true,
                  'show-first-last-page': true,
                }"
              >
                <template v-slot:item.actions="{ item }" class="text-center">
                  <v-btn icon class="success--text"
                    ><v-icon small @click="setEditAlumni(item)">mdi-pencil</v-icon></v-btn
                  >
                  <v-btn icon class="error--text" @click="setDeleteAlumni(item)"
                    ><v-icon small>mdi-delete-forever</v-icon></v-btn
                  >
                </template>
              </v-data-table>
              <v-dialog v-model="alumniDeleteDialog" persistent max-width="290">
                <v-card>
                  <v-card-title class="headline error--text"
                    >Delete this item?</v-card-title
                  >
                  <v-card-text
                    >Please confirm if you want to delete this
                    item.</v-card-text
                  >
                  <v-card-actions>
                    <v-spacer></v-spacer>
                    <v-btn color="grey darken-1" text @click="closeDeleteDialog"
                      >Cancel</v-btn
                    >
                    <v-btn
                      color="grey darken-3"
                      text
                      @click="deleteAlumni"
                      :loading="loadingConfirmDelete"
                      >Confirm</v-btn
                    >
                  </v-card-actions>
                </v-card>
              </v-dialog>
              <v-dialog v-model="alumniEditDialog" persistent max-width="460">
                  <v-form v-model="validEditAlumni">
            <v-card elevation="0" class="pa-5">
              <v-card-title class="overline text-h5"><v-icon class="mr-2">mdi-account-edit-outline</v-icon> Edit Alumni </v-card-title>
              <v-card-text>
                <v-text-field
                  label="Student ID"
                  type="text"
                  v-model="editedItem.student_number"
                  :success-messages="success"
                  :error-messages="error" 
                  :rules="[rules.required]"
                  dense
                  filled
                  rounded
                ></v-text-field>
                <v-text-field
                  label="First name"
                  v-model="editedItem.fname"
                  type="text"
                  :rules="[rules.required]"
                  dense
                  filled
                  rounded
                  required
                ></v-text-field>
                <v-text-field
                  label="Last name"
                  type="text"
                  :rules="[rules.required]"
                  v-model="editedItem.lname"
                  dense
                  filled
                  rounded
                ></v-text-field>
                <v-text-field
                  label="Middle name"
                  v-model="editedItem.mname"
                  type="text"
                  dense
                  filled
                  rounded
                  class="mb-0"
                ></v-text-field>
                <v-text-field
                  label="Address"
                  type="text"
                  v-model="editedItem.address"
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
                  @change="batchTypeEditListener"
                  :rules="[rules.required]"
                  filled
                  rounded
                ></v-select>

                <v-select
                  v-if="batchEditedIndex  == 1 || batchEditedIndex  == 3"
                  v-model="editedItem.h_batch_year_id"
                  :rules="[rules.required]"
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
                  v-if="batchEditedIndex  == 2 || batchEditedIndex  == 3"
                  v-model="editedItem.c_batch_year_id"
                  :rules="[rules.required]"
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
              <v-card-actions class="mt-0 pt-0">
                <v-spacer></v-spacer>
                 <v-btn 
                  @click="closeEditDialog"
                  large
                  class="white accent-4 pa-5"
                  elevation="0"
                >
                  <v-icon class="mr-2">mdi-close</v-icon>
                  Close
                </v-btn>
                <v-btn
                  :disabled="!validEditAlumni"
                  :loading="loadingEditAlumni"
                  @click="updateAlumni"
                  large
                  class="success accent-4 pa-5"
                  elevation="0"
                >
                  <v-icon class="mr-2">mdi-content-save</v-icon>
                  Save
                </v-btn>
              </v-card-actions>
            </v-card>
          </v-form>
              </v-dialog>
            </v-card>
          </v-container>
        </v-col>
      </v-row>
    </v-sheet>
  </v-app>
</template>
<script>
export default {
  data() {
    return {
      success: "",
      error: "",
      alumniDeleteDialog: false,
      loadingConfirmDelete: false,
      loadingSaveAlumni: false,
      validAlumni: true,
      alumniEditDialog: false,
      loadingConfirmEdit: false,
      loadingEditAlumni: false,
      validEditAlumni: true,
      page: 0,
      totalAlumni: 0,
      numberOfPages: 0,
      options: {},
      alumni: {},
      batchEditedIndex: 0,
      batchIndex: 0,
      batchtypes: {},
      h_years: {},
      c_years: {},
      c_year: "",
      h_year: "",
      rules: {
        required: (v) => !!v || "This Field is Required",
        min: (v) => v.length >= 8 || "Minimum 8 Characters Required",
        validEmail: (v) => /.+@.+\..+/.test(v) || "Email must be valid",
      },
      addedItem: {
        id: "",
        batch: "",
        c_year: "",
        h_year: "",
        student_number: "",
        lname: "",
        mname: "",
        fname: "",
      },
      editedItem: {
        id: "",
        batch: "",
        c_batch_year_id: "",
        h_batch_year_id: "",
        student_number: "",
        lname: "",
        mname: "",
        fname: "",
      },
      deletedItem: {
        id: "",
        batch: "",
        c_year: "",
        h_year: "",
        student_number: "",
        lname: "",
        mname: "",
        fname: "",
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
      },
      search: "",
      headers: [
        { text: "ID", value: "id" },
        {
          text: "Student Id",
          align: "start",
          sortable: false,
          value: "student_number",
        },
        { text: "Name", value: "name" },
        { text: "Address", value: "address" },
        { text: "Bacth Type", value: "batch_type" },
        { text: "Year", value: "year" },
        { text: "Action", value: "actions" },
      ],
    };
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
  computed: {
    checkStudentNumber() {
      if (this.addedItem.student_number.length != 0) {
        axios
          .post("/api/v1/studentNumber/verify", {
            student_number: this.addedItem.student_number,
          })
          .then((res) => {
            this.success = res.data.message;
            this.error = "";
          })
          .catch((err) => {
            this.success = "";
            this.error = "Student Number Already Exist";
          });
      }
      if (this.addedItem.student_number.length <= 0) {
        this.success = "";
        this.error = "";
      }
    },
  },
  created() {
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
  },
  methods: {
     closeEditDialog() {
      this.alumniEditDialog = false;
      this.editedItem = Object.assign({}, this.defaultWorkExperience);
    },
    setEditAlumni(item) {
      console.log(item);
      this.editedItem = Object.assign({}, item);
      this.batchEditedIndex = this.editedItem.batch;
      this.alumniEditDialog = true;
    },
    closeDeleteDialog() {
      this.alumniDeleteDialog = false;
      this.deletedItem = Object.assign({}, this.defaultWorkExperience);
    },
    setDeleteAlumni(item) {
      this.deletedItem = Object.assign({}, item);
      this.alumniDeleteDialog = true;
    },
    deleteAlumni() {
      this.saveDialog = true;
      this.loadingConfirmDelete = true;
      axios
        .post("api/v1/deleteAlumni", {
          alumni: this.deletedItem,
        })
        .then((res) => {
          this.deletedItem = Object.assign({}, this.defaultItem);
          this.saveDialog = false;

          this.alumniDeleteDialog = false;
          this.alumni = res.data.alumni;
          this.totalAlumni = res.data.alumni.total;
          this.numberOfPages = res.data.alumni.last_page;
          this.$toast.success("Alumni successfully deleted!", {
            toastClassName: "my-custom-toast-class",
            bodyClassName: ["custom-class-1", "custom-class-2"],
            position: "bottom-right",
            timeout: 5000,
            closeOnClick: true,
            pauseOnFocusLoss: true,
            pauseOnHover: true,
            draggable: true,
            draggablePercent: 0.61,
            showCloseButtonOnHover: false,
            hideProgressBar: true,
            closeButton: "button",
            icon: true,
            rtl: false,
          });
          this.loadingConfirmDelete = false;
        })
        .catch((error) => {
          this.loadingSaveAlumni = false;
          this.$toast.error("Alumni failed on deleting!", {
            toastClassName: "my-custom-toast-class",
            bodyClassName: ["custom-class-1", "custom-class-2"],
            position: "bottom-right",
            timeout: 5000,
            closeOnClick: true,
            pauseOnFocusLoss: true,
            pauseOnHover: true,
            draggable: true,
            draggablePercent: 0.61,
            showCloseButtonOnHover: false,
            hideProgressBar: true,
            closeButton: "button",
            icon: true,
            rtl: false,
          });
          this.loadingConfirmDelete = false;
          this.saveDialog = false;
          console.log(error);
        });
    },
    saveAlumni() {
      this.loadingSaveAlumni = true;
      axios
        .post("/api/v1/alumni", this.addedItem)
        .then((res) => {
          this.addedItem = Object.assign({}, this.defaultItem);
          this.loadingSaveAlumni = false;
          this.loading = false;
          this.alumni = res.data.alumni;
          this.totalAlumni = res.data.alumni.total;
          this.numberOfPages = res.data.alumni.last_page;
          this.$toast.success("New Alumni successfully added!", {
            toastClassName: "my-custom-toast-class",
            bodyClassName: ["custom-class-1", "custom-class-2"],
            position: "bottom-right",
            timeout: 5000,
            closeOnClick: true,
            pauseOnFocusLoss: true,
            pauseOnHover: true,
            draggable: true,
            draggablePercent: 0.61,
            showCloseButtonOnHover: false,
            hideProgressBar: true,
            closeButton: "button",
            icon: true,
            rtl: false,
          });
        })
        .catch((err) => {
          this.loadingSaveAlumni = false;
          this.$toast.error("Failed to add - Data might already exist!", {
            toastClassName: "my-custom-toast-class",
            bodyClassName: ["custom-class-1", "custom-class-2"],
            position: "bottom-right",
            timeout: 5000,
            closeOnClick: true,
            pauseOnFocusLoss: true,
            pauseOnHover: true,
            draggable: true,
            draggablePercent: 0.61,
            showCloseButtonOnHover: false,
            hideProgressBar: true,
            closeButton: "button",
            icon: true,
            rtl: false,
          });
        });
    },
    updateAlumni() {
      this.loadingEditAlumni = true;
      axios
        .post("/api/v1/updateAlumni", this.editedItem)
        .then((res) => {
           this.alumniEditDialog = false;
          this.editedItem = Object.assign({}, this.defaultItem);
         
          this.loadingEditAlumni = false;
          this.loading = false;
          this.alumni = res.data.alumni;
          this.totalAlumni = res.data.alumni.total;
          this.numberOfPages = res.data.alumni.last_page;
          this.$toast.success("Successfully updated!", {
            toastClassName: "my-custom-toast-class",
            bodyClassName: ["custom-class-1", "custom-class-2"],
            position: "bottom-right",
            timeout: 5000,
            closeOnClick: true,
            pauseOnFocusLoss: true,
            pauseOnHover: true,
            draggable: true,
            draggablePercent: 0.61,
            showCloseButtonOnHover: false,
            hideProgressBar: true,
            closeButton: "button",
            icon: true,
            rtl: false,
          });
        })
        .catch((err) => {
           this.alumniEditDialog = false;
          this.loadingEditAlumni = false;
          this.$toast.error("Error while updating data!", {
            toastClassName: "my-custom-toast-class",
            bodyClassName: ["custom-class-1", "custom-class-2"],
            position: "bottom-right",
            timeout: 5000,
            closeOnClick: true,
            pauseOnFocusLoss: true,
            pauseOnHover: true,
            draggable: true,
            draggablePercent: 0.61,
            showCloseButtonOnHover: false,
            hideProgressBar: true,
            closeButton: "button",
            icon: true,
            rtl: false,
          });
        });
    },
    searchIt(d) {
      if (d.length > 3) {
        const { page, itemsPerPage } = this.options;
        axios
          .get(`/api/v1/alumni/${d}`)
          .then((res) => {
            this.loading = false;
            this.alumni = res.data.alumni;
            this.totalAlumni = res.data.alumni.total;
            this.numberOfPages = res.data.alumni.last_page;
          })
          .catch((err) => {
            console.error(err);
          });
      }
      if (d.length <= 0) {
        axios
          .get(`/api/v1/alumni?page=${d.page}`, {
            params: { per_page: d.itemsPerPage },
          })
          .then((res) => {
            this.loading = false;
            this.alumni = res.data.alumni;
            this.totalAlumni = res.data.alumni.total;
            this.numberOfPages = res.data.alumni.last_page;
          })
          .catch((err) => {
            console.error(err);
          });
      }
    },
    readDataFromAPI() {
      this.loading = true;
      const { page, itemsPerPage } = this.options;
      let pageNumber = page;
      axios
        .get(`/api/v1/alumni?page=` + pageNumber, {
          params: { per_page: itemsPerPage },
        })
        .then((response) => {
          //Then injecting the result to datatable parameters.
          this.loading = false;
          //  this.page = response.data.students;
          this.alumni = response.data.alumni;
          this.totalAlumni = response.data.alumni.total;
          this.numberOfPages = response.data.alumni.last_page;
        });
    },
    batchTypeListener() {
      this.batchIndex = this.addedItem.batch; 
    },
    batchTypeEditListener() {
      this.batchEditedIndex = this.editedItem.batch; 
    },
    toTop() {
      this.$vuetify.goTo(0);
    },
  },
};
</script>