<?php

STATIC $n=0;

/* In this scenario, it is assumed that $user is a predefined object with a preloaded list of events 
   Add a condition to your implementation to check whether or not your user is valid */
if($user == true){
	$dates = array();
	$url = array();
	$i = 0;
	foreach($user->get_events as $userEvent) {

    /* For each event, add an entry into your date and URL array*/
    $dates[$i] = $userEvent->event()->date;
		$url[$i] = 'yourUsersEventlink.php?event='.$userEvent->event()->id;

    // It is recommended to add conditions to check the event type if further styling or specific URLs must be implemented
    $i++;
	}
}

?>

<style>
@main-bg:rgb(40,40,59);
@calendar-border:rgb(220,220,255);
@calendar-bg:#fff;
@calendar-standout:rgb(40,40,59);
@calendar-color:#444;
@calendar-fade-color:#c0c0c0;
@body-color:#444;
#btnPrev {
  float:left;
  font-size: 14px;
  margin-bottom:20px;
  &:before {
    content:'\f104';
    font-family:FontAwesome;
    padding-right:4px;
  }
}
#btnNext {
  float:right;
  font-size: 14px;
  margin-bottom:20px;
  &:after {
    content:'\f105';
    font-family:FontAwesome;
    padding-left:4px;
  }
}
#btnPrev, #btnNext {
  background:transparent;
  border:none;
  outline:none;
  font-size: 14px;
  color:@calendar-fade-color;
  cursor:pointer;
  font-family:"Roboto Condensed", sans-serif;
  text-transform:uppercase;
  transition:all 0.3s ease;
  &:hover {
    color:@calendar-standout;
    font-weight:bold;
  }
}
body {
  font-size:100%;
  line-height:1.5;
  background:@main-bg;
  background-image:linear-gradient(@main-bg 0%, darken(@main-bg,12%) 100%);
  color:@body-color;
}

*, *:before, *:after {
  box-sizing:border-box;
}

.group {
  &:after {
    content: "";
    display: table;
    clear: both;
  }
}

img {
  max-width:100%;
  height:auto;
  vertical-align:baseline;
}

a {
  text-decoration:none;
}




.calendar-wrapper {
  height: 10px;
  width:500px;
  margin:3em auto;
  padding:2em;
  border:1px solid @calendar-border;
  border-radius:5px;
  background:@calendar-bg;

}
table {
  clear:both;
  width:100%;
  font-size: 14px;
text-align: center;
  border:1px solid @calendar-border;
  border-radius:3px;
  border-collapse:collapse;
  color:@calendar-color;
}
td {
  height:48px;
  text-align:center;
  vertical-align:middle;
  border-right:1px solid @calendar-border;
  border-top:1px solid @calendar-border;
  width:14.2857143%;
}
td.not-current {
  color:@calendar-fade-color;;
}
td.normal {}
td.today {
  color:#3A67A8;
  font-size:1.5em;
}
td.special {
  font-weight:700;
  color:#AA4401;
  font-size:1.5em;
}

thead td {
  border:none;
  color:@calendar-standout;
  text-transform:uppercase;
  font-size:1.5em;
}
@media only screen and (min-width:200px) and (max-width: 300px) {
table td, table th { font-size:7.5px; }
}
@media only screen and (min-width:300px) and (max-width: 325px) {
table td, table th { font-size:8px; }
}
@media only screen and (min-width:325px) and (max-width: 350px) {
table td, table th { font-size:9px; }
}
@media only screen and (min-width:350px) and ( max-width: 450px) {
table td, table th { font-size:12px; }
}

</style>

<script>

var Cal = function(divId) {

  //Store div id
  this.divId = divId;

  // Days of week, starting on Sunday
  this.DaysOfWeek = [
    'Sun',
    'Mon',
    'Tue',
    'Wed',
    'Thu',
    'Fri',
    'Sat'
  ];

  // Months, stating on January
  this.Months = ['January', 'February', 'March', 'April', 'May', 'June', 'July', 'August', 'September', 'October', 'November', 'December' ];

  // Set the current month, year
  var d = new Date();

  this.currMonth = d.getMonth();
  this.currYear = d.getFullYear();
  this.currDay = d.getDate();

};

// Goes to next month
Cal.prototype.nextMonth = function() {
  if ( this.currMonth == 11 ) {
    this.currMonth = 0;
    this.currYear = this.currYear + 1;
  }
  else {
    this.currMonth = this.currMonth + 1;
  }
  this.showcurr();
};

