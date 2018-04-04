<template>
  <div class="responders-manager mx-auto px-4">
    <div class="flex justify-between items-center pb-4 border-b-2 border-grey-light">
      <h3>Your Responders</h3>
      <button class="bg-brand hover:bg-brand-dark text-white text-sm font-bold py-2 px-4 rounded" @click="showNewResponderModal">Add New</button>
      <new-responder-modal></new-responder-modal>
    </div>
  </div>
</template>
<script>
import NewResponderModal from '@/components/NewResponderModal'
export default {
  name: 'RespondersManager',
  components: {
    NewResponderModal
  },
  methods: {
    showNewResponderModal() {
      this.$modal.show('new-responder-modal')
    }
  }
}
</script>

<style lang="scss">
.responders-manager {
  margin-top: 100px;
  max-width: 600px;
  width: 100%;
}
</style>

