<?php
/**
 * Крон - 	Отправляет на почту отчет о событиях за сутки из (slov_notification). 
 */

	// компании, которым отсылаем отчет(уведомление)
	$sql = "	SELECT n.login_id, n.company_id, c.company, l.email
			FROM notification_cron_send_1800 n, company c, login l
			WHERE n.login_id=l.id AND n.company_id=c.id AND l.email LIKE '%@%' AND NOT l.email LIKE 'AMO_%'
			GROUP BY n.login_id, n.company_id, c.company  ";

	$row = PreExecSQL_all($sql,array());

	foreach($row as $k=>$m){

			$sql = "	SELECT sn.notification_email, COUNT(n.id) kol, sn.sort, ncp.notification_param_id
					FROM slov_notification sn, notification_cron_send_1800 n
					LEFT JOIN notification_company_param ncp ON ncp.flag=2 AND ncp.company_id=n.company_id AND ncp.notification_id=n.notification_id
					WHERE n.notification_id IN (2,3,5,6,7,8,13) AND n.notification_id=sn.id 
							AND n.login_id=".$m['login_id']." AND n.company_id=".$m['company_id']."
					GROUP BY sn.notification_email
					ORDER BY sn.sort ";

			$row2 = PreExecSQL_all($sql,array());

			$text = '';
			foreach($row2 as $k=>$mm){		
							
					$text .= $mm['notification_email'].' - <strong>'.$mm['kol'].'</strong><br/>';
					

			}
			
			//$m['email'] = 'vdo81@yandex.ru';
			
			sleep(2);
			
			echo $m['company_id'].'<br/>';
			$tes->LetterSendNotificationEmail1800(array(	'text'			=> $text,
														'email'			=> $m['email'],
														'name'			=> $m['company'] ));

		// удаляем отчет(уведомление)
			$STH = PreExecSQL(" DELETE FROM notification_cron_send_1800 WHERE login_id=? AND company_id=?; " ,
									array( $m['login_id'],$m['company_id']));
			
	}

?>