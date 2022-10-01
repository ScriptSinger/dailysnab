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
							<input type="checkbox" class="checkbox_checking_buysell" data-flag="1">
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
                    'value' => '',
                    'data' => array('placeholder' => 'Форма оплаты')
                ),
                    array('func' => 'reqSlovFormPayment',
                        'param' => array('' => ''),
                        'option' => array('id' => 'id', 'name' => 'form_payment')
                    )
                ).'
										</div>';
            $submit_value = 'Предложить';
        }
        ///

        // Кратность и минимальная Партия и Обязательные поля
        $required_name = $required_file = $code_multiplicity_min_party = '';
        if ($in['status'] == 10) {

            // обязательные поля (задаются в админке)
            if ($categories['no_empty_name']) {
                $required_name = 'required="required"';
            }
            if ($categories['no_empty_file']) {
                $required_file = 'required="required"';
            }
            ///

            $code_multiplicity_min_party = '

										<div class="form-group offer-form__item">
											'.$this->Input(array('type' => 'text',
                        'id' => 'multiplicity',
                        'class' => 'form-control',
                        'value' => $row_bs['multiplicity'],
                        'placeholder' => 'Кратность',
                        'dopol' => 'autocomplete="off"'
                    )
                ).'
										</div>
										<div class="form-group offer-form__item">
											'.$this->Input(array('type' => 'text',
                        'id' => 'min_party',
                        'class' => 'form-control',
                        'value' => $row_bs['min_party'],
                        'placeholder' => 'Минимальная Партия',
                        'dopol' => 'autocomplete="off"'
                    )
                ).'
										</div>';
        }
        ///

        $row_bs['cost'] = ($row_bs['cost'] > 0) ? $row_bs['cost'] : '';

        /*if(PRO_MODE){*/
        $currency = '	<div class="form-group offer-form__item currency_form">
								'.$this->Select(array('id' => 'currency_id',
                'class' => 'form-control select2',
                'value' => $row_bs['currency_id'],
                'data' => array('placeholder' => 'Валюта')
            ),
                array('func' => 'reqSlovCurrency',
                    'param' => array('' => ''),
                    'opt' => array('id' => '', 'name' => ''),
                    'option' => array('id' => 'id', 'name' => 'currency')
                )
            ).'
							</div>';
        /*}else{
				$currency = $this->Input(	array(	'type'			=> 'hidden',
												'id'			=> '',
												'value'			=> 1
											)
									);
			}*/

        // КОЛИЧЕСТВО логика проверки фасовки
        $arr_unit = self::htmlUnitsByPacking(array('row_bs' => $row_bs, 'row_categories' => $categories, 'status' => $in['status']));
        $code_unit = $arr_unit['code'];
        $flag_packing = $arr_unit['flag_packing'];
        ///


        // если фасовка поле amount (количество) обязательным не являетсяб при фасовке поля (amount1,amoun2)
        $js_amount = (!$flag_packing) ? '		amount: {
												validators: {
													integer : { 
														message : "Введите число"
													},
													notEmpty: {
														message: "Введите"
													}
												}
											},' : '';

        $js_add_assets = ($categories['assets'] && $in['status'] == 12) ? '	webix.confirm({
																			ok: "Добавить", cancel:"Отменить",
																			text: "Добавить в активы?",
																			callback:function(result){
																				if(result){
																						$.post( "/add_assets", { buy_sell_id:data.id } , 
																							function(data2){
																								//
																								if(data2.ok){
																									webix.message("Сохранено");
																								}else{
																									webix.message({type:"error", text:"Нельзя сохранить"});
																								}
																							}
																						);
																				}else{
																						// добавляем на склад
																						$.post( "/add_stock", { buy_sell_id:data.id } , 
																							function(data2){
																								//
																								if(data2.ok){
																									webix.message("Сохранено");
																								}else{
																									webix.message({type:"error", text:"Нельзя сохранить"});
																								}
																							}
																						);																					
																				}
																			}
																		});'
            : 'onReload("");';


        $code_availability = $code_delivery = '';
        if ($in['status'] <> 12) {
            $code_availability = '	<div class="form-group offer-form__item">
											'.$this->Input(array('type' => 'text',
                        'name' => 'availability',
                        'class' => 'form-control require-input',
                        'value' => $row_bs['availability'],
                        'placeholder' => 'Наличие',
                        'dopol' => 'list="availability" required data-bv-notempty-message="Введите наличие" autocomplete="off"'
                    )
                ).'
											<datalist id="availability">
													<option value="в наличии" />
													<option value="1 день" />
													<option value="2 дня" />
													<option value="3 дня" />
													<option value="4 дня" />
											</datalist>
										</div>';

            $code_delivery = '		<div class="form-group offer-form__item">
											'.$this->Select(array('id' => 'delivery_id',
                    'class' => 'form-control select2',
                    'value' => $row_bs['delivery_id'],
                    'data' => array('placeholder' => 'Доставка'),
                    'dopol' => 'required="required" data-bv-notempty-message="Выберите способ доставки"'
                ),
                    array('func' => 'reqSlovDelivery',
                        'param' => array('' => ''),
                        'opt' => array('id' => '', 'name' => ''),
                        'option' => array('id' => 'id', 'name' => 'delivery')
                    )
                ).'
										</div>';
        }


        $code .= '
					<form id="'.$id_form.'" class="" role="form">
						<div class="offer-form">
						<div class="offer-form_main">
							'.$code_flag_account3.'
							
							<div class="form-group offer-form__item">
								'.$this->Input(array('type' => 'text',
                    'id' => 'cost',
                    'class' => 'form-control require-input vmask',
                    'value' => $row_bs['cost'],
                    'placeholder' => 'Цена',
                    'dopol' => 'required data-bv-notempty-message="Введите цену" autocomplete="off"'
                )
            ).'
							</div>

							'.$currency.'
							
							
							'.$code_form_payment.'
							
							
							'.$code_unit.'
							
							
							'.$code_availability.'
							
							'.$code_delivery.'
							
							
							<div class="form-group offer-form__item">
								'.$this->SelectCities(array('cities_id' => $arr_cities['cities_id'])).'
							</div>
									
							<div class="form-group offer-form__item">
									'.$this->Input(array('type' => 'text',
                'id' => 'comments',
                'class' => 'form-control',
                'value' => $row_bs['comments'],
                'placeholder' => 'Комментарий'
            )).'
							</div>
						</div>
						<div class="offer-form_sec">
							<div class="offer-form_sec-main">
								<div class="offer-form__item cam_form">
									<label for="cam" class="file none-req">	
										<input type="buttom" id="cam" onclick="$$(\'upload_files_buy_sell'.$in['parent_id'].'\').fileDialog();" '.$required_file.'>										
									</label>
								</div>
								<div class="form-group offer-form__item">
									'.$this->Input(array('type' => 'text',
                    'id' => 'name',
                    'class' => 'form-control',
                    'value' => $row_bs['name'],
                    'placeholder' => 'Наименование',
                    'dopol' => 'autocomplete="off" '.$required_name.' data-bv-notempty-message="Введите наименование"'
                )
            ).'
								</div>
								'.$code_elem.'
								
								
								<div id="container_upload_files'.$in['parent_id'].'"></div>
									
									'.$button_dopol_attribute.'
						
								'.$code_multiplicity_min_party.'
							</div>
							<div class="offer-form_sec-more">
								<span class="request-hidden-more div_offer_dopol_attribute_visible" data-id_form="offer_'.$in['parent_id'].'-form" style="cursor:pointer;"><span class="request-hidden-more__text">Дополнительные параметры</span> <span><img src="/image/request-arrow.png" alt=""></span>
								</span>
							</div>
						</div>
							'.$this->Input(array('type' => 'hidden',
                    'id' => 'parent_id',
                    'value' => $in['parent_id']
                )
            ).'
							'.$this->Input(array('type' => 'hidden',
                    'id' => 'flag_buy_sell',
                    'value' => 2
                )
            ).'	
							'.$this->Input(array('type' => 'hidden',
                    'id' => 'share_url',
                    'value' => $in['share_url']
                )
            ).'
							'.$this->Input(array('type' => 'hidden',
                    'id' => 'nomenclature_id',
                    'value' => $row_bs['nomenclature_id']
                )
            ).'
							'.$this->Input(array('type' => 'hidden',
                    'id' => 'responsible_id',
                    'value' => $row_bs['responsible_id']
                )
            ).'
							'.$this->Input(array('type' => 'hidden',
                    'id' => 'stock_id',
                    'value' => $row_bs['stock_id']
                )
            ).'
							'.$this->Input(array('type' => 'hidden',
                    'id' => 'company_id3',
                    'value' => $row_bs['company_id3']
                )
            ).'			
							'.$this->Input(array('type' => 'submit',
                    'class' => 'request-btn request-hidden-btn',
                    'value' => $submit_value,
                    'data' => array('status' => $in['status'])
                )
            ).'
						</div>
					</form>
					<script>
							$("#'.$id_form.'").bootstrapValidator({
								feedbackIcons: {
									valid: "glyphicon glyphicon-ok",
									invalid: "glyphicon glyphicon-remove",
									validating: "glyphicon glyphicon-refresh"
								},
								fields: {
									'.$js_amount.'
									cities_id: {
										validators: {
											notEmpty: {
												message: "Выберите город"
											}
										}
									}
								}
							}).on("success.form.bv", function(e) {
								e.preventDefault();
								var $form = $(e.target);
								var bv = $form.data("bootstrapValidator");
								var button=$(e.target).data("bootstrapValidator").getSubmitButton();
								var d = button.data();
								
								bv.disableSubmitButtons(true);
								
								var flag_uploader = true;
								if($("#'.$id_form.' #cam").attr("required")=="required"){
								
									var order = $$("upload_files_buy_sell'.$in['parent_id'].'").files.data.order;
									var kol_file = order.length;
									if(kol_file==0){
										flag_uploader = false;
										webix.message({type:"error", text:"Не выбран файл(фото)"});
										bv.disableSubmitButtons(false);
									}
									
								}			
								
								if( flag_uploader ){
								
									$.post("/save_buy_sell", $form.serialize()+"&status="+d.status,
										function(data){
												if(data.ok){
														$$("upload_files_buy_sell'.$in['parent_id'].'").files.data.each(function(obj){
																	obj.formData = { id:data.id };
														});
														
														$$("upload_files_buy_sell'.$in['parent_id'].'").send(function(response){
																$$("upload_files_buy_sell'.$in['parent_id'].'").files.data.each(function(obj){
																	
																	var status = obj.status;
																	var name = obj.name;
																	if(status=="server"){
																		webix.message("Файл: "+name+" загружен");
																	}
																	else{
																		webix.message({type:"error", text:"Нельзя загрузить: "+name});
																	}
																});
																if( ('.COMPANY_ID.'>0) || ('.$company_id_share.'>0) ){
																	if(d.status==10){
																		'.$script10.'
																	}else{
																		'.$js_add_assets.'
																	}
																}else{
																	if(d.status==10){
																			$("body,html").animate({ scrollTop: 0 }, 500);
																			setTimeout(function(){
																							  $(".enter-btn").click();
																							}, 1000);
																	}
																}
														});
												}else{
													webix.message({type:"error", text:data.code});
													bv.disableSubmitButtons(false);
												}
												if (bv.getInvalidFields().length > 0) {
													bv.disableSubmitButtons(false);
												}
										}
									);
								}
							});
					</script>';
        //}


        return $code;
    }


    // модальное окно Предложения на Заявки
    function TableOfferBuy($p = array())
    {
        $in = fieldIn($p, array('id'));

        $row_bs = $p['row_bs'];


        $row = reqBuySell_Offer(array('parent_id' => $in['id'], 'group' => true));

        $row_amount_buy = reqBuySell_Offer_AmountBuy(array('id' => $in['id']));//купленное количество по этой заявке

        $amount_parent = $row_bs['amount'] - $row_amount_buy['amount_buy'];

        $arr_tid = array();
        $tr = '';
        foreach ($row as $i => $m) {

            $arr = self::TrModalOffer(array('row' => $m,
                'parent_id' => $in['id'],
                'amount_parent' => $amount_parent));
            $tr .= $arr['tr'];
            if ($arr['notification_tid']) {
                $arr_tid[] = $arr['notification_tid'];
            }

        }

        $comments = ($row_bs['comments']) ? ', '.$row_bs['comments'] : '';

        $m['name'] = isset($m['name']) & !empty($m['name']) ? $m['name'] : '-';

        if ($row_bs['unit_group_id']) {
            $amoun_unit = $this->nf($row_bs['amount1']).' '.$row_bs['unit1'];
        } else {
            $amoun_unit = $this->nf($row_bs['amount']).' '.$row_bs['unit'];
        }


        $content = '	<section class="request" id="request">
							<div class="request__top">
								<div class="request__top-content"><b>'.$row_bs['name'].',</b> '.$amoun_unit.', '.$row_bs['urgency'].$comments.'</div>
								<div id="div_count_status_buysell"></div>
							</div>
							<div class="request__content">'.$tr.'</div>
							<div class="request__bottom"></div>
						</section>';

        $tid = implode(',', $arr_tid);

        return array('content' => $content, 'tid' => $tid);
    }


    // TR строка предложение на заявки
    function TrModalOffer($p = array())
    {
        $in = fieldIn($p, array('view_grouping', 'parent_id', 'amount_parent'));// amount_parent - количество в заявке

        $m = $p['row'];

        $arr_six = array(1 => '', 2 => '', 3 => '', 4 => '', 5 => '', 6 => '');
        $r = reqBuySellAttributeSixParam(array('buy_sell_id' => $m['id'], 'categories_id' => $m['categories_id'], 'flag' => 'six'));
        foreach ($r as $n => $mm) {
            $arr_six[$mm['sort']] = '<span class="c999">'.$mm['attribute'].'</span> <strong>'.$mm['attribute_value'].'</strong>';
        }

        $buy_offer = '';
        $amount_buy_current = 0;
        $row_buy_offer = reqBuySell_TableOfferBuy(array('parent_id' => $m['id'],
            'company_id' => COMPANY_ID));
        foreach ($row_buy_offer as $ii => $mm) {
            $buy_offer .= '<div>
										<span class="badge badge-success font12">'.$mm['status_buy2'].' '.$this->nf($mm['amount']).' '.$mm['unit'].'</span>
									</div>';
            $amount_buy_current = $amount_buy_current + $mm['amount'];
        }


        $notification = $notification_tid = '';
        if ($m['kol_notification']) {
            $notification = '<div><span class="badge badge-warning badge-pill">&nbsp;</span></div>';
            $notification_tid = $m['id'];//пишем ID для - удалить маркер оповещения
        }

        $cost_coefficient = ($m['cost_coefficient'] && ($m['cost_coefficient'] <> $m['cost'])) ? '<div>('.$this->nf($m['cost_coefficient']).')</div>' : '';


        // рекомендация по покупаемому количеству
        if ($in['amount_parent'] >= $m['amount']) {
            $amount_recom = $m['amount'];
        } else {
            $amount_recom = $in['amount_parent'];
        }
        //vecho($amount_buy_current);
        if ($amount_recom >= ($m['amount'] - $amount_buy_current)) {
            $amount_recom = $amount_recom - $amount_buy_current;
        }
        ///


        // кнопка купить на кого подписан
        $button_buy = '';
        if ($m['flag_subscriptions_company_in'] || $m['login_id'] == LOGIN_ID || $m['flag_subscriptions_company_out'] || $m['qrq_id']) {
            $flag_view_button = true;// по умолчанию показываем
            if ($m['qrq_id'] > 0) {
                // проверяем , если про аккаунт ЭТП и нет своей авторизации , то кнопку "купить" не показываем
                $re = reqProverkaEtpPromoAccountsBySell(array('qrq_id' => $m['qrq_id']));
                if ($re['promo'] == 1) {
                    $flag_view_button = false;
                }
                if ($re['flag_autorize']) {
                    $flag_view_button = true;
                }
            }

            if ($flag_view_button) {
                $button_buy = $this->Input(array('type' => 'button',
                        'class' => 'pull-right btn btn-pfimary btn-sm get_form_buy_amount',
                        'value' => 'купить',
                        'data' => array('id' => $m['id'], 'where' => 'modal_offer11', 'amount_recom' => $amount_recom)
                    )
                );
            }
        }


        // изображение
        $arr = self::getImgBuySell(array('buy_sell_id' => $m['id']));
        $img = $arr['code'];
        ///

        $ico_userimg = '';
        if (($m['login_id'] == LOGIN_ID) && ($m['company_id'] <> COMPANY_ID)) {
            $ico_userimg = '<span class="userImgCnt"><img src="/image/user-img.png" alt="" class="user-img"></span>';
        }

        $company = '	<div class="request-user">
								<span class="user-name">
									<a href="/company-profile/'.$m['company_id'].'" target="_blank">'.$m['company'].'</a>
								</span>
								'.$ico_userimg.'
							</div>';

        // группированная строка
        $div_id = $button_grouping = $cost = $div_view_grouping = $quantity_bottom = $name_bottom = $urgency = $city = $data_item = $consignment = $row_status = $time = '';

        if ($m['kol_grouping'] > 1) {
            $button_buy = '';
            $company = $m['cities_name'] = $m['urgency'] = $m['availability'] = $day_noactive = $m['data_status_buy_sell_23'] = $m['categories'] = '';
            $m['comments'] = $m['form_payment'] = $m['cities_name'] = $m['unit'] = $m['amount'] = '';
            $button_grouping = $this->Input(array('type' => 'button',
                        'id' => 'view_grouping'.$m['id'],
                        'class' => 'change-btn view_grouping',
                        'value' => 'от '.$this->nf($m['cost_grouping']).' '.$m['currency'].' ('.$m['kol_grouping'].')',
                        'data' => array('value' => $m['val_grouping'],
                            'id' => $m['id'],
                            'parent_id' => $in['parent_id'],
                            'flag' => 'offer',
                            'flag_limit' => true,
                            'start_limit' => 0)
                    )
                ).'
									'.$this->Input(array('type' => 'button',
                        'id' => 'close_view_grouping'.$m['id'],
                        'class' => 'change-btn close_view_grouping',
                        'value' => 'Свернуть',
                        'dopol' => 'style="display:none;"',
                        'data' => array('id' => $m['id'])
                    )
                );
            $div_view_grouping = '	<div id="tr_'.$m['id'].'" class="request-hidden" style="display:none;">
											</div>';
        } else {

            $div_id = 'div_offer'.$m['id'].'';// id div`a для обновления при покупке

            if ($m['urgency'] == 'Срочно') {
                $urgency = '<span class="data-month urgency-urgent">'.$m['urgency'].'<span class="bttip" style="display: none;">Срочность</span></span>';
            }

            if ($m['cities_name'] != '') {
                $city = $m['cities_name'].',';
            }

            $data_item = $m['data_insert'];


            $consignment = ($m['min_party'] || $m['multiplicity']) ? '<span class="sell-item_quantity-bottom__left">'.$m['min_party'].'</span>/<span class="sell-item_quantity-bottom__right">'.$m['multiplicity'].'</span>' : '';


            if ($m['qrq_srok_dn']) {
                $str = $this->format_by_count($m['qrq_srok_dn'], 'день', 'дня', 'дней');
                $time = $m['qrq_srok_dn'].' '.$str;
            }


            $cost = '<span><span class="rpCost">'.$this->nf($m['cost']).'</span><span class="rpCurrency"> '.$m['currency'].'</span></span>';

            $row_status = '<div class="sell-item_status-bars status-bar">
										<button class="status-bar__convert">
											<img src="/image/status-mail.svg" alt="Отправить сообщение (Предложения по заявкам)" class="status-request write_message_need" 
												data-need="25" 
												data-company="'.COMPANY_ID.'"
												data-id="'.$m['id'].'"
												data-url="/'.$m['url_cities'].'/'.$m['url_categories'].'/'.$m['url'].'"
											>
										</button>
									</div>';
        }
        ///

        // форма оплаты
        if ($m['form_payment_id'] == 3) {
            $form_payment = '<span class="request-money"></span>';
        } else {
            if ($m['form_payment']) {
                $form_payment = '<span class="request-nds"><span class="ndsText">'.$m['form_payment'].'</span></span>';
            } else {
                $form_payment = '';
            }
        }
        ///

        // Наличие
        $availability = '';
        if ($m['availability']) {
            $str = $this->format_by_count($m['availability'], 'день', 'дня', 'дней');
            $availability = $m['availability'].' '.$str;
        }
        //

        // Доставка
        $delivery = '';
        if ($m['delivery_id'] == 1) {
            $delivery = 'Доставка за счет покупателя';
        } elseif ($m['delivery_id'] == 2) {
            $delivery = 'Доставка за счет продавца';
        }
        //


        $kol_status11 = ($m['kol_status11']) ? '('.$this->nf($m['kol_status11']).')' : '';//количество купленного данного предложения

        if (PRAVA_5) {
            $cost_coefficient = $cost = $form_payment = $company = '';
        }

        if ($img == '') {
            $noPhoto = ' no-photo';
        } else {
            $noPhoto = '';
        }


        $m['name'] = ($m['name']) ? $m['name'] : '-';

        // количество/ед.измерения
        $amount_unit = $m['amount'].' '.$m['unit'];

        // фасовка
        $packing = '';
        if ($m['unit_group_id']) {

            if ($m['unit_id2'] && $m['amount2']) {// выбрано ШТУКИ и другая ед.измерения
                $packing = '<span style="color:#b2afaf;">Фасовка</span><br/>'.$this->nf($m['amount1']).''.$m['unit1'].'/'.$this->nf($m['amount2']).''.$m['unit2'];
                $cost = ''.$this->nf($m['cost1']).' '.$m['currency'].'/шт
									<br/>
									'.$this->nf($m['cost']).' '.$m['currency'].'/'.$m['unit'];
                $cost_coefficient = '';
                $amount_unit = '';
            } elseif ($m['unit_id1'] && !$m['unit_id2'] && ($m['unit_id'] <> $m['unit_id1'])) {// выбрано НЕ штуки, а другая ед.измерения отличная от "по умолчанию" у категории

                $cost = ''.$this->nf($m['cost']).' '.$m['currency'].'/'.$m['unit'];

                $amount_unit = $this->nf($m['amount1']).' '.$m['unit1'];

            }

        }
        ///


        $tr = '
				<div id="'.$div_id.'" class="container">
					<div class="sell-item view_1'.$noPhoto.'">
						<div class="sell-item__img">
							<div class="request-slider-wrapper">
								<div class="image-wrapper">
									<div class="inner-wrapper">
										'.$img.'
									</div>
								</div>
								<div class="slider-control"></div>
							</div>
						</div>
						<div class="sell-item__info">
							<div class="sell-item_name">
								<div class="sell-item_name-top '.$m['kol_grouping'].'">
									<a href="/'.$m['url_cities'].'/'.$m['url_categories'].'/'.$m['url'].'" target="_blank">'.$m['name'].'</a>
								</div>
								<div class="sell-item_name-bottom">
									<span class="sell-item_name-bottom__num">'.$availability.'</span>
									<span class="sell-item_name-bottom__time">'.$time.'</span>
								</div>
							</div>
							<div class="sell-item_quantity">
								<div class="sell-item_quantity-top">
									<span class="sell-item_quantity-top__quantity">'.$amount_unit.'</span>
									<span class="sell-item_quantity-top__sec">'.$kol_status11.'</span>
									'.$packing.' 
								</div>
								<div class="sell-item_quantity-bottom">'.$consignment.'</div>
							</div>
							<div class="sell-item_price">
								<div class="sell-item_prop-left">
									<div class="sell-item_prop-left__top">'.$cost_coefficient.'</div>
									<div class="sell-item_prop-left__bottom"></div>
								</div>
								<div class="sell-item_prop-middle">
									<div class="sell-item_prop-middle__top">'.$cost.'</div>
									<div class="sell-item_prop-middle__bottom"><div>'.$notification.'</div></div>
								</div>
								<div class="sell-item_prop-right">
									<div class="sell-item_prop-right__top">'.$form_payment.'</div>
									<div class="sell-item_prop-right__bottom">'.$delivery.'</div>
								</div>
							</div>
							<div class="sell-item_prop">
								<div class="sell-item_prop-item">'.$arr_six[1].'</div>
								<div class="sell-item_prop-item">'.$arr_six[2].'</div>
								<div class="sell-item_prop-item">'.$arr_six[3].'</div>
								<div class="sell-item_prop-item">'.$arr_six[4].'</div>
								<div class="sell-item_prop-item">'.$arr_six[5].'</div>
								<div class="sell-item_prop-item">'.$arr_six[6].'</div>
							</div>
							<div class="sell-item_middle">
								<div class="sell-item_middle-comment">'.$m['comments'].'</div>
								<div class="sell-item_middle-btn">'.$button_buy.''.$button_grouping.'</div>
							</div>
							<div class="sell-item_bottom">
								<div class="sell-item_bottom-left">
									<span class="sell-item_bottom-left__sticker">'.$urgency.'</span>
									<span class="sell-item_bottom-left__city">'.$city.'</span>
									<span class="sell-item_bottom-left__date"> '.$data_item.'</span>
								</div>
								<div class="sell-item_bottom-right">
									<span class="sell-item_bottom-right__cat">'.$m['categories'].'</span>
									<!--<span class="sell-item_bottom-right__icon">●</span>
									Точка Онлайн-->
									<span class="sell-item_bottom-right__name">'.$company.'</span>
								</div>
							</div>
							'.$row_status.'
						</div>
					</div>
				</div>
				'.$div_view_grouping.'
			';

        return array('tr' => $tr, 'notification_tid' => $notification_tid);
    }


    // Подгружаем ранее редложения компании(пользователя) при даче предложения
    function TrOfferByBuySell($p = array())
    {

        $in = fieldIn($p, array('group'));

        $row = array();

        $company_id = 0;
        if ($p['flag'] == 'buy') {
            if ($p['share_url']) {
                $rs = reqBuySellShare(array('share_url' => $p['share_url']));
                $company_id = $rs['company_id_to'];
                $row = reqBuySell_Offer(array('parent_id' => $p['buy_sell_id'], 'company_id' => $company_id, 'flag' => 'noautorize'));
            } else {
                if (COMPANY_ID) {
                    $row = reqBuySell_Offer(array('parent_id' => $p['buy_sell_id'], 'company_id' => COMPANY_ID));
                }
            }
        } elseif ($p['flag'] == 'mybuy') {
            $row = reqBuySell_Offer(array('parent_id' => $p['buy_sell_id'], 'login_id' => LOGIN_ID));
        }

        $tr = '';
        foreach ($row as $i => $m) {

            $tr .= self::TrMyOfferByBuySell(array('m' => $m, 'share_url' => $p['share_url']));

        }

        $code = ($tr) ? $tr : '';

        return $code;
    }


    // Html представление табличной части "Подгружаем ранее предложения компании(пользователя) при даче предложения"
    function TrMyOfferByBuySell($p = array())
    {

        $bs = new HtmlBuySell();

        $tr = '';

        $m = $p['m'];


        $arr_six = array(1 => '', 2 => '', 3 => '', 4 => '', 5 => '', 6 => '');
        $r = reqBuySellAttributeSixParam(array('buy_sell_id' => $m['id'], 'categories_id' => $m['categories_id'], 'flag' => 'six'));
        foreach ($r as $n => $mm) {
            $arr_six[$mm['sort']] = '<span data-name="'.$mm['attribute'].'">'.$mm['attribute_value'].'</span>';
        }

        $form_buy_sell = $form_buy_sell_hidden = $edit = $data_status_buy_sell_23 = $day_noactive = '';


        // изображение
        $arr = self::getImgBuySell(array('buy_sell_id' => $m['id']));
        $img = $arr['code'];
        ///

        //$kol_status11 = ($m['kol_status11'])? '<span style="color:#008000;" title="куплено">'.$m['kol_status11'].'</span>' : '';

        // форма оплаты
        if ($m['form_payment_id'] == 3) {
            $form_payment = '<span class="request-money"></span>';
        } else {
            if ($m['form_payment']) {
                $form_payment = '<span class="request-nds"><span class="ndsText">'.$m['form_payment'].'</span></span>';
            } else {
                $form_payment = '';
            }
        }
        ///

        // Наличие
        $availability = '';
        if ($m['availability']) {
            $str = $this->format_by_count($m['availability'], 'день', 'дня', 'дней');
            $availability = $m['availability'].' '.$str;
        }
        //
        if ($img == '') {
            $noPhoto = ' no-photo';
        } else {
            $noPhoto = '';
        }
        ///

        // количество купленных
        $kol_status = '';
        if ($m['kol_status11'] > 0) {
            $kol_status = '&nbsp;<span style="color:#008000;" title="куплено">('.$this->nf($m['kol_status11']).')</span>';
        }
        ///

        $ico_userimg = '';
        if (($m['login_id'] == LOGIN_ID) && ($m['company_id'] <> COMPANY_ID)) {
            $ico_userimg = '<span class="userImgCnt"><img src="/image/user-img.png" alt="" class="user-img"></span>';
        }

        $m['name'] = ($m['name']) ? $m['name'] : '-';

        $amount_unit = '<span class="rAmount">'.$this->nf($m['amount']).'</span> <span class="rMeasure"> '.$m['unit'].'</span>';
        $cost = '<span><span class="rpCost">'.$this->nf($m['cost']).'</span><span class="rpCurrency"> '.$m['currency'].'</span></span>';
        // фасовка
        $packing = '';
        if ($m['unit_group_id']) {

            if ($m['unit_id2'] && $m['amount2']) {// выбрано ШТУКИ и другая ед.измерения
                $packing = '<span style="color:#b2afaf;">Фасовка</span><br/>'.$this->nf($m['amount1']).''.$m['unit1'].'/'.$this->nf($m['amount2']).''.$m['unit2'];
                $cost = ''.$this->nf($m['cost1']).' '.$m['currency'];
                $amount_unit = '';
            } elseif ($m['unit_id1'] && !$m['unit_id2'] && ($m['unit_id'] <> $m['unit_id1'])) {// выбрано НЕ штуки, а другая ед.измерения отличная от "по умолчанию" у категории

                $cost = ''.$this->nf($m['cost']).' '.$m['currency'].'/'.$m['unit'];

                $amount_unit = $this->nf($m['amount1']).' '.$m['unit1'];

            }

        }
        ///

        $tr .= '
						<div class="container">
							<div class="request-item request-list'.$noPhoto.' item-list-2">
								<div class="request-slider-wrapper">
									<div class="image-wrapper">
										<div class="inner-wrapper">'.$img.'</div>
									</div>
									<div class="slider-control"></div>
									<div class="request-list__27">27</div>
								</div>
								<div class="request-info">
									<div class="request-info-head">
										<div class="request-stages">
											<div class="request-stage">
												<div class="request-pics-wrapper">
													<div class="image-wrapper">
														<div class="inner-wrapper">
															'.$img.'
														</div>
													</div>
													<div class="slider-control"></div>
												</div>
												<div class="request-data-name 222">
													<p>
														<a href="/'.$m['url_cities'].'/'.$m['url_categories'].'/'.$m['url'].'" target="_blank">'.$m['name'].'</a>
													</p>
													<span class="request-quantity">'.$amount_unit.' '.$kol_status.'</span>
													'.$packing.'
													<div class="request-data-name__bottom">
														<p>'.$availability.'</p>
														<span>'.$m['min_party'].'</span>
														<span>'.$m['multiplicity'].'</span>
													</div>
												</div>
												
												<div class="request-pricing">
													<div class="request-price">
														<div>
															'.$cost.'
															<span></span>
														</div>
														<!--
														<div>
															<span class="rpCurrency"> '.$m['currency'].'</span>
															<span></span>
														</div>
														-->
														<div>
															<span>'.$form_payment.'</span>
															<span></span>
														</div>
													</div>
												</div>
												<div class="request-stage__right">
													<div class="request-stage__right-24">'.$m['categories'].'</div>
													<div class="request-stage__right-middle">
														<span>Предложение</span>
														<span></span>
													</div>
													<div class="request-stage__right-25">'.$m['data_status_buy_sell_10'].'</div>
												</div>
												<div class="request-data">
													<div class="request-data-params">
														'.$arr_six[1].'
														'.$arr_six[2].'
														'.$arr_six[3].'
														'.$arr_six[4].'
														'.$arr_six[5].'
														'.$arr_six[6].'
													</div>
												</div>
												<div class="request-for-price">
													<p class="comments">
														'.$m['comments'].'
													</p>
													<span class="bttip" style="display: none;">'.$m['comments'].'</span>
												</div>
											</div>
										</div>
										
									</div>
									<div class="request-data-place">
										<div class="request-data-place__left">
											<span class="request-data-place__sticker"></span>
											<span class="data-city">
												'.$m['cities_name'].'
											</span>
										</div>
										<div class="request-data-place__right">
											<span class="request-user">
												<span class="user-name">
													<a href="/company-profile/'.$m['company_id'].'" target="_blank">'.$m['company'].'</a>
												</span>
												'.$ico_userimg.'
											</span>
										</div>
									</div>
									<div class="status-bar">
										'.$this->Input(array('type' => 'button',
                'class' => 'modal_buy_sell',
                'value' => '<img src="/image/status-edit.svg" alt="" class="status-request">',
                'data' => array('id' => $m['id'],
                    'share_url' => $p['share_url'],
                    'flag_offer_share' => true,
                    'nomenclature_id' => $m['nomenclature_id'])
            )).'
									</div>
								</div>
							</div>
						</div>	 
							
					';

        return $tr;
    }


    // Предложения на Заявки
    function ViewPhoneByBuySell($p = array())
    {
        $in = fieldIn($p, array('buy_sell_id', 'amount'));

        $phone = $code_note = $code_buy = $code_buy_offer = '';
        $code = 'Просмотр телефона не возможен';

        $arr = $this->ProverkaViewPhone(array('buy_sell_id' => $in['buy_sell_id']));
        $row = $arr['row_buy_sell'];


        if ($arr['ok']) {
            $company1 = reqCompany(array('id' => $row['company_id']));
            $company = reqCompany(array('login_id' => $company1['login_id'], 'flag_account' => 1, 'one' => true));
            $phone = '<span>'.self::phone_number($company['phone']).'</span>';

            if (COMPANY_ID && COMPANY_ID <> $row['company_id']) {

                $code_note = self::NoteBuySellTextarea(array('buy_sell_id' => $in['buy_sell_id']));

                if (PRAVA_2 || PRAVA_3) {

                    $code_buy_offer = ($row['status_buy_sell_id'] == 10 || $row['flag_buy_sell'] == 1) ? '
								<form id="form_buy-form" class="" role="form" style="display:none;">
									<div class="form-group product-quant" style="max-height:70px;">
											'.$this->Input(array('type' => 'text',
                                'name' => 'amount',
                                'class' => 'product-input vmask',
                                'value' => '',
                                'placeholder' => ($row['unit_id1'] ? $row['unit1'] : $row['unit']),
                                'dopol' => 'list="amount" autocomplete="off" ',
                                'data' => array('unit_id' => ($row['unit_id1'] ? $row['unit_id1'] : $row['unit_id']))
                            )
                        ).'
											<datalist id="amount">
												<option value="'.$in['amount'].'" />
											</datalist>
									</div>
									<div class="form-group">
											'.$this->Input(array('type' => 'submit',
                                'class' => 'product-button request-btn product-submit',
                                'value' => 'Купить'
                            )
                        ).'
									</div>
									'.$this->Input(array('type' => 'hidden',
                                'id' => 'buy_sell_id',
                                'value' => $in['buy_sell_id']
                            )
                        ).'				
								</form>
								<script>
										$("#form_buy-form").bootstrapValidator({
											feedbackIcons: {
												valid: "glyphicon glyphicon-ok",
												invalid: "glyphicon glyphicon-remove",
												validating: "glyphicon glyphicon-refresh"
											},
											fields: {
												amount: {
													validators: {
														notEmpty: {
															message: "Укажите количество"
														}
													}
												}
											}
										}).on("success.form.bv", function(e) {
											e.preventDefault();
											var $form = $(e.target);
											var bv = $form.data("bootstrapValidator");
												$.post("/save_buy_offer", $form.serialize(),
													function(data){
															if(data.ok){
																onReload("");
															}else{
																webix.message({type:"error", text:data.code});
															}
															if (bv.getInvalidFields().length > 0) {
																bv.disableSubmitButtons(false);
															}
													}
												);
										});
								</script>
								<div class="form-group">
									'.$this->Input(array('type' => 'button',
                                'id' => 'click_buy',
                                'class' => 'product-button request-btn product-submit',
                                'value' => 'Купить'
                            )
                        ).'
								</div>' : '';
                }
            }
        }

        return array('ok' => $arr['ok'], 'code' => $code, 'phone' => $phone, 'note' => $code_note, 'buy_offer' => $code_buy_offer);
    }


    // Заметки - Объявление/Предложение/Заявки
    function NoteBuySellTextarea($p = array())
    {

        $in = fieldIn($p, array('buy_sell_id'));

        $row = isset($p['row']) ? $p['row'] :
            reqBuySellNote(array('buy_sell_id' => $in['buy_sell_id'],
                'company_id' => COMPANY_ID,
                'one' => true));

        $row['id'] = isset($row['id']) ? $row['id'] : '';
        $row['note'] = isset($row['note']) ? $row['note'] : '';

        $code = '
						<form id="form_note-form" class="" role="form">
								<div class="form-group">
									'.$this->Textarea(array('id' => 'note',
                'class' => 'product-area',
                'value' => $row['note'],
                'placeholder' => 'Заметка',
                'dopol' => 'cols="30" rows="10"'
            )).'
								</div>
								<div class="form-group">
									'.$this->Input(array('type' => 'submit',
                    'class' => 'product-button change-btn',
                    'value' => 'Сохранить'
                )
            ).'
								</div>
								'.$this->Input(array('type' => 'hidden',
                    'id' => 'id',
                    'value' => $row['id']
                )
            ).'
								'.$this->Input(array('type' => 'hidden',
                    'id' => 'buy_sell_id',
                    'value' => $in['buy_sell_id']
                )
            ).'
						</form>
						<script>
								$("#form_note-form").bootstrapValidator({
									/*fields: {
										note: {
											validators: {
												notEmpty: {
													message: "Заполните"
												}
											}
										}
									}*/
								}).on("success.form.bv", function(e) {
									e.preventDefault();
									var $form = $(e.target);
									var bv = $form.data("bootstrapValidator");
									var button=$(e.target).data("bootstrapValidator").getSubmitButton();
									var d = button.data();
										$.post("/save_note_buy_sell", $form.serialize(),
											function(data){
													if(data.ok){
														$("#div_note").html(data.code);
													}else{
														webix.message({type:"error", text:data.code});
													}
													if (bv.getInvalidFields().length > 0) {
														bv.disableSubmitButtons(false);
													}
											}
										);
								});
						</script>';

        return $code;
    }

    // Заметки - Объявление/Предложение/Заявки
    function NoteBuySellOne($p = array())
    {
        $in = fieldIn($p, array('buy_sell_id'));

        $r = reqBuySellNote(array('buy_sell_id' => $in['buy_sell_id'],
            'company_id' => COMPANY_ID,
            'one' => true));
        $r['note'] = isset($r['note']) ? $r['note'] : '';

        $code_note = self::NoteBuySellTextarea(array('row' => $r, 'buy_sell_id' => $in['buy_sell_id']));

        $code = '';

        $code = '<div class="text-left">
					Заметка <img src="/image/status-edit.svg" alt="" class="status-request edit_buy_sell_note" data-flag="1">
					<div id="div_note_view" class="text-muted font12">'.$r['note'].'</div>
					<div id="div_note_edit" style="display:none;">'.$code_note.'</div>
				</div>';

        return $code;
    }


    // модальное окно История
    function TableHistoryBuySell($p = array())
    {
        $in = fieldIn($p, array('id'));

        $r = reqBuySell(array('id' => $in['id']));
        if ($r['flag_buy_sell'] == 1) {
            $str1 = 'Объявления';
        } else {
            $str1 = 'Потребности';
        }

        $top = 'История '.$str1.' <small class="text-muted">'.$r['name'].', '.$this->nf($r['amount']).' '.$r['unit'].'</small>';

        $row = reqHistoryBuySell(array('buy_sell_id' => $in['id']));

        $tr = '';
        foreach ($row as $i => $m) {
            if ($m['value_old']) {
                $value = 'с '.$m['value_old'].' на '.$m['value_new'];
            } else {
                $value = $m['value_new'];
            }
            $tr .= '	<tr>
							<td>
								'.$m['company'].'
							</td>
							<td>
								'.$m['data_insert'].'
							</td>
							<td>
								'.$m['comments'].'
							</td>
							<td>
								'.$value.'
							</td>
						</tr>
				';
        }

        $content = '	<table id="" class="table font12" border="0" cellspacing="0" cellpadding="0" style="">
						<tbody>
							'.$tr.'
						</tbody>
					</table>';

        return array('top' => $top, 'content' => $content, 'bottom' => '');
    }

    /*
	// Предложения данные пользователем к Заявке (страница заявки - buy.php)
	function CodeMyOfferByBuy( $p=array() ){

		$in = fieldIn($p, array('buy_sell_id'));

		$code = '';

		if(COMPANY_ID){

			$row = reqBuySell(array('parent_id'=>$in['buy_sell_id'] , 'company_id'=>COMPANY_ID ));

			$tr = '';
			foreach($row as $i => $m){
					$arr_six = array(1=>'',2=>'',3=>'',4=>'',5=>'',6=>'');
					$r = reqBuySellAttributeSixParam(array('buy_sell_id'=>$m['id'],'categories_id'=>$m['categories_id'],'flag'=>'six'));
					foreach($r as $n => $mm){
						$arr_six[ $mm['sort'] ] = '<span class="c999">'.$mm['attribute'].'</span> <strong>'.$mm['attribute_value'].'</strong>';
					}


					$tr .= '	<tr>
								<td width="30%">
									<a href="/'.$m['url_cities'].'/'.$m['url_categories'].'/'.$m['url'].'" class="c000 bold" target="_blank">'.$m['amount'].' '.$m['unit'].'</a>
								</td>
								<td>
									<div class="row">
										<div class="col">
											'.$arr_six[1].'
										</div>
										<div class="col-6">
											'.$arr_six[2].'
										</div>
									</div>
									<div class="row">
										<div class="col">
											'.$arr_six[3].'
										</div>
										<div class="col-6">
											'.$arr_six[4].'
										</div>
									</div>
									<div class="row">
										<div class="col">
											'.$arr_six[5].'
										</div>
										<div class="col-6">
											'.$arr_six[6].'
										</div>
									</div>
								</td>
								<td align="center">
									'.$this->nf($m['cost']).'
									<div>
										<span class="badge badge-success">От '.$m['data_status_buy_sell_10'].'</span>
									</div>
								</td>
							</tr>
					';
			}

			$code = '	<table id="" class="table_offerbybuyell table table-borderless font12" border="0" cellspacing="0" cellpadding="0" style="">
							<tbody>
								'.$tr.'
							</tbody>
						</table>';
		}

		return $code;
	}
	*/

    // Содержание табличной части (стр. /buy-sell/buy)
    function TrMyBuySellShleif($p = array())
    {
        // - buy_sell_id
        $bs = new HtmlBuySell();

        $kol_status = $tr = $ico_photo = '';

        $m = isset($p['row']) ? $p['row'] : reqMyBuySell(array('id' => $p['buy_sell_id']));


        $r_dop = reqMyBuySell_DopParam(array('buy_sell_id' => $m['id'],
            'status_buy_sell_id' => $m['status_buy_sell_id'],
            'unit_group_id' => $m['unit_group_id']));// дополнительные параметры к записи


        if (is_array($m)) {

            $m['name'] = ($m['name']) ? $m['name'] : '-';
            /*
			if($m['status_buy_sell_id']>=10){
				$company = '<a href="/company-profile/'.$m['company_id2'].'" target="_blank">'.$m['company2'].'</a>';
				//$avatar	= '<img src="'.$m['avatar2'].'" alt="" class="user-img">';
			}else{

				if($m['company_id']==COMPANY_ID){// если своя компания, то показываем ответственного
					$company = $m['responsible'];
				}else{
					$company = '<a href="/company-profile/'.$m['company_id'].'" target="_blank">'.$m['company'].'</a>';
				}
				//$avatar	= '<img src="'.$m['avatar'].'" alt="" class="user-img">';

			}
*/
            if ($p['i'] == 1) {//номер записи
                $tr_cl = 'c000';
                if ($m['status_buy_sell_id'] == 11 && $r_dop['kol_status12'] > 0) {
                    if ($m['amount'] >= $r_dop['kol_status12']) {
                        $cl_kol_status12 = 'red';
                    } else {
                        $cl_kol_status12 = 'success';
                    }
                    $kol_status = '<span class="text-'.$cl_kol_status12.'">('.$this->nf($r_dop['kol_status12']).')</span>';
                }
            } else {
                $tr_cl = 'c999';
            }


            $arr_six = array(1 => '', 2 => '', 3 => '', 4 => '', 5 => '', 6 => '');
            $r = reqBuySellAttributeSixParam(array('buy_sell_id' => $m['id'], 'categories_id' => $m['categories_id'], 'flag' => 'six'));
            foreach ($r as $n => $mm) {
                $arr_six[$mm['sort']] = '<span data-name="'.$mm['attribute'].'">'.$mm['attribute_value'].'</span>';
            }


            // форма оплаты
            if ($m['form_payment_id'] == 3) {
                $form_payment = '<span class="request-money"></span>';
            } else {
                if ($m['form_payment']) {
                    $form_payment = '<span class="request-nds"><span class="ndsText">'.$m['form_payment'].'</span></span>';
                } else {
                    $form_payment = '';
                }
            }
            ///


            $cost = ($m['status_buy_sell_id'] <> 6) ? '	<span><span class="rpCost">'.$this->nf($m['cost']).'</span><span class="rpCurrency"> '.$m['currency'].'</span></span>
														'.$form_payment.'' : '';
            $cost_old = $m['cost'];


            if (PRAVA_5) {// Заказчик (не видит компании и цены)
                $cost = '';
                $company = '';
                //$avatar		= '';
            }

            // инока фото
            if ($r_dop['kol_photo']) {                        //href="/image/cars/3.jpg"
                $ico_photo = '<a data-fancybox="gallery8">
								<img src="/image/request-images.png" alt="" class="request-hidden-images" style="display: block;">
							</a>';
            }

            // цвета для срочности
            switch ($m['urgency_id']) {
                case '1':
                    $urgency_color = 'urgency-urgent';
                    break;
                case '2':
                    $urgency_color = 'urgency-week';
                    break;
                case '3':
                    $urgency_color = 'urgency-two-week';
                    break;
                case '4':
                    $urgency_color = 'urgency-month';
                    break;
                case '5':
                    $urgency_color = 'urgency-not-urgently';
            }

            // имя заказа
            $comments_company = $urgency = '';
            if ($m['status_buy_sell_id'] == 6) {
                $comments_company = ($m['flag_buy_sell'] == 2) ? '<span class="">'.$m['comments_company'].'</span>' : '';
                /*$urgency			= ' <span class="data-month '.$urgency_color.'">
												'.$m['urgency'].'
												<span class="bttip" style="display: none;">Срочность</span>
											</span>';*/
            }

            // Наличие
            $availability = '';
            if ($m['availability']) {
                $str = $this->format_by_count($m['availability'], 'день', 'дня', 'дней');
                $availability = $m['availability'].' '.$str;
            }
            //
            /*
			//
			if( $m['responsible_id'] && ($m['responsible_id']<>LOGIN_ID) ){
				$ico_responsible = '<span class="userImgCnt"><img src="/image/user-img.png" alt="" class="user-img"></span>';
			}
			*/

            $amount_unit = '<span class="rAmount">'.$this->nf($m['amount']).'</span> <span class="rMeasure"> '.$m['unit'].'</span>';

            // фасовка
            $packing = '';
            if ($m['unit_group_id']) {

                if ($m['unit_id2'] && $m['amount2']) {// выбрано ШТУКИ и другая ед.измерения
                    $t_amount = ($m['status_buy_sell_id'] == 11) ? $m['amount_buy'] : $m['amount1'];
                    $packing = '<span style="color:#b2afaf;">Фасовка</span><br/>'.$this->nf($t_amount).''.$m['unit1'].'/'.$this->nf($m['amount2']).''.$m['unit2'];
                    $cost = ''.$this->nf($m['cost1']).' '.$m['currency'];
                    $cost_old = $m['cost1'];
                    $cost_coefficient = '';
                    $amount_unit = '';
                } elseif ($m['unit_id1'] && !$m['unit_id2'] && ($m['unit_id'] <> $m['unit_id1'])) {// выбрано НЕ штуки, а другая ед.измерения отличная от "по умолчанию" у категории

                    $cost = ''.$this->nf($m['cost']).' '.$m['currency'].'/'.$m['unit'];
                    $cost_old = $m['cost'];

                    $t_amount = ($m['status_buy_sell_id'] == 11) ? $m['amount_buy'] : $m['amount1'];

                    $amount_unit = $this->nf($t_amount).''.$m['unit1'];

                }
            }
            ///


            $st_cost = '';
            if ($m['status_buy_sell_id'] == 12) {

                $rp = reqMyBuySell(array('id' => $m['parent_id']));

                if ($cost_old > $rp['cost']) {
                    $st_cost = 'color:#ff0000;';
                } elseif ($cost_old < $rp['cost']) {
                    $st_cost = 'color:#008000;';
                }
            }


            $tr = '	
					<div class="buy-item-main 333">
						<div class="buy-item-main-left">
							<div class="buy-item-main-left__left">
								<div class="buy-item-main-left__left-name">
									<a href="/'.$m['url_cities'].'/'.$m['url_categories'].'/'.$m['url'].'" class="'.$tr_cl.' bold" target="_blank">
										'.$m['name'].'
										<span class="bttip" style="display: none;">'.$m['name'].'</span>
									</a>
								</div>
								<div class="buy-item-main-left__left-city">
									'.$availability.' '.$m['cities_name'].'
									<span class="bttip" style="display: none;">Куда / Откуда</span>
								</div>
								<div class="buy-item-main-left__left-comment">
									<p class="comments">'.$m['comments'].'</p>
									'.$comments_company.'
								</div>
							</div>
							<div class="buy-item-main-left__right">
								<div class="buy-item-main-left__right-quantity">'.$amount_unit.' '.$kol_status.'</div>
								'.$packing.'
								<div class="buy-item-main-left__right-icon">'.$ico_photo.'</div>
							</div>
						</div>
						<div class="buy-item-main-center">
							<div class="buy-item-main-center_prop">'.$arr_six[1].'</div>
							<div class="buy-item-main-center_prop">'.$arr_six[2].'</div>
							<div class="buy-item-main-center_prop">'.$arr_six[3].'</div>
							<div class="buy-item-main-center_prop">'.$arr_six[4].'</div>
							<div class="buy-item-main-center_prop">'.$arr_six[5].'</div>
							<div class="buy-item-main-center_prop">'.$arr_six[6].'</div>
						</div>
						<div class="buy-item-main-right">
							<div class="buy-item-main-right__left">
								<div class="buy-item-main-right__left-cost" style="'.$st_cost.'">'.$cost.'</div>
								<div class="buy-item-main-right__left-company"></div>
							</div>
							
						</div>
					</div>
			';

            $a = array(11, 12, 14, 15);
            if (in_array($m['status_buy_sell_id'], $a)) {
                $parent_id = ($m['status_buy_sell_id'] == 11) ? $m['copy_id'] : $m['parent_id'];// в случае с "Куплено" дальше показываем "Копию"

                $arr = ($parent_id > 0) ? self::TrMyBuySellShleif(array('buy_sell_id' => $parent_id, 'i' => ($p['i'] + 1))) : array('tr' => '');
                $tr .= $arr['tr'];
            }

        }

        return array('tr' => $tr);
    }


    // Интересы - настройка пользователя
    function TrInterestsCompanyParam($p = array())
    {

        $p['login_id'] = (isset($p['login_id']) && !empty($p['login_id'])) ? $p['login_id'] : '';

        $tr = '';
        if (isset($p['row_interests']) && !empty($p['row_interests'])) {
            $p['row_interests'] = $p['row_interests'];
        } else {
            // выбираем последнее значение interests_id
            $row_m = reqInterestsCompanyParamMaxInterestsId();
            $p['row_interests'] = array(array('interests_id' => $row_m['interests_id']));
        }
        $row_categories = reqSlovCategories(array(/*'level'=>3,*/ 'active' => 1));
        $row_company = reqCompany();
        $row_urgency = reqSlovUrgency();
        $row_attribute23 = reqSlovAttributeValue(array('attribute_id' => 23));
        $row_attribute36 = reqSlovAttributeValue(array('attribute_id' => 36));

        foreach ($p['row_interests'] as $i => $m) {

            $tr .= self::TrOneInterestsCompanyParam(array('row_categories' => $row_categories,
                'row_company' => $row_company,
                'row_urgency' => $row_urgency,
                'row_attribute23' => $row_attribute23,
                'row_attribute36' => $row_attribute36,
                'interests_id' => $m['interests_id'],
                'flag' => $p['flag'],
                'login_id' => $p['login_id']));

        }

        return $tr;
    }

    // Интересы - настройка пользователя
    function TrOneInterestsCompanyParam($p = array())
    {

        $row = SlovInterestsParam();

        $tr = '';
        foreach ($row as $i => $m) {
            // сохраненные значения
            $row_tid = reqInterestsCompanyParamTid(array('interests_id' => $p['interests_id'],
                'interests_param_id' => $m['id'],
                'views' => 1));
            $arr_cc = array();
            foreach ($row_tid as $ii => $mm) {
                $arr_cc[] = $mm['tid'];
            }
            ///
            if ($m['id'] == 1) {// По категориям
                $pole = 'lcategories';
                $where = 'categories';
                $row = $p['row_categories'];
                $class = 'save_interests_company_param';
            } elseif ($m['id'] == 2) {// По местоположению
                $pole = 'name';
                $where = 'cities';
                $row = reqCities(array('flag' => 'interests',
                    'company_id' => COMPANY_ID,
                    'interests_id' => $p['interests_id'],
                    'interests_param_id' => $m['id']));
                /*
				$row		= ($arr_cc)? reqCities(array('flag'				=> 'interests',
													'company_id'		=> COMPANY_ID,
													'interests_id'		=> $p['interests_id'],
													'interests_param_id'=> $m['id']))
									: array();
				*/
                $class = 'save_interests_company_param_cities';
            } elseif ($m['id'] == 3) {// По пользователям
                $pole = 'company';
                $where = 'company';
                $row = $p['row_company'];
                $class = 'save_interests_company_param';
            } elseif ($m['id'] == 4) {// По срочности
                $pole = 'urgency';
                $where = 'urgency';
                $row = $p['row_urgency'];
                $class = 'save_interests_company_param';
            } elseif ($m['id'] == 5) {// Назначение
                $pole = 'attribute_value';
                $where = 'attribute36';
                $row = $p['row_attribute36'];
                $class = 'save_interests_company_param';
            } elseif ($m['id'] == 6) {// Тип
                $pole = 'attribute_value';
                $where = 'attribute23';
                $row = $p['row_attribute23'];
                $class = 'save_interests_company_param';
            }


            $tr .= '	
					<div class="interests-item">
						<div class="interests-name">
							'.$m['interests_param'].'
						</div>
						'.$this->HtmlInterestsSelect2(array('interests_id' => $p['interests_id'],
                    'interests_param_id' => $m['id'],
                    'row' => $row,
                    'pole' => $pole,
                    'class' => $class,
                    'arr_cc' => $arr_cc,
                    'flag' => $p['flag'],
                    'login_id' => $p['login_id'],
                    'where' => $where
                )).'
					</div>';
        }

        $tr = '	<div class="interests-wrapper">
					<div class="interests-info">
						'.$tr.'
					</div>
					<a href="/buy?interests_id='.$p['interests_id'].'" class="interests-go request-btn change-btn" target="_blank">Перейти</a>
				</div>';


        return $tr;
    }


    // Регистрация
    function ModalSearch($p = array())
    {

        $in = fieldIn($p, array('where'));

        $button_interests = $categories_id = $categories = $active_categories = $active_cities = $cities_id = $active_flag_buy_sell1 = $flag = '';

        $flag_buy_sell = 2;
        $active_flag_buy_sell2 = 'active';            // по умолчанию
        $categories = 'Категория';        // по умолчанию
        $cities_name = 'Город';            // по умолчанию
        $str_active_flag_buy_sell = 'Заявки';            // по умолчанию

        $sort_12 = 1;
        $st_sort_1 = '';
        $st_sort_2 = 'display:none;';
        $sort_who = 'sort_date';

        $flag_search = 4;


        $rf = reqSearchFilterParamCompany(array('login_id' => LOGIN_ID, 'company_id' => COMPANY_ID));
        if (!empty($rf)) {

            if ($rf['flag_search']) {// где поиск
                $flag_search = $rf['flag_search'];
            }

            $flag_buy_sell = ($flag_search == 2 || $flag_search == 4) ? 2 : 1;

            if ($rf['categories_id']) {
                $rsc = reqSlovCategories(array('id' => $rf['categories_id']));
                $categories_id = $rf['categories_id'];
                $categories = $rsc['categories'];
                $active_categories = 'active choosen';
            }

            if ($rf['cities_id']) {
                $rc = reqCities(array('id' => $rf['cities_id']));
                $cities_id = $rf['cities_id'];
                $cities_name = $rc['name'];
                $active_cities = 'choosen';
            }

            if ($rf['flag']) {// где поиск
                $flag = $rf['flag'];
            }

            // как сортировать
            if ($rf['sort_12'] == 1) {
                $sort_12 = 1;
                $st_sort_1 = '';
                $st_sort_2 = 'display:none;';
            } elseif ($rf['sort_12'] == 2) {
                $sort_12 = 2;
                $st_sort_1 = 'display:none;';
                $st_sort_2 = '';
            }

            $sort_who = $rf['sort_who'];


        } else {
            if (COMPANY_ID) {
                $company = reqCompany(array('id' => COMPANY_ID));
                $cities_id = $company['cities_id'];
                $cities_name = $company['cities_name'];
            } else {
                $arr_cities = $this->get_cities_id_by_ip($_SERVER['REMOTE_ADDR']);
                $cities_id = $arr_cities['cities_id'];
                $cities_name = $arr_cities['cities_name'];
            }
        }


        $r = reqInterestsCompanyParamByOneInterest();
        //vecho($in['flag_buy_sell'].$r['kol']);
        if ($flag_buy_sell == 2 && ($r['kol'] > 0)) {
            $data_flag_interest = ($rf['flag_interest']) ? 2 : 1;
            $button_interests = '<button class="request-btn interests-btn button_serch_flag_interest" data-flag="'.$data_flag_interest.'">Мои интересы</button>
							<input type="hidden" id="flag_serch_interest" value="'.$rf['flag_interest'].'">';
        }


        $search_select_group = $search_select_sort = '';
        if (COMPANY_ID) {

            $search_select_group = '<li class="nav-item">
									'.$this->SelectGroupSearchBuySell(array('id' => 0)).'
								</li>';
            $search_select_sort = '<li class="nav-item">
									<img src="/image/icon/arrow_up.svg" id="sort_arrow_up" class="sort_arrow" data-flag="up" style="'.$st_sort_1.'"/>
									<img src="/image/icon/arrow_down.svg" id="sort_arrow_down" class="sort_arrow" data-flag="down" style="'.$st_sort_2.'">
									'.$this->SelectSortSearchBuySell(array('id' => $sort_who)).'
									'.$this->Input(array('type' => 'hidden',
                        'id' => 'sort_12',
                        'value' => $sort_12
                    )
                ).'
								</li>';
        }


        $content = '<div class="btn search-main">
					<input type="text" placeholder="Что ищете?" class="search-input autocomplete_search_modal" autocomplete="off" required maxlength="100">
					<span class="after search-after" data-toggle="modal" data-target="#search-modal"></span>
					<div class="main-search__thumb">
					</div>
					'.$this->Input(array('type' => 'hidden',
                    'id' => 'flag',
                    'value' => $flag
                )
            ).'
				</div>
				<div class="hidden-wrapper">
					<ul class="nav nav-tabs setting-nav" id="myTab" role="tablist">
						<li class="nav-item">
								'.$this->SelectFlagSearchWherePage(array('id' => $flag_search)).'
						</li>
						<li class="nav-item">
							<a class="nav-link category-link '.$active_categories.'" id="order-tab" data-toggle="tab" href="#nav-category" role="tab" aria-controls="category" aria-selected="false">
							  <img src="/image/icon/part.png" alt="" class="setting-img"><span>'.$categories.'</span>
							  <div class="cancel-choose" data-flag="clear_category_search">x</div>
							</a>
						</li>
						<li class="nav-item">
							<a class="nav-link location-link '.$active_cities.'" id="partner-tab" data-toggle="tab" href="#nav-location" role="tab" aria-controls="location" aria-selected="false">
							  <img src="/image/icon/loc.png" alt="" class="setting-img"><span id="get_span_cities">'.$cities_name.'</span>
													  <div class="cancel-choose" data-flag="clear_location_search">x</div>
							</a>
						</li>
						'.$search_select_group.'
						'.$search_select_sort.'
						'.$button_interests.'
					</ul>
					<div class="tab-content" id="myTabContent">
						<div class="tab-pane fade show nav-first" id="nav-first" role="tabpanel" aria-labelledby="home-tab">
							<div class="app-wrapper blue-buttons">
								<button class="post-request '.$active_flag_buy_sell2.' param_search_buy_sell" data-src="/image/icon/request.png" data-flag_buy_sell="2">Заявка</button>
								<button class="post-post '.$active_flag_buy_sell1.' param_search_buy_sell" data-src="/image/icon/add.png" data-flag_buy_sell="1">Объявление</button>
									'.$this->Input(array('type' => 'hidden',
                    'id' => 'flag_buy_sell',
                    'value' => $flag_buy_sell
                )
            ).'
							</div>
						</div>
					  
					  
						<div class="tab-pane fade show nav-category" id="nav-category" role="tabpanel" aria-labelledby="home-tab">
							<div class="cat-wrapper">
								<div class="list-wrapper d-inline-flex">
									'.$this->CategoriesListElement(array('flag' => 'search')).'
									'.$this->Input(array('type' => 'hidden',
                    'id' => 'categories_id',
                    'value' => $categories_id
                )
            ).'
								</div>
							</div>
						</div>

						<div class="tab-pane fade show nav-location" id="nav-location" role="tabpanel" aria-labelledby="home-tab">
							<div class="city city-wrapper">
								<input type="text" placeholder="Введите город" class="city-input autocomplete_cities" value="'.(($cities_name <> 'Город') ? $cities_name : '').'" autocomplete="off">
								'.$this->Input(array('type' => 'hidden',
                    'id' => 'cities_id',
                    'value' => $cities_id
                )
            ).'
								<div class="city-thumbs">
								</div>
							</div>
						</div>
					</div>
				</div>';

        return array('content' => $content);
    }


    // Выбор категории в "Поиске" и при создании "Заявки/Объявления"
    function CategoriesListElement($p = array())
    {
        $in = fieldIn($p, array('flag', 'flag_buy_sell'));

        $code = '';
        $arr_0 = $arr_1 = $arr_2 = $arr_3 = array();

        $row0 = reqSlovCategories(array('parent_id' => 0, 'active' => true));
        foreach ($row0 as $i => $m0) {
            $arr_0[] = '<p class="level0_'.$m0['id'].'" data-block="level0_'.$m0['id'].'" 
															data-categories_id="'.$m0['id'].'" 
															data-flag="'.$in['flag'].'"
															data-flag_buy_sell="'.$in['flag_buy_sell'].'">'.$m0['categories'].'</p>';

            // Первый уровень
            $row1 = reqSlovCategories(array('parent_id' => $m0['id'], 'active' => true));
            $p1 = '';
            foreach ($row1 as $i => $m1) {
                $p1 .= '<p class="level1_'.$m1['id'].'" data-block="level1_'.$m1['id'].'" 
															data-categories_id="'.$m1['id'].'" 
															data-flag="'.$in['flag'].'"
															data-flag_buy_sell="'.$in['flag_buy_sell'].'">'.$m1['categories'].'</p>';

                // Второй уровень
                $row2 = reqSlovCategories(array('parent_id' => $m1['id'], 'active' => true));
                $p2 = '';
                foreach ($row2 as $i => $m2) {
                    $p2 .= '<p class="level2_'.$m2['id'].'" data-block="level2_'.$m2['id'].'"
																		data-categories_id="'.$m2['id'].'" 
																		data-flag="'.$in['flag'].'"
																		data-flag_buy_sell="'.$in['flag_buy_sell'].'">'.$m2['categories'].'</p>';

                    // Третий уровень
                    $row3 = reqSlovCategories(array('parent_id' => $m2['id'], 'active' => true));
                    $p3 = '';
                    foreach ($row3 as $i => $m3) {
                        $p3 .= '<p class="level3_'.$m3['id'].'" data-block="level3_'.$m2['id'].'" 
																				data-categories_id="'.$m3['id'].'" 
																				data-flag="'.$in['flag'].'"
																				data-flag_buy_sell="'.$in['flag_buy_sell'].'">'.$m3['categories'].'</p>';
                    }
                    $arr_3[] = '	<div class="level2_'.$m2['id'].'">
												'.$p3.'
											</div>';
                }
                $arr_2[] = '	<div class="level1_'.$m1['id'].'">
										'.$p2.'
									</div>';
            }
            $arr_1[] = '	<div class="level0_'.$m0['id'].'">
								'.$p1.'
							</div>';

        }

        $code = '<div class="cat-changer">
					'.implode('', $arr_0).'
				</div>
				<div class="list-element element-1">
					'.implode('', $arr_1).'
				</div>
				<div class="list-element element-2">
					'.implode('', $arr_2).'
				</div>
				<div class="list-element element-3">
					'.implode('', $arr_3).'
				</div>';

        return $code;
    }


    // Поделиться - Текс в модали после нажатия на кнопку Отправить E-mail/Копировать ссылку
    function TextAfterClickSendCopyShare($p = array())
    {

        if ($p['flag'] == 1) {// Отправить E-mail
            $code = 'Потребность отправлена
					<br/>
					<br/>
					Пользователь получит ссылку, при открытии которой, он увидит вашу потребность
					<br/>
					После того как он даст предложение, Вы увидите его у себя в предложениях
					<button type="button" data-dismiss="modal">Понятно</button>
					';
        } elseif ($p['flag'] == 2) {// Копировать ссылку
            $code = 'Ссылка скопирована
					<br/>
					<br/>
					Ссылка скопирована в буфер обмена
					<br/>
					Отправьте ее и, когда пользователь даст предложение, Вы увидите его у себя в предложениях
					<button type="button" data-dismiss="modal">Понятно</button>
					';
        }

        return $code;
    }

    // Страница объявление (sell.php) - строки
    function TrPageSell($p = array())
    {
        $in = fieldIn($p, array('view_grouping'));

        $m = $p['row'];


        $arr_six = array(1 => '', 2 => '', 3 => '', 4 => '', 5 => '', 6 => '');
        $r = reqBuySellAttributeSixParam(array('buy_sell_id' => $m['id'], 'categories_id' => $m['categories_id'], 'flag' => 'six'));
        foreach ($r as $n => $mm) {
            $arr = explode(',', $m['attribute_ids_grouping']);
            if (in_array($mm['id'], $arr) || !$m['kol_grouping']) {
                $arr_six[$mm['sort']] = '<span data-name="'.$mm['attribute'].'">'.$mm['attribute_value'].'</span>';
            }
        }

        $company = '<a href="/company-profile/'.$m['company_id'].'" target="_blank">'.$m['company'].'</a>';

        $cost_coefficient = ($m['cost_coefficient'] > 0) ? '('.$this->nf($m['cost_coefficient']).')' : '';

        // кнопка купить на кого подписан
        $button_buy = '';
        if ((PRAVA_2 || PRAVA_3) && ($m['flag_subscriptions_company_in'] || $m['flag_subscriptions_company_out'])) {
            //if(COMPANY_ID&&COMPANY_ID<>$m['company_id']){

            $button_buy = $this->Input(array('type' => 'button',
                    'class' => 'pull-right btn btn-pfimary btn-sm get_form_buy_amount',
                    'value' => 'купить',
                    'data' => array('id' => $m['id'], 'where' => 'page_sell')
                )
            );
        }


        // изображение
        $arr = self::getImgBuySell(array('buy_sell_id' => $m['id']));
        $img = $arr['code'];
        ///

        // группированная строка
        $button_grouping = $div_view_grouping = '';
        if ($m['kol_grouping'] && !$in['view_grouping']) {
            $button_buy = '';
            $company = $m['cities_name'] = $m['urgency'] = $m['data_status_buy_sell_23'] = $m['categories'] = '';//$day_noactive =
            $m['comments'] = $m['form_payment'] = $m['cities_name'] = $m['unit'] = $m['amount'] = '';
            $button_grouping = $this->Input(array('type' => 'button',
                        'id' => 'view_grouping'.$m['id'],
                        'class' => 'change-btn view_grouping',
                        'value' => 'от '.$m['min_cost_grouping'].' '.$m['currency'].' ('.$m['kol_grouping'].')',
                        'data' => array('value' => $m['val_grouping'], 'id' => $m['id'], 'flag' => 'sell')
                    )
                ).'
									'.$this->Input(array('type' => 'button',
                        'id' => 'close_view_grouping'.$m['id'],
                        'class' => 'change-btn close_view_grouping',
                        'value' => 'Свернуть',
                        'dopol' => 'style="display:none;"',
                        'data' => array('id' => $m['id'])
                    )
                );
            $div_view_grouping = '	<div id="tr_'.$m['id'].'" class="request-hidden" style="display:none;">
							
										</div>';
        }
        ///

        // форма оплаты
        if ($m['form_payment_id'] == 3) {
            $form_payment = '<span class="request-money"></span>';
        } else {
            if ($m['form_payment']) {
                $form_payment = '<span class="request-nds"><span class="ndsText">'.$m['form_payment'].'</span></span>';
            } else {
                $form_payment = '';
            }
        }
        ///

        // Срочность
        $urgency = ($m['urgency_id'] == 1) ? '<span class="data-month urgency-urgent">'.$m['urgency'].'</span>' : '';
        ///
        if ($img == '') {
            $noPhoto = ' no-photo';
        } else {
            $noPhoto = '';
        }

        // Наличие
        $availability = $availability_str = '';
        if ($m['availability']) {
            $availability_str = $this->format_by_count($m['availability'], 'день', 'дня', 'дней');
            $availability = $m['availability'];
        }
        //

        $consignment = ($m['min_party'] || $m['multiplicity']) ? '<span class="sell-item_quantity-bottom__left">'.$m['min_party'].'</span>/<span class="sell-item_quantity-bottom__right">'.$m['multiplicity'].'</span>' : '';

        // количество купленных
        $kol_status = '';
        if ($m['kol_status11'] > 0) {
            $kol_status = '&nbsp;<span class="request-quantity__bought" title="куплено">('.$this->nf($m['kol_status11']).')</span>';
        }


        $m['name'] = ($m['name']) ? $m['name'] : '-';


        $tr = '	<div class="sell-item view_2'.$noPhoto.'">
						<div class="request-slider-wrapper">
							<div class="image-wrapper">
								<div class="inner-wrapper">
									'.$img.'
								</div>
							</div>
							<div class="slider-control"></div>
						</div>
						<div class="sell-item__info">
							<div class="sell-item_name">
								<div class="sell-item_name-top">
									<a href="/'.$m['url_cities'].'/'.$m['url_categories'].'/'.$m['url'].'" target="_blank">'.$m['name'].'</a>
								</div>
								<div class="sell-item_name-bottom">
									<span class="sell-item_name-bottom__num">'.$availability.' </span>
									<span class="sell-item_name-bottom__time">'.$availability_str.'</span>
								</div>
							</div>
							<div class="sell-item_quantity">
								<div class="sell-item_quantity-top">
									<span class="sell-item_quantity-top__quantity">'.$this->nf($m['amount']).' '.$m['unit'].'</span>'.$kol_status.'
								</div>
								<div class="sell-item_quantity-bottom">
									'.$consignment.'
								</div>
							</div>
							<div class="sell-item_price">
								<div class="sell-item_prop-left">
									<div class="sell-item_prop-left__top">'.$cost_coefficient.'</div>
									<div class="sell-item_prop-left__bottom"></div>
								</div>
								<div class="sell-item_prop-middle">
									<div class="sell-item_prop-middle__top">'.$this->nf($m['cost']).' <span class="sell-item_prop-top__new-currency">'.$m['currency'].'</span></div>
									<div class="sell-item_prop-middle__bottom"><div>3 000 Р</div></div>
								</div>
								<div class="sell-item_prop-right">
									<div class="sell-item_prop-right__top">'.$form_payment.'</div>
									<div class="sell-item_prop-right__bottom"></div>
								</div>
							</div>
							<div class="sell-item_prop">
								<div class="sell-item_prop-item">'.$arr_six[1].'</div>
								<div class="sell-item_prop-item">'.$arr_six[2].'</div>
								<div class="sell-item_prop-item">'.$arr_six[3].'</div>
								<div class="sell-item_prop-item">'.$arr_six[4].'</div>
								<div class="sell-item_prop-item">'.$arr_six[5].'</div>
								<div class="sell-item_prop-item">'.$arr_six[6].'</div>
							</div>
							<div class="sell-item_middle">
								<div class="sell-item_middle-comment">'.$m['comments'].'</div>
								<div class="sell-item_middle-btn">'.$button_buy.''.$button_grouping.'</div>
							</div>
							<div class="sell-item_bottom">
								<div class="sell-item_bottom-left">
									<span class="sell-item_bottom-left__sticker">'.$urgency.'</span>
									<span class="sell-item_bottom-left__city">'.$m['cities_name'].',</span>
									<span class="sell-item_bottom-left__date"> '.$m['data_status_buy_sell_23'].'</span>
									
								</div>
								<div class="sell-item_bottom-right">
									<span class="sell-item_bottom-right__cat">'.$m['categories'].'</span>
									<!--<span class="sell-item_bottom-right__icon">●</span>-->
									<span class="sell-item_bottom-right__name">'.$company.'</span>
								</div>
							</div>
							<div class="sell-item_status-bars status-bar">
								<button>
									<img src="/image/status-mail.svg" alt="Отправить сообщение (Чужие объявления)" class="status-request write_message_need" 
										data-need="26" 
										data-company="'.$m['company_id'].'"
										data-id="'.$m['id'].'"
										data-url="/'.$m['url_cities'].'/'.$m['url_categories'].'/'.$m['url'].'"
									>
								</button>
							</div>
						</div>
					</div>

					'.$div_view_grouping.'';


        return $tr;
    }


    // Страница объявление (sell.php) - строки
    function TrPageSell22($p = array())
    {
        $in = fieldIn($p, array('view_grouping'));

        $sell22 = '';

        $m = $p['row'];


        $arr_six = array(1 => array('', ''), 2 => array('', ''), 3 => array('', ''), 4 => array('', ''), 5 => array('', ''), 6 => array('', ''));
        $r = reqBuySellAttributeSixParam(array('buy_sell_id' => $m['id'], 'categories_id' => $m['categories_id'], 'flag' => 'six'));
        foreach ($r as $n => $mm) {
            $arr = explode(',', $m['attribute_ids_grouping']);
            if (in_array($mm['id'], $arr) || !$m['kol_grouping']) {
                $arr_six[$mm['sort']] = array($mm['attribute'], $mm['attribute_value']);
            }
        }


        // изображение
        $arr = self::getImgBuySell(array('buy_sell_id' => $m['id']));
        $img = $arr['code'];
        ///

        // группированная строка
        $button_grouping = $div_view_grouping = '';
        if ($m['kol_grouping'] && !$in['view_grouping']) {
            $button_buy = '';
            $m['company'] = $m['cities_name'] = $m['urgency'] = $m['data_status_buy_sell_23'] = $m['categories'] = '';//$day_noactive =
            $m['comments'] = $m['form_payment'] = $m['cities_name'] = $m['unit'] = $m['amount'] = '';
            $button_grouping = $this->Input(array('type' => 'button',
                        'id' => 'view_grouping'.$m['id'],
                        'class' => 'change-btn view_grouping',
                        'value' => 'от '.$m['min_cost_grouping'].' '.$m['currency'].' ('.$m['kol_grouping'].')',
                        'data' => array('value' => $m['val_grouping'], 'id' => $m['id'], 'flag' => 'sell')
                    )
                ).'
									'.$this->Input(array('type' => 'button',
                        'id' => 'close_view_grouping'.$m['id'],
                        'class' => 'change-btn close_view_grouping',
                        'value' => 'Свернуть',
                        'dopol' => 'style="display:none;"',
                        'data' => array('id' => $m['id'])
                    )
                );
        }
        ///


        $sell22 = require($_SERVER['DOCUMENT_ROOT'].'/new/dist/sell22.php');


        return $sell22;
    }


    // сгруппированные строки объявление
    function TrViewGrouping_Sell($p = array())
    {

        $row = reqBuySell_PageSell(array('val_grouping' => $p['val_grouping']));

        $tr = '';
        foreach ($row as $i => $m) {

            $tr .= self::TrPageSell22(array('row' => $m, 'view_grouping' => true));

        }

        return $tr;
    }


    // сгруппированные строки объявление
    function TrViewGrouping_Offer($p = array())
    {

        $in = fieldIn($p, array('parent_id', 'flag_limit', 'start_limit'));

        $row = reqBuySell_Offer(array('parent_id' => $in['parent_id'],
            'val_grouping' => $p['val_grouping'],
            'flag_limit' => $in['flag_limit'],
            'start_limit' => $in['start_limit']));

        $arr_tid = array();
        $tr = '';
        foreach ($row as $i => $m) {

            //$tr .= self::TrModalOffer(array('row'=>$m,'view_grouping'=>true));
            $arr = self::TrModalOffer(array('row' => $m,
                'view_group' => true));
            $tr .= $arr['tr'];
            if ($arr['notification_tid']) {
                $arr_tid[] = $arr['notification_tid'];
            }
        }

        $tid = implode(',', $arr_tid);

        $dop_offer = '';
        if ($in['flag_limit']) {

            $next_step = $in['start_limit'] + 5;

            // количество и минимальная цена
            $row_count = reqBuySell_Offer(array('parent_id' => $in['parent_id'],
                'val_grouping' => $p['val_grouping'],
                'flag' => 'count',
                'flag_limit' => true,
                'start_limit' => $next_step,
                'end_limit' => 999999));
            if ($row_count['kol'] > 0) {
                if ($row_count['kol'] < 5) {
                    $kol = $row_count['kol'];
                } else {
                    $kol = 5;
                }

                $dop_offer = '<div class="request-hidden__bottom"> <span class="view_grouping" data-value="'.$p['val_grouping'].'"
																							data-parent_id="'.$in['parent_id'].'"
																							data-flag="offer"
																							data-flag_tr="3"
																							data-flag_limit="true"
																							data-start_limit="'.$next_step.'">показать ещё '.$kol.' предложение из '.$row_count['kol'].' от '.$this->nf($row_count['min_cost']).'р.</span> 
						или <span class="view_grouping" data-value="'.$p['val_grouping'].'"
														data-parent_id="'.$in['parent_id'].'"
														data-flag="offer"
														data-flag_tr="2">Показать все предложения</span></div> <!-- Эту строку нужно оставить только в единственном экземпляре в сгруппированном списке в конце -->';
            }
        }

        $tr = $tr.$dop_offer;

        return array('code' => $tr, 'tid' => $tid);
    }


    // Приглашенsq сотрудник
    function HtmlInviteWorkers($in = array())
    {

        $online = $str = '';//worker-online
        $cl_role = $span_role = $edit = $delete = '';

        if ($in['prava_id'] == 2) {
            $cl_role = 'worker-admin';
            $span_role = '<span class="worker-for-admin">Админ</span>';
        } else {
            $edit = '<img src="/image/status-edit.svg" alt="" class="status-request modal_invite_workers" data-id="'.$in['id'].'" data-flag="'.$in['flag'].'" >';
            $delete = '<u class="delete_invite_workers" data-id="'.$in['id'].'" data-flag="'.$in['flag'].'" data-question="Удалить" data-name="'.$in['name'].'">удалить</u>';
        }

        if ($in['flag'] == 2) {
            $str = '<strong>Не зарегистрирован</strong>';
        }

        $code = '<div id="div_workers'.$in['id'].'" class="workers-worker '.$online.' '.$cl_role.'">
					<div class="worker-left">
						<div class="worker-img">
							<img src="'.$in['avatar'].'" alt="">
						</div>
						'.$span_role.'
					</div>
					<div class="worker-info">
						<div class="worker-name">
							<span>'.$in['name'].'</span>
							'.$edit.'
							'.$delete.'
						</div>
						<div class="worker-prof">
							'.$in['position'].'
						</div>
						<div class="worker-contacts">
							'.$in['phone'].', '.$in['email'].'
						</div>
						'.$str.'
					</div>
				</div>';

        return $code;
    }


    // Html представление табличной части "Заявки" (Мои заявки)
    function TrMyBuy($p = array())
    {

        $bs = new HtmlBuySell();

        $tr = $ico_responsible = $kol_status = '';

        $m = $p['m'];


        $cache = isset($p['cache']) ? true : false;

        $flag_cache = (isset($p['flag_cache']) && !empty($p['flag_cache'])) ? $p['flag_cache'] : '';

        $r_dop = reqMyBuySell_DopParam(array('buy_sell_id' => $m['id'],
            'status_buy_sell_id' => $m['status_buy_sell_id'],
            'unit_group_id' => $m['unit_group_id']));// дополнительные параметры к записи

        $arr_six = array(1 => '', 2 => '', 3 => '', 4 => '', 5 => '', 6 => '');
        $r = reqBuySellAttributeSixParam(array('buy_sell_id' => $m['id'], 'categories_id' => $m['categories_id'], 'flag' => 'six'));
        foreach ($r as $n => $mm) {
            $arr_six[$mm['sort']] = '<span data-name="'.$mm['attribute'].'">'.$mm['attribute_value'].'</span>';
        }

        $notification = ($r_dop['kol_notification']) ? '<span class="badge badge-warning badge-pill">&nbsp;</span>' : '';


        if ($cache) {
            $button = '{ACTION_BUY_SELL}';
            $kol_views = '{KOL_VIEWS}';
            $kol_status = '{KOL_STATUS}';
        } else {
            $button = $bs->ActionBuySell(array('row' => $m));
            $kol_views = $r_dop['kol_views'];
            // количество купленных
            if ($r_dop['kol_status11'] > 0) {// количество купленных
                $kol_status = '&nbsp;<span style="color:#008000;" title="куплено">('.$this->nf($r_dop['kol_status11']).')</span>';
            }
        }


        $form_buy_sell = $form_buy_sell_hidden = $edit = $button_edit = $qrq_update = '';


        $data_status_buy_sell_23 = ($m['data_status_buy_sell_23']) ? $m['data_status_buy_sell_23'] : '';


        if ($m['status_buy_sell_id'] == 1 || $m['status_buy_sell_id'] == 2 || $m['status_buy_sell_id'] == 3) {
            // дать предложение
            $form_buy_sell = $this->Input(array('type' => 'button',
                    'id' => 'button_form_buy_sell'.$m['id'],
                    'class' => 'for-hidden-request form_buy_sell',
                    'value' => '<img src="/image/status-request.svg" alt="" class="status-request">',
                    'data' => array('id' => $m['id'],
                        'status' => 10,
                        'categories_id' => $m['categories_id'],
                        'value' => 3,
                        'flag' => 'mybuy',
                        'flag_offer_share' => true)
                )
            );
            $form_buy_sell_hidden = $this->Input(array('type' => 'button',
                    'class' => 'change-btn form_buy_sell_hidden',
                    'value' => 'Свернуть',
                    'data' => array('id' => $m['id'])
                )
            );

            $button_edit = '<button class="modal_buy_sell" data-id="'.$m['id'].'" 
																data-flag_buy_sell="'.$m['flag_buy_sell'].'" 
																data-status="'.$m['status_buy_sell_id'].'" 
																data-nomenclature_id="'.$m['nomenclature_id'].'">
									<img src="/image/status-edit.svg" alt="" class="status-request">
								</button>';
            $qrq_update = '	<button class="qrq_update_in_buy_sell" data-id="'.$m['id'].'">
										<img src="/image/ic_refresh.png" alt="" class="status-request">
									</button>';


        }


        $checkbox_share = '';
        if ($m['status_buy_sell_id'] == 2 || $m['status_buy_sell_id'] == 3) {
            $checkbox_share = '<input type="checkbox" class="checkbox_share" data-id="'.$m['id'].'" style="display:none;"/>';
        }

        $status_buy2 = $m['status_buy2'];
        if ($m['status_buy_sell_id'] == 1 || $m['status_buy_sell_id'] == 2) {
            $status_buy2 = '<span class="modal_history_buy_sell" data-id="'.$m['id'].'">'.$m['status_buy2'].'</span>';
        }


        if ($cache) {
            $comments_company = '{COMMENTS_COMPANY}';
        } else {
            $comments_company = ($m['comments_company'] && PRO_MODE) ? '	<span class="data-time-type">'.$m['comments_company'].'</span>' : '';
        }


        // изображение
        $arr = self::getImgBuySell(array('buy_sell_id' => $m['id']));
        $img = $arr['code'];
        ///


        // если есть шлейф заявки до Опубликованной/Активной
        $code_shleyf1 = '';
        if ($m['status_buy_sell_id'] == 1 || $m['status_buy_sell_id'] == 2 || $m['status_buy_sell_id'] == 3) {
            if ($r_dop['id_shleyf']) {
                $arr = $this->TrMyBuySellShleif(array('buy_sell_id' => $r_dop['id_shleyf'], 'i' => 1));
                $code_shleyf1 = $arr['tr'];
            }
        } else {
            $r1['parent_id'] = $r2['id'] = '';
            // Проверяем есть ли шлейф создателя заявки
            $code_shleyf1 = '';
            if ($m['parent_id']) {
                $r1 = reqBuySell_SaveBuySell(array('id' => $m['parent_id']));

                $r2 = (isset($r1['parent_id']) && !empty($r1['parent_id'])) ? reqBuySell_SaveBuySell(array('parent_id' => $r1['parent_id'], 'status_buy_sell_id' => 7, 'flag' => 'shleyf_one')) : array('id' => '');
                $r2['id'] = isset($r2['id']) ? $r2['id'] : '';

                if ($r2['id']) {
                    $arr2 = $this->TrMyBuySellShleif(array('buy_sell_id' => $r2['id'], 'i' => 1));
                    $code_shleyf1 = $arr2['tr'];
                } else {
                    if (isset($r1['parent_id']) && !empty($r1['parent_id'])) {
                        $r3 = reqBuySell_SaveBuySell(array('id' => $r1['parent_id']));
                        if ($r3['flag_buy_sell'] == 1) {// куплено объявление
                            $m['copy_id'] = $r1['id'];
                        }
                    }
                }

            }
            ///
        }

        // иконка ответственный
        if ($cache) {
            $ico_responsible = '{ICO_RESPONSIBLE}';
        } else {
            if ($m['responsible_id'] && ($m['responsible_id'] <> LOGIN_ID)) {
                $ico_responsible = '<span class="userImgCnt"><img src="/image/user-img.png" alt="" class="user-img"></span>';
            }
        }

        ///

        // цвета для срочности
        switch ($m['urgency_id']) {
            case '1':
                $urgency_color = 'urgency-urgent';
                break;
            case '2':
                $urgency_color = 'urgency-week';
                break;
            case '3':
                $urgency_color = 'urgency-two-week';
                break;
            case '4':
                $urgency_color = 'urgency-month';
                break;
            case '5':
                $urgency_color = 'urgency-not-urgently';
        }

        $urgency = '<span class="data-month '.$urgency_color.'">
							'.$m['urgency'].'
							<span class="bttip" style="display: none;">Срочность</span>
						</span>';

        // Не опубликованные, Опубликованные, Активные, (Купленные чужие объявления)
        if (!$code_shleyf1 && !$m['copy_id'] && $flag_cache <> 'assets') {

            if ($img == '') {
                $noPhoto = ' no-photo noPhoto';
            } else {
                $noPhoto = '';
            }


            $cost = $company = '';
            if ($m['status_buy_sell_id'] == 11) {// (Купленные чужие объявления)
                // форма оплаты
                if ($m['form_payment_id'] == 3) {
                    $form_payment = '<span class="request-money"></span>';
                } else {
                    if ($m['form_payment']) {
                        $form_payment = '<span class="request-nds"><span class="ndsText">'.$m['form_payment'].'</span></span>';
                    } else {
                        $form_payment = '';
                    }
                }
                ///
                $cost = '	<span><span class="rpCost">'.$this->nf($m['cost']).'</span><span class="rpCurrency"> '.$m['currency'].'</span></span>
									'.$form_payment;

                $company = '<a href="/company-profile/'.$m['company_id2'].'" target="_blank">'.$m['company2'].'</a>';

            }

            $m['name'] = ($m['name']) ? $m['name'] : '-';

            // количество/ед.измерения
            $amount_unit = '<span class="rAmount">'.$this->nf($m['amount']).'</span> <span class="rMeasure"> '.$m['unit'].'</span>';

            // фасовка
            $packing = $packing_unit2 = '';
            if ($m['unit_group_id']) {
                if ($m['unit_id2'] && $m['amount2']) {// выбрано ШТУКИ и другая ед.измерения
                    $packing = '<div>'.$this->nf($m['amount1']).' '.$m['unit1'].'</div>';
                    $packing_unit2 = '<span>'.$this->nf($m['amount2']).''.$m['unit2'].'<span class="bttip" style="display: none;">Фасовка</span></span>';

                    $cost = ''.$this->nf($m['cost1']).' '.$m['currency'];

                    $arr_six[6] = '';
                    $amount_unit = '';
                } elseif ($m['unit_id1'] && !$m['unit_id2'] && ($m['unit_id'] <> $m['unit_id1'])) {// выбрано НЕ штуки, а другая ед.измерения отличная от "по умолчанию" у категории

                    $cost = ''.$this->nf($m['cost']).' '.$m['currency'].'/'.$m['unit'];

                    $t_amount = ($m['status_buy_sell_id'] == 11) ? $m['amount_buy'] : $m['amount1'];

                    $amount_unit = $this->nf($t_amount).''.$m['unit1'];

                }
            }
            ///

            $tr .= '
							<div class="request-item'.$noPhoto.' item-list-4">
								<div class="request-slider-wrapper">
									<div class="image-wrapper">
										<div class="inner-wrapper">
											'.$img.'
										</div>
									</div>
									<div class="slider-control"></div>
								</div>
								<div class="request-info">
									<div class="request-info-head">
										<div class="request-stages">
											<div class="request-stage">
												<div class="request-data-name 444">
													'.$checkbox_share.'
													<p>
														<a href="/'.$m['url_cities'].'/'.$m['url_categories'].'/'.$m['url'].'" target="_blank">'.$m['name'].'</a>
													</p>
													<span class="request-quantity">'.$amount_unit.''.$packing.'</span>'.$kol_status.'
													<span class="data-hidden-city">'.$m['cities_name'].'</span>
													<a href="">
														<img src="/image/request-images.png" alt="" class="request-hidden-images">
													</a>
													<div class="request-data-hidden-name">
														'.$m['name'].'
													</div>
												</div>
											
												<div class="request-pricing">
													<div class="request-price">
														
													</div>
													<div class="request-user">
														<span class="user-name">'.$m['responsible'].'</span>
														'.$ico_responsible.'
													</div>
												</div>
												<div class="request-data">
													<div class="request-data-params">
														'.$packing_unit2.'
														'.$arr_six[1].'
														'.$arr_six[2].'
														'.$arr_six[3].'
														'.$arr_six[4].'
														'.$arr_six[5].'
														'.$arr_six[6].'
													</div>
													
													<div class="buy-item-main-right">
														<div class="buy-item-main-right__left">
															<div class="buy-item-main-right__left-cost">'.$cost.'</div>
															<div class="buy-item-main-right__left-company">'.$company.'</div>
														</div>
														
													</div>
													
													{ASSETS}
												</div>
												
												<div class="request-for-price">
													<p class="comments">
														'.$m['comments'].'
													</p>
													<span class="bttip" style="display: none;">'.$m['comments'].'</span>
												</div>
											</div>
											
										</div>
										<div class="request-actions">
											<p class="request-status">
												<span class="status-category">
												'.$m['categories'].'<span class="bttip">Категория: '.$m['categories'].'</span>
												</span>
												<span class="status-condition">
													'.$status_buy2.'
												</span>
												<span class="status-when">'.$data_status_buy_sell_23.'</span>
											</p>
											'.$notification.'
											<div class="status-bar">
												'.$button_edit.'
												'.$form_buy_sell.'
												<button class="convert">
													3<img src="/image/status-mail.svg" alt="Отправить сообщение (Мои заявки)" class="status-request write_message_need" 
														data-need="25" 
														data-company="'.COMPANY_ID.'"
														data-id="'.$m['id'].'"
														data-url="/'.$m['url_cities'].'/'.$m['url_categories'].'/'.$m['url'].'"
													>
												</button>
												'.$qrq_update.'
											</div>
											<p></p>
											<div id="div_form_buy_sell'.$m['id'].'">'.$button.'</div>
											<div id="div_form_buy_sell_hidden'.$m['id'].'" style="display:none;">'.$form_buy_sell_hidden.'</div>
											
										</div>
									</div>
									<div class="request-data-place">
										'.$urgency.'
										<span class="data-city">
											'.$m['cities_name'].'
											'.$edit.'
										</span>
										'.$comments_company.'
										
										<div class="request-stats">
												{DAY_NOACTIVE}
												<span class="request-views">'.$kol_views.'</span>
											</div>
									</div>
								</div>
							</div>
							  
							<div id="tr_'.$m['id'].'" class="request-hidden">
									
							</div>
							
					';


        } // Куплено, Исполнено, Возврат, Возвращено
        else {

            $company = $ico_responsible = $responsible = '';


            if ($cache) {
                $ico_responsible = '{ICO_RESPONSIBLE}';
                $company = '{COMPANY}';
                $responsible = '{RESPONSIBLE}';
            } else {

                if ($m['status_buy_sell_id'] >= 10) {
                    $company = '<a href="/company-profile/'.$m['company_id2'].'" target="_blank">'.$m['company2'].'</a>';
                    $responsible = ($m['responsible']) ? '<span class="user-name">'.$m['responsible'].'</span>' : '';
                } else {

                    if ($m['company_id'] == COMPANY_ID) {// если своя компания, то показываем ответственного
                        $company = $m['responsible'];
                    } else {
                        $company = '<a href="/company-profile/'.$m['company_id'].'" target="_blank">'.$m['company'].'</a>';
                    }

                }

                if (PRAVA_5) {// Заказчик (не видит компании и цены)
                    $company = '';
                }

                if ($m['responsible_id'] && ($m['responsible_id'] <> LOGIN_ID)) {
                    $ico_responsible = '<span class="userImgCnt"><img src="/image/user-img.png" alt="" class="user-img"></span>';
                }
            }


            $arr = $this->TrMyBuySellShleif(array('buy_sell_id' => $m['id'], 'i' => 1));


            $tr .= '
						<div class="container">
							<div class="request-item buy-item_3">
								<div class="request-slider-wrapper d-none">
									<div class="image-wrapper">
										<div class="inner-wrapper">
											'.$img.'
										</div>
									</div>
									<div class="slider-control">
									</div>
								</div>
							
								<div class="request-info 03">
									<div class="request-info-head">
										<div class="request-stages">
											'.$arr['tr'].'
											'.$code_shleyf1.'
											{ASSETS}
										</div>
										<div class="request-actions">
											<p class="request-status">
												<span class="status-category">
												'.mb_strimwidth($m['categories'], 0, 21, "...", 'utf-8').'<span class="bttip">Категория: '.$m['categories'].'</span>
												</span>
											</p>
											'.$notification.'
											<div class="status-bar">
												'.$button_edit.'
												'.$form_buy_sell.'
												<button class="convert">
													4<img src="/image/status-mail.svg" alt="" class="status-request">
												</button>
											</div>
											<div class="request-actions__info">
												<span class="status-condition">
													'.$m['status_buy2'].'
													<div class="request-actions__info-data">
														<span class="status-when">'.$m['ndata_insert'].'</span>
													</div>
												</span>
												'.$button.'
											</div>
										</div>
									</div>
									<div class="buy-item__bottom">
										<div>'.$urgency.'</div>
										<div class="buy-item__bottom-right">
											'.$comments_company.'
											<div>
												'.$company.'
												'.$responsible.'
												'.$ico_responsible.'
											</div>
										</div>
									</div>
								</div>
							</div>
							
							<div id="tr_'.$m['id'].'" class="request-hidden">
									
							</div>
						</div>
					';

        }


        return $tr;
    }


    // Html представление табличной части "Заявки" (Мои заявки) из CACHE
    function TrMyBuyCache($p = array())
    {

        $bs = new HtmlBuySell();

        $tr = $ico_responsible = $responsible = $company = $kol_status = '';

        $p['flag'] = isset($p['flag']) ? $p['flag'] : '';
        $p['group'] = isset($p['group']) ? $p['group'] : '';
        $p['flag_group_id'] = isset($p['flag_group_id']) ? $p['flag_group_id'] : '';

        $m = (isset($p['m']) && !empty($p['m'])) ? $p['m'] : reqMyBuySellCache(array('id' => $p['buy_sell_id']/*,'company_id'=> COMPANY_ID*/));


        if ($p['group'] && !$p['flag_group_id'] && $m['kol_group'] > 1) {
            if ($p['group'] == 'group_assets') {
                $pole_group_id = 'assets_id';
            } elseif ($p['group'] == 'group_responsible') {
                $pole_group_id = 'responsible_id';
            } elseif ($p['group'] == 'group_comments_company') {
                $pole_group_id = 'comments_company';
            }

            $button = $this->Input(array(	'type' => 'button',
										'id' => 'view_group'.$m['id'],
										'class' => 'change-btn view_group',
										'value' => 'Развернуть ('.$m['kol_group'].')',
										'data' => array('id' => $m['id'],
														'group' => $p['group'],
														'group_id' => $m[$pole_group_id])
									)
								).'
					'.$this->Input(array(	'type' 	=> 'button',
										'id' 	=> 'close_group'.$m['id'],
										'class' => 'change-btn close_group',
										'value' => 'Свернуть',
										'dopol' => 'style="display:none;"',
										'data' 	=> array('id' => $m['id'])
				)
			);
        } else {
            $button = $bs->ActionBuySell(array('row' => $m));
        }

        $comments_company = ($m['comments_company'] && PRO_MODE) ? '	<span class="data-time-type">'.$m['comments_company'].'</span>' : '';


        if ($m['status_buy_sell_id'] >= 10) {
            $company = '<a href="/company-profile/'.$m['company_id2'].'" target="_blank">'.$m['company2'].'</a>';
            $responsible = ($m['responsible']) ? '<br/><span class="user-name">'.$m['responsible'].'</span>' : '';
        } else {

            if ($m['company_id'] == COMPANY_ID) {// если своя компания, то показываем ответственного
                $company = $m['responsible'];
            } else {
                $company = '<a href="/company-profile/'.$m['company_id'].'" target="_blank">'.$m['company'].'</a>';
            }

        }

        if (PRAVA_5) {// Заказчик (не видит компании и цены)
            $company = '';
        }

        // иконка ответственный
        if ($m['responsible_id'] && ($m['responsible_id'] <> LOGIN_ID)) {
            $ico_responsible = '<span class="userImgCnt"><img src="/image/user-img.png" alt="" class="user-img"></span>';
        }

        // количество купленных
        if ($m['kol_status11'] > 0) {// количество купленных
            $kol_status = '&nbsp;<span style="color:#008000;" title="куплено">('.$this->nf($m['kol_status11']).')</span>';
        }

        $day_noactive = '';
        // дней осталось для опубликованные/активные
        if ($m['data_status_buy_sell_23'] && ($m['status_buy_sell_id'] == 2 || $m['status_buy_sell_id'] == 3)) {
            $str_day_noactive = $this->format_by_count($m['day_noactive'], 'день', 'дня', 'дней');
            $day_noactive = '	<span class="request-days">
												<span class="whenOff">'.$m['day_noactive'].' '.$str_day_noactive.'</span>
												<span class="request-days-line"><span class="days-before"></span></span>
											</span>';
        }

        $assets = '';
        if ($m['assets_id']) {// актив
            $ra = reqAutocompleteAssets(array('buy_sell_id' => $m['assets_id']));
            $assets = $ra['attribute_value'];
        }
        /*
		$pos1 = strpos($m['cache_2'], '<div class="buy-item-main-right__left-cost">');

		$newstring = $m['cache_2'];
		$pos2 = strpos($newstring, '</div>', $pos1); // $pos = 7, not 0
		*/

        // Удаляем  цену (во ./views/buy_sell.php script который затерает)
        if (PRAVA_5) {
            $m['cache_2'] = str_replace('<div class="buy-item-main-right__left-cost"', '<div class="buy-item-main-right__left-cost delete_html_teg"', $m['cache_2']);
        }


        $m['cache_2'] = str_replace('{ACTION_BUY_SELL}', $button, $m['cache_2']);
        $m['cache_2'] = str_replace('{ICO_RESPONSIBLE}', $ico_responsible, $m['cache_2']);
        $m['cache_2'] = str_replace('{RESPONSIBLE}', $responsible, $m['cache_2']);
        $m['cache_2'] = str_replace('{COMPANY}', $company, $m['cache_2']);
        $m['cache_2'] = str_replace('{COMMENTS_COMPANY}', $comments_company, $m['cache_2']);
        $m['cache_2'] = str_replace('{KOL_VIEWS}', $m['kol_views'], $m['cache_2']);
        $m['cache_2'] = str_replace('{KOL_STATUS}', $kol_status, $m['cache_2']);
        $m['cache_2'] = str_replace('{DAY_NOACTIVE}', $day_noactive, $m['cache_2']);
        $m['cache_2'] = str_replace('{ASSETS}', $assets, $m['cache_2']);


        if ($p['flag'] == 'refresh') {
            $code = $m['cache_2'];
        } else {
            $code = '<div id="div_mybs'.$m['id'].'">'.$m['cache_2'].'</div>
					<div id="tr_'.$m['id'].'" class="request-hidden">
									
					</div>
					';
        }


        return $code;
    }


    // Html представление табличной части "Объявления" (мои Объявления)
    function TrMySell($p = array())
    {

        $bs = new HtmlBuySell();

        $tr = $button = '';

        $m = $p['m'];

        $cache = isset($p['cache']) ? true : false;
        $update = isset($p['flag']) && ($p['flag'] == 'update') ? true : false;


        $r_dop = reqMyBuySell_DopParam(array('buy_sell_id' => $m['id'],
            'status_buy_sell_id' => $m['status_buy_sell_id'],
            'unit_group_id' => $m['unit_group_id']));// дополнительные параметры к записи


        $arr_six = array(1 => '', 2 => '', 3 => '', 4 => '', 5 => '', 6 => '');
        $where_six = ($m['flag_buy_sell'] == 5) ? 'nomenclature' : '';
        $r = reqBuySellAttributeSixParam(array('buy_sell_id' => $m['id'], 'categories_id' => $m['categories_id'], 'flag' => 'six', 'where' => $where_six));

        foreach ($r as $n => $mm) {
            $arr_six[$mm['sort']] = '<span data-name="'.$mm['attribute'].'">'.$mm['attribute_value'].'</span>';
        }

        $notification = ($r_dop['kol_notification']) ? '<span class="badge badge-warning badge-pill">&nbsp;</span>' : '';


        $edit = $day_noactive = '';

        $status_sell2 = ($m['status_buy_sell_id'] == 5) ? '' : $m['status_sell2'].'<br/>';

        if ($m['status_buy_sell_id'] == 1 || $m['status_buy_sell_id'] == 2) {
            $status_sell2 = '<span class="modal_history_buy_sell" data-id="'.$m['id'].'">'.$status_sell2.'</span>';
        }


        // редактировать
        //if($m['company_id']==COMPANY_ID||$m['status_buy_sell_id']==14){
        /*
				if($m['status_buy_sell_id']==1||$m['status_buy_sell_id']==2||$m['status_buy_sell_id']==3){
					$edit = '<button class="modal_buy_sell" data-id="'.$m['id'].'" data-flag_buy_sell="'.$m['flag_buy_sell'].'" data-nomenclature_id="'.$m['nomenclature_id'].'">
								<img src="/image/status-edit.svg" alt="" class="status-request">
							</button>';
				}
				*/

        if ($cache) {

            $button = '{ACTION_BUY_SELL}';
            $kol_views = '{KOL_VIEWS}';

        } else {

            if ($m['flag_buy_sell'] == 4 || $m['flag_buy_sell'] == 5 || $m['status_buy_sell_id'] == 1 || $m['status_buy_sell_id'] == 2 || $m['status_buy_sell_id'] == 3 || $m['status_buy_sell_id'] == 14 || $m['status_buy_sell_id'] == 15) {
                $button = $bs->ActionBuySell(array('row' => $m));
            }

            $kol_views = $r_dop['kol_views'];

        }

        // цвета для срочности
        switch ($m['urgency_id']) {
            case '1':
                $urgency_color = 'urgency-urgent';
                break;
            case '2':
                $urgency_color = 'urgency-week';
                break;
            case '3':
                $urgency_color = 'urgency-two-week';
                break;
            case '4':
                $urgency_color = 'urgency-month';
                break;
            case '5':
                $urgency_color = 'urgency-not-urgently';
        }

        $urgency = '<span class="data-month '.$urgency_color.'">
								'.$m['urgency'].'
								<span class="bttip" style="display: none;">Срочность</span>
							</span>';

        // АКТИВ, СКЛАД ,  Не опубликованные, Опубликованные, Активные
        if ($m['flag_buy_sell'] == 4 || $m['flag_buy_sell'] == 5 || $m['status_buy_sell_id'] == 1 || $m['status_buy_sell_id'] == 2 || $m['status_buy_sell_id'] == 3) {

            $edit = ($m['status_buy_sell_id'] <> 32 && $m['status_buy_sell_id'] <> 33) ?
                '	<button class="modal_buy_sell" data-id="'.$m['id'].'" data-flag_buy_sell="'.$m['flag_buy_sell'].'" data-nomenclature_id="'.$m['nomenclature_id'].'">
												<img src="/image/status-edit.svg" alt="" class="status-request">
											</button>' : '';


            $data_status_buy_sell_23 = ($m['data_status_buy_sell_23']) ? $m['data_status_buy_sell_23'] : '';


            // изображение
            $arr = self::getImgBuySell(array('buy_sell_id' => $m['id']));
            $img = $arr['code'];

            $noPhoto = '';
            if (!$img) $noPhoto = 'noPhoto';
            ///

            // форма оплаты
            if ($m['form_payment_id'] == 3) {
                $form_payment = '<span class="request-money"></span>';
            } else {
                if ($m['form_payment']) {
                    $form_payment = '<span class="request-nds"><span class="ndsText">'.$m['form_payment'].'</span></span>';
                } else {
                    $form_payment = '';
                }
            }
            ///

            // Срочность
            $urgency = ($m['urgency_id'] == 1) ? '<span class="data-month urgency-urgent">'.$m['urgency'].'</span>' : '';
            ///

            // Наличие
            $availability = '';
            if ($m['availability']) {
                $str = $this->format_by_count($m['availability'], 'день', 'дня', 'дней');
                $availability = $m['availability'].' '.$str;
            }
            //

            $checkbox_share = '';
            if ($m['status_buy_sell_id'] == 2 || $m['status_buy_sell_id'] == 3) {
                $checkbox_share = '<input type="checkbox" class="checkbox_share" data-id="'.$m['id'].'" style="display:none;"/>';
            }


            $m['name'] = ($m['name']) ? $m['name'] : '-';


            // количество/ед.измерения
            $amount_unit = '<span class="rAmount">'.$this->nf($m['amount']).'</span> <span class="rMeasure"> '.$m['unit'].'</span>';


            // фасовка
            $packing = '';
            if ($m['unit_group_id']) {

                if ($m['unit_id2'] && $m['amount2']) {// выбрано ШТУКИ и другая ед.измерения
                    $packing = '<span style="color:#b2afaf;">Фасовка</span><br/>'.$this->nf($m['amount1']).''.$m['unit1'].'/'.$this->nf($m['amount2']).''.$m['unit2'];

                    $amount_unit = '';
                } elseif ($m['unit_id1'] && !$m['unit_id2'] && ($m['unit_id'] <> $m['unit_id1'])) {// выбрано НЕ штуки, а другая ед.измерения отличная от "по умолчанию" у категории

                    $t_amount = ($m['status_buy_sell_id'] == 11) ? $m['amount_buy'] : $m['amount1'];

                    $amount_unit = $this->nf($t_amount).''.$m['unit1'];

                }
            }
            ///


            $code_status_bar = '	<div class="status-bar">
											'.$edit.'
											<button class="convert">
												<img src="/image/status-mail.png" alt="Отправить сообщение (Склад)" class="status-request write_message_need" 
												data-need="28" 
												data-company="'.COMPANY_ID.'"
												data-id="'.$m['id'].'"
												data-url="/'.$m['url_cities'].'/'.$m['url_categories'].'/'.$m['url'].'"
												>													  
											</button>
										</div>';


            // Ответственный и Склад только для "Актив"
            $responsible = $stock = '';
            if ($m['flag_buy_sell'] == 4) {
                if ($cache) {
                    $responsible = '{RESPONSIBLE}';
                    $stock = '{STOCK}';
                } else {
                    $responsible = '	<div class="request-user">
														<span class="user-name">'.$m['responsible'].'</span>
													</div>';
                    $stock = '		<div class="request-user">
														<span class="user-name">'.$m['stock'].'</span>
												</div>';
                }

            }
            ///

            // СКЛАД
            $str_avg = $company2 = $amount_reserve = '';
            if ($m['flag_buy_sell'] == 5) {

                if (!$update) {
                    $code_status_bar = '';// скрываем (редактирование, отправка сообщений...)
                }

                // количество/ед.измерения заменяем остатком, если есть остаток
                if ($m['ostatok'] > 0) {
                    $amount_unit = '<span class="rAmount">'.$this->nf($m['ostatok']).'</span> <span class="rMeasure"> '.$m['unit'].'</span>';
                }

                if ($m['kol_stock'] > 1) {
                    $str_avg = 'средняя ';
                }

                $company2 = $m['company2'];

                if ($cache) {
                    $amount_reserve = '{AMOUNT_RESERVE}';
                } else {
                    $amount_reserve = ($m['amount_reserve']) ? ' <span style="color:#ff0000;">('.$this->nf($m['amount_reserve']).')</span>' : '';
                }

            }
            ///

            $tr .= '
								<div class="request-item item-list-5 '.$noPhoto.'">
									<div class="request-slider-wrapper">
										<div class="image-wrapper">
											<div class="inner-wrapper">
												'.$img.'
											</div>
										</div>
										<div class="slider-control"></div>
									</div>
									<div class="request-info">
										<div class="request-info-head">
											<div class="request-stages">
												<div class="request-stage">
													<div class="request-pics-wrapper">
														<div class="image-wrapper">
															<div class="inner-wrapper">
																'.$img.'
															</div>
														</div>
														<div class="slider-control"></div>
													</div>
													<div class="request-data-name 555">
														'.$checkbox_share.'
														<p>
															<a href="/'.$m['url_cities'].'/'.$m['url_categories'].'/'.$m['url'].'" target="_blank">'.$m['name'].'<span class="bttip">'.$m['name'].'</span></a><br>
															<span class="request-availability">'.$availability.'</span>
														</p>
														<span class="request-quantity">'.$amount_unit.'</span>'.$amount_reserve.'
														'.$packing.'
														<span class="data-hidden-city">'.$m['cities_name'].'</span>
														<a href="">
															<img src="/image/request-images.png" alt="" class="request-hidden-images">
														</a>
														<div class="request-data-hidden-name">
															'.$m['name'].'
														</div>
													</div>
													
													<div class="request-pricing">
														<div class="request-price">
															<span>'.$str_avg.'<span class="rpCost">'.(($this->nf($m['cost1'])) ? $this->nf($m['cost1']) : $this->nf($m['cost'])).'</span><span class="rpCurrency"> '.$m['currency'].'</span></span>
															'.$form_payment.'
														</div>
														'.$responsible.'
														'.$stock.'
														'.$company2.'
													</div>
													<div class="request-data">
														<div class="request-data-params">
															'.$arr_six[1].'
															'.$arr_six[2].'
															'.$arr_six[3].'
															'.$arr_six[4].'
															'.$arr_six[5].'
															'.$arr_six[6].'
														</div>
													</div>
													<div class="request-for-price">
														<p class="comments">
															'.$m['comments'].'
														</p>
														<span class="bttip" style="display: none;">'.$m['comments'].'</span>
													</div>
												</div>
											</div>
											<div class="request-actions">
												<p class="request-status">
													<span class="status-category">
													'.mb_strimwidth($m['categories'], 0, 21, "...", 'utf-8').'<span class="bttip">Категория: '.$m['categories'].'</span>
													</span>
													<span class="status-condition">
														'.$status_sell2.'
													</span>
													<span class="status-when">'.$data_status_buy_sell_23.'</span>
												</p>
												'.$notification.'
												'.$code_status_bar.'
												<p></p>
												'.$button.'
												
											</div>
										</div>
										<div class="request-data-place">
											'.$urgency.'
											<span class="data-city">
												'.$m['cities_name'].'
											</span>
											<div class="request-stats">
													{DAY_NOACTIVE}
													 <span class="request-views">'.$kol_views.'</span>
												</div>
										</div>
									</div>
								</div>
								  
								<div id="tr_'.$m['id'].'" class="request-hidden">

								</div>
						';

        } // Куплено, Исполнено, Возврат, Возвращено
        else {

            $company = '';

            if ($cache) {
                $company = '{COMPANY}';
            } else {
                if ($m['status_buy_sell_id'] >= 10) {
                    $company = '<a href="/company-profile/'.$m['company_id2'].'" target="_blank">'.$m['company2'].'</a>';
                } else {

                    if ($m['company_id'] == COMPANY_ID) {// если своя компания, то показываем ответственного
                        $company = $m['responsible'];
                    } else {
                        $company = '<a href="/company-profile/'.$m['company_id'].'" target="_blank">'.$m['company'].'</a>';
                    }

                }

                if (PRAVA_5) {// Заказчик (не видит компании и цены)
                    $company = '';
                }

            }

            $arr = self::TrMyBuySellShleif(array('buy_sell_id' => $m['id'], 'i' => 1));

            $tr .= '
								<div class="request-item item-list-xxx buy-item_3 buy-item_3-clone">
									<div class="request-slider-wrapper d-none">
										<div class="image-wrapper">
											<div class="inner-wrapper">
											</div>
										</div>
										<div class="slider-control">
										</div>
									</div>
								
									<div class="request-info">
										<div class="request-info-head">
											<div class="request-stages">
												'.$arr['tr'].'
											</div>
											<div class="request-actions">
												<p class="request-status">
													<span class="status-category">
													'.mb_strimwidth($m['categories'], 0, 21, "...", 'utf-8').'<span class="bttip">Категория: '.$m['categories'].'</span>
													</span>
													<span class="status-condition">
														'.$m['status_buy2'].'
													</span>
													<span class="status-when">'.$m['ndata_insert'].'</span>
												</p>
												'.$notification.'
												<div class="status-bar">
													'.$edit.'
													<button class="convert">
														5<img src="/image/status-mail.svg" alt="" class="status-request">
													</button>
												</div>
												<p></p>
												'.$button.'
											</div>
										</div>
										<div class="buy-item__bottom">
											<div>'.$urgency.'</div>
											<div class="buy-item__bottom-right">
												<div>
													'.$company.'
												</div>
											</div>
										</div>
									</div>
								</div>
								
								<div id="tr_'.$m['id'].'" class="request-hidden">
										
								</div>
						';

        }


        return $tr;
    }


    // Html представление табличной части "Объявление" (Мои объявления) из CACHE
    function TrMySellCache($p = array())
    {

        $bs = new HtmlBuySell();

        $tr = $button = $company = '';

        $p['flag'] = isset($p['flag']) ? $p['flag'] : '';

        $m = isset($p['m']) ? $p['m'] : reqMyBuySellCache(array('id' => $p['buy_sell_id'], 'company_id' => COMPANY_ID));


        if ($m['status_buy_sell_id'] == 1 || $m['status_buy_sell_id'] == 2 || $m['status_buy_sell_id'] == 3 || $m['status_buy_sell_id'] == 14 || $m['status_buy_sell_id'] == 15) {
            $button = $bs->ActionBuySell(array('row' => $m));
        }


        if ($m['status_buy_sell_id'] >= 10) {
            $company = '<a href="/company-profile/'.$m['company_id2'].'" target="_blank">'.$m['company2'].'</a>';
        } else {

            if ($m['company_id'] == COMPANY_ID) {// если своя компания, то показываем ответственного
                $company = $m['responsible'];
            } else {
                $company = '<a href="/company-profile/'.$m['company_id'].'" target="_blank">'.$m['company'].'</a>';
            }

        }

        if (PRAVA_5) {// Заказчик (не видит компании и цены)
            $company = '';
        }

        $day_noactive = '';
        if ($m['data_status_buy_sell_23']) {
            $str_day_noactive = $this->format_by_count($m['day_noactive'], 'день', 'дня', 'дней');
            $day_noactive = '	<span class="request-days">
												<span class="whenOff">'.$m['day_noactive'].' '.$str_day_noactive.'</span>
												<span class="request-days-line"><span class="days-before"></span></span>
											</span>';
        }


        $m['cache_1'] = str_replace('{ACTION_BUY_SELL}', $button, $m['cache_1']);
        $m['cache_1'] = str_replace('{COMPANY}', $company, $m['cache_1']);
        $m['cache_1'] = str_replace('{KOL_VIEWS}', $m['kol_views'], $m['cache_1']);
        $m['cache_1'] = str_replace('{DAY_NOACTIVE}', $day_noactive, $m['cache_1']);

        if ($p['flag'] == 'refresh') {
            $code = $m['cache_1'];
        } else {
            $code = '<div id="div_mybs'.$m['id'].'">'.$m['cache_1'].'</div>';
        }

        return $code;
    }


    // Html представление табличной части "Мои Заявки или Мои Объявление" из CACHE
    function TrMyBuySellCache($p = array())
    {
        $code = '';
        if ($p['flag_buy_sell'] == 2) {
            $code = self::TrMyBuyCache(array('buy_sell_id' => $p['buy_sell_id'], 'flag' => 'refresh'));
        }
        if ($p['flag_buy_sell'] == 1) {
            $code = self::TrMySellCache(array('buy_sell_id' => $p['buy_sell_id'], 'flag' => 'refresh'));
        }

        return $code;
    }

    // Следующие строки при прокрутки для Заявок/Объявлений
    function NextTrMyBuySell($p = array())
    {

        $p['group'] = isset($p['group']) ? $p['group'] : '';
        $p['group_id'] = isset($p['group_id']) ? $p['group_id'] : '';
        $p['flag_group_id'] = isset($p['flag_group_id']) ? $p['flag_group_id'] : '';


        if ($p['flag_buy_sell'] == 2) {
            $func = 'TrMyBuyCache';
            // проверяем это сотрудник или владелец компании
            $rp = reqMyBuySell_ProverkaInvite();
            $flag_interests_invite = (!empty($rp)) ? true : false;
            ///
            $row = reqMyBuySellCache(array(	'company_id' 			=> COMPANY_ID,
											'flag_buy_sell' 		=> $p['flag_buy_sell'],
											'status_buy_sell_id'	=> $p['status_buy_sell_id'],
											'active' 				=> 1,
											'sbs_flag' 				=> 1,
											'start_limit' 			=> $p['start_limit'],
											'categories_id' 		=> $p['categories_id'],
											'cities_id' 			=> $p['cities_id'],
											'value' 				=> $p['value'],
											'flag_interests_invite' => $flag_interests_invite,
											'group' 				=> $p['group'],
											'flag_group_id' 		=> $p['flag_group_id'],
											'group_id' 				=> $p['group_id']
										));
        } else {
            $func = 'TrMySellCache';
            $row = reqMyBuySellCache(array(	'flag' 					=> 'flag_my_sell',
											'status_buy_sell_id' 	=> $p['status_buy_sell_id'],
											'active' 				=> 1,
											'sbs_flag' 				=> 1,
											'start_limit' 			=> $p['start_limit']));
        }

        $tr = '';
        foreach ($row as $i => $m) {

            $tr .= self::$func(array('m' => $m,
                'group' => $p['group'],
                'group_id' => $p['group_id'],
                'flag_group_id' => $p['flag_group_id']));

        }

        $code = ($tr) ? $tr : '';

        return $code;
    }

    // Сводные цифры по статусам заявки
    function CountStatusBuySellByNomenclature($p = array())
    {

        $in = fieldIn($p, array('flag', 'nomenclature_id'));

        $code = '';

        if ($in['nomenclature_id'] > 0) {

            $row = reqCountStatusBuySellByNomenclature(array('nomenclature_id' => $in['nomenclature_id']));

            $tr = '';
            foreach ($row as $i => $m) {
                if ($m['kol']) {
                    $code = '';
                    //vecho($m);
                    //$arr[ $m['id'] ] = array($m['status_bs_count'].' - ',$m['kol']);
                    if ($m['id'] == 31) {// на складе
                        $r = reqStockByNomenclature(array('nomenclature_id' => $in['nomenclature_id']));
                        foreach ($r as $ii => $mm) {
                            $code .= '<div>'.$this->nf($mm['amount']).' '.$mm['unit'].' - '.$mm['stock'].'</div>';
                        }
                    } else {// остальные статусы
                        $r = reqCompanyStatusBuySellByNomenclature(array('nomenclature_id' 		=> $in['nomenclature_id'],
																		'status_buy_sell_id' 	=> $m['id']));
                        foreach ($r as $ii => $mm) {
                            $code .= '<div>'.$mm['company'].' - '.$mm['attribute'].' - '.$this->nf($mm['amount']).' '.$mm['unit'].' - '.$mm['cost'].' - '.$mm['ndata_insert'].'</div>';
                        }
                    }

                    $arr[$m['id']] = array($m['status_bs_count'].' - ', $m['kol'], $code);

                } else {
                    $arr[$m['id']] = array('', '', '');
                }
            }

            $code = '
						<div class="modal-status">
							<div class="modal-status__left">
								<div class="modal-status__left-item">
									'.$arr[2][0].' <span class="modal-status__left-item__quantity">'.$arr[2][1].'</span>
									<span class="bttip" style="display: none;">
										'.$arr[2][2].'
									</span>
								</div>
								<div class="modal-status__left-item">
									'.$arr[3][0].' <span class="modal-status__left-item__quantity">'.$arr[3][1].'</span>
									<span class="bttip" style="display: none;">
										'.$arr[3][2].'
									</span>
								</div>
								<div class="modal-status__left-item">
									'.$arr[11][0].' <span class="modal-status__left-item__quantity">'.$arr[11][1].'</span>
									<span class="bttip" style="display: none;">
										'.$arr[11][2].'
									</span>
								</div>
							</div>
							<div class="modal-status__right">
								<div class="modal-status__right-item">
									'.$arr[12][0].' <span class="modal-status__right-item__quantity">'.$arr[12][1].'</span>
									<span class="bttip" style="display: none;">
										'.$arr[12][2].'
									</span>
								</div>
								<div class="modal-status__right-item">
									'.$arr[14][0].' <span class="modal-status__right-item__quantity">'.$arr[14][1].'</span>
									<span class="bttip" style="display: none;">
										'.$arr[14][2].'
									</span>
								</div>
								<div class="modal-status__right-item">
									'.$arr[15][0].' <span class="modal-status__right-item__quantity">'.$arr[15][1].'</span>
									<span class="bttip" style="display: none;">
										'.$arr[15][2].'
									</span>
								</div>
							</div>
							<div class="modal-status__right" style="margin-left:30px;">
								<div class="modal-status__right-item">
									'.$arr[31][0].' <span class="modal-status__right-item__quantity">'.$arr[31][1].'</span>
									<span class="bttip" style="display: none;">
										'.$arr[31][2].'
									</span>
								</div>
							</div>
						</div>';

        }

        return $code;
    }


    // Html представление табличной части "Чужие Заявки"
    function TrPageBuy($p = array())
    {

        $bs = new HtmlBuySell();

        $in = fieldIn($p, array('where'));


        $tr = $ico_responsible = '';


        $m = $p['m'];
        $row_share = isset($p['row_share']) ? $p['row_share'] : array('share_url' => '');
        $row_np = isset($p['row_np']) ? $p['row_np'] : array('notification_param_id_10' => '', 'notification_param_id_11' => '');

        $arr_six = array(1 => '', 2 => '', 3 => '', 4 => '', 5 => '', 6 => '');
        $r = reqBuySellAttributeSixParam(array('buy_sell_id' => $m['id'], 'categories_id' => $m['categories_id'], 'flag' => 'six'));
        foreach ($r as $n => $mm) {
            $arr_six[$mm['sort']] = '<span data-name="'.$mm['attribute'].'">
												'.$mm['attribute_value'].'
												<span class="bttip" style="display: none;">'.$mm['attribute'].': '.$mm['attribute_value'].'</span>
											</span>';
        }

        // Дать предложение
        $form_buy_sell = $form_buy_sell_hidden = '';
        if ((PRAVA_2 || PRAVA_3) && (($m['company_id'] <> COMPANY_ID) || $row_share['share_url'])) {
            $form_buy_sell = '	
									<div class="btn-group">
										'.$this->Input(array('type' => 'button',
															'id' => 'button_form_buy_sell'.$m['id'],
															'class' => 'btn btn-primary btn-sm form_buy_sell',
															'value' => 'Дать предложение',
															'data' => array('id' => $m['id'],
																			'categories_id' => $m['categories_id'],
																			'flag' => 'buy',
																			'status' => 10,
																			'share_url' => $row_share['share_url'])
                    )
                ).'
										<button type="button" class="btn btn-sm btn-primary dropdown-toggle dropdown-toggle-split" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
											<span class="sr-only"></span>
										</button>
										<div class="dropdown-menu">
											<a id="" class="dropdown-item" title="">Что здесь</a>
											<a id="" class="dropdown-item" title="">Класс задать?</a>
										</div>
									</div>';
            $form_buy_sell_hidden = $this->Input(array('type' => 'button',
                    'class' => 'change-btn form_buy_sell_hidden',
                    'value' => 'Свернуть',
                    'data' => array('id' => $m['id'])
                )
            );
        }

        $notification = '';
        // выбрано "о новых срочных заявках"
        if ($m['flag_new'] && $row_np['notification_param_id_10'] == 3 && $m['urgency_id'] == 1 && (!$row_np['notification_param_id_11'] || $row_np['notification_param_id_11'] == 1)) {

            $notification = '<div><span class="badge badge-warning badge-pill">&nbsp;</span></div>';

        } // выбрано "о новых заявках"
        elseif ($m['flag_new'] && $row_np['notification_param_id_10'] <> 3 && (!$row_np['notification_param_id_11'] || $row_np['notification_param_id_11'] == 1)) {

            $notification = '<div><span class="badge badge-warning badge-pill">&nbsp;</span></div>';

        }


        $str_day_noactive = $this->format_by_count($m['day_noactive'], 'день', 'дня', 'дней');
        $day_noactive = '	<span class="request-days">
							<span>'.$m['day_noactive'].' '.$str_day_noactive.'</span>
							<span class="request-days-line"></span>
						</span>';


        // количество купленных
        $kol_status = '';
        if ($m['kol_status11'] > 0) {
            $kol_status = '&nbsp;<span class="request-quantity__bought" title="куплено">('.$this->nf($m['kol_status11']).')</span>';
        }


        // изображение
        $arr = self::getImgBuySell(array('buy_sell_id' => $m['id']));
        $img = $arr['code'];
        ///

        if ($img == '') {
            $noPhoto = ' no-photo';
        } else {
            $noPhoto = '';
        }

        $m['name'] = ($m['name']) ? $m['name'] : '-';

        switch ($m['urgency_id']) {
            case '1':
                $urgency_color = 'urgency-urgent';
                break;
            case '2':
                $urgency_color = 'urgency-week';
                break;
            case '3':
                $urgency_color = 'urgency-two-week';
                break;
            case '4':
                $urgency_color = 'urgency-month';
                break;
            case '5':
                $urgency_color = 'urgency-not-urgently';
        }

        $url = 'href="/'.$m['url_cities'].'/'.$m['url_categories'].'/'.$m['url'].'"';

        if ($m['status_buy_sell_id'] == 2 && $in['where'] == 'company_profile') {
            $url = 'class="get_url_buy_sell_one" data-id="'.$m['id'].'"';
        }


        $tr .= '
				<div class="container">
					<div class="request-item buy-item">
						<div class="request-info item-list-6 '.$noPhoto.'">
							<div class="request-slider-wrapper">
								<div class="image-wrapper">
									<div class="inner-wrapper">
										'.$img.'
									</div>
								</div>
								<div class="slider-control"></div>
							</div>
							<div class="request-info-content">
								<div class="request-info-head">
									<div class="request-stages">
										<div class="request-stage">
											<div class="request-data-name 666">
												<p>
													<a '.$url.' target="_blank">
														'.$m['name'].'
														<span class="bttip" style="display: none;">'.$m['name'].'</span>
													</a>
												</p>
												<span class="request-quantity">
													'.$this->nf($m['amount']).' '.$m['unit'].''.$kol_status.'
													<span class="bttip" style="display: none;">Количество</span>
												</span>
											</div>
											<div class="request-data">
												<div class="request-data-params">
													'.$arr_six[1].'
													'.$arr_six[2].'
													'.$arr_six[3].'
													'.$arr_six[4].'
													'.$arr_six[5].'
													'.$arr_six[6].'
												</div>
											</div>
											<div class="request-for-price">
												<p class="comments">
													'.$m['comments'].'
												</p>
												<span class="bttip" style="display: none;">'.$m['comments'].'</span>
											</div>
										</div>
									</div>
									<div class="request-actions">
										<div class="status-bar">
											<button class="status-bar__convert">
												<img src="/image/status-mail.png" alt="Отправить сообщение (Чужие заявки)" class="status-request write_message_need" 
													data-need="25" 
													data-company="'.$m['company_id'].'"
													data-id="'.$m['id'].'"
													data-url="/'.$m['url_cities'].'/'.$m['url_categories'].'/'.$m['url'].'"
												>
												<span class="bttip" style="display: none;">Нажмите, чтобы отправить сообщение</span>
											</button>
										</div>
										<div class="btn-action" id="div_form_buy_sell'.$m['id'].'">'.$form_buy_sell.'</div>
										<div class="btn-action" id="div_form_buy_sell_hidden'.$m['id'].'" style="display:none;">'.$form_buy_sell_hidden.'</div>
									</div>
								</div>
								<div class="request-data-place">
									<p>
										<span class="data-month '.$urgency_color.'">
											'.$m['urgency'].'
											<span class="bttip" style="display: none;">Срочность</span>
										</span>
										<span class="data-city">
											'.$m['cities_name'].'
											<span class="bttip" style="display: none;">Куда / Откуда</span>
										</span>
										<span class="status-when">
											'.$m['data_status_buy_sell_23'].'
											<span class="bttip" style="display: none;">Дата и время присвоение статуса</span>
										</span>
									</p>
									<p class="request-status">
										<span class="user-name">
											<a href="/company-profile/'.$m['company_id'].'" target="_blank">'.$m['company'].'</a>
											<span class="bttip" style="display: none;">Заказчик</span>
										</span>
										<span class="status-category">
											'.$m['categories'].'
											<span class="bttip" style="display: none;">Категория</span>
										</span>
									</p>
								</div>
							</div>
						</div>
					</div>
					  
					<div id="tr_'.$m['id'].'" class="request-hidden">
							
					</div>
				</div>
					
			';


        return $tr;
    }


    // Следующие строки при прокрутки для Чужик Заявки
    function NextTrPageBuy($p = array())
    {

        $row_share = array('share_url' => '');
        if ($p['share_url']) {// проверяем
            $row_share = reqBuySellShare(array('share_url' => $p['share_url']));
        }

        $row_np = reqNotificationParamId_1011();

        $row = reqBuySell_pageBuy(array('start_limit' 			=> $p['start_limit'],
										//'parent_id'			=> 0,
										'flag_interests' 		=> $p['flag_interests'],
										'share_url' 			=> $row_share['share_url'],
										'categories_id' 		=> $p['categories_id'],
										'cities_id' 			=> $p['cities_id'],
										'value' 				=> $p['value'],
										'flag_search' 			=> $p['flag_search'],
										'company_id' 			=> $p['company_id'],
										'flag_companyprofile' 	=> $p['flag_companyprofile']));


        $tr = '';
        foreach ($row as $i => $m) {

            $tr .= self::TrPageBuy(array('m' => $m, 'row_share' => $row_share, 'row_np' => $row_np));

        }

        $code = ($tr) ? $tr : '';

        return $code;
    }


    // Следующие строки при прокрутки для "Подписки"
    function TrPageSubscrProfile($p = array())
    {

        $views = $p['views'];
        $m = $p['m'];

        if ($m['flag_account'] == 1) {//  Профиль аккаунта (физ.лицо)
            $company = '<a href="/company-profile/'.$m['id'].'" target="_blank">'.$m['company'].'</a>';;
        } else {// Компания
            $company = $m['legal_entity'].' '.'<a href="/company-profile/'.$m['id'].'" target="_blank">'.$m['company'].'</a>';;
        }

        $rcc = reqCompanyCategories(array('flag' => 'group_categories', 'company_id' => $m['id']));

        $button = ($m['id'] <> COMPANY_ID) ? $this->ButtonSubscriptions(array('flag' => $m['flag_subscriptions'], 'company_id_out' => $m['id'], 'flag_etp' => $m['flag_etp'])) : '';

        $kol_notification = ($views == 'me' && $m['kol_notification']) ? '<div><span class="badge badge-warning badge-pill">&nbsp;</span></div>' : '';

        // класс для online subs-online
        $cl_online = (1 == 2) ? 'subs-online' : '';

        $tr = '	<div class="subs-item">
						<div class="subs-icon">
							<img src="'.$m['avatar'].'" alt="" class="rounded-circle" height="60">
						</div>
						<div class="subs-info">
							'.$kol_notification.'
							<div class="subs-name">
								'.$company.'
							</div>
							<div class="subs-cat">
								'.$rcc['categories'].'
							</div>
							<div class="subs-place">
								'.$m['cities_name'].'
							</div>
										<div class="status-bar" style="position:relative;top:5px;right:0px;opacity:1;">
											<button class="status-bar__convert">
												<img src="/image/status-mail.png" alt="Отправить сообщение (Подписки)" class="status-request write_message_need" 
													data-need="22" 
													data-company="'.COMPANY_ID.'"
													data-id="'.$m['id'].'"
													data-url="/company-profile/'.$m['id'].'"
												>
												<span class="bttip" style="display: none;">Нажмите, чтобы отправить сообщение</span>
											</button>
										</div>
						</div>
						<div>
							'.$button.'
						</div>
					</div>
			';

        return $tr;
    }

    // Следующие строки при прокрутки для "Подписки"
    function NextTrPageSubscrProfile($p = array())
    {

        $row = $this->rowCompanySubscriptions(array('start_limit' => $p['start_limit'],
            'views' => $p['views'],
            'value' => $p['value']));

        $tr = '';
        foreach ($row as $i => $m) {

            $tr .= self::TrPageSubscrProfile(array('m' => $m, 'views' => $p['views']));

        }

        $code = ($tr) ? $tr : '';

        return $code;

    }


    // меню о qrq и ...
    function SubmenuHelp($p = array())
    {

        $in = fieldIn($p, array('page'));

        $cl_faq = $cl_rules = $cl_about = $cl_confidentiality = $cl_sitemap = '';

        $cl_active = 'submenu-item-active';

        if ($in['page'] == 'rules') {
            $cl_rules = $cl_active;
        } elseif ($in['page'] == 'faq') {
            $cl_faq = $cl_active;
        } elseif ($in['page'] == 'about') {
            $cl_about = $cl_active;
        } elseif ($in['page'] == 'sitemap') {
            $cl_sitemap = $cl_active;
        } elseif ($in['page'] == 'confidentiality') {
            $cl_confidentiality = $cl_active;
        }

        $code = '
			<div class="submenu-block">
				<div class="container">
					<div class="submenu-items">
						<a href="/faq" class="'.$cl_faq.'">Частые вопросы</a>
						<!--<a href="">Мои вопросы</a>
						<a href="">Предложения</a>
						<a href="">Отзывы</a>-->
						<a href="/about" class="'.$cl_about.'">О QRQ</a>
						<a href="/rules" class="'.$cl_rules.'">Соглашение</a>
						<a href="/confidentiality" class="'.$cl_confidentiality.'">Конфиденциальность</a>
					</div>
				</div>
			</div>';


        return $code;
    }


    // меню в админке сторонних ресурсов
    function NavTabsAdminAmo($p = array())
    {
        $code = $active1 = $active2 = '';
        $in = fieldIn($p, array('flag'));

        if ($in['flag'] == 'qrq') {
            $active1 = 'active';
        } elseif ($in['flag'] == 'accounts') {
            $active2 = 'active';
        }

        $code = '	<ul class="nav nav-tabs">
						<li class="nav-item">
							<a href="/admin_qrq" class="nav-link '.$active1.'">Поставщики AMO</a>
						</li>
						<li class="nav-item">
							<a href="/admin_qrq/accounts" class="nav-link '.$active2.'">Аккаунты пользователей</a>
						</li>
					</ul>';

        return $code;
    }

    // меню в админке Etp
    function NavTabsAdminEtp($p = array())
    {
        $code = $active1 = $active2 = $active3 = $active4 = $active5 = '';
        $in = fieldIn($p, array('flag'));

        if ($in['flag'] == 'etp') {
            $active1 = 'active';
        } elseif ($in['flag'] == 'accounts') {
            $active2 = 'active';
        } elseif ($in['flag'] == 'errors') {
            $active3 = 'active';
        } elseif ($in['flag'] == 'errors_log') {
            $active4 = 'active';
        } elseif ($in['flag'] == 'cities') {
            $active5 = 'active';
        }

        $code = '	<ul class="nav nav-tabs">
						<li class="nav-item">
							<a href="/admin_etp" class="nav-link '.$active1.'">ЭТП</a>
						</li>
						<li class="nav-item">
							<a href="/admin_etp/accounts" class="nav-link '.$active2.'">Аккаунты пользователей</a>
						</li>
						<li class="nav-item">
							<a href="/admin_etp/errors" class="nav-link '.$active3.'">Ошибки</a>
						</li>
						<li class="nav-item">
							<a href="/admin_etp/errors_log" class="nav-link '.$active4.'">Ошибки Лог</a>
						</li>
						<li class="nav-item">
							<a href="/admin_etp/cities" class="nav-link '.$active5.'">Города</a>
						</li>
					</ul>';

        return $code;
    }


    // поле КОЛИЧЕСТВО логика проверки фасовки
    function htmlUnitsByPacking($p = array())
    {

        $in = fieldIn($p, array('amount', 'status', 'flag'));

        $flag_packing = false;

        $row_bs = $tmp_row_bs = $p['row_bs'];
        $row_categories = $p['row_categories'];

        if ($in['flag'] == 'last_form' || $in['flag'] == 'change_categories') {// предзаполение не нужно этих полей
            $row_bs['amount'] = '';
            $row_bs['amount1'] = '';
            $row_bs['amount2'] = '';
        }
        //vecho($row_bs);
        if ($row_categories['unit_group_id'] && ($in['status'] == 10 || $in['status'] == 1 || $in['status'] == 2 || $in['status'] == 3 || $in['status'] == 4)) { // указана у категории группа фасовки
            $flag_packing = true;

            $div_amount_unit2_st_dn = 'display:none;';// по умолчанию
            if (!empty($tmp_row_bs)) {// редактируем запись
                if ($row_bs['unit_id1'] == 1) {
                    $div_amount_unit2_st_dn = '';
                }
            } else {
                $row_bs = array('amount1' => '', 'unit_id1' => '', 'amount2' => '', 'unit_id2' => '');
            }


            $code = '
						<div class="offer-form__item-couple">
							<div class="form-group offer-form__item">
							
								'.$this->Input(array('type' => 'text',
													'name' => 'amount1',
													'class' => 'form-control require-input vmask',
													'value' => $row_bs['amount1'],
													'placeholder' => 'Ед. измерения',
													'dopol' => 'autocomplete="off"',//required data-bv-notempty-message="Введите" 
													'data' => array('unit_id' => $row_bs['unit_id1'])
												)
											).'
								<!--
								<div id="div_krat_amount1" style="display:none;">Кратность должна быть до 0,01</div>
								-->
							</div>
							<div class="form-group offer-form__item">
								'.$this->SelectUnitGropByCategories(array('unit_group_id' => $row_categories['unit_group_id'], 'unit_id1' => $row_bs['unit_id1'])).'
							</div>
						</div>
						<div id="div_amount_unit2" class="form-group offer-form__item offer-form__item-couple" style="'.$div_amount_unit2_st_dn.'">
							<div class="form-group offer-form__item">
								'.$this->Input(array(	'type'		=> 'text',
													'name' 		=> 'amount2',
													'class' 	=> 'form-control require-input vmask',
													'value' 	=> $row_bs['amount2'],
													'placeholder' => 'Группа ед.изм.(фасовка)',
													'dopol' 	=> 'autocomplete="off"'//required data-bv-notempty-message="Введите"
												)
											).'
									<!--
									<div id="div_krat_amount2" style="display:none;">Кратность должна быть до 0,01</div>
									-->
							</div>
							<div class="form-group offer-form__item">
									'.$this->Select(array('id' 	=> 'unit_id2',
														'class' => 'form-control select2',
														'value' => $row_bs['unit_id2'],
														'dopol' => 'required data-bv-notempty-message=" Выберите ед.изм."'
													),
													array(	'func'	=> 'reqSlovUnit',
															'param' => array('unit_group_id' => $row_categories['unit_group_id']),
															'option'=> array('id' => 'id', 'name' => 'unit')
													)
												).'
							</div>
						</div>
						';
        } elseif ($row_categories['unit_group_id'] && ($in['status'] == 12 || $in['status'] == 14)) {


            $min = ($row_bs['unit_id1'] == 1) ? ' min="1" ' : '';

            $code = '<div class="form-group offer-form__item">
							'.$this->Input(array('type' => 'hidden',
												'name' => 'unit_id1',
												'value' => $row_bs['unit_id1']
											)
										).'	
							'.$this->Input(array('type' 		=> 'text',
												'name'		=> 'amount1',
												'class' 	=> 'form-control require-input vmask',
												'value' 	=> '',
												'placeholder' => $row_bs['unit1'],
												'dopol' 	=> ' '.$min.'  list="amount"  autocomplete="off" ',//required data-bv-notempty-message="Введите"
												'data' 		=> array('unit_id' => $row_bs['unit_id1'])
											)
										).'
							<datalist id="amount">
								<option value="'.$row_bs['amount'].'" />
							</datalist>
						</div>';

        } else {
            $row_bs['amount'] = isset($row_bs['amount']) ? $row_bs['amount'] : 1;

            if (isset($row_bs['unit'])) {
                $unit_id = $row_bs['unit_id'];
            } else {
                $row_bs['unit'] = $row_categories['unit'];
                $unit_id = $row_categories['unit_id'];
            }


            if ($row_categories['unit_group_id']) {
                $placeholder = $row_bs['unit1'];
                $unit_id = $row_bs['unit_id1'];
            } else {
                $placeholder = $row_bs['unit'];
            }


            $code = '<div class="form-group offer-form__item">
							'.$this->Input(array('type' 			=> 'text',
												'name' 			=> 'amount',
												'class' 		=> 'form-control require-input vmask',
												'value' 		=> ($row_bs['amount']>0)? $row_bs['amount'] : '',
												'placeholder' 	=> $placeholder,
												'dopol' 		=> 'autocomplete="off" ',//required data-bv-notempty-message="Введите" 
												'data' 			=> array('unit_id' => $unit_id)
											)
										).'
						</div>';
        }


        return array('code' => $code, 'flag_packing' => $flag_packing);
    }


    // Следующие строки при прокрутки для "Номенклатура"
    function NextTrPageNomenclature($p = array())
    {

        $in = fieldIn($p, array('value'));

        $row = reqNomenclature(array('start_limit' => $p['start_limit'],
            'company_id' => COMPANY_ID,
            'value' => $in['value']));

        $tr = '';
        foreach ($row as $i => $m) {

            $tr .= self::TrPageNomenclature(array('m' => $m));

        }

        $code = ($tr) ? $tr : '';

        return $code;

    }

    // Следующие строки при прокрутки для "Номенклатура"
    function TrPageNomenclature($p = array())
    {

        $m = $p['m'];

        $id_elem = 'div_nomenclature'.$m['id'].'';

        $delete = ($m['flag_nomenclature_bs']) ? '' : '<span class="delete_nomenclature" style="color:#999;cursor:pointer;" title="Удалить" 
																data-id="'.$m['id'].'" data-elem="'.$id_elem.'" data-name="'.$m['name'].'">x</span>';

        $tr = '	<div class="subs-item" id="'.$id_elem.'">
						<div class="subs-info">
							<div class="subs-name">
								'.$m['name'].'
								<button class="modal_nomenclature" data-id="'.$m['id'].'">
									<img src="/image/status-edit.png" alt="" class="status-request">
								</button>
								'.$delete.'
							</div>
							<div class="subs-cat">
								'.$m['categories'].'
							</div>
						</div>
					</div>
			';

        return $tr;
    }


    // Следующие строки при прокрутки для "админка Поисковый запрос"
    function NextTrPageSearchCategories($p = array())
    {

        $row = reqSearchCategories(array('start_limit' => $p['start_limit']));

        $tr = '';
        foreach ($row as $i => $m) {

            $tr .= self::TrPageSearchCategories(array('m' => $m));

        }

        $code = ($tr) ? $tr : '';

        return $code;

    }

    // Следующие строки при прокрутки для "админка Поисковый запрос"
    function TrPageSearchCategories($p = array())
    {

        $m = $p['m'];

        $id_elem = 'div_search_categories'.$m['id'].'';

        $delete = '<span class="delete_search_categories" style="color:#999;cursor:pointer;" title="Удалить" 
													data-id="'.$m['id'].'" data-elem="'.$id_elem.'" data-name="'.$m['name'].'">x</span>';

        $tr = '	<div class="subs-item" id="'.$id_elem.'">
						<div class="subs-info">
							<div class="subs-name">
								'.$m['name'].'
								<button class="modal_search_categories" data-id="'.$m['id'].'">
									<img src="/image/status-edit.png" alt="" class="status-request">
								</button>
								'.$delete.'
							</div>
							<div class="subs-cat">
								'.$m['categories'].'
							</div>
						</div>
					</div>
			';

        return $tr;
    }


    // подгрузка Товары на складе закрепленные за номенклатурой
    function TableStock($p = array())
    {

        $in = fieldIn($p, array('nomenclature_id'));

        $row = reqMyBuySell(array('flag_buy_sell' => 5, 'nomenclature_id' => $in['nomenclature_id']));

        $tr = '';
        foreach ($row as $i => $m) {

            $tr .= self::TrMySell(array('m' => $m, 'flag' => 'update'));

        }


        return $tr;
    }

    // Меню - Сообщения
    function NavTabsMessagesFolders($p = array())
    {
        $code = $active1 = $active2 = '';
        $in = fieldIn($p, array('views', 'kol'));

        //$row_kol_my = reqCompany(array('flag'=>'chat-my','kol'=>true));
        //$row_kol_me = reqCompany(array('flag'=>'chat-me','kol'=>true));

        $views_chat = $views_open_chats = $views_arhive_chats = $views_wt_chats = '';

        if ($in['views'] == 'messages') {        // Все сообщения
            $views_chat = 'active';
        } elseif ($in['views'] == 'open-chats') {    // Открытая тема
            $views_open_chats = 'active';
        } elseif ($in['views'] == 'wt-chats') {    // Без темы
            $views_wt_chats = 'active';
        } elseif ($in['views'] == 'arhive-chats') {    // Архив
            $views_arhive_chats = 'active';
        }

        $code = '	
				<div class="request-head">
					<div class="request-checking">
						<input type="checkbox">
					</div>
					<ul class="request-menu">
						<li class="request-menu-item">
							<button>
								<a href="/chat/messages" class="nav-link '.$views_chat.'">Все сообщения</a>
							</button>
						</li>
						<!--
						<li class="request-menu-item">
							<button>
								<a href="/chat/open-chats" class="nav-link '.$views_open_chats.'">Открытая тема</a>
							</button>
						</li>
						-->
						<li class="request-menu-item">
							<button>
								<a href="/chat/wt-chats" class="nav-link '.$views_wt_chats.'">Открытая тема</a> <!-- без темы --!>
							</button>
						</li>						
						<li class="request-menu-item">
							<button>
								<a href="/chat/arhive-chats" class="nav-link '.$views_arhive_chats.'">Архив</a>
							</button>
						</li>
					</ul>
				</div>';

        return $code;
    }


    // Следующие строки при прокрутки для "Сообщения"
    function _____TrPageMessagesFolders($p = array())
    {

        $views = $p['views'];
        $m = $p['m'];
        $tr = $kol_notification = '';

        $status_on_off = '';//($m["status"] != 2) ? '<button>В архив</button>' : '<button>Открыть тему</button>';
        $status_badge = ($m["status"] != 2) ? 'badge-warning' : 'badge-secondary';

        //vecho($m);
        //vecho($rcm);

        $comp_count = count(json_decode($m['companies_id'], true));
        if ($comp_count == 2) {
            $arr_companies = json_decode($m['companies_id'], true);
            $rc = reqCompany(array('id' => $arr_companies[1]));
            //vecho($rc);
        }
        $b_comp = (!empty($rc['company'])) ? ', '.$rc['company'] : ''; //второй собеседник

        $rcm = reqChatMessages(array('folder_id' => $m['folder_id']));

        $last_message = end($rcm); //информация о последнем сообщении
        //$last_message = $rcm[count($rcm) - 1];

        $last_am = $last_message["name_rcmc"].': '.$last_message["ticket_exp"];

        //if (!empty($rcm)){


        //$kol_notification = ($views=='me'&&$m['kol_notification'])? '<div><span class="badge badge-warning badge-pill">&nbsp;</span></div>' : '';

        // класс для online subs-online
        //$cl_online = (1==2)? 'subs-online' : '';

        if (!empty($m['ava_folder'])) { // если явно проставлен логотип чата
            $avatar = $m['ava_folder'];
        } else {
            $avatar = !empty($m['ava_company']) ?
                "<img src='".$m['ava_company']."' class='rounded-circle' height='50'>" :
                "<img src='/image/profile-icon.png' class='rounded-circle' height='50'>";
        }

        if ((!empty($m['folder_name'])) && ($m['company_id'] === COMPANY_ID) && ($m['status'] != 2)) { // если явно прописана тема чата и чат создан тем кому он пренадлежит и не в архиве
            $theme = $m['folder_name'];
            $edit_theme = '	
								<div class="_status-bar ">
									<button class="_status-bar__convert edit_theme" data-id="'.$m['folder_id'].'">
										<img src="/image/status-edit.svg" alt="" class="status-request">												
									</button>
								</div>';

        } else if (!empty($m['folder_name'])) {
            $theme = $m['folder_name'];
            $edit_theme = '';
        } else {
            $theme = $m["name_rcmc"].$b_comp;
            $edit_theme = '';
        }


        $tr = '	<div class="subs-item row">
						<div class="subs-icon col-1">
							'.$avatar.'							
						</div>
						<a name="'.$m['id'].'" />
						<div class="subs-info col-11 row">
							'.$kol_notification.' 
							<div class="subs-cat col-7">
								<a href="/chat/messages/'.$m["folder_id"].'">'.$theme.'</a><br />
								<span>'.$last_am.'</span> 
							</div>
							<div class="subs-place col-3">
								'.$status_on_off.'
							</div>
							<div class="subs-place col-2">
								'.$edit_theme.'
							
								  <!-- <span class="badge '.$status_badge.' badge-pill">&nbsp;</span>  -->
								<small class="_status-bar__time">'.$last_message["t_date_full"].'</small>
							</div>							
						</div>
					</div>
			';
        //}

        return $tr;
    }

