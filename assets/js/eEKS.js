// JS for eEKS

////// pikaday calendar - https://github.com/dbushell/Pikaday

// i18n for pikaday
// var lang is set dynamically by eEKS via PHP
let i18n = {
    previousMonth : 'Previous Month',
    nextMonth     : 'Next Month',
    months        : ['January','February','March','April','May','June','July','August','September','October','November','December'],
    weekdays      : ['Sunday','Monday','Tuesday','Wednesday','Thursday','Friday','Saturday'],
    weekdaysShort : ['Sun','Mon','Tue','Wed','Thu','Fri','Sat']
    };
if(lang == "de-de") {
  i18n = {
      previousMonth : 'Vorheriger Monat',
      nextMonth     : 'Nächster Monat',
      months        : ['Januar','Februar','März','April','Mai','Juni','Juli','August','September','Oktober','November','Dezember'],
      weekdays      : ['Sonntag','Montag','Dienstag','Mittwoch','Donnerstag','Freitag','Samstag'],
      weekdaysShort : ['So','Mo','Di','Mi','Do','Fr','Sa']
  }
}

// pikaday definitions
const yearRangeUpper = new Date().getFullYear() + 1;
const dateInputFields = document.querySelectorAll('input.date');

dateInputFields.forEach(el => {
    new Pikaday({
        field: el,
        firstDay: 1,
        numberOfMonths: 2,
        yearRange: [2015, yearRangeUpper],
        keyboardInput: false,
        showDaysInNextAndPreviousMonths: true,
        enableSelectionDaysInNextAndPreviousMonths: true,
        format: 'd.m.Y',
        toString(d, format) {

            // date format was set inside eEKS and has a format used py PHP strtotime function
            // it handles formats like "Y-m-d", "m/d/Y", "d.m.Y"
            // now it is hard coded

            var day = ("0" + d.getDate()).slice(-2);      // day with leading zero
            var month = ("0"+(d.getMonth()+1)).slice(-2); // month with leading zero
            var year = d.getFullYear();                   // year

            var datestring = format;
            datestring = datestring.replace("d", day);
            datestring = datestring.replace("m", month);
            datestring = datestring.replace("Y", year);

            return datestring
            },
        parse(dateString, format) {

            const parts = dateString.split('.');

            const day   = parseInt(parts[0], 10);
            const month = parseInt(parts[1], 10) - 1;
            const year  = parseInt(parts[2], 10);
            return new Date(year, month, day);
        },
        i18n: i18n,
      }).prevMonth();
});
