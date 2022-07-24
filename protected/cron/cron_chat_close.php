<?php
/**
 * Крон - Проверка закрытия темы у сообщений   /cron/chat_close/  
 */
	$code = '';
	$current_date = date('Y-m-d', time()); 
	
	//$today = date("Y-m-d");
	//$date = date('Y-m-d', strtotime('+1 month', $today));	

	// компании, которым отсылаем отчет(уведомление) -30 дней 
	$sql = "	SELECT t.folder_id, t.company_id, t.ticket_exp, t.ticket_status, t.data_insert, tf.status
				FROM tickets t, tickets_folder tf
				WHERE t.ticket_status = 1 AND t.folder_id = tf.id and tf.status<>2 AND t.ticket_exp LIKE '%предложил закрыть тему%' 
				AND t.data_insert < DATE_ADD(CURDATE(), INTERVAL -30 DAY)
				ORDER BY t.data_insert";

	
	$row = PreExecSQL_all($sql,array());
	
	//var_dump(count($row));
	//die;
	
	if(count($row)>0){
	
		foreach($row as $k=>$m){
		
			$folder_id = $m['folder_id'];	
			
			//$rcm = reqChatMessages(array('company_id' => COMPANY_ID)); 
			//$company_name = $rcm[0]["name_rcmc"];
		
			//$messagetext 	= $company_name. ' закрыл тему.';
			$messagetext 	= ' Тема закрылась автоматически по истечении 30 суток.';
			
			//техн сообщение
			$STH = PreExecSQL(" INSERT INTO tickets (folder_id,company_id,ticket_exp,ticket_status) VALUES (?,?,?,?); " ,
								array($folder_id,1,$messagetext,1)); 
			//в архив					
			$STH2 = PreExecSQL(" UPDATE tickets_folder SET status=? WHERE id=?" ,
								array(2,$folder_id));
			//Логи					
			$STH3 = PreExecSQL(" INSERT INTO tickets_logs (text,company_id,action,object,object_id) VALUES (?,?,?,?,?); " ,
								array('autoclose',1,3,0,$folder_id));								
/* 		if($STH && $STH2){
			$ok = true;	
			$code = 'Тема закрыта';	
			} */			
			

										
		}
	}

?>