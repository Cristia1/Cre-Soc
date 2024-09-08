<template>

</template>

<script>
import axios from 'axios';

export default {
  data() {
    return {
      userId: null,
    };
  },
  mounted() {
    const userIdMeta = document.querySelector('meta[name="user-id"]');
    
    if (userIdMeta) {
      this.userId = userIdMeta.content;
      this.$emit('user-id-received', this.userId);
    }

    if (!this.userId) {
      axios.get('/user-id')
        .then(response => {
          this.userId = response.data.userId;
          // console.log('User ID from API:', this.userId);
          this.$emit('user-id-received', this.userId);
        })
        .catch(error => {
          console.error('Error fetching user ID:', error);
        });
    }
  },
};
</script>