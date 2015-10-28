/*-------------------------------------------------
 
  common.js
 
 --------------------------------------------------*/
 
$(function(){
	$('a > img, #viewlist a > i').hover(
		function(){
			$(this).stop().animate({'opacity': '0.5'}, 400);
		},
		function(){
			$(this).stop().animate({'opacity': '1'}, 400);
		}
	);
	
	$('#gNav li a').hover(
		function(){
			$(this).stop().animate({backgroundColor: '#2a7d65'}, 300);
		},
		function(){
			$(this).stop().animate({backgroundColor: '#39b998'}, 300);
		}
	);
});