<script setup>
import TheWelcome from '../components/TheWelcome.vue'
import { ref, onMounted, computed } from "vue";
import { useStore } from "vuex";

const store = useStore();

const getUsers = computed(() => {
  return store.getters.getUsers;
});

const users = computed(() => {
  return store.state.users;
});

onMounted(() => {
  store.dispatch("fetchUsers");
});
</script>

<template>
  <main>
    <body>
      <!-- Navbar -->
      <nav class="navbar navbar-expand navbar-dark bg-dark fixed-top">
        <a class="navbar-brand" href="#">Logo</a>
        <a class="navbar-brand" href="#">Home</a>
      </nav>
    
      <!-- Login Box -->
      <div class="container">
        <div class="login-box">
          <h2>Login</h2>
          <form>
            <div class="form-group">
              <label for="username">Username</label>
              <input type="text" class="form-control" id="username" placeholder="Enter username">
            </div>
            <div class="form-group">
              <label for="password">Password</label>
              <input type="password" class="form-control" id="password" placeholder="Enter password">
            </div>
            <button type="submit" class="btn btn-primary">Login</button>
          </form>
        </div>
      </div>
    
      <!-- Footer -->
      <footer class="fixed-bottom bg-light text-center">
        <p>&copy; Forum page. All rights reserved.</p>
      </footer>
    
        <div v-for="user in getUsers" :key="user.id">
            {{ user.id }} {{ user.name }}
        </div>
        
    </body>

  </main>
</template>
