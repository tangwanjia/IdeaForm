<script setup>

import { useStore} from "vuex";
import { onMounted, computed } from "vue";
import { useRouter } from 'vue-router';
import axios from 'axios';

const router = useRouter();

const goToCreatePost = () => {
  router.push({ name: 'create-post' }); // Assumes you've named the route for the form page'create-post'
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

const store = useStore();
// Fetch the data when the component is mounted
onMounted(() => {
  store.dispatch("fetchUsers");
  store.dispatch("fetchPosts");
  store.dispatch("fetchComments");
});

// Computed properties to get data from the store
const users = computed(() => {return store.state.users});
const posts = computed(() => {return store.state.posts});
const comments = computed(() => {return store.state.comments});

// Helper function to get comments by post id
const getCommentsByPostId = (postId) => {
  return comments.value.filter((comment) => comment.post_id === postId);
};

// Helper function to get user by id
const getUserById = (userId) => {
  return users.value.find((user) => user.id === userId);
};

</script>

<template>

<div class="container">
  <button @click="goToCreatePost" class="btn btn-primary mt-3">Create New Post</button>
  <div class="row justify-content-center">
    <div class="col-lg-12">
      <div v-for="post in posts" :key="post.id" class="post-box border mb-4 p-3">
        <h2 class="post-title">{{ post.title }}</h2>
        <p>{{ post.content }}</p>
        <button @click="editPost(post.id)" class="btn btn-primary">Edit</button>
        <button @click="deletePost(post.id)" class="btn btn-danger">Delete</button>
        <h5 class="comment-title">Comments:</h5>
        <ul>
          <li v-for="comment in getCommentsByPostId(post.id)" :key="comment.id">
            {{ comment.content }} - {{ getUserById(comment.user_id).name }}
          </li>
        </ul>
        <hr class="mt-4 mb-0">
      </div>
    </div>
  </div>
</div>

</template>


<style>
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
</style>
