<?php
	// 終了したイベントと、これから開催されるイベントを格納するための配列変数
	$upcomingEvents = array();
	$pastEvents = array();
	// 終了したイベントと、これから開催されるイベントに分ける
	foreach($events as $event):
		// 開催終了日時のタイムスタンプ
		$timestamp = strtotime($event['Event']['event_end_date'].' '.$event['Event']['event_end_time']);
		if(time() > $timestamp){
			// 現在時刻タイムスタンプの方が大きい = 終了したイベント
			array_push($pastEvents, $event);
		}else{
			// 現在時刻タイムスタンプの方が小さい = これから開催されるイベント
			array_push($upcomingEvents, $event);
		}
	endforeach;
	
	// これから開催されるイベントについては、現在日時に近いものほど上位に表示するため並び替える
	for($i=0; $i<count($upcomingEvents)-1; $i++){
		for($j=$i+1; $j<count($upcomingEvents); $j++){
			if(date($upcomingEvents[$i]['Event']['event_begin_date']) > date($upcomingEvents[j]['Event']['event_begin_date'])){
				// スワップ処理
				$tmp = $upcomingEvents[$i];
				$upcomingEvents[$i] = $upcomingEvents[$j];
				$upcomingEvents[$j] = $tmp;
			}
		}
	}
	
?>
<h2>Event List</h2>
<!-- Upcoming Events -->
<h3>Upcoming Events</h3>
<ul id="upcomingEventList">
<?php if(empty($upcomingEvents)){ ?>
<li>No Results.</li>
<?php }else{ ?>
	<?php foreach($upcomingEvents as $event) : ?>
		<li>
		<a href="<?php echo $this->Html->url(array('controller' => 'Events', 'action' => 'view')).'/'.$event['Event']['unique_str']; ?>">
		<span class="tit"><?php echo h($event['Event']['event_name']); ?></span>
		<span>Location：<?php echo h($event['Event']['event_location']); ?></span>
		<span>DateTime：<?php echo $event['Event']['event_begin_date']; ?> <?php echo $this->Time->format($event['Event']['event_begin_time'], '%H:%M'); ?> - <?php echo $event['Event']['event_end_date']; ?> <?php echo $this->Time->format($event['Event']['event_end_time'], '%H:%M');?></span>
		</a>
		</li>
	<?php endforeach; ?>
<?php } // endif ?>
</ul>
<!-- //Upcoming Events -->
<!-- Past Events -->
<h3>Past Events</h3>
<ul id="pastEventList">
<?php if(empty($pastEvents)){ ?>
<li>No Results.</li>
<?php }else{ ?>
	<?php foreach($pastEvents as $event) : ?>
		<li>
		<a href="<?php echo $this->Html->url(array('controller' => 'Events', 'action' => 'view')).'/'.$event['Event']['unique_str']; ?>">
		<span class="tit"><?php echo h($event['Event']['event_name']); ?></span>
		<span>Location：<?php echo h($event['Event']['event_location']); ?></span>
		<span>DateTime：<?php echo $event['Event']['event_begin_date']; ?> <?php echo $this->Time->format($event['Event']['event_begin_time'], '%H:%M'); ?> - <?php echo $event['Event']['event_end_date']; ?> <?php echo $this->Time->format($event['Event']['event_end_time'], '%H:%M');?></span>
		</a>
		</li>
	<?php endforeach; ?>
<?php } // endif ?>
</ul>
<!-- //Past Events -->
<?php echo $this->Html->link('Create Event', array('controller'=>'events', 'action'=>'add'), array('class'=>'btn btn-custom')); ?>
