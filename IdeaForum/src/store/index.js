import { createStore } from "vuex";
import axios from "axios";

export default createStore({
  state: {
    users: [],
    posts: [],
    comments: [],
    token: localStorage.getItem("token") || ""
  },
  actions: {
    async fetchUsers({ commit }) {
      try {
        const response = await axios.get("http://127.0.0.1:8000/api/users");
        commit("SET_USERS", response.data);
      } catch (error) {
        alert(error);
        console.log(error);
      }
    },
    async fetchPosts({ commit }) {
      try {
        const response = await axios.get("http://127.0.0.1:8000/api/posts");
        commit("SET_POSTS", response.data);
      } catch (error) {
        alert(error);
        console.log(error);
      }
    },
    async fetchComments({ commit }) {
      try {
        const response = await axios.get("http://127.0.0.1:8000/api/comments");
        commit("SET_COMMENTS", response.data);
      } catch (error) {
        alert(error);
        console.log(error);
      }
    },
    async deletePost({ commit }, postId) {
      try {
        const response = await axios.delete(`http://127.0.0.1:8000/api/posts/${postId}`);
        if (response.status === 204) {
          commit('DELETE_POST', postId); 
        }
      } catch (error) {
        alert(error);
        console.log(error);
      }
    },
    async login({ commit }, userInfo) {
      try{
        const response = await axios.post("http://127.0.0.1:8000/login", {
          email: userInfo.email,
          password: userInfo.password,
        });
        commit("SET_LOGGED_USER_ID", response.data.user_id);
        commit("SET_TOKEN", response.data.token);

        // Set token in Axios headers
        axios.defaults.headers.common["Authorization"] = `Bearer ${response.data.token}`;
        console.log(response.data.token);
        console.log(response.data.user_id);
        return true;
      } catch(error){
        alert('Error logging in: ' + error);
        console.log(error);
        return false;
      }
    }
  },
  mutations: {
    SET_USERS(state, users) {
      state.users = users;
    },
    SET_POSTS(state, posts) {
      state.posts = posts;
    },
    SET_COMMENTS(state, comments) {
      state.comments = comments;
    },
    DELETE_POST(state, postId) {
      state.posts = state.posts.filter(post => post.id !== postId);
    },
    SET_LOGGED_USER_ID(state, id){
      localStorage.setItem("user_id", id);
    },
    SET_TOKEN(state, token){
      localStorage.setItem("token", token);
      state.token = token;
    },
  },
});