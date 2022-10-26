<?php
	$row 			= $member['admin_nosend_email']['row'];
	$flag 			= $member['admin_nosend_email']['flag'];
	

	
	$tr = '';
	foreach($row as $i => $m){
		$tr .= '	<tr>
					<td>'.$m['email'].'</td>
					<td><span class="delete_admin_nosend_email" data-id="'.$m['id'].'">удалить</span></td>
				</tr>
		';
	}
	
	
	$code .= '				
				<div class="container">
					<h3 class="text-center">
						Email исключенный из отправки
					</h3>
					
					'.$t->NavTabsAdminUsers(array('flag'=>$flag)).'
					
					<div>
						'.$e->Input(	array(	'type'			=> 'button',
												'class'			=> 'profile-btn request-btn modal_nosend_email',
												'value'			=> 'Добавить email'
										)
								).'
					</div>

					
		<table id="users" class="table table-striped table-bordered" style="width:100%">
			<thead>
				<tr>
					<th>Email</th>
					<th></th>
				</tr>
			</thead>
			<tbody>
			   '.$tr.'
			   
			</tbody>
			<tfoot>
			   <tr>
					<th>Email</th>
					<th></th>
				</tr>
			</tfoot>
		</table>
				
<script>

$(document).ready(function () {
    $("#users").DataTable( {
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
});

</script>

</div>

';
	
?>