// Goes to previous month
Cal.prototype.previousMonth = function() {
  if ( this.currMonth == 0 ) {
    this.currMonth = 11;
    this.currYear = this.currYear - 1;
  }
  else {
    this.currMonth = this.currMonth - 1;
  }
  this.showcurr();
};

// Show current month
Cal.prototype.showcurr = function() {
  this.showMonth(this.currYear, this.currMonth);
};

// Show month (year, month)
Cal.prototype.showMonth = function(y, m) {

  var d = new Date()
  // First day of the week in the selected month
  , firstDayOfMonth = new Date(y, m, 1).getDay()
  // Last day of the selected month
  , lastDateOfMonth =  new Date(y, m+1, 0).getDate()
  // Last day of the previous month
  , lastDayOfLastMonth = m == 0 ? new Date(y-1, 11, 0).getDate() : new Date(y, m, 0).getDate();


  var html = '<table>';

  // Write selected month and year
  html += '<thead ><tr  style="height:48px">';
  html += '<td colspan="7" style="color:#AA4401; font-weight:800; font-size: 22px; text-align: center; width: 100%">' + this.Months[m] + ' ' + y + '</td>';
  html += '</tr></thead>';

  html += '<tbody style="height: 338px">';
  // Write the header of the days of the week
  html += '<tr class="days"  style="height:48px">';
  for(var i=0; i < this.DaysOfWeek.length;i++) {
    html += '<td style="font-weight:bold; width:14.2857143%;">' + this.DaysOfWeek[i] + '</td>';
  }
  html += '</tr>';

  // Write the days
  var i=1;
  var n=0;
  do {

    var dow = new Date(y, m, i).getDay();

    // If Sunday, start new row
    if ( dow == 0 ) {
      html += '<tr  style="height:48px">';
    }
    // If not Sunday but first day of the month
    // it will write the last days from the previous month
    else if ( i == 1 ) {
      html += '<tr style="height:48px">';
      var k = lastDayOfLastMonth - firstDayOfMonth+1;
      for(var j=0; j < firstDayOfMonth; j++) {
        html += '<td style="width:14.2857143%; color: #c0c0c0" class="not-current">' + k + '</td>';
        k++;
      }
    }

    // Write the current day in the loop
    var chk = new Date();
    var chkY = chk.getFullYear();
    var chkM = chk.getMonth();
    var today = false;

    // Each entry is alloted (100/7)% space on the calendar

    if (chkY == this.currYear && chkM == this.currMonth && i == this.currDay) {
      // Prints the current day in a special blue font-style
      html += '<td style="width:14.2857143%; font-weight:600;" class="today">' + i + '</td>';
    }
  <?php foreach($dates as $data) { ?>
    /*
      A PHP foreach loop works in the background to check if the JavaScript do-while loop is outputting days that are common
      to the dates array
    */
    else if (i==<?php echo date_format(new DateTime($data), 'd'); ?>
		&& this.currMonth==(<?php echo date_format(new DateTime($data), 'm'); ?> - 1)
		&& this.currYear==20<?php echo date_format(new DateTime($data), 'y'); ?> ) {
		    if (chkY == this.currYear && chkM == this.currMonth && i == this.currDay) { today = true; }
        else { today = false; }
        // Prints the event day in a special orange-font style as well as associating the same date with its event URL
      	html += '<td style="width:14.2857143%" class="special"><a href="<?php echo($url[$n++]); ?>" style="color: #AA4401">' + i + '</a></td>';
    }
  <?php } ?>
    else {
      html += '<td style="width:14.2857143%" class="normal">' + i + '</td>';
    }
    // If Saturday, closes the row
    if ( dow == 6 ) {
      html += '</tr>';
    }

    // If not Saturday, but last day of the selected month
    // it will write the next few days from the next month
    else if ( i == lastDateOfMonth ) {
      var k=1;
      for(dow; dow < 6; dow++) {
        // Prints the day outside of the month in a faded grey font-style
        html += '<td style="width:14.2857143%; color: #c0c0c0" class="not-current">' + k + '</td>';
        k++;
      }
    }

    i++;
  }while(i <= lastDateOfMonth);

  // Closes table
  html += '</tbody></table>';

  // Write HTML to the div
  document.getElementById(this.divId).innerHTML = html;
};

// On Load of the window
window.onload = function() {

  // Start calendar
  var c = new Cal("divCal");
  c.showcurr();

  // Bind next and previous button clicks
  getId('btnNext').onclick = function() {
    c.nextMonth();
  };
  getId('btnPrev').onclick = function() {
    c.previousMonth();
  };
}

// Get element by id
function getId(id) {
  return document.getElementById(id);
}
</script>
