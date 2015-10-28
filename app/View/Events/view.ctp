<h2><?php echo h($event['Event']['event_name']); ?></h2>
<p class="location">Location: <?php echo h($event['Event']['event_location']); ?></p>
<p class="datetime">DateTime：<?php echo $event['Event']['event_begin_date']; ?> <?php echo $this->Time->format($event['Event']['event_begin_time'], '%H:%M'); ?> - <?php echo $event['Event']['event_end_date']; ?> <?php echo $this->Time->format($event['Event']['event_end_time'], '%H:%M'); ?></p>

<h3>View Your Event</h3>
<ul id="viewlist">
<li><a href="
<?php echo $this->Html->url(array('controller' => 'PosMapps', 'action' => 'index')) ?>
" target="_blank"><i class="fa fa-television  fa-5x"></i></a></li>
<li><a href="
<?php echo $this->Html->url(array('controller' => 'PosMapps', 'action' => 'qr')) ?>
"><i class="fa fa-mobile  fa-5x"></i></a></li>
<li><a href="
<?php echo $this->Html->url(array('controller' => 'PosMapps', 'action' => 'makejson')) ?>
"><i class="fa fa-print  fa-5x"></i></a></li>
</ul>