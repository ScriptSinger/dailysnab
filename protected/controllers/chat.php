<?php // Подписки
class Controllers_Chat extends core_BaseController
{
    public function __construct()
    {
        parent::__construct();

        if (LOGIN_ID) {

            $views = getArgs(1);
            $views = ($views) ? $views : 'messages';
            $value = getGets('value');
            $mid = $value = '';

            $mid = getArgs(2);
            //$mid = (!empty($mid))? $mid : '';
            //$_mid    = getGets('messages_id');

            // страница - Все сообщения
            if ($views == 'messages') {

                // Поиск

                $row = $this->rowChatMessages(array('views' => $views,

                    'value' => $value));

                $rown = reqChatMessages(array('views' => $views,
                    'folder_id' => $mid,
                ));

                $this->chat = array('views' => $views,
                    'row' => $row,
                    'value' => $value,
                    'mid' => $mid,
                    'rown' => $rown,
                );
                $this->title = 'Все сообщения';
            }
            // страница - Отктыре темы
            elseif ($views == 'open-chats') {
                $row = $this->rowChatMessages(array('views' => $views));
                $this->chat = array('views' => $views,
                    'row' => $row,
                    'value' => $value,
                );
                $this->title = 'Отктыре темы';
            }
            // страница - Архивные
            elseif ($views == 'arhive-chats') {
                $row = $this->rowChatMessages(array('views' => $views));
                $this->chat = array('views' => $views,
                    'row' => $row,
                    'value' => $value,
                );
                $this->title = 'Архив';
            }
            // страница - Без темы
            elseif ($views == 'wt-chats') {
                $row = $this->rowChatMessages(array('views' => $views));
                $this->chat = array('views' => $views,
                    'row' => $row,
                    'value' => $value,
                );
                $this->title = 'Без темы';
            }
            // удаляем оповещение(маркеры)
            //reqDeleteNotification(array('notification_id'=>13));

            else {

                //$this->e404 = '';
                //$this->title = 'Ошибка 404. Страница не найдена';
            }

        } else {
            redirect('/');
        }
    }
}
