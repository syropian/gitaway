<template>
  <modal name="new-responder-modal" height="auto">
    <div class="flex items-center justify-between p-4 border-b border-grey-light">
      <h4>New Responder</h4>
      <button class="text-2xl focus-none" @click="closeModal">&times;</button>
    </div>
    <form action="" class="p-4">
      <div class="mb-4">
        <label class="block text-grey-darker text-sm font-bold mb-2" for="r-title">
          Title
        </label>
        <input class="appearance-none border-2 border-grey-light focus:border-brand hover:border-grey rounded py-2 px-4 w-full text-grey-darker transition-color-bg-border focus-none" id="r-title" type="text" placeholder="Trip to Toronto">
      </div>
      <div class="mb-4">
        <label class="block text-grey-darker text-sm font-bold mb-2" for="r-message">
          Message
        </label>
        <textarea class="appearance-none border-2 border-grey-light focus:border-brand hover:border-grey rounded py-2 px-4 w-full text-grey-darker transition-color-bg-border focus-none" rows="8" id="r-message" type="text" placeholder="Add a message..."></textarea>
      </div>
      <div class="flex mb-8">
        <div class="w-1/2 pr-2">
          <label class="block text-grey-darker text-sm font-bold mb-2" for="r-start-date">
            Start Date
          </label>
          <vue-datepicker-local v-model="startDate" format="YYYY-MM-DD HH:mm:ss" class="w-full" :local="local"></vue-datepicker-local>
        </div>
        <div class="w-1/2 pl-2">
          <label class="block text-grey-darker text-sm font-bold mb-2" for="r-start-date">
            End Date
          </label>
          <vue-datepicker-local v-model="endDate" format="YYYY-MM-DD HH:mm:ss" class="w-full" :local="local"></vue-datepicker-local>
        </div>
      </div>
      <div class="mt-8 mb-4 flex">
        <button @click.prevent="closeModal" class="transition-bg bg-grey-light hover:bg-grey text-grey-darkest text-sm font-bold py-2 px-4 mr-4 rounded ml-auto ">Cancel</button>
        <button type="submit" class="transition-bg bg-green hover:bg-green-dark text-white text-sm font-bold py-2 px-4 rounded">Save Responder</button>
      </div>
    </form>
  </modal>
</template>
<script>
import VueDatepickerLocal from 'vue-datepicker-local'
import { DateTime } from 'luxon'
export default {
  name: 'NewResponderModal',
  components: {
    VueDatepickerLocal
  },
  data() {
    return {
      startDate: DateTime.local(),
      endDate: DateTime.local().plus({ days: 1 }),
       local: {
          dow: 0,
          hourTip: 'Select Hour',
          secondTip: 'Select Second',
          minuteTip: 'Select Minute',
          yearSuffix: '',
          monthsHead: 'January_February_March_April_May_June_July_August_September_October_November_December'.split('_'),
          months: 'Jan_Feb_Mar_Apr_May_Jun_Jul_Aug_Sep_Oct_Nov_Dec'.split('_'),
          weeks: 'Su_Mo_Tu_We_Th_Fr_Sa'.split('_'),
          cancelTip: 'cancel',
          submitTip: 'confirm'
      }
    }
  },
  methods: {
    closeModal() {
      this.$modal.hide('new-responder-modal')
    }
  }
}
</script>
<style lang="scss">
.v--modal-overlay .v--modal-box {
  overflow: unset !important;
}

.datepicker > input {
  border-width: 2px !important;
  border-color: config("colors.grey-light");
  border-radius: 0.25rem;
  &:hover {
    border-color: config("colors.grey");
  }
  &.focus {
    border-color: config("colors.brand") !important;
  }
}
</style>

