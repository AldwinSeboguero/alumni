<template>
  <v-flex>
    <v-container class="elevation-0 white">
      <v-layout wrap class="elevation-0">
        <v-flex sm12 xs12 md5 lg5>
          <h2 class="overline text-lg-h5">Profile Information</h2>

          <v-subheader class="pa-0">
            Update your account's profile information and email address.
          </v-subheader>
        </v-flex>
        <v-flex sm12 xs12 md7 lg7>
          <v-card class="" elevation="2" max-width="">
            <v-card-title class="text-center">
              <v-row justify="center" align="center" class="mt-3 mb-1">
                <h2 class="subtitle-1">Profile Picture</h2>
              </v-row>
            </v-card-title>
            <v-card-text>
              <v-row justify="center" align="center" class="mb-3">
                <v-badge
                  avatar
                  bordered
                  overlap
                  bottom
                  icon="mdi-camera"
                  @click="dialog = true"
                >
                  <v-avatar
                    size="80"
                    class="grey darken-2"
                    @click="dialog = true"
                  >
                    <v-img
                      :src="form.image ? form.image : editedItem.image"
                    ></v-img>
                  </v-avatar>
                </v-badge>
              </v-row>
              <v-form>
                <v-dialog v-model="dialog" max-width="400px">
                  <v-card tile>
                    <v-card-title>Upload Image</v-card-title>

                    <v-card-text style="min-height: 260px" class="pb-0">
                      <v-row justify="center" class="mt-1 ml-4 pb-3">
                        <v-image-input
                          v-model="form.image"
                          clearable
                          :image-quality="1.0"
                          image-format="jpeg"
                          image-height="200"
                          image-width="200"
                          imageMinScaling="contain"
                        >
                        </v-image-input>
                      </v-row>
                    </v-card-text>
                    <v-card-action> </v-card-action>
                  </v-card>
                  <v-bottom-navigation v-model="value" class="elevation-0">
                    <v-btn
                      value="recent"
                      class="col-6 primary--text"
                      @click="dialog = false"
                    >
                      <span class="error--text">Close</span>

                      <v-icon class="error--text">mdi-close</v-icon>
                    </v-btn>

                    <v-btn value="favorites" class="col-6"   @click="dialog = false">
                      <span class="primary--text">Ok</span>

                      <v-icon class="primary--text">mdi-content-save</v-icon>
                    </v-btn>
                  </v-bottom-navigation>
                </v-dialog>
                <v-text-field
                  label="First name"
                  type="text"
                  dense
                  filled
                  rounded
                  v-model="editedItem.fname"
                  :rules="[rules.required]"
                  required
                  @input="$v.fname.$touch()"
                  @blur="$v.fname.$touch()"
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
                  label="Last name"
                  v-model="editedItem.lname"
                  type="text"
                  :rules="[rules.required]"
                  dense
                  filled
                  rounded
                ></v-text-field>
                <v-text-field
                  label="Email"
                  v-model="editedItem.email"
                  type="email"
                  :rules="[rules.required]"
                  dense
                  filled
                  rounded
                ></v-text-field>
              </v-form>
            </v-card-text>
            <v-divider></v-divider>
            <v-card-actions>
              <v-spacer></v-spacer>
              <v-btn
                rounded
                :loading="saveProfileInformationDialog"
                class="elevation-0 mb-2 mr-2"
                dark
                color=""
                @click="showSaveImage"
              >
                Save</v-btn
              >
            </v-card-actions>
          </v-card>

          <v-dialog
            v-model="saveProfileInformationDialog"
            hide-overlay
            persistent
            width="300"
          >
            <v-card color="default" dark>
              <v-card-text>
                Saving ...
                <v-progress-linear
                  indeterminate
                  color="white"
                  class="mb-0"
                ></v-progress-linear>
              </v-card-text>
            </v-card>
          </v-dialog>
        </v-flex>
      </v-layout>

      <!-- work information -->
      <v-divider class="mt-5 mb-5"></v-divider>
      <v-layout wrap class="elevation-0">
        <v-flex sm12 xs12 md5 lg5>
          <h2 class="overline text-lg-h5">Work Information</h2>

          <v-subheader class="pa-0">
            Update your work information industry and skills.
          </v-subheader>
        </v-flex>
        <v-flex sm12 xs12 md7 lg7>
          <v-card class="" elevation="2" max-width="">
            <v-card-title class="text-center"> </v-card-title>
            <v-card-text>
              <v-form>
                <h2 class="overline">Industry</h2>

                <v-autocomplete
                  v-model="user_industry"
                  :disabled="isUpdating"
                  :items="industry"
                  key="id"
                  value="name"
                  filled
                  chips
                  small-chips
                  color="blue-grey lighten-2"
                  label="Select Industry"
                  item-text="name"
                  item-value="name"
                  multiple
                  rounded
                  class="pt-0"
                >
                  <template v-slot:selection="data">
                    <v-chip
                      v-bind="data.attrs"
                      :input-value="data.selected"
                      close
                      @click="data.select"
                      @click:close="remove(data.item)"
                    >
                      {{ data.item.name }}
                    </v-chip>
                  </template>
                  <template v-slot:item="data">
                    <template v-if="typeof data.item !== 'object'">
                      <v-list-item-content
                        v-text="data.item"
                      ></v-list-item-content>
                    </template>
                    <template v-else>
                      <v-list-item-content>
                        <v-list-item-title
                          v-html="data.item.name"
                        ></v-list-item-title>
                        <v-list-item-subtitle
                          v-html="data.item.group"
                        ></v-list-item-subtitle>
                      </v-list-item-content>
                    </template>
                  </template>
                </v-autocomplete>
                <h2 class="overline">Skills</h2>
                <v-autocomplete
                  v-model="friends"
                  :disabled="isUpdating"
                  :items="industry"
                  filled
                  chips
                  small-chips
                  color="blue-grey lighten-2"
                  label="Select Skill"
                  item-text="name"
                  item-value="name"
                  multiple
                  rounded
                  class="pt-0"
                >
                  <template v-slot:selection="data">
                    <v-chip
                      v-bind="data.attrs"
                      :input-value="data.selected"
                      close
                      @click="data.select"
                      @click:close="remove(data.item)"
                    >
                      {{ data.item.name }}
                    </v-chip>
                  </template>
                  <template v-slot:item="data">
                    <template v-if="typeof data.item !== 'object'">
                      <v-list-item-content
                        v-text="data.item"
                      ></v-list-item-content>
                    </template>
                    <template v-else>
                      <v-list-item-content>
                        <v-list-item-title
                          v-html="data.item.name"
                        ></v-list-item-title>
                        <v-list-item-subtitle
                          v-html="data.item.group"
                        ></v-list-item-subtitle>
                      </v-list-item-content>
                    </template>
                  </template>
                </v-autocomplete>
              </v-form>
            </v-card-text>
            <v-divider></v-divider>
            <v-card-actions>
              <v-spacer></v-spacer>
              <v-btn rounded class="elevation-0 mb-2 mr-2" dark color="">
                Save</v-btn
              >
            </v-card-actions>
          </v-card>
        </v-flex>
      </v-layout>

      <!-- work contacts -->
      <v-divider class="mt-5 mb-5"></v-divider>
      <v-layout wrap class="elevation-0">
        <v-flex sm12 xs12 md5 lg5>
          <h2 class="overline text-lg-h5">Contact Information</h2>

          <v-subheader class="pa-0">
            Update your contact information and address.
          </v-subheader>
        </v-flex>
        <v-flex sm12 xs12 md7 lg7>
          <v-card class="" elevation="2" max-width="">
            <v-card-title class="text-center"> </v-card-title>
            <v-form>
            <v-card-text>
          
                <h2 class="overline">Work</h2>
                <v-text-field
                  label="Mobile No."
                  type="text"
                  dense
                  filled
                  rounded
                  v-model="userContactInformation_work" 
                  @input="$v.fname.$touch()"
                  @blur="$v.fname.$touch()"
                ></v-text-field>
                <h2 class="overline">Home</h2>
                <v-text-field
                  label="Mobile No."
                  type="text"
                  dense
                  filled
                  rounded
                  v-model="userContactInformation_home" 
                  @input="$v.fname.$touch()"
                  @blur="$v.fname.$touch()"
                ></v-text-field>
             
            </v-card-text>
            <v-divider></v-divider>
            <v-card-actions>
              <v-spacer></v-spacer>

              <v-btn
                rounded
                d-inline-block
                class="elevation-0 mb-2 mr-2"
                dark
                color=""
                @click="saveContactInformation"
              >
                Save</v-btn
              >
            </v-card-actions>
             </v-form>
          </v-card>
        </v-flex>
      </v-layout>

      <!-- work Experience -->
      <v-divider class="mt-5 mb-5"></v-divider>
      <v-layout wrap class="elevation-0">
        <v-flex sm12 xs12 md5 lg5>
          <h2 class="overline text-lg-h5">Work Experience</h2>

          <v-subheader class="pa-0">
            Update your work experiences.
          </v-subheader>
        </v-flex>
        <v-flex sm12 xs12 md7 lg7>
        
          <v-card class="" elevation="2" max-width="">
            <v-card-title class="text-center"> </v-card-title>
            <v-card-text>
              <v-form>
                <h2 class="overline">
                  <span> Experience</span>
                  <span class="col-12 offset-lg3">
                    <v-btn
                      x-small
                      fab
                      class="primary elevation-0"
                      dark
                      @click.stop="workExperienceAddDialog = true"
                    >
                      <v-icon>mdi-plus</v-icon>
                    </v-btn>
                  </span>
                </h2>
                <v-list>
                  <v-list-item
                    v-for="item in workExperiences"
                    :key="item.jobTitle"
                    three-line="true"
                  >
                    <v-list-item-avatar>
                      <v-icon
                        class="grey darken-4 white--text"
                        
                      >mdi-briefcase</v-icon>
                    </v-list-item-avatar>

                    <v-list-item-content>
                      <v-list-item-title
                        v-text="item.jobTitle"
                      ></v-list-item-title>
                      <v-list-item-subtitle
                        v-text="item.companyName"
                      ></v-list-item-subtitle>
                      <v-list-item-subtitle
                        v-if="!item.isPresent"
                      >{{item.startDate}} - {{item.endDate}}</v-list-item-subtitle>
                      <v-list-item-subtitle
                        v-else
                      >{{item.startDate}} - Present</v-list-item-subtitle>
                    </v-list-item-content>

                    <v-list-item-action>
                      <span>
                        <v-btn icon>
                          <v-icon color="grey lighten-1" @click="setEditWorkExperience(item)">mdi-pencil</v-icon>
                        </v-btn>
                        <v-btn icon>
                          <v-icon color="grey lighten-1" @click="setDeleteWorkExperience(item)">mdi-delete</v-icon>
                        </v-btn>
                      </span>
                    </v-list-item-action>
                  </v-list-item>
                </v-list>
                <v-dialog
                  v-model="workExperienceAddDialog"
                  
                  max-width="400px"
                >
                  <v-card>
                    <v-card-title class="overline"
                      >Add Work Experience</v-card-title
                    > 
                    <v-form v-model="validExperience">
                    <v-card-text style="height: 360px">
                    
                        <v-text-field
                          label="Job Title"
                          type="text"
                          dense
                          filled
                          rounded
                          v-model="workExperience.jobTitle"
                          :rules="[rules.required]"
                          required
                          @input="$v.fname.$touch()"
                          @blur="$v.fname.$touch()"
                        ></v-text-field>

                        <v-text-field
                         
                          label="Start Date"
                          type="date"
                          dense
                          filled
                          rounded
                          v-model="workExperience.startDate"
                          :rules="[rules.required]"
                          required
                          @input="$v.fname.$touch()"
                          @blur="$v.fname.$touch()"
                        ></v-text-field>
                        <v-checkbox
                        class="mt-0 pt-0 text-subtitle-2"
                        dense
                          v-model="workExperience.isPresent" 
                          label="Current Job?" 
                          @click="workExperience.isPresent ? jobCheckbox=true : jobCheckbox=false"
                          @change="$v.checkbox.$touch()"
                          @blur="$v.checkbox.$touch()"
                        ></v-checkbox>
                        <v-text-field
                          label="End Date"
                          type="date"
                          dense
                          filled
                          rounded
                          v-model="workExperience.endDate" 
                          required
                          :disabled="jobCheckbox"
                          @input="$v.fname.$touch()"
                          @blur="$v.fname.$touch()"
                        ></v-text-field>
                        <v-text-field
                          label="Company"
                          type="text"
                          dense
                          filled
                          rounded
                          v-model="workExperience.companyName"
                          :rules="[rules.required]"
                          required
                          @input="$v.fname.$touch()"
                          @blur="$v.fname.$touch()"
                        ></v-text-field>
                      
                    </v-card-text> 
                    <v-card-actions>
                   <v-spacer></v-spacer>
                        <v-btn
                        color="blue darken-1"
                        text
                        @click="workExperienceAddDialog = false"
                        >Close</v-btn
                      >
                      <v-btn
                        color="blue darken-1"
                        text
                        @click="saveWorkExperience"
                        :disabled="!validExperience"
                        :loading="loadingSubmitExperience"
                        type="submit"
                        >Save</v-btn
                      > 
                     
                    </v-card-actions>
                    </v-form>
                  </v-card>
                </v-dialog>
                <v-dialog
                  v-model="workExperienceUpdateDialog"
                  
                  max-width="400px"
                >
                  <v-card>
                    <v-card-title class="overline"
                      >Update Work Experience</v-card-title
                    > 
                    <v-form v-model="validExperience">
                    <v-card-text style="height: 360px">
                    
                        <v-text-field
                          label="Job Title"
                          type="text"
                          dense
                          filled
                          rounded
                          v-model="workExperience.jobTitle"
                          :rules="[rules.required]"
                          required
                          @input="$v.fname.$touch()"
                          @blur="$v.fname.$touch()"
                        ></v-text-field>

                        <v-text-field
                         
                          label="Start Date"
                          type="date"
                          dense
                          filled
                          rounded
                          v-model="workExperience.sDate"
                          :rules="[rules.required]"
                          required
                          @input="$v.fname.$touch()"
                          @blur="$v.fname.$touch()"
                        ></v-text-field>
                        <v-checkbox
                        class="mt-0 pt-0 text-subtitle-2"
                        dense
                          v-model="workExperience.isPresent" 
                          label="Current Job?" 
                          @click="workExperience.isPresent ? jobCheckbox=true : jobCheckbox=false"
                          @change="$v.checkbox.$touch()"
                          @blur="$v.checkbox.$touch()"
                        ></v-checkbox>
                        <v-text-field
                          label="End Date"
                          type="date"
                          dense
                          filled
                          rounded
                          v-model="workExperience.eDate" 
                          required
                          :disabled="workExperience.isPresent"
                          @input="$v.fname.$touch()"
                          @blur="$v.fname.$touch()"
                        ></v-text-field>
                        <v-text-field
                          label="Company"
                          type="text"
                          dense
                          filled
                          rounded
                          v-model="workExperience.companyName"
                          :rules="[rules.required]"
                          required
                          @input="$v.fname.$touch()"
                          @blur="$v.fname.$touch()"
                        ></v-text-field>
                      
                    </v-card-text> 
                    <v-card-actions>
                   <v-spacer></v-spacer>
                        <v-btn
                        color="blue darken-1"
                        text
                        @click="closeWorkExperienceUpdateDialog"
                        >Close</v-btn
                      >
                      <v-btn
                        color="blue darken-1"
                        text
                        @click="updateWorkExperience"
                        :disabled="!validExperience"
                        :loading="loadingSubmitExperience"
                        type="submit"
                        >Save</v-btn
                      > 
                     
                    </v-card-actions>
                    </v-form>
                  </v-card>
                </v-dialog>
                <v-dialog v-model="workExperienceDeleteDialog" persistent max-width="290"> 
                <v-card>
                  <v-card-title class="headline error--text">Delete this item?</v-card-title>
                  <v-card-text>Please confirm if you want to delete this item.</v-card-text>
                  <v-card-actions>
                    <v-spacer></v-spacer>
                    <v-btn color="grey darken-1" text
                      @click="closeWorkExperienceDeleteDialog">Cancel</v-btn>
                    <v-btn color="grey darken-3" text  @click="deleteWorkExperience" 
                        :loading="loadingSubmitExperience">Confirm</v-btn>
                  </v-card-actions>
                </v-card>
              </v-dialog>
              </v-form>
            </v-card-text>
            <v-card-actions> </v-card-actions>
          </v-card>
        </v-flex>
      </v-layout>
    </v-container>
  </v-flex>
