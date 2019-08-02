
export const weeks = ["Sun", "Mon", "Tue", "Wed", "Thu", "Fri", "Sat"];

// format api to object that accepts year, month, and day
export function formatObjectDate(data, eventDaysIndex){

    let date = {
        year: data.year,
        month: data.month - 1,
        day: data.eventDays.length ? data.eventDays[eventDaysIndex].day : "01"
    };

    return date;
}

export function daysInMonth(year, month) {
    return new Date(year, month, "00").getDate();
}

export function isInItem2(array, item) {
    for (var i = 0; i < array.length; i++) {
        // This if statement depends on the format of your array
        if (array[i][0] == item[0] && array[i][1] == item[1]) {
        return true; // Found it
        }
    }
    return false; // Not found
}
  