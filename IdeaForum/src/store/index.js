import { createStore } from "vuex";
import axios from "axios";

export default createStore({
  state: {
    users: [],
    posts: [],
    comments: [],
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
        console.log("Fetched posts:", response.data);
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
  },
});