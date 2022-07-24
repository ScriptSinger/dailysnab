<?php // Карта сайта
	class Controllers_Sitemap extends core_BaseController
	{
		function __construct()
		{
			parent::__construct();

				$this->sitemap = '';
				
				$home = (isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on' ? "https" : "http") . "://$_SERVER[HTTP_HOST]";  //$_SERVER[REQUEST_URI]
				header('Content-type: application/xml; charset=utf-8');
				$xml_data = '<?xml version="1.0" encoding="UTF-8"?><urlset xmlns="https://www.sitemaps.org/schemas/sitemap/0.9">';

					$sql_route = "SELECT route, data_insert FROM route where id NOT IN (1,2,4,5,6,7,8,13,18,19,24,27,28,30,31)";
					$row_route = PreExecSQL_all($sql_route,array());
					
					$sql_category = "SELECT categories, url_categories, data_insert FROM slov_categories where active=1";
					$row_category = PreExecSQL_all($sql_category,array());
					

					foreach($row_route as $k=>$m){
						//вывод url из таблицы route
						$datetime = new DateTime($m['data_insert']);
						//$lastmod = $datetime->format('Y-m-d\TH:i:sP'); //формат даты другой
						$lastmod = $datetime->format('c');	////формат даты еще один
								$xml_data .= '  <url><loc>'.$home.'/'.$m['route'].'</loc>    ';
								$xml_data .= '  <lastmod>'.$lastmod.'</lastmod> ';
								$xml_data .= '  <changefreq>daily</changefreq>  ';
								$xml_data .= '  <priority>0.5</priority></url> ';		
							}
						//вывод url buy из таблицы slov_categories	
						foreach($row_category as $k=>$m2){
							$datetime = new DateTime($m2['data_insert']);
							$lastmod = $datetime->format('c');	
								$xml_data .= '  <url><loc>'.$home.'/buy/'.$m2['url_categories'].'</loc>    ';
								$xml_data .= '  <lastmod>'.$lastmod.'</lastmod> ';
								$xml_data .= '  <changefreq>daily</changefreq>  ';
								$xml_data .= '  <priority>0.5</priority></url> ';		
						}	 
						//вывод url sell  из таблицы slov_categories	
						foreach($row_category as $k=>$m2){
							$datetime = new DateTime($m2['data_insert']);
							$lastmod = $datetime->format('c');	
								$xml_data .= '  <url><loc>'.$home.'/sell/'.$m2['url_categories'].'</loc>    ';
								$xml_data .= '  <lastmod>'.$lastmod.'</lastmod> ';
								$xml_data .= '  <changefreq>daily</changefreq>  ';
								$xml_data .= '  <priority>0.5</priority></url> ';		
						}		


				$xml_data .= '</urlset>';

				//$sitemap = fopen("sitemap.xml", "w") or die("Unable to open file!");
				//fwrite($sitemap, $xml_data);
				//fclose($sitemap);

				echo $xml_data;			
		}
	}
?>