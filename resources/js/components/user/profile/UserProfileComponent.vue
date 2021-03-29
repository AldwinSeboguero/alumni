<template>
  <v-app id="inspire">
      <v-app-bar
        :clipped-left="$vuetify.breakpoint.lgAndUp"
        :clipped-right="$vuetify.breakpoint.lgAndUp"
        app
        elevation="0"
        dark
        color="#1e1e1e" 
        dense
      >
        <v-app-bar-nav-icon
          @click.stop="drawer = !drawer"
          class="hidden-sm-and-up"
        ></v-app-bar-nav-icon>
        <v-btn icon large link to="/user/newsfeed">
          <v-avatar size="32px" item>
            <v-img src="images/psu_logo.png" alt="Vuetify"></v-img
          ></v-avatar>
        </v-btn>
        <!-- <v-toolbar-title  class="ml-0 mr-4 pl-4">
          <span class="hidden-sm-and-down">ParSU ALumni</span>
        </v-toolbar-title> -->
        <v-text-field
          flat
          solo-inverted
          hide-details
          append-icon="mdi-magnify"
          label="Search"
          class="shrink mx-4"
          rounded
          dense
        ></v-text-field>
        <v-spacer></v-spacer>
        <v-btn  text  rounded class="overline hidden-sm-and-down" to="/user/profile" link>
          <v-avatar size="32px" item class="mr-2">
             <img :src="user.photo" v-if="user.photo != 'profile.png'">
                   <v-icon v-else>mdi-face-profile</v-icon>
            </v-avatar>
          <span>{{ user.fname }}</span> 
        </v-btn>
        <v-btn icon class="hidden-sm-and-down">
          <v-avatar size="36px" item color="grey darken-3">
            <v-icon small>mdi-plus</v-icon>
          </v-avatar>
        </v-btn>
        <v-btn icon>
          <v-avatar size="36px" item color="grey darken-3">
            <v-icon small>mdi-email</v-icon>
          </v-avatar>
        </v-btn>
        <v-btn icon>
          <v-avatar size="36px" item color="grey darken-3">
            <v-icon small>mdi-bell</v-icon>
          </v-avatar>
        </v-btn>
        <v-btn icon>
          <v-avatar size="36px" item color="grey darken-3">
            <v-icon small>mdi-arrow-down-drop-circle</v-icon>
          </v-avatar>
        </v-btn> 
      </v-app-bar>
    
      <v-main> 
        <router-view></router-view>
        <v-sheet class="grey darken-4" height="10%"> </v-sheet>
      </v-main>
    
  </v-app>
</template>

<script>
export default {
  name: "app",
  props: {
    source: String,
  },
  data: () => ({
    dialog: false,
    drawer: null,
    user: "",
    names: [
      {
        icon: true,
        title: "Jason Oner",
        avatar: "https://cdn.vuetifyjs.com/images/lists/1.jpg",
      },
      {
        title: "Travis Howard",
        avatar: "https://cdn.vuetifyjs.com/images/lists/2.jpg",
      },
      {
        title: "Ali Connors",
        avatar: "https://cdn.vuetifyjs.com/images/lists/3.jpg",
      },
      {
        title: "Cindy Baker",
        avatar: "https://cdn.vuetifyjs.com/images/lists/4.jpg",
      },
      {
        title: "Cindy Baker",
        avatar: "https://cdn.vuetifyjs.com/images/lists/4.jpg",
      },
    ],
    items: [
      { icon: "mdi-newspaper", text: "News Feed", link: "/user/newsfeed" },
      { icon: "mdi-account-multiple", text: "People", link: "/user/people" },
      { icon: "mdi-calendar", text: "Events", link: "/user/events" },
      {
        icon: "mdi-basket",
        text: "Entreprenuership",
        link: "/user/entreprenuership",
      },
      { icon: "mdi-help-network", text: "Help Needed", link: "/user/help" },
    ],
     years: [
        {
          color: "cyan",
          year: "1960",
        },
        {
          color: "green",
          year: "1970",
        },
        {
          color: "pink",
          year: "1980",
        },
        {
          color: "amber",
          year: "1990",
        },
        {
          color: "orange",
          year: "2000",
        },
      ],
      tags: [
        "Html 5",
        "CSS 3",
        "Laravel",
        "Vuejs",
        "Mysql",
        "Postgresql",
        "Photo Editing",
      ],

      items: [
        {
          action: "mdi-mail",
          title: "aldwin.seboguero@parsu.edu.ph",
        },
        {
          action: "mdi-phone",
          title: "+639302418587",
        },
        {
          action: "mdi-map-marker",
          title: "Zone 3 Matacla Goa, Camarines Sur 4422",
        },
      ],
      items2: [
        {
          icon: "folder",
          iconClass: "grey lighten-1 white--text",
          title: "Web Designer",
          location:"Partido State University",
          date: "Jan 9, 2014",
        },
        {
          icon: "folder",
          iconClass: "grey lighten-1 white--text",
          title: "Front-End Developer",
          location:"Partido State University",
          date: "Jan 17, 2014",
        },
        {
          icon: "folder",
          iconClass: "grey lighten-1 white--text",
          title: "Softwer Developer",
          location:"Partido State University",
          date: "Jan 28, 2014",
        },
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
      this.role = res.data.role.role;
      console.dir(res);
    });
  },
};
</script> 