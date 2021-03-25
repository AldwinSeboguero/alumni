import Vue from 'vue';
import VueRouter from 'vue-router';
import LoginComponent from './components/LoginComponent';

import AdminComponent from './components/alumni/AdminComponent';


import ForgotPassword from './components/page/ForgotPassword';
import ResetPasswordForm from './components/page/ResetPasswordForm';
import ResetEmailForm from './components/page/ResetEmailForm';


import ProfileComponent from './components/user/profile/ProfileComponent'; 
import EventComponent from './components/alumni/EventComponent'; 
import PeopleComponent from './components/alumni/PeopleComponent'; 
import LiveFeedComponent from './components/alumni/LiveFeedComponent'; 
import CareerComponent from './components/alumni/CareerComponent'; 

//home Componenent
import HomeComponent from './components/home/HomeComponent'; 
import UserComponent from './components/user/UserComponent'; 
import UserProfileComponent from './components/user/profile/UserProfileComponent'; 
import EditProfileComponent from './components/user/profile/EditProfileComponent'; 


Vue.use(VueRouter);

const routes =[
    { 
        path: '/reset-password', 
        name: 'reset-password', 
        component: ForgotPassword, 
        meta: { 
          auth:false 
        } 
      },
      { 
        path: '/reset-password/:token', 
        name: 'reset-password-form', 
        component: ResetPasswordForm, 
        meta: { 
          auth:false 
        } 
      },
      { 
        path: '/reset-email/:token', 
        name: 'reset-email-form', 
        component: ResetEmailForm, 
        meta: { 
          auth:false 
        } 
      },
    // {
    //     path: '/',
    //     beforeEnter: checkRoleRoute,
    //     name: 'login'
            
    // },
    {
        path: '/login',
        component: LoginComponent, 
    },
    {
        path: '/',
        beforeEnter: checkRoleRoute,
        name: 'login'
    },
    {
        path: '/userhome',
        component: UserComponent, 
    },
    
    {
        path: '/admin',
        component: AdminComponent,
        name: 'Admin', 
        beforeEnter: (to, from, next) => {
            if (localStorage.getItem('token')) {
                next();
            } else {
    localStorage.removeItem('token');
    localStorage.removeItem('token','user','loggedIn');
    localStorage.removeItem('loggedIn');
    localStorage.removeItem('user');
    next('/login');
            }
        },
        redirect: '/admin/profile',
        children: [
            //Admin Routes
            
              
                {
                    path: 'profile',
                    beforeEnter: isADMIN,
                    component: ProfileComponent,
                    name: 'Profile' 
                },
                {
                    path: 'event',
                    component: EventComponent,
                    name: 'event' 
                },
                {
                    path: 'people',
                    component: PeopleComponent,
                    name: 'people' 
                },
                {
                    path: 'newsfeed',
                    component: LiveFeedComponent,
                    name: 'newsfeed' 
                },
                {
                    path: 'career',
                    component: CareerComponent,
                    name: 'career' 
                },
        ]
        
    },
    {
        path: '/user',
        component: UserComponent,
        name: 'User', 
        beforeEnter: (to, from, next) => {
            if (localStorage.getItem('token')) {
                next();
            } else {
    localStorage.removeItem('token');
    localStorage.removeItem('token','user','loggedIn');
    localStorage.removeItem('loggedIn');
    localStorage.removeItem('user');
    next('/login');
            }
        },
        redirect: '/user/newsfeed',
        children: [
            //Admin Routes
            
              
               
                {
                    path: 'event',
                    component: EventComponent,
                    name: 'event' 
                },
                {
                    path: 'people',
                    component: PeopleComponent,
                    name: 'people' 
                },
                {
                    path: 'newsfeed',
                    beforeEnter: isUser,
                    component: LiveFeedComponent,
                    name: 'newsfeed' 
                },
                {
                    path: 'career',
                    component: CareerComponent,
                    name: 'career' 
                },
        ]
        
    },
    {
        path: '/user',
       
        name: 'UserProfile', 
        beforeEnter: (to, from, next) => {
            if (localStorage.getItem('token')) {
                next();
            } else {
    localStorage.removeItem('token');
    localStorage.removeItem('token','user','loggedIn');
    localStorage.removeItem('loggedIn');
    localStorage.removeItem('user');
    next('/login');
            }
        }, 
        component: UserProfileComponent,
        children: [
            //Admin Routes
            
              
                {
                    path: 'profile', 
                    component: ProfileComponent,
                    name: 'Profile' 
                },
                {
                    path: 'edit-profile', 
                    beforeEnter: isUser,
                    component: EditProfileComponent,
                    name: 'Edit-Profile' 
                },
            ],
        
    },
    
    
];
function requireLogin(to, from, next) {
    axios.get('/api/v1/verify',{'user' : localStorage.getItem('user')})
    .then(res => next())
    .catch(err => next('/login'))
}
// function backLogin(){
//     localStorage.removeItem('token');
//     localStorage.removeItem('token','user','loggedIn');
//     localStorage.removeItem('loggedIn');
//     localStorage.removeItem('user');


//     next('/login');
// }
function isADMIN(to, from, next) {
    axios.get('/api/v1/verify')
    .then(res => {
            if(res.data.user_role.role.name=="admin") {next();} 
            else{next('/');}
        }).catch(err => {
    localStorage.removeItem('token');
    localStorage.removeItem('token','user','loggedIn');
    localStorage.removeItem('loggedIn');
    localStorage.removeItem('user');
    next('/login');})
}

function isUser(to, from, next) {
    axios.get('/api/v1/verify')
    .then(res => {
            if(res.data.user_role.role.name=="user") {
                next();} 
            else{next('/');}
        }).catch(err => {
    localStorage.removeItem('token');
    localStorage.removeItem('token','user','loggedIn');
    localStorage.removeItem('loggedIn');
    localStorage.removeItem('user');
    next('/login');})
}



function checkRoleRoute(to, from, next) {
    axios.get('/api/v1/verify')
        .then(res => {
                if(res.data.user_role.role.name=="admin") {
                    next('/admin');
                } 
                else if(res.data.user_role.role.name=="user") {
                    next('/user');
                } 
                
                else{
                    localStorage.removeItem('token');
                    localStorage.removeItem('token','user','loggedIn');
                    localStorage.removeItem('loggedIn');
                    localStorage.removeItem('user');
                    next('/login');
                }
            }
            )
        .catch(err => {
            {
                localStorage.removeItem('token');
                localStorage.removeItem('token','user','loggedIn');
                localStorage.removeItem('loggedIn');
                localStorage.removeItem('user');
                next('/login');}
        })
}
const router = new VueRouter({routes})
// router.beforeEach((to,from,next) => {
//     const token = localStorage.getItem('token') || null
//     window.axios.defaults.headers['Authorization'] = "Bearer" + token;
//     next();
// })
export default new VueRouter({routes});