// Следующие строки при прокрутки для "Сообщения"
    function TrPageMessagesFolders($p = array())
    {

        $views = $p['views'];
        $m = $p['m'];
        $tr = $kol_notification = '';

        $status_on_off = '';//($m["status"] != 2) ? '<button>В архив</button>' : '<button>Открыть тему</button>';
        $status_badge = ($m["status"] != 2) ? 'badge-warning' : 'badge-secondary';


        $comp_count = count(json_decode($m['companies_id'], true));
        if ($comp_count == 2) {
            $arr_companies = json_decode($m['companies_id'], true);

            if (($key = array_search(COMPANY_ID, $arr_companies)) !== false) {
                unset($arr_companies[$key]);
            }
            //vecho(implode("",$arr_companies));
            $comp2 = implode("", $arr_companies); //второй собеседник (string)
            $rc2 = reqCompany(array('id' => $comp2));

            $ava_sobesednika = $rc2["avatar"];

        }
        //$b_comp = (!empty($rc['company'])) ? ', '.$rc['company'] : ''; //второй собеседник

        $rcm = reqChatMessages(array('folder_id' => $m['id']));

        $last_message = end($rcm); //информация о последнем сообщении
        //$last_message = $rcm[count($rcm) - 1];

        //$last_message["ava_company"] - аватарка последнего отправиышего сообщение в чате

        $last_am = $last_message["name_rcmc"].': '.$last_message["ticket_exp"];


        if (!empty($m['avatar'])) { // если явно проставлен логотип чата
            $avatar = "<img src='".$m['avatar']."' class='rounded-circle' height='50'>";
        } else {
            $avatar = !empty($ava_sobesednika) ?
                "<img src='".$ava_sobesednika."' class='rounded-circle' height='50'>" :
                "<img src='/image/profile-icon.png' class='rounded-circle' height='50'>";
        }

        if ((!empty($m['folder_name'])) && ($m['owner_id'] === COMPANY_ID) && ($m['status'] != 2)) { // если явно прописана тема чата и чат создан тем кому он пренадлежит и не в архиве
            $theme = $m['folder_name'];
            $edit_theme = '	
								<div class="_status-bar ">
									<button class="_status-bar__convert edit_theme" data-id="'.$m['id'].'">
										<img src="/image/status-edit.svg" alt="" class="status-request">												
									</button>
								</div>';

        } else if (!empty($m['folder_name'])) {
            $theme = $m['folder_name'];
            $edit_theme = '';
        } else {
            if (!empty($rc2)) {
                $theme = $rc2['legal_entity'].' '.$rc2["company"];
                $edit_theme = '';
            } else {
                $theme = $last_message["name_rcmc"];
                $edit_theme = '';
            }
        }

//        $buttonArchive = ($m['status'] != 2) ? '<button type="button" class="button-blue pull-right close_theme" data-fid="'.$m["id"].'">в Архив</button>' : '<button type="button" class="button-blue pull-right open_theme" data-fid="'.$m["id"].'">Открыть тему</button>';
        $buttonArchive = '';
       
        if ($m['status'] != 2 && $m['folder_name'] == '') {
            $buttonArchive = '<button type="button" class="button-blue pull-right close_chat" data-fid="'.$m["id"].'">в Архив</button>';
        } elseif ($m['status'] != 2 && ($m['folder_name'] != '' && $m['owner_id'] == COMPANY_ID)) {
            $buttonArchive = '<button type="button" class="button-blue pull-right close_theme" data-fid="'.$m["id"].'">Закрыть тему</button>';
        }elseif ($m['status'] == 2 && ($m['folder_name'] != '') && $m['owner_id'] == COMPANY_ID) {
            $buttonArchive = '<button type="button" class="button-blue pull-right open_theme" data-fid="'.$m["id"].'">Открыть тему</button>';
        }
        elseif ($m['status'] == 2 && ($m['folder_name'] == '')) {
            $buttonArchive = '<button type="button" class="button-blue pull-right open_chat" data-fid="'.$m["id"].'">Вернуть чат</button>';
        }

        $tr = '	<div class="subs-item row">
						<div class="subs-icon col-1">
							'.$avatar.'							
						</div>
						<div class="subs-info col-11 row">
							'.$kol_notification.' 
							<div class="subs-cat col-6">
								<a href="/chat/messages/'.$m["id"].'">'.$theme.'</a><br />
								<span>'.$last_am.'</span> 
							</div>
							<div class="subs-place col-2">
								'.$status_on_off.'
							</div>
							<div class="subs-place col-2">
								'.$buttonArchive.'</div>

							<div class="subs-place col-2">
								'.$edit_theme.'
							
								  <!-- <span class="badge '.$status_badge.' badge-pill">&nbsp;</span>  -->
								<small class="_status-bar__time">'.$last_message["t_date_full"].'</small>
							</div>							
						</div>
					</div>
			';
        //}

        return $tr;
    }

    // Следующие строки при прокрутки для "Папок сообщений"
    function NextTrPageMessagesFolders($p = array())
    {

        $row = $this->rowChatMessages(array('start_limit' => $p['start_limit'],
            'views' => $p['views']));

        $tr = '';
        foreach ($row as $i => $m) {

            $tr .= self::TrPageMessagesFolders(array('m' => $m, 'views' => $p['views']));

        }

        $code = ($tr) ? $tr : '';

        return $tr;

    }

    // Следующие строки при прокрутки для "Сообщения"
    function TrPageMessages($p = array())
    {

        $views = $p['views'];
        $m = $p['m'];

        $tr = $kol_notification = $cl_own = $tr_img = $tr_img_wrapper = '';
        $allowImage = array('jpg', 'jpeg', 'png', 'gif');
        $allowDoc = array('doc', 'docx', 'xls', 'xlsx', 'pdf', 'ppt', 'pptx', 'txt');


        //$status_on_off = ($m["status"] != 2) ? 'В архив': 'Открыть тему';

        $rcmf = reqChatMessagesFiles(array('message_id' => $m['id']));

        if (!empty($rcmf)) {

            foreach ($rcmf as $i => $val) {
                $ext = explode('.', $val['name'])[1];

                if (in_array($ext, $allowImage)) {
                    $tr_img .= '<div class="img-item">
					<a data-fancybox="gallery6" class="img-item-link" href="/files/messages/'.$m['company_id'].'/'.$val['name'].'">
					<img src="/files/messages/'.$m['company_id'].'/'.pathinfo($val['name'], PATHINFO_FILENAME).'-thumb.png">
					</a>						
					</div>';
                } elseif (in_array($ext, $allowDoc)) {
                    $tr_img .= '<div class="img-item">
						<a class="img-item-link" target="_blank" href="https://docs.google.com/viewer?url=https://questrequest.ru/files/messages/'.$m['company_id'].'/'.$val['name'].'">
							<img style="width:100px" src="/image/iconMessages/'.$ext.'.png">
						</a>						
					</div>';
                } else {
                    $tr_img .= '<div class="img-item">
						<a class="img-item-link" href="/files/messages/'.$m['company_id'].'/'.$val['name'].'">
							<img style="width:100px" src="/image/iconMessages/'.$ext.'.png">
						</a>						
					</div>';
                }
            }

            $tr_img_wrapper .= '<div class="img-list col-md-10" id="js-file-listM">
				'.$tr_img.'
				</div>';

        }


        $cl_own = ($m['company_id'] == COMPANY_ID) ? 'justify-content-end own' : 'justify-content-start';
        $cl_status = ($m['ticket_status'] == 1) ? ' tech' : '';

        $avatar = "<img src='".$m['ava_company']."' class='rounded-circle' height='40'>";

        /* 			if (empty($m['folder_name'])) {
					$avatar = "<img src='".$m['ava_company']."' class='rounded-circle' height='40'>";
				}
			else
				{
					$avatar = "<img src='".$m['ava_folder']."' class='rounded-circle' height='40'>";
				} */


        $_24h = 24 * 60 * 60; //24 часа
        $date_max = strtotime($m['data_insert']) + $_24h;
        $date_cur = strtotime(date("Y-m-d H:i:s"));

        //если после отправки прошло больше 24 часов - показываем полуную дату
        $date_message = ($date_cur <= $date_max) ? $m['t_time'] : $m['t_date_full'];

        if ($m['ticket_status'] == 1) {

            $tr = '	<div class="message-item row '.$cl_own.$cl_status.'">
				<div class="tech-info _col col-md-12 text-center">	

				<span>'.$m["ticket_exp"].'</span>															
				</div>
				</div>
				';

        } elseif ($m['ticket_status'] == 2) {
            $rcm = reqChatMessages(array('folder_id' => $m['chatId']));
            // // var_dump($m['chatId']);
            $mes = '';
            foreach ($rcm as $k) {
                $mes .= self::TrPageMessages(array('m' => $k, 'views' => 'messages'));
            }
            // var_dump($mes);
            $tr = '	<div class="message-item row tech '.$cl_own.$cl_status.'">

				<div class="message-info col col-md-10">
				<a name="'.$m['id'].'">
			<span>'.$m["ticket_exp"].'</span>
			<div class="tech-info _col col-md-12">	
				'.$mes.'										
				</div>		
				</div>
				</div>
				';
        } else {

            $tr = '	<div class="message-item row '.$cl_own.$cl_status.'">
				<div class="message-info col col-md-10">
				<a name="'.$m['id'].'">
				<span class="user_name">'.$m["name_rcmc"].'</span><br />
				'.$avatar.'	
				'.$kol_notification.' 
				'.$m["ticket_exp"].'
				<small class="pull-right">'.$date_message.'</small>							
				</div>						
				'.$tr_img_wrapper.'	
				</div>
				';

        }
        //}
        return $tr;
    }

    // Меню - Тикеты
    function NavTabsTicketsFolders($p = array())
    {
        $code = $active1 = $active2 = '';
        $in = fieldIn($p, array('views', 'kol', 'start_limit'));

        $views_errors = $views_pred = $views_in_works = $views_done = $views_arhiv = $views_active = $views_na_proverku = $views_vozvrat = $views_otzyv = '';
        $kol_1 = $kol_2 = $kol_4 = $kol_7 = $kol_8 = $kol_3 = $kol_5 = $kol_6 = $kol_9 = '';

        $admins = reqTicketAdmins();
        $adminsArr = explode(",", $admins['admins']);

        if (in_array(LOGIN_ID, $adminsArr)) {

            $rct = reqCountTickets();

        } else {

            $rct = reqCountTickets(array('owner_id' => COMPANY_ID));
            $rtm = reqTicketMessages(array('prava' => 0, 'owner_id' => COMPANY_ID));

        }

        //Поиск кол-ва
        $ticket_flag_errors = search($rct, 'ticket_flag', 1); //Ошибок
        $ticket_flag_pred = search($rct, 'ticket_flag', 2); //Предложений
        $ticket_flag_inworks = search($rct, 'ticket_flag', 4); //В работе
        $ticket_flag_done = search($rct, 'ticket_flag', 7); //Исполненных
        $ticket_flag_arhiv = search($rct, 'ticket_flag', 8); //Архив

        $ticket_flag_active = search($rct, 'ticket_flag', 3); //Активные
        $ticket_flag_na_proverku = search($rct, 'ticket_flag', 5); //Проверка
        $ticket_flag_vozvrat = search($rct, 'ticket_flag', 6); //Возврат
        //$ticket_flag_active = search($rct, 'status', 1); //Поиск кол-ва Активные


        /* сумма Активных

		$sumActive = array();
		$sumActive['count_flag'] = 0;
		foreach($ticket_flag_active as $i => $val){
			$sumActive['count_flag'] += $val['count_flag'];
		}
*/

        //$kol_3 = !empty($ticket_flag_active[0]) ? $sumActive['count_flag']: '';


        $kol_1 = !empty($ticket_flag_errors[0]) ? $ticket_flag_errors[0]['count_flag'] : '';
        $kol_2 = !empty($ticket_flag_pred[0]) ? $ticket_flag_pred[0]['count_flag'] : '';
        $kol_7 = !empty($ticket_flag_done[0]) ? $ticket_flag_done[0]['count_flag'] : '';
        $kol_8 = !empty($ticket_flag_arhiv[0]) ? $ticket_flag_arhiv[0]['count_flag'] : '';


        if ($in['views'] == 'errors') {        // Ошибки 1
            $views_errors = 'active';
        } elseif ($in['views'] == 'pred') {            // Предложения 2
            $views_pred = 'active';
        } elseif ($in['views'] == 'in_works') {    // В работе 4
            $views_in_works = 'active';
        } elseif ($in['views'] == 'done') {        // Исполненные 7
            $views_done = 'active';
        } elseif ($in['views'] == 'arhiv') {        // Архив 8
            $views_arhiv = 'active';

        } elseif ($in['views'] == 'active') {        // Активные 3
            $views_active = 'active';
        } elseif ($in['views'] == 'na_proverku') {    // Проверка 5
            $views_na_proverku = 'active';
        } elseif ($in['views'] == 'vozvrat') {        // Возврат 6
            $views_vozvrat = 'active';

        } elseif ($in['views'] == 'otzyv') {        // Отзывы 9
            $views_otzyv = 'active';

        }

        if (in_array(LOGIN_ID, $adminsArr)) {

            $kol_3 = !empty($ticket_flag_active[0]) ? $ticket_flag_active[0]['count_flag'] : '';
            $kol_5 = !empty($ticket_flag_na_proverku[0]) ? $ticket_flag_na_proverku[0]['count_flag'] : '';
            $kol_6 = !empty($ticket_flag_vozvrat[0]) ? $ticket_flag_vozvrat[0]['count_flag'] : '';
            $kol_4 = !empty($ticket_flag_inworks[0]) ? $ticket_flag_inworks[0]['count_flag'] : '';
            $view_active = ($kol_3 > 0) ? '
							<li class="request-menu-item">
								<button>
									<a href="/ticket/active" class="nav-link '.$views_active.'">Активные <sup>'.$kol_3.'</sup></a>
								</button>
							</li>' : '';
            $view_na_proverk = ($kol_5 > 0) ? '
							<li class="request-menu-item">
								<button>
									<a href="/ticket/na_proverku" class="nav-link '.$views_na_proverku.'">На проверке <sup>'.$kol_5.'</sup></a>
								</button>
							</li>' : '';
            $view_vozvrat = ($kol_6 > 0) ? '
							<li class="request-menu-item">
								<button>
									<a href="/ticket/vozvrat" class="nav-link '.$views_vozvrat.'">Возвращено <sup></sup>'.$kol_6.'</a>
								</button>
							</li>' : '';


            $views_admins = $view_active.$view_na_proverk.$view_vozvrat;


        } else {

            $kol_3 = !empty($ticket_flag_active[0]) ? $ticket_flag_active[0]['count_flag'] : 0;
            $kol_5 = !empty($ticket_flag_na_proverku[0]) ? $ticket_flag_na_proverku[0]['count_flag'] : 0;
            $kol_6 = !empty($ticket_flag_vozvrat[0]) ? $ticket_flag_vozvrat[0]['count_flag'] : 0;
            $kol_4_0 = !empty($ticket_flag_inworks[0]) ? $ticket_flag_inworks[0]['count_flag'] : 0;

            $kol_4_all = $kol_3 + $kol_5 + $kol_6 + $kol_4_0;
            $kol_4 = !empty($kol_4_all) ? $kol_4_all : '';
            $views_admins = '';

        }
        $kol_1v = ($kol_1 > 0) ? '<li class="request-menu-item">
							<button>
								<a href="/ticket/errors" class="nav-link '.$views_errors.'">Ошибки <sup>'.$kol_1.'</sup></a>
							</button>
						</li>' : '';

        $kol_2v = ($kol_2 > 0) ? '<li class="request-menu-item">
							<button>
								<a href="/ticket/pred" class="nav-link '.$views_pred.'">Предложения <sup>'.$kol_2.'</sup></a>
							</button>
						</li>' : '';

        $kol_4v = ($kol_4 > 0) ? '<li class="request-menu-item">
							<button>
								<a href="/ticket/in_works" class="nav-link '.$views_in_works.'">В работе <sup>'.$kol_4.'</sup></a>
							</button>
						</li>' : '';

        $kol_7v = ($kol_7 > 0) ? '<li class="request-menu-item">
							<button>
								<a href="/ticket/done" class="nav-link '.$views_done.'">Исполненные <sup>'.$kol_7.'</sup></a>
							</button>
						</li>' : '';

        $kol_8v = ($kol_8 > 0) ? '<li class="request-menu-item">
							<button>
								<a href="/ticket/arhiv" class="nav-link '.$views_arhiv.'">Архив <sup>'.$kol_8.'</sup></a>
							</button>
						</li>' : '';


        $code = '	
				<div class="request-head">
					<div class="request-checking">
						<input type="checkbox">
					</div>
					<ul class="request-menu">
						

							'.$kol_1v.$kol_2v.$kol_4v.$kol_7v.$kol_8v.$views_admins.'
						<!--
						<li class="request-menu-item">
							<button>
								<a href="/ticket/otzyv" class="nav-link '.$views_otzyv.'">Отзывы <sup></sup></a>
							</button>
						</li>
						-->
						<li class="request-menu-item">
							<button>
								<a href="/faq" class="nav-link">Частые вопросы</a>
							</button>
						</li>	
						<li class="request-menu-item">
							<button>
								<a href="/about" class="nav-link">О QuestRequest</a>
							</button>
						</li>
						<li class="request-menu-item">
							<button>
								<a href="/rules" class="nav-link">Соглашение</a>
							</button>
						</li>
						<li class="request-menu-item">
							<button>
								<a href="/confidentiality" class="nav-link">Конфиденциальность</a>
							</button>
						</li>							
					</ul>
				</div>';

        return $code;
    }


    // настройки интеграции с 1С
    function SericeBind1c($p = array())
    {

        $row_company = reqCompany(array('id' => COMPANY_ID));

        $r_all = req1cRefreshAll(array('company_id' => COMPANY_ID));

        if (empty($r_all)) {
            $code_refresh = '	<div class="container">
				
									<h5>Обновить из 1С</h5>

									'.$this->Input(array('type' => 'button',
                        'class' => 'profile-btn request-btn refresh_1c_all',
                        'value' => 'обновить из 1С'
                    )
                ).'
											
							</div>';
        } else {
            $code_refresh = '	<div class="container">
				
									<h5>Обновить из 1С</h5>
									
									<div>
										Идет обновление из 1с ...
									</div>
											
							</div>';
        }

        $code = '
				<div class="container">	
				
						<h5>Шаг 3. Привязать организацию</h5>
						
						<form id="my_company_id_1c-form" class="" role="form">
							<div class="profile-wrapper company-wrapper">
								<div class="profile-info-wrapper">
									<div class="profile-info">
										<div class="form-group">
											'.$this->Input(array('type' => 'text',
                    'id' => 'id_1c',
                    'value' => $row_company['id_1c'],
                    'placeholder' => 'Идентификатор компании из 1С'
                )
            ).'
											'.$this->Input(array('type' => 'submit',
                    'class' => 'profile-btn request-btn',
                    'value' => 'Привязать'
                )
            ).'
										</div>
										Идентификатор компании, берется из 1С и имеет вид 00000000-0000-0000-0000-000000000000
									</div>
								</div>
							</div>
						</form>
						
				</div>
				
				<div class="container">	
				
						<h5>Шаг 4. Привязать единицы измерения</h5>

						'.$this->Input(array('type' => 'button',
                    'id' => 'bind_unit_1c',
                    'class' => 'profile-btn request-btn',
                    'value' => 'Привязать'
                )
            ).'
						
						<div id="div_bind_unit_1c"></div>
				</div>
					
				<div class="container">	
				
						<h5>Шаг 5. Привязать вид номенклатуры'.COMPANY_ID.'</h5>

						'.$this->Input(array('type' => 'button',
                    'id' => 'bind_1c_typenom',
                    'class' => 'profile-btn request-btn',
                    'value' => 'обновить из 1С'
                )
            ).'
								
						'.$this->Input(array('type' => 'button',
                    'class' => 'profile-btn request-btn get_form_bind_1c_typenom',
                    'value' => 'Привязать',
                    'data' => array('id' => 1)
                )
            ).'
						
						<div id="div_bind_1c_typenom1"></div>
				</div>
				
				<div class="container">	
				
						<h5>Шаг 6. Привязать склады</h5>

						'.$this->Input(array('type' => 'button',
                    'id' => 'bind_1c_stock',
                    'class' => 'profile-btn request-btn',
                    'value' => 'обновить из 1С'
                )
            ).'
								
						'.$this->Input(array('type' => 'button',
                    'id' => 'get_form_bind_1c_stock',
                    'class' => 'profile-btn request-btn',
                    'value' => 'Привязать'
                )
            ).'
						
						<div id="div_bind_1c_stock"></div>
				</div>
				
				<div class="container">	
				
						<h5>Шаг 7. Привязать компании</h5>

						'.$this->Input(array('type' => 'button',
                    'id' => 'bind_1c_company',
                    'class' => 'profile-btn request-btn',
                    'value' => 'обновить из 1С'
                )
            ).'
								
						<a href="/subscriptions/profile" class="profile-btn request-btn">Привязать</a>
						
						<div id="div_bind_1c_stock"></div>
				</div>
				
				<div class="container">
				
						<h5>Шаг 8. Привязать номенклатуру</h5>

						'.$this->Input(array('type' => 'button',
                    'id' => 'bind_1c_nomenclature',
                    'class' => 'profile-btn request-btn',
                    'value' => 'обновить из 1С'
                )
            ).'
								
						<a href="/nomenclature" class="profile-btn request-btn">Привязать</a>
						
						<div id="div_bind_1c_stock"></div>
				</div>
				
				'.$code_refresh.'
				
		
				';


        return $code;
    }


    // Следующие строки при прокрутки для "Склад"
    function NextTrPageStock($p = array())
    {

        $row = reqMyStockBuySell(array('start_limit' => $p['start_limit'],
            'stock_id' => $p['stock_id'],
            'status_buy_sell_id' => $p['status_buy_sell_id'],
            'value' => $p['value']));


        $tr = '';
        foreach ($row as $i => $m) {

            $tr .= self::TrMySell(array('m' => $m));

        }

        $tr = str_replace('{DAY_NOACTIVE}', '', $tr);

        $code = ($tr) ? $tr : '';

        return $code;
    }


}

?>