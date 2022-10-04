<?php
/*
	 *  Элементы (шаблоны)
	 */

class HtmlTemplate extends HtmlServive
{
    /*
	 *	Верстка
	 */
    //левая колонка
    function indexLeftCol($menuleft = false, $content = false, $col = false)
    {
        return '
					<div class="col-md-'.$col.'">
						'.$menuleft.'
					</div>
					<div class="col-md-'.(12 - $col).'">
						'.$content.'
					</div>
				';
    }


    /*
	 *	МОДАЛЬНОЕ ОКНО
	 */
    //модальное окно
    function getModal($modal = array(), $form = array(), $arr = array())
    {
        $f = ($form['id']) ? '<form id="'.$form['id'].'" class="'.$form['class'].'" role="form">' : '';
        $f_ = ($form['id']) ? '</form>' : '';

        $modal['class_dialog'] = isset($modal['class_dialog']) ? $modal['class_dialog'] : '';
        $modal['class_content'] = isset($modal['class_content']) ? $modal['class_content'] : '';
        $modal['class_body'] = isset($modal['class_body']) ? $modal['class_body'] : '';

        $modal['top'] = isset($modal['top']) ? $modal['top'] : '';
        $bottom = isset($modal['bottom']) ? $modal['bottom'] : '';
        /*$bottom_close	= (isset($arr['bottom_noclose'])&&($arr['bottom_noclose']))? '' : '<button type="button" class="btn btn-default"
																						data-dismiss="modal">Закрыть</button>';*/
        $size = (isset($arr['size']) && ($arr['size'])) ? $arr['size'] : '';

        $html = '
			  <div class="modal-dialog '.$modal['class_dialog'].' '.$size.'" role="document">
				<div class="modal-close-wrap">
					<div class="modal-close" data-dismiss="modal">&#215;</div>
				</div>
				<div class="modal-content '.$modal['class_content'].'">
					'.$f.'
						<div class="modal-body '.$modal['class_body'].'">
							'.$modal['top'].'
							'.$modal['content'].'
							'.$bottom.'
						</div>
								
					'.$f_.'
				</div>
			  </div>
				';
        /*
		$html = '
			  <div class="modal-dialog '.$size.'" role="document">
				<div class="modal-content">
				  <div class="modal-header">
					<h4 class="modal-title">'.$modal['top'].'</h4>
					<button type="button" class="close" data-dismiss="modal" aria-label="Close">
					  <span aria-hidden="true">&times;</span>
					</button>
				  </div>
					'.$f.'
						  <div class="modal-body">
								'.$modal['content'].'
						  </div>
						  <div class="modal-footer">
								'.$bottom.'
								'.$bottom_close.'
						  </div>
					'.$f_.'
				</div>
			  </div>
				';
		*/
        return $html;
    }


    // Изображение Заявка/Объявление
    function FilesListBuySell($p = array())
    {
        $code = '';
        $empty = $delete = false;
        $r = array();
        //$in 		= fieldIn($p, array('where'));
        $p['buy_sell_id'] = (isset($p['buy_sell_id']) && !empty($p['buy_sell_id'])) ? $p['buy_sell_id'] : '';// параметры Помещения

        $file_types = array('jpg', 'jpeg', 'gif', 'png', 'bmp');// изображения

        $r = reqBuySellFiles(array('buy_sell_id' => $p['buy_sell_id']));
        $id_uniq = $p['buy_sell_id'];

        $delete = true;

        if (!empty($r)) {

            foreach ($r as $k => $m) {
                $elem = 'li_file'.$k.$id_uniq;

                $del = ($delete) ? '<span class="delete_file_buy_sell" style=""
																title="Удалить файл<br/>'.$m['name_file'].'"
																data-value="'.$m['id_md5'].'"
																data-name="'.$m['name_file'].'"
																data-elem="'.$elem.'">удалить</span>' : '';
                // предпросмотр изображения
                $img = '';

                $img = $this->Img(array('src' => $m['path'],
                    'wh' => 50,
                    'dopol' => 'style="margin-right:20px;"'));

                $code .= ' 	<div id="'.$elem.'" style="margin-bottom:5px;">
								<a href="'.$m['path'].'">'.$img.''.$m['name_file'].'</a>
								'.$del.'
							</div>';
            }

            if ($code) {
                $code = '<div class="container_files_orders" style="margin-top:5px;">
								'.$code.'
							</div>';
            }

        } else {
            $empty = true;
        }

        return array('code' => $code, 'empty' => $empty);
    }

