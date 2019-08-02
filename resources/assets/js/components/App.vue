<template>
  <div class="container shadow-lg p-3 mb-5 bg-white rounded mt-2">
    <div class="border-bottom mb-3">
      <h3>Calendar</h3>
    </div>

    <div class="clearfix">
      <div class="event">
        <eventpicker
          v-bind:date="date"
          v-on:change-date="catchNewDate"
          v-on:new-event="fetchNewEvents"
        ></eventpicker>
      </div>
      <div class="calendar">
        <calendar v-bind:events="events"></calendar>
      </div>
    </div>
    <notifications group="notify" :classes="notificationClasses" />
  </div>
</template>

<script>
import calendar from "./Calendar";
import eventpicker from "./EventPicker";
import axios from "axios";
import {formatObjectDate, daysInMonth, isInItem2, weeks} from "../helper";

export default {
  name: "App",
  components: {
    calendar,
    eventpicker
  },
  data() {
    let date = new Date();

    return {
      notificationClasses: null,
      date: [
        new Date(date.getFullYear(), date.getMonth(), 1),
        new Date(date.getFullYear(), date.getMonth() + 1, 0)
      ],
      events: []
    };
  },
  created() {
    this.fetchEvents();
  },
  methods: {

    catchNewDate(newDate) {
      this.date = newDate;
    },

    fetchNewEvents(newEvents) {
      let self = this;

      const { year, description, daysMonth } = newEvents;

      axios
        .post("api/events", {
          year,
          description,
          daysMonth
        })
        .then(res => res.data)
        .then(function(res) {

          self.events = [];
          self.showNotifications("notify", "success", "Success", "Successfully updated events");

          if (Array.isArray(res.data) && res.data.length !== 0) {
           
           let fromDate = formatObjectDate(res.data[0], 0)

            let toDate = formatObjectDate(res.data[res.data.length - 1], res.data[res.data.length - 1].eventDays.length - 1);

            self.catchEvents(res.data);
            self.catchDates(fromDate, toDate);
          }
        })
        .catch(function(err){
          self.showNotifications("notify", "error", "Error!", "Error updating events");
        });
    },

    fetchEvents() {
      let self = this;
      axios
        .get("api/events")
        .then(res => res.data)
        .then(function(res) {
          // new fetch api
          if (Array.isArray(res.data) && res.data.length !== 0) {
            
            let fromDate = formatObjectDate(res.data[0], 0)

            let toDate = formatObjectDate(res.data[res.data.length - 1], res.data[res.data.length - 1].eventDays.length - 1);

            self.catchEvents(res.data);
            self.catchDates(fromDate, toDate);
          }
        })
        .catch(err => console.log(err));
    },

    // catch the events related
    // 
    catchEvents(data) {

      this.events = [];

      let events = [];

      for (let i = 0; i < data.length; i++) {
        let event = {};

        event.id = i;
        event.year = data[i].year;
        event.month = data[i].month;
        event.nameOfMonth = data[i].nameOfMonth;
        event.totalDaysOfMonth = data[i].totalDaysOfMonth;

        event.eventDays = [];

        let date = new Date(data[i].year, data[i].month, "01");

        let index = i;

        for (let i = 1; i <= event.totalDaysOfMonth; i++) {

          date.setDate(date.getDate() + (i - 1));

          let eventDays = {};

          eventDays.day = i;
          eventDays.activated = false;
          eventDays.dayName = weeks[date.getDay()];

          for (let x = 0; x < data[index].eventDays.length; x++) {
            if (data[index].eventDays[x].day == i) {
              eventDays.dayName = data[index].eventDays[x].name;
              eventDays.activated = true;
              eventDays.description = data[index].eventDays[x].description;

              data[index].eventDays.splice(x, 1);

              x = data[index].eventDays.length;
            }
          }

          event.eventDays.push(eventDays);

        }
        events.push(event);
      }

      this.events = events;
    },

    // catch the dates in api
    catchDates(from, to) {
      this.date = [
        new Date(from.year, from.month, from.day),
        new Date(to.year, to.month, to.day)
      ];
    },
    
    showNotifications(group = "notify", type = "success", title = "", text = "", duration = 500, speed = 1000){
        this.notificationClasses = "vue-notification " + type;
        this.$notify({
          group: group,
          type: type,
          title: title,
          text: text
        });
    }
  }
};

</script>

<style scoped>

.vue-notification {
  padding: 10px;
  margin: 0 5px 5px;
 
  font-size: 12px;
 
  color: #ffffff;
  background: #44A4FC;
  border-left: 5px solid #187FE7;
 
  &.warn {
    background: #ffb648;
    border-left-color: #f48a06;
  }
 
  &.error {
    background: #E54D42;
    border-left-color: #B82E24;
  }
 
  &.success {
    background: #68CD86;
    border-left-color: #42A85F;
  }
}

</style>

