<?php
    require_once("cal.php");
?>
<a href="#" class="icon-info" data-toggle="modal" data-target="#calendar">open Calendar</a>

<!-- Calendar #Calendar Modal-->
<div id="calendar" class="modal fade" tabindex="-1" role="dialog" aria-hidden="true">
  <div class="modal-dialog">
  <div class="modal-content">
      <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal" aria-hidden="true">x</button>
      </div>
      <div class="modal-body">
      	  <button id="btnPrev" type="button">Prev</button>
	  <button id="btnNext" type="button">Next</button>
	  <!-- divCal is the representation of the calendar found from cal.php -->
  	  <div  id="divCal"></div>
      </div>
      <div class="modal-footer">
          <div class="col-md-12">
          <button class="btn" data-dismiss="modal" aria-hidden="true">Cancel</button>
      </div>
      </div>
  </div>
  </div>
</div>
