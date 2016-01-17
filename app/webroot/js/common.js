/*-------------------------------------------------
 
  common.js
 
 --------------------------------------------------*/
 
$(function(){
	// リンク付き画像ホバー時、の透明度を徐々に変化させる
	$('a > img, #viewlist a > i').hover(
		function(){
			$(this).stop().animate({'opacity': '0.5'}, 400);
		},
		function(){
			$(this).stop().animate({'opacity': '1'}, 400);
		}
	);
	
	// グローバルメニューホバー時、背景色を徐々に変化させる
	$('#gNav li a').hover(
		function(){
			$(this).stop().animate({backgroundColor: '#2a7d65'}, 300);
		},
		function(){
			$(this).stop().animate({backgroundColor: '#39b998'}, 300);
		}
	);
	
	// class requiredを持つinput要素の前にあたる兄弟要素labelにもclass requiredを付与する
	$('input.required').each(function(index, element) {
		$(this).prev('label').addClass('required');
	});
	
	// ログイン状態でないとき、グローバルメニューを使用不可能に
	if(loginUserID == '' || loginUserID == undefined){
		disabledGNav();	
	}
});

// グローバルメニューを使用不可能にする処理
function disabledGNav(){
	$('#dashboard #gNav').addClass('disabled');
	$('#dashboard #gNav li').each(function(index, element) {
		$(this).children('a').attr('href', 'javascript:void(0)');
	});
}

// Google アナリティクス トラッキングコード
(function(i,s,o,g,r,a,m){i['GoogleAnalyticsObject']=r;i[r]=i[r]||function(){
(i[r].q=i[r].q||[]).push(arguments)},i[r].l=1*new Date();a=s.createElement(o),
m=s.getElementsByTagName(o)[0];a.async=1;a.src=g;m.parentNode.insertBefore(a,m)
})(window,document,'script','//www.google-analytics.com/analytics.js','ga');

ga('create', 'UA-72523563-1', 'auto');
ga('send', 'pageview');