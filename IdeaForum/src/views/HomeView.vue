<script setup>

import { useStore }  from "vuex";
import { onMounted, computed, ref } from "vue";
import { useRouter } from 'vue-router';
import axios from 'axios';

const router = useRouter();
const store = useStore();
const loggedInUserId = computed(() => parseInt(localStorage.getItem('user_id')));
const isAuthenticated = computed(() => store.state.token !== '');

// Computed properties to get data from the store
const users = computed(() => {return store.state.users});
const posts = computed(() => {return store.state.posts});
const comments = computed(() => {return store.state.comments});

const goToCreatePost = () => {
  if (isAuthenticated.value) {
    router.push({ name: 'create-post' });
  } else {
    router.push({ name: 'login' });
  }
};

const editPost = (postId) => {
  router.push({ name: 'edit-post', params: { postId } });
};

const deletePost = async (postId) => {
    try {
      const response = await axios.delete(`http://127.0.0.1:8000/api/posts/${postId}`);
      console.log(response);
      if (response.status === 204) {
        // Post deleted successfully, fetch updated posts
        store.dispatch("fetchPosts");
        alert('Post deleted successfully!');
      } else {
        alert('Error deleting post: Unable to delete the post.');
      }
    } catch (error) {
      alert('Error deleting post: ' + error);
    }
};

const newComments = {};
const commentInteracted = ref({});
const createNewComment = (postId) => {
  newComments[postId] = '';
};

const submitComment = async (postId) => {
  try {
    if (!newComments[postId] || newComments[postId].trim() === '') {
      alert('Comment cannot be empty.');
      return;
    }

    const response = await axios.post('http://127.0.0.1:8000/api/comments', {
      post_id: postId,
      content: newComments[postId],
      user_id: loggedInUserId.value,
    });
    if (response.status === 201) {
      store.dispatch("fetchComments"); // Fetch updated comments
      newComments[postId] = ''; // Clear the comment field
      commentInteracted[postId] = false;
      alert('Comment posted successfully!');
    } else {
      alert('Error posting comment: Unable to post the comment.');
    }
  } catch (error) {
    alert('Error posting comment: ' + error);
  }
};

const editComment = async (commentId) => {
    router.push({ name: 'edit-comment', params: { commentId } });
};

const deleteComment = async (commentId) => {
  try {
    const response = await axios.delete(`http://127.0.0.1:8000/api/comments/${commentId}`);
    if (response.status === 204) {
      store.dispatch("fetchComments"); // Fetch updated comments
      alert('Comment deleted successfully!');
    } else {
      alert('Error deleting comment: Unable to delete the comment.');
    }
  } catch (error) {
    alert('Error deleting comment: ' + error);
  }
};

// Fetch the data when the component is mounted
onMounted(() => {
  store.dispatch("fetchUsers");
  store.dispatch("fetchPosts");
  store.dispatch("fetchComments");
  // Create new comments for each post
  posts.value.forEach(post => {
    createNewComment(post.id);
    commentInteracted[post.id] = false;
  });
});


// Helper function to get comments by post id
const getCommentsByPostId = (postId) => {
  return comments.value.filter((comment) => comment.post_id === postId);
};

// Helper function to get user by id
const getUserById = (userId) => {
  return users.value.find((user) => user.id === userId);
};

const isPostAuthor = (post) => {
  return post.user_id === loggedInUserId.value;
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
          <button @click="goToCreatePost" class="btn btn-success ms-auto me-2 p-lg-2">
             Create New Post
          </button>
        </div>
    </nav>

    <!-- Main Header -->
    <div class="p-5 text-center border-bottom">
      <h1>PHP Forum</h1>
      <p>
        A large equal forum to talk about PHP, in order to help one another learn PHP language. <br>
        Read and make your contributions to the discussions below.
      </p>
    </div>

    <!-- Main Content -->
    <div class="container main-content">
      <div class="row justify-content-center">
        <div class="col-lg-12">
          <div v-for="post in posts" :key="post.id" class="post-box border mb-4 p-3">
            <h2 class="post-title">{{ post.title }}</h2>
            <p>{{ post.content }}</p>
            <button v-if="loggedInUserId && isPostAuthor(post)" @click="editPost(post.id)" class="btn btn-primary">Edit</button>
            <button v-if="loggedInUserId && isPostAuthor(post)" @click="deletePost(post.id)" class="btn btn-danger">Delete</button>
            <h5 class="comment-title">Comments:</h5>
            <ul>
              <li v-for="comment in getCommentsByPostId(post.id)" :key="comment.id">
                {{ comment.content }} - {{ getUserById(comment.user_id).name }}
                <button v-if="comment.user_id === loggedInUserId" @click="editComment(comment.id)" class="btn btn-primary btn-sm">Edit</button>
                <button v-if="comment.user_id === loggedInUserId" @click="deleteComment(comment.id)" class="btn btn-danger btn-sm">Delete</button>
              </li>
            </ul>
            <form @submit.prevent="submitComment(post.id)">
              <div class="mb-3">
                <label for="comment" class="form-label">Post a Comment</label>
                <textarea 
                v-model="newComments[post.id]" 
                class="form-control" 
                id="comment" 
                @input="commentInteracted[post.id] = true" 
                rows="2"></textarea>
                <p class="text-danger" v-if="commentInteracted[post.id] && (!newComments[post.id] || !newComments[post.id].trim())">Comment cannot be empty.</p>
              </div>
              <button type="submit" class="btn btn-primary">Post Comment</button>
            </form>
            <hr class="mt-4 mb-0">
          </div>
        </div>
      </div>
    </div>

    <!-- Footer -->
    <footer class="bg-dark  text-lg-start text-white">
      <!-- Copyright -->
      <div class="text-center p-3" style="background-color: rgba(0, 0, 0, 0.2)">
        © 2023 Copyright:phpforum.com
      </div>
    </footer>
  </div>

</template>


<style>
    *{
      font-family: Arial, Helvetica, sans-serif;
    }
    body {
      background-color: #f5f5f5;
    }
    .post-box {
      background-color: white;
      border: 1px solid #ddd;
      border-radius: 5px;
      padding: 15px;
      margin-bottom: 20px;
      box-shadow: 0px 2px 4px rgba(0, 0, 0, 0.1);
    }
    .post-title {
      color: #337ab7;
    }
    .comment-title {
      color: #555;
      margin-top: 10px;
    }

    .page-container {
      display: flex;
      flex-direction: column;
      height: 100%;
    }

    .main-content {
      flex: 1;
      padding: 20px;
    }
</style>