    // изображение к заявке/объявление
    function getImgBuySell($p = array())
    {

        $code = $first_img = '';

        $row = reqBuySellFiles(array('buy_sell_id' => $p['buy_sell_id']));

        foreach ($row as $k => $m) {
            $ac = '';
            if ($k == 0) {
                $ac = 'class="activeSlide"';
                $first_img = '<img src="'.$m['path'].'" alt="photo">';
            }
            $code .= '<img src="'.$m['path'].'" alt="photo" '.$ac.'>';
        }

        return array('code' => $code, 'first_img' => $first_img);
    }


    //Сообщение пользователю после нажатия кнопки "Сбросить текущий пароль"
    function getAfterLetterSendRestorePassword($p = array())
    {

        $code = '<div class="page-header">
					<h2>Восстановление доступа</h2>
				</div>
				На электронную почту <b>'.$p['email'].'</b> отправлено письмо. 
				Перейдите по ссылке в письме, чтобы задать новый пароль от вашей учетной записи.
				<div class="text-muted" style="margin:15px 0px;">
					Если вы не видите письма, обязательно проверьте папку СПАМ.
				</div>
				<a href="/" class="btn btn-primary btn-block">На главную</a>
				';

        return $code;
    }


    // Администрирование - Категории матрица
    function TableTrAdminCategories($p = array())
    {
        $code = '';
        $in = fieldIn($p, array('parent_id', 'level'));
        $arr_attribute = ($p['arr_attribute']) ? $p['arr_attribute'] : array();
        $in['parent_id'] = ($in['parent_id']) ? $in['parent_id'] : 0;
        $in['level'] = ($in['level']) ? $in['level'] : 0;

        // пустые td
        $td_attribute = '';
        foreach ($arr_attribute as $k) {
            $td_attribute .= '<td class=""></td>';
        }

        $tr = '';
        $row = reqSlovCategories(array('parent_id' => $in['parent_id']));
        foreach ($row as $i => $m) {
            $add_categories = $change_level = '';
            $st_ml = $in['level'] * 100;
            if ($in['level'] <> 3) {
                $add_categories = '<span class="modal_admin_categories" title="Добавить под категорию" style="font-size:26px;cursor:pointer;"
														data-parent_id="'.$m['id'].'"
														data-level="'.($m['level'] + 1).'">+</span>';
            }
            $cl_span = ($m['active'] == 2) ? 'text-muted' : '';

            // перенести в другую категорию
            if ($in['level'] > 0) {
                $change_level = '<span class="modal_admin_change_level_categories" title="Перенести в другую категорию" style="font-size:26px;cursor:pointer;"
																						data-id="'.$m['id'].'"
																						data-level="'.($m['level'] + 1).'">*</span>';
            }
            //

            // последний уровень (отмечаем параметр)
            if ($in['level'] == 3) {
                // выбранные
                $r = reqCategoriesAttribute(array('flag' => 'group_attribute_id', 'categories_id' => $m['id']));
                $arr_attribute_id = explode(',', $r['attribute_id']);
                $td_attribute = '';
                foreach ($arr_attribute as $k => $a) {
                    $cl_td = '';
                    $active = '2';
                    $st_dn_sort = '';//'display:none;';
                    $id_sort = $value_sort = 0;
                    foreach ($arr_attribute_id as $a2) {
                        $arr_a2 = explode('*', $a2);
                        if ($k == $arr_a2[0]) {
                            //$cl_td 		= 'bg-success';
                            $cl_td = 'table-active';
                            $active = '1';
                            $st_dn_sort = '';
                            $id_sort = $arr_a2[1];
                            $value_sort = $arr_a2[2];
                        }
                    }

                    $td_attribute .= '	<td class="td_attribute  '.$cl_td.'" style="cursor:crosshair;" title="'.$m['categories'].' | '.$a.'"
																					data-toggle="tooltip" 
																					data-placement="bottom"
																				data-categories_id="'.$m['id'].'"
																				data-attribute_id="'.$k.'"
																				data-active="'.$active.'">
											'.$this->Input(array('type' => 'text',
                                'id' => 'sort'.$m['id'].$k,
                                'class' => 'form-control form-control-sm float-right text-center change_sort',
                                'value' => $value_sort,
                                'placeholder' => '',
                                'dopol' => 'style="width:50px;'.$st_dn_sort.'"',
                                'data' => array('table' => 'categories_attribute', 'id' => $id_sort)
                            )
                        ).'										
										</td>';
                }


            }
            ///


