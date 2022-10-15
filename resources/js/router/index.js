import Vue from "vue";
import Router from "vue-router";

import home from "../pages/home";
import index from "../pages/index.vue";

//Auth
import student from "../components/registerStudent";
import teacher from "../components/registerTeacher";
import emailVerifyOtp from "../pages/auth/emailVerifyOtp";
import forgot from "../pages/auth/forgot";
import login from "../pages/auth/login";
import otp from "../pages/auth/otp";
import register from "../pages/auth/register";
import reset from "../pages/auth/reset";

//Profile
import profile from "../pages/profile/index";
import followings from "../pages/profile/_id/following";
import projects from "../pages/profile/_id/project";
import research from "../pages/profile/_id/research";

//Admin
import teachers from "../pages/Admin/teachers";

Vue.use(Router);

let publicRoute = 1;
let authRoute = 2;
let defaultRoute = 3;

export default new Router({
    mode: "history",
    routes: [
        {
            path: "/",
            name: "index",
            component: index,
            meta: {
                allowed: defaultRoute,
                title: "Home - LURC",
                pageName: "index",
            },
        },
        {
            path: "/register",
            name: "register",
            component: register,
            meta: {
              allowed: defaultRoute,
              title: "Register - LURC",
              pageName: "Register"
            }
        },
        {
            path: "/register/student",
            name: "student",
            component: student,
            meta: {
                allowed: defaultRoute,
                title: "RegisterAsStudent - LURC",
                pageName: "Register"
            }
        },
        {
            path: "/register/teacher",
            name: "teacher",
            component: teacher,
            meta: {
                allowed: defaultRoute,
                title: "RegisterAsTeacher - LURC",
                pageName: "Register"
            }
        },
        {
            path: "/login",
            name: "login",
            component: login,
            meta: {
                allowed: defaultRoute,
                title: "Login - LURC",
                pageName: "login",
            },
        },
        {
            path: "/forgot_password",
            name: "forgot_password",
            component: forgot,
            meta: {
                allowed: defaultRoute,
                title: "Forgot Password - LURC",
                pageName: "Forgot Password",
            },
        },
        {
            path: "/reset_password",
            name: "reset_password",
            component: reset,
            meta: {
                allowed: defaultRoute,
                title: "Reset Your Password - LURC",
                pageName: "Reset Password",
            },
        },
        {
            path: "/otp",
            name: "otp",
            component: otp,
            meta: {
                allowed: defaultRoute,
                title: "Enter Your OTP - LURC",
                pageName: "OTP",
            },
        },

        {
            path: "/emailVerifyOtp",
            name: "email verify otp",
            component: emailVerifyOtp,
            meta: {
                allowed: defaultRoute,
                title: "Enter Your OTP - LURC",
                pageName: "OTP",
            },
        },

        {
            path: "/home",
            name: "home",
            component: home,
            meta: {
                allowed: authRoute,
                title: "Home - LURC",
                pageName: "home",
            },
        },
        {
            path: "/profile/:id",
            name: "profile",
            component: profile,
            meta: {
                allowed: authRoute,
                title: "Profile",
                pageName: "home",
            },
        },
        {
            path: "/profile/:id/research",
            name: "research",
            component: research,
            meta: {
                allowed: authRoute,
                title: "Research",
                pageName: "home",
            },
        },
        {
            path: "/profile/:id/projects",
            name: "projects",
            component: projects,
            meta: {
                allowed: authRoute,
                title: "Projects",
                pageName: "home",
            },
        },
        {
            path: "/profile/:id/followings",
            name: "followings",
            component: followings,
            meta: {
                allowed: authRoute,
                title: "Followings",
                pageName: "home",
            },
        },

        {
            path: "/teachers",
            name: "teachers",
            component: teachers,
            meta: {
                allowed: authRoute,
                title: "Teachers",
                pageName: "teachers",
            },
        },
    ],
});
