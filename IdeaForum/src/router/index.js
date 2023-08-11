import { createRouter, createWebHistory } from 'vue-router'
import HomeView from '../views/HomeView.vue'
import CreatePostForm from '../views/CreatePostForm.vue'
import EditPostForm from '../views/EditPostForm.vue'
import EditCommentForm from '../views/EditCommentForm.vue'
import Login from '../views/Login.vue'
import store from '../store/index'

const router = createRouter({
  history: createWebHistory(import.meta.env.BASE_URL),
  routes: [
    {
      path: '/home',
      name: 'home',
      component: HomeView
    },
    {
      path: '/',
      name: 'login',
      component: Login
    },
    { 
      path: '/create-post', 
      name: 'create-post', 
      component: CreatePostForm,
      meta: {requiresAuth: true} 
    },
    {
      path: '/edit-post/:postId',
      name: 'edit-post',
      component: EditPostForm
    },
    {
      path: '/edit-comment/:commentId',
      name: 'edit-comment',
      component: EditCommentForm
    },
  ]
})

//Global navigation
router.beforeEach((to, from, next) => {
  const requiresAuth = to.matched.some(record => record.meta.requiresAuth);
  const isAuthenticated = store.state.token !== '';

  if (requiresAuth && !isAuthenticated) {
    // Redirect to the login page if route requires authentication but user is not logged in
    next({ name: 'login' });
  } else {
    next();
  }
});


export default router
