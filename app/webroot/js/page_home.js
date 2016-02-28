/*-------------------------------------------------

  Home javascript

 --------------------------------------------------*/

// ウィンドウの高さを取得
var window_height = $(window).height();

$(document).ready(function(){
	smoothScroll();
	imgHover();
	headerScroll();
});
$.event.add(window, "load", function(){ 
	pagetop();
});

// ページ内リンクスクロール
function smoothScroll(){
	$('a[href*=#]').click(function() {
		if (location.pathname.replace(/^\//,'') == this.pathname.replace(/^\//,'') && location.hostname == this.hostname) {
			var target = $(this.hash);
			target = target.length && target;
			if (target.length) {
				var sclpos = 70;
				var scldurat = 1200;
				var targetOffset = target.offset().top - sclpos;
				$('html,body')
					.animate({scrollTop: targetOffset}, {duration: scldurat, easing: "easeOutExpo"});
				return false;
			}
		}
	});
}

// ホバー処理
function imgHover(){
	$('a img').hover(
        function(){  
            $(this).stop().animate({'opacity' : '0.7'}, 500);  
        },
        function(){
            $(this).stop().animate({'opacity' : '1'}, 1000);
        }
    );
}

// ページトップへ戻る
function pagetop(){
	$(window).scroll(function() {
		if($(this).scrollTop() > 300) {
			$('.pagetop').fadeIn(300);
		}else{
			$('.pagetop').fadeOut(300);
		}
	});
	$('.pagetop a').click(function(event) {
		event.preventDefault();
		$('html, body').animate({scrollTop: 0}, 300);
	});
}

// ヘッダーの背景色処理
function headerScroll(){
	$(window).scroll(function() {
		if($(this).scrollTop() >= (window_height-70)) {
			// ウィンドウの高さよりも下の場合
			$('#header').stop().animate({backgroundColor: 'rgba(34,34,34,1.0)'}, 300);
		}else{
			// ウィンドウの高さよりも上の場合
			$('#header').stop().animate({backgroundColor: 'rgba(34,34,34,0.0)'}, 300);
		}
	});
}