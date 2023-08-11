<script setup>
import axios from 'axios';
import { ref, computed, onMounted } from 'vue';
import { useRoute, useRouter } from 'vue-router';
import { useStore }  from "vuex";

const router = useRouter();
const route = useRoute();
const store = useStore();
const postId = ref(parseInt(route.params.postId));
const loggedInUserId = localStorage.getItem('user_id');

const editedPost = computed(() => {
  return store.state.posts.find(post => post.id === postId.value) || { title: '', content: '' };
});

const isPostAuthor = computed(() => {
  const post = store.state.posts.find(post => post.id === postId.value);
  return post && post.user_id === parseInt(loggedInUserId);
});

const updatePost = async () => {
  if (!isPostAuthor.value) {
    alert('You are not authorized to edit this post.');
    return;
  }
  try {
    const response = await axios.put(`http://127.0.0.1:8000/api/posts/${postId.value}`, editedPost.value);
    if (response.status === 200) {
      router.push('/');
      alert('Post updated successfully!');
    } else {
      alert('Error updating post: Unable to update the post.');
    }
  } catch (error) {
    alert('Error updating post: ' + error);
  }
};

//Pre-populate the post 
onMounted(async () => {
  const selectedPost = store.state.posts.find(post => post.id === postId.value);
  if (selectedPost) {
    editedPost.value.title = selectedPost.title;
    editedPost.value.content = selectedPost.content;
  } else {
    console.error('Selected post not found');
  }
});

</script>

<template>
  <div class="page-container">

  <!-- Nav Bar -->
  <nav class="navbar bg-dark navbar-expand-lg navbar-dark p-3">
        <div class="container">
          <a class="navbar-brand" href="#">PHP</a>
          <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav"
            aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
          </button>
          <div class="collapse navbar-collapse" id="navbarNav">
            <ul class="navbar-nav">
              <li class="nav-item">
                <a class="nav-link active" aria-current="page" href="#">Home</a>
              </li>
            </ul>
          </div>
          <button @click="goToCreatePost" class="btn btn-success ms-auto me-2 p-lg-2">
             Create New Post
          </button>
          <button @click="goToLogin" class="btn btn-success ms-auto me-2 p-lg-2">
            Login
          </button>
        </div>
  </nav>

  <div class="container">
      <h1>Edit Post</h1>
      <form @submit.prevent="updatePost">
        <div class="mb-3">
          <label for="edit-title" class="form-label">Title</label>
          <input v-model="editedPost.title" type="text" class="form-control" id="edit-title" required>
        </div>
        <div class="mb-3">
          <label for="edit-content" class="form-label">Content</label>
          <textarea v-model="editedPost.content" class="form-control" id="edit-content" rows="4" required></textarea>
        </div>
        <button type="submit" class="btn btn-primary">Save</button>
      </form>
    </div>
  
  <!-- Footer -->
  <footer class="bg-dark text-lg-start text-white">
      <p class="text-uppercase text-end"><i class="fas fa-at fa-fw fa-sm me-2">PHP Forum</i></p>
      <p class="text-uppercase text-end"><i class="fas fa-at fa-fw fa-sm me-2">Tel:12345678</i></p>
      <p class="text-uppercase text-end"><i class="fas fa-at fa-fw fa-sm me-2">Address:Ottawa,ON</i></p>
    
      <!-- Copyright -->
      <div class="text-center p-3" style="background-color: rgba(0, 0, 0, 0.2)">
        © 2023 Copyright:
        <a class="text-white" href="#">phpforum.com</a>
      </div>
      <!-- Copyright -->
    </footer>
  </div>

</template>

<style>
*{
  font-family: Arial, Helvetica, sans-serif;
}
.page-container {
      display: flex;
      flex-direction: column;
      height: 100%;
}

</style>
    
