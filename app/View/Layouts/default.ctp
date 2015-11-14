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
		/********************************************************
		  *							style sheet										*
		 ********************************************************/
		echo $this->Html->css('bootstrap.min');
		echo $this->Html->css('bootstrap-select');
		echo $this->Html->css('jquery-ui.min');
		echo $this->Html->css('reset');
		echo $this->Html->css('base');
		echo $this->Html->css('font-awesome.min');
		echo $this->Html->css('layout_header');
		// コントローラ別にcssを切り分ける
		switch($this->name){
			case 'Events':
				echo $this->Html->css('page_event');
				break;
			case 'Posters':
				echo $this->Html->css('page_poster');
				break;
		}

		echo $this->fetch('meta');
		echo $this->fetch('css');
		echo $this->fetch('script');
		/********************************************************
		  *							javascirpt										*
		 ********************************************************/
		echo $this->Html->script('jquery-1.11.3.min');
		echo $this->Html->script('jquery.animate-colors-min');
		echo $this->Html->script('easeljs-0.8.0.min');
		echo $this->Html->script('bootstrap.min');
		echo $this->Html->script('bootstrap-select');
		echo $this->Html->script('jquery-ui.min');
?>
		<script type="text/javascript">
		/* グローバル変数 */
		// コントローラを取得
		var controller = "<?php echo $this->name; ?>";
		// アクションを取得
		var action = "<?php echo $this->action ?>";
		// 現在のURLを取得
		var url = "<?php echo $this->here ?>";
		// webrootのURLを取得
		var webroot = "<?php echo $this->webroot; ?>";
		// ログイン中のユーザIDを取得(ログイン中でない場合は空)
		var loginUserID = "<?php echo isset($_SESSION['login_user_id'])? $_SESSION['login_user_id'] : ''; ?>";
        </script>
<?php
		echo $this->Html->script('common');
		// コントローラ別にjsを切り分ける
		switch($this->name){
			case 'Events':
				echo $this->Html->script('page_event');
				break;
			case 'Posters':
				echo $this->Html->script('page_poster');
				break;
			case 'Presentations':
				echo $this->Html->script('page_presentation');
				break;
		}
	?>
    <!-- fonts -->
    <link href='https://fonts.googleapis.com/css?family=Oswald' rel='stylesheet' type='text/css'>
</head>
<body>
<!-- contents -->
<div id="contents">
<!-- contents.dashboard -->
<div id="dashboard">
<h1 id="logo">
<?php
echo $this->Html->image('i_logo.png', array(
	"alt" => "PosTom",
	'url' => array('controller' => 'events', 'action' => 'index')
));
?>
</h1>
<ul id="gNav">
<li id="gNavDas"><a href="
<?php
	if(isset($_SESSION['event_str'])){
		echo $this->Html->url(array('controller' => 'events', 'action' => 'view', $_SESSION['event_str']));
	}else{
		echo '#';
	}
?>
"><i class="fa fa-tachometer fa-2x"></i><span>Dashboard</span></a></li>
<li id="gNavPos"><a href="<?php echo $this->Html->url(array('controller' => 'posters', 'action' => 'index')); ?>"><i class="fa fa-file-image-o fa-2x"></i><span>Poster</span></a></li>
<li id="gNavSch"><a href="<?php echo $this->Html->url(array('controller' => 'schedules', 'action' => 'index')); ?>"><i class="fa fa-calendar fa-2x"></i><span>Schedule</span></a></li>
<li id="gNavPre"><a href="<?php echo $this->Html->url(array('controller' => 'presentations', 'action' => 'index')); ?>"><i class="fa fa-television fa-2x"></i><span>Presentation</span></a></li>
<li id="gNavFlo"><a href="<?php echo $this->Html->url(array('controller' => 'floormaps', 'action' => 'index')); ?>"><img src="<?php echo $this->webroot; ?>/img/ico_floormap.png" alt="Floor Map"><span>Floor Map</span></a></li>
<li id="gNavSet"><a href="<?php echo $this->Html->url(array('controller' => 'settings', 'action' => 'index')); ?>"><i class="fa fa-cog fa-2x"></i><span>Setting</span></a></li>
</ul>
</div>
<!-- //contents.dashboard -->
<!-- contents.main -->
<div id="main">

<!-- header -->
<div id="header">
	<ul id="hNav">
	<?php
	//ログインしているユーザ名取得
	$user = AuthComponent::user();
	$username = $user['username'];
	//ログインか否かで表示を変更
	if($username != null){
		$signoutLink = $this->Html->url(array('controller' => 'users', 'action' => 'logout'));
		echo '<li><a href="' . $signoutLink . '">SignOut</a></li>';
		echo '<li><p>Welcome to PosTom ' . $username . ' !!</p></li>';
	}else{
		$signupLink = $this->Html->url(array('controller' => 'users', 'action' => 'signup'));
		$signinLink = $this->Html->url(array('controller' => 'users', 'action' => 'login'));
		echo '<li><a href="' . $signinLink . '">SignIn</a></li>';
		echo '<li><a href="' . $signupLink . '">SignUp</a></li>';
	}
	?>
	</ul>
</div>
<!-- //header -->


<?php echo $this->Flash->render(); ?>
<?php echo $this->fetch('content'); ?>

<!-- sql dump -->
<div id="sqldump">
<?php echo $this->element('sql_dump'); ?>
</div>
<!--//sql dump-->
</div>
<!-- //contents.main -->
</div>
<!-- //contents -->
</body>
</html>
