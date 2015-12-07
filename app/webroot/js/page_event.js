/*-------------------------------------------------

  Event javascript

 --------------------------------------------------*/

 /********************************************************
 *		グローバルナビゲーション カレント処理					*
 ********************************************************/
$(function(){
	switch(action){
		case 'index':
			disabledGNav();
			break;
		case 'add':
			disabledGNav();
			break;
		case 'view':
			$('#dashboard #gNav #gNavDas').addClass('current');
			break;
	}
});

// 「Add Presentation From CSV File」ボタンを押すと、ファイル選択ボタンを作動させる
function selectFile(){
	$('#selectFile').trigger('click');
}
