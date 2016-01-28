/*-------------------------------------------------

  Presentation javascript

 --------------------------------------------------*/

 /********************************************************
 *		グローバルナビゲーション カレント処理					*
 ********************************************************/
$(function(){
	// ダッシュボードのPresentationを選択状態にする
	$('#dashboard #gNav #gNavPre').addClass('current');
});

// 「Add Presentation From CSV File」ボタンを押すと、ファイル選択ボタンを作動させる
function selectFile(){
	$('#selectFile').trigger('click');
}
$(function(){

//$("[id^=Presen]").click(function(){
$("[id^=Presentable]").on('click',function(){
		clickid=$(this).attr("id").replace(/Presentable/g,"");
		$("#presentitle").text("Edit Presentation");
		$('#session_make_btn').css('display', 'none');
		$('#session_save_btn').css('display', '');
		$('#session_delete_btn').css('display', '');
		
		$(':hidden[id="PresentationSessionid"]').val($(this).attr("id").replace(/Presentable/g,""));
		$(':text[id="PresentationRoom"]').val($(this).children(".Room").text());
		$(':text[id="PresentationSessionOrder"]').val($(this).children(".Session_order").text());
		$(':text[id="PresentationId"]').val($(this).children(".Presentation_order").text());
		$(':text[id="PresentationTitle"]').val($(this).children(".Title").text());
		console.log(clickid);
		$(':text[id="PresentationAuthor"]').val($(this).children(".Name").text());
		$(':text[id="PresentationAffiliation"]').val($(this).children(".Affiliation").text());
		$('#Session').val($(this).children(".Room").text()+$(this).children(".Session_order").text());
		/*$( "#dialogSelectConfirm" ).dialog({
			resizable: false,
			modal: true,
		});*/
		$('body').append('<div class="modal-overlay"></div>');
		// オーバーレイをフェードイン
		$('.modal-overlay').fadeIn('slow');
		var modal = "#dialogSelectConfirm";
		modalResize();
		$("#dialogSelectConfirm").fadeIn('slow');
});
$("#plus").on('click',function(){
		$("#presentitle").text("Add New Presentation");

		$('#session_make_btn').css('display', '');
		$('#session_save_btn').css('display', 'none');
		$('#session_delete_btn').css('display', 'none');
		
		$(':hidden[id="PresentationSessionid"]').val("");
		$(':text[id="PresentationRoom"]').val("");
		$(':text[id="PresentationSessionOrder"]').val("");
		$(':text[id="PresentationId"]').val("");
		$(':text[id="PresentationTitle"]').val("");
		$(':text[id="PresentationAuthor"]').val("");
		$('#Session').val("");
		$(':text[id="PresentationAffiliation"]').val();
		
		/*$( "#dialogSelectConfirm" ).dialog({
			resizable: false,
			modal: true,
		});*/
		$('body').append('<div class="modal-overlay"></div>');
		$('.modal-overlay').fadeIn('slow');
		var modal = "#dialogSelectConfirm";
		modalResize();
		$("#dialogSelectConfirm").fadeIn('slow');
});

// リサイズしたら表示位置を再取得
		$(window).on('resize', function(){
			modalResize();
		});

		function modalResize(){
			// ウィンドウの横幅、高さを取得
			var w = $(window).width();
			var h = $(window).height();

			// モーダルコンテンツの表示位置を取得
			var x = (w - $("#dialogSelectConfirm").outerWidth(true)) / 2;
			var y = (h - $("#dialogSelectConfirm").outerHeight(true)) / 2;
			
			/*if(y<0){
				y=0;
			}*/

			// モーダルコンテンツの表示位置を設定
			$("#dialogSelectConfirm").css({'left': x + 'px','top': y + 'px'});
		}

		$('.modal-close').off().click(function(){
			// モーダルコンテンツとオーバーレイをフェードアウト
			$("#dialogSelectConfirm").fadeOut('slow');
			$('.modal-overlay').fadeOut('slow',function(){
				// オーバーレイを削除
				$('.modal-overlay').remove();
				// エラーメッセージ削除
				$("#error-messages").text("");
			});
		});

		$('.modal-overlay').on('click',function(){
			// モーダルコンテンツとオーバーレイをフェードアウト
			$("#dialogSelectConfirm").fadeOut('slow');
			$('.modal-overlay').fadeOut('slow',function(){
				// オーバーレイを削除
				$('.modal-overlay').remove();
				// エラーメッセージ削除
				$("#error-messages").text("");
			});
		});
});