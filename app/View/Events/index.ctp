<h2>Event List</h2>
<ul id="eventlist">
<?php foreach($events as $event) : ?>
<li>
<a href="<?php echo '/postom/events/view/'.$event['Event']['id']; ?>">

<?php
// echo h($event['Event']['event_name']);
//echo $this->Html->link($event['Event']['event_name'], '/events/view/'.$event['Event']['id']);
?>
<span class="tit"><?php echo h($event['Event']['event_name']); ?></span>
<span>場所：<?php echo h($event['Event']['event_location']); ?></span>
<span>日付：<?php echo $event['Event']['event_begin_date']; ?> - <?php echo $event['Event']['event_end_date']; ?></span>
</a>
</li>
<?php endforeach; ?>
</ul>

<?php echo $this->Html->link('Create Event', array('controller'=>'events', 'action'=>'add'), array('class'=>'btn btn-custom')); ?>