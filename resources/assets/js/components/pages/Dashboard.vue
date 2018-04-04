<template>
  <div class="dashboard">
    <navbar></navbar>
    <responders-manager></responders-manager>
  </div>
</template>
<script>
import { mapActions } from 'vuex'
import Navbar from '@/components/Navbar'
import RespondersManager from '@/components/RespondersManager'
export default {
  name: 'Dashboard',
  components: {
    Navbar,
    RespondersManager
  },
  methods: {
    ...mapActions(['fetchUser'])
  },
  mounted() {
    this.fetchUser()
  }
}
</script>
