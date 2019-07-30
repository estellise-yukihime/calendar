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
      <!-- <div class="mb-2 clearfix">
        <div class="float-left mr-4 date-div">
          <span class="d-block">From</span>
          <date-picker
            v-model="fromDate"
            lang="en"
            type="date"
            format="YYYY-MM-dd"
            class="date-picker"
            confirm
          ></date-picker>
        </div>
        <div class="float-left date-div">
          <span class="d-block">To</span>
          <date-picker
            v-model="toDate"
            lang="en"
            type="date"
            format="YYYY-MM-dd"
            class="date-picker"
            disable="disableDates"
          ></date-picker>
        </div>
      </div>-->
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

      let nameOfDays = ["Sun", "Mon", "Tue", "Wed", "Thu", "Fri", "Sat"];

      let startOfDate = this.date[0];
      let endOfDate = this.date[1];

      events.year = startOfDate.getFullYear();
      events.description = this.description;
      events.daysMonth = [];

      for (
        let month = startOfDate.getMonth();
        month <= endOfDate.getMonth();
        month++
      ) {
        let date = new Date(events.year, month + 1, 0);

        let totalDays = daysInMonth(date.getMonth(), date.getFullYear());

        for (let day = startOfDate.getDate() - 1; day <= totalDays; day++) {
          date.setDate(day + 1);

          if (this.days.indexOf(nameOfDays[date.getDay()]) != -1) {
            let dayMonth = [];

            dayMonth.push(date.getMonth() + 1);

            dayMonth.push(date.getDate());

            events.daysMonth.push(dayMonth);
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

function daysInMonth(month, year) {
  return new Date(year, month, 0).getDate();
}
</script>

<style scoped>
.w-90 {
  width: 100%;
}

.box > label {
  margin-right: 8px;
}
</style>
