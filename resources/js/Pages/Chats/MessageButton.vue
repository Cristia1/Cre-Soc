<template>
    <div v-if="canSendMessage">
      <button class="sendMessage" @click="sendMessage">
        📩 Send Message
      </button>
    </div>
  </template>
  
  <script>
  export default {
    props: {
      currentUserId: {
        type: [String, Number],
        required: true,
      },
      profileUserId: {
        type: [String, Number],
        required: true,
      },
    },
    computed: {
      canSendMessage() {
        // Afișăm butonul doar dacă utilizatorul curent este diferit de proprietarul profilului
        return this.currentUserId !== this.profileUserId;
      },
    },
    methods: {
      sendMessage() {
        // Logica de trimitere a mesajului sau de deschidere a unei ferestre de chat
        this.$emit('openChat', this.profileUserId); // Emite un eveniment către părinte pentru a deschide fereastra de chat
      },
    },
  };
  </script>
  
  <style scoped>
  .sendMessage {
    background: rgb(30, 28, 28);
    color: white;
    border-radius: 10px; /* Colțuri rotunjite */
    padding: 10px 20px;
    border: none;
    cursor: pointer;
    font-size: 16px;
    font-weight: bold;
    text-align: center;
    transition: background-color 0.3s ease;
  }
  
  .sendMessage:hover {
    background-color: rgb(50, 50, 50);
  }
  </style>
  