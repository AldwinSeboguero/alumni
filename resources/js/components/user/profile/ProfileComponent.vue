<template>
  <v-app style="padding: 0" id="inspire">
    <v-sheet>
      <v-container class="pl-0 pr-0 mt-0 pt-0">
        <v-card tile class="rounded-b-xl" elevation="0">
          <v-img
            height="300px"
            src="images/PSU.png"
            class="elevation-0 pt-3"
            gradient="to bottom left, rgba(00,00,00,.22), rgba(00,00,00,.6)"
          >
            <v-row align="end" class="fill-height" justify="center">
              <v-col cols="12" class="text-center">
                <v-avatar class="profile mt-2" color="grey" size="200" circle>
                  <expandable-image
                    :src="user.photo" v-if="user.photo != 'profile.png'"
                    class="image"
                  ></expandable-image> 
                   <v-icon class="text-h1 white--text" v-else>mdi-face-profile</v-icon>
                </v-avatar>
              </v-col>
              <v-col class="py-0">
                <v-list-item color="rgba(0, 0, 0, .4)" dark class="text-center">
                  <v-list-item-content>
                    <v-list-item-title class="title"
                      >{{ user.fname }} {{ user.lname }}</v-list-item-title
                    >
                    <v-list-item-subtitle
                      >Fullstack Developer</v-list-item-subtitle
                    >
                  </v-list-item-content>
                </v-list-item>
              </v-col>
            </v-row>
          </v-img>
        </v-card>
        <!-- <v-card class="mx-auto mb-8 rounded-lg" rounded elevation="0">
      <v-img  height="200px"
                src="images/PSU.png"
                class="elevation-0 pt-3 rounded-lg"
                gradient="to bottom left, rgba(00,00,00,.33), rgba(25,32,72,.7)"
                ></v-img>
      <v-row style="margin:2.5%;position:absolute; top: 130px" class="mx-auto" align="center">
              <v-col cols="12" >
                  <v-list-item>
                   <v-list-item-avatar size="130">
                      <img
                        src="https://www.w3schools.com/howto/img_avatar.png"
                        alt="John"
                      >
                    </v-list-item-avatar>
                    <v-list-item-content>
                      <v-list-item-title class="title" style="margin-top:20px;">{{ user.fname }} {{ user.lname }}</v-list-item-title>
                      <v-list-item-subtitle>Fullstack Developer</v-list-item-subtitle>
                    </v-list-item-content>
                  </v-list-item>
              </v-col>
                
    </v-row>
  </v-card> -->
        <v-container>
          <!-- <v-divider class="col-10 offset-1 mx-auto"></v-divider> -->
          <v-row class="mb-1 mt-0">
            <v-col cols="12" class="text-center text-md-right">
              <v-spacer></v-spacer>
              <v-btn
                class="primary mr-2"
                elevation="0"
                flat
                link
                to="/user/edit-profile"
              >
                <v-icon left dark>mdi-account-edit-outline</v-icon
                >Edit Profile</v-btn
              >
              <v-btn class="primary mr-2" elevation="0" flat>
                <v-icon left dark>mdi-file-download</v-icon>Resume</v-btn
              >
            </v-col>
          </v-row>
          <v-divider></v-divider>
          <v-tabs
            background-color="white"
            color="deep-purple accent-4"
            left
            show-arrows
          >
            <v-tab>About</v-tab>
            <v-tab>Photo</v-tab>
            <v-tab>Post</v-tab>
            <v-spacer></v-spacer>

            <v-tab-item key="1">
              <v-sheet height="100%">
                <v-container fluid>
                  <v-row height="100%">
                    <v-row>
                      <v-col cols="12" sm="8">
                        <v-sheet rounded="lg" min-height="268">
                          <!--  -->

                          <v-row class="mt-2">
                            <v-col cols="12" sm="6" style="padding-top: 0">
                              <v-card-title>Industry</v-card-title>
                              <v-divider></v-divider>
                              <v-sheet elevation="0" class="1">
                                <div>
                                  <v-chip-group
                                    active-class="primary--text"
                                    column
                                    style="padding-left: 10px"
                                  >
                                    <v-chip
                                      v-for="industry in user_industry"
                                      :key="industry"
                                      :ripple="false"
                                      outlined
                                      rounded
                                      small
                                    >
                                      {{ industry.industry.name }}
                                    </v-chip>
                                  </v-chip-group>
                                </div>
                              </v-sheet>
                            </v-col>
                            <v-col cols="12" sm="6" style="padding-top: 0">
                              <v-card-title>Skill</v-card-title>
                              <v-divider></v-divider>
                              <v-sheet>
                                <div>
                                  <v-chip-group
                                    active-class="primary--text"
                                    column
                                    style="padding-left: 10px"
                                  >
                                    <v-chip
                                      v-for="tag in tags"
                                      :key="tag"
                                      outlined
                                      rounded
                                      small
                                    >
                                      {{ tag }}
                                    </v-chip>
                                  </v-chip-group>
                                </div>
                              </v-sheet>
                            </v-col>
                          </v-row>

                          <v-row>
                            <v-col cols="12" style="padding-top: 0">
                              <v-card-title>Work Experience</v-card-title>
                              <v-divider></v-divider>
                              <v-sheet elevation="0" class="1">
                                <v-container fluid>
                                  <!-- <v-list two-line subheader>
                            <v-list-item
                              v-for="item in items2"
                              :key="item.title"
                            >
                              <v-list-item-avatar>
                                <v-icon>mdi-domain</v-icon>
                              </v-list-item-avatar>

                              <v-list-item-content>
                                <v-list-item-title
                                  v-text="item.title"
                                ></v-list-item-title>
                                <v-list-item-subtitle class="primary--text">
                                  <v-icon small color="primary"
                                    >mdi-home</v-icon
                                  >
                                  Partido State University
                                </v-list-item-subtitle>
                                <v-list-item-subtitle
                                  v-text="item.subtitle"
                                ></v-list-item-subtitle>
                              </v-list-item-content>
                            </v-list-item>
                          </v-list> -->

                                  <v-timeline>
                                    <v-slide-x-reverse-transition
                                      group
                                      hide-on-leave
                                    >
                                      <v-timeline-item
                                        v-for="(item, i) in workExperiences"
                                        :key="i"
                                        color="grey draken-4"
                                        small
                                        fill-dot
                                      >
                                        <template v-slot:icon>
                                          <v-avatar>
                                            <v-icon x-small class="white--text">
                                              mdi-briefcase
                                            </v-icon>
                                          </v-avatar>
                                        </template>
                                         <v-card class="elevation-2">
                                           <v-card-text>
                                          <template>
                                            <span
                                              :class="`title overline text-subtitle-2 font-weight-bold  mb-0 pb-0`"
                                              >{{ item.jobTitle }}</span
                                            >
                                          </template>
                                          <div>
                                            <v-list-item-subtitle class="">
                                              <h2
                                                :class="`overline  font-weight-light mb-0 pb-0 `"
                                                v-if="!item.isPresent"
                                              >
                                                {{ item.startDate }} -
                                                {{ item.endDate }}
                                              </h2>
                                              <h2
                                                :class="`overline  font-weight-light mb-0 pb-0 `"
                                                v-else
                                              >
                                                {{ item.startDate }} - Present
                                              </h2>
                                            </v-list-item-subtitle>
                                            <v-list-item-subtitle
                                              class="mb-0 pb-0"
                                              v-text="item.companyName"
                                            ></v-list-item-subtitle>
                                          </div>
                                           </v-card-text>
                                         </v-card>
                                      </v-timeline-item>
                                    </v-slide-x-reverse-transition>
                                  </v-timeline>
                                </v-container>
                              </v-sheet>
                            </v-col>
                          </v-row>
                        </v-sheet>
                      </v-col>
                      <v-col cols="12" sm="4" class="mt-5">
                        <v-sheet min-height="40vh">
                          <v-card-title style="padding-bottom: 0"
                          >Contacts</v-card-title
                          >
                          <v-divider></v-divider>

                          <v-list two-line>
                            <v-list-item v-if="userContactInformation_home">
                              <v-list-item-icon>
                                <v-icon color="indigo"> mdi-phone </v-icon>
                              </v-list-item-icon>

                              <v-list-item-content>
                                <v-list-item-title
                                  >{{userContactInformation_home}}</v-list-item-title
                                >
                                <v-list-item-subtitle
                                  >Mobile</v-list-item-subtitle
                                >
                              </v-list-item-content>
 
                            </v-list-item>

                            <v-list-item v-if="userContactInformation_work">
                              <v-list-item-action></v-list-item-action>

                              <v-list-item-content>
                                <v-list-item-title
                                  >{{userContactInformation_work}}</v-list-item-title
                                >
                                <v-list-item-subtitle
                                  >Work</v-list-item-subtitle
                                >
                              </v-list-item-content>

                             
                            </v-list-item>

                            <v-divider inset></v-divider>

                            <v-list-item v-if="email">
                              <v-list-item-icon>
                                <v-icon color="indigo"> mdi-email </v-icon>
                              </v-list-item-icon>

                              <v-list-item-content>
                                <v-list-item-title>{{
                                  email
                                }}</v-list-item-title>
                                <v-list-item-subtitle
                                  >Email</v-list-item-subtitle
                                >
                              </v-list-item-content>
                            </v-list-item>

                            <v-divider inset></v-divider>

                            <!-- <v-list-item v-if="userContactInformation_address">
                              <v-list-item-icon>
                                <v-icon color="indigo"> mdi-map-marker </v-icon>
                              </v-list-item-icon>

                              <v-list-item-content>
                                <v-list-item-title
                                  >Zone 3 Matacla, Goa</v-list-item-title
                                >
                                <v-list-item-subtitle
                                  >Camarines Sur, Philippines
                                  4422</v-list-item-subtitle
                                >
                              </v-list-item-content>
                            </v-list-item> -->
                          </v-list>
                        </v-sheet>
                      </v-col>
                    </v-row>
                  </v-row>
                </v-container>
              </v-sheet>
            </v-tab-item>
          </v-tabs>
        </v-container>
      </v-container>
    </v-sheet>
  </v-app>
