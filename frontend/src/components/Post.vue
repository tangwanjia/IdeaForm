<script setup>
const props = defineProps({
  msg: {
    type: String,
    required: true
  }
})
</script>

<template>
    <div class="idea-box">
      <h2 class="idea-title">Idea 1</h2>
      <p class="idea-text">{{props.msg}}</p>
      <div class="idea-info">
        <span class="comments">Comments: 10</span>
        <span class="posted-by">Posted by: John Doe</span>
      </div>
    </div>
</template>

<style scoped>

</style>
