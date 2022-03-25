<template>
    <router-view></router-view>
</template>

<script>
import Dashboard from './pages/Dashboard.vue'
export default {
  components: {
    'dash-component': Dashboard
  },
  mounted(){
    console.log(this.$route)
  }
};
</script>
