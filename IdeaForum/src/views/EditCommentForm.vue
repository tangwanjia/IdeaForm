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
  try {
    const commentId = Number(route.params.commentId);
    const response = await axios.put(`http://127.0.0.1:8000/api/comments/${commentId}`, editedComment.value);
    if (response.status === 200) {
      store.dispatch('fetchComments'); // Fetch updated comments
      router.push('/'); // Redirect back to the main page
      alert('Comment updated successfully!');
    } else {
      alert('Error updating comment: Unable to update the comment.');
    }
  } catch (error) {
    alert('Error updating comment: ' + error);
  }
};
</script>

<template>
    <div class="container">
      <h1 class="text-center mt-4">Edit Comment</h1>
      <div class="comment-box border mt-4 p-3">
        <form @submit.prevent="updateComment">
          <div class="mb-3">
            <label for="content" class="form-label">Comment</label>
            <textarea v-model="editedComment.content" class="form-control" id="content" rows="4" required></textarea>
          </div>
          <button type="submit" class="btn btn-primary">Update Comment</button>
        </form>
      </div>
    </div>
</template>
  
<style>
  .comment-box {
    background-color: white;
    border: 1px solid #ddd;
    border-radius: 5px;
    padding: 15px;
    box-shadow: 0px 2px 4px rgba(0, 0, 0, 0.1);
  }
</style>