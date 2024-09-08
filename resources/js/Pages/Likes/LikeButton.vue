<template>
    <div>
      <button @click="toggleLike">
        <span v-if="liked">&#128077; Unlike</span>
        <span v-else>&#128077; Like</span>
      </button>
      <span>{{ likesCount }} likes</span>
    </div>
  </template>
  
  <script>
  import axios from 'axios';
  
  export default {
    props: {
      itemId: {
        type: Number,
        required: true,
        default: 0,
      },
      itemType: {
        type: String,
        required: true
      },
      initialLiked: {
        type: Boolean,
        required: true
      },
      initialLikesCount: {
        type: Number,
        required: true
      },
    },
    data() {
      return {
        liked: this.initialLiked,
        likesCount: this.initialLikesCount,
      };
    },
    methods: {
      async toggleLike() {
        try {
          if (this.liked) {
            await axios.delete(`/api/${this.itemType}/${this.itemId}/unlike`);
            this.liked = false;
            this.likesCount--;
          } else {
            await axios.post(`/api/${this.itemType}/${this.itemId}/like`);
            this.liked = true;
            this.likesCount++;
          }
        } catch (error) {
          console.error('Error toggling like:', error);
        }
      }
    }
  };
  </script>