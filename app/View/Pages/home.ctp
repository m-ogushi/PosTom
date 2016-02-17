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
<script type="text/javascript">
$(function(){
	// ランディングページのアカウント登録ボタンを押されたときの処理
	$('#UserSignupForm').submit(function(){
		// フォームに入力されている値を変数に格納
		userName = $('#UserUsername').val();
		mailAddress = $('#UserEmail').val();
		passwd = $('#UserPassword').val();
		passwdConfirm = $('#UserPasswordConfirm').val();
	
		// エラーメッセージを空に
		err_box = $('.error-messages');
		err_box.empty();
	
		// submitを許可するか判断するための変数
		submitPermit = true;
		
		// User Name が未入力の場合
		if(userName == '' || userName == undefined){
			err_elm = $('<p>').text("User Name is required.");
			err_box.append(err_elm);
			submitPermit = false;
		}
		// Mail Address が未入力の場合
		if(mailAddress == '' || mailAddress == undefined){
			err_elm = $('<p>').text("Mail Address is required.");
			err_box.append(err_elm);
			submitPermit = false;
		}
		// Password が未入力の場合
		if(passwd == '' || passwd == undefined){
			err_elm = $('<p>').text("Password is required.");
			err_box.append(err_elm);
			submitPermit = false;
		}
		// Password と 確認用Password の値が異なる場合
		if(passwd !==  passwdConfirm){
			err_elm = $('<p>').text("Password and Password(Confirm) is different.");
			err_box.append(err_elm);
			submitPermit = false;
		}
		// User Name がすでに登録されているかどうかチェック
		/*
		TODO: Ajaxからのレスポンスが遅くて先にsubmitされてしまう（現状はサインアップページに自動遷移する）
		isAlreadyRegisted  = false;
		$.ajax({
			type: "POST",
			cache : false,
			url: "users/checkAlreadyRegisted",
			data: { "name": userName },
			success: function(response){
				// すでに登録されている場合
				if(response == "true"){
					isAlreadyRegisted = true;
				}
			},
			error: function(){
				alert('Ajax Error');
			}
		}).done(function(response){
			// Ajaxの処理がおわったときの処理
			if(response == "true"){
				isAlreadyRegisted = true;
			}
			// すでに入力したユーザ名が存在している場合
			if(isAlreadyRegisted){
				err_elm = $('<p>').text('User Name "'+ userName +'" is Already existed.');
				err_box.append(err_elm);
				submitPermit = false;
			}
			// submitを許可しない場合はページ遷移させない
			if(!submitPermit){
				slideDown(err_box)
				return false;
			}else{
				// ajaxが終了してもなお、submitPermitがtrueだったらsubmitさせる
				return true;
			}
		});
		*/
		
		// submitを許可しない場合はページ遷移させない
		if(!submitPermit){
			slideDown(err_box)
			return false;
		}
	})
	
	// エラーメッセージ表示用処理
	function slideDown(slideEle){
		slideEle.slideDown(300).removeClass('disno');
	}
 })
</script>
<meta charset="UTF-8">
<title>PosTom - 展示会向けwebアプリ作成支援ツール</title>
</head>

<body>
<!-- header -->
<div id="header">
<div class="inner">
<h1><a href="#"><img src="img/top/i_logo.png" alt="PosTom" width="120" height="70"></a></h1>
<!-- PC向けメニュー -->
<ul id="hnav" class="hidden-xs">
<li><a href="#col2">SERVICE</a></li>
<li><a href="#col3">FEATURE</a></li>
<li><a href="#col4">MOVIE</a></li>
<li><a href="#col5">SIGN UP</a></li>
<li><a href="users/login">SIGN IN</a></li>
</ul>
<!-- スマートフォン向けメニュー -->
<ul id="smHnav" class="visible-xs">
<!-- 開発中 -->
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
PosTom is a web service which generates smartphone applications for onferences including poster sessions.<br>
You can generate the applications quickly and easily.
</h4>
</div> 
</div> 
<!-- //column 1 -->

<!-- column 2 -->
<div id="col2" class="cd-scrolling-bg cd-color-1">
<div class="inner cd-container">
<p class="tit">Generate an application for smartphone on the web site.</p>
<p class="txt">If you already have the program data for a conference, you can easily generate the program pages by importing it.
<p class="thumb"><img src="img/top/i_col1.png" alt="サービス画像" width="745" height="495"></p>
</div> 
</div>
<!-- // column 2 -->

<!-- column 3 -->
<div id="col3" class="cd-fixed-bg cd-bg-2 no-min-height">
<div class="inner cd-container">
<p class="tit">By intuitive handling</p>
<p class="txt">PosTom provides the poster layout tool.<br>You can make the layout and assign poster information intuitively!</p>
<p class="thumb"><img src="img/top/i_col2.png" alt="フィーチャー画像" width="940" height="484"></p>
</div> 
</div> 
<!-- // column 3 -->

<!-- column 4 -->
<div id="col4" class="cd-scrolling-bg cd-color-3">
<div class="inner cd-container">
<p class="tit">How to make the event</p>
<p class="tac"><iframe width="560" height="315" src="https://www.youtube.com/embed/pQ8oD7f7RKU" frameborder="0" allowfullscreen></iframe></p>
</div> 
</div> 
<!-- // column 4 -->

<!-- column 5 -->
<div id="col5" class="cd-scrolling-bg cd-color-2">
<div class="inner cd-container">
<p class="tit">Sign up to try PosTom !</p>
<p class="txt">Fill your account information and sign up.</p>
<div class="error-messages disno"></div>
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
<!-- // column 5 -->

<!-- footer -->
<div id="footer">
<div class="inner">
<p id="copyright">Coptyright &copy; University of Tsukuba Graduate School of Systems and Information Engineering AIT Team: tsss</p>
</div>
</div>
<!-- // footer -->

<!-- page top -->
<div class="pagetop disno hidden-xs">
<a href="#col1">
PAGE TOP
</a>
</div>
<!-- // page top -->
</body>
</html>


