<table class="table table-striped table-bordered table-hover">
<thead>
<th>ID</th><th>width</th><th>height</th>
<th>x</th><th>y</th><th>area_id</th>
<th>date</th>
</thead>
<tbody>


<h2>
<?php echo $this->Html->url(array('controller' => 'Events', 'action' => 'view')) ?>/<?php echo $id;?>
</h2>
	<script type="text/javascript">
			localStorage.clear();
			 window.onload=function()
			 {
				 window.location.href="<?php echo $this->Html->url(array('controller' => 'Events', 'action' => 'view')) ?>/<?php echo $id;?>";
			}
	</script>
</tbody>
</table>
