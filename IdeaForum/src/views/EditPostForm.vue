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
  return (
    store.state.posts.find((post) => post.id === postId.value) || {
      title: '',
      content: '',
      titleError: false,  // Add these lines
      contentError: false,  // Add these lines
    }
  );
});

const isPostAuthor = computed(() => {
  const post = store.state.posts.find(post => post.id === postId.value);
  return post && post.user_id === parseInt(loggedInUserId);
});

const updatePost = async () => {
  editedPost.value.titleError = false;
  editedPost.value.contentError = false;

  if (!editedPost.value.title.trim()) {
    editedPost.value.titleError = true;
    return;
  }

  if (!editedPost.value.content.trim()) {
    editedPost.value.contentError = true;
    return;
  }

  if (!isPostAuthor.value) {
    alert('You are not authorized to edit this post.');
    return;
  }
  try {
    const response = await axios.put(`http://127.0.0.1:8000/api/posts/${postId.value}`, editedPost.value);
    if (response.status === 200) {
      router.push('/home');
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

const logout = () => {
  store.dispatch('logout');
  router.push({ name: 'login' }); 
};

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
          <button @click="logout" class="btn btn-danger ms-auto me-2 p-lg-2">Logout</button>
        </div>
  </nav>

  <!-- Main Header -->
  <div class="p-5 text-center border-bottom">
      <h1>PHP Forum</h1>
      <p>
        A large equal forum to talk about PHP, in order to help one another learn PHP language. <br>
        Edit your post in the form below.
      </p>
  </div>

  <div class="container">
      <h1 class="text-center">Edit Post</h1>
      <form @submit.prevent="updatePost">
        <div class="mb-3">
          <label for="edit-title" class="form-label">Title</label>
          <input v-model="editedPost.title" type="text" class="form-control" id="edit-title">
          <p class="text-danger" v-if="editedPost.titleError">Title cannot be empty.</p>
        </div>
        <div class="mb-3">
          <label for="edit-content" class="form-label">Content</label>
          <textarea v-model="editedPost.content" class="form-control" id="edit-content" rows="4"></textarea>
          <p class="text-danger" v-if="editedPost.contentError">Content cannot be empty.</p>
        </div>
        <button type="submit" class="btn btn-primary">Save</button>
      </form>
    </div>
  
  <!-- Footer -->
  <footer class="bg-dark text-lg-start text-white">
      <!-- Copyright -->
      <div class="text-center p-3" style="background-color: rgba(0, 0, 0, 0.2)">
        © 2023 Copyright: phpforum.com
      </div>
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
    
