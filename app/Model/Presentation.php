<?php
ini_set('auto_detect_line_endings', true);
class Presentation extends AppModel {
	public function loadCSV($filename){
			$this->begin();
			try{
				// ˆê“xA‚·‚×‚Ä‚Ìƒf[ƒ^‚ðíœ‚·‚é‘O‚É‘ÎÛ‚Æ‚È‚éƒvƒŒƒ[ƒ“ƒe[ƒVƒ‡ƒ“‚ªŠÖ˜A•t‚¯‚³‚ê‚Ä‚¢‚éƒ|ƒXƒ^[‚Ìƒf[ƒ^‚ð‰Šú‰»‚·‚é
				self::checkRelatedPoster();
				$handle = fopen($filename,"r");
				while(($row = fgetcsv($handle, 1000, ",")) !== FALSE){
					mb_convert_variables("UTF-8", "auto", $row);
					$presenData = array(
						'room' => $row[0],
						'session_order' => $row[1],
						'presentation_order' => $row[2],
						'date' => $row[3],
						'title' => $row[4],
						'abstract' => $row[5],
						'keyword' =>  $row[6],
						'authors_name' => $row[7],
						'authors_affiliation' => $row[8],
						'event_id' => $_SESSION['event_id']
					);
					if($row[0] != "room") {
							$this->create($presenData);
							$this->save();
					}
				}
				$this->commit();
			}catch(Exception $e){
				$this->rollback();
			}
	}

	// ŠÖ˜AÏ‚ÝƒvƒŒƒ[ƒ“ƒe[ƒVƒ‡ƒ“‚ðíœ‚µ‚æ‚¤‚Æ‚·‚é‚Æ‚«A‚»‚ê‚ðŽQÆ‚·‚éƒ|ƒXƒ^[‚ª‚ ‚éê‡Aƒ|ƒXƒ^[‚Ìî•ñ‚ð•ÏX‚·‚éˆ—
	public function checkRelatedPoster(){
		// Œ»Žž“_‚Å‚ÍAˆê“x‚·‚×‚Ä‚ÌƒvƒŒƒ[ƒ“ƒe[ƒVƒ‡ƒ“‚Ìƒf[ƒ^‚ðíœ‚·‚é‚½‚ßA‚·‚×‚Ä‚Ìƒf[ƒ^‚ðŽæ“¾‚·‚é
		$presentations = $this->requestAction('/presentations/getall');
		// íœ‘ÎÛƒvƒŒƒ[ƒ“ƒe[ƒVƒ‡ƒ“‚ªƒ|ƒXƒ^[ƒf[ƒ^‚ÅŠÖ˜A•t‚¯‚³‚ê‚Ä‚¢‚é‚©‚Ç‚¤‚©ƒ`ƒFƒbƒN
		foreach($presentations as $id => $presentation){
			// íœ‘ÎÛƒvƒŒƒ[ƒ“ƒe[ƒVƒ‡ƒ“‚ÌID‚ð•Ï”‚ÉŠi”[
			$target_id = $presentation['Presentation']['id'];
			// íœ‘ÎÛƒvƒŒƒ[ƒ“ƒe[ƒVƒ‡ƒ“‚ðŠÖ˜A•t‚¯ID‚Æ‚µ‚Ä‚¢‚éƒ|ƒXƒ^[‚Ìî•ñ‚ðXV‚·‚é
			self::updateRelatedPoster($target_id);
		}
	}

	// ˆø”‚ÌID‚ðŠÖ˜A•t‚¯ID‚Æ‚µ‚Ä•ÛŽ‚µ‚Ä‚¢‚éƒ|ƒXƒ^[‚Ìî•ñ‚ðXV‚·‚é
	public function updateRelatedPoster($target_id){
		// ‘ÎÛID‚ðŠÖ˜A•t‚¯ID‚Æ‚µ‚Ä•ÛŽ‚µ‚Ä‚¢‚éƒ|ƒXƒ^[‚ðŽæ“¾
		$posters = $this->requestAction('/posters/getRelatedPoster/'.$target_id);
		foreach($posters as $id => $poster){
			// ŠÖ˜A•t‚¯ID‚Ì€–Ú‚ð‰Šú‰»i0j‚É‚·‚é
			$this->requestAction('/posters/initRelatedPoster/'.$poster['Poster']['id']);
		}
	}
}
?>
