<?php
	$row 			= $member['admin_users']['row'];
	$row_account		= $member['admin_users']['row_account'];
	$flag 			= $member['admin_users']['flag'];
	
	
	$h3_small = '';
	$cl_btn1 = $cl_btn2 = 'btn-light';
	if($flag=='login_id'){
		$h3_small = '<small>компании профиля '.$row_account['company'].'</small>';
	}elseif($flag=='company'){
		$cl_btn2 = 'btn-info';
	}elseif($flag=='account'){
		$cl_btn1 = 'btn-info';
		
	}
	
	$tr = '';
	foreach($row as $i => $m){
		$count_company = '';
		$phone = (!empty($m['phone'])) ? $m['phone'] : 'Отсутсвует';
		$email = (!empty($m['email'])) ? $m['email'] : 'Отсутсвует';
		$text = "Номер телефона: $phone <br> Почта: $email";
				if($flag=='account'){
			$str = $g->format_by_count($m['count_company'], 'компания', 'компании', 'компаний');
			$count_company = '<div>
								<a href="/admin_users/'.$m['login_id'].'/'.$m['id'].'" class="badge badge-primary">'.$m['count_company'].' '.$str.'</a>
							</div>';
		}
		$pro_mode = ($m['pro_mode'])? 'Отключить' : 'Подключить';
		
		$active = ($m['active']==2)? '<div>
										<span class="badge badge-danger">НЕ АКТИВНА</span>
									</div>' : '';

      
		$tr .= '	<tr>
					<td>'.$m['dmy_data_insert'].'</td>
					<td><img src="/images/profile.png" alt="" class="rounded" height="50"/></td>
					<td>
						'.$m['company'].'
						'.$active.'
						'.$count_company.'
						<button class="modal_admin_company" data-id="'.$m['id'].'">
							<img src="/image/status-edit.svg" alt="" class="status-request">
						</button>
					</td>
					<td>
						' . $text . '
					</td>
					<td><button class="change-btn admin_pro_mode" data-id="'.$m['id'].'">'.$pro_mode.'</button></td>
				</tr>
		';
	}
	
	
	$code .= '				
				<div class="container">
					<h3 class="text-center">
						Пользователи
						<div>'.$h3_small.'</div>
					</h3>
					
					<div >
						<a href="/admin_users" class="btn '.$cl_btn1.' btn-sm">Пользователи</a>

						<a href="/admin_users/company" class="btn '.$cl_btn2.' btn-sm">Компании</a>
					</div>
					
					<table id="example" class="table table-striped table-bordered" style="width:100%">
        <thead>
            <tr>
               <th>Дата регистрации</th>
							<th>Аватар</th>
							<th>Наименование</th>
							<th>Контакты</th>
							<th>Pro режим</th>
            </tr>
        </thead>
        <tbody>
           '.$tr.'
           
        </tbody>
        <tfoot>
           <tr>
                <th>Дата регистрации</th>
							<th>Аватар</th>
							<th>Наименование</th>
							<th>Контакты</th>
							<th>Pro режим</th>
            </tr>
        </tfoot>
    </table>
				
				<script>$(document).ready(function () {
    $("#example").DataTable( {
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