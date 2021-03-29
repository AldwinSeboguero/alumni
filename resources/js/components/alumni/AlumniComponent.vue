<template>
  <v-app id="inspire">
    <v-navigation-drawer
      v-model="drawer" 
        :clipped="$vuetify.breakpoint.lgAndUp"
        app  
        :expand-on-hover="expandOnHover"
        :mini-variant="miniVariant" 
        dark
        
      > 
      
        <v-list
          dense
          nav
          class="py-0"
        >
          <v-list-item two-line :class="miniVariant && 'px-0'">
            <v-list-item-avatar>
                <v-avatar 
                    class="grey darken-2" 
                  >
                   <img :src="user.photo" v-if="user.photo != 'profile.png'">
                   <v-icon v-else>mdi-face-profile</v-icon>
                </v-avatar>
            </v-list-item-avatar>

            <v-list-item-content>
              <v-list-item-title>{{ user.fname }} {{ user.lname }}</v-list-item-title>
              <v-list-item-subtitle>{{ user.email }}</v-list-item-subtitle>
            </v-list-item-content>
          </v-list-item>

          <v-divider></v-divider>

          <v-list-item
            v-for="item in items"
            :key="item.title"
            :to="item.link"
            link
            @click="toTop"
          >
            <v-list-item-icon>
              <v-icon>{{ item.icon }}</v-icon>
            </v-list-item-icon>

            <v-list-item-content>
              <v-list-item-title>{{ item.title }}</v-list-item-title>
            </v-list-item-content>
          </v-list-item>
        </v-list> 
    </v-navigation-drawer>
    <v-app-bar 
      :clipped-left="$vuetify.breakpoint.lgAndUp"
      app 
      dark
      flat
    >
     <template v-slot:img="{ props }">
        <v-img
          v-bind="props"
          gradient="to bottom right, rgba(100,115,201,.3), rgba(25,32,72,.3)"
        ></v-img>
      </template>
      <v-app-bar-nav-icon @click.stop="drawer = !drawer"></v-app-bar-nav-icon>
       <v-btn icon large>
          <v-avatar size="32px" item>
            <v-img src="images/psu_logo.png" alt="Vuetify"></v-img
          ></v-avatar>
        </v-btn>
        <v-toolbar-title style="width: 300px" class="ml-0 pl-4">
          <span class="hidden-sm-and-down overline text-subtitle-1  ">PARSU Alumni</span>
        </v-toolbar-title>
        <v-text-field
          flat
          solo-inverted
          hide-details
          prepend-inner-icon="mdi-magnify"
          label="Search"
          class="hidden-sm-and-up"
          rounded
        ></v-text-field>
        <v-spacer></v-spacer>
        <!-- <v-btn text large rounded class="overline" to="/user/profile" link>
          <v-avatar size="32px" item class="mr-2">
            <v-img :src="user.photo" alt="Vuetify"></v-img
          ></v-avatar>
          {{ user.fname }}
        </v-btn> -->
        <v-btn icon>
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
        
         <v-menu
      v-model="menu"
      :close-on-content-click="false"
      :nudge-width="200"
       open-on-hover
      close-on-click  
      offset-y
    >
      <template v-slot:activator="{ on, attrs }">
       
        <v-btn icon large v-bind="attrs"
          v-on="on">
       <v-avatar size="36px" item color="grey darken-3">
            <v-icon small>mdi-arrow-down-drop-circle</v-icon>
          </v-avatar>
      </v-btn> 
      </template>

      <v-card>
        
        <v-list rounded>
            <v-list-item-group color="success">
           <v-list-item @click="logout">
         
            <v-list-item-action>
              <v-icon class="success--text">mdi-logout-variant</v-icon>
            </v-list-item-action>
            <v-list-item-content>
              <v-list-item-title>
                Logout
              </v-list-item-title>
            </v-list-item-content>
          </v-list-item>
            </v-list-item-group>
        </v-list>
 
      </v-card>
    </v-menu>
    
    </v-app-bar>

    <v-main> 
        <router-view></router-view> 
       
       <v-btn
            v-scroll="onScroll"
            v-show="fab"
            fab
            dark
            fixed
            bottom
            right
            color="primary"
            
          gradient="to bottom right, rgba(100,115,201,.3), rgba(25,32,72,.3)"
            @click="toTop"
          >
            <v-icon>mdi-arrow-up</v-icon>
          </v-btn>
    </v-main>
  </v-app>
</template>
<script>
export default {
  name: "main-app",
  props: {
    source: String,
  },
  data: () => ({
          menu: false, 
            fab: false, 
    user: '',
    role: '',
    drawer: null,
        items: [
          { title: 'Newsfeed', icon: 'mdi-view-dashboard', link: "/alumni/newsfeed"  },
          { title: 'Alumni', icon: 'mdi-badge-account', link: "/alumni/alumnus"  },
          { title: 'About', icon: 'mdi-help-box', link: "/alumni/about"  },
        ],
        color: 'primary',
        colors: [
          'primary',
          'blue',
          'success',
          'red',
          'teal',
        ],
        right: false,
        permanent: true,
        miniVariant: true,
        expandOnHover: true,
        background: true,
      }),
    computed: {
      bg () {
        return this.background ? 'https://cdn.vuetifyjs.com/images/backgrounds/bg-2.jpg' : undefined
      },
    },
     methods: {
       onScroll (e) {
      if (typeof window === 'undefined') return
      const top = window.pageYOffset ||   e.target.scrollTop || 0
      this.fab = top > 20
    },
        toTop () {
      this.$vuetify.goTo(0)
    },
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
