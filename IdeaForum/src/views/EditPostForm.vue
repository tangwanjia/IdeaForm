<script setup>
import axios from 'axios';
import { useRouter } from 'vue-router';

const router = useRouter();
const postId = router.params.postId;

const editedPost = computed(() => {
  return store.state.posts.find(post => post.id === postId) || { title: '', content: '' };
});

const updatePost = async () => {
  try {
    const response = await axios.put(`http://127.0.0.1:8000/api/posts/${postId}`, editedPost.value);
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
</script>

<template>
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
</template>
