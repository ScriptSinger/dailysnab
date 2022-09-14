<?php
/**
 * Крон - Ручной режим - Запускаем все обновления из 1С (ранее они были получены из 1С)

 */
 
  error_reporting( E_ALL | E_STRICT );
 

	// 
	$sql = "	SELECT c.id, c.id_1c , t.company_id
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
					$api->Cron1cSave(array(	'id_1c' 				=> $m['id_1c'],
											'id'					=> $m['id'] ));
				}
			}

	}



?>