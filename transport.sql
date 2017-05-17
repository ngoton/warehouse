-- phpMyAdmin SQL Dump
-- version 4.2.7.1
-- http://www.phpmyadmin.net
--
-- Client :  127.0.0.1
-- Généré le :  Jeu 13 Avril 2017 à 11:52
-- Version du serveur :  5.6.20
-- Version de PHP :  5.5.15

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Base de données :  `transport`
--

-- --------------------------------------------------------

--
-- Structure de la table `account`
--

CREATE TABLE IF NOT EXISTS `account` (
`account_id` int(11) NOT NULL,
  `account_number` varchar(20) DEFAULT NULL,
  `account_name` varchar(50) DEFAULT NULL,
  `account_parent` int(11) DEFAULT NULL
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=14 ;

--
-- Contenu de la table `account`
--

INSERT INTO `account` (`account_id`, `account_number`, `account_name`, `account_parent`) VALUES
(1, '111', 'Tiền mặt', 0),
(2, '112', 'Tiền gửi ngân hàng', 0),
(3, '131', 'Phải thu khách hàng', 0),
(4, '331', 'Phải trả người bán', 0),
(5, '334', 'Phải trả người lao động', 0),
(6, '141', 'Tạm ứng', 0),
(7, '154', 'Chi phí sản xuất kinh doanh dở dang', 0),
(8, '152', 'Nguyên vật liệu', 0),
(9, '621', 'Chi phí nguyên vật liệu trực tiếp', 0),
(10, '632', 'Giá vốn hàng bán', 0),
(11, '627', 'Chi phí sản xuất chung', 0),
(12, '642', 'Chi phí quản lý', 0),
(13, '333', 'Thuế & các khoản phải nộp nhà nước', 0);

-- --------------------------------------------------------

--
-- Structure de la table `bank`
--

CREATE TABLE IF NOT EXISTS `bank` (
`bank_id` int(11) NOT NULL,
  `bank_code` varchar(20) DEFAULT NULL,
  `bank_name` varchar(50) DEFAULT NULL,
  `account_number` varchar(50) DEFAULT NULL,
  `account_bank` varchar(50) DEFAULT NULL,
  `account_bank_branch` varchar(100) DEFAULT NULL
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=2 ;

--
-- Contenu de la table `bank`
--

INSERT INTO `bank` (`bank_id`, `bank_code`, `bank_name`, `account_number`, `account_bank`, `account_bank_branch`) VALUES
(1, '111', 'Tiền mặt', '', '', '');

-- --------------------------------------------------------

--
-- Structure de la table `bridge_cost`
--

CREATE TABLE IF NOT EXISTS `bridge_cost` (
`bridge_cost_id` int(11) NOT NULL,
  `toll_booth` int(11) DEFAULT NULL,
  `road` int(11) DEFAULT NULL,
  `toll_booth_cost` decimal(10,0) DEFAULT NULL,
  `check_vat` int(11) DEFAULT NULL
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=1865 ;

--
-- Contenu de la table `bridge_cost`
--

INSERT INTO `bridge_cost` (`bridge_cost_id`, `toll_booth`, `road`, `toll_booth_cost`, `check_vat`) VALUES
(1857, 1, 2175, '10000', 1),
(1858, 2, 2175, '20000', 0),
(1859, 2, 2176, '21000', 0),
(1860, 1, 2177, '10000', 1),
(1861, 1, 2178, '10000', 1),
(1862, 2, 2178, '21000', 0),
(1863, 1, 2179, '10000', 1),
(1864, 3, 2180, '0', 0);

-- --------------------------------------------------------

--
-- Structure de la table `bridge_cost_temp`
--

CREATE TABLE IF NOT EXISTS `bridge_cost_temp` (
`bridge_cost_temp_id` int(11) NOT NULL,
  `bridge_cost_id` int(11) NOT NULL,
  `toll_booth` int(11) DEFAULT NULL,
  `road` int(11) DEFAULT NULL,
  `toll_booth_cost` decimal(10,0) DEFAULT NULL,
  `check_vat` int(11) DEFAULT NULL,
  `bridge_cost_temp_date` int(11) DEFAULT NULL,
  `bridge_cost_temp_action` int(11) DEFAULT NULL COMMENT '1:Add | 2:Edit | 3:Delete',
  `bridge_cost_temp_user` int(11) DEFAULT NULL,
  `name` varchar(20) DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Structure de la table `contact_person`
--

CREATE TABLE IF NOT EXISTS `contact_person` (
`contact_person_id` int(11) NOT NULL,
  `contact_person_name` varchar(50) DEFAULT NULL,
  `contact_person_address` varchar(100) DEFAULT NULL,
  `contact_person_phone` varchar(20) DEFAULT NULL,
  `contact_person_mobile` varchar(20) DEFAULT NULL,
  `contact_person_email` varchar(50) DEFAULT NULL,
  `contact_person_position` varchar(20) DEFAULT NULL,
  `contact_person_department` varchar(20) DEFAULT NULL,
  `customer` int(11) DEFAULT NULL
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=2 ;

--
-- Contenu de la table `contact_person`
--

INSERT INTO `contact_person` (`contact_person_id`, `contact_person_name`, `contact_person_address`, `contact_person_phone`, `contact_person_mobile`, `contact_person_email`, `contact_person_position`, `contact_person_department`, `customer`) VALUES
(1, 'a', '', '12', '', '', '', '', 1);

-- --------------------------------------------------------

--
-- Structure de la table `cont_unit`
--

CREATE TABLE IF NOT EXISTS `cont_unit` (
`cont_unit_id` int(11) NOT NULL,
  `cont_unit_name` varchar(20) DEFAULT NULL
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=4 ;

--
-- Contenu de la table `cont_unit`
--

INSERT INTO `cont_unit` (`cont_unit_id`, `cont_unit_name`) VALUES
(1, 'Cont 20'''),
(2, 'Cont 40'''),
(3, 'KG');

-- --------------------------------------------------------

--
-- Structure de la table `cost_list`
--

CREATE TABLE IF NOT EXISTS `cost_list` (
`cost_list_id` int(11) NOT NULL,
  `cost_list_code` varchar(50) DEFAULT NULL,
  `cost_list_name` varchar(100) DEFAULT NULL,
  `cost_list_type` int(11) DEFAULT NULL COMMENT '1:Công ty | 2:Chi hộ | 3:Khác'
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=2 ;

--
-- Contenu de la table `cost_list`
--

INSERT INTO `cost_list` (`cost_list_id`, `cost_list_code`, `cost_list_name`, `cost_list_type`) VALUES
(1, 'NL', 'Tiền dầu', 5);

-- --------------------------------------------------------

--
-- Structure de la table `cost_type`
--

CREATE TABLE IF NOT EXISTS `cost_type` (
`cost_type_id` int(11) NOT NULL,
  `cost_type_name` varchar(50) DEFAULT NULL
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=12 ;

--
-- Contenu de la table `cost_type`
--

INSERT INTO `cost_type` (`cost_type_id`, `cost_type_name`) VALUES
(1, 'Hành chính'),
(2, 'Mua hàng'),
(3, 'Nhân sự'),
(4, 'Sửa chữa, Bảo trì'),
(5, 'Nhiên liệu'),
(6, 'Cầu đường'),
(7, 'Tạm ứng'),
(8, 'Chi hộ'),
(9, 'Hoa hồng'),
(10, 'Công an'),
(11, 'Khác');

-- --------------------------------------------------------

--
-- Structure de la table `customer`
--

CREATE TABLE IF NOT EXISTS `customer` (
`customer_id` int(11) NOT NULL,
  `customer_code` varchar(50) DEFAULT NULL,
  `customer_name` varchar(100) DEFAULT NULL,
  `customer_company` varchar(200) DEFAULT NULL,
  `customer_mst` int(11) DEFAULT NULL,
  `customer_address` varchar(255) DEFAULT NULL,
  `customer_phone` varchar(20) DEFAULT NULL,
  `customer_mobile` varchar(20) DEFAULT NULL,
  `customer_email` varchar(50) DEFAULT NULL,
  `customer_bank_account` int(11) DEFAULT NULL,
  `customer_bank_name` varchar(50) DEFAULT NULL,
  `customer_bank_branch` varchar(50) DEFAULT NULL,
  `customer_sub` varchar(20) DEFAULT NULL,
  `type_customer` int(11) DEFAULT NULL COMMENT '1:Khách hàng | 2:Đối tác'
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=2 ;

--
-- Contenu de la table `customer`
--

INSERT INTO `customer` (`customer_id`, `customer_code`, `customer_name`, `customer_company`, `customer_mst`, `customer_address`, `customer_phone`, `customer_mobile`, `customer_email`, `customer_bank_account`, `customer_bank_name`, `customer_bank_branch`, `customer_sub`, `type_customer`) VALUES
(1, 'KH-AA', 'AA', 'Công ty TNHH AA', 111, 'a2', '085 548 8899', '092 454 5566', '', 0, '', '', '1,2,3', 2);

-- --------------------------------------------------------

--
-- Structure de la table `customer_sub`
--

CREATE TABLE IF NOT EXISTS `customer_sub` (
`customer_sub_id` int(11) NOT NULL,
  `customer_sub_name` varchar(50) DEFAULT NULL
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=4 ;

--
-- Contenu de la table `customer_sub`
--

INSERT INTO `customer_sub` (`customer_sub_id`, `customer_sub_name`) VALUES
(1, 'Sắn'),
(2, 'Mì'),
(3, 'Cám');

-- --------------------------------------------------------

--
-- Structure de la table `customer_temp`
--

CREATE TABLE IF NOT EXISTS `customer_temp` (
`customer_temp_id` int(11) NOT NULL,
  `customer_id` int(11) NOT NULL,
  `customer_code` varchar(20) DEFAULT NULL,
  `customer_name` varchar(100) DEFAULT NULL,
  `customer_company` varchar(200) DEFAULT NULL,
  `customer_mst` int(11) DEFAULT NULL,
  `customer_address` varchar(255) DEFAULT NULL,
  `customer_phone` varchar(20) DEFAULT NULL,
  `customer_mobile` varchar(20) DEFAULT NULL,
  `customer_email` varchar(50) DEFAULT NULL,
  `customer_bank_account` int(11) DEFAULT NULL,
  `customer_bank_name` varchar(50) DEFAULT NULL,
  `customer_bank_branch` varchar(50) DEFAULT NULL,
  `customer_sub` varchar(20) DEFAULT NULL,
  `type_customer` int(11) DEFAULT NULL COMMENT '1:Khách hàng | 2:Đối tác',
  `customer_temp_date` int(11) DEFAULT NULL,
  `customer_temp_action` int(11) DEFAULT NULL,
  `customer_temp_user` int(11) DEFAULT NULL,
  `name` varchar(20) DEFAULT NULL
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=2 ;

--
-- Contenu de la table `customer_temp`
--

INSERT INTO `customer_temp` (`customer_temp_id`, `customer_id`, `customer_code`, `customer_name`, `customer_company`, `customer_mst`, `customer_address`, `customer_phone`, `customer_mobile`, `customer_email`, `customer_bank_account`, `customer_bank_name`, `customer_bank_branch`, `customer_sub`, `type_customer`, `customer_temp_date`, `customer_temp_action`, `customer_temp_user`, `name`) VALUES
(1, 1, 'KH-AA', 'AA', 'Công ty TNHH AA', 111, 'a2', '085 548 8899', '092 454 5566', '', 0, '', '', '1,2,3', 2, 1491343200, 2, 41, 'Khách hàng');

-- --------------------------------------------------------

--
-- Structure de la table `debit`
--

CREATE TABLE IF NOT EXISTS `debit` (
`debit_id` int(11) NOT NULL,
  `debit_date` int(11) DEFAULT NULL,
  `customer` int(11) DEFAULT NULL,
  `staff` int(11) DEFAULT NULL,
  `money` decimal(10,0) DEFAULT NULL,
  `money_vat` int(11) DEFAULT NULL,
  `money_vat_price` decimal(10,0) DEFAULT NULL,
  `comment` varchar(255) DEFAULT NULL,
  `check_debit` int(11) DEFAULT NULL COMMENT '1:Phải thu | 2:Phải trả',
  `shipment` int(11) DEFAULT NULL,
  `shipment_cost` int(11) DEFAULT NULL,
  `import_stock` int(11) DEFAULT NULL,
  `import_stock_cost` int(11) DEFAULT NULL,
  `repair` int(11) DEFAULT NULL
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=6 ;

--
-- Contenu de la table `debit`
--

INSERT INTO `debit` (`debit_id`, `debit_date`, `customer`, `staff`, `money`, `money_vat`, `money_vat_price`, `comment`, `check_debit`, `shipment`, `shipment_cost`, `import_stock`, `import_stock_cost`, `repair`) VALUES
(1, 1490911200, 1, NULL, '7000', 1, '700', 'Mua hàng HD số 000032424', 2, NULL, NULL, 1, NULL, NULL),
(2, 1490997600, NULL, 1, '530000', 0, NULL, 'Sửa chữa', 2, NULL, NULL, NULL, NULL, 1),
(3, 1490911200, 1, NULL, '60000', 1, NULL, 'Mua hàng', 2, NULL, NULL, NULL, 1, NULL),
(4, 1490911200, 1, NULL, '30000', 0, NULL, 'Phát sinh', 2, NULL, NULL, NULL, 2, NULL);

-- --------------------------------------------------------

--
-- Structure de la table `department`
--

CREATE TABLE IF NOT EXISTS `department` (
`department_id` int(11) NOT NULL,
  `department_code` varchar(20) DEFAULT NULL,
  `department_name` varchar(50) DEFAULT NULL
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=2 ;

--
-- Contenu de la table `department`
--

INSERT INTO `department` (`department_id`, `department_code`, `department_name`) VALUES
(1, 'NS', 'Nhân sự');

-- --------------------------------------------------------

--
-- Structure de la table `department_temp`
--

CREATE TABLE IF NOT EXISTS `department_temp` (
`department_temp_id` int(11) NOT NULL,
  `department_id` int(11) NOT NULL,
  `department_code` varchar(20) DEFAULT NULL,
  `department_name` varchar(50) DEFAULT NULL,
  `department_temp_date` int(11) DEFAULT NULL,
  `department_temp_action` int(11) DEFAULT NULL,
  `department_temp_user` int(11) DEFAULT NULL,
  `name` varchar(20) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Structure de la table `distance`
--

CREATE TABLE IF NOT EXISTS `distance` (
`distance_id` int(11) NOT NULL,
  `road` int(11) DEFAULT NULL,
  `km` float DEFAULT NULL,
  `oil` float DEFAULT NULL,
  `way` int(11) DEFAULT NULL
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=9 ;

--
-- Contenu de la table `distance`
--

INSERT INTO `distance` (`distance_id`, `road`, `km`, `oil`, `way`) VALUES
(1, 2175, 1, 0.38, 1),
(2, 2176, 1, 0.58, 2),
(3, 2177, 1, 0.38, 1),
(4, 2175, 1, 0.58, 2),
(5, 2178, 10, 3.8, 1),
(6, 2178, 10, 5.8, 2),
(7, 2179, 10, 3.8, 1),
(8, 2180, 2, 0.76, 1);

-- --------------------------------------------------------

--
-- Structure de la table `distance_temp`
--

CREATE TABLE IF NOT EXISTS `distance_temp` (
`distance_temp_id` int(11) NOT NULL,
  `distance_id` int(11) NOT NULL,
  `road` int(11) DEFAULT NULL,
  `km` float DEFAULT NULL,
  `oil` float DEFAULT NULL,
  `way` int(11) DEFAULT NULL,
  `distance_temp_date` int(11) DEFAULT NULL,
  `distance_temp_action` int(11) DEFAULT NULL COMMENT '1:Add | 2:Edit | 3:Delete',
  `distance_temp_user` int(11) DEFAULT NULL,
  `name` varchar(20) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Structure de la table `driver`
--

CREATE TABLE IF NOT EXISTS `driver` (
`driver_id` int(11) NOT NULL,
  `start_work` int(11) DEFAULT NULL,
  `end_work` int(11) DEFAULT NULL,
  `vehicle` int(11) DEFAULT NULL,
  `steersman` int(11) DEFAULT NULL
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=57 ;

--
-- Contenu de la table `driver`
--

INSERT INTO `driver` (`driver_id`, `start_work`, `end_work`, `vehicle`, `steersman`) VALUES
(54, 1489618800, 1490738400, 1, 41),
(55, 1490824800, 1491948000, 1, 42),
(56, 1492034400, 1807567200, 1, 41);

-- --------------------------------------------------------

--
-- Structure de la table `driver_temp`
--

CREATE TABLE IF NOT EXISTS `driver_temp` (
`driver_temp_id` int(11) NOT NULL,
  `driver_id` int(11) NOT NULL,
  `start_work` int(11) DEFAULT NULL,
  `end_work` int(11) DEFAULT NULL,
  `vehicle` int(11) DEFAULT NULL,
  `steersman` int(11) DEFAULT NULL,
  `driver_temp_date` int(11) DEFAULT NULL,
  `driver_temp_action` int(11) DEFAULT NULL COMMENT '1:Add | 2:Edit | 3:Delete',
  `driver_temp_user` int(11) DEFAULT NULL,
  `name` varchar(20) DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Structure de la table `excess`
--

CREATE TABLE IF NOT EXISTS `excess` (
`excess_id` int(11) NOT NULL,
  `vehicle` int(11) DEFAULT NULL,
  `round` int(11) DEFAULT NULL,
  `month` int(11) DEFAULT NULL,
  `year` int(11) DEFAULT NULL,
  `excess_cost` decimal(10,0) DEFAULT NULL,
  `bonus` decimal(10,0) DEFAULT NULL,
  `used` int(11) DEFAULT NULL,
  `shipment` int(11) DEFAULT NULL
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=2414 ;

--
-- Contenu de la table `excess`
--

INSERT INTO `excess` (`excess_id`, `vehicle`, `round`, `month`, `year`, `excess_cost`, `bonus`, `used`, `shipment`) VALUES
(2413, 1, 2, 4, 2017, '0', '0', 0, 12183);

-- --------------------------------------------------------

--
-- Structure de la table `export_stock`
--

CREATE TABLE IF NOT EXISTS `export_stock` (
`export_stock_id` int(11) NOT NULL,
  `export_stock_code` varchar(50) DEFAULT NULL,
  `export_stock_date` int(11) DEFAULT NULL,
  `export_stock_user` int(11) DEFAULT NULL,
  `export_stock_price` decimal(10,0) DEFAULT NULL,
  `export_stock_vat` decimal(10,0) DEFAULT NULL,
  `export_stock_total` float DEFAULT NULL,
  `export_stock_comment` varchar(255) DEFAULT NULL,
  `staff` int(11) DEFAULT NULL,
  `house` int(11) DEFAULT NULL
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=3 ;

--
-- Contenu de la table `export_stock`
--

INSERT INTO `export_stock` (`export_stock_id`, `export_stock_code`, `export_stock_date`, `export_stock_user`, `export_stock_price`, `export_stock_vat`, `export_stock_total`, `export_stock_comment`, `staff`, `house`) VALUES
(1, 'XK00001', 1490911200, 41, '9000', NULL, 3, NULL, 1, 1),
(2, 'XK000002', 1490911200, 41, '82000', '8200', 10, 'Xuất kho', 1, 1);

-- --------------------------------------------------------

--
-- Structure de la table `house`
--

CREATE TABLE IF NOT EXISTS `house` (
`house_id` int(11) NOT NULL,
  `house_name` varchar(50) DEFAULT NULL,
  `house_place` varchar(100) DEFAULT NULL
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=2 ;

--
-- Contenu de la table `house`
--

INSERT INTO `house` (`house_id`, `house_name`, `house_place`) VALUES
(1, 'Kho nhiên liệu', 'Q1');

-- --------------------------------------------------------

--
-- Structure de la table `house_temp`
--

CREATE TABLE IF NOT EXISTS `house_temp` (
`house_temp_id` int(11) NOT NULL,
  `house_id` int(11) DEFAULT NULL,
  `house_name` varchar(50) DEFAULT NULL,
  `house_place` varchar(100) DEFAULT NULL,
  `house_temp_date` int(11) DEFAULT NULL,
  `house_temp_action` int(11) DEFAULT NULL,
  `house_temp_user` int(11) DEFAULT NULL,
  `name` varchar(20) DEFAULT NULL
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=3 ;

--
-- Contenu de la table `house_temp`
--

INSERT INTO `house_temp` (`house_temp_id`, `house_id`, `house_name`, `house_place`, `house_temp_date`, `house_temp_action`, `house_temp_user`, `name`) VALUES
(1, 1, 'Kho nhiên liệu', 'Q1', 1491688800, 1, 41, 'DS kho vật tư'),
(2, 1, 'Kho nhiên liệu', 'Q1', 1491688800, 2, 41, 'DS kho vật tư');

-- --------------------------------------------------------

--
-- Structure de la table `import_stock`
--

CREATE TABLE IF NOT EXISTS `import_stock` (
`import_stock_id` int(11) NOT NULL,
  `import_stock_code` varchar(50) DEFAULT NULL,
  `import_stock_date` int(11) DEFAULT NULL,
  `import_stock_user` int(11) DEFAULT NULL,
  `import_stock_total` float DEFAULT NULL,
  `import_stock_price` decimal(10,0) DEFAULT NULL,
  `import_stock_vat` decimal(10,0) DEFAULT NULL,
  `import_stock_comment` varchar(255) DEFAULT NULL,
  `invoice_number` varchar(20) DEFAULT NULL,
  `invoice_date` int(11) DEFAULT NULL,
  `invoice_customer` int(11) DEFAULT NULL,
  `deliver` varchar(50) DEFAULT NULL,
  `deliver_address` varchar(200) DEFAULT NULL,
  `house` int(11) DEFAULT NULL
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=10 ;

--
-- Contenu de la table `import_stock`
--

INSERT INTO `import_stock` (`import_stock_id`, `import_stock_code`, `import_stock_date`, `import_stock_user`, `import_stock_total`, `import_stock_price`, `import_stock_vat`, `import_stock_comment`, `invoice_number`, `invoice_date`, `invoice_customer`, `deliver`, `deliver_address`, `house`) VALUES
(1, 'A3353511', 1490911200, 41, 4, '7000', '700', 'Nhập kho', '000032424', 1488322800, 1, 'Hoàng Nam', 'TP Hồ Chí Minh', 1),
(4, 'NK909999', 1492120800, 41, 2, '8000000', '1600000', 'Lốp', '', 0, 0, '', '', 1),
(9, 'aaaa', 1492034400, 41, 2, '8000000', '800000', 'a', '', 0, 0, '', '', 1);

-- --------------------------------------------------------

--
-- Structure de la table `import_stock_cost`
--

CREATE TABLE IF NOT EXISTS `import_stock_cost` (
`import_stock_cost_id` int(11) NOT NULL,
  `import_stock` int(11) DEFAULT NULL,
  `cost_list` int(11) DEFAULT NULL,
  `cost` decimal(10,0) DEFAULT NULL,
  `check_vat` int(11) DEFAULT NULL,
  `comment` varchar(255) DEFAULT NULL,
  `receiver` int(11) DEFAULT NULL,
  `cost_document` varchar(50) DEFAULT NULL
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=2 ;

--
-- Contenu de la table `import_stock_cost`
--

INSERT INTO `import_stock_cost` (`import_stock_cost_id`, `import_stock`, `cost_list`, `cost`, `check_vat`, `comment`, `receiver`, `cost_document`) VALUES
(1, 1, 1, '60000', 1, 'Mua hàng', 1, '000923');

-- --------------------------------------------------------

--
-- Structure de la table `info`
--

CREATE TABLE IF NOT EXISTS `info` (
`info_id` int(11) NOT NULL,
  `info_company` varchar(100) DEFAULT NULL,
  `info_mst` int(11) DEFAULT NULL,
  `info_address` varchar(200) DEFAULT NULL,
  `info_phone` varchar(20) DEFAULT NULL,
  `info_email` varchar(50) DEFAULT NULL
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=2 ;

--
-- Contenu de la table `info`
--

INSERT INTO `info` (`info_id`, `info_company`, `info_mst`, `info_address`, `info_phone`, `info_email`) VALUES
(1, 'Công ty CP Tân Cảng Miền Trung', 132323454, 'asas', '334 343 4344', 'dsd@dsd.cc');

-- --------------------------------------------------------

--
-- Structure de la table `insurance`
--

CREATE TABLE IF NOT EXISTS `insurance` (
`insurance_id` int(11) NOT NULL,
  `insurance_date` int(11) DEFAULT NULL,
  `driver` int(11) DEFAULT NULL,
  `money` decimal(10,0) DEFAULT NULL
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=15 ;

-- --------------------------------------------------------

--
-- Structure de la table `loan_shipment`
--

CREATE TABLE IF NOT EXISTS `loan_shipment` (
`loan_shipment_id` int(11) NOT NULL,
  `loan_cost` decimal(10,0) DEFAULT NULL,
  `loan_unit` int(11) DEFAULT NULL,
  `loan_comment` varchar(200) DEFAULT NULL,
  `shipment` int(11) DEFAULT NULL,
  `loan_shipment_user` int(11) DEFAULT NULL
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=10 ;

--
-- Contenu de la table `loan_shipment`
--

INSERT INTO `loan_shipment` (`loan_shipment_id`, `loan_cost`, `loan_unit`, `loan_comment`, `shipment`, `loan_shipment_user`) VALUES
(8, '20000', 1, 'Nâng', 12179, 41),
(9, '10000', 2, 'Hạ', 12179, 41);

-- --------------------------------------------------------

--
-- Structure de la table `loan_unit`
--

CREATE TABLE IF NOT EXISTS `loan_unit` (
`loan_unit_id` int(11) NOT NULL,
  `loan_unit_name` varchar(20) DEFAULT NULL
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=4 ;

--
-- Contenu de la table `loan_unit`
--

INSERT INTO `loan_unit` (`loan_unit_id`, `loan_unit_name`) VALUES
(1, 'Phí nâng cont'),
(2, 'Phí hạ cont'),
(3, 'Chi phí khác');

-- --------------------------------------------------------

--
-- Structure de la table `marketing`
--

CREATE TABLE IF NOT EXISTS `marketing` (
`marketing_id` int(11) NOT NULL,
  `marketing_date` int(11) DEFAULT NULL,
  `marketing_from` int(11) DEFAULT NULL,
  `marketing_to` int(11) DEFAULT NULL,
  `customer` int(11) DEFAULT NULL,
  `customer_type` varchar(20) DEFAULT NULL,
  `marketing_ton` float DEFAULT NULL,
  `cont_unit` int(11) DEFAULT NULL,
  `marketing_charge` decimal(10,0) DEFAULT NULL,
  `status` int(11) DEFAULT NULL,
  `marketing_start` int(11) DEFAULT NULL,
  `marketing_end` int(11) DEFAULT NULL,
  `commission` decimal(10,0) DEFAULT NULL,
  `commission_number` float DEFAULT NULL,
  `marketing_create_user` int(11) DEFAULT NULL,
  `marketing_ton_use` float DEFAULT NULL
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=17 ;

--
-- Contenu de la table `marketing`
--

INSERT INTO `marketing` (`marketing_id`, `marketing_date`, `marketing_from`, `marketing_to`, `customer`, `customer_type`, `marketing_ton`, `cont_unit`, `marketing_charge`, `status`, `marketing_start`, `marketing_end`, `commission`, `commission_number`, `marketing_create_user`, `marketing_ton_use`) VALUES
(15, 1490997600, 2, 1, 1, '1', 150, 3, '5000', NULL, 1490997600, 1493503200, '20000', 1, 41, 50),
(16, 1490997600, 2, 1, 1, '1', 2, 1, '40000', NULL, 1490997600, 1493416800, '1000', 10, 41, 1);

-- --------------------------------------------------------

--
-- Structure de la table `oil`
--

CREATE TABLE IF NOT EXISTS `oil` (
`oil_id` int(11) NOT NULL,
  `way` varchar(20) DEFAULT NULL,
  `oil` float DEFAULT NULL
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=3 ;

--
-- Contenu de la table `oil`
--

INSERT INTO `oil` (`oil_id`, `way`, `oil`) VALUES
(1, 'Rỗng', 0.38),
(2, 'Lên', 0.58);

-- --------------------------------------------------------

--
-- Structure de la table `oil_temp`
--

CREATE TABLE IF NOT EXISTS `oil_temp` (
`oil_temp_id` int(11) NOT NULL,
  `oil_id` int(11) NOT NULL,
  `way` varchar(20) DEFAULT NULL,
  `oil` float DEFAULT NULL,
  `oil_temp_date` int(11) DEFAULT NULL,
  `oil_temp_action` int(11) DEFAULT NULL COMMENT '1:Add | 2:Edit | 3:Delete',
  `oil_temp_user` int(11) DEFAULT NULL,
  `name` varchar(20) DEFAULT NULL
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=4 ;

--
-- Contenu de la table `oil_temp`
--

INSERT INTO `oil_temp` (`oil_temp_id`, `oil_id`, `way`, `oil`, `oil_temp_date`, `oil_temp_action`, `oil_temp_user`, `name`) VALUES
(1, 3, 'Xuống', 0.6, 1490652000, 1, 41, 'Định mức dầu'),
(2, 3, 'Xuống', 0.7, 1490652000, 2, 41, 'Định mức dầu'),
(3, 3, 'Xuống', 0.7, 1490652000, 3, 41, 'Định mức dầu');

-- --------------------------------------------------------

--
-- Structure de la table `overtime`
--

CREATE TABLE IF NOT EXISTS `overtime` (
`overtime_id` int(11) NOT NULL,
  `overtime_date` int(11) DEFAULT NULL,
  `driver` int(11) DEFAULT NULL,
  `money` decimal(10,0) DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Structure de la table `place`
--

CREATE TABLE IF NOT EXISTS `place` (
`place_id` int(11) NOT NULL,
  `place_name` varchar(100) DEFAULT NULL,
  `province` int(11) DEFAULT NULL
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=3 ;

--
-- Contenu de la table `place`
--

INSERT INTO `place` (`place_id`, `place_name`, `province`) VALUES
(1, 'Cát Lái', 1),
(2, 'Aeo', 25);

-- --------------------------------------------------------

--
-- Structure de la table `place_temp`
--

CREATE TABLE IF NOT EXISTS `place_temp` (
`place_temp_id` int(11) NOT NULL,
  `place_id` int(11) NOT NULL,
  `place_name` varchar(100) DEFAULT NULL,
  `province` int(11) DEFAULT NULL,
  `place_temp_date` int(11) DEFAULT NULL,
  `place_temp_action` int(11) DEFAULT NULL COMMENT '1:Add | 2:Edit | 3:Delete',
  `place_temp_user` int(11) DEFAULT NULL,
  `name` varchar(20) DEFAULT NULL
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=4 ;

--
-- Contenu de la table `place_temp`
--

INSERT INTO `place_temp` (`place_temp_id`, `place_id`, `place_name`, `province`, `place_temp_date`, `place_temp_action`, `place_temp_user`, `name`) VALUES
(1, 3, 'sas', 12, 1490652000, 1, 41, 'DS kho hàng'),
(2, 3, 'aa', 12, 1490652000, 2, 41, 'DS kho hàng'),
(3, 3, 'aa', 12, 1490652000, 3, 41, 'DS kho hàng');

-- --------------------------------------------------------

--
-- Structure de la table `province`
--

CREATE TABLE IF NOT EXISTS `province` (
`province_id` int(11) NOT NULL,
  `province_name` varchar(50) DEFAULT NULL,
  `province_code` varchar(20) DEFAULT NULL
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=63 ;

--
-- Contenu de la table `province`
--

INSERT INTO `province` (`province_id`, `province_name`, `province_code`) VALUES
(1, 'TP Hồ Chí Minh', 'HCM'),
(2, 'Đồng Nai', 'ĐN'),
(3, 'Bình Dương', 'BD'),
(4, 'Bà Rịa - Vũng Tàu', 'BR-VT'),
(5, 'Long An', 'LA'),
(6, 'Bình Phước', 'BP'),
(7, 'Tây Ninh', 'TN'),
(8, 'TP Cần Thơ', 'CT'),
(9, 'TP Đà Nẵng', 'ĐANA'),
(10, 'TP Hà Nội', 'HN'),
(11, 'TP Hải Phòng', 'HP'),
(12, 'An Giang', 'AG'),
(13, 'Bắc Kạn', 'BK'),
(14, 'Bạc Liêu', 'BL'),
(15, 'Bắc Ninh', 'BN'),
(16, 'Bến Tre', 'BTRE'),
(17, 'Bình Định', 'BĐ'),
(18, 'Bình Thuận', 'BT'),
(19, 'Cà Mau', 'CM'),
(20, 'Cao Bằng', 'CB'),
(21, 'Đắk Lắk', 'ĐL'),
(22, 'Đắk Nông', 'ĐNONG'),
(23, 'Điện Biên', 'ĐB'),
(24, 'Đồng Tháp', 'ĐT'),
(25, 'Gia Lai', 'GL'),
(26, 'Hà Giang', 'HG'),
(27, 'Hà Nam', 'HANA'),
(28, 'Hà Tĩnh', 'HT'),
(29, 'Hải Dương', 'HD'),
(30, 'Hậu Giang', 'HAUGIA'),
(31, 'Hòa Bình', 'HB'),
(32, 'Hưng Yên', 'HY'),
(33, 'Khánh Hòa', 'KH'),
(34, 'Kiên Giang', 'KG'),
(35, 'Kon Tum', 'KT'),
(36, 'Lai Châu', 'LC'),
(37, 'Lâm Đồng', 'LĐ'),
(38, 'Lạng Sơn', 'LS'),
(39, 'Lào Cai', 'LCA'),
(40, 'Nam Định', 'NĐ'),
(41, 'Nghệ An', 'NA'),
(42, 'Ninh Bình', 'NB'),
(43, 'Ninh Thuận', 'NT'),
(44, 'Phú Thọ', 'PT'),
(45, 'Phú Yên', 'PY'),
(46, 'Quảng Bình', 'QB'),
(47, 'Quảng Nam', 'QNA'),
(48, 'Quảng Ngãi', 'QN'),
(49, 'Quảng Ninh', 'QNI'),
(50, 'Quảng Trị', 'QT'),
(51, 'Sóc Trăng', 'ST'),
(52, 'Sơn La', 'SL'),
(53, 'Thái Bình', 'TB'),
(54, 'Thái Nguyên', 'THN'),
(55, 'Thanh Hóa', 'TH'),
(56, 'Thừa Thiên Huế', 'HUE'),
(57, 'Tiền Giang', 'TG'),
(58, 'Trà Vinh', 'TV'),
(59, 'Tuyên Quang', 'TQ'),
(60, 'Vĩnh Long', 'VL'),
(61, 'Vĩnh Phúc', 'VP'),
(62, 'Yên Bái', 'YB');

-- --------------------------------------------------------

--
-- Structure de la table `repair`
--

CREATE TABLE IF NOT EXISTS `repair` (
`repair_id` int(11) NOT NULL,
  `repair_code` varchar(50) DEFAULT NULL,
  `repair_date` int(11) DEFAULT NULL,
  `staff` int(11) DEFAULT NULL,
  `repair_comment` varchar(255) DEFAULT NULL,
  `vehicle` int(11) DEFAULT NULL,
  `romooc` int(11) DEFAULT NULL,
  `repair_price` decimal(10,0) DEFAULT NULL
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=2 ;

--
-- Contenu de la table `repair`
--

INSERT INTO `repair` (`repair_id`, `repair_code`, `repair_date`, `staff`, `repair_comment`, `vehicle`, `romooc`, `repair_price`) VALUES
(1, 'S00443', 1490997600, 1, 'Sửa chữa', 1, 0, '530000');

-- --------------------------------------------------------

--
-- Structure de la table `repair_list`
--

CREATE TABLE IF NOT EXISTS `repair_list` (
`repair_list_id` int(11) NOT NULL,
  `repair` int(11) DEFAULT NULL,
  `repair_list_comment` varchar(255) DEFAULT NULL,
  `repair_list_price` decimal(10,0) DEFAULT NULL
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=3 ;

--
-- Contenu de la table `repair_list`
--

INSERT INTO `repair_list` (`repair_list_id`, `repair`, `repair_list_comment`, `repair_list_price`) VALUES
(1, 1, 'Làm còi', '30000'),
(2, 1, 'Sửa đèn', '500000');

-- --------------------------------------------------------

--
-- Structure de la table `road`
--

CREATE TABLE IF NOT EXISTS `road` (
`road_id` int(11) NOT NULL,
  `road_from` int(11) DEFAULT NULL,
  `road_to` int(11) DEFAULT NULL,
  `road_km` int(11) DEFAULT NULL,
  `road_oil` float DEFAULT NULL,
  `road_time` float DEFAULT NULL,
  `bridge_cost` decimal(10,0) DEFAULT NULL,
  `police_cost` decimal(10,0) DEFAULT NULL,
  `tire_cost` decimal(10,0) DEFAULT NULL,
  `way` int(11) DEFAULT NULL COMMENT '0:Rong | 1:Len | 2:Xuong | 3:Bang | 4:DN-QN',
  `charge_add` decimal(10,0) DEFAULT NULL,
  `status` int(11) DEFAULT NULL,
  `start_time` int(11) DEFAULT NULL,
  `end_time` int(11) DEFAULT NULL,
  `route_from` int(11) DEFAULT NULL,
  `route_to` int(11) DEFAULT NULL,
  `road_add` decimal(10,0) DEFAULT NULL
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=2181 ;

--
-- Contenu de la table `road`
--

INSERT INTO `road` (`road_id`, `road_from`, `road_to`, `road_km`, `road_oil`, `road_time`, `bridge_cost`, `police_cost`, `tire_cost`, `way`, `charge_add`, `status`, `start_time`, `end_time`, `route_from`, `route_to`, `road_add`) VALUES
(2175, 1, 2, 2, 0.96, 1, '27273', '200000', '50000', 1, '100000', 1, 1490310000, 1490738400, 1, 2, NULL),
(2176, 1, 2, 2, 0.96, 1, '18182', '0', '2000', 2, '0', 1, 1490824800, 1492120800, 1, 2, NULL),
(2177, 1, 2, 1, 0.38, 0, '9091', '0', '0', 2, '0', 1, 1492207200, 1588197600, 1, 2, NULL),
(2178, 2, 1, 20, 9.6, 2, '28182', '500000', '20000', 2, '10000', 1, 1488322800, 1490911200, 1, 2, '0'),
(2179, 2, 1, 10, 3.8, 1, '9091', '50000', '20000', 2, '10000', 1, 1490997600, 1493416800, 2, 1, '200000'),
(2180, 2, 1, 2, 0.76, 0, '0', '0', '0', 2, '0', 1, 1493503200, 1588197600, 2, 1, '0');

-- --------------------------------------------------------

--
-- Structure de la table `road_temp`
--

CREATE TABLE IF NOT EXISTS `road_temp` (
`road_temp_id` int(11) NOT NULL,
  `road_id` int(11) NOT NULL,
  `road_from` int(11) DEFAULT NULL,
  `road_to` int(11) DEFAULT NULL,
  `road_km` int(11) DEFAULT NULL,
  `road_oil` float DEFAULT NULL,
  `road_time` float DEFAULT NULL,
  `bridge_cost` decimal(10,0) DEFAULT NULL,
  `police_cost` decimal(10,0) DEFAULT NULL,
  `tire_cost` decimal(10,0) DEFAULT NULL,
  `way` int(11) DEFAULT NULL COMMENT '0:Rong | 1:Len | 2:Xuong | 3:Bang | 4:DN-QN',
  `charge_add` decimal(10,0) DEFAULT NULL,
  `status` int(11) DEFAULT NULL,
  `start_time` int(11) DEFAULT NULL,
  `end_time` int(11) DEFAULT NULL,
  `road_temp_date` int(11) DEFAULT NULL,
  `road_temp_action` int(11) DEFAULT NULL COMMENT '1:Add | 2:Edit | 3:Delete',
  `road_temp_user` int(11) DEFAULT NULL,
  `name` varchar(20) DEFAULT NULL,
  `route_from` int(11) DEFAULT NULL,
  `route_to` int(11) DEFAULT NULL,
  `road_add` decimal(10,0) DEFAULT NULL
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=5 ;

--
-- Contenu de la table `road_temp`
--

INSERT INTO `road_temp` (`road_temp_id`, `road_id`, `road_from`, `road_to`, `road_km`, `road_oil`, `road_time`, `bridge_cost`, `police_cost`, `tire_cost`, `way`, `charge_add`, `status`, `start_time`, `end_time`, `road_temp_date`, `road_temp_action`, `road_temp_user`, `name`, `route_from`, `route_to`, `road_add`) VALUES
(1, 2178, 2, 1, 20, 9.6, 2, '28182', '500000', '20000', 2, '10000', 1, 1488322800, 1583017200, 1491084000, 1, 41, 'Tuyến đường', NULL, NULL, NULL),
(2, 2179, 2, 1, 10, 3.8, 1, '9091', '50000', '20000', 2, '10000', 1, 1490997600, 1585692000, 1491343200, 1, 41, 'Tuyến đường', 2, 1, '200000'),
(3, 2180, 2, 1, 2, 0.76, 0, '0', '0', '0', 2, '0', 1, 1493503200, 1588197600, 1491343200, 1, 41, 'Tuyến đường', 2, 1, '0'),
(4, 2178, 2, 1, 20, 9.6, 2, '28182', '500000', '20000', 2, '10000', 1, 1488322800, 1490911200, 1491516000, 2, 41, 'Tuyến đường', 1, 2, '0');

-- --------------------------------------------------------

--
-- Structure de la table `role`
--

CREATE TABLE IF NOT EXISTS `role` (
`role_id` int(11) NOT NULL,
  `role_name` varchar(255) DEFAULT NULL,
  `role_status` int(1) NOT NULL DEFAULT '1' COMMENT '1:active|0:inactive'
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=22 ;

--
-- Contenu de la table `role`
--

INSERT INTO `role` (`role_id`, `role_name`, `role_status`) VALUES
(1, 'Quản trị cấp cao', 1),
(2, 'Báo cáo, tổng hợp', 1),
(3, 'Kế toán', 1),
(4, 'Kinh doanh', 1),
(5, 'Điều độ', 1),
(6, 'Kho', 1),
(7, 'Nhân sự', 1),
(8, 'Vật tư, kỹ thuật', 1),
(9, 'Tài xế', 1);

-- --------------------------------------------------------

--
-- Structure de la table `romooc`
--

CREATE TABLE IF NOT EXISTS `romooc` (
`romooc_id` int(11) NOT NULL,
  `romooc_number` varchar(20) DEFAULT NULL,
  `status` int(11) DEFAULT '0' COMMENT '1:Đã lắp | 0:Trống'
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=3 ;

--
-- Contenu de la table `romooc`
--

INSERT INTO `romooc` (`romooc_id`, `romooc_number`, `status`) VALUES
(1, '72A-32324', 0),
(2, '72C-32300', 0);

-- --------------------------------------------------------

--
-- Structure de la table `romooc_temp`
--

CREATE TABLE IF NOT EXISTS `romooc_temp` (
`romooc_temp_id` int(11) NOT NULL,
  `romooc_id` int(11) NOT NULL,
  `romooc_number` varchar(20) DEFAULT NULL,
  `romooc_temp_date` int(11) DEFAULT NULL,
  `romooc_temp_user` int(11) DEFAULT NULL,
  `romooc_temp_action` int(11) DEFAULT NULL,
  `name` varchar(50) NOT NULL
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=6 ;

--
-- Contenu de la table `romooc_temp`
--

INSERT INTO `romooc_temp` (`romooc_temp_id`, `romooc_id`, `romooc_number`, `romooc_temp_date`, `romooc_temp_user`, `romooc_temp_action`, `name`) VALUES
(1, 1, '72A-323245', 1490738400, 41, 1, 'DS xe'),
(2, 1, '72A-32324', 1490738400, 41, 2, 'DS mooc'),
(3, 2, 'sdsd', 1490738400, 41, 1, 'DS xe'),
(4, 2, 'sdsd', 1490738400, 41, 3, 'DS mooc'),
(5, 2, '72C-32300', 1490738400, 41, 1, 'DS mooc');

-- --------------------------------------------------------

--
-- Structure de la table `route`
--

CREATE TABLE IF NOT EXISTS `route` (
`route_id` int(11) NOT NULL,
  `route_name` varchar(100) DEFAULT NULL,
  `province` int(11) DEFAULT NULL
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=3 ;

--
-- Contenu de la table `route`
--

INSERT INTO `route` (`route_id`, `route_name`, `province`) VALUES
(1, 'An Sương', 1),
(2, 'Sóng Thần', 3);

-- --------------------------------------------------------

--
-- Structure de la table `route_temp`
--

CREATE TABLE IF NOT EXISTS `route_temp` (
`route_temp_id` int(11) NOT NULL,
  `route_id` int(11) DEFAULT NULL,
  `route_name` varchar(100) DEFAULT NULL,
  `province` int(11) DEFAULT NULL,
  `route_temp_date` int(11) DEFAULT NULL,
  `route_temp_action` int(11) DEFAULT NULL,
  `route_temp_user` int(11) DEFAULT NULL,
  `name` varchar(50) DEFAULT NULL
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=3 ;

--
-- Contenu de la table `route_temp`
--

INSERT INTO `route_temp` (`route_temp_id`, `route_id`, `route_name`, `province`, `route_temp_date`, `route_temp_action`, `route_temp_user`, `name`) VALUES
(1, 1, 'An Sương', 1, 1491343200, 1, 41, 'DS địa điểm'),
(2, 2, 'Sóng Thần', 3, 1491343200, 1, 41, 'DS địa điểm');

-- --------------------------------------------------------

--
-- Structure de la table `salary_bonus`
--

CREATE TABLE IF NOT EXISTS `salary_bonus` (
`salary_bonus_id` int(11) NOT NULL,
  `bonus` decimal(10,0) DEFAULT NULL,
  `deduct` decimal(10,0) DEFAULT NULL,
  `start_time` int(11) DEFAULT NULL,
  `end_time` int(11) DEFAULT NULL
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=6 ;

--
-- Contenu de la table `salary_bonus`
--

INSERT INTO `salary_bonus` (`salary_bonus_id`, `bonus`, `deduct`, `start_time`, `end_time`) VALUES
(4, '10000', '10000', 1491429600, 1493416800),
(5, '15000', '20000', 1493503200, 1809036000);

-- --------------------------------------------------------

--
-- Structure de la table `shipment`
--

CREATE TABLE IF NOT EXISTS `shipment` (
`shipment_id` int(11) NOT NULL,
  `shipment_date` varchar(20) DEFAULT NULL,
  `vehicle` int(11) DEFAULT NULL,
  `romooc` int(11) DEFAULT NULL,
  `shipment_from` int(11) DEFAULT NULL,
  `shipment_to` int(11) DEFAULT NULL,
  `customer` int(11) DEFAULT NULL,
  `customer_type` varchar(20) DEFAULT NULL,
  `shipment_charge` decimal(10,0) DEFAULT NULL,
  `shipment_ton` float DEFAULT NULL,
  `shipment_ton_net` float DEFAULT NULL,
  `cont_unit` int(11) DEFAULT NULL,
  `cont_unit_net` int(11) DEFAULT NULL,
  `shipment_create_user` int(11) DEFAULT NULL,
  `shipment_revenue` decimal(10,0) DEFAULT NULL,
  `shipment_cost` decimal(10,0) DEFAULT NULL,
  `shipment_profit` decimal(10,0) DEFAULT NULL,
  `oil_add` float DEFAULT NULL,
  `shipment_round` int(11) DEFAULT NULL,
  `oil_cost` decimal(10,0) DEFAULT NULL,
  `cost_add` decimal(10,0) DEFAULT NULL,
  `approve` int(11) DEFAULT NULL COMMENT '1:OK | 0:NO',
  `user_approve` int(11) DEFAULT NULL,
  `oil_add_dc` int(11) DEFAULT NULL,
  `cost_add_comment` text,
  `shipment_update` int(11) DEFAULT NULL,
  `shipment_pay` int(11) DEFAULT NULL,
  `shipment_excess` decimal(10,0) DEFAULT NULL,
  `not_del` int(11) DEFAULT NULL,
  `sub_driver` int(11) DEFAULT NULL,
  `sub_driver_name` varchar(20) DEFAULT NULL,
  `sub_driver2` int(11) DEFAULT NULL,
  `shipment_loan` decimal(10,0) DEFAULT NULL,
  `loan_unit` int(11) DEFAULT NULL,
  `loan_content` text,
  `shipment_bonus` decimal(10,0) DEFAULT NULL,
  `oil_excess` float DEFAULT NULL,
  `oil_excess_dc` varchar(50) DEFAULT NULL,
  `oil_excess_comment` varchar(200) DEFAULT NULL,
  `advance` decimal(10,0) DEFAULT NULL,
  `advance_comment` text,
  `commission` decimal(10,0) DEFAULT NULL,
  `commission_number` float DEFAULT NULL,
  `oil_residual` float DEFAULT NULL,
  `oil_residual_comment` varchar(200) DEFAULT NULL,
  `cost_vat` decimal(10,0) DEFAULT NULL,
  `cost_vat_comment` varchar(200) DEFAULT NULL,
  `shipment_cost_temp` decimal(10,0) DEFAULT NULL,
  `oil_add2` float DEFAULT NULL,
  `oil_add_dc2` int(11) DEFAULT NULL,
  `shipment_plan` text,
  `shipment_expect` text,
  `cost_excess` decimal(10,0) DEFAULT NULL,
  `cost_excess_comment` text,
  `shipment_complete` int(11) DEFAULT NULL,
  `revenue_other` decimal(10,0) DEFAULT NULL,
  `shipment_sub` int(11) DEFAULT NULL,
  `shipment_temp` int(11) DEFAULT NULL,
  `shipment_charge_excess` decimal(10,0) DEFAULT NULL,
  `shipment_charge_excess_comment` varchar(200) DEFAULT NULL,
  `bridge_cost_add` decimal(10,0) DEFAULT NULL,
  `approve_oil` int(11) DEFAULT NULL,
  `bill_number` varchar(50) DEFAULT NULL,
  `bill_receive_date` int(11) DEFAULT NULL,
  `bill_delivery_date` int(11) DEFAULT NULL,
  `bill_receive_ton` float DEFAULT NULL,
  `bill_delivery_ton` float DEFAULT NULL,
  `bill_receive_unit` int(11) DEFAULT NULL,
  `bill_delivery_unit` int(11) DEFAULT NULL,
  `bill_in` int(11) DEFAULT NULL,
  `bill_out` int(11) DEFAULT NULL,
  `shipment_oil` float DEFAULT NULL,
  `export_stock` varchar(20) DEFAULT NULL,
  `shipment_salary` decimal(10,0) DEFAULT NULL,
  `route` varchar(50) DEFAULT NULL
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=12184 ;

--
-- Contenu de la table `shipment`
--

INSERT INTO `shipment` (`shipment_id`, `shipment_date`, `vehicle`, `romooc`, `shipment_from`, `shipment_to`, `customer`, `customer_type`, `shipment_charge`, `shipment_ton`, `shipment_ton_net`, `cont_unit`, `cont_unit_net`, `shipment_create_user`, `shipment_revenue`, `shipment_cost`, `shipment_profit`, `oil_add`, `shipment_round`, `oil_cost`, `cost_add`, `approve`, `user_approve`, `oil_add_dc`, `cost_add_comment`, `shipment_update`, `shipment_pay`, `shipment_excess`, `not_del`, `sub_driver`, `sub_driver_name`, `sub_driver2`, `shipment_loan`, `loan_unit`, `loan_content`, `shipment_bonus`, `oil_excess`, `oil_excess_dc`, `oil_excess_comment`, `advance`, `advance_comment`, `commission`, `commission_number`, `oil_residual`, `oil_residual_comment`, `cost_vat`, `cost_vat_comment`, `shipment_cost_temp`, `oil_add2`, `oil_add_dc2`, `shipment_plan`, `shipment_expect`, `cost_excess`, `cost_excess_comment`, `shipment_complete`, `revenue_other`, `shipment_sub`, `shipment_temp`, `shipment_charge_excess`, `shipment_charge_excess_comment`, `bridge_cost_add`, `approve_oil`, `bill_number`, `bill_receive_date`, `bill_delivery_date`, `bill_receive_ton`, `bill_delivery_ton`, `bill_receive_unit`, `bill_delivery_unit`, `bill_in`, `bill_out`, `shipment_oil`, `export_stock`, `shipment_salary`, `route`) VALUES
(12179, '1492639200', 1, 1, 2, 1, 1, '1', '10000', 3, 2, 2, 2, 41, '30000', '916322', '-753768', 10.5, 1, '12573', '6000', 0, NULL, 1, 'Phát sinh', 1, 0, '0', 1, 0, '', 0, '30000', NULL, '', '0', 10, 'ĐN', 'Phát sinh dầu', '20000', 'TU', '20000', 1, 1, 'Dầu thừa', '20000', 'Mua', '947600', 20, 5, NULL, NULL, '20000', 'Thừa', 1, NULL, NULL, 0, '2000', 'Cước phát sinh', '10000', NULL, 'DO0323232', 1492034400, 1492725600, 2, 3, 2, 2, 1492808400, 1492811999, 8.5, '1,2', NULL, NULL),
(12180, '1493503200', 1, 1, 1, 2, 1, '3', '10000', 4500, 5000, 3, 3, 41, '45000000', '35255', '44964745', 0, 2, '12573', '0', 1, NULL, 1, '', 1, 0, '0', NULL, 0, '', 0, '0', NULL, '', '0', 0, '', '', '0', '', '0', 1, 0, '', '0', '', '30000', 0, 1, NULL, NULL, '0', '', 0, NULL, NULL, 0, '0', '', '0', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(12183, '1490824800', 1, 2, 2, 1, 1, '3', '500000', 1, 2, 2, 1, 41, '500000', '790216', '-240216', 0, 1, '12236', '0', 1, NULL, 1, '', 1, 0, '0', 0, 0, '', 0, '0', NULL, '', '0', 0, '', '', '0', '', '0', 1, 0, '', '0', '', '611000', 0, 1, NULL, NULL, '0', '', 0, NULL, NULL, 0, '0', '', '0', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '200000', '2178');

-- --------------------------------------------------------

--
-- Structure de la table `shipment_cost`
--

CREATE TABLE IF NOT EXISTS `shipment_cost` (
`shipment_cost_id` int(11) NOT NULL,
  `shipment` int(11) DEFAULT NULL,
  `cost_list` int(11) DEFAULT NULL,
  `cost` decimal(10,0) DEFAULT NULL,
  `check_vat` int(11) DEFAULT NULL,
  `comment` varchar(255) DEFAULT NULL,
  `receiver` int(11) DEFAULT NULL,
  `cost_document` varchar(50) DEFAULT NULL
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=6 ;

--
-- Contenu de la table `shipment_cost`
--

INSERT INTO `shipment_cost` (`shipment_cost_id`, `shipment`, `cost_list`, `cost`, `check_vat`, `comment`, `receiver`, `cost_document`) VALUES
(4, 12183, 1, '20000', 1, 'Dầu1', 1, '00e434341'),
(5, 12183, 1, '30000', 0, '2', 1, '0066666');

-- --------------------------------------------------------

--
-- Structure de la table `shipment_temp`
--

CREATE TABLE IF NOT EXISTS `shipment_temp` (
`shipment_temp_id` int(11) NOT NULL,
  `shipment_temp_date` int(11) DEFAULT NULL,
  `owner` int(11) DEFAULT NULL,
  `marketing` int(11) DEFAULT NULL,
  `shipment_temp_status` int(11) DEFAULT NULL,
  `shipment_temp_ton` float DEFAULT NULL,
  `shipment_temp_cont_unit` int(11) DEFAULT NULL,
  `shipment_temp_number` int(11) DEFAULT NULL,
  `shipment_temp_commission` decimal(10,0) DEFAULT NULL,
  `shipment_temp_commission_number` int(11) DEFAULT NULL,
  `shipment_ton_use` float DEFAULT NULL
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=6 ;

--
-- Contenu de la table `shipment_temp`
--

INSERT INTO `shipment_temp` (`shipment_temp_id`, `shipment_temp_date`, `owner`, `marketing`, `shipment_temp_status`, `shipment_temp_ton`, `shipment_temp_cont_unit`, `shipment_temp_number`, `shipment_temp_commission`, `shipment_temp_commission_number`, `shipment_ton_use`) VALUES
(4, 1491256800, 41, 15, 0, 50, 3, 3, '20000', 1, NULL),
(5, 1491602400, 41, 16, 0, 1, 1, 1, '1000', 10, NULL);

-- --------------------------------------------------------

--
-- Structure de la table `shipment_two`
--

CREATE TABLE IF NOT EXISTS `shipment_two` (
`shipment_two_id` int(11) NOT NULL,
  `shipment_date` varchar(20) DEFAULT NULL,
  `vehicle` int(11) DEFAULT NULL,
  `shipment_from` int(11) DEFAULT NULL,
  `shipment_to` int(11) DEFAULT NULL,
  `customer` int(11) DEFAULT NULL,
  `shipment_charge` decimal(10,0) DEFAULT NULL,
  `shipment_ton` float DEFAULT NULL,
  `shipment_create_user` int(11) DEFAULT NULL,
  `shipment_revenue` decimal(10,0) DEFAULT NULL,
  `shipment_cost` decimal(10,0) DEFAULT NULL,
  `shipment_profit` decimal(10,0) DEFAULT NULL,
  `oil_add` float DEFAULT NULL,
  `shipment_round` int(11) DEFAULT NULL,
  `oil_cost` decimal(10,0) DEFAULT NULL,
  `cost_add` decimal(10,0) DEFAULT NULL,
  `approve` int(11) DEFAULT NULL COMMENT '1:OK | 0:NO',
  `user_approve` int(11) DEFAULT NULL,
  `oil_add_dc` int(11) DEFAULT NULL,
  `cost_add_comment` text,
  `shipment_update` int(11) DEFAULT NULL,
  `shipment_pay` int(11) DEFAULT NULL,
  `shipment_excess` decimal(10,0) DEFAULT NULL,
  `not_del` int(11) DEFAULT NULL,
  `sub_driver` int(11) DEFAULT NULL,
  `sub_driver_name` varchar(20) DEFAULT NULL,
  `sub_driver2` int(11) DEFAULT NULL,
  `shipment_loan` decimal(10,0) DEFAULT NULL,
  `loan_content` text,
  `shipment_bonus` decimal(10,0) DEFAULT NULL,
  `oil_excess` float DEFAULT NULL,
  `oil_excess_dc` varchar(50) DEFAULT NULL,
  `oil_excess_comment` varchar(200) DEFAULT NULL,
  `advance` decimal(10,0) DEFAULT NULL,
  `advance_comment` text,
  `commission` decimal(10,0) DEFAULT NULL,
  `commission_number` float DEFAULT NULL,
  `oil_residual` float DEFAULT NULL,
  `oil_residual_comment` varchar(200) DEFAULT NULL,
  `cost_vat` decimal(10,0) DEFAULT NULL,
  `cost_vat_comment` varchar(200) DEFAULT NULL,
  `shipment_cost_temp` decimal(10,0) DEFAULT NULL,
  `oil_add2` float DEFAULT NULL,
  `oil_add_dc2` int(11) DEFAULT NULL,
  `shipment_plan` text,
  `shipment_expect` text,
  `cost_excess` decimal(10,0) DEFAULT NULL,
  `cost_excess_comment` text,
  `shipment_complete` int(11) DEFAULT NULL,
  `revenue_other` decimal(10,0) DEFAULT NULL,
  `shipment_sub` int(11) DEFAULT NULL,
  `shipment_temp` int(11) DEFAULT NULL,
  `shipment_charge_excess` decimal(10,0) DEFAULT NULL,
  `shipment_charge_excess_comment` varchar(200) DEFAULT NULL,
  `bridge_cost_add` decimal(10,0) DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Structure de la table `spare_drap`
--

CREATE TABLE IF NOT EXISTS `spare_drap` (
`spare_drap_id` int(11) NOT NULL,
  `spare_part` int(11) DEFAULT NULL,
  `spare_part_number` float DEFAULT NULL,
  `spare_vehicle` int(11) DEFAULT NULL
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=3 ;

--
-- Contenu de la table `spare_drap`
--

INSERT INTO `spare_drap` (`spare_drap_id`, `spare_part`, `spare_part_number`, `spare_vehicle`) VALUES
(1, 3, 1, 18),
(2, 4, 1, 19);

-- --------------------------------------------------------

--
-- Structure de la table `spare_part`
--

CREATE TABLE IF NOT EXISTS `spare_part` (
`spare_part_id` int(11) NOT NULL,
  `spare_part_code` varchar(50) DEFAULT NULL,
  `spare_part_seri` varchar(100) DEFAULT NULL,
  `spare_part_date_manufacture` int(11) DEFAULT NULL,
  `spare_part_brand` varchar(50) DEFAULT NULL,
  `spare_part_name` varchar(100) DEFAULT NULL,
  `spare_part_type` varchar(50) DEFAULT NULL,
  `code_list` int(11) DEFAULT NULL
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=18 ;

--
-- Contenu de la table `spare_part`
--

INSERT INTO `spare_part` (`spare_part_id`, `spare_part_code`, `spare_part_seri`, `spare_part_date_manufacture`, `spare_part_brand`, `spare_part_name`, `spare_part_type`, `code_list`) VALUES
(1, 'BL01', '2346466565', 1488236400, 'Honda', 'Bulong', '1,2', NULL),
(2, 'OC01', '6479232964', 1488301200, 'Toshiba', 'Ốc', NULL, NULL),
(3, 'C002', '', 0, '', 'Cờ lê', '3', NULL),
(4, 'O9992', '', 0, '', 'Xả khói', '4', NULL),
(5, 'DR801', '500000444', 1492016400, 'Double Road', 'Double Road', NULL, NULL),
(6, 'DR801', '5111144565', 1491948000, 'Double Road', 'Double Road', '', NULL),
(7, 'DR801', '55555555555', 1491930000, 'Double Road', 'Double Road', NULL, 1),
(8, 'DR801', '4444444444', 1491930000, 'Double Road', 'Double Road', NULL, 1),
(9, 'd', '111', 1491930000, 'd', 'd', NULL, 2),
(10, 'd', '222', 1491930000, 'd', 'd', NULL, 2),
(11, 'd', '2222', 1492016400, 'd', 'd', NULL, 2),
(12, 'd', '1111', 1492016400, 'd', 'd', NULL, 2),
(13, 'd', '111', 1491498000, 'd', 'd', NULL, 2),
(14, 'd', '1111', 1491498000, 'd', 'd', NULL, 2),
(15, 'a', '555', 1492794000, 'a', 'a', NULL, 3),
(16, 'a', '666', 1492794000, 'a', 'a', NULL, 3),
(17, 'a', '777', 1492707600, 'a', 'a', NULL, 3);

-- --------------------------------------------------------

--
-- Structure de la table `spare_part_code`
--

CREATE TABLE IF NOT EXISTS `spare_part_code` (
`spare_part_code_id` int(11) NOT NULL,
  `code` varchar(20) DEFAULT NULL,
  `name` varchar(50) DEFAULT NULL
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=4 ;

--
-- Contenu de la table `spare_part_code`
--

INSERT INTO `spare_part_code` (`spare_part_code_id`, `code`, `name`) VALUES
(1, 'DR801', 'Double Road'),
(2, 'd', 'd'),
(3, 'a', 'a');

-- --------------------------------------------------------

--
-- Structure de la table `spare_part_temp`
--

CREATE TABLE IF NOT EXISTS `spare_part_temp` (
`spare_part_temp_id` int(11) NOT NULL,
  `spare_part_id` int(11) NOT NULL,
  `spare_part_code` varchar(50) DEFAULT NULL,
  `spare_part_seri` varchar(100) DEFAULT NULL,
  `spare_part_date_manufacture` int(11) DEFAULT NULL,
  `spare_part_brand` varchar(50) DEFAULT NULL,
  `spare_part_name` varchar(100) DEFAULT NULL,
  `spare_part_type` varchar(50) DEFAULT NULL,
  `spare_part_temp_date` int(11) DEFAULT NULL,
  `spare_part_temp_action` int(11) DEFAULT NULL,
  `spare_part_temp_user` int(11) DEFAULT NULL,
  `name` varchar(20) DEFAULT NULL,
  `code_list` int(11) DEFAULT NULL
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=15 ;

--
-- Contenu de la table `spare_part_temp`
--

INSERT INTO `spare_part_temp` (`spare_part_temp_id`, `spare_part_id`, `spare_part_code`, `spare_part_seri`, `spare_part_date_manufacture`, `spare_part_brand`, `spare_part_name`, `spare_part_type`, `spare_part_temp_date`, `spare_part_temp_action`, `spare_part_temp_user`, `name`, `code_list`) VALUES
(1, 5, 'DR801', '500000444', 1492016400, 'Double Road', 'Double Road', NULL, 1492016400, 1, 41, 'Vật tư', NULL),
(2, 6, 'DR801', '511114456', 1492016400, 'Double Road', 'Double Road', NULL, 1492016400, 1, 41, 'Vật tư', NULL),
(3, 7, 'DR801', '55555555555', 1491930000, 'Double Road', 'Double Road', NULL, 1492016400, 1, 41, 'Vật tư', 1),
(4, 8, 'DR801', '4444444444', 1491930000, 'Double Road', 'Double Road', NULL, 1492016400, 1, 41, 'Vật tư', 1),
(5, 6, 'DR801', '5111144565', 1491948000, 'Double Road', 'Double Road', '', 1492034400, 2, 41, 'Vật tư', NULL),
(6, 9, 'd', '111', 1491930000, 'd', 'd', NULL, 1492016400, 1, 41, 'Vật tư', 2),
(7, 10, 'd', '222', 1491930000, 'd', 'd', NULL, 1492016400, 1, 41, 'Vật tư', 2),
(8, 11, 'd', '2222', 1492016400, 'd', 'd', NULL, 1492016400, 1, 41, 'Vật tư', 2),
(9, 12, 'd', '1111', 1492016400, 'd', 'd', NULL, 1492016400, 1, 41, 'Vật tư', 2),
(10, 13, 'd', '111', 1491498000, 'd', 'd', NULL, 1492016400, 1, 41, 'Vật tư', 2),
(11, 14, 'd', '1111', 1491498000, 'd', 'd', NULL, 1492016400, 1, 41, 'Vật tư', 2),
(12, 15, 'a', '555', 1492794000, 'a', 'a', NULL, 1492016400, 1, 41, 'Vật tư', 3),
(13, 16, 'a', '666', 1492794000, 'a', 'a', NULL, 1492016400, 1, 41, 'Vật tư', 3),
(14, 17, 'a', '777', 1492707600, 'a', 'a', NULL, 1492016400, 1, 41, 'Vật tư', 3);

-- --------------------------------------------------------

--
-- Structure de la table `spare_stock`
--

CREATE TABLE IF NOT EXISTS `spare_stock` (
`spare_stock_id` int(11) NOT NULL,
  `spare_part` int(11) DEFAULT NULL,
  `spare_stock_unit` varchar(20) DEFAULT NULL,
  `spare_stock_number` float DEFAULT NULL,
  `spare_stock_price` decimal(10,0) DEFAULT NULL,
  `spare_stock_vat` int(11) DEFAULT NULL,
  `spare_stock_vat_percent` float DEFAULT NULL,
  `spare_stock_vat_price` decimal(10,0) DEFAULT NULL,
  `import_stock` int(11) DEFAULT NULL,
  `export_stock` int(11) DEFAULT NULL
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=23 ;

--
-- Contenu de la table `spare_stock`
--

INSERT INTO `spare_stock` (`spare_stock_id`, `spare_part`, `spare_stock_unit`, `spare_stock_number`, `spare_stock_price`, `spare_stock_vat`, `spare_stock_vat_percent`, `spare_stock_vat_price`, `import_stock`, `export_stock`) VALUES
(1, 1, 'Cái', 2, '2500', 1, 10, '500', 1, NULL),
(2, 2, 'Chiếc', 2, '1000', 0, 10, '200', 1, NULL),
(3, 1, 'Cái', 3, '3000', 1, NULL, NULL, NULL, 1),
(4, 2, '', 2, '1000', 0, 10, '200', NULL, 2),
(5, 3, '', 5, '10000', 1, 10, '5000', NULL, 2),
(6, 4, '', 3, '10000', 0, 10, '3000', NULL, 2),
(10, 5, 'Bộ', 1, '4000000', NULL, 10, '800000', 4, NULL),
(11, 6, 'Bộ', 1, '4000000', NULL, 10, '800000', 4, NULL),
(20, 15, 'a', 1, '4000000', NULL, 10, '400000', 9, NULL),
(21, 16, 'a', 1, '4000000', NULL, 10, '400000', 9, NULL);

-- --------------------------------------------------------

--
-- Structure de la table `spare_sub`
--

CREATE TABLE IF NOT EXISTS `spare_sub` (
`spare_sub_id` int(11) NOT NULL,
  `spare_sub_name` varchar(20) DEFAULT NULL
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=5 ;

--
-- Contenu de la table `spare_sub`
--

INSERT INTO `spare_sub` (`spare_sub_id`, `spare_sub_name`) VALUES
(1, 'Ốc'),
(2, 'Bulong'),
(3, 'Cờ lê'),
(4, 'Ống khói');

-- --------------------------------------------------------

--
-- Structure de la table `spare_vehicle`
--

CREATE TABLE IF NOT EXISTS `spare_vehicle` (
`spare_vehicle_id` int(11) NOT NULL,
  `vehicle` int(11) DEFAULT NULL,
  `romooc` int(11) DEFAULT NULL,
  `spare_part` int(11) DEFAULT NULL,
  `start_time` int(11) DEFAULT NULL,
  `end_time` int(11) DEFAULT NULL,
  `spare_part_number` float DEFAULT NULL,
  `export_stock` int(11) DEFAULT NULL
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=20 ;

--
-- Contenu de la table `spare_vehicle`
--

INSERT INTO `spare_vehicle` (`spare_vehicle_id`, `vehicle`, `romooc`, `spare_part`, `start_time`, `end_time`, `spare_part_number`, `export_stock`) VALUES
(9, 1, 0, 3, 1488322800, 0, 1, 2),
(10, 1, NULL, 2, 1490911200, NULL, 1, 2),
(11, NULL, 1, 4, 1490911200, NULL, 2, 2),
(18, 1, NULL, 3, NULL, 1490911200, 1, NULL),
(19, NULL, 1, 4, NULL, 1490911200, 1, NULL);

-- --------------------------------------------------------

--
-- Structure de la table `staff`
--

CREATE TABLE IF NOT EXISTS `staff` (
`staff_id` int(11) NOT NULL,
  `staff_code` varchar(50) DEFAULT NULL,
  `staff_name` varchar(50) DEFAULT NULL,
  `staff_birth` varchar(10) DEFAULT NULL,
  `staff_gender` int(11) DEFAULT NULL COMMENT '0:Male | 1:Female',
  `staff_address` varchar(200) DEFAULT NULL,
  `staff_phone` varchar(20) DEFAULT NULL,
  `staff_email` varchar(50) DEFAULT NULL,
  `cmnd` varchar(15) DEFAULT NULL,
  `bank` varchar(50) DEFAULT NULL,
  `account` int(11) DEFAULT NULL,
  `staff_create_user` int(11) DEFAULT NULL,
  `staff_create_time` varchar(20) DEFAULT NULL,
  `staff_update_user` int(11) DEFAULT NULL,
  `staff_update_time` int(11) DEFAULT NULL,
  `status` int(11) DEFAULT NULL,
  `position` varchar(50) DEFAULT NULL,
  `priority` int(11) DEFAULT NULL,
  `start_date` int(11) DEFAULT NULL,
  `end_date` int(11) DEFAULT NULL,
  `department` int(11) DEFAULT NULL
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=2 ;

--
-- Contenu de la table `staff`
--

INSERT INTO `staff` (`staff_id`, `staff_code`, `staff_name`, `staff_birth`, `staff_gender`, `staff_address`, `staff_phone`, `staff_email`, `cmnd`, `bank`, `account`, `staff_create_user`, `staff_create_time`, `staff_update_user`, `staff_update_time`, `status`, `position`, `priority`, `start_date`, `end_date`, `department`) VALUES
(1, 'NV01', 'Nguyễn Văn A', '01/04/1980', 0, 'Đồng Nai', '090 324 3344', 'a@abc.com', '221231421', '00032124313', 0, 41, '04/2017', NULL, NULL, 1, 'Nhân viên kỹ thuật', 0, 1490997600, 0, 1);

-- --------------------------------------------------------

--
-- Structure de la table `staff_temp`
--

CREATE TABLE IF NOT EXISTS `staff_temp` (
`staff_temp_id` int(11) NOT NULL,
  `staff_id` int(11) NOT NULL,
  `staff_code` varchar(50) DEFAULT NULL,
  `staff_name` varchar(50) DEFAULT NULL,
  `staff_birth` varchar(10) DEFAULT NULL,
  `staff_gender` int(11) DEFAULT NULL COMMENT '0:Male | 1:Female',
  `staff_address` varchar(200) DEFAULT NULL,
  `staff_phone` varchar(20) DEFAULT NULL,
  `staff_email` varchar(50) DEFAULT NULL,
  `cmnd` varchar(15) DEFAULT NULL,
  `bank` varchar(50) DEFAULT NULL,
  `account` int(11) DEFAULT NULL,
  `staff_create_user` int(11) DEFAULT NULL,
  `staff_create_time` varchar(20) DEFAULT NULL,
  `staff_update_user` int(11) DEFAULT NULL,
  `staff_update_time` int(11) DEFAULT NULL,
  `status` int(11) DEFAULT NULL,
  `position` varchar(50) DEFAULT NULL,
  `priority` int(11) DEFAULT NULL,
  `start_date` int(11) DEFAULT NULL,
  `end_date` int(11) DEFAULT NULL,
  `department` int(11) DEFAULT NULL,
  `staff_temp_date` int(11) DEFAULT NULL,
  `staff_temp_action` int(11) DEFAULT NULL,
  `staff_temp_user` int(11) DEFAULT NULL,
  `name` varchar(20) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Structure de la table `steersman`
--

CREATE TABLE IF NOT EXISTS `steersman` (
`steersman_id` int(11) NOT NULL,
  `steersman_code` varchar(50) DEFAULT NULL,
  `steersman_name` varchar(50) DEFAULT NULL,
  `steersman_birth` int(11) DEFAULT NULL,
  `steersman_bank` varchar(20) DEFAULT NULL,
  `steersman_start_time` int(11) DEFAULT NULL,
  `steersman_end_time` int(11) DEFAULT NULL,
  `steersman_phone` varchar(20) DEFAULT NULL,
  `steersman_cmnd` int(11) DEFAULT NULL,
  `steersman_gplx` varchar(20) DEFAULT NULL
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=44 ;

--
-- Contenu de la table `steersman`
--

INSERT INTO `steersman` (`steersman_id`, `steersman_code`, `steersman_name`, `steersman_birth`, `steersman_bank`, `steersman_start_time`, `steersman_end_time`, `steersman_phone`, `steersman_cmnd`, `steersman_gplx`) VALUES
(41, 'MT01', 'Nguyễn Văn A', 1489791600, 'ACB2323001', 1490310000, 1490911200, '090 208 5911', 2147483647, 'GP3236465454'),
(42, 'MT02', 'ABC', 1490223600, '545454545', 1490223600, 0, '090 208 5988', 2147483647, '2323');

-- --------------------------------------------------------

--
-- Structure de la table `steersman_temp`
--

CREATE TABLE IF NOT EXISTS `steersman_temp` (
`steersman_temp_id` int(11) NOT NULL,
  `steersman_id` int(11) NOT NULL,
  `steersman_code` varchar(50) DEFAULT NULL,
  `steersman_name` varchar(50) DEFAULT NULL,
  `steersman_birth` int(11) DEFAULT NULL,
  `steersman_bank` varchar(20) DEFAULT NULL,
  `steersman_start_time` int(11) DEFAULT NULL,
  `steersman_end_time` int(11) DEFAULT NULL,
  `steersman_phone` varchar(20) DEFAULT NULL,
  `steersman_cmnd` int(11) DEFAULT NULL,
  `steersman_gplx` varchar(20) DEFAULT NULL,
  `steersman_temp_date` int(11) DEFAULT NULL,
  `steersman_temp_action` int(11) DEFAULT NULL COMMENT '1:Add | 2:Edit | 3:Delete',
  `steersman_temp_user` int(11) DEFAULT NULL,
  `name` varchar(20) DEFAULT NULL
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=6 ;

--
-- Contenu de la table `steersman_temp`
--

INSERT INTO `steersman_temp` (`steersman_temp_id`, `steersman_id`, `steersman_code`, `steersman_name`, `steersman_birth`, `steersman_bank`, `steersman_start_time`, `steersman_end_time`, `steersman_phone`, `steersman_cmnd`, `steersman_gplx`, `steersman_temp_date`, `steersman_temp_action`, `steersman_temp_user`, `name`) VALUES
(1, 43, 'a', 'a', 0, '', 1489618800, 0, '0', 0, '', 1490652000, 1, 41, 'DS tài xế'),
(2, 43, 'a', 'a', -94266000, '323', 1489618800, 0, '0534', 2323, '2323', 1490652000, 2, 41, 'DS tài xế'),
(3, 43, 'a', 'a', -94266000, '323', 1489618800, 0, '0534', 2323, '2323', 1490652000, 2, 41, 'DS tài xế'),
(4, 43, 'as', 'aa', -94266000, '323', 1489618800, 0, '0534', 2323, '2323', 1490652000, 2, 41, 'DS tài xế'),
(5, 43, 'as', 'aa', -94266000, '323', 1489618800, 0, '0534', 2323, '2323', 1490652000, 3, 41, 'DS tài xế');

-- --------------------------------------------------------

--
-- Structure de la table `tax`
--

CREATE TABLE IF NOT EXISTS `tax` (
`tax_id` int(11) NOT NULL,
  `tax_date` int(11) DEFAULT NULL,
  `driver` int(11) DEFAULT NULL,
  `money` decimal(10,0) DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Structure de la table `toll`
--

CREATE TABLE IF NOT EXISTS `toll` (
`toll_id` int(11) NOT NULL,
  `toll_name` varchar(200) DEFAULT NULL,
  `toll_mst` varchar(50) DEFAULT NULL,
  `toll_type` int(11) DEFAULT NULL COMMENT '1: Vé thu phí | 2: Cước đường bộ',
  `toll_symbol` varchar(20) DEFAULT NULL
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=4 ;

--
-- Contenu de la table `toll`
--

INSERT INTO `toll` (`toll_id`, `toll_name`, `toll_mst`, `toll_type`, `toll_symbol`) VALUES
(1, 'QL1', '03254659-1', 1, 't2033'),
(2, 'QL2', '52456666', 2, '545454a'),
(3, '', '', 1, '');

-- --------------------------------------------------------

--
-- Structure de la table `toll_temp`
--

CREATE TABLE IF NOT EXISTS `toll_temp` (
`toll_temp_id` int(11) NOT NULL,
  `toll_id` int(11) NOT NULL,
  `toll_name` varchar(200) DEFAULT NULL,
  `toll_mst` varchar(50) DEFAULT NULL,
  `toll_type` int(11) DEFAULT NULL COMMENT '1: Vé thu phí | 2: Cước đường bộ',
  `toll_symbol` varchar(20) DEFAULT NULL,
  `toll_temp_date` int(11) DEFAULT NULL,
  `toll_temp_action` int(11) DEFAULT NULL COMMENT '1:Add | 2:Edit | 3:Delete',
  `toll_temp_user` int(11) DEFAULT NULL,
  `name` varchar(20) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Structure de la table `toxic`
--

CREATE TABLE IF NOT EXISTS `toxic` (
`toxic_id` int(11) NOT NULL,
  `toxic_date` int(11) DEFAULT NULL,
  `driver` int(11) DEFAULT NULL,
  `money` decimal(10,0) DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Structure de la table `user`
--

CREATE TABLE IF NOT EXISTS `user` (
`user_id` int(11) NOT NULL,
  `username` varchar(50) NOT NULL,
  `password` varchar(200) NOT NULL,
  `create_time` int(11) NOT NULL,
  `role` int(11) NOT NULL,
  `user_lock` int(11) DEFAULT NULL,
  `user_group` int(11) DEFAULT NULL,
  `user_dept` int(11) DEFAULT NULL
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=42 ;

--
-- Contenu de la table `user`
--

INSERT INTO `user` (`user_id`, `username`, `password`, `create_time`, `role`, `user_lock`, `user_group`, `user_dept`) VALUES
(41, 'admin', '81dc9bdb52d04dc20036dbd8313ed055', 1411375062, 1, NULL, NULL, NULL);

-- --------------------------------------------------------

--
-- Structure de la table `vehicle`
--

CREATE TABLE IF NOT EXISTS `vehicle` (
`vehicle_id` int(11) NOT NULL,
  `vehicle_number` varchar(20) DEFAULT NULL,
  `cont_number` varchar(20) DEFAULT NULL,
  `vehicle_type` int(11) DEFAULT NULL COMMENT '1:Mới | 2:Thuê | 3:Cũ'
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=3 ;

--
-- Contenu de la table `vehicle`
--

INSERT INTO `vehicle` (`vehicle_id`, `vehicle_number`, `cont_number`, `vehicle_type`) VALUES
(1, '51C-34567', 'WLU201020341', 1),
(2, '72F-4321', '', 2);

-- --------------------------------------------------------

--
-- Structure de la table `vehicle_romooc`
--

CREATE TABLE IF NOT EXISTS `vehicle_romooc` (
`vehicle_romooc_id` int(11) NOT NULL,
  `vehicle` int(11) DEFAULT NULL,
  `romooc` int(11) DEFAULT NULL,
  `start_time` int(11) DEFAULT NULL,
  `end_time` int(11) DEFAULT NULL
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=18 ;

--
-- Contenu de la table `vehicle_romooc`
--

INSERT INTO `vehicle_romooc` (`vehicle_romooc_id`, `vehicle`, `romooc`, `start_time`, `end_time`) VALUES
(14, 1, 2, 1490738400, 1490911200),
(15, 1, 1, 1488322800, 1490652000),
(16, 1, 1, 1491084000, 1493503200),
(17, 1, 2, 1490997600, NULL);

-- --------------------------------------------------------

--
-- Structure de la table `vehicle_temp`
--

CREATE TABLE IF NOT EXISTS `vehicle_temp` (
`vehicle_temp_id` int(11) NOT NULL,
  `vehicle_id` int(11) NOT NULL,
  `vehicle_number` varchar(20) DEFAULT NULL,
  `cont_number` varchar(20) DEFAULT NULL,
  `vehicle_type` int(11) DEFAULT NULL COMMENT '1:Mới | 2:Thuê | 3:Cũ',
  `vehicle_temp_date` int(11) DEFAULT NULL,
  `vehicle_temp_action` int(11) DEFAULT NULL COMMENT '1:Add | 2:Edit | 3:Delete',
  `vehicle_temp_user` int(11) DEFAULT NULL,
  `name` varchar(20) DEFAULT NULL
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=6 ;

--
-- Contenu de la table `vehicle_temp`
--

INSERT INTO `vehicle_temp` (`vehicle_temp_id`, `vehicle_id`, `vehicle_number`, `cont_number`, `vehicle_type`, `vehicle_temp_date`, `vehicle_temp_action`, `vehicle_temp_user`, `name`) VALUES
(1, 3, 'rre', 'fdf', 1, 1490652000, 1, 41, 'DS xe'),
(2, 3, 'rregfg', 'fdfgfg', 1, 1490652000, 2, 41, 'DS xe'),
(3, 3, NULL, NULL, NULL, 1490652000, 3, 41, 'DS tài xế'),
(4, 4, 'a', 'a', 1, 1490652000, 1, 41, 'DS xe'),
(5, 4, 'a', 'a', 1, 1490652000, 3, 41, 'DS tài xế');

-- --------------------------------------------------------

--
-- Structure de la table `vehicle_work`
--

CREATE TABLE IF NOT EXISTS `vehicle_work` (
`vehicle_work_id` int(11) NOT NULL,
  `vehicle` int(11) DEFAULT NULL,
  `start_work` int(11) DEFAULT NULL,
  `end_work` int(11) DEFAULT NULL
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=41 ;

--
-- Contenu de la table `vehicle_work`
--

INSERT INTO `vehicle_work` (`vehicle_work_id`, `vehicle`, `start_work`, `end_work`) VALUES
(39, 1, 1490137200, 1805670000),
(40, 1, 1490824800, 1806357600);

-- --------------------------------------------------------

--
-- Structure de la table `vehicle_work_temp`
--

CREATE TABLE IF NOT EXISTS `vehicle_work_temp` (
`vehicle_work_temp_id` int(11) NOT NULL,
  `vehicle_work_id` int(11) NOT NULL,
  `vehicle` int(11) DEFAULT NULL,
  `start_work` int(11) DEFAULT NULL,
  `end_work` int(11) DEFAULT NULL,
  `vehicle_work_temp_date` int(11) DEFAULT NULL,
  `vehicle_work_temp_action` int(11) DEFAULT NULL COMMENT '1:Add | 2:Edit | 3:Delete',
  `vehicle_work_temp_user` int(11) DEFAULT NULL,
  `name` varchar(20) DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Structure de la table `warehouse`
--

CREATE TABLE IF NOT EXISTS `warehouse` (
`warehouse_id` int(11) NOT NULL,
  `warehouse_name` varchar(200) DEFAULT NULL,
  `warehouse_cont` decimal(10,0) DEFAULT NULL,
  `warehouse_ton` decimal(10,0) DEFAULT NULL,
  `warehouse_weight` decimal(10,0) DEFAULT NULL,
  `warehouse_clean` decimal(10,0) DEFAULT NULL,
  `warehouse_gate` decimal(10,0) DEFAULT NULL,
  `warehouse_add` decimal(10,0) DEFAULT NULL,
  `status` int(11) DEFAULT NULL,
  `start_time` int(11) DEFAULT NULL,
  `end_time` int(11) DEFAULT NULL,
  `warehouse_code` int(11) DEFAULT NULL,
  `check_new` int(11) DEFAULT NULL
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=663 ;

--
-- Contenu de la table `warehouse`
--

INSERT INTO `warehouse` (`warehouse_id`, `warehouse_name`, `warehouse_cont`, `warehouse_ton`, `warehouse_weight`, `warehouse_clean`, `warehouse_gate`, `warehouse_add`, `status`, `start_time`, `end_time`, `warehouse_code`, `check_new`) VALUES
(660, 'Cát Lái', '60000', '20000', '20000', '20000', '10000', '10000', 1, 1490310000, 1490824800, 1, NULL),
(661, 'Cát Lái', '20000', '0', '0', '0', '0', '20000', 1, 1490911200, 1806444000, 1, NULL);

-- --------------------------------------------------------

--
-- Structure de la table `warehouse_temp`
--

CREATE TABLE IF NOT EXISTS `warehouse_temp` (
`warehouse_temp_id` int(11) NOT NULL,
  `warehouse_id` int(11) NOT NULL,
  `warehouse_name` varchar(200) DEFAULT NULL,
  `warehouse_cont` decimal(10,0) DEFAULT NULL,
  `warehouse_ton` decimal(10,0) DEFAULT NULL,
  `warehouse_weight` decimal(10,0) DEFAULT NULL,
  `warehouse_clean` decimal(10,0) DEFAULT NULL,
  `warehouse_gate` decimal(10,0) DEFAULT NULL,
  `warehouse_add` decimal(10,0) DEFAULT NULL,
  `status` int(11) DEFAULT NULL,
  `start_time` int(11) DEFAULT NULL,
  `end_time` int(11) DEFAULT NULL,
  `warehouse_code` int(11) DEFAULT NULL,
  `check_new` int(11) DEFAULT NULL,
  `warehouse_temp_date` int(11) DEFAULT NULL,
  `warehouse_temp_action` int(11) DEFAULT NULL COMMENT '1:Add | 2:Edit | 3:Delete',
  `warehouse_temp_user` int(11) DEFAULT NULL,
  `name` varchar(20) DEFAULT NULL
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=2 ;

--
-- Index pour les tables exportées
--

--
-- Index pour la table `account`
--
ALTER TABLE `account`
 ADD PRIMARY KEY (`account_id`);

--
-- Index pour la table `bank`
--
ALTER TABLE `bank`
 ADD PRIMARY KEY (`bank_id`);

--
-- Index pour la table `bridge_cost`
--
ALTER TABLE `bridge_cost`
 ADD PRIMARY KEY (`bridge_cost_id`);

--
-- Index pour la table `bridge_cost_temp`
--
ALTER TABLE `bridge_cost_temp`
 ADD PRIMARY KEY (`bridge_cost_temp_id`), ADD KEY `bridge_cost_temp_id` (`bridge_cost_temp_id`);

--
-- Index pour la table `contact_person`
--
ALTER TABLE `contact_person`
 ADD PRIMARY KEY (`contact_person_id`);

--
-- Index pour la table `cont_unit`
--
ALTER TABLE `cont_unit`
 ADD PRIMARY KEY (`cont_unit_id`);

--
-- Index pour la table `cost_list`
--
ALTER TABLE `cost_list`
 ADD PRIMARY KEY (`cost_list_id`);

--
-- Index pour la table `cost_type`
--
ALTER TABLE `cost_type`
 ADD PRIMARY KEY (`cost_type_id`);

--
-- Index pour la table `customer`
--
ALTER TABLE `customer`
 ADD PRIMARY KEY (`customer_id`);

--
-- Index pour la table `customer_sub`
--
ALTER TABLE `customer_sub`
 ADD PRIMARY KEY (`customer_sub_id`);

--
-- Index pour la table `customer_temp`
--
ALTER TABLE `customer_temp`
 ADD PRIMARY KEY (`customer_temp_id`);

--
-- Index pour la table `debit`
--
ALTER TABLE `debit`
 ADD PRIMARY KEY (`debit_id`);

--
-- Index pour la table `department`
--
ALTER TABLE `department`
 ADD PRIMARY KEY (`department_id`);

--
-- Index pour la table `department_temp`
--
ALTER TABLE `department_temp`
 ADD PRIMARY KEY (`department_temp_id`);

--
-- Index pour la table `distance`
--
ALTER TABLE `distance`
 ADD PRIMARY KEY (`distance_id`);

--
-- Index pour la table `distance_temp`
--
ALTER TABLE `distance_temp`
 ADD PRIMARY KEY (`distance_temp_id`), ADD KEY `distance_temp_id` (`distance_temp_id`);

--
-- Index pour la table `driver`
--
ALTER TABLE `driver`
 ADD PRIMARY KEY (`driver_id`);

--
-- Index pour la table `driver_temp`
--
ALTER TABLE `driver_temp`
 ADD PRIMARY KEY (`driver_temp_id`), ADD KEY `driver_temp_id` (`driver_temp_id`);

--
-- Index pour la table `excess`
--
ALTER TABLE `excess`
 ADD PRIMARY KEY (`excess_id`);

--
-- Index pour la table `export_stock`
--
ALTER TABLE `export_stock`
 ADD PRIMARY KEY (`export_stock_id`);

--
-- Index pour la table `house`
--
ALTER TABLE `house`
 ADD PRIMARY KEY (`house_id`);

--
-- Index pour la table `house_temp`
--
ALTER TABLE `house_temp`
 ADD PRIMARY KEY (`house_temp_id`);

--
-- Index pour la table `import_stock`
--
ALTER TABLE `import_stock`
 ADD PRIMARY KEY (`import_stock_id`);

--
-- Index pour la table `import_stock_cost`
--
ALTER TABLE `import_stock_cost`
 ADD PRIMARY KEY (`import_stock_cost_id`);

--
-- Index pour la table `info`
--
ALTER TABLE `info`
 ADD PRIMARY KEY (`info_id`);

--
-- Index pour la table `insurance`
--
ALTER TABLE `insurance`
 ADD PRIMARY KEY (`insurance_id`);

--
-- Index pour la table `loan_shipment`
--
ALTER TABLE `loan_shipment`
 ADD PRIMARY KEY (`loan_shipment_id`);

--
-- Index pour la table `loan_unit`
--
ALTER TABLE `loan_unit`
 ADD PRIMARY KEY (`loan_unit_id`);

--
-- Index pour la table `marketing`
--
ALTER TABLE `marketing`
 ADD PRIMARY KEY (`marketing_id`);

--
-- Index pour la table `oil`
--
ALTER TABLE `oil`
 ADD PRIMARY KEY (`oil_id`);

--
-- Index pour la table `oil_temp`
--
ALTER TABLE `oil_temp`
 ADD PRIMARY KEY (`oil_temp_id`), ADD KEY `oil_temp_id` (`oil_temp_id`);

--
-- Index pour la table `overtime`
--
ALTER TABLE `overtime`
 ADD PRIMARY KEY (`overtime_id`);

--
-- Index pour la table `place`
--
ALTER TABLE `place`
 ADD PRIMARY KEY (`place_id`);

--
-- Index pour la table `place_temp`
--
ALTER TABLE `place_temp`
 ADD PRIMARY KEY (`place_temp_id`), ADD KEY `place_temp_id` (`place_temp_id`);

--
-- Index pour la table `province`
--
ALTER TABLE `province`
 ADD PRIMARY KEY (`province_id`);

--
-- Index pour la table `repair`
--
ALTER TABLE `repair`
 ADD PRIMARY KEY (`repair_id`);

--
-- Index pour la table `repair_list`
--
ALTER TABLE `repair_list`
 ADD PRIMARY KEY (`repair_list_id`);

--
-- Index pour la table `road`
--
ALTER TABLE `road`
 ADD PRIMARY KEY (`road_id`);

--
-- Index pour la table `road_temp`
--
ALTER TABLE `road_temp`
 ADD PRIMARY KEY (`road_temp_id`), ADD KEY `road_temp_id` (`road_temp_id`);

--
-- Index pour la table `role`
--
ALTER TABLE `role`
 ADD PRIMARY KEY (`role_id`);

--
-- Index pour la table `romooc`
--
ALTER TABLE `romooc`
 ADD PRIMARY KEY (`romooc_id`);

--
-- Index pour la table `romooc_temp`
--
ALTER TABLE `romooc_temp`
 ADD PRIMARY KEY (`romooc_temp_id`);

--
-- Index pour la table `route`
--
ALTER TABLE `route`
 ADD PRIMARY KEY (`route_id`);

--
-- Index pour la table `route_temp`
--
ALTER TABLE `route_temp`
 ADD PRIMARY KEY (`route_temp_id`);

--
-- Index pour la table `salary_bonus`
--
ALTER TABLE `salary_bonus`
 ADD PRIMARY KEY (`salary_bonus_id`);

--
-- Index pour la table `shipment`
--
ALTER TABLE `shipment`
 ADD PRIMARY KEY (`shipment_id`);

--
-- Index pour la table `shipment_cost`
--
ALTER TABLE `shipment_cost`
 ADD PRIMARY KEY (`shipment_cost_id`);

--
-- Index pour la table `shipment_temp`
--
ALTER TABLE `shipment_temp`
 ADD PRIMARY KEY (`shipment_temp_id`);

--
-- Index pour la table `shipment_two`
--
ALTER TABLE `shipment_two`
 ADD PRIMARY KEY (`shipment_two_id`);

--
-- Index pour la table `spare_drap`
--
ALTER TABLE `spare_drap`
 ADD PRIMARY KEY (`spare_drap_id`);

--
-- Index pour la table `spare_part`
--
ALTER TABLE `spare_part`
 ADD PRIMARY KEY (`spare_part_id`);

--
-- Index pour la table `spare_part_code`
--
ALTER TABLE `spare_part_code`
 ADD PRIMARY KEY (`spare_part_code_id`);

--
-- Index pour la table `spare_part_temp`
--
ALTER TABLE `spare_part_temp`
 ADD PRIMARY KEY (`spare_part_temp_id`);

--
-- Index pour la table `spare_stock`
--
ALTER TABLE `spare_stock`
 ADD PRIMARY KEY (`spare_stock_id`);

--
-- Index pour la table `spare_sub`
--
ALTER TABLE `spare_sub`
 ADD PRIMARY KEY (`spare_sub_id`);

--
-- Index pour la table `spare_vehicle`
--
ALTER TABLE `spare_vehicle`
 ADD PRIMARY KEY (`spare_vehicle_id`);

--
-- Index pour la table `staff`
--
ALTER TABLE `staff`
 ADD PRIMARY KEY (`staff_id`);

--
-- Index pour la table `staff_temp`
--
ALTER TABLE `staff_temp`
 ADD PRIMARY KEY (`staff_temp_id`);

--
-- Index pour la table `steersman`
--
ALTER TABLE `steersman`
 ADD PRIMARY KEY (`steersman_id`);

--
-- Index pour la table `steersman_temp`
--
ALTER TABLE `steersman_temp`
 ADD PRIMARY KEY (`steersman_temp_id`), ADD KEY `steersman_temp_id` (`steersman_temp_id`);

--
-- Index pour la table `tax`
--
ALTER TABLE `tax`
 ADD PRIMARY KEY (`tax_id`);

--
-- Index pour la table `toll`
--
ALTER TABLE `toll`
 ADD PRIMARY KEY (`toll_id`);

--
-- Index pour la table `toll_temp`
--
ALTER TABLE `toll_temp`
 ADD PRIMARY KEY (`toll_temp_id`), ADD KEY `toll_temp_id` (`toll_temp_id`);

--
-- Index pour la table `toxic`
--
ALTER TABLE `toxic`
 ADD PRIMARY KEY (`toxic_id`);

--
-- Index pour la table `user`
--
ALTER TABLE `user`
 ADD PRIMARY KEY (`user_id`);

--
-- Index pour la table `vehicle`
--
ALTER TABLE `vehicle`
 ADD PRIMARY KEY (`vehicle_id`);

--
-- Index pour la table `vehicle_romooc`
--
ALTER TABLE `vehicle_romooc`
 ADD PRIMARY KEY (`vehicle_romooc_id`);

--
-- Index pour la table `vehicle_temp`
--
ALTER TABLE `vehicle_temp`
 ADD PRIMARY KEY (`vehicle_temp_id`), ADD KEY `vehicle_temp_id` (`vehicle_temp_id`);

--
-- Index pour la table `vehicle_work`
--
ALTER TABLE `vehicle_work`
 ADD PRIMARY KEY (`vehicle_work_id`);

--
-- Index pour la table `vehicle_work_temp`
--
ALTER TABLE `vehicle_work_temp`
 ADD PRIMARY KEY (`vehicle_work_temp_id`), ADD KEY `vehicle_work_temp_id` (`vehicle_work_temp_id`);

--
-- Index pour la table `warehouse`
--
ALTER TABLE `warehouse`
 ADD PRIMARY KEY (`warehouse_id`);

--
-- Index pour la table `warehouse_temp`
--
ALTER TABLE `warehouse_temp`
 ADD PRIMARY KEY (`warehouse_temp_id`), ADD KEY `id` (`warehouse_temp_id`);

--
-- AUTO_INCREMENT pour les tables exportées
--

--
-- AUTO_INCREMENT pour la table `account`
--
ALTER TABLE `account`
MODIFY `account_id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=14;
--
-- AUTO_INCREMENT pour la table `bank`
--
ALTER TABLE `bank`
MODIFY `bank_id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=2;
--
-- AUTO_INCREMENT pour la table `bridge_cost`
--
ALTER TABLE `bridge_cost`
MODIFY `bridge_cost_id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=1865;
--
-- AUTO_INCREMENT pour la table `bridge_cost_temp`
--
ALTER TABLE `bridge_cost_temp`
MODIFY `bridge_cost_temp_id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT pour la table `contact_person`
--
ALTER TABLE `contact_person`
MODIFY `contact_person_id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=2;
--
-- AUTO_INCREMENT pour la table `cont_unit`
--
ALTER TABLE `cont_unit`
MODIFY `cont_unit_id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=4;
--
-- AUTO_INCREMENT pour la table `cost_list`
--
ALTER TABLE `cost_list`
MODIFY `cost_list_id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=2;
--
-- AUTO_INCREMENT pour la table `cost_type`
--
ALTER TABLE `cost_type`
MODIFY `cost_type_id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=12;
--
-- AUTO_INCREMENT pour la table `customer`
--
ALTER TABLE `customer`
MODIFY `customer_id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=2;
--
-- AUTO_INCREMENT pour la table `customer_sub`
--
ALTER TABLE `customer_sub`
MODIFY `customer_sub_id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=4;
--
-- AUTO_INCREMENT pour la table `customer_temp`
--
ALTER TABLE `customer_temp`
MODIFY `customer_temp_id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=2;
--
-- AUTO_INCREMENT pour la table `debit`
--
ALTER TABLE `debit`
MODIFY `debit_id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=6;
--
-- AUTO_INCREMENT pour la table `department`
--
ALTER TABLE `department`
MODIFY `department_id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=2;
--
-- AUTO_INCREMENT pour la table `department_temp`
--
ALTER TABLE `department_temp`
MODIFY `department_temp_id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT pour la table `distance`
--
ALTER TABLE `distance`
MODIFY `distance_id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=9;
--
-- AUTO_INCREMENT pour la table `distance_temp`
--
ALTER TABLE `distance_temp`
MODIFY `distance_temp_id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT pour la table `driver`
--
ALTER TABLE `driver`
MODIFY `driver_id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=57;
--
-- AUTO_INCREMENT pour la table `driver_temp`
--
ALTER TABLE `driver_temp`
MODIFY `driver_temp_id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT pour la table `excess`
--
ALTER TABLE `excess`
MODIFY `excess_id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=2414;
--
-- AUTO_INCREMENT pour la table `export_stock`
--
ALTER TABLE `export_stock`
MODIFY `export_stock_id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=3;
--
-- AUTO_INCREMENT pour la table `house`
--
ALTER TABLE `house`
MODIFY `house_id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=2;
--
-- AUTO_INCREMENT pour la table `house_temp`
--
ALTER TABLE `house_temp`
MODIFY `house_temp_id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=3;
--
-- AUTO_INCREMENT pour la table `import_stock`
--
ALTER TABLE `import_stock`
MODIFY `import_stock_id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=10;
--
-- AUTO_INCREMENT pour la table `import_stock_cost`
--
ALTER TABLE `import_stock_cost`
MODIFY `import_stock_cost_id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=2;
--
-- AUTO_INCREMENT pour la table `info`
--
ALTER TABLE `info`
MODIFY `info_id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=2;
--
-- AUTO_INCREMENT pour la table `insurance`
--
ALTER TABLE `insurance`
MODIFY `insurance_id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=15;
--
-- AUTO_INCREMENT pour la table `loan_shipment`
--
ALTER TABLE `loan_shipment`
MODIFY `loan_shipment_id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=10;
--
-- AUTO_INCREMENT pour la table `loan_unit`
--
ALTER TABLE `loan_unit`
MODIFY `loan_unit_id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=4;
--
-- AUTO_INCREMENT pour la table `marketing`
--
ALTER TABLE `marketing`
MODIFY `marketing_id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=17;
--
-- AUTO_INCREMENT pour la table `oil`
--
ALTER TABLE `oil`
MODIFY `oil_id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=3;
--
-- AUTO_INCREMENT pour la table `oil_temp`
--
ALTER TABLE `oil_temp`
MODIFY `oil_temp_id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=4;
--
-- AUTO_INCREMENT pour la table `overtime`
--
ALTER TABLE `overtime`
MODIFY `overtime_id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT pour la table `place`
--
ALTER TABLE `place`
MODIFY `place_id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=3;
--
-- AUTO_INCREMENT pour la table `place_temp`
--
ALTER TABLE `place_temp`
MODIFY `place_temp_id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=4;
--
-- AUTO_INCREMENT pour la table `province`
--
ALTER TABLE `province`
MODIFY `province_id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=63;
--
-- AUTO_INCREMENT pour la table `repair`
--
ALTER TABLE `repair`
MODIFY `repair_id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=2;
--
-- AUTO_INCREMENT pour la table `repair_list`
--
ALTER TABLE `repair_list`
MODIFY `repair_list_id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=3;
--
-- AUTO_INCREMENT pour la table `road`
--
ALTER TABLE `road`
MODIFY `road_id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=2181;
--
-- AUTO_INCREMENT pour la table `road_temp`
--
ALTER TABLE `road_temp`
MODIFY `road_temp_id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=5;
--
-- AUTO_INCREMENT pour la table `role`
--
ALTER TABLE `role`
MODIFY `role_id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=22;
--
-- AUTO_INCREMENT pour la table `romooc`
--
ALTER TABLE `romooc`
MODIFY `romooc_id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=3;
--
-- AUTO_INCREMENT pour la table `romooc_temp`
--
ALTER TABLE `romooc_temp`
MODIFY `romooc_temp_id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=6;
--
-- AUTO_INCREMENT pour la table `route`
--
ALTER TABLE `route`
MODIFY `route_id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=3;
--
-- AUTO_INCREMENT pour la table `route_temp`
--
ALTER TABLE `route_temp`
MODIFY `route_temp_id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=3;
--
-- AUTO_INCREMENT pour la table `salary_bonus`
--
ALTER TABLE `salary_bonus`
MODIFY `salary_bonus_id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=6;
--
-- AUTO_INCREMENT pour la table `shipment`
--
ALTER TABLE `shipment`
MODIFY `shipment_id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=12184;
--
-- AUTO_INCREMENT pour la table `shipment_cost`
--
ALTER TABLE `shipment_cost`
MODIFY `shipment_cost_id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=6;
--
-- AUTO_INCREMENT pour la table `shipment_temp`
--
ALTER TABLE `shipment_temp`
MODIFY `shipment_temp_id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=6;
--
-- AUTO_INCREMENT pour la table `shipment_two`
--
ALTER TABLE `shipment_two`
MODIFY `shipment_two_id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT pour la table `spare_drap`
--
ALTER TABLE `spare_drap`
MODIFY `spare_drap_id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=3;
--
-- AUTO_INCREMENT pour la table `spare_part`
--
ALTER TABLE `spare_part`
MODIFY `spare_part_id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=18;
--
-- AUTO_INCREMENT pour la table `spare_part_code`
--
ALTER TABLE `spare_part_code`
MODIFY `spare_part_code_id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=4;
--
-- AUTO_INCREMENT pour la table `spare_part_temp`
--
ALTER TABLE `spare_part_temp`
MODIFY `spare_part_temp_id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=15;
--
-- AUTO_INCREMENT pour la table `spare_stock`
--
ALTER TABLE `spare_stock`
MODIFY `spare_stock_id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=23;
--
-- AUTO_INCREMENT pour la table `spare_sub`
--
ALTER TABLE `spare_sub`
MODIFY `spare_sub_id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=5;
--
-- AUTO_INCREMENT pour la table `spare_vehicle`
--
ALTER TABLE `spare_vehicle`
MODIFY `spare_vehicle_id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=20;
--
-- AUTO_INCREMENT pour la table `staff`
--
ALTER TABLE `staff`
MODIFY `staff_id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=2;
--
-- AUTO_INCREMENT pour la table `staff_temp`
--
ALTER TABLE `staff_temp`
MODIFY `staff_temp_id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT pour la table `steersman`
--
ALTER TABLE `steersman`
MODIFY `steersman_id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=44;
--
-- AUTO_INCREMENT pour la table `steersman_temp`
--
ALTER TABLE `steersman_temp`
MODIFY `steersman_temp_id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=6;
--
-- AUTO_INCREMENT pour la table `tax`
--
ALTER TABLE `tax`
MODIFY `tax_id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT pour la table `toll`
--
ALTER TABLE `toll`
MODIFY `toll_id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=4;
--
-- AUTO_INCREMENT pour la table `toll_temp`
--
ALTER TABLE `toll_temp`
MODIFY `toll_temp_id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT pour la table `toxic`
--
ALTER TABLE `toxic`
MODIFY `toxic_id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT pour la table `user`
--
ALTER TABLE `user`
MODIFY `user_id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=42;
--
-- AUTO_INCREMENT pour la table `vehicle`
--
ALTER TABLE `vehicle`
MODIFY `vehicle_id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=3;
--
-- AUTO_INCREMENT pour la table `vehicle_romooc`
--
ALTER TABLE `vehicle_romooc`
MODIFY `vehicle_romooc_id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=18;
--
-- AUTO_INCREMENT pour la table `vehicle_temp`
--
ALTER TABLE `vehicle_temp`
MODIFY `vehicle_temp_id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=6;
--
-- AUTO_INCREMENT pour la table `vehicle_work`
--
ALTER TABLE `vehicle_work`
MODIFY `vehicle_work_id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=41;
--
-- AUTO_INCREMENT pour la table `vehicle_work_temp`
--
ALTER TABLE `vehicle_work_temp`
MODIFY `vehicle_work_temp_id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT pour la table `warehouse`
--
ALTER TABLE `warehouse`
MODIFY `warehouse_id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=663;
--
-- AUTO_INCREMENT pour la table `warehouse_temp`
--
ALTER TABLE `warehouse_temp`
MODIFY `warehouse_temp_id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=2;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
