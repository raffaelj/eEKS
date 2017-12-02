// JS for eEKS

////// pikaday calendar - https://github.com/dbushell/Pikaday

// i18n for pikaday
// var lang is set dynamically by eEKS via PHP
var i18n = {
    previousMonth : 'Previous Month',
    nextMonth     : 'Next Month',
    months        : ['January','February','March','April','May','June','July','August','September','October','November','December'],
    weekdays      : ['Sunday','Monday','Tuesday','Wednesday','Thursday','Friday','Saturday'],
    weekdaysShort : ['Sun','Mon','Tue','Wed','Thu','Fri','Sat']
    };
if( lang == "de-de" ){
  i18n = {
      previousMonth : 'Vorheriger Monat',
      nextMonth     : 'Nächster Monat',
      months        : ['Januar','Februar','März','April','Mai','Juni','Juli','August','September','Oktober','November','Dezember'],
      weekdays      : ['Sonntag','Montag','Dienstag','Mittwoch','Donnerstag','Freitag','Samstag'],
      weekdaysShort : ['So','Mo','Di','Mi','Do','Fr','Sa']
  }
}

// pikaday definitions
var date_input = document.querySelectorAll('input.date');
for(x in date_input) {
  if(date_input.hasOwnProperty(x)) {
    new Pikaday(
      {
        field: date_input[x]
      , firstDay: 1
      , numberOfMonths: 2
      , yearRange: [2015,2020]
      , keyboardInput: false
      , showDaysInNextAndPreviousMonths: true
      , enableSelectionDaysInNextAndPreviousMonths: true
      , format: date_out // var date_out is set dynamically by eEKS via PHP
      , toString(d, format) {
        
          // date format is set inside eEKS and has a format used py PHP strtotime function
          // it handles formats like "Y-m-d", "m/d/Y", "d.m.Y"
          
          var day = ("0" + d.getDate()).slice(-2);      // day with leading zero
          var month = ("0"+(d.getMonth()+1)).slice(-2); // month with leading zero
          var year = d.getFullYear();                   // year
          
          var datestring = format;
          datestring = datestring.replace("d", day);
          datestring = datestring.replace("m", month);
          datestring = datestring.replace("Y", year);
          
          return datestring
        }
      , i18n: i18n
      }).prevMonth();
  }
}