</template>


<script>
export default {
  name: "app",
  props: {
    source: String,
  },
  data: () => ({
    workExperiences: [],
    user_industry: {},
    user_skill: "",
    user_contact: "",
    dialog: false,
    drawer: null,
    user: "",
    email: "",
    role: "",
    userContactInformation_work: '',
    userContactInformation_home: '',
    userContactInformation_address: '',
      
    tags: [ 
    ],
 
  }),
  computed: {
    scrollbarTheme() {
      return this.$vuetify.theme.dark ? "dark" : "light";
    },
    buttonText() {
      return !this.$vuetify.theme.dark ? "Switch to dark" : "Switch to light";
    },
  },
  methods: {
    toggleTheme() {
      this.$vuetify.theme.dark = !this.$vuetify.theme.dark;
    },
    logout() {
      axios.post("logout").then((resposnse) => {
        localStorage.removeItem("token");
        this.$router.push("/login");
      });
    },
  },
  created() {
    axios.get("/api/v1/verify").then((res) => {
      this.user = res.data.user;
      this.role = res.data.user_role.role;
      this.email = res.data.user.email;
      console.dir(res);
    });
    axios.get("/api/v1/profileInformation").then((res) => {
      //   this.user = res.data.user;
      //   this.role = res.data.role.role;
      this.userContactInformation_address = res.data.user_contact.address;
        this.userContactInformation_home = res.data.user_contact.home;
      this.userContactInformation_work = res.data.user_contact.work;
      this.workExperiences = res.data.user_work_experience.data;
      this.user_industry = res.data.user_industries;
      console.dir(res);
    });
  },
};
</script> 