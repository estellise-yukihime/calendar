<template>
  <div>
    <div class="form-group">
      <label for="month">Select Months</label>
      <select class="form-control" id="month" v-model="selectedMonth">
          <option v-for="event in events" v-bind:key="event.id" v-bind:value="event.nameOfMonth">
            {{ event.nameOfMonth }}
          </option>
      </select>
    </div>
    <div v-for="event in showEvents" v-bind:key="event.id" >
      <h5 class="m-2 mb-2 mt-4">{{ event.nameOfMonth }} {{ event.year }}</h5>
      <div v-for="day in event.eventDays" v-bind:key="day.day">
        <div class="days rounded p-3 m-2 mb-2 shadow-sm" v-bind:class="{ 'active' : day.activated}">
          <span>{{ day.day + " " + day.dayName }}</span>
          <span>{{ day.description }}</span>
        </div>
      </div>
    </div>
  </div>
</template>

<script>
export default {
  name: "Calendar",
  props: ["events"],
  data(){
    return {
      selectedMonth: null
    }
  },
  watch:{
    events: function(val){
      this.selectedMonth = val[0].nameOfMonth;
    }
  },
  computed: {
    showEvents: function(){
      return this.events.filter(event => event.nameOfMonth === this.selectedMonth);
    }
  }
};
</script>

<style scoped>
.active {
  background-color: #a1ec92;
}

.days > span:first-child {
  width: 100px;
  display: inline-block;
}
</style>


