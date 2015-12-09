	<script type="text/javascript">
				 window.onload=function()
				 {
			localStorage.clear();
			var url= window.location.href;
			var event_str = url.substring(url.lastIndexOf('/')+1, url.length);
			window.location.href="<?php echo $this->Html->url(array('controller' => 'PosMapps', 'action' => 'index',"")) ?>"+"/"+event_str;
			}
	</script>
