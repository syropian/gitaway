import Vue from "vue";
import Router from "vue-router";
import ls from "local-storage";
import Auth from "@/components/pages/Auth";
import Dashboard from "@/components/pages/Dashboard";

Vue.use(Router);

const router = new Router({
  mode: "history",
  routes: [
    {
      path: "/",
      name: "Auth",
      component: Auth,
      beforeEnter: (to, from, next) => {
        if (to.query.token) {
          const expirySeconds = parseInt(to.query.token_expiry, 10);
          const now = new Date();
          now.setSeconds(now.getSeconds() + expirySeconds);
          ls("jwt_expiry", now);
          ls("jwt", to.query.token);
          next("dashboard");
        } else {
          next();
        }
      },
      children: [
        {
          path: "logout",
          name: "Logout",
          meta: {
            requiresAuth: true
          },
          beforeEnter: (to, from, next) => {
            ls.remove("jwt");
            next("/");
          }
        }
      ]
    },
    {
      path: "/dashboard",
      name: "Dashboard",
      component: Dashboard,
      meta: {
        requiresAuth: true
      }
    }
  ]
});

router.beforeEach((to, from, next) => {
  const token = ls("jwt");
  const expiry = ls("jwt_expiry");
  const requiresAuth = to.matched.some(record => record.meta.requiresAuth);

  if (requiresAuth && !token) {
    next("/");
  } else if (requiresAuth && token && new Date() > new Date(expiry)) {
    next("/");
  } else if (!requiresAuth && token && new Date() < new Date(expiry)) {
    next("dashboard");
  } else {
    next();
  }
});

export default router;
