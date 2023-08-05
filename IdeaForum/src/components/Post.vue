<script setup>
defineProps({
  msg: {
    type: String,
    required: true
  }
})
</script>

<template>
    <div class="idea-box">
      <h2 class="idea-title">Idea 1</h2>
      <p class="idea-text">This is the description of Idea 1.</p>
      <div class="idea-info">
        <span class="comments">Comments: 10</span>
        <button class="vote-button" onclick="upvote(this)">👍</button>
        <span class="upvotes">25</span>
        <button class="vote-button" onclick="downvote(this)">👎</button>
        <span class="downvotes">5</span>
        <span class="posted-by">Posted by: John Doe</span>
      </div>
    </div>
</template>

<style scoped>

</style>
