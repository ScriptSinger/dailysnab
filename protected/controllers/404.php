<?php
	class Controllers_404 extends core_BaseController
	{
		function __construct()
		{
			parent::__construct();
			
			$this->e404 = '';
			$this->title = 'Ошибка 404';
		}
	}
?>