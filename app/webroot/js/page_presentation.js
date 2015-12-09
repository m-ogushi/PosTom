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
//function selectObject(element){
		/* 確認ダイアログの表示 */
		
		$(this).css("background-color", "#FC6");
		$('#session_make_btn').css('display', 'none');
		$('#session_save_btn').css('display', '');
		$('#session_delete_btn').css('display', '');
		
		$(':hidden[id="PresentationSessionid"]').val($(this).attr("id").replace(/Presentable/g,""));
		$(':text[id="PresentationRoom"]').val($(this).children(".Room").text());
		$(':text[id="PresentationSessionOrder"]').val($(this).children(".Session_order").text());
		$(':text[id="PresentationPresentationOrder"]').val($(this).children(".Presentation_order").text());
		$(':text[id="PresentationTitle"]').val($(this).children(".Title").text());
		$(':text[id="PresentationAuthor"]').val($(this).children(".Author").text());
		$('#Session').val($(this).children(".Sessionvalue").text());
		$( "#dialogSelectConfirm" ).dialog({
			resizable: false,
			modal: true,
			buttons: {
			"Yes": function() {
				$('#PresentationForm').submit();
				$( this ).dialog( "close" );
			},
			"No": function() {
				$( this ).dialog( "close" );
			}
			}
		});
});
$("#plus").on('click',function(){
		$('#session_make_btn').css('display', '');
		$('#session_save_btn').css('display', 'none');
		$('#session_delete_btn').css('display', 'none');
		
		$( "#dialogSelectConfirm" ).dialog({
			resizable: false,
			modal: true,
			buttons: {
			"Yes": function() {
				$('PresentationEditForm').submit();
				$( this ).dialog( "close" );
			},
			"No": function() {
				$( this ).dialog( "close" );
			}
			}
		});
});
});
