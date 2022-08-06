import Vue from 'vue';
import Router from 'vue-router';

import login from '../layout/login';
import profile from '../layout/profile_page';
import register from '../layout/register';
import followings from '../pages/following';
import home from '../pages/home';
import projects from '../pages/project';
import student from '../pages/register_student';
import teacher from '../pages/register_teacher';
import research from '../pages/research';
import role from '../pages/role';


// import home from '../pages/home';
import index from '../pages/index.vue';

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
      path: '/student',
      name: 'student',
      component: student,
      
    }, {
      path: '/teacher',
      name: 'teacher',
      component: teacher,
      
    }, {
        path: '/login',
        name: 'login',
        component: login,
    },{
      path: '/role',
      name: 'role',
      component: role,
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
