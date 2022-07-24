<?php
	//$row 	= $member['mainpage']['row'];


	$code .= '
	
			<header class="header" id="header">
				<div class="container">
					<img src="/image/logotype.svg" alt="logotype" class="logo">
					'.$f->FormAutorize2().'
				</div>
			</header>
	
			<section class="search" id="search">
				<div class="container">
					<div class="search-wrapper">
						<div class="for-search">
							<div class="btn search-main">
								<input type="text" placeholder="Что ищете?" class="search-input autocomplete_search_mainpage" autocomplete="off">
								<span class="after search-after search-after-rot modal_search" data-mclass="search-dialog"></span>
								<div class="main-search__thumb"></div>
							</div>
						</div>

						<div class="btn search-post">
							<div class="post-btn">
								<p>Разместить потребность</p>
							</div>
							<div class="post-wrap blue-buttons _d-none">
								<button class="post-request modal_buy_sell" data-flag_buy_sell="2">
									Заявка
								</button>
								<button class="post-post modal_buy_sell" data-flag_buy_sell="1">
									Объявление
								</button>
							</div>
						</div>
					</div>
				</div>
			</section>

		
<script>
	AutocompleteSearch("mainpage");
</script>	
		
			';


?>