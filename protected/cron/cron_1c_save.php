<?php
/**
 * Крон - Сохраняем из 1С переданные данные (справочники и исполненные заказы, а также ранее переданные купленные)
	https://questrequest.ru/cron/cron_1c_save
 */
 
  error_reporting( E_ALL | E_STRICT );
 

	// 
	$sql = "	SELECT c.id, c.id_1c
			FROM company c
			WHERE c.id_1c<>'' ";

	$row = PreExecSQL_all($sql,array());
	

	foreach($row as $k=>$m){

		if(strlen($m['id_1c'])==36){
			
			echo '<br/>'.$m['id_1c'].'<br/>';


			// ОБНОВИТЬ ВСЕ из 1С И СПРАВОЧНИКИ И ДАННЫЕ
			$api->Cron1cSave(array(	'id_1c' 				=> $m['id_1c'],
									'id'					=> $m['id']
									));


		}

	}



?>