<template>
<v-app id="inspire">
    <v-app id="inspire">
      <v-navigation-drawer
        v-model="drawer"
        :clipped="$vuetify.breakpoint.lgAndUp"
        left
        width="320"
        color="#1e1e1e"
      app 
      >
      <v-sheet dark height="100%">
        <v-list dense :class="$vuetify.theme.dark">
          <template v-for="item in items">
            <v-row
              v-if="item.heading"
              :key="item.heading"
              align="center"
            >
              <v-col cols="6">
                <v-subheader v-if="item.heading">
                  {{ item.heading }}
                </v-subheader>
              </v-col>
              <v-col
                cols="6"
                class="text-center"
              >
                <a
                  href="#!"
                  class="body-2 black--text"
                >EDIT</a>
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
                link
              >
                <v-list-item-action v-if="child.icon">
                  <v-icon>{{ child.icon }}</v-icon>
                </v-list-item-action>
                <v-list-item-content>
                  <v-list-item-title>
                    {{ child.text }}
                  </v-list-item-title>
                </v-list-item-content>
              </v-list-item>
            </v-list-group>
            <v-list-item
              v-else
              :key="item.text"
              link
            >
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
      </v-sheet>
      </v-navigation-drawer>

      
       <v-navigation-drawer
        v-model="drawer"
        :clipped="$vuetify.breakpoint.lgAndUp"
        right
        width="320"
      app 
      >
      <v-sheet dark>
        <v-list dense :class="$vuetify.theme.dark">
         <v-col cols="12" sm="12">
            <v-sheet>
              <v-card-title style="padding-bottom: 0"
                >Recently Connected
              <v-spacer></v-spacer>  
              <btn class="subtitle-2">See All</btn>
              </v-card-title
              > 
               <v-list>
      <v-list-item
        v-for="name in names"
        :key="name.title" 
      >
        <!-- <v-list-item-icon>
          <v-icon v-if="name.icon" color="pink">mdi-star</v-icon>
        </v-list-item-icon> -->
  <v-list-item-avatar>
          <v-img :src="name.avatar"></v-img>
        </v-list-item-avatar>
        <v-list-item-content>
          <v-list-item-title v-text="name.title"></v-list-item-title>
           <v-list-item-subtitle small
                        >ICTMO Staff</v-list-item-subtitle
                      >
        </v-list-item-content>

        
      </v-list-item>
    </v-list>
               
            </v-sheet>

            <v-sheet min-height="20vh" >
              <v-card-title style="padding-bottom: 0" class="mb-2"
                >Upcoming Events</v-card-title
              > 
              <v-card class="mx-auto" v-for="n in 3" :key="n">
                <v-list-item three-line class="mb-2">
                  <v-list-item-avatar
                    
                    size="80"
                    rounded
                    color="grey"
                  ></v-list-item-avatar>
                  <v-list-item-content>
                    <div class="overline mb-4">Conference</div>
                    <v-list-item-title class="subtitle-2 mb-1"
                      >Business Conference with dsk</v-list-item-title
                    >
                    <v-list-item-subtitle
                      >Greyhound divisely hello coldly
                      fonwderfully</v-list-item-subtitle
                    >
                  </v-list-item-content>
                </v-list-item>

                <!-- <v-card-actions>
                  <v-chip-group>
                    <v-chip
                      v-for="size in 4"
                      :key="size"
                      :value="size"
                      color="transparent"
                    >
                      <v-avatar>
                        <v-img src="img/aldwin.jpg"></v-img>
                      </v-avatar>
                    </v-chip>
                  </v-chip-group>
                </v-card-actions> -->
              </v-card>
            </v-sheet>
          </v-col>
        </v-list>
        </v-sheet>
      
      </v-navigation-drawer>
      <v-app-bar
        :clipped-left="$vuetify.breakpoint.lgAndUp"
        :clipped-right="$vuetify.breakpoint.lgAndUp"
        app
        elevation="0"
        dark
        color="#1e1e1e"
      >
    
        <v-app-bar-nav-icon @click.stop="drawer = !drawer" 
          class="hidden-sm-and-up"></v-app-bar-nav-icon>
          <v-btn
          icon
          large
        >
          <v-avatar
            size="32px"
            item
          >
            <v-img
              src="images/psu_logo.png"
              alt="Vuetify"
            ></v-img></v-avatar>
        </v-btn>  
        <v-toolbar-title
          style="width: 300px"
          class="ml-0 pl-4"
        >
          <span class="hidden-sm-and-down">ParSU ALumni</span>
        </v-toolbar-title>
        <v-text-field
          flat
          solo-inverted
          hide-details
          prepend-inner-icon="mdi-magnify"
          label="Search"
          class="hidden-sm-and-down"
          rounded
        ></v-text-field>
        <v-spacer></v-spacer>
        <v-btn
          text
          large
          rounded
          class="overline"
        >
          <v-avatar
            size="32px"
            item
            class="mr-2"
            
          >
            <v-img
              :src='user.photo'
              alt="Vuetify"
            ></v-img></v-avatar>
            {{user.fname}}
        </v-btn> 
        <v-btn icon>
         <v-avatar
            size="36px"
            item
             color="grey darken-3"
          >
          <v-icon small>mdi-plus</v-icon>
           </v-avatar>
        </v-btn>
        <v-btn icon>
         <v-avatar
            size="36px"
            item
             color="grey darken-3"
          >
          <v-icon small>mdi-email</v-icon>
           </v-avatar>
        </v-btn>
        <v-btn icon>
         <v-avatar
            size="36px"
            item
             color="grey darken-3"
          >
          <v-icon small>mdi-email</v-icon>
           </v-avatar>
        </v-btn>
        <v-btn icon>
         <v-avatar
            size="36px"
            item
             color="grey darken-3"
          >
          <v-icon small>mdi-arrow-down-drop-circle</v-icon>
           </v-avatar>
        </v-btn>
      </v-app-bar>
      
      <v-main>  
         <v-sheet dark  > 
           
            <router-view></router-view> 
         </v-sheet>
       
      </v-main>
      <v-btn
        bottom
        color="grey darken-2"
        dark
        fab
        fixed
        right
        @click="dialog = !dialog"
      >
        <v-icon>mdi-plus</v-icon>
      </v-btn>
      <v-dialog
        v-model="dialog"
        width="800px"
      >
        <v-card>
          <v-card-title class="grey darken-2">
            Create contact
          </v-card-title>
          <v-container>
            <v-row class="mx-2">
              <v-col
                class="align-center justify-space-between"
                cols="12"
              >
                <v-row
                  align="center"
                  class="mr-0"
                >
                  <v-avatar
                    size="40px"
                    class="mx-3"
                  >
                    <img
                      src="//ssl.gstatic.com/s2/oz/images/sge/grey_silhouette.png"
                      alt=""
                    >
                  </v-avatar>
                  <v-text-field
                    placeholder="Name"
                  ></v-text-field>
                </v-row>
              </v-col>
              <v-col cols="6">
                <v-text-field
                  prepend-icon="mdi-account-card-details-outline"
                  placeholder="Company"
                ></v-text-field>
              </v-col>
              <v-col cols="6">
                <v-text-field
                  placeholder="Job title"
                ></v-text-field>
              </v-col>
              <v-col cols="12">
                <v-text-field
                  prepend-icon="mdi-mail"
                  placeholder="Email"
                ></v-text-field>
              </v-col>
              <v-col cols="12">
                <v-text-field
                  type="tel"
                  prepend-icon="mdi-phone"
                  placeholder="(000) 000 - 0000"
                ></v-text-field>
              </v-col>
              <v-col cols="12">
                <v-text-field
                  prepend-icon="mdi-text"
                  placeholder="Notes"
                ></v-text-field>
              </v-col>
            </v-row>
          </v-container>
          <v-card-actions>
            <v-btn
              text
              color="primary"
            >More</v-btn>
            <v-spacer></v-spacer>
            <v-btn
              text
              color="primary"
              @click="dialog = false"
            >Cancel</v-btn>
            <v-btn
              text
              @click="dialog = false"
            >Save</v-btn>
          </v-card-actions>
        </v-card>
      </v-dialog>
    </v-app>
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
    user:'',
      names: [
          { icon: true, title: 'Jason Oner', avatar: 'https://cdn.vuetifyjs.com/images/lists/1.jpg' },
          { title: 'Travis Howard', avatar: 'https://cdn.vuetifyjs.com/images/lists/2.jpg' },
          { title: 'Ali Connors', avatar: 'https://cdn.vuetifyjs.com/images/lists/3.jpg' },
          { title: 'Cindy Baker', avatar: 'https://cdn.vuetifyjs.com/images/lists/4.jpg' },
          { title: 'Cindy Baker', avatar: 'https://cdn.vuetifyjs.com/images/lists/4.jpg' },
        ],
    items: [
      { icon: 'mdi-newspaper', text: 'News Feed' },
      { icon: 'mdi-account-multiple', text: 'People' },
      { icon: 'mdi-calendar', text: 'Events' },
      { icon: 'mdi-basket', text: 'Entreprenuership' },
      { icon: 'mdi-help-network', text: 'Help Needed' },
    ]
       
  }),
computed: {
    scrollbarTheme() {
      return this.$vuetify.theme.dark ? 'dark' : 'light';
    },
    buttonText() {
      return !this.$vuetify.theme.dark ? 'Switch to dark' : 'Switch to light'  ;
    }
  },
  methods: {
    toggleTheme() {
      this.$vuetify.theme.dark = !this.$vuetify.theme.dark;
    },
    logout(){
          axios.post('logout')
          .then(resposnse => {
             localStorage.removeItem('token');
             this.$router.push("/login");
          });
    }
  },
  created() {
      axios.get('/api/v1/verify')
      .then(res => {
        this.user = res.data.user
        this.role = res.data.role.role
        console.dir(res)
      })
  },

};
</script> 