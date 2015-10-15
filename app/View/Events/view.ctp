<h2><?php echo h($event['Event']['event_name']); ?></h2>

<p>Location: <?php echo h($event['Event']['event_location']); ?></p>
<p>DateTime：<?php echo $event['Event']['event_begin_date']; ?> <?php echo $event['Event']['event_begin_time']; ?> - <?php echo $event['Event']['event_end_date']; ?> <?php echo $event['Event']['event_end_time']; ?></p>

<h3>View Your Event</h3>
<ul id="viewlist">
<li><a href="#"><i class="fa fa-television  fa-5x"></i></a></li>
<li><a href="#"><i class="fa fa-mobile  fa-5x"></i></a></li>
<li><a href="#"><i class="fa fa-print  fa-5x"></i></a></li>
</ul>