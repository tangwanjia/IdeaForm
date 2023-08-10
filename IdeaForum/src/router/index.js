import { createRouter, createWebHistory } from 'vue-router'
import HomeView from '../views/HomeView.vue'
import CreatePostForm from '../views/CreatePostForm.vue'
import EditPostForm from '../views/EditPostForm.vue'

const router = createRouter({
  history: createWebHistory(import.meta.env.BASE_URL),
  routes: [
    {
      path: '/',
      name: 'home',
      component: HomeView
    },
    {
      path: '/Login',
      name: 'login',
      component: () => import('../views/Login.vue')
    },
    {
      path: '/about',
      name: 'about',
      // route level code-splitting
      // this generates a separate chunk (About.[hash].js) for this route
      // which is lazy-loaded when the route is visited.
      component: () => import('../views/AboutView.vue')
    },
    { 
      path: '/create-post', 
      name: 'create-post', 
      component: CreatePostForm 
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
    }
  ]
})


export default router
