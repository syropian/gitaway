<template>
  <vue-datepicker-local v-model="time" />
</template>
<script>
import VueDatepickerLocal from 'vue-datepicker-local'
export default {
  name: 'DatePicker',
  components: {
    VueDatepickerLocal
  }
}
</script>

