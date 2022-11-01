<?php
	//$row 	= $member['mainpage']['row'];
	$rowt = reqTicketMessages();
	
	$navPanel = empty($rowt) ? $t->SubmenuHelp(array('page'=>'confidentiality')) : $t->NavTabsTicketsFolders();  

	$code .= '

			<div class="container">'.$navPanel.'</div>		
			
			<section class="infopage">
				<div class="container">

					<div class="center-text">
						<h1>ПОЛИТИКА КОНФИДЕНЦИАЛЬНОСТИ</h1>
					</div>
					
					<div class="text-section center-text">
						<h5>ИНТЕРНЕТ-САЙТА QUESTREQUEST</h1>
					</div>
					<div class="text-section justify-text">
						<p>Настоящая  Политика  конфиденциальности  персональных  данных  (далее - «Политика   конфиденциальности»)   действует  в  отношении  всей  информации, размещенной     на     сайте     в     сети     Интернет     по     адресу: https://qrq.ru  (далее – «Сайт»), которую ИП Султанов Денис Фанилевич (владелец сайта) и иные управомоченные им лица  могут  получить о Пользователе  во  время  использования  Сайта,  его  сервисов,  программ  и продуктов.</p>
					</div>
					<div class="text-section justify-text">
						<p>Использование сервисов Сайта означает безоговорочное согласие Пользователя с настоящей Политикой и указанными в ней условиями обработки его персональной информации; в случае несогласия с этими условиями Пользователь должен воздержаться от использования Сайта и сервисов.</p>
					</div>
						 
					<div class="text-section justify-text">
						<ol>
							<li><div class="center-text"><h5>ОБЩИЕ ПОЛОЖЕНИЯ</h5></div>
								<ol>
									<li> В рамках настоящей Политики под персональной информацией Пользователя понимаются:
										<ol>
											<li>Персональная информация, которую Пользователь предоставляет о себе самостоятельно при регистрации (создании учетной записи) или в процессе использования Сервисов, включая персональные данные Пользователя. Обязательная для предоставления Сервисов информация помечена специальным образом. Иная информация предоставляется Пользователем на его усмотрение.
												<br/>К персональной информации относятся самостоятельно предоставляемые (при регистрации) Пользователем данные:
												<br/>- фамилия, имя, отчество;
												<br/>- дата рождения;
												<br/>- пол;
												<br/>- контактная информация, включая номера телефонов, факсов, e-mail;
												<br/>- адрес регистрации и места проживания;
												<br/>- данные необходимые для осуществления оплаты стоимости услуг (номер банковской карты, дата выпуска, срок действия, информация о владельце CVC -код).
												<br/>Автоматически собираемые данные:
												<br/>- IP-адрес, данные файлов cookie,
												<br/>- информация о браузере Пользователя, технические характеристики оборудования и программного обеспечения, используемых Пользователем,
												<br/>- дата и время доступа к сайту, адреса запрашиваемых страниц и иная подобная информация.
											</li>
											<li>Данные, которые автоматически передаются сервисам Сайта в процессе их использования с помощью установленного на устройстве Пользователя программного обеспечения, в том числе IP-адрес, данные файлов cookie, информация о браузере Пользователя (или иной программе, с помощью которой осуществляется доступ к сервисам), технические характеристики оборудования и программного обеспечения, используемых Пользователем, дата и время доступа к сервисам, адреса запрашиваемых страниц и иная подобная информация.</li>
											<li>Иная информация о Пользователе, обработка которой предусмотрена Пользовательским соглашением.</li>
											<li>Настоящая Политика конфиденциальности применяется только к Сайту https://qrq.ru. Сайт https://qrq.ru не контролирует и не несет ответственности за сайты третьих лиц, на которые Пользователь может перейти по ссылкам, доступным на Сайте https://qrq.ru. 
												<br/>Определение иных терминов:</li>
											<li>Сайт - совокупность программно-аппаратных средств для ЭВМ, обеспечивающих публикацию данных в Интернет для всеобщего обозрения. Сайт доступен по уникальному электронному адресу или его буквенному обозначению. Может содержать графическую, текстовую, аудио-, видео-, а также иную информацию, воспроизводимую с помощью ЭВМ.</li>
											<li>Оператор - ИП Султанов Денис Фанилевич, осуществляющий обработку персональных данных, а также определяющий цели и содержание обработки персональных данных;</li>
											<li>Субъект персональных данных в контексте настоящего положения - физическое лицо, являющееся клиентом - пользователем Сайта.</li>
											<li>Обработка персональных данных - действия (операции) с персональными данными, включая сбор, систематизацию, накопление, хранение, уточнение (обновление, изменение), использование, распространение (в том числе передача), обезличивание, блокирование, уничтожение персональных данных;</li>
											<li>Конфиденциальность персональных данных - обязательное для соблюдения оператором или иным получившим доступ к персональным данным лицом требование не допускать их распространения без согласия субъекта персональных данных или иного законного основания;</li>
											<li>Распространение персональных данных - действия, направленные на передачу персональных данных определенному кругу лиц или на ознакомление с персональными данными неограниченного круга лиц, в том числе обнародование персональных данных в средствах массовой информации, размещение в информационно-телекоммуникационных сетях или предоставление доступа к персональным данным каким-либо иным способом;</li>
											<li>Использование персональных данных - действия (операции) с персональными данными, совершаемые оператором в целях принятия решений или совершения иных действий, порождающих юридические последствия в отношении субъекта персональных данных или других лиц, либо иным образом затрагивающих права и свободы субъекта персональных данных или других лиц;</li>
											<li>Уничтожение персональных данных - действия, в результате которых невозможно восстановить содержание персональных данных в информационной системе персональных данных или в результате которых уничтожаются материальные носители персональных данных работников;</li>
											<li>Обезличивание персональных данных - действия, в результате которых невозможно определить принадлежность персональных данных конкретному субъекту персональных данных;</li>
											<li>Блокирование персональных данных - временное прекращение сбора, систематизации, накопления, использования, распространения персональных данных, в том числе их передачи;</li>
											<li>Общедоступные персональные данные - персональные данные, доступ неограниченного круга лиц к которым предоставлен с согласия субъекта персональных данных или на которые в соответствии с федеральными законами не распространяется требование соблюдения конфиденциальности.</li>
											<li>Администратор сайта — это физическое лицо, уполномоченное Оператором для осуществления администрирования Сайта.</li>							
										</ol>
									</li>
									
								</ol>
							</li>
							
							<li><div class="center-text"><h5>ЦЕЛИ ОБРАБОТКИ ПЕРСОНАЛЬНОЙ ИНФОРМАЦИИ ПОЛЬЗОВАТЕЛЕЙ</h5></div>
								<ol>
									<li>Сайт собирает и хранит только ту персональную информацию, которая необходима для предоставления сервисов или исполнения пользовательского соглашения и иных договоров с Пользователем, за исключением случаев, когда законодательством предусмотрено обязательное хранение персональной информации в течение определенного законом срока. Правовым основанием для обработки персональных данных является волеизъявление Пользователя на получение услуг, использование Сервиса (в соответствии с пользовательским соглашением), предоставляемых Оператором, а также Гражданский кодекс РФ.</li>
									<li>Персональную информацию Пользователя Сайт обрабатывает в следующих целях:
										<ol>
											<li>Идентификации Пользователя, зарегистрированного на Сайте, для возможности получения услуг.</li>
											<li>Предоставления Пользователю доступа к персонализированным ресурсам Сайта.</li>
											<li>Установления с Пользователем обратной связи, включая направление уведомлений, запросов, касающихся использования Сайта, оказания услуг, обработку запросов и заявок от Пользователя.</li>
											<li>Определения места нахождения Пользователя для обеспечения безопасности, предотвращения мошенничества.</li>
											<li>Подтверждения достоверности и полноты персональных данных, предоставленных Пользователем.</li>
											<li>Создания учетной записи для возможности покупки и продажи товаров, оставления заявок на Сайте, если Пользователь дал согласие на создание учетной записи.</li>
											<li>Уведомления Пользователя Сайта.</li>
											<li>Предоставления Пользователю эффективной клиентской и технической поддержки при возникновении проблем, связанных с использованием Сайта.</li>
											<li>Осуществления рекламной деятельности с согласия Пользователя.</li>
											<li>Оказания услуг, предусмотренных пользовательским соглашением.</li>
										</ol>
									</li>
									
								</ol>
							</li>
							
							<li><div class="center-text"><h5>УСЛОВИЯ ОБРАБОТКИ ПЕРСОНАЛЬНОЙ ИНФОРМАЦИИ ПОЛЬЗОВАТЕЛЕЙ И ЕЕ ПЕРЕДАЧИ ТРЕТЬИМ ЛИЦАМ</h5></div>
								<ol>
									<li>Сайт хранит персональную информацию Пользователей в соответствии с внутренними регламентами конкретных сервисов.</li>
									<li>В отношении персональной информации Пользователя сохраняется ее конфиденциальность, кроме случаев добровольного предоставления Пользователем информации о себе для общего доступа неограниченному кругу лиц. При использовании отдельных сервисов Пользователь соглашается с тем, что определенная часть его персональной информации становится общедоступной.</li>
									<li>Сайт вправе передать персональную информацию Пользователя третьим лицам в следующих случаях:
										<ol>
											<li>Пользователь выразил согласие на такие действия.</li>
											<li>Передача необходима для использования Пользователем определенного сервиса либо для исполнения определенного соглашения или договора с Пользователем.</li>
											<li>Передача предусмотрена российским или иным применимым законодательством в рамках установленной законодательством процедуры.</li>
											<li>В случае продажи Сайта к приобретателю переходят все обязательства по соблюдению условий настоящей Политики применительно к полученной им персональной информации.</li>
										</ol>
									<li>Обработка персональных данных Пользователя осуществляется без ограничения срока любым законным способом, в том числе в информационных системах персональных данных с использованием средств автоматизации или без использования таких средств. Обработка персональных данных Пользователей осуществляется в соответствии с Федеральным законом от 27.07.2006 N 152-ФЗ «О персональных данных».</li>
									<li>При утрате или разглашении персональных данных Администрация Сайта информирует Пользователя об утрате или разглашении персональных данных.</li>
									<li>Администрация Сайта принимает необходимые организационные и технические меры для защиты персональной информации Пользователя от неправомерного или случайного доступа, уничтожения, изменения, блокирования, копирования, распространения, а также от иных неправомерных действий третьих лиц.</li>
									<li>Администрация Сайта совместно с Пользователем принимает все необходимые меры по предотвращению убытков или иных отрицательных последствий, вызванных утратой или разглашением персональных данных Пользователя.</li>									
								</ol>
							</li>
							
							<li><div class="center-text"><h5>ОБЯЗАТЕЛЬСТВА СТОРОН. СРОКИ</h5></div>
								<ol>
									<li>Пользователь обязан:
										<ol>
											<li>Предоставить информацию о персональных данных, необходимую для пользования Сайтом.</li>
											<li>Обновлять, дополнять предоставленную информацию о персональных данных в случае изменения данной информации.</li>
										</ol>
									<li> Администрация Сайта обязана:
										<ol>
											<li>Использовать полученную информацию исключительно для целей, указанных в настоящей Политике конфиденциальности.</li>
											<li>Обеспечить хранение конфиденциальной информации в тайне, не разглашать без предварительного письменного разрешения Пользователя, а также не осуществлять продажу, обмен, опубликование либо разглашение иными возможными способами переданных персональных данных Пользователя, за исключением предусмотренных настоящей Политикой конфиденциальности.</li>
											<li>Принимать меры предосторожности для защиты конфиденциальности персональных данных Пользователя согласно порядку, обычно используемому для защиты такого рода информации в существующем деловом обороте.</li>
											<li>Осуществить блокирование персональных данных, относящихся к соответствующему Пользователю, с момента обращения или запроса Пользователя или его законного представителя либо уполномоченного органа по защите прав субъектов персональных данных на период проверки в случае выявления недостоверных персональных данных или неправомерных действий.</li>
										</ol>
									</li>	
									<li>Администрация сайта хранит персональные данные в течение срока использования Сайта. При этом под сроком использования Сайта понимается период регистрации Пользователя на Сайте.</li>	
								</ol>
							</li>
							
							<li><div class="center-text"><h5>КОНФИДЕНЦИАЛЬНОСТЬ. ХРАНЕНИЕ ПЕРСОНАЛЬНЫХ ДАННЫХ</h5></div>
								<ol>
									<li>Персональные данные являются конфиденциальными. Администрация сайта обеспечивает конфиденциальность персональных данных и обязана не допускать их распространения без согласия пользователей, либо наличия иного законного основания.</li>
									<li>Все меры конфиденциальности при сборе, обработке и хранении персональных данных клиентов распространяются как на бумажные, так и на электронные (автоматизированные) носители информации.</li>
									<li>Режим конфиденциальности персональных данных снимается в случаях обезличивания или опубликования их в общедоступных источниках (СМИ, Интернет, ЕГРЮЛ и иных публичных государственных реестрах).</li>
									<li>Персональные данные обрабатываются и хранятся в электронном виде на территории РФ.</li>
								</ol>
							</li>
							
							<li><div class="center-text"><h5>ОТВЕТСТВЕННОСТЬ СТОРОН</h5></div>
								<ol>
									<li>Администрация Сайта, не исполнившая свои обязательства, несет ответственность за убытки, понесенные Пользователем в связи с неправомерным использованием персональных данных, в соответствии с законодательством Российской Федерации.</li>
									<li>В случае утраты или разглашения конфиденциальной информации Администрация Сайта не несет ответственности, если данная конфиденциальная информация:
										<ol>
											<li>Стала публичным достоянием до ее утраты или разглашения.</li>
											<li>Была получена от третьей стороны до момента ее получения Администрацией Сайта.</li>
											<li>Была разглашена с согласия Пользователя.</li>
										</ol>
									</li>
									
								</ol>
							</li>
							
							<li><div class="center-text"><h5>РАЗРЕШЕНИЕ СПОРОВ</h5></div>
								<ol>
									<li>До обращения в суд с иском по спорам, возникающим из отношений между Пользователем Сайта и Администрацией Сайта, обязательным является предъявление претензии (письменного предложения о добровольном урегулировании спора).</li>
									<li>Получатель претензии в течение 10 календарных дней со дня получения претензии письменно уведомляет заявителя претензии о результатах рассмотрения претензии.</li>
									<li>При недостижении соглашения спор будет передан на рассмотрение в суд в соответствии с действующим законодательством Российской Федерации.</li>
									<li>К настоящей Политике конфиденциальности и отношениям между Пользователем и Администрацией Сайта применяется действующее законодательство Российской Федерации.</li>
								</ol>
							</li>
							
							<li><div class="center-text"><h5>ДОПОЛНИТЕЛЬНЫЕ УСЛОВИЯ</h5></div>
								<ol>
									<li>Администрация Сайта вправе вносить изменения в настоящую Политику конфиденциальности без согласия Пользователя.</li>
									<li>Новая Политика конфиденциальности вступает в силу с момента ее размещения на Сайте, если иное не предусмотрено новой редакцией Политики конфиденциальности.</li>
									<li>Все предложения или вопросы по настоящей Политике конфиденциальности следует сообщать по адресу электронной почты: support@qrq.ru</li>
									<li>Действующая Политика конфиденциальности размещена на странице по адресу: https://qrq.ru/confidentiality.</li>
									<li>Настоящая Политика конфиденциальности является неотъемлемой частью Пользовательского соглашения, размещенного на странице по адресу: https://qrq.ru/rules.</li>
								</ol>
							</li>
						</ol>
					</div>
					
					<div class="text-section">
						 
						Дата размещения: 29.11. 2020г.
						
					</div>
					
					
				</div>
			</section>

	
		
			';


?>