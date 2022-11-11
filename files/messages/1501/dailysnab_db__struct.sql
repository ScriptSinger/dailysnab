-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Host: dailysnab.beget.tech
-- Generation Time: Oct 28, 2022 at 03:13 PM
-- Server version: 5.7.21-20-beget-5.7.21-20-1-log
-- PHP Version: 7.3.31

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `dailysnab_db`
--

-- --------------------------------------------------------

--
-- Table structure for table `1c_company`
--

CREATE TABLE `1c_company` (
  `id` int(11) NOT NULL,
  `company_id` int(11) NOT NULL,
  `id_1c` varchar(50) NOT NULL,
  `name` varchar(250) NOT NULL,
  `fullname` varchar(250) NOT NULL,
  `inn` varchar(15) NOT NULL,
  `kpp` varchar(15) NOT NULL,
  `data_1c` date DEFAULT NULL,
  `data_insert` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `1c_company_company`
--

CREATE TABLE `1c_company_company` (
  `id` int(11) NOT NULL,
  `company_id` int(11) NOT NULL,
  `1c_company_id` int(11) NOT NULL,
  `company_id_to` int(11) NOT NULL COMMENT 'kompaniu kotoruu privyzivaem',
  `data_insert` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `1c_nomenclature`
--

CREATE TABLE `1c_nomenclature` (
  `id` int(11) NOT NULL,
  `company_id` int(11) NOT NULL,
  `id_1c` varchar(50) NOT NULL,
  `article` varchar(250) NOT NULL,
  `name` varchar(250) NOT NULL,
  `measure_id` int(11) NOT NULL,
  `typenom_id_1c` varchar(50) NOT NULL,
  `kod_tovar` varchar(255) DEFAULT NULL COMMENT 'kod tovara v 1c',
  `data_1c` datetime DEFAULT NULL,
  `data_insert` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `1c_nomenclature_out`
--

CREATE TABLE `1c_nomenclature_out` (
  `id` int(11) NOT NULL,
  `nomenclature_id` int(11) NOT NULL,
  `data_insert` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `1c_nomost`
--

CREATE TABLE `1c_nomost` (
  `id` int(11) NOT NULL,
  `company_id` int(11) NOT NULL,
  `nomenclature_id` int(11) NOT NULL,
  `stock_id` int(11) NOT NULL,
  `ostatok` decimal(10,2) NOT NULL,
  `data_1c` datetime NOT NULL,
  `id_1c_nomid` varchar(50) NOT NULL COMMENT 'NomID - iz 1C',
  `data_update` datetime DEFAULT NULL,
  `data_insert` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `1c_outbuy11`
--

CREATE TABLE `1c_outbuy11` (
  `id` int(11) NOT NULL,
  `buy_sell_id` int(11) NOT NULL,
  `data_insert` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `1c_outbuy12`
--

CREATE TABLE `1c_outbuy12` (
  `id` int(11) NOT NULL,
  `buy_sell_id` int(11) NOT NULL,
  `data_insert` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `1c_refresh_all`
--

CREATE TABLE `1c_refresh_all` (
  `id` int(11) NOT NULL,
  `company_id` int(11) NOT NULL,
  `data_insert` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `1c_slov_unit`
--

CREATE TABLE `1c_slov_unit` (
  `id` int(11) NOT NULL,
  `company_id` int(11) DEFAULT NULL,
  `name` varchar(50) DEFAULT NULL,
  `measure_id` int(11) DEFAULT NULL,
  `data_1c` datetime DEFAULT NULL COMMENT 'data iz 1c'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `1c_stock`
--

CREATE TABLE `1c_stock` (
  `id` int(11) NOT NULL,
  `company_id` int(11) NOT NULL,
  `id_1c` varchar(50) NOT NULL,
  `name` varchar(250) NOT NULL,
  `data_1c` datetime DEFAULT NULL,
  `data_insert` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `1c_transport`
--

CREATE TABLE `1c_transport` (
  `id` int(11) NOT NULL,
  `company_id` int(11) NOT NULL,
  `id_1c` varchar(50) NOT NULL,
  `modelname` varchar(250) NOT NULL,
  `regnumber` varchar(50) NOT NULL,
  `lastdriver` varchar(250) NOT NULL,
  `data1c` date NOT NULL,
  `data_insert` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `1c_transport_buy_sell`
--

CREATE TABLE `1c_transport_buy_sell` (
  `id` int(11) NOT NULL,
  `buy_sell_id` int(11) NOT NULL,
  `1c_transport_id` int(11) NOT NULL,
  `data_insert` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `1c_typenom`
--

CREATE TABLE `1c_typenom` (
  `id` int(11) NOT NULL,
  `company_id` int(11) NOT NULL,
  `id_1c` varchar(50) NOT NULL,
  `name` varchar(250) NOT NULL,
  `data_1c` datetime DEFAULT NULL,
  `data_insert` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `1c_typenom_categoies`
--

CREATE TABLE `1c_typenom_categoies` (
  `id` int(11) NOT NULL,
  `company_id` int(11) NOT NULL,
  `1c_typenom_id` int(11) NOT NULL COMMENT '1c_typenom_id iz tablicy 1c_typenom',
  `categories_id` int(11) NOT NULL,
  `data_insert` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `amo_accounts_basket_param`
--

CREATE TABLE `amo_accounts_basket_param` (
  `id` int(11) NOT NULL,
  `accounts_id` int(11) NOT NULL,
  `param` text NOT NULL,
  `data_insert` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `amo_accounts_etp`
--

CREATE TABLE `amo_accounts_etp` (
  `id` int(11) NOT NULL COMMENT 'NOVAYA VERSIYA ETP',
  `company_id` int(11) NOT NULL COMMENT '1-admin sozdal',
  `qrq_id` int(11) NOT NULL,
  `flag_autorize` tinyint(1) NOT NULL COMMENT '1-bez avtorizacii (avtorizaciya etoy kompanii beretsya c priznakom flag_autorize=3); 2-sam polzovatel avtorizovalsya so svoim login/pass; 3-oznachaet chto sozdano v adminke',
  `login` varchar(255) DEFAULT NULL,
  `pass` varchar(255) DEFAULT NULL,
  `accounts_id` varchar(255) DEFAULT NULL,
  `account_title` varchar(255) DEFAULT NULL,
  `data_insert` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `amo_accounts_old11062022`
--

CREATE TABLE `amo_accounts_old11062022` (
  `id` int(11) NOT NULL COMMENT 'STATRAYA VERSIYA',
  `company_id` int(11) NOT NULL,
  `vendorid` varchar(50) NOT NULL COMMENT 'polucheniy unikalniy id postavchika',
  `login` varchar(250) NOT NULL,
  `password` varchar(250) NOT NULL,
  `accounts_id` varchar(50) NOT NULL,
  `accounts_title` varchar(250) NOT NULL,
  `parent_id` varchar(50) DEFAULT NULL,
  `data_insert` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `data_update` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `amo_cities`
--

CREATE TABLE `amo_cities` (
  `id` int(11) NOT NULL COMMENT 'id iz amo',
  `rid` int(11) NOT NULL,
  `title` varchar(255) NOT NULL,
  `data_insert` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `amo_cities_cities_id`
--

CREATE TABLE `amo_cities_cities_id` (
  `id` int(11) NOT NULL COMMENT 'svyaz gorodov etp s nashimi',
  `cities_id` int(11) NOT NULL,
  `amo_cities_id` int(11) NOT NULL,
  `data_insert` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `amo_html_searchbrend`
--

CREATE TABLE `amo_html_searchbrend` (
  `id` int(11) NOT NULL,
  `buy_sell_id` int(11) NOT NULL,
  `html` longtext NOT NULL,
  `data_insert` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `amo_log_json`
--

CREATE TABLE `amo_log_json` (
  `id` int(11) NOT NULL,
  `parent_id` int(11) NOT NULL COMMENT 'ne 0 znachit error ili warning true',
  `url` varchar(50) NOT NULL,
  `json` longtext,
  `json2` longtext,
  `token` varchar(50) NOT NULL,
  `parameters` text NOT NULL,
  `accounts_id` int(11) DEFAULT NULL,
  `errors_code` int(11) DEFAULT NULL COMMENT 'kod oshibki',
  `errors_message` varchar(255) DEFAULT NULL COMMENT 'soobchenie oshibki',
  `data_insert` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `amo_name_error_etp`
--

CREATE TABLE `amo_name_error_etp` (
  `id` int(11) NOT NULL COMMENT 'oshbki etp dlya obrabotki v sisteme',
  `name_error` varchar(255) DEFAULT NULL,
  `name_error_qrq` varchar(255) DEFAULT NULL,
  `name_error_etp` varchar(255) DEFAULT NULL,
  `next_etp` tinyint(1) NOT NULL DEFAULT '0',
  `data_insert` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `attribute_value`
--

CREATE TABLE `attribute_value` (
  `id` int(11) NOT NULL,
  `categories_id` int(11) NOT NULL,
  `attribute_id` int(11) NOT NULL,
  `attribute_value_id` int(11) NOT NULL COMMENT 'foreign slov_attribute_value_id',
  `data_insert` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `a_cities`
--

CREATE TABLE `a_cities` (
  `id` int(11) NOT NULL,
  `regions_id` int(11) NOT NULL,
  `name` varchar(50) NOT NULL,
  `ru_type` varchar(50) NOT NULL DEFAULT '',
  `ru_path` varchar(50) NOT NULL,
  `url_cities` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `buy_sell`
--

CREATE TABLE `buy_sell` (
  `id` int(11) NOT NULL,
  `parent_id` int(11) NOT NULL DEFAULT '0' COMMENT 'ne "0" svyz s prediduchey',
  `copy_id` int(11) NOT NULL DEFAULT '0' COMMENT 'obchaya svyaz zapisey',
  `login_id` int(11) NOT NULL DEFAULT '0',
  `company_id` int(11) NOT NULL,
  `company_id2` int(11) DEFAULT '0' COMMENT 'postavchik. Ot kogo predlojenie, i u kogo kupili',
  `flag_buy_sell` tinyint(1) NOT NULL COMMENT '1-sell,2-buy,3-offer,4-assets,5-stock',
  `status_buy_sell_id` tinyint(2) NOT NULL DEFAULT '1',
  `active` tinyint(1) NOT NULL DEFAULT '1',
  `amount` decimal(10,2) NOT NULL DEFAULT '0.00',
  `amount1` decimal(10,2) NOT NULL DEFAULT '0.00' COMMENT 'kolichestvo pri fasovke',
  `unit_id1` tinyint(2) NOT NULL DEFAULT '0' COMMENT 'ed.izm pri fasovke',
  `amount2` decimal(10,2) NOT NULL DEFAULT '0.00' COMMENT 'kolichestvo esli v unit_id1 ukazano shtuki (unit_id1=1)',
  `unit_id2` tinyint(2) NOT NULL DEFAULT '0',
  `amount_buy` decimal(10,2) NOT NULL DEFAULT '0.00' COMMENT 'pokupaemoe kolichestvo',
  `name` varchar(255) NOT NULL,
  `url` varchar(255) NOT NULL,
  `cities_id` int(11) NOT NULL,
  `categories_id` int(11) NOT NULL,
  `urgency_id` tinyint(4) NOT NULL,
  `availability` int(4) DEFAULT '0',
  `cost` decimal(10,2) NOT NULL DEFAULT '0.00',
  `cost1` decimal(10,2) NOT NULL DEFAULT '0.00' COMMENT 'cena za fasovku v ed.izm ili za kolichestvo v ed.izm',
  `currency_id` tinyint(1) NOT NULL DEFAULT '1',
  `form_payment_id` tinyint(1) NOT NULL DEFAULT '0',
  `comments` text,
  `comments_company` varchar(255) DEFAULT NULL COMMENT 'Imya zakaza',
  `responsible_id` int(11) DEFAULT '0' COMMENT 'Otvetstvenniy - id iz company (flag_account=4)',
  `qrq_id` int(11) DEFAULT '0' COMMENT 'esli predlojeniy so storonnego servisa (ssilka na slov_qrq)',
  `item_id` decimal(12,0) DEFAULT '0' COMMENT 'id predlojeniy so storonnego servisa',
  `nomenclature_id` int(11) NOT NULL DEFAULT '0',
  `multiplicity` int(11) DEFAULT '0',
  `min_party` int(11) DEFAULT '0',
  `delivery_id` int(11) DEFAULT '0',
  `stock_id` int(11) DEFAULT '0',
  `assets_id` int(11) DEFAULT '0',
  `company_id3` int(11) DEFAULT '0' COMMENT 'zakazchik dlya kogo zayavka',
  `data_insert` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `data_status_buy_sell_23` datetime DEFAULT NULL COMMENT 'data kogda status stal 2 ili 3',
  `data_status_buy_sell_10` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `buy_sell_1c`
--

CREATE TABLE `buy_sell_1c` (
  `id` int(11) NOT NULL,
  `flag` tinyint(1) NOT NULL DEFAULT '1' COMMENT '1-docreceiptgoods ; 2-docreceiptgoods; 3-docimplementation',
  `company_id` int(11) NOT NULL,
  `buy_sell_id` int(11) NOT NULL,
  `id_1c` varchar(50) NOT NULL,
  `data_1c` datetime NOT NULL,
  `data_insert` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `buy_sell_attribute`
--

CREATE TABLE `buy_sell_attribute` (
  `id` bigint(21) NOT NULL,
  `buy_sell_id` int(11) NOT NULL,
  `attribute_id` int(11) NOT NULL,
  `attribute_value_id` int(11) DEFAULT '0',
  `value` text,
  `data_insert` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Triggers `buy_sell_attribute`
--
DELIMITER $$
CREATE TRIGGER `trigger_history_buy_sell_attribute_delete` BEFORE DELETE ON `buy_sell_attribute` FOR EACH ROW BEGIN
    END
$$
DELIMITER ;
DELIMITER $$
CREATE TRIGGER `trigger_history_buy_sell_attribute_insert` AFTER INSERT ON `buy_sell_attribute` FOR EACH ROW BEGIN
		INSERT INTO history_buy_sell(login_id, buy_sell_id, value_new, value_old, comments) 
		VALUES ((SELECT bs.login_id FROM buy_sell bs WHERE bs.id=NEW.buy_sell_id),
				NEW.buy_sell_id, 
				case when NEW.id>0 then (
					SELECT CONCAT(
						(SELECT sa.attribute FROM slov_attribute sa WHERE sa.id=t.attribute_id),
						' - ',
						CASE WHEN t.attribute_value_id=0 THEN t.value 
							ELSE (	SELECT sav.attribute_value 
								FROM attribute_value av, slov_attribute_value sav
								WHERE av.id=t.attribute_value_id AND av.attribute_value_id=sav.id )
							END 
						) attribute_value
					FROM buy_sell_attribute t
					WHERE t.id=NEW.id
					) else '' end,
				'',
				 'добавлено'
			);
    END
$$
DELIMITER ;
DELIMITER $$
CREATE TRIGGER `trigger_history_buy_sell_attribute_update` AFTER UPDATE ON `buy_sell_attribute` FOR EACH ROW BEGIN
		INSERT INTO history_buy_sell(login_id, buy_sell_id, value_new, value_old, comments) 
		VALUES ((SELECT bs.login_id FROM buy_sell bs WHERE bs.id=OLD.buy_sell_id),
			OLD.buy_sell_id, (
					SELECT CONCAT(
						(SELECT sa.attribute FROM slov_attribute sa WHERE sa.id=OLD.attribute_id),
						' - ',
						CASE WHEN OLD.attribute_value_id=0 THEN NEW.value 
							ELSE (	SELECT sav.attribute_value 
								FROM attribute_value av, slov_attribute_value sav
								WHERE av.id=NEW.attribute_value_id AND av.attribute_value_id=sav.id )
							END 
						) attribute_value
					),
					(
					SELECT CONCAT(
						(SELECT sa.attribute FROM slov_attribute sa WHERE sa.id=OLD.attribute_id),
						' - ',
						CASE WHEN OLD.attribute_value_id=0 THEN OLD.value 
							ELSE (	SELECT sav.attribute_value 
								FROM attribute_value av, slov_attribute_value sav
								WHERE av.id=OLD.attribute_value_id AND av.attribute_value_id=sav.id )
							END 
						) attribute_value
					),
				 'Изменен'
			);
    END
$$
DELIMITER ;

-- --------------------------------------------------------

--
-- Table structure for table `buy_sell_cache`
--

CREATE TABLE `buy_sell_cache` (
  `id` int(11) NOT NULL,
  `buy_sell_id` int(11) NOT NULL,
  `cache_2` longtext NOT NULL COMMENT 'zayavki',
  `cache_1` longtext,
  `data_insert` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `buy_sell_cookie`
--

CREATE TABLE `buy_sell_cookie` (
  `id` int(11) NOT NULL,
  `buy_sell_id` int(11) NOT NULL,
  `cookie_session` varchar(50) NOT NULL COMMENT 'идентификатор куки для закрепленнием заявок/объявл за пользователем после регистрации',
  `data_insert` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `buy_sell_etp_sell`
--

CREATE TABLE `buy_sell_etp_sell` (
  `id` int(11) NOT NULL COMMENT 'obyavleniya(predlojeniya) s etp poluchenie polzovatelem',
  `buy_sell_id` int(11) NOT NULL,
  `company_id` int(11) NOT NULL DEFAULT '0' COMMENT 'kompaniy zaprosivshaya obyavleniya(predlojeniya)',
  `cookie_session` varchar(50) NOT NULL,
  `data_insert` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `buy_sell_files`
--

CREATE TABLE `buy_sell_files` (
  `id` int(11) NOT NULL,
  `buy_sell_id` int(11) NOT NULL,
  `path` varchar(255) NOT NULL,
  `name_file` varchar(255) NOT NULL,
  `type_file` varchar(10) NOT NULL,
  `data_insert` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `buy_sell_note`
--

CREATE TABLE `buy_sell_note` (
  `id` int(11) NOT NULL,
  `buy_sell_id` int(11) NOT NULL,
  `company_id` int(11) NOT NULL,
  `note` text NOT NULL,
  `data_insert` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `buy_sell_refresh_amo_search`
--

CREATE TABLE `buy_sell_refresh_amo_search` (
  `id` int(11) NOT NULL COMMENT 'cm. cron_amo_buy_sell_search.php',
  `company_id` int(11) NOT NULL,
  `buy_sell_id` int(11) NOT NULL,
  `data_insert` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `buy_sell_share`
--

CREATE TABLE `buy_sell_share` (
  `id` int(11) NOT NULL,
  `company_id_to` int(11) NOT NULL COMMENT 'компания которой отправили',
  `email` varchar(255) DEFAULT NULL COMMENT 'кому отправляем ссылки',
  `share_url` varchar(32) NOT NULL,
  `name` varchar(255) DEFAULT NULL,
  `comments` varchar(255) DEFAULT NULL,
  `company_id_from` int(11) NOT NULL,
  `data_insert` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `buy_sell_share_ids`
--

CREATE TABLE `buy_sell_share_ids` (
  `id` int(11) NOT NULL,
  `buy_sell_share_id` int(11) NOT NULL,
  `buy_sell_id` int(11) NOT NULL,
  `data_insert` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `cards`
--

CREATE TABLE `cards` (
  `id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `keywords` varchar(255) NOT NULL,
  `description` varchar(255) NOT NULL,
  `login_id` int(11) NOT NULL,
  `slug` varchar(255) NOT NULL,
  `description_card` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `card_attributes`
--

CREATE TABLE `card_attributes` (
  `id` int(11) NOT NULL,
  `card_id` int(11) NOT NULL,
  `attribute_id` int(11) NOT NULL,
  `value` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `card_files`
--

CREATE TABLE `card_files` (
  `id` int(11) NOT NULL,
  `card_id` int(11) NOT NULL,
  `path` varchar(255) NOT NULL,
  `type` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `categories_attribute`
--

CREATE TABLE `categories_attribute` (
  `id` int(11) NOT NULL,
  `categories_id` int(11) NOT NULL,
  `attribute_id` int(11) NOT NULL,
  `buy_type_attribute_id` int(11) NOT NULL DEFAULT '0',
  `sell_type_attribute_id` int(11) NOT NULL DEFAULT '0',
  `no_empty_buy` int(11) NOT NULL DEFAULT '0',
  `no_empty_sell` int(11) NOT NULL DEFAULT '0',
  `sort` int(11) NOT NULL,
  `grouping_sell` tinyint(1) NOT NULL DEFAULT '0',
  `assets` tinyint(1) NOT NULL DEFAULT '0',
  `data_insert` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `chat`
--

CREATE TABLE `chat` (
  `id` int(11) NOT NULL,
  `type` int(11) NOT NULL DEFAULT '1',
  `name` text,
  `archive` tinyint(1) DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `chat_attachment`
--

CREATE TABLE `chat_attachment` (
  `id` int(11) NOT NULL,
  `type` varchar(255) NOT NULL,
  `message_id` int(11) NOT NULL,
  `link` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `chat_messages`
--

CREATE TABLE `chat_messages` (
  `id` int(11) NOT NULL,
  `chat_id` int(11) NOT NULL,
  `user_sent_id` int(11) NOT NULL,
  `user_to_id` int(11) NOT NULL,
  `message` text,
  `isRead` binary(1) NOT NULL DEFAULT '0',
  `date` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `type` int(11) NOT NULL DEFAULT '1'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `chat_users`
--

CREATE TABLE `chat_users` (
  `id` int(11) NOT NULL,
  `chat_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `company`
--

CREATE TABLE `company` (
  `id` int(11) NOT NULL,
  `login_id` int(11) NOT NULL,
  `flag_account` tinyint(1) NOT NULL DEFAULT '0' COMMENT '1-профиль (аккаунт зарегистрированного пользователя), 2 - компания, 3-несущест.поставщик',
  `legal_entity_id` tinyint(1) NOT NULL,
  `company` varchar(150) NOT NULL,
  `email` varchar(100) DEFAULT NULL,
  `iti_phone` varchar(5) DEFAULT NULL,
  `phone` decimal(13,0) DEFAULT NULL,
  `position` varchar(100) DEFAULT NULL,
  `tax_system_id` tinyint(4) NOT NULL DEFAULT '1',
  `who1` tinyint(1) NOT NULL DEFAULT '0' COMMENT 'sell',
  `who2` tinyint(1) NOT NULL DEFAULT '0' COMMENT 'buy',
  `avatar` varchar(100) DEFAULT NULL,
  `cities_id` int(11) NOT NULL,
  `comments` text,
  `pro_mode` tinyint(1) NOT NULL DEFAULT '0',
  `id_1c` varchar(50) DEFAULT NULL COMMENT 'identifikator kompanii iz 1C',
  `active` tinyint(1) NOT NULL DEFAULT '1' COMMENT '2 - companiya ne aktivna (nigde ne vidna)',
  `data_insert` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `skip` int(11) DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `company_balance`
--

CREATE TABLE `company_balance` (
  `id` int(11) NOT NULL,
  `company_id` int(11) DEFAULT NULL,
  `total` int(11) DEFAULT NULL,
  `type` int(11) DEFAULT NULL,
  `data_insert` timestamp NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `company_categories`
--

CREATE TABLE `company_categories` (
  `id` int(11) NOT NULL,
  `company_id` int(11) NOT NULL,
  `categories_id` int(11) NOT NULL,
  `data_insert` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `company_details`
--

CREATE TABLE `company_details` (
  `id` int(11) NOT NULL,
  `company_id` int(11) DEFAULT '0',
  `name` varchar(1024) DEFAULT NULL,
  `inn` varchar(50) DEFAULT NULL,
  `kpp` varchar(50) DEFAULT NULL,
  `rschet` varchar(50) DEFAULT NULL,
  `bik` varchar(50) DEFAULT NULL,
  `korr_schet` varchar(50) DEFAULT NULL,
  `ur_adr` varchar(1024) DEFAULT NULL,
  `type_skills` int(11) DEFAULT NULL,
  `data_insert` timestamp NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='Rekvizity dlya scheta';

-- --------------------------------------------------------

--
-- Table structure for table `company_form_payment`
--

CREATE TABLE `company_form_payment` (
  `id` int(11) NOT NULL,
  `company_id` int(11) NOT NULL,
  `form_payment_id` tinyint(1) NOT NULL,
  `coefficient` decimal(10,1) NOT NULL,
  `data_insert` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `company_last_session`
--

CREATE TABLE `company_last_session` (
  `id` int(11) NOT NULL,
  `login_id` int(11) NOT NULL,
  `company_id` int(11) NOT NULL,
  `data_insert` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `company_page_visited_send`
--

CREATE TABLE `company_page_visited_send` (
  `id` int(11) NOT NULL,
  `login_id` int(11) NOT NULL,
  `company_id` int(11) NOT NULL,
  `page_id` int(11) NOT NULL,
  `data_visited` datetime DEFAULT NULL,
  `data_last_send_email` datetime DEFAULT NULL COMMENT 'data otpravki pisma na pochtu o novoy zayavke'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `company_qrq`
--

CREATE TABLE `company_qrq` (
  `id` int(11) NOT NULL COMMENT 'dayet ponimanie kto iz company uchastvuet v etp',
  `company_id` int(11) NOT NULL,
  `login` varchar(255) NOT NULL,
  `pass` varchar(255) NOT NULL,
  `data_insert` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `company_vip_function`
--

CREATE TABLE `company_vip_function` (
  `id` int(11) NOT NULL,
  `company_id` int(11) NOT NULL,
  `vip_function_id` int(11) NOT NULL,
  `data_insert` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `counter_buysellone`
--

CREATE TABLE `counter_buysellone` (
  `id` int(11) NOT NULL,
  `login_id` int(11) NOT NULL,
  `company_id` int(11) NOT NULL,
  `buy_sell_id` int(11) NOT NULL,
  `data_insert` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `counter_buysellone_ip`
--

CREATE TABLE `counter_buysellone_ip` (
  `id` int(11) NOT NULL,
  `buy_sell_id` int(11) NOT NULL,
  `ip` varchar(20) NOT NULL,
  `data_insert` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `cron_amo_buy_sell`
--

CREATE TABLE `cron_amo_buy_sell` (
  `id` int(11) NOT NULL,
  `buy_sell_id` int(11) NOT NULL,
  `token` varchar(50) NOT NULL,
  `data_insert` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `cron_amo_buy_sell_search`
--

CREATE TABLE `cron_amo_buy_sell_search` (
  `id` int(11) NOT NULL,
  `buy_sell_id` int(11) NOT NULL,
  `token` varchar(50) NOT NULL,
  `brand` varchar(250) NOT NULL,
  `searchtext` varchar(250) NOT NULL,
  `data_insert` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `cron_amo_buy_sell_searchupdate`
--

CREATE TABLE `cron_amo_buy_sell_searchupdate` (
  `id` int(11) NOT NULL,
  `buy_sell_id` int(11) NOT NULL,
  `token` varchar(50) NOT NULL,
  `searchid` varchar(50) NOT NULL,
  `flag_delete` tinyint(4) NOT NULL COMMENT '1-nelzya udalit pri povtornom vizovi chera cron',
  `data_insert` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `cron_amo_buy_sell_search_infopart`
--

CREATE TABLE `cron_amo_buy_sell_search_infopart` (
  `id` int(11) NOT NULL,
  `token` varchar(50) NOT NULL,
  `searchid` varchar(50) NOT NULL COMMENT 'ubrat brand, searchtext, accountid (teper asinhrono)',
  `categories_id` int(11) NOT NULL,
  `company_id_out` int(11) NOT NULL COMMENT 'kompaniya zaprosivshaya predlojenie',
  `cookie_session` varchar(50) NOT NULL COMMENT 'cookie kompaniya zaprosivshaya predlojenie',
  `data_insert` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `finished` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `cron_new_buysell`
--

CREATE TABLE `cron_new_buysell` (
  `id` int(11) NOT NULL,
  `buy_sell_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `cron_qrq_buy_sell`
--

CREATE TABLE `cron_qrq_buy_sell` (
  `id` int(11) NOT NULL,
  `buy_sell_id` int(11) NOT NULL,
  `data_insert` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `cron_qrq_buy_sell_result`
--

CREATE TABLE `cron_qrq_buy_sell_result` (
  `id` int(11) NOT NULL,
  `buy_sell_id` int(11) NOT NULL,
  `qrq_id` int(11) NOT NULL,
  `article_id` varchar(250) NOT NULL,
  `brand` varchar(250) DEFAULT NULL,
  `data_insert` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `history_buy_sell`
--

CREATE TABLE `history_buy_sell` (
  `id` int(11) NOT NULL,
  `buy_sell_id` int(11) NOT NULL,
  `login_id` int(11) NOT NULL COMMENT 'kto vnes izmeneniya',
  `value_new` varchar(255) DEFAULT NULL,
  `value_old` varchar(255) DEFAULT NULL,
  `comments` varchar(255) NOT NULL,
  `data_insert` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `interests_company_param`
--

CREATE TABLE `interests_company_param` (
  `id` int(11) NOT NULL,
  `login_id` int(11) NOT NULL,
  `company_id` int(11) NOT NULL,
  `interests_id` int(11) NOT NULL COMMENT 'svyazivauchiy id tid`ov (unique dlya interests_param_id)',
  `interests_param_id` int(11) NOT NULL,
  `tid` int(11) NOT NULL,
  `views` tinyint(1) NOT NULL DEFAULT '1' COMMENT 'kakie pokazivat v spiske',
  `flag` tinyint(1) NOT NULL DEFAULT '1' COMMENT '1-company, 2-invite',
  `data_insert` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `invite_workers`
--

CREATE TABLE `invite_workers` (
  `id` int(11) NOT NULL,
  `company_id` int(11) NOT NULL,
  `email` varchar(255) NOT NULL,
  `name` varchar(255) NOT NULL,
  `position` varchar(255) NOT NULL,
  `prava_id` int(11) NOT NULL,
  `data_insert` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `login`
--

CREATE TABLE `login` (
  `id` int(11) NOT NULL,
  `email` varchar(100) NOT NULL,
  `pass` varchar(50) NOT NULL,
  `who1` tinyint(1) NOT NULL,
  `who2` tinyint(1) NOT NULL,
  `active` tinyint(1) NOT NULL DEFAULT '2',
  `data_insert` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `login_company_prava`
--

CREATE TABLE `login_company_prava` (
  `id` int(11) NOT NULL,
  `login_id` int(11) NOT NULL,
  `company_id` int(11) NOT NULL,
  `prava_id` int(11) NOT NULL,
  `position` varchar(255) DEFAULT NULL,
  `data_insert` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `menu`
--

CREATE TABLE `menu` (
  `id` smallint(6) NOT NULL,
  `parent_id` smallint(6) NOT NULL DEFAULT '0',
  `flag` tinyint(1) NOT NULL DEFAULT '1' COMMENT '1-left_menu,2-используется для доступа',
  `href` varchar(30) NOT NULL,
  `menu` varchar(50) NOT NULL,
  `title` varchar(50) DEFAULT NULL,
  `active` tinyint(1) NOT NULL,
  `sort` smallint(2) NOT NULL,
  `icon` varchar(50) DEFAULT NULL,
  `need` tinyint(1) NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `menu_prava`
--

CREATE TABLE `menu_prava` (
  `id` int(11) NOT NULL,
  `prava_id` int(11) NOT NULL,
  `menu_id` smallint(11) NOT NULL,
  `data_insert` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `nomenclature`
--

CREATE TABLE `nomenclature` (
  `id` int(11) NOT NULL,
  `login_id` int(11) NOT NULL,
  `company_id` int(11) NOT NULL,
  `name` varchar(250) NOT NULL,
  `categories_id` int(11) NOT NULL,
  `1c_nomenclature_id` int(11) NOT NULL DEFAULT '0',
  `data_insert` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `nomenclature_amo_searchbrend`
--

CREATE TABLE `nomenclature_amo_searchbrend` (
  `id` int(11) NOT NULL,
  `nomenclature_id` int(11) NOT NULL,
  `brand` varchar(255) NOT NULL,
  `data_insert` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `nomenclature_attribute`
--

CREATE TABLE `nomenclature_attribute` (
  `id` int(11) NOT NULL,
  `nomenclature_id` int(11) NOT NULL,
  `attribute_id` int(11) NOT NULL,
  `attribute_value_id` int(11) DEFAULT NULL,
  `value` varchar(250) DEFAULT NULL,
  `data_insert` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `nosend_email`
--

CREATE TABLE `nosend_email` (
  `id` int(11) NOT NULL COMMENT 'blockirovka email ot otpravki',
  `email` varchar(250) NOT NULL,
  `data_insert` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `notification`
--

CREATE TABLE `notification` (
  `id` int(11) NOT NULL,
  `notification_id` int(11) NOT NULL,
  `login_id` int(11) NOT NULL,
  `company_id` int(11) NOT NULL,
  `tid` int(11) NOT NULL COMMENT 'id - po konkretnomu uvedomleniu',
  `data_insert` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Triggers `notification`
--
DELIMITER $$
CREATE TRIGGER `trigger_notification_insert` AFTER INSERT ON `notification` FOR EACH ROW BEGIN
		INSERT INTO notification_cron_send_1800(notification_id,login_id,company_id,tid) 
		VALUES (NEW.notification_id, NEW.login_id, NEW.company_id, NEW.tid);
    END
$$
DELIMITER ;

-- --------------------------------------------------------

--
-- Table structure for table `notification_company_param`
--

CREATE TABLE `notification_company_param` (
  `id` int(11) NOT NULL,
  `login_id` int(11) NOT NULL,
  `company_id` int(11) NOT NULL,
  `flag` tinyint(1) NOT NULL COMMENT '1-na sayte, 2-na email',
  `notification_id` int(11) NOT NULL,
  `notification_param_id` tinyint(4) NOT NULL,
  `data_insert` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `notification_cron_send_1800`
--

CREATE TABLE `notification_cron_send_1800` (
  `id` int(11) NOT NULL,
  `notification_id` int(11) NOT NULL,
  `login_id` int(11) NOT NULL,
  `company_id` int(11) NOT NULL,
  `tid` int(11) NOT NULL,
  `data_insert` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `notification_logo_propustit`
--

CREATE TABLE `notification_logo_propustit` (
  `id` int(11) NOT NULL COMMENT 'propustit uvedomlenie u logo_',
  `company_id` int(11) NOT NULL,
  `flag` int(11) NOT NULL COMMENT 'chto propuskaem 1-nomenclature1c, 2-company1c',
  `tid` int(11) NOT NULL COMMENT 'id kotoroe propuskaem, v uvedomlenie',
  `data_insert` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `pro_invoices`
--

CREATE TABLE `pro_invoices` (
  `id` int(11) NOT NULL,
  `company_id` int(11) NOT NULL DEFAULT '0',
  `summ` int(20) NOT NULL DEFAULT '0',
  `type_s` tinyint(1) DEFAULT NULL,
  `paid` tinyint(1) DEFAULT '0',
  `paymentId` varchar(50) DEFAULT NULL,
  `data_insert` timestamp NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `qrq_html_question`
--

CREATE TABLE `qrq_html_question` (
  `id` int(11) NOT NULL,
  `buy_sell_id` int(11) NOT NULL,
  `qrq_id` int(11) NOT NULL,
  `html_question` text NOT NULL,
  `data_insert` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `qrq_html_question_search`
--

CREATE TABLE `qrq_html_question_search` (
  `id` int(11) NOT NULL,
  `session_id` varchar(50) NOT NULL,
  `qrq_id` int(11) NOT NULL,
  `html_question` text NOT NULL,
  `data_insert` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `route`
--

CREATE TABLE `route` (
  `id` int(11) NOT NULL,
  `route` varchar(255) NOT NULL,
  `class` varchar(255) NOT NULL,
  `data_insert` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `search_categories`
--

CREATE TABLE `search_categories` (
  `id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `categories_id` int(11) NOT NULL,
  `data_insert` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `search_categories_attribute`
--

CREATE TABLE `search_categories_attribute` (
  `id` int(11) NOT NULL,
  `search_categories_id` int(11) NOT NULL,
  `attribute_id` int(11) NOT NULL,
  `attribute_value_id` int(11) DEFAULT NULL,
  `value` text,
  `data_insert` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `search_filter_param_company`
--

CREATE TABLE `search_filter_param_company` (
  `id` int(11) NOT NULL,
  `login_id` int(11) NOT NULL DEFAULT '0',
  `company_id` int(11) NOT NULL DEFAULT '0',
  `cookie_session` varchar(50) NOT NULL,
  `flag_search` tinyint(1) NOT NULL DEFAULT '0',
  `categories_id` int(11) NOT NULL DEFAULT '0',
  `cities_id` int(11) NOT NULL DEFAULT '0',
  `flag` int(11) NOT NULL DEFAULT '2',
  `flag_interest` tinyint(1) NOT NULL DEFAULT '0',
  `sort_12` tinyint(1) NOT NULL DEFAULT '1' COMMENT '1-up , 2-down',
  `sort_who` varchar(20) NOT NULL DEFAULT 'sort_date',
  `data_insert` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `flag_buy_sell` tinyint(1) DEFAULT '2' COMMENT 'UBRAT vremenno'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `search_request`
--

CREATE TABLE `search_request` (
  `id` int(11) NOT NULL,
  `flag_pole` tinyint(2) NOT NULL,
  `categories_id` int(11) NOT NULL,
  `value` varchar(100) NOT NULL,
  `data_insert` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `slov_attribute`
--

CREATE TABLE `slov_attribute` (
  `id` int(11) NOT NULL,
  `attribute` varchar(255) NOT NULL,
  `active` tinyint(1) NOT NULL DEFAULT '1',
  `sort` int(11) NOT NULL,
  `data_insert` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `slov_attribute_value`
--

CREATE TABLE `slov_attribute_value` (
  `id` int(11) NOT NULL,
  `attribute_id` int(11) NOT NULL,
  `attribute_value` varchar(255) NOT NULL,
  `sort` int(11) DEFAULT NULL,
  `flag_insert` tinyint(11) NOT NULL DEFAULT '1',
  `company_id` int(11) NOT NULL DEFAULT '0',
  `data_insert` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `slov_categories`
--

CREATE TABLE `slov_categories` (
  `id` int(11) NOT NULL,
  `parent_id` int(11) NOT NULL DEFAULT '0',
  `categories` varchar(255) NOT NULL,
  `url_categories` varchar(255) NOT NULL,
  `level` tinyint(4) NOT NULL,
  `unit_id` tinyint(2) NOT NULL,
  `unit_group_id` tinyint(2) NOT NULL DEFAULT '0' COMMENT 'vtoraya edinica izmereniya (slov_unit_group)',
  `limit_sell` int(11) NOT NULL DEFAULT '1' COMMENT 'limit kolichestvo obyavleniy',
  `limit_buy` int(11) NOT NULL DEFAULT '1' COMMENT 'limit kolichestvo zayavok',
  `desc_sell` text NOT NULL,
  `desc_buy` text NOT NULL,
  `keywords_buy` varchar(1024) NOT NULL,
  `keywords_sell` varchar(1024) NOT NULL,
  `description_buy` varchar(1024) NOT NULL,
  `description_sell` varchar(1024) NOT NULL,
  `active` tinyint(1) NOT NULL DEFAULT '1',
  `no_empty_name` tinyint(1) NOT NULL DEFAULT '0' COMMENT 'required pole naimenovanie',
  `no_empty_file` tinyint(1) NOT NULL DEFAULT '0' COMMENT 'required pole files (uploader)',
  `assets` tinyint(1) NOT NULL DEFAULT '0',
  `sort` int(11) NOT NULL,
  `data_insert` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `slov_currency`
--

CREATE TABLE `slov_currency` (
  `id` tinyint(1) NOT NULL,
  `currency` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `slov_delivery`
--

CREATE TABLE `slov_delivery` (
  `id` int(11) NOT NULL,
  `delivery` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `slov_flag_buy_sell`
--

CREATE TABLE `slov_flag_buy_sell` (
  `id` tinyint(2) NOT NULL,
  `flag_buy_sell` varchar(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `slov_form_payment`
--

CREATE TABLE `slov_form_payment` (
  `id` tinyint(1) NOT NULL,
  `form_payment` varchar(10) NOT NULL,
  `coefficient2` decimal(10,1) NOT NULL COMMENT 'tax_system_id=2',
  `coefficient3` decimal(10,1) NOT NULL COMMENT 'tax_system_id=3',
  `coefficient4` decimal(10,1) NOT NULL COMMENT 'tax_system_id=4'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `slov_interests_param`
--

CREATE TABLE `slov_interests_param` (
  `id` int(11) NOT NULL,
  `interests_param` varchar(20) NOT NULL,
  `sql_value` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `slov_legal_entity`
--

CREATE TABLE `slov_legal_entity` (
  `id` tinyint(4) NOT NULL,
  `legal_entity` varchar(5) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `slov_notification`
--

CREATE TABLE `slov_notification` (
  `id` int(11) NOT NULL,
  `parent_id` int(11) NOT NULL,
  `notification` varchar(100) NOT NULL,
  `notification_email` varchar(100) DEFAULT NULL,
  `sort` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `slov_notification_param`
--

CREATE TABLE `slov_notification_param` (
  `id` tinyint(1) NOT NULL,
  `notification_param` varchar(30) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `slov_page`
--

CREATE TABLE `slov_page` (
  `id` int(11) NOT NULL,
  `page` varchar(50) NOT NULL,
  `comments` varchar(100) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `slov_prava`
--

CREATE TABLE `slov_prava` (
  `id` int(11) NOT NULL,
  `flag` tinyint(2) NOT NULL,
  `nprava` varchar(255) NOT NULL,
  `z_comments` varchar(255) NOT NULL,
  `data_insert` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `slov_qrq`
--

CREATE TABLE `slov_qrq` (
  `id` int(11) NOT NULL,
  `qrq` varchar(250) NOT NULL,
  `company_id` int(11) NOT NULL,
  `vendorid` varchar(100) NOT NULL,
  `flag_autorize` tinyint(1) NOT NULL DEFAULT '0' COMMENT '1-bez vhoda',
  `promo` tinyint(1) NOT NULL DEFAULT '0' COMMENT '1-uchavstvuet v promo',
  `data_insert` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `slov_status_buy_sell`
--

CREATE TABLE `slov_status_buy_sell` (
  `id` tinyint(2) NOT NULL,
  `flag` tinyint(1) NOT NULL DEFAULT '1' COMMENT '1-Zayavki/Obyavl , 2-Offer',
  `status_buy` varchar(20) NOT NULL,
  `status_buy2` varchar(20) NOT NULL,
  `status_sell` varchar(20) NOT NULL,
  `status_sell2` varchar(20) NOT NULL,
  `status_bs_count` varchar(20) DEFAULT NULL,
  `sort` tinyint(2) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `slov_tax_system`
--

CREATE TABLE `slov_tax_system` (
  `id` tinyint(4) NOT NULL,
  `tax_system` varchar(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `slov_type_attribute`
--

CREATE TABLE `slov_type_attribute` (
  `id` int(11) NOT NULL,
  `type_attribute` varchar(255) NOT NULL,
  `flag_value` tinyint(1) NOT NULL COMMENT '1-svayz po id , 2-vvodimoe znachenie'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `slov_unit`
--

CREATE TABLE `slov_unit` (
  `id` tinyint(2) NOT NULL,
  `unit` varchar(20) NOT NULL,
  `unit_group_id` tinyint(2) NOT NULL DEFAULT '0',
  `sort` int(11) NOT NULL DEFAULT '0',
  `okei` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `slov_unit_formula`
--

CREATE TABLE `slov_unit_formula` (
  `id` tinyint(2) NOT NULL,
  `unit_id` tinyint(2) NOT NULL,
  `unit_id1` tinyint(2) NOT NULL,
  `formula` varchar(20) NOT NULL DEFAULT '{NUMBER}'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `slov_unit_group`
--

CREATE TABLE `slov_unit_group` (
  `id` tinyint(2) NOT NULL,
  `unit_group` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `slov_urgency`
--

CREATE TABLE `slov_urgency` (
  `id` tinyint(4) NOT NULL,
  `urgency` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `slov_vip_function`
--

CREATE TABLE `slov_vip_function` (
  `id` int(11) NOT NULL,
  `function` varchar(100) NOT NULL,
  `data_insert` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `sms_logs`
--

CREATE TABLE `sms_logs` (
  `id` int(11) NOT NULL,
  `login_id` int(11) NOT NULL,
  `sms_id` int(11) NOT NULL,
  `status_code` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `stock`
--

CREATE TABLE `stock` (
  `id` int(11) NOT NULL,
  `company_id` int(11) NOT NULL,
  `stock` varchar(255) NOT NULL,
  `address` varchar(255) NOT NULL,
  `1c_stock_id` int(11) NOT NULL DEFAULT '0',
  `data_insert` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `subscriptions`
--

CREATE TABLE `subscriptions` (
  `id` int(11) NOT NULL,
  `company_id_in` int(11) NOT NULL COMMENT 'kto podpisan',
  `company_id_out` int(11) NOT NULL COMMENT 'na kogo podpisan',
  `data_insert` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `subscriptions_no_autorize`
--

CREATE TABLE `subscriptions_no_autorize` (
  `id` int(11) NOT NULL,
  `company_id_from` int(11) NOT NULL,
  `cookie_session` varchar(50) NOT NULL,
  `data_insert` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `tickets`
--

CREATE TABLE `tickets` (
  `id` int(11) NOT NULL,
  `folder_id` int(11) NOT NULL,
  `company_id` int(11) NOT NULL,
  `companies` varchar(50) NOT NULL,
  `ticket_exp` text NOT NULL,
  `ticket_status` int(11) NOT NULL,
  `attachments` varchar(40) NOT NULL,
  `data_insert` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `chatId` text,
  `ggg` json NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `tickets2`
--

CREATE TABLE `tickets2` (
  `id` int(11) NOT NULL,
  `owner_id` int(11) NOT NULL DEFAULT '0',
  `ticket_exp` text NOT NULL,
  `ticket_flag` int(11) NOT NULL,
  `status` tinyint(4) NOT NULL DEFAULT '1',
  `vazh` int(11) DEFAULT NULL,
  `inv` varchar(50) DEFAULT NULL,
  `data_insert` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `tickets2_change_options_rules`
--

CREATE TABLE `tickets2_change_options_rules` (
  `id` int(11) NOT NULL,
  `status_1` int(11) NOT NULL,
  `status_2` int(11) NOT NULL,
  `roles` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `tickets2_files`
--

CREATE TABLE `tickets2_files` (
  `id` int(11) NOT NULL,
  `file_name` varchar(50) NOT NULL,
  `ticket_id` int(20) NOT NULL,
  `data_insert` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `tickets2_history`
--

CREATE TABLE `tickets2_history` (
  `id` int(11) NOT NULL,
  `ticket_id` int(11) NOT NULL,
  `status1` int(11) NOT NULL,
  `status2` int(11) NOT NULL,
  `flag` tinyint(4) NOT NULL DEFAULT '0',
  `user_id` int(11) NOT NULL,
  `data_insert` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `tickets2_status`
--

CREATE TABLE `tickets2_status` (
  `id` int(11) NOT NULL,
  `status_name` varchar(50) NOT NULL,
  `status_name_out` varchar(50) NOT NULL,
  `status_class` varchar(50) NOT NULL,
  `prava` tinyint(4) NOT NULL,
  `active` tinyint(4) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `tickets_files`
--

CREATE TABLE `tickets_files` (
  `id` int(11) NOT NULL,
  `name` varchar(50) NOT NULL DEFAULT '0',
  `message_id` int(20) NOT NULL,
  `data_added` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `tickets_folder`
--

CREATE TABLE `tickets_folder` (
  `id` int(11) NOT NULL,
  `folder_name` varchar(50) DEFAULT NULL,
  `owner_id` int(11) NOT NULL,
  `status` tinyint(4) NOT NULL,
  `companies_id` varchar(50) NOT NULL,
  `avatar` varchar(50) DEFAULT NULL,
  `need` varchar(256) NOT NULL,
  `uniq` varchar(50) NOT NULL,
  `flag` tinyint(4) DEFAULT '0',
  `data_insert` timestamp NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `tickets_logs`
--

CREATE TABLE `tickets_logs` (
  `id` int(11) NOT NULL,
  `text` varchar(50) DEFAULT NULL,
  `company_id` int(11) NOT NULL,
  `action` tinyint(1) NOT NULL COMMENT '1 - insert \r\n2 - delete \r\n3 - update \r\n4 - add to chat \r\n5 - remove from chat ',
  `object` tinyint(1) NOT NULL COMMENT '0 - folder \r\n1 - message ',
  `object_id` int(11) NOT NULL,
  `data_insert` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Stand-in structure for view `view_counter_buysellone`
-- (See below for the actual view)
--
CREATE TABLE `view_counter_buysellone` (
`buy_sell_id` int(11)
,`kol` decimal(42,0)
);

-- --------------------------------------------------------

--
-- Stand-in structure for view `view_grouping_id_kol_page_sell`
-- (See below for the actual view)
--
CREATE TABLE `view_grouping_id_kol_page_sell` (
`val` text
,`kol` bigint(21)
,`buy_sell_id` int(11)
,`min_cost` decimal(10,2)
,`attribute_ids` text
);

-- --------------------------------------------------------

--
-- Stand-in structure for view `view_grouping_id_val_offer`
-- (See below for the actual view)
--
CREATE TABLE `view_grouping_id_val_offer` (
`buy_sell_id` int(11)
,`parent_id` int(11)
,`val` varchar(341)
);

-- --------------------------------------------------------

--
-- Stand-in structure for view `view_grouping_id_val_page_sell`
-- (See below for the actual view)
--
CREATE TABLE `view_grouping_id_val_page_sell` (
`buy_sell_id` int(11)
,`val` text
);

-- --------------------------------------------------------

--
-- Stand-in structure for view `view_grouping_kol_offer`
-- (See below for the actual view)
--
CREATE TABLE `view_grouping_kol_offer` (
`parent_id` int(11)
,`val` mediumtext
,`kol` bigint(21)
,`cost` decimal(10,2)
,`buy_sell_id` int(11)
);

-- --------------------------------------------------------

--
-- Stand-in structure for view `view_mybuysell_OLD`
-- (See below for the actual view)
--
CREATE TABLE `view_mybuysell_OLD` (
`active` tinyint(1)
,`flag` tinyint(1)
,`id` int(11)
,`parent_id` int(11)
,`copy_id` int(11)
,`login_id` int(11)
,`company_id` int(11)
,`company_id2` int(11)
,`flag_buy_sell` tinyint(1)
,`name` varchar(255)
,`url` varchar(255)
,`status_buy_sell_id` tinyint(2)
,`urgency_id` tinyint(4)
,`form_payment_id` tinyint(1)
,`categories_id` int(11)
,`cost` decimal(10,2)
,`currency_id` tinyint(1)
,`amount` decimal(10,2)
,`comments` text
,`comments_company` varchar(255)
,`responsible_id` int(11)
,`nomenclature_id` int(11)
,`responsible` varchar(150)
,`availability` varchar(11)
,`form_payment` varchar(10)
,`cities_name` varchar(50)
,`url_cities` varchar(100)
,`company` varchar(150)
,`company2` varchar(150)
,`id_shleyf` bigint(11)
,`categories` varchar(255)
,`url_categories` varchar(255)
,`urgency` varchar(50)
,`status_buy2` varchar(20)
,`status_sell2` varchar(20)
,`unit` varchar(20)
,`currency` varchar(50)
,`ndata_insert` varchar(67)
,`data_status_buy_sell_23` varchar(67)
,`day_noactive` int(7)
,`flag_offer_min_cost` varbinary(46)
,`flag_offer_min_cost2` varbinary(46)
,`kol_notification_offer` bigint(21)
,`kol_notification` bigint(11)
,`kol_status11` varbinary(34)
,`kol_status12` decimal(32,2)
,`kol_photo` bigint(21)
,`kol_views` decimal(42,0)
);

-- --------------------------------------------------------

--
-- Table structure for table `z_slov_flag_account`
--

CREATE TABLE `z_slov_flag_account` (
  `id` tinyint(2) DEFAULT NULL,
  `name` varchar(100) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `z_slov_flag_insert_slov_attribute_value`
--

CREATE TABLE `z_slov_flag_insert_slov_attribute_value` (
  `id` tinyint(4) NOT NULL,
  `flag_insert` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Structure for view `view_counter_buysellone`
--
DROP TABLE IF EXISTS `view_counter_buysellone`;

CREATE ALGORITHM=UNDEFINED DEFINER=`dailysnab_db`@`%` SQL SECURITY DEFINER VIEW `view_counter_buysellone`  AS   (select `qw`.`id` AS `buy_sell_id`,sum(`qw`.`kol`) AS `kol` from (select `bs`.`id` AS `id`,count(`cb`.`id`) AS `kol` from (`counter_buysellone` `cb` join `buy_sell` `bs`) where (`cb`.`buy_sell_id` = `bs`.`id`) group by `bs`.`id` union all select `bs`.`id` AS `id`,count(`cb`.`id`) AS `kol` from (`counter_buysellone_ip` `cb` join `buy_sell` `bs`) where (`cb`.`buy_sell_id` = `bs`.`id`) group by `bs`.`id`) `qw` group by `qw`.`id`)  ;

-- --------------------------------------------------------

--
-- Structure for view `view_grouping_id_kol_page_sell`
--
DROP TABLE IF EXISTS `view_grouping_id_kol_page_sell`;

CREATE ALGORITHM=UNDEFINED DEFINER=`dailysnab_db`@`%` SQL SECURITY DEFINER VIEW `view_grouping_id_kol_page_sell`  AS   (select `qw`.`val` AS `val`,count(`qw`.`buy_sell_id`) AS `kol`,`qw`.`buy_sell_id` AS `buy_sell_id`,min(`qw`.`cost`) AS `min_cost`,`qw`.`attribute_ids` AS `attribute_ids` from (select `bsa`.`buy_sell_id` AS `buy_sell_id`,group_concat(ifnull(`bsa`.`value`,`bsa`.`attribute_value_id`) separator ',') AS `val`,group_concat(`bsa`.`attribute_id` separator ',') AS `attribute_ids`,`bs`.`cost` AS `cost` from (`buy_sell` `bs` join `buy_sell_attribute` `bsa`) where ((`bsa`.`buy_sell_id` = `bs`.`id`) and (`bs`.`parent_id` = 0) and `bsa`.`attribute_id` in (select `ca`.`attribute_id` from `categories_attribute` `ca` where ((`ca`.`categories_id` = `bs`.`categories_id`) and (`ca`.`grouping_sell` = 1))) and (`bs`.`flag_buy_sell` = 1) and (`bs`.`status_buy_sell_id` in (2,3))) group by `bsa`.`buy_sell_id` order by group_concat(ifnull(`bsa`.`value`,`bsa`.`attribute_value_id`) separator ','),`bs`.`data_status_buy_sell_23` desc) `qw` group by `qw`.`val`)  ;

-- --------------------------------------------------------

--
-- Structure for view `view_grouping_id_val_offer`
--
DROP TABLE IF EXISTS `view_grouping_id_val_offer`;

CREATE ALGORITHM=UNDEFINED DEFINER=`dailysnab_db`@`%` SQL SECURITY DEFINER VIEW `view_grouping_id_val_offer`  AS   (select `bs`.`id` AS `buy_sell_id`,`bs`.`parent_id` AS `parent_id`,ifnull(group_concat((case when (`bsa`.`attribute_value_id` <> '') then `bsa`.`attribute_value_id` else `bsa`.`value` end) separator ','),'vdo_qrq_vdo') AS `val` from (`buy_sell` `bs` left join `buy_sell_attribute` `bsa` on(((`bsa`.`buy_sell_id` = `bs`.`id`) and `bsa`.`attribute_id` in (select `ca`.`attribute_id` from `categories_attribute` `ca` where ((`ca`.`categories_id` = `bs`.`categories_id`) and (`ca`.`grouping_sell` = 1)))))) where ((`bs`.`flag_buy_sell` = 2) and (`bs`.`status_buy_sell_id` = 10)) group by `bs`.`id`,`bs`.`parent_id`)  ;

-- --------------------------------------------------------

--
-- Structure for view `view_grouping_id_val_page_sell`
--
DROP TABLE IF EXISTS `view_grouping_id_val_page_sell`;

CREATE ALGORITHM=UNDEFINED DEFINER=`dailysnab_db`@`%` SQL SECURITY DEFINER VIEW `view_grouping_id_val_page_sell`  AS   (select `bsa`.`buy_sell_id` AS `buy_sell_id`,group_concat(ifnull(`bsa`.`value`,`bsa`.`attribute_value_id`) separator ',') AS `val` from (`buy_sell` `bs` join `buy_sell_attribute` `bsa`) where ((`bsa`.`buy_sell_id` = `bs`.`id`) and (`bs`.`parent_id` = 0) and `bsa`.`attribute_id` in (select `ca`.`attribute_id` from `categories_attribute` `ca` where ((`ca`.`categories_id` = `bs`.`categories_id`) and (`ca`.`grouping_sell` = 1))) and (`bs`.`flag_buy_sell` = 1) and (`bs`.`status_buy_sell_id` in (2,3))) group by `bsa`.`buy_sell_id` order by group_concat(ifnull(`bsa`.`value`,`bsa`.`attribute_value_id`) separator ','),`bs`.`cost`)  ;

-- --------------------------------------------------------

--
-- Structure for view `view_grouping_kol_offer`
--
DROP TABLE IF EXISTS `view_grouping_kol_offer`;

CREATE ALGORITHM=UNDEFINED DEFINER=`dailysnab_db`@`%` SQL SECURITY DEFINER VIEW `view_grouping_kol_offer`  AS   (select `qw`.`parent_id` AS `parent_id`,ifnull(`qw`.`val`,'vdo_qrq_vdo') AS `val`,count(`qw`.`parent_id`) AS `kol`,min(`qw`.`cost`) AS `cost`,`qw`.`id` AS `buy_sell_id` from (select `bs`.`id` AS `id`,`bs`.`parent_id` AS `parent_id`,`bs`.`cost` AS `cost`,group_concat((case when (`bsa`.`attribute_value_id` <> '') then `bsa`.`attribute_value_id` else `bsa`.`value` end) separator ',') AS `val` from (`buy_sell` `bs` left join `buy_sell_attribute` `bsa` on(((`bsa`.`buy_sell_id` = `bs`.`id`) and `bsa`.`attribute_id` in (select `ca`.`attribute_id` from `categories_attribute` `ca` where ((`ca`.`categories_id` = `bs`.`categories_id`) and (`ca`.`grouping_sell` = 1)))))) where ((`bs`.`flag_buy_sell` = 2) and (`bs`.`status_buy_sell_id` = 10)) group by `bs`.`id`,`bs`.`parent_id` order by group_concat(ifnull(`bsa`.`value`,`bsa`.`attribute_value_id`) separator ','),`bs`.`cost`) `qw` group by `qw`.`parent_id`,`qw`.`val`)  ;

-- --------------------------------------------------------

--
-- Structure for view `view_mybuysell_OLD`
--
DROP TABLE IF EXISTS `view_mybuysell_OLD`;

CREATE ALGORITHM=UNDEFINED DEFINER=`dailysnab_db`@`%` SQL SECURITY DEFINER VIEW `view_mybuysell_OLD`  AS   (select `bs`.`active` AS `active`,`sbs`.`flag` AS `flag`,`bs`.`id` AS `id`,`bs`.`parent_id` AS `parent_id`,`bs`.`copy_id` AS `copy_id`,`bs`.`login_id` AS `login_id`,`bs`.`company_id` AS `company_id`,`bs`.`company_id2` AS `company_id2`,`bs`.`flag_buy_sell` AS `flag_buy_sell`,`bs`.`name` AS `name`,`bs`.`url` AS `url`,`bs`.`status_buy_sell_id` AS `status_buy_sell_id`,`bs`.`urgency_id` AS `urgency_id`,`bs`.`form_payment_id` AS `form_payment_id`,`bs`.`categories_id` AS `categories_id`,`bs`.`cost` AS `cost`,`bs`.`currency_id` AS `currency_id`,`bs`.`amount` AS `amount`,`bs`.`comments` AS `comments`,`bs`.`comments_company` AS `comments_company`,`bs`.`responsible_id` AS `responsible_id`,`bs`.`nomenclature_id` AS `nomenclature_id`,(select `cr`.`company` from `company` `cr` where (`cr`.`id` = `bs`.`responsible_id`)) AS `responsible`,(case when (`bs`.`availability` = 0) then '' else `bs`.`availability` end) AS `availability`,`sfp`.`form_payment` AS `form_payment`,`cities`.`name` AS `cities_name`,`cities`.`url_cities` AS `url_cities`,`c`.`company` AS `company`,`c2`.`company` AS `company2`,(select `t`.`id` from `buy_sell` `t` where ((`t`.`parent_id` = `bs`.`id`) and (`t`.`status_buy_sell_id` = 7)) limit 1) AS `id_shleyf`,`sc`.`categories` AS `categories`,`sc`.`url_categories` AS `url_categories`,`su`.`urgency` AS `urgency`,`sbs`.`status_buy2` AS `status_buy2`,`sbs`.`status_sell2` AS `status_sell2`,`sunit`.`unit` AS `unit`,`scurrency`.`currency` AS `currency`,date_format(`bs`.`data_insert`,'%d %M') AS `ndata_insert`,date_format(`bs`.`data_status_buy_sell_23`,'%d %M') AS `data_status_buy_sell_23`,(select (to_days((`bs`.`data_status_buy_sell_23` + interval 30 day)) - to_days(now()))) AS `day_noactive`,(select concat(min(`t`.`cost`),'*',count(`t`.`id`),'*',`t`.`parent_id`) from `buy_sell` `t` where ((`t`.`parent_id` = `bs`.`id`) and (`t`.`status_buy_sell_id` = 10)) limit 1) AS `flag_offer_min_cost`,(select concat(min(`t`.`cost`),'*',count(`t`.`id`),'*',`t`.`parent_id`) from `buy_sell` `t` where ((`t`.`parent_id` = (select `t`.`parent_id` from `buy_sell` `t` where `t`.`id` in (select `t`.`copy_id` from `buy_sell` `t` where ((`t`.`id` = `bs`.`id`) and (`t`.`status_buy_sell_id` in (11,12)))))) and (`t`.`status_buy_sell_id` = 10)) limit 1) AS `flag_offer_min_cost2`,(select count(`bs0`.`parent_id`) from `buy_sell` `bs0` where (((`bs0`.`parent_id` = `bs`.`id`) or (`bs0`.`parent_id` = (select `t`.`parent_id` from `buy_sell` `t` where (`t`.`id` = (select `tt`.`copy_id` from `buy_sell` `tt` where (`tt`.`id` = `bs`.`id`)))))) and `bs0`.`id` in (select `t`.`tid` from `notification` `t` where ((`t`.`notification_id` = 2) and (`t`.`login_id` = '.LOGIN_ID.') and (`t`.`company_id` = '.COMPANY_ID.'))))) AS `kol_notification_offer`,(select `t`.`tid` from `notification` `t` where ((`t`.`tid` = `bs`.`id`) and (`t`.`login_id` = '.LOGIN_ID.') and (`t`.`company_id` = '.COMPANY_ID.')) limit 1) AS `kol_notification`,(case when ((`bs`.`status_buy_sell_id` = 2) or (`bs`.`status_buy_sell_id` = 3)) then (select sum(`t`.`amount`) from `buy_sell` `t` where (`t`.`parent_id` in (select `tt`.`id` from `buy_sell` `tt` where (`tt`.`parent_id` = `bs`.`id`)) and (`t`.`status_buy_sell_id` = 11))) else '' end) AS `kol_status11`,(select sum(`t`.`amount`) from `buy_sell` `t` where ((`t`.`parent_id` = `bs`.`id`) and (`t`.`status_buy_sell_id` = 12))) AS `kol_status12`,(select count(`t`.`id`) from `buy_sell_files` `t` where (`t`.`buy_sell_id` = `bs`.`id`)) AS `kol_photo`,(select `vcb`.`kol` from `view_counter_buysellone` `vcb` where (`vcb`.`buy_sell_id` = `bs`.`id`)) AS `kol_views` from (((((((`company` `c` join `a_cities` `cities`) join `slov_categories` `sc`) join `slov_urgency` `su`) join `slov_status_buy_sell` `sbs`) join `slov_unit` `sunit`) join `slov_currency` `scurrency`) join ((`buy_sell` `bs` left join `slov_form_payment` `sfp` on((`sfp`.`id` = `bs`.`form_payment_id`))) left join `company` `c2` on((`c2`.`id` = `bs`.`company_id2`)))) where ((`bs`.`company_id` = `c`.`id`) and (`cities`.`id` = `bs`.`cities_id`) and (`bs`.`categories_id` = `sc`.`id`) and (`bs`.`urgency_id` = `su`.`id`) and (`sbs`.`id` = `bs`.`status_buy_sell_id`) and (`sc`.`unit_id` = `sunit`.`id`) and (`bs`.`currency_id` = `scurrency`.`id`)) order by (case when (`bs`.`data_status_buy_sell_23` > `bs`.`data_insert`) then `bs`.`data_status_buy_sell_23` else `bs`.`data_insert` end) desc)  ;

--
-- Indexes for dumped tables
--

--
-- Indexes for table `1c_company`
--
ALTER TABLE `1c_company`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `NewIndex1` (`id_1c`,`company_id`),
  ADD KEY `FK_1c_company_company_id` (`company_id`);

--
-- Indexes for table `1c_company_company`
--
ALTER TABLE `1c_company_company`
  ADD PRIMARY KEY (`id`),
  ADD KEY `FK_1c_company_company_company_id` (`company_id`),
  ADD KEY `FK_1c_company_company_company_id_to` (`company_id_to`),
  ADD KEY `FK_1c_company_company_1c_company_id` (`1c_company_id`);

--
-- Indexes for table `1c_nomenclature`
--
ALTER TABLE `1c_nomenclature`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `NewIndex1` (`id_1c`,`company_id`),
  ADD KEY `FK_1c_nomenclature_company_id` (`company_id`),
  ADD KEY `NewIndex2` (`data_1c`);

--
-- Indexes for table `1c_nomenclature_out`
--
ALTER TABLE `1c_nomenclature_out`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `FK_1c_nomenclature_out` (`nomenclature_id`);

--
-- Indexes for table `1c_nomost`
--
ALTER TABLE `1c_nomost`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `NewIndex1` (`nomenclature_id`,`stock_id`),
  ADD KEY `FK_1c_nomost` (`company_id`),
  ADD KEY `FK_1c_nomost_stock_id` (`stock_id`);

--
-- Indexes for table `1c_outbuy11`
--
ALTER TABLE `1c_outbuy11`
  ADD PRIMARY KEY (`id`),
  ADD KEY `FK_1c_outbuy11_buy_sell_id` (`buy_sell_id`);

--
-- Indexes for table `1c_outbuy12`
--
ALTER TABLE `1c_outbuy12`
  ADD PRIMARY KEY (`id`),
  ADD KEY `FK_1c_outbuy12` (`buy_sell_id`);

--
-- Indexes for table `1c_refresh_all`
--
ALTER TABLE `1c_refresh_all`
  ADD PRIMARY KEY (`id`),
  ADD KEY `FK_1c_refresh_all` (`company_id`);

--
-- Indexes for table `1c_slov_unit`
--
ALTER TABLE `1c_slov_unit`
  ADD PRIMARY KEY (`id`),
  ADD KEY `NewIndex1` (`measure_id`),
  ADD KEY `FK_tmp_1c_slov_unit_company_id` (`company_id`);

--
-- Indexes for table `1c_stock`
--
ALTER TABLE `1c_stock`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `NewIndex1` (`id_1c`,`company_id`),
  ADD KEY `FK_1c_stock_company_id` (`company_id`);

--
-- Indexes for table `1c_transport`
--
ALTER TABLE `1c_transport`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `1c_transport_buy_sell`
--
ALTER TABLE `1c_transport_buy_sell`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `NewIndex1` (`buy_sell_id`,`1c_transport_id`),
  ADD KEY `FK_1c_transport_buy_sell_1c_transport_id` (`1c_transport_id`);

--
-- Indexes for table `1c_typenom`
--
ALTER TABLE `1c_typenom`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `NewIndex1` (`id_1c`,`company_id`),
  ADD KEY `FK_tmp_1c_typenom_company_id` (`company_id`);

--
-- Indexes for table `1c_typenom_categoies`
--
ALTER TABLE `1c_typenom_categoies`
  ADD PRIMARY KEY (`id`),
  ADD KEY `FK_1c_typenom_categoies` (`company_id`),
  ADD KEY `FK_1c_typenom_categoies_categories_id` (`categories_id`),
  ADD KEY `FK_1c_typenom_categoies_1c_typenom_id` (`1c_typenom_id`);

--
-- Indexes for table `amo_accounts_basket_param`
--
ALTER TABLE `amo_accounts_basket_param`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `NewIndex1` (`accounts_id`);

--
-- Indexes for table `amo_accounts_etp`
--
ALTER TABLE `amo_accounts_etp`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `NewIndex1` (`company_id`,`qrq_id`),
  ADD KEY `FK_amo_accounts_etp_qrq_id` (`qrq_id`);

--
-- Indexes for table `amo_accounts_old11062022`
--
ALTER TABLE `amo_accounts_old11062022`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `NewIndex1` (`company_id`,`vendorid`,`parent_id`);

--
-- Indexes for table `amo_cities`
--
ALTER TABLE `amo_cities`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `amo_cities_cities_id`
--
ALTER TABLE `amo_cities_cities_id`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `NewIndex1` (`cities_id`,`amo_cities_id`);

--
-- Indexes for table `amo_html_searchbrend`
--
ALTER TABLE `amo_html_searchbrend`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `amo_log_json`
--
ALTER TABLE `amo_log_json`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `amo_name_error_etp`
--
ALTER TABLE `amo_name_error_etp`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `attribute_value`
--
ALTER TABLE `attribute_value`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `NewIndex1` (`attribute_id`,`attribute_value_id`,`categories_id`) USING BTREE,
  ADD KEY `FK_attribute_value` (`attribute_value_id`),
  ADD KEY `FK_attribute_value_categories_id` (`categories_id`);

--
-- Indexes for table `a_cities`
--
ALTER TABLE `a_cities`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `unique` (`regions_id`,`name`,`ru_type`,`ru_path`),
  ADD KEY `regions_id` (`regions_id`),
  ADD KEY `name` (`name`),
  ADD KEY `NewIndex1` (`regions_id`,`name`);

--
-- Indexes for table `buy_sell`
--
ALTER TABLE `buy_sell`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `NewIndex2` (`url`),
  ADD KEY `FK_buy_sell_slov_categories` (`categories_id`),
  ADD KEY `FK_buy_sell_a_cities` (`cities_id`),
  ADD KEY `FK_buy_sell_slov_urgency` (`urgency_id`),
  ADD KEY `FK_buy_sell_company_id` (`company_id`),
  ADD KEY `NewIndex1` (`parent_id`),
  ADD KEY `FK_buy_sell_status_buy_sell_id` (`status_buy_sell_id`),
  ADD KEY `FK_buy_sell_company_id2` (`company_id2`),
  ADD KEY `NewIndex3` (`parent_id`,`company_id`),
  ADD KEY `NewIndex4` (`flag_buy_sell`,`status_buy_sell_id`),
  ADD KEY `FK_buy_sell_currency_id` (`currency_id`),
  ADD KEY `FK_buy_sell` (`login_id`),
  ADD KEY `NewIndex5` (`parent_id`,`status_buy_sell_id`),
  ADD KEY `NewIndex6` (`company_id`,`flag_buy_sell`,`active`),
  ADD KEY `NewIndex7` (`data_insert`),
  ADD KEY `NewIndex8` (`nomenclature_id`);

--
-- Indexes for table `buy_sell_1c`
--
ALTER TABLE `buy_sell_1c`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `NewIndex1` (`id_1c`),
  ADD KEY `FK_buy_sell_1c_buy_sell_id` (`buy_sell_id`),
  ADD KEY `FK_buy_sell_1c` (`company_id`);

--
-- Indexes for table `buy_sell_attribute`
--
ALTER TABLE `buy_sell_attribute`
  ADD PRIMARY KEY (`id`),
  ADD KEY `FK_buy_sell_attribute_slov_attribute` (`attribute_id`),
  ADD KEY `NewIndex1` (`buy_sell_id`,`attribute_id`),
  ADD KEY `NewIndex2` (`attribute_value_id`);

--
-- Indexes for table `buy_sell_cache`
--
ALTER TABLE `buy_sell_cache`
  ADD PRIMARY KEY (`id`),
  ADD KEY `FK_buy_sell_cache_buy_sell_id` (`buy_sell_id`);

--
-- Indexes for table `buy_sell_cookie`
--
ALTER TABLE `buy_sell_cookie`
  ADD PRIMARY KEY (`id`),
  ADD KEY `FK_buy_sell_cookie_buy_sell_id` (`buy_sell_id`);

--
-- Indexes for table `buy_sell_etp_sell`
--
ALTER TABLE `buy_sell_etp_sell`
  ADD PRIMARY KEY (`id`),
  ADD KEY `FK_buy_sell_etp_sell_buy_sell_id` (`buy_sell_id`),
  ADD KEY `NewIndex1` (`cookie_session`),
  ADD KEY `NewIndex2` (`company_id`,`cookie_session`);

--
-- Indexes for table `buy_sell_files`
--
ALTER TABLE `buy_sell_files`
  ADD PRIMARY KEY (`id`),
  ADD KEY `FK_buy_sell_files` (`buy_sell_id`);

--
-- Indexes for table `buy_sell_note`
--
ALTER TABLE `buy_sell_note`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `NewIndex1` (`buy_sell_id`,`company_id`),
  ADD KEY `FK_buy_sell_note_company_id` (`company_id`);

--
-- Indexes for table `buy_sell_refresh_amo_search`
--
ALTER TABLE `buy_sell_refresh_amo_search`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `buy_sell_share`
--
ALTER TABLE `buy_sell_share`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `NewIndex1` (`share_url`),
  ADD KEY `FK_buy_sell_share_company_id_from` (`company_id_from`);

--
-- Indexes for table `buy_sell_share_ids`
--
ALTER TABLE `buy_sell_share_ids`
  ADD PRIMARY KEY (`id`),
  ADD KEY `FK_buy_sell_share` (`buy_sell_id`),
  ADD KEY `FK_buy_sell_share_ids` (`buy_sell_share_id`);

--
-- Indexes for table `cards`
--
ALTER TABLE `cards`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `card_attributes`
--
ALTER TABLE `card_attributes`
  ADD PRIMARY KEY (`id`),
  ADD KEY `card_attributes_fk0` (`card_id`),
  ADD KEY `attribute_id` (`attribute_id`);

--
-- Indexes for table `card_files`
--
ALTER TABLE `card_files`
  ADD PRIMARY KEY (`id`),
  ADD KEY `card_files_fk0` (`card_id`);

--
-- Indexes for table `categories_attribute`
--
ALTER TABLE `categories_attribute`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `NewIndex1` (`categories_id`,`attribute_id`) USING BTREE,
  ADD KEY `FK_categories_attribute_attribute` (`attribute_id`);

--
-- Indexes for table `chat`
--
ALTER TABLE `chat`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `chat_attachment`
--
ALTER TABLE `chat_attachment`
  ADD PRIMARY KEY (`id`),
  ADD KEY `chat_attachment_fk0` (`message_id`);

--
-- Indexes for table `chat_messages`
--
ALTER TABLE `chat_messages`
  ADD PRIMARY KEY (`id`),
  ADD KEY `chat_messages_fk0` (`chat_id`);

--
-- Indexes for table `chat_users`
--
ALTER TABLE `chat_users`
  ADD PRIMARY KEY (`id`),
  ADD KEY `chat_users_fk0` (`chat_id`);

--
-- Indexes for table `company`
--
ALTER TABLE `company`
  ADD PRIMARY KEY (`id`),
  ADD KEY `FK_company_login_id` (`login_id`),
  ADD KEY `FK_company_legal_entity_id` (`legal_entity_id`),
  ADD KEY `FK_company` (`cities_id`);

--
-- Indexes for table `company_balance`
--
ALTER TABLE `company_balance`
  ADD PRIMARY KEY (`id`) USING BTREE;

--
-- Indexes for table `company_categories`
--
ALTER TABLE `company_categories`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `NewIndex1` (`company_id`,`categories_id`),
  ADD KEY `FK_company_categories_categories_id` (`categories_id`);

--
-- Indexes for table `company_details`
--
ALTER TABLE `company_details`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `company_form_payment`
--
ALTER TABLE `company_form_payment`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `NewIndex1` (`company_id`,`form_payment_id`),
  ADD KEY `FK_company_form_payment_form_payment_id` (`form_payment_id`);

--
-- Indexes for table `company_last_session`
--
ALTER TABLE `company_last_session`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `NewIndex1` (`login_id`,`company_id`),
  ADD KEY `FK_company_last_session_company_id` (`company_id`),
  ADD KEY `NewIndex2` (`login_id`);

--
-- Indexes for table `company_page_visited_send`
--
ALTER TABLE `company_page_visited_send`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `NewIndex1` (`company_id`,`page_id`,`login_id`),
  ADD KEY `FK_page_visited_send_page_visited_send_id` (`page_id`),
  ADD KEY `FK_company_page_visited_send_login_id` (`login_id`);

--
-- Indexes for table `company_qrq`
--
ALTER TABLE `company_qrq`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `FK_company_qrq` (`company_id`);

--
-- Indexes for table `company_vip_function`
--
ALTER TABLE `company_vip_function`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `NewIndex1` (`company_id`,`vip_function_id`),
  ADD KEY `FK_company_vip_function_vip_function_id` (`vip_function_id`);

--
-- Indexes for table `counter_buysellone`
--
ALTER TABLE `counter_buysellone`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `NewIndex1` (`login_id`,`company_id`,`buy_sell_id`),
  ADD KEY `FK_counter_buysellone_company_id` (`company_id`),
  ADD KEY `FK_counter_buysellone` (`buy_sell_id`);

--
-- Indexes for table `counter_buysellone_ip`
--
ALTER TABLE `counter_buysellone_ip`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `NewIndex1` (`buy_sell_id`,`ip`);

--
-- Indexes for table `cron_amo_buy_sell`
--
ALTER TABLE `cron_amo_buy_sell`
  ADD PRIMARY KEY (`id`),
  ADD KEY `FK_cron_amo_buy_sell` (`buy_sell_id`);

--
-- Indexes for table `cron_amo_buy_sell_search`
--
ALTER TABLE `cron_amo_buy_sell_search`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `cron_amo_buy_sell_searchupdate`
--
ALTER TABLE `cron_amo_buy_sell_searchupdate`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `NewIndex1` (`searchid`),
  ADD KEY `FK_cron_amo_buy_sell_searchupdate` (`buy_sell_id`);

--
-- Indexes for table `cron_amo_buy_sell_search_infopart`
--
ALTER TABLE `cron_amo_buy_sell_search_infopart`
  ADD PRIMARY KEY (`id`),
  ADD KEY `FK_cron_amo_buy_sell_search_infopart` (`categories_id`);

--
-- Indexes for table `cron_new_buysell`
--
ALTER TABLE `cron_new_buysell`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `cron_qrq_buy_sell`
--
ALTER TABLE `cron_qrq_buy_sell`
  ADD PRIMARY KEY (`id`),
  ADD KEY `FK_cron_qrq_buy_sell_but_sell_id` (`buy_sell_id`);

--
-- Indexes for table `cron_qrq_buy_sell_result`
--
ALTER TABLE `cron_qrq_buy_sell_result`
  ADD PRIMARY KEY (`id`),
  ADD KEY `FK_cron_qrq_buy_sell_result_buy_sell_id` (`buy_sell_id`);

--
-- Indexes for table `history_buy_sell`
--
ALTER TABLE `history_buy_sell`
  ADD PRIMARY KEY (`id`),
  ADD KEY `NewIndex1` (`buy_sell_id`),
  ADD KEY `FK_history_buy_sell_login_id` (`login_id`);

--
-- Indexes for table `interests_company_param`
--
ALTER TABLE `interests_company_param`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `NewIndex1` (`company_id`,`interests_id`,`interests_param_id`,`tid`),
  ADD KEY `FK_interests_company_param_interests_param_id` (`interests_param_id`),
  ADD KEY `NewIndex2` (`company_id`,`interests_param_id`);

--
-- Indexes for table `invite_workers`
--
ALTER TABLE `invite_workers`
  ADD PRIMARY KEY (`id`),
  ADD KEY `FK_invite_workers_company_id` (`company_id`),
  ADD KEY `FK_invite_workers_prava_id` (`prava_id`);

--
-- Indexes for table `login`
--
ALTER TABLE `login`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `login_company_prava`
--
ALTER TABLE `login_company_prava`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `NewIndex1` (`login_id`,`company_id`),
  ADD KEY `FK_login_company_prava_company_id` (`company_id`);

--
-- Indexes for table `menu`
--
ALTER TABLE `menu`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `menu_prava`
--
ALTER TABLE `menu_prava`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `NewIndex1` (`prava_id`,`menu_id`),
  ADD KEY `FK_prava_menu_login_id` (`prava_id`),
  ADD KEY `FK_prava_menu_menu_id` (`menu_id`);

--
-- Indexes for table `nomenclature`
--
ALTER TABLE `nomenclature`
  ADD PRIMARY KEY (`id`),
  ADD KEY `FK_nomenclature_company_id` (`company_id`),
  ADD KEY `FK_nomenclature_login_id` (`login_id`),
  ADD KEY `FK_nomenclature` (`categories_id`),
  ADD KEY `NewIndex1` (`1c_nomenclature_id`);

--
-- Indexes for table `nomenclature_amo_searchbrend`
--
ALTER TABLE `nomenclature_amo_searchbrend`
  ADD PRIMARY KEY (`id`),
  ADD KEY `FK_nomenclature_amo_searchbrend` (`nomenclature_id`);

--
-- Indexes for table `nomenclature_attribute`
--
ALTER TABLE `nomenclature_attribute`
  ADD PRIMARY KEY (`id`),
  ADD KEY `FK_nomenclature_attribute_nomenclature_id` (`nomenclature_id`),
  ADD KEY `FK_nomenclature_attribute_attribute_id` (`attribute_id`);

--
-- Indexes for table `nosend_email`
--
ALTER TABLE `nosend_email`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `NewIndex1` (`email`);

--
-- Indexes for table `notification`
--
ALTER TABLE `notification`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `NewIndex1` (`notification_id`,`login_id`,`company_id`,`tid`),
  ADD KEY `FK_notification_company_id` (`company_id`),
  ADD KEY `FK_notification_login_id` (`login_id`);

--
-- Indexes for table `notification_company_param`
--
ALTER TABLE `notification_company_param`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `NewIndex1` (`company_id`,`flag`,`notification_id`,`login_id`),
  ADD KEY `FK_notification_company_param_notification_id` (`notification_id`),
  ADD KEY `FK_notification_company_param_notification_param_id` (`notification_param_id`);

--
-- Indexes for table `notification_cron_send_1800`
--
ALTER TABLE `notification_cron_send_1800`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `NewIndex1` (`notification_id`,`company_id`,`tid`,`login_id`),
  ADD KEY `FK_notification_cron_send_1800_company_id` (`company_id`),
  ADD KEY `FK_notification_cron_send_1800_login_id` (`login_id`);

--
-- Indexes for table `notification_logo_propustit`
--
ALTER TABLE `notification_logo_propustit`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `NewIndex2` (`company_id`,`flag`,`tid`),
  ADD KEY `NewIndex1` (`tid`);

--
-- Indexes for table `pro_invoices`
--
ALTER TABLE `pro_invoices`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `qrq_html_question`
--
ALTER TABLE `qrq_html_question`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `NewIndex1` (`buy_sell_id`,`qrq_id`),
  ADD KEY `FK_qrq_html_question` (`qrq_id`);

--
-- Indexes for table `qrq_html_question_search`
--
ALTER TABLE `qrq_html_question_search`
  ADD PRIMARY KEY (`id`),
  ADD KEY `FK_qrq_html_question_search_qrq_id` (`qrq_id`);

--
-- Indexes for table `route`
--
ALTER TABLE `route`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `NewIndex1` (`route`);

--
-- Indexes for table `search_categories`
--
ALTER TABLE `search_categories`
  ADD PRIMARY KEY (`id`),
  ADD KEY `FK_search_categories` (`categories_id`);

--
-- Indexes for table `search_categories_attribute`
--
ALTER TABLE `search_categories_attribute`
  ADD PRIMARY KEY (`id`),
  ADD KEY `FK_search_categories_attribute` (`search_categories_id`);

--
-- Indexes for table `search_filter_param_company`
--
ALTER TABLE `search_filter_param_company`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `NewIndex1` (`login_id`,`company_id`,`cookie_session`),
  ADD KEY `FK_search_filter_param_company_company_id` (`company_id`),
  ADD KEY `FK_search_filter_param_company` (`categories_id`);

--
-- Indexes for table `search_request`
--
ALTER TABLE `search_request`
  ADD PRIMARY KEY (`id`),
  ADD KEY `NewIndex1` (`flag_pole`,`categories_id`,`value`);

--
-- Indexes for table `slov_attribute`
--
ALTER TABLE `slov_attribute`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `slov_attribute_value`
--
ALTER TABLE `slov_attribute_value`
  ADD PRIMARY KEY (`id`),
  ADD KEY `NewIndex1` (`attribute_id`),
  ADD KEY `FK_slov_attribute_value_flag_insert` (`flag_insert`);

--
-- Indexes for table `slov_categories`
--
ALTER TABLE `slov_categories`
  ADD PRIMARY KEY (`id`),
  ADD KEY `NewIndex1` (`parent_id`),
  ADD KEY `FK_slov_categories_unit_id` (`unit_id`);

--
-- Indexes for table `slov_currency`
--
ALTER TABLE `slov_currency`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `slov_delivery`
--
ALTER TABLE `slov_delivery`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `slov_flag_buy_sell`
--
ALTER TABLE `slov_flag_buy_sell`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `slov_form_payment`
--
ALTER TABLE `slov_form_payment`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `slov_interests_param`
--
ALTER TABLE `slov_interests_param`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `slov_legal_entity`
--
ALTER TABLE `slov_legal_entity`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `slov_notification`
--
ALTER TABLE `slov_notification`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `slov_notification_param`
--
ALTER TABLE `slov_notification_param`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `slov_page`
--
ALTER TABLE `slov_page`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `slov_prava`
--
ALTER TABLE `slov_prava`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `slov_qrq`
--
ALTER TABLE `slov_qrq`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `NewIndex1` (`vendorid`),
  ADD KEY `NewIndex2` (`company_id`);

--
-- Indexes for table `slov_status_buy_sell`
--
ALTER TABLE `slov_status_buy_sell`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `slov_tax_system`
--
ALTER TABLE `slov_tax_system`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `slov_type_attribute`
--
ALTER TABLE `slov_type_attribute`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `slov_unit`
--
ALTER TABLE `slov_unit`
  ADD PRIMARY KEY (`id`),
  ADD KEY `NewIndex1` (`okei`);

--
-- Indexes for table `slov_unit_formula`
--
ALTER TABLE `slov_unit_formula`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `NewIndex1` (`unit_id`,`unit_id1`),
  ADD KEY `FK_slov_unit_formula_unit_id1` (`unit_id1`);

--
-- Indexes for table `slov_unit_group`
--
ALTER TABLE `slov_unit_group`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `slov_urgency`
--
ALTER TABLE `slov_urgency`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `slov_vip_function`
--
ALTER TABLE `slov_vip_function`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `sms_logs`
--
ALTER TABLE `sms_logs`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `stock`
--
ALTER TABLE `stock`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `subscriptions`
--
ALTER TABLE `subscriptions`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `NewIndex1` (`company_id_in`,`company_id_out`),
  ADD KEY `FK_subscriptions_company_id_out` (`company_id_out`),
  ADD KEY `NewIndex2` (`company_id_in`);

--
-- Indexes for table `subscriptions_no_autorize`
--
ALTER TABLE `subscriptions_no_autorize`
  ADD PRIMARY KEY (`id`),
  ADD KEY `FK_subscriptions_no_autorize_company_id_from` (`company_id_from`);

--
-- Indexes for table `tickets`
--
ALTER TABLE `tickets`
  ADD PRIMARY KEY (`id`),
  ADD KEY `company_id` (`company_id`);

--
-- Indexes for table `tickets2`
--
ALTER TABLE `tickets2`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `tickets2_change_options_rules`
--
ALTER TABLE `tickets2_change_options_rules`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `tickets2_files`
--
ALTER TABLE `tickets2_files`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `tickets2_history`
--
ALTER TABLE `tickets2_history`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `tickets2_status`
--
ALTER TABLE `tickets2_status`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `tickets_files`
--
ALTER TABLE `tickets_files`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `tickets_folder`
--
ALTER TABLE `tickets_folder`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `tickets_logs`
--
ALTER TABLE `tickets_logs`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `z_slov_flag_insert_slov_attribute_value`
--
ALTER TABLE `z_slov_flag_insert_slov_attribute_value`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `1c_company`
--
ALTER TABLE `1c_company`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `1c_company_company`
--
ALTER TABLE `1c_company_company`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `1c_nomenclature`
--
ALTER TABLE `1c_nomenclature`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `1c_nomenclature_out`
--
ALTER TABLE `1c_nomenclature_out`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `1c_nomost`
--
ALTER TABLE `1c_nomost`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `1c_outbuy11`
--
ALTER TABLE `1c_outbuy11`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `1c_outbuy12`
--
ALTER TABLE `1c_outbuy12`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `1c_refresh_all`
--
ALTER TABLE `1c_refresh_all`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `1c_slov_unit`
--
ALTER TABLE `1c_slov_unit`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `1c_stock`
--
ALTER TABLE `1c_stock`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `1c_transport`
--
ALTER TABLE `1c_transport`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `1c_transport_buy_sell`
--
ALTER TABLE `1c_transport_buy_sell`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `1c_typenom`
--
ALTER TABLE `1c_typenom`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `1c_typenom_categoies`
--
ALTER TABLE `1c_typenom_categoies`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `amo_accounts_basket_param`
--
ALTER TABLE `amo_accounts_basket_param`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `amo_accounts_etp`
--
ALTER TABLE `amo_accounts_etp`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT COMMENT 'NOVAYA VERSIYA ETP';

--
-- AUTO_INCREMENT for table `amo_accounts_old11062022`
--
ALTER TABLE `amo_accounts_old11062022`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT COMMENT 'STATRAYA VERSIYA';

--
-- AUTO_INCREMENT for table `amo_cities_cities_id`
--
ALTER TABLE `amo_cities_cities_id`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT COMMENT 'svyaz gorodov etp s nashimi';

--
-- AUTO_INCREMENT for table `amo_html_searchbrend`
--
ALTER TABLE `amo_html_searchbrend`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `amo_log_json`
--
ALTER TABLE `amo_log_json`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `amo_name_error_etp`
--
ALTER TABLE `amo_name_error_etp`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT COMMENT 'oshbki etp dlya obrabotki v sisteme';

--
-- AUTO_INCREMENT for table `attribute_value`
--
ALTER TABLE `attribute_value`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `a_cities`
--
ALTER TABLE `a_cities`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `buy_sell_1c`
--
ALTER TABLE `buy_sell_1c`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `buy_sell_attribute`
--
ALTER TABLE `buy_sell_attribute`
  MODIFY `id` bigint(21) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `buy_sell_cache`
--
ALTER TABLE `buy_sell_cache`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `buy_sell_cookie`
--
ALTER TABLE `buy_sell_cookie`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `buy_sell_etp_sell`
--
ALTER TABLE `buy_sell_etp_sell`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT COMMENT 'obyavleniya(predlojeniya) s etp poluchenie polzovatelem';

--
-- AUTO_INCREMENT for table `buy_sell_files`
--
ALTER TABLE `buy_sell_files`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `buy_sell_note`
--
ALTER TABLE `buy_sell_note`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `buy_sell_refresh_amo_search`
--
ALTER TABLE `buy_sell_refresh_amo_search`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT COMMENT 'cm. cron_amo_buy_sell_search.php';

--
-- AUTO_INCREMENT for table `buy_sell_share`
--
ALTER TABLE `buy_sell_share`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `buy_sell_share_ids`
--
ALTER TABLE `buy_sell_share_ids`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `cards`
--
ALTER TABLE `cards`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `card_attributes`
--
ALTER TABLE `card_attributes`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `card_files`
--
ALTER TABLE `card_files`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `categories_attribute`
--
ALTER TABLE `categories_attribute`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `chat`
--
ALTER TABLE `chat`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `chat_attachment`
--
ALTER TABLE `chat_attachment`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `chat_messages`
--
ALTER TABLE `chat_messages`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `chat_users`
--
ALTER TABLE `chat_users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `company`
--
ALTER TABLE `company`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `company_balance`
--
ALTER TABLE `company_balance`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `company_categories`
--
ALTER TABLE `company_categories`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `company_details`
--
ALTER TABLE `company_details`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `company_form_payment`
--
ALTER TABLE `company_form_payment`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `company_last_session`
--
ALTER TABLE `company_last_session`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `company_page_visited_send`
--
ALTER TABLE `company_page_visited_send`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `company_qrq`
--
ALTER TABLE `company_qrq`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT COMMENT 'dayet ponimanie kto iz company uchastvuet v etp';

--
-- AUTO_INCREMENT for table `company_vip_function`
--
ALTER TABLE `company_vip_function`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `counter_buysellone`
--
ALTER TABLE `counter_buysellone`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `counter_buysellone_ip`
--
ALTER TABLE `counter_buysellone_ip`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `cron_amo_buy_sell`
--
ALTER TABLE `cron_amo_buy_sell`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `cron_amo_buy_sell_search`
--
ALTER TABLE `cron_amo_buy_sell_search`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `cron_amo_buy_sell_searchupdate`
--
ALTER TABLE `cron_amo_buy_sell_searchupdate`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `cron_amo_buy_sell_search_infopart`
--
ALTER TABLE `cron_amo_buy_sell_search_infopart`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `cron_new_buysell`
--
ALTER TABLE `cron_new_buysell`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `cron_qrq_buy_sell`
--
ALTER TABLE `cron_qrq_buy_sell`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `cron_qrq_buy_sell_result`
--
ALTER TABLE `cron_qrq_buy_sell_result`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `history_buy_sell`
--
ALTER TABLE `history_buy_sell`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `interests_company_param`
--
ALTER TABLE `interests_company_param`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `invite_workers`
--
ALTER TABLE `invite_workers`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `login`
--
ALTER TABLE `login`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `login_company_prava`
--
ALTER TABLE `login_company_prava`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `menu`
--
ALTER TABLE `menu`
  MODIFY `id` smallint(6) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `menu_prava`
--
ALTER TABLE `menu_prava`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `nomenclature`
--
ALTER TABLE `nomenclature`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `nomenclature_amo_searchbrend`
--
ALTER TABLE `nomenclature_amo_searchbrend`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `nomenclature_attribute`
--
ALTER TABLE `nomenclature_attribute`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `nosend_email`
--
ALTER TABLE `nosend_email`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT COMMENT 'blockirovka email ot otpravki';

--
-- AUTO_INCREMENT for table `notification`
--
ALTER TABLE `notification`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `notification_company_param`
--
ALTER TABLE `notification_company_param`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `notification_cron_send_1800`
--
ALTER TABLE `notification_cron_send_1800`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `notification_logo_propustit`
--
ALTER TABLE `notification_logo_propustit`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT COMMENT 'propustit uvedomlenie u logo_';

--
-- AUTO_INCREMENT for table `pro_invoices`
--
ALTER TABLE `pro_invoices`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `qrq_html_question`
--
ALTER TABLE `qrq_html_question`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `qrq_html_question_search`
--
ALTER TABLE `qrq_html_question_search`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `route`
--
ALTER TABLE `route`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `search_categories`
--
ALTER TABLE `search_categories`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `search_categories_attribute`
--
ALTER TABLE `search_categories_attribute`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `search_filter_param_company`
--
ALTER TABLE `search_filter_param_company`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `search_request`
--
ALTER TABLE `search_request`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `slov_attribute`
--
ALTER TABLE `slov_attribute`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `slov_attribute_value`
--
ALTER TABLE `slov_attribute_value`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `slov_categories`
--
ALTER TABLE `slov_categories`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `slov_currency`
--
ALTER TABLE `slov_currency`
  MODIFY `id` tinyint(1) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `slov_delivery`
--
ALTER TABLE `slov_delivery`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `slov_interests_param`
--
ALTER TABLE `slov_interests_param`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `slov_legal_entity`
--
ALTER TABLE `slov_legal_entity`
  MODIFY `id` tinyint(4) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `slov_notification`
--
ALTER TABLE `slov_notification`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `slov_notification_param`
--
ALTER TABLE `slov_notification_param`
  MODIFY `id` tinyint(1) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `slov_page`
--
ALTER TABLE `slov_page`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `slov_prava`
--
ALTER TABLE `slov_prava`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `slov_qrq`
--
ALTER TABLE `slov_qrq`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `slov_status_buy_sell`
--
ALTER TABLE `slov_status_buy_sell`
  MODIFY `id` tinyint(2) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `slov_tax_system`
--
ALTER TABLE `slov_tax_system`
  MODIFY `id` tinyint(4) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `slov_type_attribute`
--
ALTER TABLE `slov_type_attribute`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `slov_unit`
--
ALTER TABLE `slov_unit`
  MODIFY `id` tinyint(2) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `slov_unit_formula`
--
ALTER TABLE `slov_unit_formula`
  MODIFY `id` tinyint(2) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `slov_urgency`
--
ALTER TABLE `slov_urgency`
  MODIFY `id` tinyint(4) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `slov_vip_function`
--
ALTER TABLE `slov_vip_function`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `sms_logs`
--
ALTER TABLE `sms_logs`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `stock`
--
ALTER TABLE `stock`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `subscriptions`
--
ALTER TABLE `subscriptions`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `subscriptions_no_autorize`
--
ALTER TABLE `subscriptions_no_autorize`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `tickets`
--
ALTER TABLE `tickets`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `tickets2`
--
ALTER TABLE `tickets2`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `tickets2_change_options_rules`
--
ALTER TABLE `tickets2_change_options_rules`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `tickets2_files`
--
ALTER TABLE `tickets2_files`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `tickets2_history`
--
ALTER TABLE `tickets2_history`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `tickets2_status`
--
ALTER TABLE `tickets2_status`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `tickets_files`
--
ALTER TABLE `tickets_files`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `tickets_folder`
--
ALTER TABLE `tickets_folder`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `tickets_logs`
--
ALTER TABLE `tickets_logs`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `z_slov_flag_insert_slov_attribute_value`
--
ALTER TABLE `z_slov_flag_insert_slov_attribute_value`
  MODIFY `id` tinyint(4) NOT NULL AUTO_INCREMENT;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `1c_company`
--
ALTER TABLE `1c_company`
  ADD CONSTRAINT `FK_1c_company_company_id` FOREIGN KEY (`company_id`) REFERENCES `company` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `1c_company_company`
--
ALTER TABLE `1c_company_company`
  ADD CONSTRAINT `FK_1c_company_company_1c_company_id` FOREIGN KEY (`1c_company_id`) REFERENCES `1c_company` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `FK_1c_company_company_company_id` FOREIGN KEY (`company_id`) REFERENCES `company` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `FK_1c_company_company_company_id_to` FOREIGN KEY (`company_id_to`) REFERENCES `company` (`id`);

--
-- Constraints for table `1c_nomenclature`
--
ALTER TABLE `1c_nomenclature`
  ADD CONSTRAINT `FK_1c_nomenclature_company_id` FOREIGN KEY (`company_id`) REFERENCES `company` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `1c_nomenclature_out`
--
ALTER TABLE `1c_nomenclature_out`
  ADD CONSTRAINT `FK_1c_nomenclature_out` FOREIGN KEY (`nomenclature_id`) REFERENCES `nomenclature` (`id`);

--
-- Constraints for table `1c_nomost`
--
ALTER TABLE `1c_nomost`
  ADD CONSTRAINT `FK_1c_nomost` FOREIGN KEY (`company_id`) REFERENCES `company` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `FK_1c_nomost_nomenclature_id` FOREIGN KEY (`nomenclature_id`) REFERENCES `nomenclature` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `FK_1c_nomost_stock_id` FOREIGN KEY (`stock_id`) REFERENCES `stock` (`id`);

--
-- Constraints for table `1c_outbuy11`
--
ALTER TABLE `1c_outbuy11`
  ADD CONSTRAINT `FK_1c_outbuy11_buy_sell_id` FOREIGN KEY (`buy_sell_id`) REFERENCES `buy_sell` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `1c_outbuy12`
--
ALTER TABLE `1c_outbuy12`
  ADD CONSTRAINT `FK_1c_outbuy12` FOREIGN KEY (`buy_sell_id`) REFERENCES `buy_sell` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `1c_refresh_all`
--
ALTER TABLE `1c_refresh_all`
  ADD CONSTRAINT `FK_1c_refresh_all` FOREIGN KEY (`company_id`) REFERENCES `company` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `1c_slov_unit`
--
ALTER TABLE `1c_slov_unit`
  ADD CONSTRAINT `FK_tmp_1c_slov_unit_company_id` FOREIGN KEY (`company_id`) REFERENCES `company` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `1c_stock`
--
ALTER TABLE `1c_stock`
  ADD CONSTRAINT `FK_1c_stock_company_id` FOREIGN KEY (`company_id`) REFERENCES `company` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `1c_typenom`
--
ALTER TABLE `1c_typenom`
  ADD CONSTRAINT `FK_tmp_1c_typenom_company_id` FOREIGN KEY (`company_id`) REFERENCES `company` (`id`);

--
-- Constraints for table `1c_typenom_categoies`
--
ALTER TABLE `1c_typenom_categoies`
  ADD CONSTRAINT `FK_1c_typenom_categoies` FOREIGN KEY (`company_id`) REFERENCES `company` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `FK_1c_typenom_categoies_1c_typenom_id` FOREIGN KEY (`1c_typenom_id`) REFERENCES `1c_typenom` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `FK_1c_typenom_categoies_categories_id` FOREIGN KEY (`categories_id`) REFERENCES `slov_categories` (`id`);

--
-- Constraints for table `amo_accounts_etp`
--
ALTER TABLE `amo_accounts_etp`
  ADD CONSTRAINT `FK_amo_accounts_etp_company_id` FOREIGN KEY (`company_id`) REFERENCES `company` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `FK_amo_accounts_etp_qrq_id` FOREIGN KEY (`qrq_id`) REFERENCES `slov_qrq` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `amo_accounts_old11062022`
--
ALTER TABLE `amo_accounts_old11062022`
  ADD CONSTRAINT `FK_amo_accountsadd` FOREIGN KEY (`company_id`) REFERENCES `company` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `attribute_value`
--
ALTER TABLE `attribute_value`
  ADD CONSTRAINT `FK_attribute_value` FOREIGN KEY (`attribute_value_id`) REFERENCES `slov_attribute_value` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `FK_attribute_value_attribute_id` FOREIGN KEY (`attribute_id`) REFERENCES `slov_attribute` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `FK_attribute_value_categories_id` FOREIGN KEY (`categories_id`) REFERENCES `slov_categories` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `buy_sell`
--
ALTER TABLE `buy_sell`
  ADD CONSTRAINT `FK_buy_sell_a_cities` FOREIGN KEY (`cities_id`) REFERENCES `a_cities` (`id`),
  ADD CONSTRAINT `FK_buy_sell_currency_id` FOREIGN KEY (`currency_id`) REFERENCES `slov_currency` (`id`),
  ADD CONSTRAINT `FK_buy_sell_slov_categories` FOREIGN KEY (`categories_id`) REFERENCES `slov_categories` (`id`),
  ADD CONSTRAINT `FK_buy_sell_slov_urgency` FOREIGN KEY (`urgency_id`) REFERENCES `slov_urgency` (`id`),
  ADD CONSTRAINT `FK_buy_sell_status_buy_sell_id` FOREIGN KEY (`status_buy_sell_id`) REFERENCES `slov_status_buy_sell` (`id`);

--
-- Constraints for table `buy_sell_1c`
--
ALTER TABLE `buy_sell_1c`
  ADD CONSTRAINT `FK_buy_sell_1c` FOREIGN KEY (`company_id`) REFERENCES `company` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `buy_sell_attribute`
--
ALTER TABLE `buy_sell_attribute`
  ADD CONSTRAINT `FK_buy_sell_attribute_buy_sell_id` FOREIGN KEY (`buy_sell_id`) REFERENCES `buy_sell` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `FK_buy_sell_attribute_slov_attribute` FOREIGN KEY (`attribute_id`) REFERENCES `slov_attribute` (`id`);

--
-- Constraints for table `buy_sell_cache`
--
ALTER TABLE `buy_sell_cache`
  ADD CONSTRAINT `FK_buy_sell_cache_buy_sell_id` FOREIGN KEY (`buy_sell_id`) REFERENCES `buy_sell` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `buy_sell_cookie`
--
ALTER TABLE `buy_sell_cookie`
  ADD CONSTRAINT `FK_buy_sell_cookie_buy_sell_id` FOREIGN KEY (`buy_sell_id`) REFERENCES `buy_sell` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `buy_sell_etp_sell`
--
ALTER TABLE `buy_sell_etp_sell`
  ADD CONSTRAINT `FK_buy_sell_etp_sell_buy_sell_id` FOREIGN KEY (`buy_sell_id`) REFERENCES `buy_sell` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `buy_sell_files`
--
ALTER TABLE `buy_sell_files`
  ADD CONSTRAINT `FK_buy_sell_files` FOREIGN KEY (`buy_sell_id`) REFERENCES `buy_sell` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `buy_sell_note`
--
ALTER TABLE `buy_sell_note`
  ADD CONSTRAINT `FK_buy_sell_note_buy_sell_id` FOREIGN KEY (`buy_sell_id`) REFERENCES `buy_sell` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `FK_buy_sell_note_company_id` FOREIGN KEY (`company_id`) REFERENCES `company` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `buy_sell_share`
--
ALTER TABLE `buy_sell_share`
  ADD CONSTRAINT `FK_buy_sell_share_company_id_from` FOREIGN KEY (`company_id_from`) REFERENCES `company` (`id`);

--
-- Constraints for table `buy_sell_share_ids`
--
ALTER TABLE `buy_sell_share_ids`
  ADD CONSTRAINT `FK_buy_sell_share` FOREIGN KEY (`buy_sell_id`) REFERENCES `buy_sell` (`id`),
  ADD CONSTRAINT `FK_buy_sell_share_ids` FOREIGN KEY (`buy_sell_share_id`) REFERENCES `buy_sell_share` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `card_attributes`
--
ALTER TABLE `card_attributes`
  ADD CONSTRAINT `card_attributes_fk0` FOREIGN KEY (`card_id`) REFERENCES `cards` (`id`);

--
-- Constraints for table `card_files`
--
ALTER TABLE `card_files`
  ADD CONSTRAINT `card_files_fk0` FOREIGN KEY (`card_id`) REFERENCES `cards` (`id`);

--
-- Constraints for table `categories_attribute`
--
ALTER TABLE `categories_attribute`
  ADD CONSTRAINT `FK_categories_attribute_attribute` FOREIGN KEY (`attribute_id`) REFERENCES `slov_attribute` (`id`),
  ADD CONSTRAINT `FK_categories_attribute_categories` FOREIGN KEY (`categories_id`) REFERENCES `slov_categories` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `chat_attachment`
--
ALTER TABLE `chat_attachment`
  ADD CONSTRAINT `chat_attachment_fk0` FOREIGN KEY (`message_id`) REFERENCES `chat_messages` (`id`);

--
-- Constraints for table `chat_messages`
--
ALTER TABLE `chat_messages`
  ADD CONSTRAINT `chat_messages_fk0` FOREIGN KEY (`chat_id`) REFERENCES `chat` (`id`);

--
-- Constraints for table `chat_users`
--
ALTER TABLE `chat_users`
  ADD CONSTRAINT `chat_users_fk0` FOREIGN KEY (`chat_id`) REFERENCES `chat` (`id`);

--
-- Constraints for table `company`
--
ALTER TABLE `company`
  ADD CONSTRAINT `FK_company` FOREIGN KEY (`cities_id`) REFERENCES `a_cities` (`id`),
  ADD CONSTRAINT `FK_company_legal_entity_id` FOREIGN KEY (`legal_entity_id`) REFERENCES `slov_legal_entity` (`id`),
  ADD CONSTRAINT `FK_company_login_id` FOREIGN KEY (`login_id`) REFERENCES `login` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `company_categories`
--
ALTER TABLE `company_categories`
  ADD CONSTRAINT `FK_company_categories` FOREIGN KEY (`company_id`) REFERENCES `company` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `FK_company_categories_categories_id` FOREIGN KEY (`categories_id`) REFERENCES `slov_categories` (`id`);

--
-- Constraints for table `company_form_payment`
--
ALTER TABLE `company_form_payment`
  ADD CONSTRAINT `FK_company_form_payment_company_id` FOREIGN KEY (`company_id`) REFERENCES `company` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `FK_company_form_payment_form_payment_id` FOREIGN KEY (`form_payment_id`) REFERENCES `slov_form_payment` (`id`);

--
-- Constraints for table `company_last_session`
--
ALTER TABLE `company_last_session`
  ADD CONSTRAINT `FK_company_last_session_company_id` FOREIGN KEY (`company_id`) REFERENCES `company` (`id`),
  ADD CONSTRAINT `FK_company_last_session_login_id` FOREIGN KEY (`login_id`) REFERENCES `login` (`id`);

--
-- Constraints for table `company_page_visited_send`
--
ALTER TABLE `company_page_visited_send`
  ADD CONSTRAINT `FK_company_page_visited_send_login_id` FOREIGN KEY (`login_id`) REFERENCES `login` (`id`),
  ADD CONSTRAINT `FK_page_visited_send` FOREIGN KEY (`company_id`) REFERENCES `company` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `FK_page_visited_send_page_visited_send_id` FOREIGN KEY (`page_id`) REFERENCES `slov_page` (`id`);

--
-- Constraints for table `company_qrq`
--
ALTER TABLE `company_qrq`
  ADD CONSTRAINT `FK_company_qrq` FOREIGN KEY (`company_id`) REFERENCES `company` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `company_vip_function`
--
ALTER TABLE `company_vip_function`
  ADD CONSTRAINT `FK_company_vip_function_company_id` FOREIGN KEY (`company_id`) REFERENCES `company` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `FK_company_vip_function_vip_function_id` FOREIGN KEY (`vip_function_id`) REFERENCES `slov_vip_function` (`id`);

--
-- Constraints for table `counter_buysellone`
--
ALTER TABLE `counter_buysellone`
  ADD CONSTRAINT `FK_counter_buysellone` FOREIGN KEY (`buy_sell_id`) REFERENCES `buy_sell` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `FK_counter_buysellone_company_id` FOREIGN KEY (`company_id`) REFERENCES `company` (`id`),
  ADD CONSTRAINT `FK_counter_buysellone_login_id` FOREIGN KEY (`login_id`) REFERENCES `login` (`id`);

--
-- Constraints for table `counter_buysellone_ip`
--
ALTER TABLE `counter_buysellone_ip`
  ADD CONSTRAINT `FK_counter_buysellone_ip_buy_sell_id` FOREIGN KEY (`buy_sell_id`) REFERENCES `buy_sell` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `cron_amo_buy_sell`
--
ALTER TABLE `cron_amo_buy_sell`
  ADD CONSTRAINT `FK_cron_amo_buy_sell` FOREIGN KEY (`buy_sell_id`) REFERENCES `buy_sell` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `cron_amo_buy_sell_searchupdate`
--
ALTER TABLE `cron_amo_buy_sell_searchupdate`
  ADD CONSTRAINT `FK_cron_amo_buy_sell_searchupdate` FOREIGN KEY (`buy_sell_id`) REFERENCES `buy_sell` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `cron_amo_buy_sell_search_infopart`
--
ALTER TABLE `cron_amo_buy_sell_search_infopart`
  ADD CONSTRAINT `FK_cron_amo_buy_sell_search_infopart` FOREIGN KEY (`categories_id`) REFERENCES `slov_categories` (`id`);

--
-- Constraints for table `cron_qrq_buy_sell`
--
ALTER TABLE `cron_qrq_buy_sell`
  ADD CONSTRAINT `FK_cron_qrq_buy_sell_but_sell_id` FOREIGN KEY (`buy_sell_id`) REFERENCES `buy_sell` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `cron_qrq_buy_sell_result`
--
ALTER TABLE `cron_qrq_buy_sell_result`
  ADD CONSTRAINT `FK_cron_qrq_buy_sell_result_buy_sell_id` FOREIGN KEY (`buy_sell_id`) REFERENCES `buy_sell` (`id`);

--
-- Constraints for table `history_buy_sell`
--
ALTER TABLE `history_buy_sell`
  ADD CONSTRAINT `FK_history_buy_sell` FOREIGN KEY (`buy_sell_id`) REFERENCES `buy_sell` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `interests_company_param`
--
ALTER TABLE `interests_company_param`
  ADD CONSTRAINT `FK_interests_company_param_company_id` FOREIGN KEY (`company_id`) REFERENCES `company` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `FK_interests_company_param_interests_param_id` FOREIGN KEY (`interests_param_id`) REFERENCES `slov_interests_param` (`id`);

--
-- Constraints for table `invite_workers`
--
ALTER TABLE `invite_workers`
  ADD CONSTRAINT `FK_invite_workers_company_id` FOREIGN KEY (`company_id`) REFERENCES `company` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `FK_invite_workers_prava_id` FOREIGN KEY (`prava_id`) REFERENCES `slov_prava` (`id`);

--
-- Constraints for table `login_company_prava`
--
ALTER TABLE `login_company_prava`
  ADD CONSTRAINT `FK_login_company_prava_company_id` FOREIGN KEY (`company_id`) REFERENCES `company` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `FK_login_company_prava_login_id` FOREIGN KEY (`login_id`) REFERENCES `login` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `FK_login_prava` FOREIGN KEY (`login_id`) REFERENCES `login` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `menu_prava`
--
ALTER TABLE `menu_prava`
  ADD CONSTRAINT `FK_prava_menu_id` FOREIGN KEY (`prava_id`) REFERENCES `slov_prava` (`id`);

--
-- Constraints for table `nomenclature`
--
ALTER TABLE `nomenclature`
  ADD CONSTRAINT `FK_nomenclature` FOREIGN KEY (`categories_id`) REFERENCES `slov_categories` (`id`),
  ADD CONSTRAINT `FK_nomenclature_company_id` FOREIGN KEY (`company_id`) REFERENCES `company` (`id`),
  ADD CONSTRAINT `FK_nomenclature_login_id` FOREIGN KEY (`login_id`) REFERENCES `login` (`id`);

--
-- Constraints for table `nomenclature_amo_searchbrend`
--
ALTER TABLE `nomenclature_amo_searchbrend`
  ADD CONSTRAINT `FK_nomenclature_amo_searchbrend` FOREIGN KEY (`nomenclature_id`) REFERENCES `nomenclature` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `nomenclature_attribute`
--
ALTER TABLE `nomenclature_attribute`
  ADD CONSTRAINT `FK_nomenclature_attribute_attribute_id` FOREIGN KEY (`attribute_id`) REFERENCES `slov_attribute` (`id`),
  ADD CONSTRAINT `FK_nomenclature_attribute_nomenclature_id` FOREIGN KEY (`nomenclature_id`) REFERENCES `nomenclature` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `notification`
--
ALTER TABLE `notification`
  ADD CONSTRAINT `FK_notification_company_id` FOREIGN KEY (`company_id`) REFERENCES `company` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `FK_notification_login_id` FOREIGN KEY (`login_id`) REFERENCES `login` (`id`),
  ADD CONSTRAINT `FK_notification_notification_id` FOREIGN KEY (`notification_id`) REFERENCES `slov_notification` (`id`);

--
-- Constraints for table `notification_company_param`
--
ALTER TABLE `notification_company_param`
  ADD CONSTRAINT `FK_notification_company_param_company_id` FOREIGN KEY (`company_id`) REFERENCES `company` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `FK_notification_company_param_notification_id` FOREIGN KEY (`notification_id`) REFERENCES `slov_notification` (`id`),
  ADD CONSTRAINT `FK_notification_company_param_notification_param_id` FOREIGN KEY (`notification_param_id`) REFERENCES `slov_notification_param` (`id`);

--
-- Constraints for table `notification_cron_send_1800`
--
ALTER TABLE `notification_cron_send_1800`
  ADD CONSTRAINT `FK_notification_cron_send_1800` FOREIGN KEY (`notification_id`) REFERENCES `slov_notification` (`id`),
  ADD CONSTRAINT `FK_notification_cron_send_1800_company_id` FOREIGN KEY (`company_id`) REFERENCES `company` (`id`),
  ADD CONSTRAINT `FK_notification_cron_send_1800_login_id` FOREIGN KEY (`login_id`) REFERENCES `login` (`id`);

--
-- Constraints for table `qrq_html_question`
--
ALTER TABLE `qrq_html_question`
  ADD CONSTRAINT `FK_qrq_html_question` FOREIGN KEY (`qrq_id`) REFERENCES `slov_qrq` (`id`);

--
-- Constraints for table `qrq_html_question_search`
--
ALTER TABLE `qrq_html_question_search`
  ADD CONSTRAINT `FK_qrq_html_question_search_qrq_id` FOREIGN KEY (`qrq_id`) REFERENCES `slov_qrq` (`id`);

--
-- Constraints for table `search_categories`
--
ALTER TABLE `search_categories`
  ADD CONSTRAINT `FK_search_categories` FOREIGN KEY (`categories_id`) REFERENCES `slov_categories` (`id`);

--
-- Constraints for table `search_categories_attribute`
--
ALTER TABLE `search_categories_attribute`
  ADD CONSTRAINT `FK_search_categories_attribute` FOREIGN KEY (`search_categories_id`) REFERENCES `search_categories` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `slov_attribute_value`
--
ALTER TABLE `slov_attribute_value`
  ADD CONSTRAINT `FK_slov_attribute_value` FOREIGN KEY (`attribute_id`) REFERENCES `slov_attribute` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `FK_slov_attribute_value_flag_insert` FOREIGN KEY (`flag_insert`) REFERENCES `z_slov_flag_insert_slov_attribute_value` (`id`);

--
-- Constraints for table `slov_categories`
--
ALTER TABLE `slov_categories`
  ADD CONSTRAINT `FK_slov_categories_unit_id` FOREIGN KEY (`unit_id`) REFERENCES `slov_unit` (`id`);

--
-- Constraints for table `slov_qrq`
--
ALTER TABLE `slov_qrq`
  ADD CONSTRAINT `FK_slov_qrq` FOREIGN KEY (`company_id`) REFERENCES `company` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `slov_unit_formula`
--
ALTER TABLE `slov_unit_formula`
  ADD CONSTRAINT `FK_slov_unit_formula_unit_id` FOREIGN KEY (`unit_id`) REFERENCES `slov_unit` (`id`),
  ADD CONSTRAINT `FK_slov_unit_formula_unit_id1` FOREIGN KEY (`unit_id1`) REFERENCES `slov_unit` (`id`);

--
-- Constraints for table `subscriptions`
--
ALTER TABLE `subscriptions`
  ADD CONSTRAINT `FK_subscriptions_company_id_in` FOREIGN KEY (`company_id_in`) REFERENCES `company` (`id`),
  ADD CONSTRAINT `FK_subscriptions_company_id_out` FOREIGN KEY (`company_id_out`) REFERENCES `company` (`id`);

--
-- Constraints for table `subscriptions_no_autorize`
--
ALTER TABLE `subscriptions_no_autorize`
  ADD CONSTRAINT `FK_subscriptions_no_autorize_company_id_from` FOREIGN KEY (`company_id_from`) REFERENCES `company` (`id`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
