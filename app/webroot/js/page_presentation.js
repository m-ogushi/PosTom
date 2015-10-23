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
