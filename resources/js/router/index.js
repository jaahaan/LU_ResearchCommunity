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
import connection from "../pages/profile/_slug/connection";
import overview from "../pages/profile/_slug/overview";
import projects from "../pages/profile/_slug/project";
import userresearch from "../pages/profile/_slug/research";

//description
import department from "../pages/department/_slug/_id";
import message from "../pages/message";
import comments from "../pages/PostDescription/comments";
import postOverview from "../pages/PostDescription/overview";
import research from "../pages/research";

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
            path: "/profile/:slug/overview",
            name: "profile-slug-overview",
            component: overview,
            meta: {
                allowed: authRoute,
                title: "Profile",
                pageName: "overview",
            },
        },
        {
            path: "/profile/:slug/research",
            name: "profile-slug-research",
            component: userresearch,
            meta: {
                allowed: authRoute,
                title: "Research",
                pageName: "research",
            },
        },
        {
            path: "/profile/:slug/project",
            name: "profile-slug-project",
            component: projects,
            meta: {
                allowed: authRoute,
                title: "Projects",
                pageName: "projrcts",
            },
        },
        
        {
            path: "/profile/:slug/connection",
            name: "profile-slug-connection",
            component: connection,
            meta: {
                allowed: authRoute,
                title: "Connection",
                pageName: "connection",
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
        
        {
            path: "/description/:slug/overview",
            name: "description-slug-overview",
            component: postOverview,
            meta: {
                allowed: authRoute,
                title: "Post overview",
                pageName: "post_overview",
            },
        },
        {
            path: "/description/:slug/comments",
            name: "description-slug-comments",
            component: comments,
            meta: {
                allowed: authRoute,
                title: "Post comments",
                pageName: "post_comments",
            },
        },

        {
            path: "/research",
            name: "research",
            component: research,
            meta: {
                allowed: publicRoute,
                title: "Research",
                pageName: "research",
            },
        },

        {
            path: "/department/:slug/:id",
            name: "department",
            component: department,
            meta: {
                allowed: publicRoute,
                title: "department",
                pageName: "department",
            },
        },
        {
            path: "/message",
            name: "message",
            component: message,
            meta: {
                allowed: publicRoute,
                title: "message",
                pageName: "message",
            },
        },
    ],
});
