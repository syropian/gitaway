<template>
<div class="navbar bg-brand h-12 flex text-white items-center justify-between px-4">
  <h3>Gitaway</h3>
  <span class="user">Hey {{ user.username }}!</span>
</div>
</template>
<script>
import { mapGetters } from 'vuex'
export default {
  name: 'Navbar',
  computed: {
    ...mapGetters(['user'])
  }
}
</script>

