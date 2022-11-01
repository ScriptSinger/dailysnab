<?php
	$row = $member['admin_attribute_users']['row'];
	

	echo mb_strtolower('Пользователь');

	$tr = '';
	foreach($row as $i => $m){
		$flag_insert = '';
		if($m['flag_insert']==2){
			$flag_insert = 'qrq';
		}elseif($m['flag_insert']==3){
			$flag_insert = 'Пользователь';
		}
		$tr .= '	<tr>
					<td>'.$m['attribute'].'</td>
					<td>'.$m['attribute_value'].'</td>
					<td>'.$flag_insert.'</td>
				</tr>
		';
	}
	
	
	$code .= '				
					<div class="container">
					<h3 class="text-center">
							Значения Полей (пользователей, qrq)
					</h3>
					
				

					<table id="users_attr" class="table table-striped table-bordered" style="width:100%">
        <thead>
							<th>Поле</th>
							<th>Значение</th>
							<th>Кто внес</th>
						</thead>
        <tbody>
           '.$tr.'
           
        </tbody>
        <tfoot>
           <tr>
              <th>Поле</th>
							<th>Значение</th>
							<th>Кто внес</th>
            </tr>
        </tfoot>
    </table>
				
				<script>$(document).ready(function () {
    $("#users_attr").DataTable( {
        "language": {
            "lengthMenu": "Отображать по _MENU_ элементов на странице",
            "zeroRecords": "Пусто",
            "info": "Страница _PAGE_ из _PAGES_",
            "infoEmpty": "Нет записей",
            "infoFiltered": "(filtered from _MAX_ total records)",
            "paginate": {
			        "first":      "Начало",
			        "last":       "Конец",
			        "next":       "Дальше",
			        "previous":   "Назад"
			    },
			 "search": "Поиск:"
        }
    });
}); </script>

					</div>

			';

			
			
			
?>