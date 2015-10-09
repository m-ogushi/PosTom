<h2>イベント一覧</h2>
<ul>
<?php foreach($events as $event) : ?>
<li>
<?php
// echo h($event['Event']['event_name']);
echo $this->Html->link($event['Event']['event_name'], '/events/view/'.$event['Event']['id']);
?>
</li>
<?php endforeach; ?>
</ul>

<h2>新規イベント作成</h2>
<?php echo $this->Html->link('新規イベント作成', array('controller'=>'events', 'action'=>'add')); ?>