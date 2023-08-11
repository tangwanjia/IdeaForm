<script setup>
  import { useStore } from 'vuex';
  import { ref, computed } from 'vue';
  import { useRouter } from 'vue-router';

  const store = useStore();
  const router = useRouter();

  const email = ref('');
  const password = ref('');
  const showEmailValidation = ref(false);
  const showPasswordValidation = ref(false);

  const isValidEmail = (email) => {
    const emailPattern = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
    return emailPattern.test(email);
  };

  const isEmailValid = computed(() => isValidEmail(email.value));
  const isPasswordValid = computed(() => password.value !== '');

  const login = async () => {
    showEmailValidation.value = true;
    showPasswordValidation.value = true;
    if (!isEmailValid.value || !isPasswordValid.value) {
      return;
    }
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
          <a class="navbar-brand">PHP</a>
          <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav"
            aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
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

  <!-- Login Form -->
  <div class="container login-form">
    <h1 class="text-center">Login</h1>
    <form @submit.prevent="login">
      <div class="mb-3">
        <label for="email" class="form-label">Email</label>
        <input v-model="email" type="email" class="form-control" id="email">
        <div class="text-danger" v-if="showEmailValidation && !isEmailValid">Please enter a valid email address.</div>
      </div>
      <div class="mb-3">
        <label for="password" class="form-label">Password</label>
        <input v-model="password" type="password" class="form-control" id="password">
        <div class="text-danger" v-if="showPasswordValidation && !isPasswordValid">Password is required.</div>
      </div>
      <div class="text-center">
        <button type="submit" class="btn btn-primary">Login</button>
      </div>
    </form>
  </div>

  <!-- Footer -->
  <footer class="bg-dark text-lg-start text-white mt-4">
      <!-- Copyright -->
      <div class="text-center p-3" style="background-color: rgba(0, 0, 0, 0.2)">
        © 2023 Copyright: phpforum.com
      </div>
    </footer>
  </div>

</template>

<style>
*{
  font-family: Arial, Helvetica, sans-serif;
  font-size: 20px;
  margin: 0;
  padding: 0;
  box-sizing: border-box;
}

.page-container {
  display: flex;
  flex-direction: column;
  min-height: 100vh;
}

.login-form {
  display: flex;
  flex-direction: column;
  justify-content: center;
  align-items: center;
  flex: 1;
  padding: 20px;
}

.login-form form {
  max-width: 300px;
  width: 100%;
}

.login-form .mb-3 {
  margin-bottom: 10px;
}

.login-form .form-label {
  display: inline-block;
  margin-bottom: 5px;
}

footer {
  margin-top: auto;
}

.text-danger.d-none {
  display: none;
}

</style>
