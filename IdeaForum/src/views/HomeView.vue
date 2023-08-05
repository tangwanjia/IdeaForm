<script setup>
import TheWelcome from '../components/TheWelcome.vue'
import Post from '../components/Post.vue'
</script>

<template>
  <div>
    <Post v-for="x in 3"></Post>
  </div>
  
</template>
