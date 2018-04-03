<template>
  <h1>Henlo {{ user.username }}</h1>
</template>
<script>
import { mapGetters, mapActions } from 'vuex'
export default {
  name: 'Dashboard',
  computed: {
    ...mapGetters(['user'])
  },
  methods: {
    ...mapActions(['fetchUser'])
  },
  mounted() {
    this.fetchUser()
  }
}
</script>
