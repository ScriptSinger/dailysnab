<?php
/**
 * Крон - Ручной режим - Запускаем все обновления из 1С (ранее они были получены из 1С)

 */
 
  error_reporting( E_ALL | E_STRICT );
 

	// 
	$sql = "	SELECT c.id, c.id_1c , t.company_id,
					(SELECT t.id FROM company_vip_function t WHERE t.company_id=c.id AND vip_function_id=1
					) flag_ispolnen,	/*включена исполение на странице навыки*/
					(SELECT t.id FROM company_vip_function t WHERE t.company_id=c.id AND vip_function_id=2
					) flag_ostatki		/*включена на странице навыки*/
			FROM company c , 1c_refresh_all t
			WHERE t.company_id=c.id ";

	$row = PreExecSQL_all($sql,array());
	

	foreach($row as $k=>$m){

			echo '<br/>'.$m['id_1c'].'<br/>';
			
			$file = '/qrq/1C/'.$m['id_1c'].'/refresh.json';
			
			if(file_exists($_SERVER['DOCUMENT_ROOT'].$file)){
				
				$rez = $g->deleteFile($file);
				
				if($rez){
					$STH = PreExecSQL(" DELETE FROM 1c_refresh_all WHERE company_id=? " ,
										array($m['company_id']));


					// ОБНОВИТЬ ВСЕ из 1С И СПРАВОЧНИКИ И ДАННЫЕ
					$api->Cron1cSave(array(	'id_1c' 		=> $m['id_1c'],
											'flag_ispolnen'	=> $m['flag_ispolnen'],
											'flag_ostatki'	=> $m['flag_ostatki'],
											'id'			=> $m['id'] ));
				}
			}

	}



?>