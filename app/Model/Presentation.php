<?php
ini_set('auto_detect_line_endings', true);
class Presentation extends AppModel {
	public function loadCSV($filename){
			$this->begin();
			try{
				// ��x�A���ׂẴf�[�^���폜����O�ɑΏۂƂȂ�v���[���e�[�V�������֘A�t������Ă���|�X�^�[�̃f�[�^������������
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

	// �֘A�ς݃v���[���e�[�V�������폜���悤�Ƃ���Ƃ��A������Q�Ƃ���|�X�^�[������ꍇ�A�|�X�^�[�̏���ύX���鏈��
	public function checkRelatedPoster(){
		// �����_�ł́A��x���ׂẴv���[���e�[�V�����̃f�[�^���폜���邽�߁A���ׂẴf�[�^���擾����
		$presentations = $this->requestAction('/presentations/getall');
		// �폜�Ώۃv���[���e�[�V�������|�X�^�[�f�[�^�Ŋ֘A�t������Ă��邩�ǂ����`�F�b�N
		foreach($presentations as $id => $presentation){
			// �폜�Ώۃv���[���e�[�V������ID��ϐ��Ɋi�[
			$target_id = $presentation['Presentation']['id'];
			// �폜�Ώۃv���[���e�[�V�������֘A�t��ID�Ƃ��Ă���|�X�^�[�̏����X�V����
			self::updateRelatedPoster($target_id);
		}
	}

	// ������ID���֘A�t��ID�Ƃ��ĕێ����Ă���|�X�^�[�̏����X�V����
	public function updateRelatedPoster($target_id){
		// �Ώ�ID���֘A�t��ID�Ƃ��ĕێ����Ă���|�X�^�[���擾
		$posters = $this->requestAction('/posters/getRelatedPoster/'.$target_id);
		foreach($posters as $id => $poster){
			// �֘A�t��ID�̍��ڂ��������i0�j�ɂ���
			$this->requestAction('/posters/initRelatedPoster/'.$poster['Poster']['id']);
		}
	}
}
?>
