<script setup>
  import { useStore } from 'vuex';
  import { ref } from 'vue';
  import { useRouter } from 'vue-router';

  const store = useStore();
  const router = useRouter();

  const email = ref('');
  const password = ref('');

  const login = async () => {
    const userInfo = { email: email.value, password: password.value };
    const success = await store.dispatch('login', userInfo);
    if (success) {
      router.push({ name: 'home' }); // Redirect to home after successful login
    }
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
          <div class="collapse navbar-collapse" id="navbarNav">
            <ul class="navbar-nav">
              <li class="nav-item">
                <a class="nav-link active" aria-current="page" href="#">Home</a>
              </li>
            </ul>
          </div>
          <button @click="goToCreatePost" class="btn btn-success ms-auto me-2 p-lg-2">
             Create New Post
          </button>
          <button @click="goToLogin" class="btn btn-success ms-auto me-2 p-lg-2">
            Login
          </button>
        </div>
  </nav>

  <!-- Main Header -->
  <div class="p-5 text-center border-bottom">
      <h1>PHP Forum</h1>
      <p>
        A large equal forum to talk about PHP, in order to help one another learn PHP language. <br>
        Login to catch more important and useful information.
      </p>
  </div>

  <div class="container">
    <h1>Login</h1>
    <form @submit.prevent="login">
      <div class="mb-3">
        <label for="email" class="form-label">Email</label>
        <input v-model="email" type="email" class="form-control" id="email" required>
      </div>
      <div class="mb-3">
        <label for="password" class="form-label">Password</label>
        <input v-model="password" type="password" class="form-control" id="password" required>
      </div>
      <button type="submit" class="btn btn-primary">Login</button>
    </form>
  </div>

  <!-- Footer -->
  <footer class="bg-dark text-lg-start text-white">
      <p class="text-uppercase text-end"><i class="fas fa-at fa-fw fa-sm me-2">PHP Forum</i></p>
      <p class="text-uppercase text-end"><i class="fas fa-at fa-fw fa-sm me-2">Tel:12345678</i></p>
      <p class="text-uppercase text-end"><i class="fas fa-at fa-fw fa-sm me-2">Address:Ottawa,ON</i></p>
    
      <!-- Copyright -->
      <div class="text-center p-3" style="background-color: rgba(0, 0, 0, 0.2)">
        © 2023 Copyright:
        <a class="text-white" href="#">phpforum.com</a>
      </div>
      <!-- Copyright -->
    </footer>
  </div>

</template>

<style>
*{
  font-family: Arial, Helvetica, sans-serif;
}
.page-container {
      display: flex;
      flex-direction: column;
      height: 100%;
}

</style>
