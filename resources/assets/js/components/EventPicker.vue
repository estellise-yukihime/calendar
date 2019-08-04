<template>
  <div>
    <form @submit="newEvents">
      <div class="mb-3">
        <span>Event</span>
        <input
          type="text"
          v-model="description"
          class="form-control"
          maxlength="191"
          placeholder="Event"
        />
      </div>
      <date-picker v-model="dateProp" range lang="en" format="MM-DD" confirm class="w-90"></date-picker>

      <div class="mt-2 box">
        <input type="checkbox" id="mon" value="Mon" v-model="days" />
        <label for="mon">Mon</label>
        <input type="checkbox" id="tue" value="Tue" v-model="days" />
        <label for="tue">Tue</label>
        <input type="checkbox" id="wed" value="Wed" v-model="days" />
        <label for="wed">Wed</label>
        <input type="checkbox" id="thu" value="Thu" v-model="days" />
        <label for="thu">Thur</label>
        <input type="checkbox" id="fri" value="Fri" v-model="days" />
        <label for="fri">Fri</label>
        <input type="checkbox" id="sat" value="Sat" v-model="days" />
        <label for="sat">Sat</label>
        <input type="checkbox" id="sun" value="Sun" v-model="days" />
        <label for="sun">Sun</label>
      </div>
      <input type="submit" class="btn btn-primary" value="Save" />
    </form>
  </div>
</template>

<script>

import DatePicker from "vue2-datepicker";
import {daysInMonth, weeks} from "../helper";

export default {
  name: "EventPicker",
  components: {
    DatePicker
  },
  props: ["date"],
  data() {
    return {
      description: "",
      days: []
    };
  },
  methods: {
    newEvents(e) {
      e.preventDefault();

      let events = {}; 

      let startOfDate = this.date[0];
      let endOfDate = this.date[1];

      if(startOfDate !== null && endOfDate !== null)
      {
        events.year = new Date().getFullYear();
        events.description = this.description;
        events.daysMonth = [];

        for (let month = startOfDate.getMonth(); month <= endOfDate.getMonth(); month++){
          
          // plus 1, because month in javascript starts at 0;
          // carbon month in php starts at 1
          let date = new Date(events.year, month, "01");

          let totalDays = month == endOfDate.getMonth() ? endOfDate.getDate() : daysInMonth(date.getFullYear(), date.getMonth());

          let day = month == startOfDate.getMonth() ? startOfDate.getDate() : 1;

          for (; day <= totalDays; day++) {
            
            date.setDate(day);

            if (this.days.indexOf(weeks[date.getDay()]) != -1) {
              let dayMonth = [];

              // push month
              dayMonth.push(date.getMonth() + 1);

              // push day
              dayMonth.push(date.getDate());

              events.daysMonth.push(dayMonth);
            }
          }
        }
      }

      this.$emit("new-event", events);
    }
  },
  computed: {
    dateProp: {
      get: function() {
        return this.date;
      },
      set: function(newDate) {
        this.$emit("change-date", newDate);
      }
    }
  }
};

</script>

<style scoped>
.w-90 {
  width: 100%;
}

.box > label {
  margin-right: 8px;
}
</style>
