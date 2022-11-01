<?php
	class core_BaseModel
	{	
		

		


		

		


		
		//Суммы по месяцам за определенный год (для графиков)
		function MonthProfitCost($contractor_id=false,$year=false) {
			$sql_cotracrot = ($contractor_id)? 'AND t.contractor_id='.$contractor_id.'' : 'AND c.active=0';
			$sql = "	SELECT sm.month_id, IFNULL(qw.profit,0) profit, IFNULL(qw.cost,0) cost 
					FROM (
							SELECT DATE_FORMAT(t.date_total,'%c') mm,
								SUM(t.sale-(t.buy+t.supply))-IFNULL((SELECT IFNULL(SUM(summa),0) summa FROM cost WHERE total_id=t.id),0) profit, 
								IFNULL((SELECT IFNULL(SUM(summa),0) summa FROM cost WHERE total_id=t.id),0) cost
							FROM total t, contractor c
							WHERE c.id=t.contractor_id AND DATE_FORMAT(t.date_total,'%Y')=".$year." 
									".$sql_cotracrot."
							GROUP BY DATE_FORMAT(t.date_total,'%c')
					) qw
					RIGHT JOIN slov_month sm ON sm.month_id=qw.mm
					ORDER BY sm.month_id ";
			$row = ExecSQL_Select($sql)->fetchAll();
			
			return $row;
		}		
		
	}

?>