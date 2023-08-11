<script setup>
import { ref, onMounted } from 'vue';
import axios from 'axios';
import { useRoute, useRouter } from 'vue-router';
import { useStore } from 'vuex';

const store = useStore();
const route = useRoute();
const router = useRouter();

const editedComment = ref({
  content: '',
  contentError: false,
});

onMounted(async () => {
  const commentId = Number(route.params.commentId);
  const comment = await fetchComment(commentId); // Fetch comment details from API
  editedComment.value.content = comment.content;
});

const fetchComment = async (commentId) => {
  try {
    const response = await axios.get(`http://127.0.0.1:8000/api/comments/${commentId}`);
    return response.data;
  } catch (error) {
    console.error('Error fetching comment:', error);
  }
};

const updateComment = async () => {
  if (!editedComment.value.content.trim()) {
    editedComment.value.contentError = true;
    return;
  }

  try {
    const commentId = Number(route.params.commentId);
    const response = await axios.put(`http://127.0.0.1:8000/api/comments/${commentId}`, editedComment.value);
    if (response.status === 200) {
      store.dispatch('fetchComments'); // Fetch updated comments
      router.push('/home'); // Redirect back to the main page
      alert('Comment updated successfully!');
    } else {
      alert('Error updating comment: Unable to update the comment.');
    }
  } catch (error) {
    alert('Error updating comment: ' + error);
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
        Login to catch more important and useful information.
      </p>
  </div>

  <div class="container">
      <h1 class="text-center mt-4">Edit Comment</h1>
      <div class="comment-box border mt-4 p-3">
        <form @submit.prevent="updateComment">
          <div class="mb-3">
            <label for="content" class="form-label">Comment</label>
            <textarea v-model="editedComment.content" class="form-control" id="content" rows="4"></textarea>
            <p v-if="editedComment.contentError" class="text-danger">Comment cannot be empty.</p>
          </div>
          <button type="submit" class="btn btn-primary">Update Comment</button>
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
  .comment-box {
    background-color: white;
    border: 1px solid #ddd;
    border-radius: 5px;
    padding: 15px;
    box-shadow: 0px 2px 4px rgba(0, 0, 0, 0.1);
  }
</style>