</template>


<script>
import { VueEditor, Quill } from "vue2-editor";
import { ImageDrop } from "quill-image-drop-module";
import ImageResize from "quill-image-resize-module";

Quill.register("modules/imageDrop", ImageDrop);
Quill.register("modules/imageResize", ImageResize);
export default {
  components: {
    VueEditor,
  },
  name: "app",
  props: {
    source: String,
  },

  data: () => ({
    items2: [
      {
        icon: "mdi-briefcase",
        iconClass: "blue white--text",
        title: "Fullstack Developer",
        subtitle: "Jan 20, 2014 - Present",
        location: "Partido State University",
      },
      {
        icon: "mdi-briefcase",
        iconClass: "amber white--text",
        title: "Backend Developer",
        subtitle: "Jan 20, 2014 - Present",
        location: "Partido State University",
      },
    ],
    validExperiecnce: false,
    loadingSubmitExperience: false,
    jobCheckbox: false, 
    workExperienceAddDialog: false,
    workExperienceUpdateDialog: false,
    workExperienceDeleteDialog: false,
    saveProfileInformationDialog: false,
    value: "",
    industries: [],
    user_industry: {},
    user_skill: "",
    user_contact: "",
    dialog: false,
    htmlForEditor: "",
    rules: {
      required: (v) => !!v || "This Field is Required",
      min: (v) => v.length >= 8 || "Minimum 8 Characters Required",
      validEmail: (v) => /.+@.+\..+/.test(v) || "Email must be valid",
    },
    industry: [{ name: "Government" }, { name: "Private" }],
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
      bday: "",
      confirmPassword: "",
      created_at: "",
      image: "",
    },
    workExperience: {
      jobTitle: '',
      startDate:'',
      endDate:'',
      companyName: '',
      isPresent:'',
    },
    userContactInformation_work: '',
    userContactInformation_home: '',
    
     defaultWorkExperience: {
      jobTitle: '',
      startDate:'',
      endDate:'',
      companyName: '',
      isPresent:'',
    },
    workExperiences:[],
    customToolbar: [
      ["bold", "italic", "underline"],
      [{ list: "ordered" }, { list: "bullet" }],
      ["image", "code-block"],
    ],
    editorSettings: {
      modules: {
        imageDrop: true,
        imageResize: {},
      },
    },
    post: {},
    form: {
      title: "",
      body: "",
      image: "",
    },
  }),
  watch: {
    isUpdating(val) {
      if (val) {
        setTimeout(() => (this.isUpdating = false), 3000);
      }
    },
  },
  methods: {
    //contact information methods
    saveContactInformation(){
      this.saveProfileInformationDialog = true;
      this.loadingSubmitContactInformation = true; 
      axios.post("api/v1/saveContactInformation",{
        contact_home: this.userContactInformation_home,
        contact_work: this.userContactInformation_work,})
        .then((result) => { 
           this.saveProfileInformationDialog = false;
 
          this.userContactInformation = result.data.user_contact;
          this.$toast.success("Contact Information successfully updated!", {
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
           this.loadingSubmitExperience = false; 
          console.log(result);
        })
        .catch((error) => {
           this.loadingSubmitExperience = false; 
           this.saveProfileInformationDialog = false;
          console.log(error);
        });
    },

    // work Experience 
    closeWorkExperienceUpdateDialog(){
      this.workExperienceUpdateDialog = false;
      this.workExperience = Object.assign({}, this.defaultWorkExperience);
    },
     closeWorkExperienceDeleteDialog(){
      this.workExperienceDeleteDialog = false;
      this.workExperience = Object.assign({}, this.defaultWorkExperience);
    },
    setDeleteWorkExperience(item){ 
          this.workExperience = Object.assign({}, item); 
          this.workExperienceDeleteDialog = true;
    },
    setEditWorkExperience(item){ 
          this.workExperience = Object.assign({}, item);
          console.log(this.workExperience);
          this.workExperienceUpdateDialog = true;
    },
    deleteWorkExperience(){
      this.saveProfileInformationDialog = true;
      this.loadingSubmitExperience = true; 
      axios.post("api/v1/deleteWorkExperience",{
        experience: this.workExperience,})
        .then((result) => {
          this.workExperience = Object.assign({}, this.defaultWorkExperience);
           this.saveProfileInformationDialog = false;

          this.workExperienceDeleteDialog = false;
          this.workExperiences = result.data.user_work_experience.data;
          this.$toast.success("Work Experience successfully deleted!", {
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
           this.loadingSubmitExperience = false; 
          console.log(result);
        })
        .catch((error) => {
           this.loadingSubmitExperience = false; 
           this.saveProfileInformationDialog = false;
          console.log(error);
        });
    },
    updateWorkExperience(){
      this.saveProfileInformationDialog = true;
      this.loadingSubmitExperience = true; 
      axios.post("api/v1/updateWorkExperience",{
        experience: this.workExperience,})
        .then((result) => {
          this.workExperience = Object.assign({}, this.defaultWorkExperience);
           this.saveProfileInformationDialog = false;
this.workExperienceUpdateDialog = false;
          this.workExperiences = result.data.user_work_experience.data;
          this.$toast.success("Work Experience successfully updated!", {
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
           this.loadingSubmitExperience = false; 
          console.log(result);
        })
        .catch((error) => {
           this.loadingSubmitExperience = false; 
           this.saveProfileInformationDialog = false;
          console.log(error);
        });
    },
    saveWorkExperience(){
      this.saveProfileInformationDialog = true;
      this.loadingSubmitExperience = true; 
      axios.post("api/v1/saveWorkExperience",{
        experience: this.workExperience,})
        .then((result) => {
          this.workExperience = Object.assign({}, this.defaultWorkExperience);
           this.saveProfileInformationDialog = false;

          this.workExperienceAddDialog = false;
          this.workExperiences = result.data.user_work_experience.data;
          this.$toast.success("Work Experience successfully added!", {
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
           this.loadingSubmitExperience = false; 
          console.log(result);
        })
        .catch((error) => {
           this.loadingSubmitExperience = false; 
           this.saveProfileInformationDialog = false;
          console.log(error);
        });
    },
    showSaveImage() {
      this.saveProfileInformationDialog = true;
      console.log(this.form.image);

      axios
        .post("api/v1/post/upload", {
          image: this.form.image,
          user: this.editedItem,
        })
        .then((result) => {
          this.saveProfileInformationDialog = false;
          this.$toast.success("Profile successfully updated!", {
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
          this.saveProfileInformationDialog = false;
          console.log(err);
        });
    },
    remove(item) {
      const index = this.industry.indexOf(item.name);
      if (index >= 0) this.industry.splice(index, 1);
    },
    

    handleImageAdded: function (file, Editor, cursorLocation, resetUploader) {
      var formData = new FormData();
      formData.append("image", file);

      axios({
        url: "api/v1/post/upload",
        method: "POST",
        data: formData,
      })
        .then((result) => {
          let url = result.data.url;
          // Get url from response
          Editor.insertEmbed(cursorLocation, "image", url);
          resetUploader();
          console.log(this.htmlForEditor);
        })
        .catch((err) => {
          console.log(err);
        });
    },
  },
  created() {
    axios.get("/api/v1/verify").then((res) => {
      this.editedItem = res.data.user;
      this.editedItem.image = res.data.user.photo;
      console.log(res.data.status);
    });
    axios.get("/api/v1/profileInformation").then((res) => {
      this.industries = res.data.all_industry;
      this.user_industry = res.data.user_industries;
      this.userContactInformation_home = res.data.user_contact.home;
      this.userContactInformation_work = res.data.user_contact.work;
       this.workExperiences = res.data.user_work_experience.data;
      console.dir(res);
    });
  },
};
</script> 