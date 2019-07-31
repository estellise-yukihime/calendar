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
          v-on:new-event="catchNewEvents"
        ></eventpicker>
      </div>
      <div class="calendar">
        <calendar v-bind:events="events"></calendar>
      </div>
    </div>
  </div>
</template>

<script>
import calendar from "./Calendar";
import eventpicker from "./EventPicker";
import axios from "axios";

export default {
  name: "App",
  components: {
    calendar,
    eventpicker
  },
  data() {
    let date = new Date();

    return {
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
    catchNewEvents(newEvents) {
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
          if (Array.isArray(res.data) && res.data.length !== 0) {
            self.catchEvents(res.data);
            self.dates(res.data);
          }
        })
        .catch(err => console.log(err));
    },

    catchNewDate(newDate) {
      this.date = newDate;
    },

    dates(data) {
      let fromStr = data[0]["month_year"] + "-" + data[0]["day_number"];
      let toStr =
        data[data.length - 1]["month_year"] +
        "-" +
        data[data.length - 1]["day_number"];

      fromStr = fromStr.split("-");
      toStr = toStr.split("-");

      this.date = [
        new Date(fromStr[0], fromStr[1] - 1, fromStr[2]),
        new Date(toStr[0], toStr[1] - 1, toStr[2])
      ];
    },

    fetchEvents() {
      let self = this;
      axios
        .get("api/events")
        .then(res => res.data)
        .then(function(res) {
          // new fetch api
          /*
          let data = res.data;
          let events = [];

          console.log(data);

          for (let i = 0; i < data.length; i++) {
            let event = {};

            event.year = data[i].year;
            event.month = data[i].month;
            event.nameOfMonth = data[i].nameOfMonth;

            event.eventDays = [];

            for (let i = 1; i <= event.totalDaysOfMonth; i++) {
              let eventDays = {};

              eventDays.day = i;
              eventDays.activated = false;

              for (let x = 0; x < data[i].eventDays.length; x++) {
                if (data[i].eventDays[x].day == i) {
                  eventDays.activated = true;
                  eventDays.description = data[i].eventDays[x].description;
                  break;
                }
              }
            }
          }
          */
          //if (Array.isArray(res.data) && res.data.length !== 0) {
          //  self.catchEvents(res.data);
          //  self.dates(res.data);
          //}
        })
        .catch(err => console.log(err));
    },

    catchEvents(data) {
      let activatedDays = [];
      let ym = [];
      let x;

      let nameOfDays = ["Sun", "Mon", "Tue", "Wed", "Thu", "Fri", "Sat"];

      for (x in data) {
        if (!isInItem2(ym, [data[x]["month_year"], data[x]["month_name"]])) {
          ym.push([data[x]["month_year"], data[x]["month_name"]]);
        }

        activatedDays.push([
          data[x]["year"],
          data[x]["month_number"],
          data[x]["day_number"],
          data[x]["description"]
        ]);
      }

      for (x in ym) {
        let strDate = ym[x][0].split("-");
        let date = new Date(strDate[0], strDate[1] - 1, "01");

        let days = daysInMonth(date.getMonth() + 1, date.getFullYear());

        let event = {};

        event.id = x;
        event.year = strDate[0];
        event.month = strDate[1];
        event.monthName = ym[x][1];
        event.days = [];

        date.setDate(date.getDate() - 1);

        for (let i = 0; i < days; i++) {
          date.setDate(date.getDate() + 1);

          let day = {};

          day.day = date.getDate();
          day.name = nameOfDays[date.getDay()];
          day.description = "";
          day.activated = false;

          for (let i = 0; i < activatedDays.length; i++) {
            if (
              activatedDays[i][0] == strDate[0] &&
              activatedDays[i][1] == strDate[1] &&
              activatedDays[i][2] == date.getDate()
            ) {
              day.activated = true;
              day.description = activatedDays[i][3];
            }
          }

          event.days.push(day);
        }

        this.events = [...this.events, event];
      }
    }
  }
};

function daysInMonth(month, year) {
  return new Date(year, month, 0).getDate();
}

function isInItem2(array, item) {
  for (var i = 0; i < array.length; i++) {
    // This if statement depends on the format of your array
    if (array[i][0] == item[0] && array[i][1] == item[1]) {
      return true; // Found it
    }
  }
  return false; // Not found
}
</script>

