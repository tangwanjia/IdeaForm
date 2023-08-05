const baseUrl = 'http://127.0.0.1:8000'

const app = Vue.createApp({
  data: function () {
    return {
      title: 'Notebook',
      token: '',
      user: {},
      notes: [],
      showNewNote: false,
      showEditNote: false,
      loginForm: {
        email: '',
        password: ''
      },
      noteForm: {
        title: '',
        content: ''
      },
      editForm: {
        title: '',
        content: ''
      }
    }
  },
  created: async function () { 
    this.token = sessionStorage.getItem('token') || '';
    this.user = JSON.parse(sessionStorage.getItem('user') || {});

    this.getNotes();
  },
  methods: {
    login: async function () {
      try{
        const response = await fetch(`${baseUrl}/login`, {
          method: 'post',
          headers:{
            'Content-Type': 'application/json',
            'Accept': 'application/json'
          },
          body: JSON.stringify(this.loginForm)
        })

        const json = await response.json();
        this.token = json.token;
        this.user = json.user;
        sessionStorage.setItem('token', this.token);
        sessionStorage.setItem('user', JSON.stringify(this.user));

        this.getNotes()

      }catch(error){
        console.log(error);
      }
    },
    getNotes: async function () {
      try{
        if(this.user.id && this.token){
          const response = await fetch(`${baseUrl}/api/users/${this.user.id}/notes`, {
            method: 'get',
            headers:{
              'Accept': 'application/json',
              'Authorization': `Bearer ${this.token}`
            }
          })

          this.notes = await response.json();
        }

      }catch(error){
        console.log(error)
      }
    },
    addNote: async function () {
      try{
        const response = await fetch(`${baseUrl}/api/users/${this.user.id}/notes`, {
          method: 'post',
          headers:{
            'Content-Type': 'application/json',
            'Accept': 'application/json',
            'Authorization': `Bearer ${this.token}`
          },
          body: JSON.stringify(this.noteForm)
        })

        const json = await response.json();
        this.notes.push(json);
        this.showNewNote = false;

      }catch(error){
        console.log(error)
      }
    },
    editNote: function (note) {
      
    },
    updateNote: async function () {

    },
    deleteNote: async function (note) {
      
    },
    logout: async function () {
      
    }

  }
})

app.mount('#app')