<script setup>

import { useStore, useDispatch, computed } from "vuex";
import { onMounted } from "vue";

const store = useStore();
const dispatch = useDispatch();

// Fetch the data when the component is mounted
onMounted(() => {
  dispatch("fetchUsers");
  dispatch("fetchPosts");
  dispatch("fetchComments");
});

// Computed properties to get data from the store
const users = computed(() => store.state.users);
const posts = computed(() => store.state.posts);
const comments = computed(() => store.state.comments);

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

  <div>
    <div v-for="post in posts" :key="post.id">
      <h2>{{ post.title }}</h2>
      <p>{{ post.content }}</p>
      <h3>Comments:</h3>
      <ul>
        <li v-for="comment in getCommentsByPostId(post.id)" :key="comment.id">
          {{ comment.text }} - {{ getUserById(comment.user_id).name }}
        </li>
      </ul>
      <hr />
    </div>
  </div>

</template>


<style>

</style>
