<h2>Edit event</h2>

<ul id="eventlist">
<?php foreach($events as $event) : ?>
<li>
<a href="<?php echo $this->Html->url(array('controller' => 'settings', 'action' => 'eventedit')).'/'.$event['Event']['id']; ?>">

<span class="tit"><?php echo h($event['Event']['event_name']); ?></span>
<span>Location：<?php echo h($event['Event']['event_location']); ?></span>
<span>DateTime：<?php echo $event['Event']['event_begin_date']; ?> <?php echo $event['Event']['event_begin_time']; ?> - <?php echo $event['Event']['event_end_date']; ?> <?php echo $event['Event']['event_end_time']; ?></span>
</a>
</li>
<?php endforeach; ?>
</ul>
