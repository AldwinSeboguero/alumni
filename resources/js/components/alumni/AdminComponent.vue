<template>
  <v-app id="inspire">
       <v-navigation-drawer
      v-model="drawer"
      :clipped="$vuetify.breakpoint.lgAndUp"
      app
    >
      <template v-slot:prepend>
        <v-list-item two-line>
          <v-list-item-avatar>
            <img :src='user.photo' />
          </v-list-item-avatar>

          <v-list-item-content>
            <v-list-item-title> {{user.fname}} {{user.lname}}</v-list-item-title>
            <v-list-item-subtitle>{{user.email}}</v-list-item-subtitle>
          </v-list-item-content>
        </v-list-item>
      </template>

      <v-divider></v-divider>
  <div  v-slimscroll="scrollOptions">
      <v-list dense>
        <template v-for="item in items">
          <v-row v-if="item.heading" :key="item.heading" align="center">
            <v-col cols="6">
              <v-subheader v-if="item.heading">
                {{ item.heading }}
              </v-subheader>
            </v-col>
            <v-col cols="6" class="text-center">
              <a href="#!" class="body-2 black--text">EDIT</a>
            </v-col>
          </v-row>
          <v-list-group
            v-else-if="item.children"
            :key="item.text"
            v-model="item.model"
            :prepend-icon="item.model ? item.icon : item['icon-alt']"
            append-icon=""
          >
            <template v-slot:activator>
              <v-list-item-content>
                <v-list-item-title>
                  {{ item.text }}
                </v-list-item-title>
              </v-list-item-content>
            </template>
            <v-list-item
              v-for="(child, i) in item.children"
              :key="i"
              :to="child.link"
              link
            >
              <v-list-item-action v-if="child.icon">
                <v-icon>{{ child.icon }}</v-icon>
              </v-list-item-action>
              <v-list-item-content 
              style="padding-left: 20px">
                <v-list-item-title>
                  {{ child.text }}
                </v-list-item-title>
              </v-list-item-content>
            </v-list-item>
          </v-list-group>
          <v-list-item v-else :key="item.text" :to="item.link" link>
            <v-list-item-action>
              <v-icon>{{ item.icon }}</v-icon>
            </v-list-item-action>
            <v-list-item-content>
              <v-list-item-title>
                {{ item.text }}
              </v-list-item-title>
            </v-list-item-content>
          </v-list-item>
        </template>
        <v-list-item @click="logout">
            <v-list-item-action>
              <v-icon>mdi-logout-variant</v-icon>
            </v-list-item-action>
            <v-list-item-content>
              <v-list-item-title>
                Logout
              </v-list-item-title>
            </v-list-item-content>
          </v-list-item>
      </v-list>
  </div>
    </v-navigation-drawer>
    
    <v-app-bar
      :clipped-left="$vuetify.breakpoint.lgAndUp"
      app
      color="green darken-3"
      dark
      flat
      src="https://cdn.vuetifyjs.com/images/backgrounds/bg-2.jpg"
      fixed
      class="elevation-1"
    >
      <v-app-bar-nav-icon
        @click.stop="drawer = !drawer"
        class="hidden-md-and-up"
      ></v-app-bar-nav-icon>
      <v-toolbar-title style="width: 300px" class="ml-0 pl-4">
        <span>ParSU Alumni</span>
      </v-toolbar-title>
      <v-text-field
        flat
        solo-inverted
        hide-details
        prepend-inner-icon="mdi-magnify"
        label="Search"
        class="hidden-sm-and-down"
      ></v-text-field>
      <v-spacer></v-spacer>
      <!-- <v-btn icon>
        <v-icon>mdi-email</v-icon>
      </v-btn>
      <v-btn icon>
        <v-icon>mdi-bell</v-icon>
      </v-btn> -->
      <v-btn icon large>
        <v-avatar size="32px" item>
          <v-img
            src="images/psu_logo.png"
            alt="Vuetify"
          ></v-img
        ></v-avatar>
      </v-btn>
      <template v-slot:extension class="hidden-sm-and-down" v-if="user.status">
        <v-tabs
          centered
          class="ml-n9 hidden-md-and-down"
          color="grey darken-1"
          background-color="white" 
        >
        <v-tabs-slider color="light-blue"></v-tabs-slider>
          <v-tab v-for="link in links" :key="link.text" :to="link.link" class="grey--text" >
           {{ link.text }}
          </v-tab>
        </v-tabs>
      </template>
    </v-app-bar>

    <v-main v-if="user.status">
      <router-view></router-view>

      <v-footer dark padless class="hidden-sm-and-down">
        <v-card
          flat
          tile
          width="100%"
          class="white lighten-1 black--text text-center"
        >
          <v-card-text>
            <v-btn class="mx-4 black--text" icon>
              <v-icon size="24px"> mdi-web </v-icon>
            </v-btn>
            <v-btn class="mx-4 black--text" icon>
              <v-icon size="24px"> mdi-facebook </v-icon>
            </v-btn>
            <v-btn class="mx-4 black--text" icon>
              <v-icon size="24px"> mdi-twitter </v-icon>
            </v-btn>
            <v-btn class="mx-4 black--text" icon>
              <v-icon size="24px"> mdi-youtube </v-icon>
            </v-btn>
          </v-card-text>

          <v-card-text class="black--text pt-0"> </v-card-text>

          <v-card-text class="black--text">
            {{ new Date().getFullYear() }} &copy;
            <strong>ICTMO, Partido State University</strong>
          </v-card-text>
        </v-card>
      </v-footer>
    </v-main>
    <v-main v-else>
      <v-container>
      <v-row dense>
        <v-col cols="12">
          <v-card
            color="#385F73"
            dark
          >
            <v-card-title class="headline">
              <v-icon
                large
                left
              >
              mdi-information
            </v-icon> 
              Pending for Approval
            </v-card-title>

            <v-card-subtitle>Please wait for the approval of your account. Thank you!</v-card-subtitle>

            <v-card-actions>
              <v-btn text>
               
              </v-btn>
            </v-card-actions>
          </v-card>
        </v-col>
      </v-row>
      </v-container>
    </v-main>
    <v-bottom-navigation
    v-model="bottomNav"
   success 
    shift
    fixed
    class=" d-xm-flex d-sm-flex d-md-none"
  > 
     
    <v-btn>
      <span>Profile</span>
      <v-icon>mdi-face-profile</v-icon>
    </v-btn>
