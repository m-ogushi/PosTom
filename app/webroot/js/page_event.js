/*-------------------------------------------------
 
  Event javascript
 
 --------------------------------------------------*/
 
 /********************************************************
 *		グローバルナビゲーション カレント処理					*
 ********************************************************/
$(function(){
	switch(action){
		case 'index':
			// actionがindexであればロゴにcurrent
			// TODO: ロゴにcurrentしたときのデザイン考え中…
			
			// グローバルメニューを選択不可状態に
			//$('#dashboard').css('background-color', '#eee');
			$('#dashboard #gNav').addClass('disabled');
			$('#dashboard #gNav li').each(function(index, element) {
                $(this).children('a').attr('href', 'javascript:void(0)');
            });
			break;
		case 'view':
			// actionがviewであればDashboardにcurrent
			$('#dashboard #gNav #gNavDas').addClass('current');	
	}
});

// 「Add Presentation From CSV File」ボタンを押すと、ファイル選択ボタンを作動させる
function selectFile(){
	$('#selectFile').trigger('click');
}
