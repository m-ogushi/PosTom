/*-------------------------------------------------

  Event javascript

 --------------------------------------------------*/

 /********************************************************
 *		グローバルナビゲーション カレント処理					*
 ********************************************************/
$(function(){
	switch(action){
		case 'index':
			$('#dashboard #gNav #gNavSet').addClass('current');
			break;
		case 'eventedit':
			$('#dashboard #gNav #gNavSet').addClass('current');
			break;
	}
});

// 「Add Presentation From CSV File」ボタンを押すと、ファイル選択ボタンを作動させる
function selectFile(){
	$('#selectFile').trigger('click');
}
