<?php $this->layout = ""; ?>
<!doctype html>
<html>
<head>
<?php
echo $this->fetch('meta');
echo $this->fetch('css');
echo $this->fetch('script');
?>
<!-- stylesheet -->
<?php
echo $this->Html->css('bootstrap.min');
echo $this->Html->css('bootstrap-select');
echo $this->Html->css('jquery-ui.min');
echo $this->Html->css('reset');
echo $this->Html->css('page_home');
?>
<link href='https://fonts.googleapis.com/css?family=Montserrat' rel='stylesheet' type='text/css'>
<!-- javascript -->
<?php
echo $this->Html->script('jquery-1.11.3.min');
echo $this->Html->script('jquery-ui.min');
echo $this->Html->script('jquery.animate-colors-min');
echo $this->Html->script('page_home');
?>
<meta charset="UTF-8">
<title>PosTom - 展示会向けwebアプリ作成支援ツール</title>
</head>

<body>
<!-- header -->
<div id="header">
<div class="inner">
<h1><a href="#"><img src="img/top/i_logo.png" alt="PosTom" width="120" height="70"></a></h1>
<ul id="hnav">
<li><a href="#col2">SERVICE</a></li>
<li><a href="#col3">FEATURE</a></li>
<li><a href="#col4">SIGN UP</a></li>
<li><a href="users/login">SIGN IN</a></li>
</ul>
</div>
</div>
<!-- // header -->

<!-- column 1 -->
<div id="col1" class="cd-fixed-bg cd-bg-1">
<div class="inner cd-container">
<h2>SMARTPHONE APPLICATION GENERATOR</h2>
<h3>FOR CONFERENCES INCLUDING POSTER SESSIONS</h3>
<h4>
PosTomは展示会向けwebアプリ作成支援ツールです。<br>
学会のポスターをはじめ、プレゼンテーション・スケジュールのコンテンツを<br>
簡単に作成することができます。
</h4>
</div> 
</div> 
<!-- //column 1 -->

<!-- column 2 -->
<div id="col2" class="cd-scrolling-bg cd-color-1">
<div class="inner cd-container">
<p class="tit">PCから簡単スマートフォン向けアプリ生成</p>
<p class="txt">学会向けスマートフォンアプリの生成が作りたいアナタへ。<br>学会ごとにスマートフォンアプリをつくるなんて面倒だと思っていませんか？<br>あなたに求めることは必要最低限の操作と、データをアップロードするだけ。<br>最短3分で簡単につくることができます。しかも無料。</p>
<p class="thumb"><img src="img/top/i_col1.png" alt="サービス画像" width="745" height="495"></p>
</div> 
</div>
<!-- // column 2 -->

<!-- column 3 -->
<div id="col3" class="cd-fixed-bg cd-bg-2 no-min-height">
<div class="inner cd-container">
<p class="tit">簡単にポスター配置</p>
<p class="txt">ポスターセッションのコンテンツは特に面倒なもの。<br>しかし、PosTomを利用すれば直感的に配置がおこなえます。</p>
<p class="thumb"><img src="img/top/i_col2.png" alt="フィーチャー画像" width="940" height="484"></p>
</div> 
</div> 
<!-- // column 3 -->

<!-- column 4 -->
<div id="col4" class="cd-scrolling-bg cd-color-2">
<div class="inner cd-container">

<p class="tit">まずはお試しください</p>
<p class="txt">すべて無料。仮登録が完了するとメールが届きます。</p>
<div class="signup-form">
<form action="users/signup" id="UserSignupForm" method="post" accept-charset="utf-8">
<div class="disno">
<input type="hidden" name="_method" value="POST">
</div>
<dl class="input text">
<dt><label for="UserUsername" class="required">User Name</label></dt>
<dd><input name="data[User][username]" class="form-control required" maxlength="100" type="text" id="UserUsername"></dd>
</dl>
<dl class="input text">
<dt><label for="UserEmail" class="required">Mail Address</label></dt>
<dd><input name="data[User][email]" class="form-control required" maxlength="200" type="text" id="UserEmail"></dd>
</dl>
<dl class="input password">
<dt><label for="UserPassword" class="required">Password</label></dt>
<dd><input name="data[User][password]" class="form-control required" type="password" id="UserPassword"></dd>
</dl>
<dl class="input password">
<dt><label for="UserPasswordConfirm" class="required">Password(Confirm)</label></dt>
<dd><input name="data[User][password_confirm]" class="form-control required" type="password" id="UserPasswordConfirm"></dd>
</dl>
<div class="submit">
<input class="btn btn-custom" type="submit" value="Sign Up">
</div>
</form>
</div>

</div> 
</div> 
<!-- // column 4 -->

<!-- footer -->
<div id="footer">
<div class="inner">
<p id="copyright">Coptyright &copy; University of Tsukuba Graduate School of Systems and Information Engineering AIT Team: tsss</p>
</div>
</div>
<!-- // footer -->

<!-- page top -->
<div class="pagetop disno">
<a href="#col1">
PAGE TOP
</a>
</div>
<!-- // page top -->
</body>
</html>


