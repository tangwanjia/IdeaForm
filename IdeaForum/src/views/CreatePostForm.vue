<script setup>
  import { ref } from 'vue';
  import axios from 'axios';
  import { useRouter } from 'vue-router';

  const router = useRouter();

  const post = ref({
    title: '',
    content: '',
    user_id: 1, // how can I use the user_id?
  });

  const createPost = async () => {
    try {
      const response = await axios.post('http://127.0.0.1:8000/api/posts', post.value);
      if (response.status === 201) {
        alert('Post created successfully!');
        post.value.title = '';
        post.value.content = '';
        router.push('/');
      } else {
        alert('Error creating post: Unable to create the post.');
      }
    } catch (error) {
      alert('Error creating post: ' + error);
    }
  };

</script>

<template>
  <div class="container">
    <h1 class="text-center mt-4">Create a new post</h1>
    <div class="post-box border mt-4 p-3">
      <form @submit.prevent="createPost">
        <div class="mb-3">
          <label for="title" class="form-label">Title</label>
          <input v-model="post.title" type="text" class="form-control" id="title" required>
        </div>
        <div class="mb-3">
          <label for="content" class="form-label">Text</label>
          <textarea v-model="post.content" class="form-control" id="content" rows="4" required></textarea>
        </div>
        <button type="submit" class="btn btn-primary">POST</button>
      </form>
    </div>
  </div>
</template>

<style>
  .post-box {
    background-color: white;
    border: 1px solid #ddd;
    border-radius: 5px;
    padding: 15px;
    box-shadow: 0px 2px 4px rgba(0, 0, 0, 0.1);
  }
</style>