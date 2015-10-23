<?php
/**
 * CakePHP(tm) : Rapid Development Framework (http://cakephp.org)
 * Copyright (c) Cake Software Foundation, Inc. (http://cakefoundation.org)
 *
 * Licensed under The MIT License
 * For full copyright and license information, please see the LICENSE.txt
 * Redistributions of files must retain the above copyright notice.
 *
 * @copyright     Copyright (c) Cake Software Foundation, Inc. (http://cakefoundation.org)
 * @link          http://cakephp.org CakePHP(tm) Project
 * @package       app.View.Layouts
 * @since         CakePHP(tm) v 0.10.0.1076
 * @license       http://www.opensource.org/licenses/mit-license.php MIT License
 */

$cakeDescription = __d('cake_dev', 'CakePHP: the rapid development php framework');
$cakeVersion = __d('cake_dev', 'CakePHP %s', Configure::version())
?>
<!DOCTYPE html>
<html>
<head>
	<?php echo $this->Html->charset(); ?>
	<title>
        <?php  echo $title_for_layout; ?>
	</title>
	<?php
		echo $this->Html->meta('icon');
		
		echo $this->Html->css('bootstrap.min');
		echo $this->Html->css('bootstrap-select');
		echo $this->Html->css('jquery-ui.min');
		echo $this->Html->css('reset');
		echo $this->Html->css('base');
		echo $this->Html->css('font-awesome.min');
		
		echo $this->fetch('meta');
		echo $this->fetch('css');
		echo $this->fetch('script');
		
		echo $this->Html->script('jquery-1.11.3.min');
	?>
    <!-- fonts -->
    <link href='https://fonts.googleapis.com/css?family=Oswald' rel='stylesheet' type='text/css'>
</head>
<body>
<!-- header -->
<!--
<div id="header">
<div class="inner">

<h1><?php echo $this->Html->link('PosTom', '/'); ?></h1>

</div>
</div>
-->
<!-- //header -->
<!-- contents -->
<div id="contents">
<!-- contents.dashboard -->
<div id="dashboard">
<h1 id="logo">
<?php
echo $this->Html->image("http://placehold.jp/24/39b998/77dec6/200x150.png?text=PosTom", array(
	"alt" => "PosTom",
	'url' => array('controller' => 'events', 'action' => 'index')
));
?>
</h1>
<ul id="gNav">
<li id="gNavTop"><a href="<?php echo $this->Html->url(array('controller' => 'events', 'action' => 'index')); ?>"><i class="fa fa-tachometer fa-2x"></i><span>Dashboard</span></a></li>
<li id="gNavPos"><a href="<?php echo $this->Html->url(array('controller' => 'posters', 'action' => 'index')); ?>"><i class="fa fa-file-image-o fa-2x"></i><span>Poster</span></a></li>
<li id="gNavSch"><a href="<?php echo $this->Html->url(array('controller' => 'schedules', 'action' => 'index')); ?>"><i class="fa fa-calendar fa-2x"></i><span>Schedule</span></a></li>
<li id="gNavPre"><a href="<?php echo $this->Html->url(array('controller' => 'presentations', 'action' => 'index')); ?>"><i class="fa fa-television fa-2x"></i><span>Presentation</span></a></li>
<li id="gNavFlo"><a href="#"><i class="fa fa-map-marker fa-2x"></i><span>Floor Map</span></a></li>
<li id="gNavSet"><a href="#"><i class="fa fa-cog fa-2x"></i><span>Setting</span></a></li>
</ul>
</div>
<!-- //contents.dashboard -->
<!-- contents.main -->
<div id="main">

<?php echo $this->Flash->render(); ?>
<?php echo $this->fetch('content'); ?>

</div>
<!-- //contents.main -->
</div>
<!-- //contents -->
<!-- footer -->
<!--
<div id="footer">
<div class="inner">
<p id="copyright">
Copyright &copy; 2015, University of Tsukuba, Department of Computer Science, AIT, Team tsss.
</p>
</div>
</div>
-->
<!-- //footer -->
<?php echo $this->element('sql_dump'); ?>
</body>
</html>
