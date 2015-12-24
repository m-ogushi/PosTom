    <script type="text/javascript">
        window.onload=function()
        {
          localStorage.clear();
          window.location.href="<?php echo $this->Html->url(array('controller' => 'PosMapps', 'action' => 'index',$_SESSION['event_str'])) ?>";
        }
    </script>

	<?php
			//echo $message;

	 ?>

