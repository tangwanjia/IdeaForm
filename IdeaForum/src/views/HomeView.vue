<script setup>

import { useStore} from "vuex";
import { onMounted, computed } from "vue";
import { useRouter } from 'vue-router';
import axios from 'axios';

const router = useRouter();

const goToCreatePost = () => {
  router.push({ name: 'create-post' });
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

const newComment = ref('');

const submitComment = async (postId) => {
  try {
    const response = await axios.post('http://127.0.0.1:8000/api/comments', {
      post_id: postId,
      content: newComment.value,
      user_id: 1, // Set the user_id as needed
    });
    if (response.status === 201) {
      store.dispatch("fetchComments"); // Fetch updated comments
      newComment.value = ''; // Clear the comment field
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
            <button @click="editComment(comment.id)" class="btn btn-primary btn-sm">Edit</button>
            <button @click="deleteComment(comment.id)" class="btn btn-danger btn-sm">Delete</button>
          </li>
        </ul>
        <form @submit.prevent="submitComment(post.id)">
          <div class="mb-3">
            <label for="comment" class="form-label">Post a Comment</label>
            <textarea v-model="newComment" class="form-control" id="comment" rows="2" required></textarea>
          </div>
          <button type="submit" class="btn btn-primary">Post Comment</button>
        </form>
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
