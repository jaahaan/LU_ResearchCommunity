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

import profile from "../pages/profile/index";
import followings from "../pages/profile/_id/following";
import projects from "../pages/profile/_id/project";
import research from "../pages/profile/_id/research";

Vue.use(Router);

let publicRoute = 1;

export default new Router({
    mode: "history",
    routes: [
        {
            path: "/",
            name: "index",
            component: index,
            meta: {
                allowed: publicRoute,
                title: "Home|LURC",
                pageName: "Home",
            },
        },
        {
            path: "/register",
            name: "register",
            component: register,
            // meta: {
            //   allowed: 3,
            //   title: "Register User",
            //   pageName: "Register"
            // }
        },
        {
            path: "/register/student",
            name: "student",
            component: student,
        },
        {
            path: "/register/teacher",
            name: "teacher",
            component: teacher,
        },
        {
            path: "/login",
            name: "login",
            component: login,
            meta: {
                allowed: publicRoute,
                title: "Login|LURC",
                pageName: "Login",
            },
        },
        {
            path: "/forgot_password",
            name: "forgot_password",
            component: forgot,
            meta: {
                allowed: publicRoute,
                title: "Forgot Password|LURC",
                pageName: "Forgot Password",
            },
        },
        {
            path: "/reset_password",
            name: "reset_password",
            component: reset,
            meta: {
                allowed: publicRoute,
                title: "Reset Your Password|LURC",
                pageName: "Reset Password",
            },
        },
        {
            path: "/otp",
            name: "otp",
            component: otp,
            meta: {
                allowed: publicRoute,
                title: "Enter Your OTP|LURC",
                pageName: "OTP",
            },
        },

        {
            path: "/emailVerifyOtp",
            name: "email verify otp",
            component: emailVerifyOtp,
            meta: {
                allowed: publicRoute,
                title: "Enter Your OTP|LURC",
                pageName: "OTP",
            },
        },

        {
            path: "/home",
            name: "home",
            component: home,
        },
        {
            path: "/profile/:id",
            name: "profile",
            component: profile,
        },
        {
            path: "/profile/:id/research",
            name: "research",
            component: research,
        },
        {
            path: "/profile/:id/projects",
            name: "projects",
            component: projects,
        },
        {
            path: "/profile/:id/followings",
            name: "followings",
            component: followings,
        },
    ],
});
