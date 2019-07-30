<template>
  <div>
    <div v-for="event in events" v-bind:key="event.id">
      <h5 class="m-2 mb-2 mt-4">{{ event.monthName }} {{ event.year }}</h5>
      <div v-for="day in event.days" v-bind:key="day.day">
        <div class="days rounded p-3 m-2 mb-2 shadow-sm" v-bind:class="{ 'active' : day.activated}">
          <span>{{ day.day }} {{ day.name }}</span>
          <span>{{ day.description }}</span>
        </div>
      </div>
    </div>
  </div>
</template>

<script>
export default {
  name: "Calendar",
  props: ["events"]
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


