import Vue from 'vue';
import Router from 'vue-router';


import home from '../pages/home';
import index from '../pages/index.vue';

//Auth
import student from '../components/registerStudent';
import teacher from '../components/registerTeacher';
import login from '../pages/auth/login';
import register from '../pages/auth/register';

import followings from '../pages/profile/following';
import profile from '../pages/profile/index';
import projects from '../pages/profile/project';
import research from '../pages/profile/research';

Vue.use(Router)

let publicRoute = 1;

export default new Router({
  mode: 'history',
  routes: [

    {
      path: '/',
      name: 'index',
      component: index,
      meta: {
        allowed: publicRoute,
        title: "Home - Laravel Vue Template",
        pageName: "Home"
      }
    }, 
    {
      path: '/register',
      name: 'register',
      component: register,
      // meta: {
      //   allowed: 3,
      //   title: "Register User",
      //   pageName: "Register"
      // }
    }, {
      path: '/register/student',
      name: 'student',
      component: student,
      
    }, {
      path: '/register/teacher',
      name: 'teacher',
      component: teacher,
      
    }, {
        path: '/login',
        name: 'login',
        component: login,
    },{
        path: '/home',
        name: 'home',
        component: home,
    },
    {
        path: '/profile',
        name: 'profile',
        component: profile,
    },
    {
      path: '/profile/research',
      name: 'research',
      component: research,
  },
  {
    path: '/profile/projects',
    name: 'projects',
    component: projects,
},
{
  path: '/profile/followings',
  name: 'followings',
  component: followings,
}
  ]
})
