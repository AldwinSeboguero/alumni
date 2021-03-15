<template>
<v-app id="inspire">
<v-main>
  <div>
    <v-system-bar
      window
      dark
      color="#311B92" 
      left
    > 
      <v-container 
  >
    <v-row>
      
      <v-col cols="10">
           <v-icon>mdi-email</v-icon>
      <span>alumni.support@parsu.edu.ph</span> 
      
      </v-col>
      <v-col cols="2" >
    <v-icon>mdi-facebook</v-icon>
      <v-icon>mdi-youtube</v-icon>
      <v-icon>mdi-web</v-icon>
      </v-col>
      
    </v-row>
      </v-container>
      
    </v-system-bar>
    <v-tabs
    fixed-tabs
    background-color="indigo"
    dark
  >
    <v-tab>
      Option
    </v-tab>
    <v-tab>
      Another Selection
    </v-tab>
    <v-tab>
      Items
    </v-tab>
    <v-tab>
      Another Screen
    </v-tab>
  </v-tabs>
       <v-carousel hide-delimiters>
    <v-carousel-item
      v-for="(item,i) in items"
      :key="i"
      :src="item.src"
    ></v-carousel-item>
  </v-carousel>
  </div> 
  
</v-main>
</v-app>

</template>

<script>
export default {
   
  
   data () {
      return {
        items: [
          {
            src: 'https://cdn.vuetifyjs.com/images/carousel/squirrel.jpg',
          },
          {
            src: 'https://cdn.vuetifyjs.com/images/carousel/sky.jpg',
          },
          {
            src: 'https://cdn.vuetifyjs.com/images/carousel/bird.jpg',
          },
          {
            src: 'https://cdn.vuetifyjs.com/images/carousel/planet.jpg',
          },
        ],
      }
    },
};
</script>