<v-btn>
      <span>Newsfeed</span>
      <v-icon>mdi-post</v-icon>
    </v-btn>
    <v-btn>
      <span>People</span>
      <v-icon>mdi-account-group</v-icon>
    </v-btn>
 <v-btn>
      <span>Events</span>
      <v-icon>mdi-calendar</v-icon>
    </v-btn>
    <v-btn>
      <span>Entreprenuership</span>
      <v-icon>mdi-shopping</v-icon>
    </v-btn>
   

    <v-btn>
      <span>Help Needed</span>
      <v-icon>mdi-account-question</v-icon>
    </v-btn>
  </v-bottom-navigation>
  </v-app>
</template>

<script>
export default {
  name: "main-app",
  props: {
    source: String,
  },
  
  data: () => ({
    bottomNav: 0,
    dialog: false,
    drawer: null,
    user: '',
    role: '',
     scrollOptions:{
                    height:'100%',  
                },
    links: [ 
      {
        text: "Live Feed",
        link: "newsfeed"
      },
       {
        text:  "People",
        link: "people"
      },
       {
        text:   "Event",
        link: "event"
      },
       {
        text: "Career",
        link: "career"
      },
       {
        text: "Entrepreneurship",
        link: "newsfeed"
      },
       {
        text: "Help Needed",
        link: "help"
      }, 
    ],
    dialog: false,
    drawer: false,
    items: [
      {
        icon: "mdi-face-profile",
        text: "Profile",
        link: "/user/profile",
      },
      {
        icon: "mdi-post",
        text: "Live Feed",
        link: "/admin/newsfeed",
      },
      {
        icon: "mdi-account-group",
        text: "People",
        link: "/admin/people",
      },
      
      {
        icon: "mdi-calendar",
        text: "Event",
        link: "/admin/event",
      },
      {
        icon: "mdi-briefcase",
        text: "Career",
        link: "/admin/career",
      },
      {
        icon: "mdi-shopping",
        text: "Entrepreneurship",
        link: "/admin/entreprenuership",
      },
       {
        icon: "mdi-account-question",
        text: "Help Needed",
        link: "/admin/help",
      },
      
      
      
      { icon: "mdi-cog", text: "Settings", link: "/admin/settings" }, 
    ],
  }),
  watch: {
    dialog(val) {
      val || this.close();
    },
  },
  // created() {
  //   this.initialize();
  // },
computed: { 
  
      color () {
        switch (this.bottomNav) {
          case 0: return 'blue-grey'
          case 1: return 'teal'
          case 2: return 'brown'
          case 3: return 'indigo'
        }
      }, 
    loggedIn:{
      get(){
        return this.$store.state.currentUser.loggedIn;
      }
    },
    currentUser:{
      get(){
        return this.$store.state.currentUser.user;
      }
    }
  },
  methods: {
        logout(){
          axios.post('logout')
          .then(resposnse => {
             localStorage.removeItem('token');
             this.$router.push("/login");
          });
    }
  },
  created(){
        axios.interceptors.response.use(
      (response) => response,
      (error) => {
        if (error.response.status !== 419) return Promise.reject(error)
        window.location.reload()
      }
    )
    axios.defaults.headers['Authorization'] = "Bearer " + localStorage.getItem("token");
    this.$store.dispatch('currentUser/getUser');
          axios.get('/api/v1/getUser')
      .then(res => {
        this.user = res.data.user
        this.role = res.data.role.role
        console.dir(res)
      })
 
  }, 


};
</script>