            $tr .= '<tr class="level-'.($m['level'] + 1).'">
						<td style="padding-left:'.$st_ml.'px;">
							<span class="'.$cl_span.' sp_a modal_admin_categories" title="Редактировать"
														data-toggle="tooltip" 
														data-placement="bottom"
														data-id="'.$m['id'].'">'.$m['categories'].'</span>
							'.$this->Input(array('type' => 'text',
                        'id' => 'sort'.$m['id'],
                        'class' => 'form-control form-control-sm text-center change_sort',
                        'value' => $m['sort'],
                        'placeholder' => '',
                        'dopol' => 'style="width:50px;"',
                        'data' => array('table' => 'slov_categories', 'id' => $m['id'])
                    )
                ).'
							'.$add_categories.'
							'.$change_level.'
						</td>
						'.$td_attribute.'
					</tr>
			';
            /*
			$tr .= '<tr >
						<td style="padding-left:'.$st_ml.'px;">
							<span class="'.$cl_span.' sp_a modal_admin_categories" title="Редактировать"
														data-toggle="tooltip"
														data-placement="bottom"
														data-id="'.$m['id'].'">'.$m['categories'].'</span>
							'.$add_categories.'
							'.$change_level.'
							'.$this->Input(	array(	'type'			=> 'text',
													'id'			=> 'sort'.$m['id'],
													'class'			=> 'form-control form-control-sm float-right text-center change_sort',
													'value'			=> $m['sort'],
													'placeholder'	=> '',
													'dopol'			=> 'style="width:50px;"',
													'data'			=> array('table'=>'slov_categories','id'=>$m['id'])
												)
										).'
						</td>
						'.$td_attribute.'
					</tr>
			';
			*/
            $tr .= self::TableTrAdminCategories(array('parent_id' => $m['id'], 'level' => $in['level'] + 1, 'arr_attribute' => $arr_attribute));
        }

        return $tr;
    }


    // Администрирование - Категориии с атрибутами (полями) , для модального окна
    function AdminRowCategoriesAttribute($p = array())
    {
        $code = '';
        $in = fieldIn($p, array('categories_id', 'attribute_id'));

        $row_ta = reqSlovTypeAttribute();

        $row = reqCategoriesAttribute(array('categories_id' => $in['categories_id'], 'attribute_id' => $in['attribute_id'], 'flag' => 'save'));
        foreach ($row as $i => $m) {

            $delete = '';
            $r = reqProverkaDelete_CategoriesAttribute_SlovAttributeValue(array('categories_attribute_id' => $m['id']));
            if (!$r['kol']) {
                $delete = '<a class="sp_a delete_categories_attribute" data-id="'.$m['id'].'" data-text="'.$m['attribute'].'"></a>';
            }


            $checked_grouping_sell = ($m['grouping_sell']) ? 'checked' : '';
            $checked_assets = ($m['assets']) ? 'checked' : '';

            $code .= '
                    <div id="div_categories_attribute'.$m['id'].'" class="amc-row">
                        <div class="amc-col-number amc-col-4">								
								'.$this->Input(array('type' => 'text',
                        'id' => 'sort'.$m['id'],
                        'class' => 'form-control form-control-sm text-center change_sort',
                        'value' => $m['sort'],
                        'placeholder' => '',
                        'dopol' => 'style="width:50px;"',
                        'data' => array('table' => 'categories_attribute', 'id' => $m['id'])
                    )
                ).'</div>
                        <div class="amc-col-22">
                            <span class="amc-designation">'.$m['attribute'].'</span> '.$delete.'
                        </div>
                        <div class="amc-col-22">
								'.$this->SelectTypeAttribute(array('row' => $row_ta,
                    'id' => $m['buy_type_attribute_id'],
                    'm_id' => $m['id'],
                    'flag' => 'buy')).'
                        </div>
                        <div class="amc-col-22">
								'.$this->SelectTypeAttribute(array('row' => $row_ta,
                    'id' => $m['sell_type_attribute_id'],
                    'm_id' => $m['id'],
                    'flag' => 'sell')).'
                        </div>
						<div class="amc-col-22">
								'.$this->SelectAttributeValue(array('categories_id' => $in['categories_id'], 'attribute_id' => $m['attribute_id'])).'
                        </div>
                        <div class="amc-col-10">
								'.$this->Input(array('type' => 'text',
                        'id' => 'sort'.$m['id'],
                        'class' => 'form-control form-control-sm text-center save_no_empty_categories_attribute',
                        'value' => $m['no_empty_buy'],
                        'placeholder' => '',
                        'dopol' => 'style="width:50px;"',
                        'data' => array('flag' => 'buy', 'id' => $m['id'])
                    )
                ).'
                        </div>
                        <div class="amc-col-10">
								'.$this->Input(array('type' => 'text',
                        'id' => 'sort'.$m['id'],
                        'class' => 'form-control form-control-sm text-center save_no_empty_categories_attribute',
                        'value' => $m['no_empty_sell'],
                        'placeholder' => '',
                        'dopol' => 'style="width:50px;"',
                        'data' => array('flag' => 'sell', 'id' => $m['id'])
                    )
                ).'
                        </div>
                        <div class="amc-col-10">
                            <input type="checkbox" class="checkbox_grouping_sell" data-id="'.$m['id'].'" value="'.$m['grouping_sell'].'" '.$checked_grouping_sell.'/>
                        </div>
						<div class="amc-col-10">
                            <input type="checkbox" class="checkbox_assets" data-id="'.$m['id'].'" value="'.$m['assets'].'" '.$checked_assets.'/>
                        </div>
                    </div>
			
			
					';
        }

        return $code;
    }


    // Администрирование - Значения Атрибутов , при клике на атрибут
    function AdminRowAttributeValue($p = array())
    {
        $code = '';
        $in = fieldIn($p, array('attribute_id'));

        $row = reqSlovAttributeValue(array('attribute_id' => $in['attribute_id']));
        foreach ($row as $i => $m) {
            $delete = '';
            $r = reqProverkaDelete_CategoriesAttribute_SlovAttributeValue(array('slov_attribute_value_id' => $m['id']));
            if (!$r['kol']) {
                $delete = '<span class="pointer delete_slov_attribute_value" data-id="'.$m['id'].'" data-text="'.$m['attribute_value'].'" data-feather="trash"></span>';
            }

            $code .= '
					<div id="div_attribute_value'.$m['id'].'" class="row">
							<div class="col form-group">
								'.$this->Input(array('type' => 'text',
                        'id' => 'attribute_value'.$m['id'],
                        'class' => 'form-control form-control-sm update_slov_attribute_value',
                        'value' => $m['attribute_value'],
                        'data' => array('id' => $m['id'])
                    )
                ).'
							</div>
							<div class="col-1">
									'.$delete.'
							</div>
					</div>';
        }


        return $code;
    }

    // Меню - Заявки/Объявления
    function NavTabsBuySell($p = array())
    {
        $code = $li = '';
        $kol = 0;
        $in = fieldIn($p, array('flag_buy_sell', 'status_buy_sell_id', 'flag_interests_invite'));

        if ($in['flag_buy_sell'] == 1) {
            $url_priznak = 'sell';
            $pole = 'status_sell';
            $str1 = 'Мои объявления';
        } elseif ($in['flag_buy_sell'] == 2) {
            $url_priznak = 'buy';
            $pole = 'status_buy';
            $str1 = 'Мои заявки';
        }

        $row = reqSlovStatusBuySellByCompany(array('flag' => 1, 'flag_buy_sell' => $in['flag_buy_sell'], 'flag_interests_invite' => $in['flag_interests_invite']));
        foreach ($row as $i => $m) {
            $active = ($m['id'] == $in['status_buy_sell_id']) ? 'active' : '';
            $have_num = ($m['kol'] == 0) ? 'd-none' : '';
            $kol_notification = ($m['kol_notification']) ? ' <span class="badge badge-warning">'.$m['kol_notification'].'</span>' : '';

            $li .= ' 	<li class="request-menu-item '.$have_num.'">
						<button>
							<a href="/buy-sell/'.$m['url_priznak'].'/'.$m['id'].'" class="'.$active.'">
								'.$m[$pole].' <span>'.$m['kol'].'</span>'.$kol_notification.'
							</a>
						</button>
					</li>';
            $kol = $kol + $m['kol'];

        }
        $active0 = ($in['status_buy_sell_id']) ? '' : 'active';

        $code = '<div class="request-head">
						<div class="request-checking">
							<input type="checkbox" id="checkbox_checking_buysell" class="checkbox_checking_buysell" data-flag="1">
						</div>
						<ul class="request-menu">
							<li class="request-menu-item">
								<button>
									<a href="/buy-sell/'.$url_priznak.'/0" class="'.$active0.'">'.$str1.' '.$kol.'</a>
								</button>
							</li>
							'.$li.'
						</ul>
						<div class="request-head-btn">
							<img src="/image/menu-request-icon.svg" id="share_buy_sell_1" class="share_buy_sell" data-flag="1" data-change="1" alt="">
						</div>
						<div class="request-heading">
							<button class="request-btn heading-btn change-btn share_buy_sell" data-flag="2">
								Отменить
							</button>
							<button class="request-btn heading-btn inactive choose-client modal_share_buy_sell" data-flag_buy_sell="'.$in['flag_buy_sell'].'">
								Выбрать получателя
							</button>
						</div>
					</div>';


        return $code;
    }


    // Меню - Активы
    function NavTabsAssets($p = array())
    {
        $code = $li = '';
        $kol = 0;
        $in = fieldIn($p, array('status_buy_sell_id'));

        $row = reqSlovStatusBuySellByCompany(array('flag' => 3, 'flag_buy_sell' => 4));
        foreach ($row as $i => $m) {
            $active = ($m['id'] == $in['status_buy_sell_id']) ? 'active' : '';
            $have_num = ($m['kol'] == 0) ? 'd-none' : '';

            $li .= ' 	<li class="request-menu-item '.$have_num.'">
						<button>
							<a href="/assets/'.$m['id'].'" class="'.$active.'">
								'.$m['status_buy'].' <span>'.$m['kol'].'</span>
							</a>
						</button>
					</li>';
            $kol = $kol + $m['kol'];

        }
        $active0 = ($in['status_buy_sell_id']) ? '' : 'active';

        $code = '<div class="request-head">
						<ul class="request-menu">
							<li class="request-menu-item">
								<button>
									<a href="/assets" class="'.$active0.'">Мои активы '.$kol.'</a>
								</button>
							</li>
							'.$li.'
						</ul>
					</div>';


        return $code;
    }


    // Меню - Склад
    function NavTabsStock($p = array())
    {
        $code = $li = '';
        $kol = 0;
        $in = fieldIn($p, array('stock_id', 'status_buy_sell_id'));

        $row = reqNavTabsStock();
        foreach ($row as $i => $m) {
            if ($m['kol'] > 0) {
                $active = (($m['stock_id'] == $in['stock_id']) && ($m['sbs_id'] == $in['status_buy_sell_id'])) ? 'active' : '';

                $li .= ' 	<li class="request-menu-item">
							<button>
								<a href="/stock/'.$m['sbs_id'].'/'.$m['stock_id'].'" class="'.$active.'">
									'.$m['stock'].' <span>'.$m['kol'].'</span>
								</a>
							</button>
						</li>';
                $kol = $kol + $m['kol'];
            }

        }
        $active0 = ($in['stock_id']) ? '' : 'active';

        $code = '<div class="request-head">
						<ul class="request-menu">
							<li class="request-menu-item">
								<button>
									<a href="/stock" class="'.$active0.'">Мой склад '.$kol.'</a>
								</button>
							</li>
							'.$li.'
						</ul>
					</div>';


        return $code;
    }


    // Меню - Поисковые запросы / категории
    function NavTabsAdminSearch($p = array())
    {
        $code = $active1 = $active2 = '';
        $in = fieldIn($p, array('flag'));

        if ($in['flag'] == 1) {
            $active1 = 'active';
        } elseif ($in['flag'] == 2) {
            $active2 = 'active';
        }

        $code = '	<ul class="nav nav-tabs">
						<li class="nav-item">
							<a href="/admin_search/1" class="nav-link '.$active1.'">Поисковые запросы</a>
						</li>
						<li class="nav-item">
							<a href="/admin_search/2" class="nav-link '.$active2.'">Категории</a>
						</li>
					</ul>';

        return $code;
    }

    // Меню - Подписки
    function NavTabsSubscriptions($p = array())
    {
        $code = $active1 = $active2 = '';
        $in = fieldIn($p, array('views', 'kol'));

        $row_kol_my = reqCompany(array('flag' => 'subscriptions-my', 'kol' => true));
        $row_kol_me = reqCompany(array('flag' => 'subscriptions-me', 'kol' => true));

        $views_profile = $views_profile_buy = $views_profile_sell = $views_my = $views_me = '';

        if ($in['views'] == 'profile') {                // Все пользователи
            $views_profile = 'active';
        } elseif ($in['views'] == 'profile-buy') {    // Покупатели
            $views_profile_buy = 'active';
        } elseif ($in['views'] == 'profile-sell') {    // Продавцы
            $views_profile_sell = 'active';
        } elseif ($in['views'] == 'my') {                // Подписки
            $views_my = 'active';
        } elseif ($in['views'] == 'me') {                // Подписчики
            $views_me = 'active';
        }

        $code = '	
				<div class="request-head">
					<div class="request-checking">
						<input type="checkbox">
					</div>
					<ul class="request-menu">
						<li class="request-menu-item">
							<button>
								<a href="/subscriptions/profile" class="nav-link '.$views_profile.'">Все пользователи</a>
							</button>
						</li>
						<li class="request-menu-item">
							<button>
								<a href="/subscriptions/profile-buy" class="nav-link '.$views_profile_buy.'">Все покупатели</a>
							</button>
						</li>
						<li class="request-menu-item">
							<button>
								<a href="/subscriptions/profile-sell" class="nav-link '.$views_profile_sell.'">Все продавцы</a>
							</button>
						</li>
						<li class="request-menu-item">
							<button>
								<a href="/subscriptions/my" class="nav-link '.$views_my.'">Подписки  <span id="count_subscriptions">'.$row_kol_my['kol'].'</span></a>
							</button>
						</li>
						<li class="request-menu-item">
							<button>
								<a href="/subscriptions/me" class="nav-link '.$views_me.'">Подписчики  <span>'.$row_kol_me['kol'].'</span></a>
							</button>
						</li>
					</ul>
				</div>';

        return $code;
    }


    // Заявка/Объявление - Атрибуты за категорией
    function CategoriesAttributeBuySell($p = array())
    {
        $code = $code_elem = '';
        $in = fieldIn($p, array('flag_buy_sell', 'categories_id', 'buy_sell_id', 'status', 'flag', 'parent_id',
            'nomenclature', 'nomenclature_id', 'search_categories', 'search_categories_id'));

        $row_bs = isset($p['row_bs']) ? $p['row_bs'] : array();

        if (($in['flag_buy_sell'] == 2) && PRO_MODE && ($in['flag'] == 'change_categories')) {// предзаполненные поля, Значения, которые предзаполняются, берутся из предыдущей заявки.

            $rb = reqBuySell_LastId();

            $rbs = ($rb['id']) ? reqBuySell_FormBuyAmount(array('id' => $rb['id'])) : '';

            if (!empty($rbs)) {
                $in['buy_sell_id'] = $rbs['id'];
                $in['parent_id'] = $rbs['parent_id'];
                $row_bs = $rbs;
            }

        }


        if ($in['flag_buy_sell'] == 1 || $in['flag_buy_sell'] == 4) {
            $pole1 = 'sell_type_attribute_id';
            $pole2 = 'sell_flag_value';
            $pole3 = 'no_empty_sell';
        } else {
            $pole1 = 'buy_type_attribute_id';
            $pole2 = 'buy_flag_value';
            $pole3 = 'no_empty_buy';
        }

        $categories = reqSlovCategories(array('id' => $in['categories_id']));

        $dool_min1 = ($categories['unit_id'] == 1) ? ' min="1" ' : '';

        $code_elem = $code_unit = $flag_packing = '';

        if (!$in['nomenclature'] && !$in['search_categories']) {
            // КОЛИЧЕСТВО логика проверки фасовки
            $arr_unit = self::htmlUnitsByPacking(array('row_bs' => $row_bs, 'row_categories' => $categories, 'status' => $in['status'], 'flag' => $in['flag']));
            $code_unit = $arr_unit['code'];
            $flag_packing = $arr_unit['flag_packing'];
            ///
            $code_elem = $code_unit;
        }
        /*
		$code_elem = (!$in['nomenclature'])? '
										<div class="col-3 form-group">
												'.$this->Input(	array(	'type'			=> 'text',
																		'name'			=> 'amount',
																		'class'			=> 'form-control',
																		'value'			=> $this->nf($in['amount']),
																		'placeholder'	=> $categories['unit'],
																		'dopol'			=> 'required data-bv-field="amount" data-bv-notempty-message="Введите число" '
																	)
															).'
										</div>' : '';
		*/

        $row = reqCategoriesAttribute(array('categories_id' => $in['categories_id'],
            'flag_buy_sell' => $in['flag_buy_sell'],
            'buy_sell_id' => $in['buy_sell_id'],
            'nomenclature_id' => $in['nomenclature_id'],
            'search_categories_id' => $in['search_categories_id'],
            'parent_id' => $in['parent_id']));

        $n = 1;
        foreach ($row as $i => $m) {
            $n++;
            $required = ($m[$pole3]) ? true : false;
            if ($m[$pole1] == 1) {// Цифровое поле
                $elem = $this->HtmlTypeAttribute1(array('required' => $required, 'value' => $m['attribute_value_id'], 'attribute_id' => $m['attribute_id'], 'attribute' => $m['attribute']));
            } elseif ($m[$pole1] == 2) {// Цифровой период
                $elem = $this->HtmlTypeAttribute2(array('required' => $required, 'value' => $m['attribute_value_id'], 'attribute_id' => $m['attribute_id'], 'attribute' => $m['attribute']));
            } elseif ($m[$pole1] == 3) {// Текстовое поле
                $elem = $this->HtmlTypeAttribute3(array('required' => $required, 'value' => $m['attribute_value_id'], 'attribute_id' => $m['attribute_id'], 'attribute' => $m['attribute']));
            } elseif ($m[$pole1] == 4) {// Выпадающий список (выбор одного)
                $elem = $this->HtmlTypeAttribute4567(array('flag' => $in['flag'], 'required' => $required, 'id' => $m['attribute_value_id'], 'id2' => $m['attribute_value_id_parent'], 'multiple' => false, 'categories_id' => $in['categories_id'], 'attribute_id' => $m['attribute_id'], 'attribute' => $m['attribute']));
            } elseif ($m[$pole1] == 5) {// Выпадающий список (выбор нескольких)
                $elem = $this->HtmlTypeAttribute4567(array('flag' => $in['flag'], 'required' => $required, 'id' => $m['attribute_value_id'], 'id2' => $m['attribute_value_id_parent'], 'multiple' => true, 'categories_id' => $in['categories_id'], 'attribute_id' => $m['attribute_id'], 'attribute' => $m['attribute']));
            } elseif ($m[$pole1] == 6) {// Выпадающий список (выбор одного и добавление новых)
                $elem = $this->HtmlTypeAttribute4567(array('flag' => $in['flag'], 'required' => $required, 'id' => $m['attribute_value_id'], 'id2' => $m['attribute_value_id_parent'], 'multiple' => false, 'new' => true, 'categories_id' => $in['categories_id'], 'attribute_id' => $m['attribute_id'], 'attribute' => $m['attribute']));
            } elseif ($m[$pole1] == 7) {// Выпадающий список (выбор нескольких и добавление новых)
                $elem = $this->HtmlTypeAttribute4567(array('flag' => $in['flag'], 'required' => $required, 'id' => $m['attribute_value_id'], 'id2' => $m['attribute_value_id_parent'], 'multiple' => true, 'new' => true, 'categories_id' => $in['categories_id'], 'attribute_id' => $m['attribute_id'], 'attribute' => $m['attribute']));
            } else {
                $elem = '';
            }

            if ($elem) {
                $code_elem .= '
						<div class="form-group bttip-wrap">
							'.$elem.'
							<span class="bttip 1" style="display: none;">'.$m['attribute'].'</span>
						</div>';

            } else {
                $code_elem = '';
            }

            if ($n % 4 == 0) {// две колонки
                $code .= $code_elem;
                $code_elem = '';
            }
        }

        if ($code_elem) {
            $code .= $code_elem;
        }


        return array('code' => $code, 'row_categories' => $categories);
    }


    // Заявка - Дать предложение
    function CategoriesAttributeAction($p = array())
    {

        $code = $code_elem = $button_dopol_attribute = '';
        $in = fieldIn($p, array('categories_id', 'parent_id', 'flag_account', 'status', 'share_url', 'flag'));

        $arr_cities = $this->CitiesIdByCompanyOrIp();

        $submit_value = 'Записать';// по умолчанию

        $pole1 = 'sell_type_attribute_id';
        $pole2 = 'sell_flag_value';
        $pole3 = 'no_empty_sell';

        $script10 = ($in['flag'] == 'buy' || $in['flag'] == 'mybuy') ? ' $("#button_form_buy_sell'.$in['parent_id'].'").click(); ' : ' onReload(""); ';


        $company_id_share = 0;
        if ($in['share_url']) {
            $rs = reqBuySellShare(array('share_url' => $in['share_url']));
            $company_id_share = ($rs['company_id_from']) ? $rs['company_id_from'] : 0;
        }


        $id_form = 'offer_'.$in['parent_id'].'-form';

        $row_bs = reqBuySell_FormBuyAmount(array('id' => $in['parent_id']));// данные заявки

        if ($in['status'] == 10) {// обнуляем для предложения
            $row_bs['cost'] = '';
            $row_bs['currency_id'] = '';
            $row_bs['availability'] = '';
            $row_bs['name'] = '';
            $row_bs['comments'] = '';
            $row_bs['nomenclature_id'] = '';
            $row_bs['multiplicity'] = '';
            $row_bs['min_party'] = '';
            $rb = reqBuySell_LastId(array('flag_buy_sell' => 2, 'status_buy_sell_id' => 10));
            $row_bs['delivery_id'] = isset($rb['delivery_id']) ? $rb['delivery_id'] : '';
            //$rbs 		= ($rb['id'])? reqBuySell_FormBuyAmount(array('id' => $rb['id'])) : '';
            //$row_bs['delivery_id'] 	= isset($rbs['delivery_id'])? $rbs['delivery_id'] : '';
        }

        $categories = reqSlovCategories(array('id' => $in['categories_id']));

        $row = reqCategoriesAttribute(array('categories_id' => $in['categories_id'],
            'flag' => 'buy_sell_attribute',
            'flag_not_empty' => $pole1,
            'buy_sell_id' => $in['parent_id']));
        $n = 0;
        foreach ($row as $i => $m) {
            $required = ($m[$pole3]) ? true : false;
            if ($m[$pole1] == 1) {// Цифровое поле
                $elem = $this->HtmlTypeAttribute1(array('required' => $required, 'value' => ''/*$m['attribute_value_id']*/, 'attribute_id' => $m['attribute_id'], 'attribute' => $m['attribute']));
            } elseif ($m[$pole1] == 2) {// Цифровой период
                $elem = $this->HtmlTypeAttribute2(array('required' => $required, 'value' => ''/*$m['attribute_value_id']*/, 'attribute_id' => $m['attribute_id'], 'attribute' => $m['attribute']));
            } elseif ($m[$pole1] == 3) {// Текстовое поле
                $elem = $this->HtmlTypeAttribute3(array('required' => $required, 'value' => ''/*$m['attribute_value_id']*/, 'attribute_id' => $m['attribute_id'], 'attribute' => $m['attribute']));
            } elseif ($m[$pole1] == 4) {// Выпадающий список (выбор одного)
                $elem = $this->HtmlTypeAttribute4567(array('flag' => 'offer', 'status' => $in['status'], 'required' => $required, 'id' => $m['attribute_value_id'], 'multiple' => false, 'categories_id' => $in['categories_id'], 'attribute_id' => $m['attribute_id'], 'attribute' => $m['attribute']));
            } elseif ($m[$pole1] == 5) {// Выпадающий список (выбор нескольких)
                $elem = $this->HtmlTypeAttribute4567(array('flag' => 'offer', 'status' => $in['status'], 'required' => $required, 'id' => $m['attribute_value_id'], 'multiple' => true, 'categories_id' => $in['categories_id'], 'attribute_id' => $m['attribute_id'], 'attribute' => $m['attribute']));
            } elseif ($m[$pole1] == 6) {// Выпадающий список (выбор одного и добавление новых)
                $elem = $this->HtmlTypeAttribute4567(array('flag' => 'offer', 'status' => $in['status'], 'required' => $required, 'id' => $m['attribute_value_id'], 'multiple' => false, 'new' => true, 'categories_id' => $in['categories_id'], 'attribute_id' => $m['attribute_id'], 'attribute' => $m['attribute']));
            } elseif ($m[$pole1] == 7) {// Выпадающий список (выбор нескольких и добавление новых)
                $elem = $this->HtmlTypeAttribute4567(array('flag' => 'offer', 'status' => $in['status'], 'required' => $required, 'id' => $m['attribute_value_id'], 'multiple' => true, 'new' => true, 'categories_id' => $in['categories_id'], 'attribute_id' => $m['attribute_id'], 'attribute' => $m['attribute']));
            } else {
                $elem = '';
            }


            $cl_attribute = $button_dopol_attribute = '';
            /*if($m['sort']>6){
				$cl_attribute = 'div_offer_dopol_attribute';
				$button_dopol_attribute = ($n==0)? '	<button class="request-hidden-more div_offer_dopol_attribute_visible" data-id_form="'.$id_form.'">
														Дополнительные параметры <span><img src="/image/request-arrow.png" alt=""></span>
												</button>
												' : '';
												//<span class="sp_a div_offer_dopol_attribute_visible" data-id_form="'.$id_form.'" style="margin-top:25px;margin-left:10px;">Дополнительные параметры <span data-feather="chevron-down"></span></span>
												//<div class="clearfix"></div>
				$n++;
			}*/

            $code_elem .= $button_dopol_attribute.'
							<div class="offer-form__item'.$cl_attribute.'">
									<div class="form-group">
										'.$elem.'
									</div>
							</div>';


        }

        //if($code_elem){
        // добавляем в форму "Несуществующего поставщика"
        $code_flag_account3 = '';
        if ($in['flag_account'] == 3) {
            $code_flag_account3 = '<div class="form-group offer-form__item">
												'.$this->Input(array('type' => 'text',
                        'id' => 'qwertyu',
                        'class' => 'form-control require-input autocomplete_fa'.$in['parent_id'].'',
                        'value' => '',
                        'placeholder' => 'Поставщик',
                        'dopol' => 'required data-bv-notempty-message="Не выбран поставщик"'
                    )
                ).'
												'.$this->Input(array('type' => 'text',
                        'id' => 'company_id',
                        'value' => ''
                    )
                ).'
										</div>';
        } else {
            $code_flag_account3 = $this->Input(array('type' => 'text',
                    'id' => 'company_id',
                    'value' => COMPANY_ID
                )
            );
        }
        ///


        // форма оплаты в Предложении
        $code_form_payment = '';
        if ($in['status'] == 10 && FLAG_ACCOUNT <> 1) {
            $code_form_payment = '<div class="form-group offer-form__item">
											'.$this->Select(array('id' => 'form_payment_id',
                    'class' => 'form-control select2',
               