<p class="location">Location: <?php echo h($event['Event']['event_location']); ?></p>
<p class="datetime">DateTime：<?php echo $event['Event']['event_begin_date']; ?> <?php echo $this->Time->format($event['Event']['event_begin_time'], '%H:%M'); ?> - <?php echo $event['Event']['event_end_date']; ?> <?php echo $this->Time->format($event['Event']['event_end_time'], '%H:%M'); ?></p>
<h3>Description of the side bar</h3>
<div class="list">
	<div class="title">
	・Schedule
	</div>
	<div>
	<p>&nbsp;You can register Session of the event.</p>
	<p>&nbsp;&nbsp;・registration by import scv file</p>
	<p>&nbsp;&nbsp;・registration by visually</p>
	</div> 
</div>

<div class="list">
	<div class="title">
	・Poster
	</div>
	<div>
	</p>&nbsp;You can set poster by visually.</p>
	</p>&nbsp;You can also poster associate with presentation.(register presentation ahead)</p>
	</div>
</div>

<div class="list">
	<div class="title">
	・Presentation
	</div>
	<div>
	<p>&nbsp;You can register Presentaion of the event.</p>
	<p>&nbsp;&nbsp;・registration by import scv file</p>
	<p>&nbsp;&nbsp;・registration by visually</p>
	</div> 
</div>

<div class="list">
	<div class="title">
	・Floor Map
	</div>
	<div>
	You can upload floor map image simply.
	</div>
</div>

<div class="list">
	<div class="title">
	・Setting
	</div>
	<div>
	<p>&nbsp;You can edit the following information of the event.</p>
	<p>&nbsp;&nbsp;・Eevnt Name</p>
	<p>&nbsp;&nbsp;・Event Location</p>
	<p>&nbsp;&nbsp;・Event Begin Date</p>
	<p>&nbsp;&nbsp;・Event Begin Time</p>
	<p>&nbsp;&nbsp;・Event End Datev</p>
	<p>&nbsp;&nbsp;・Event End Time</p>
	<p>&nbsp;and You can upload event top image.</p>
	</div>
</div>

<h3>Manage Your Event</h3>
<ul id="viewlist2">
<li><a href="
<?php echo $this->Html->url(array('controller' => 'schedules', 'action' => 'index')) ?>
" target="_blank"><i class="fa fa-calendar  fa-5x"></i></a>
<p>Add Sessions</p>
</li>
<li><a href="
<?php echo $this->Html->url(array('controller' => 'posters', 'action' => 'index')) ?>
"><i class="fa fa-file-image-o  fa-5x"></i></a>
<p>Make Poster Map</p>
</li>
<li><a href="
<?php echo $this->Html->url(array('controller' => 'presentations', 'action' => 'index')) ?>
" target="_blank"><i class="fa fa-television  fa-5x"></i></a>
<p>Add Presentations</p>
</li>
</ul>

<h3>How to make the event?</h3>

example)

<div class="list">
<div class="title">
	1.Add Sessions
</div>
First,you register sessions information.
Import csv file about sessions, or register visually.
If you use csv file,the form is decided.But you can download format sample. So don't worry.
If you register visually,first add information of the rooms by tab,then add new session in each rooms.
You can do easily.
</div>

<div class="list">
<div class="title">
	2.Add presentation
</div>
Next,you register presentation information.
In the same way as sessions,this can do easily,import csv file about presentation, or register visually.
</div>

<div class="list">
<div class="title">
	3.Make poster map
</div>
Next,you register poster information.
You can A poster can be arranged.you can register visually.
And, if you already register presentation information, presentations can be associated with posters.
</div>

<div class="list">
<div class="title">
	4.Make Floor Map
</div>
Last, you register floor map.
You can upload a picture in your computer.
</div>

<h3>View Your Event</h3>
<ul id="viewlist">
<li><a href="
<?php echo $this->Html->url(array('controller' => 'PosMapps', 'action' => 'deletestorage')) ?>
" target="_blank"><i class="fa fa-television  fa-5x"></i></a>
<p>by PC</p>
</li>
<li><a href="
<?php echo $this->Html->url(array('controller' => 'PosMapps', 'action' => 'qr')) ?>
"><i class="fa fa-mobile  fa-5x"></i></a>
<p>by SmartPhone</p>
</li>
</ul>
