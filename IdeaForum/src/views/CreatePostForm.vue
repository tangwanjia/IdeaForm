<script setup>
  import { ref } from 'vue';
  import axios from 'axios';
  import { useRouter } from 'vue-router';

  const router = useRouter();

  const loggedInUserId = localStorage.getItem('user_id');

  const post = ref({ title: '', content: '' });
  const titleError = ref(false);
  const contentError = ref(false);

  const createPost = async () => {
    if (!loggedInUserId) {
      router.push({ name: 'login' });
      return;
    }
    // Validate fields
    titleError.value = !post.value.title.trim();
    contentError.value = !post.value.content.trim();

    if (titleError.value || contentError.value) {
      return;
    }

    try {
      const response = await axios.post('http://127.0.0.1:8000/api/posts', {
        title: post.value.title,
        content: post.value.content,
        user_id: loggedInUserId,
      });
      if (response.status === 201) {
        alert('Post created successfully!');
        post.value.title = '';
        post.value.content = '';
        router.push('/home');
      } else {
        alert('Error creating post: Unable to create the post.');
      }
    } catch (error) {
      alert('Error creating post: ' + error);
    }
  };

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
          <button @click="logout" class="btn btn-danger ms-auto me-2 p-lg-2">Logout</button>
        </div>
  </nav>

  <!-- Main Header -->
  <div class="p-5 text-center border-bottom">
      <h1>PHP Forum</h1>
      <p>
        A large equal forum to talk about PHP, in order to help one another learn PHP language. <br>
        Create your post in the form below. Remember to be respectful.
      </p>
  </div>

  <div class="container">
    <h1 class="text-center mt-4">Create a new post</h1>
    <div class="post-box border mt-4 p-3">
      <form @submit.prevent="createPost">
        <div class="mb-3">
          <label for="title" class="form-label">Title</label>
          <input v-model="post.title" type="text" class="form-control" id="title">
          <p v-if="titleError" class="text-danger">Title cannot be empty.</p>
        </div>
        <div class="mb-3">
          <label for="content" class="form-label">Text</label>
          <textarea v-model="post.content" class="form-control" id="content" rows="4"></textarea>
          <p v-if="contentError" class="text-danger">Content cannot be empty.</p>
        </div>
        <button type="submit" class="btn btn-primary">POST</button>
      </form>
    </div>
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
  .post-box {
    background-color: white;
    border: 1px solid #ddd;
    border-radius: 5px;
    padding: 15px;
    box-shadow: 0px 2px 4px rgba(0, 0, 0, 0.1);
  }
</style>