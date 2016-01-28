<p class="location">Location: <?php echo h($event['Event']['event_location']); ?></p>
<p class="datetime">DateTime：<?php echo $event['Event']['event_begin_date']; ?> <?php echo $this->Time->format($event['Event']['event_begin_time'], '%H:%M'); ?> - <?php echo $event['Event']['event_end_date']; ?> <?php echo $this->Time->format($event['Event']['event_end_time'], '%H:%M'); ?></p>

<h3>Description Of Dashboard Menu</h3>
<ul id="dashboardlist">
<li><a data-toggle="collapse" data-parent="#accordion" href="#collapseOne"><i class="fa fa-calendar fa-5x"></i></a>
<p>Schedule</p>
</li>
<li><a data-toggle="collapse" data-parent="#accordion" href="#collapseTwo"><i class="fa fa-file-image-o fa-5x"></i></a>
<p>Poster</p>
</li>
<li><a data-toggle="collapse" data-parent="#accordion" href="#collapseThree"><i class="fa fa-television fa-5x"></i></a>
<p>Presentation</p>
</li>
<li><a data-toggle="collapse" data-parent="#accordion" href="#collapseFour"><i class="fa fa-map-o fa-5x"></i></a>
<p>Floor Map</p>
</li>
<li><a data-toggle="collapse" data-parent="#accordion" href="#collapseFive"><i class="fa fa-cog fa-5x"></i></a>
<p>Setting</p>
</li>
</ul>
<!-- アコーディオングループ -->
<div class="panel-group" id="accordion">
<!-- スケジュール -->
<div class="panel panel-default">
<div id="collapseOne" class="panel-collapse collapse">
<!-- panel-body -->
<div class="panel-body">
<p>You can register Session of the event.</p>
<ul>
<li>Registration by import scv file</li>
<li>Registration by visually</li>
</ul>
</div>
<!-- //panel-body -->
</div>
</div>
<!-- //スケジュール -->
<!-- ポスター -->
<div class="panel panel-default">
<div id="collapseTwo" class="panel-collapse collapse">
<!-- panel-body -->
<div class="panel-body">
<p>You can set poster by visually.</p>
<p>You can also poster associate with presentation ( register presentation ahead ).</p>
</div>
<!-- //panel-body -->
</div>
</div>
<!-- //ポスター -->
<!-- プレゼンテーション -->
<div class="panel panel-default">
<div id="collapseThree" class="panel-collapse collapse">
<!-- panel-body -->
<div class="panel-body">
<p>You can register Presentaion of the event.</p>
<ul>
<li>Registration by import scv file</li>
<li>Registration by visually</li>
</ul>
</div>
<!-- //panel-body -->
</div>
</div>
<!-- //プレゼンテーション -->
<!-- フロアマップ -->
<div class="panel panel-default">
<div id="collapseFour" class="panel-collapse collapse">
<!-- panel-body -->
<div class="panel-body">
<p>You can upload floor map image simply.</p>
</div>
<!-- //panel-body -->
</div>
</div>
<!-- //フロアマップ -->
<!-- セッティング -->
<div class="panel panel-default">
<div id="collapseFive" class="panel-collapse collapse">
<!-- panel-body -->
<div class="panel-body">
<p>You can edit the following information of the event.</p>
<ul>
<li>Event Name</li>
<li>Event Location</li>
<li>Event Begin Date / Time</li>
<li>Event End Date / Time</li>
</ul>
<p>And you can upload event top image.</p>
</div>
<!-- //panel-body -->
</div>
</div>
<!-- //セッティング -->
</div>
<!-- //アコーディオングループ -->


<h3>How To Make The Event</h3>
<iframe width="560" height="315" src="https://www.youtube.com/embed/pQ8oD7f7RKU" frameborder="0" allowfullscreen></iframe>

<h3>View Your Event</h3>
<ul id="viewlist">
<li><a href="
<?php echo $this->Html->url(array('controller' => 'PosMapps', 'action' => 'deletestorage')) ?>
" target="_blank"><i class="fa fa-television fa-5x"></i></a>
<p>by PC</p>
</li>
<li><a href="
<?php echo $this->Html->url(array('controller' => 'PosMapps', 'action' => 'qr')) ?>
"><i class="fa fa-mobile fa-5x"></i></a>
<p>by SmartPhone</p>
</li>
</ul>
