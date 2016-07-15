CREATE DATABASE IF NOT EXISTS smartCardMarket;
use smartCardMarket;

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


CREATE TABLE `users` (
  `user_id` int(11) NOT NULL AUTO_INCREMENT,
  `email` varchar(100) NOT NULL,
  `password` varchar(100) NOT NULL,
  `user_first_name` varchar(50) NOT NULL,
  `user_last_name` varchar(50) DEFAULT NULL,
  `user_type_id` int(11) NOT NULL,
  `terms_conditions` smallint(6) NOT NULL DEFAULT '0',
  `created_time` int(11) NOT NULL,
  `is_active` smallint(6) NOT NULL DEFAULT '1',
  `is_verified` smallint(6) NOT NULL,
  `is_first_login` smallint(6) NOT NULL DEFAULT '0',
  `is_address_added` SMALLINT NULL DEFAULT '0',
  `is_settings_added` SMALLINT NULL DEFAULT '0',
  PRIMARY KEY (`user_id`),
  UNIQUE KEY `email` (`email`),
   INDEX `user_first_name` (`user_first_name`),
   INDEX `user_last_name` (`user_last_name`),
   INDEX `user_type_id` (`user_type_id`),
   INDEX `created_time` (`created_time`),
   INDEX `is_active` (`is_active`),
   INDEX `is_verified` (`is_verified`),
   INDEX `is_first_login` (`is_first_login`),
   INDEX `is_address_added` (`is_address_added`),
   INDEX `is_settings_added` (`is_settings_added`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;


INSERT INTO `users` (`user_id`, `email`, `password`, `user_first_name`, `user_last_name`, `user_type_id`, `terms_conditions`, `created_time`, `is_active`, `is_verified`) 
VALUES
(1, 'admin@smartcardmarket.com', '0192023a7bbd73250516f069df18b500', 'System', 'Admin', 1, 1, 1459747810, 1, 1),
(2, 'supplier@smartcardmarket.com', '0192023a7bbd73250516f069df18b500', 'System', 'Supplier', 3, 1, 1459747810, 1, 1),
(3, 'freight@smartcardmarket.com', '0192023a7bbd73250516f069df18b500', 'System', 'Freight', 4, 1, 1459747810, 1, 1);

CREATE TABLE `user_type` (
  `user_type_id` int(11) NOT NULL AUTO_INCREMENT,
  `user_type_name` varchar(50) NOT NULL,
  `is_active` smallint(6) NOT NULL DEFAULT '1',
  PRIMARY KEY (`user_type_id`),
  INDEX `user_type_name` (`user_type_name`),
  INDEX `is_active` (`is_active`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;



INSERT INTO `user_type` (`user_type_id`, `user_type_name`, `is_active`) VALUES
(1, 'Admin', 1),
(2, 'Consumer', 1),
(3, 'Supplier', 1),
(4, 'Freight Forwarder', 1);


CREATE TABLE `consumer_details` (
  `cd_id` int(11) NOT NULL AUTO_INCREMENT,
  `user_id` int(11) NOT NULL,
  `logo_path` varchar(250) NULL,
  `address_id` int(11) NOT NULL,
  `is_active` smallint(6) NOT NULL,
  PRIMARY KEY (`cd_id`),
  INDEX `user_id` (`user_id`),
  INDEX `address_id` (`address_id`),
  INDEX `is_active` (`is_active`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;


CREATE TABLE `supplier_details` (
  `sd_id` int(11) NOT NULL AUTO_INCREMENT,
  `user_id` int(11) NOT NULL,
  `company_name` varchar(50) NULL,
  `trading_name` varchar(100) NULL,
  `brand` varchar(250) NULL,
  `website_url` varchar(250) NULL,
  `minimum_order_quantity_id` int(11) NOT NULL,
  `description` text NULL,
  `logo_path` varchar(250) NULL,
  `address_id` int(11) NULL,
  `is_vetted` smallint(6) NOT NULL,
  `is_active` smallint(6) NOT NULL,
  PRIMARY KEY (`sd_id`),
  INDEX `logo_path` (`logo_path`),
  INDEX `address_id` (`address_id`),
  INDEX `user_id` (`user_id`),
  INDEX `company_name` (`company_name`),
  INDEX `trading_name` (`trading_name`),
  INDEX `brand` (`brand`),
  INDEX `website_url` (`website_url`),
  INDEX `minimum_order_quantity_id` (`minimum_order_quantity_id`), 
  INDEX `is_vetted` (`is_vetted`),
  INDEX `is_active` (`is_active`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;


INSERT INTO `supplier_details` (`sd_id`, `user_id`, `company_name`, `trading_name`, `brand`, `website_url`, `description`, `logo_path`, `address_id`, `is_vetted`, `is_active`) VALUES
(1, 2, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 0, 1);


CREATE TABLE `supplier_sub_category` (
  `ssc_id` int(11) NOT NULL AUTO_INCREMENT,
  `sd_id` int(11) NOT NULL,
  `sub_cat_id` int(11) NOT NULL,
  `is_active` smallint(6) NOT NULL,
  PRIMARY KEY (`ssc_id`),
  INDEX `sd_id` (`sd_id`),
  INDEX `sub_cat_id` (`sub_cat_id`),
  INDEX `is_active` (`is_active`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;


CREATE TABLE `freight_details` (
  `fd_id` int(11) NOT NULL AUTO_INCREMENT,
  `user_id` int(11) NOT NULL,
  `company_name` varchar(50) NULL,
  `trading_name` varchar(100) NULL,
  `brand` varchar(250) NULL,
  `website_url` varchar(250) NULL,
  `description` text NULL,
  `logo_path` varchar(250) NULL,
  `address_id` int(11) NULL,
  `is_vetted` smallint(6) NOT NULL,
  `is_active` smallint(6) NOT NULL,
  PRIMARY KEY (`fd_id`),
  INDEX `address_id` (`address_id`),
  INDEX `user_id` (`user_id`),
  INDEX `company_name` (`company_name`),
  INDEX `trading_name` (`trading_name`),
  INDEX `brand` (`brand`),
  INDEX `website_url` (`website_url`),
  INDEX `logo_path` (`logo_path`),
  INDEX `is_vetted` (`is_vetted`),
  INDEX `is_active` (`is_active`) 
) ENGINE=InnoDB DEFAULT CHARSET=latin1;


INSERT INTO `freight_details` (`fd_id`, `user_id`, `company_name`, `trading_name`, `brand`, `website_url`, `description`,  `logo_path`, `address_id`, `is_vetted`, `is_active`) VALUES
(1, 3, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 0, 1);


CREATE TABLE `user_history_log` (
  `uhl_id` int(11) NOT NULL AUTO_INCREMENT,
  `user_id` int(11) NOT NULL,
  `action_name` varchar(150) NOT NULL,
  `description` text NOT NULL,
  `created_time` int(11) NOT NULL,
  PRIMARY KEY (`uhl_id`),
  INDEX `user_id` (`user_id`),
  INDEX `created_time` (`created_time`),
  INDEX `action_name` (`action_name`)  
) ENGINE=InnoDB DEFAULT CHARSET=latin1;


CREATE TABLE `user_password_log` (
  `upl_id` int(11) NOT NULL AUTO_INCREMENT,
  `user_id` int(11) NOT NULL,
  `old_password` varchar(250) NULL,
  `new_password` varchar(250) NULL,
  `random_hash_tag` varchar(200) NOT NULL,
  `created_time` int(11) NOT NULL,
  `modified_time` int(11) NULL,
  `is_active` smallint(6) NOT NULL,
  PRIMARY KEY (`upl_id`),
  INDEX `user_id` (`user_id`),
  INDEX `created_time` (`created_time`),
  INDEX `modified_time` (`modified_time`),
  INDEX `random_hash_tag` (`random_hash_tag`),
  INDEX `is_active` (`is_active`) 
) ENGINE=InnoDB DEFAULT CHARSET=latin1;


CREATE TABLE `job_details` (
  `job_id` int(11) NOT NULL AUTO_INCREMENT,
  `cd_id` int(11) NOT NULL,
  `job_name` varchar(250) NOT NULL,
  `job_overview` text NULL,
  `product_quantity` int(11) NULL,
  `product_lead_time` int(11) NULL,
  `expected_amount` float NULL,
  `expected_terms` text NULL,
  `is_urgent` smallint(6) NULL,
  `sla_milestone` int(11) NULL,
  `is_sealed` smallint(6) NULL,
  `job_status_id` int(11) NOT NULL,
  `job_file_id` int(11) NULL,
  `created_time` int(11) NOT NULL,
  `modified_time` int(11) NULL,
  `description` text NULL,
  `special_requirement` text NULL,
  `is_invoice_uploaded` SMALLINT(6) NULL DEFAULT '0',
  `is_packaging_list_uploaded` SMALLINT(6) NULL DEFAULT '0',
  `is_active` smallint(6) NOT NULL,
  PRIMARY KEY (`job_id`),
  INDEX `product_quantity` (`product_quantity`),
  INDEX `product_lead_time` (`product_lead_time`),
  INDEX `sla_milestone` (`sla_milestone`),
  INDEX `job_status_id` (`job_status_id`),
  INDEX `created_time` (`created_time`),
  INDEX `cd_id` (`cd_id`),
  INDEX `job_file_id` (`job_file_id`),
  INDEX `modified_time` (`modified_time`),
  INDEX `job_name` (`job_name`),
  INDEX `expected_amount` (`expected_amount`),
  INDEX `is_urgent` (`is_urgent`),
  INDEX `is_sealed` (`is_sealed`),
  INDEX `is_invoice_uploaded` (`is_invoice_uploaded`),
  INDEX `is_packaging_list_uploaded` (`is_packaging_list_uploaded`),
  INDEX `is_active` (`is_active`)      
) ENGINE=InnoDB DEFAULT CHARSET=latin1;


CREATE TABLE `job_sub_category` (
  `jsc_id` int(11) NOT NULL AUTO_INCREMENT,
  `job_id` int(11) NOT NULL,
  `sub_cat_id` int(11) NOT NULL,
  `is_active` smallint(6) NOT NULL DEFAULT '1',
  PRIMARY KEY (`jsc_id`),
  INDEX `job_id` (`job_id`),
  INDEX `sub_cat_id` (`sub_cat_id`),
  INDEX `is_active` (`is_active`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;


CREATE TABLE `job_file` (
  `job_file_id` int(11) NOT NULL AUTO_INCREMENT,
  `job_id` int(11) NOT NULL,
  `file_type_id` int(11) NOT NULL,
  `file_name` text NULL,
  `user_id` int(11) NOT NULL,
  `created_time` int(11) NOT NULL,
  `is_active` smallint(6) NOT NULL DEFAULT '1',
  PRIMARY KEY (`job_file_id`),
  INDEX `job_id` (`job_id`),
  INDEX `file_type_id` (`file_type_id`),
  INDEX `user_id` (`user_id`),
  INDEX `created_time` (`created_time`),
  INDEX `is_active` (`is_active`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;


CREATE TABLE `file_type` (
  `file_type_id` int(11) NOT NULL AUTO_INCREMENT,
  `file_type_name` varchar(150) NOT NULL,
  `is_active` smallint(6) NOT NULL DEFAULT '1',
  PRIMARY KEY (`file_type_id`),
  INDEX `file_type_name` (`file_type_name`),
  INDEX `is_active` (`is_active`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;


INSERT INTO `file_type` (`file_type_id`, `file_type_name`, `is_active`) VALUES
(1, 'General', 1),
(2, 'Proforma Invoice', 1),
(3, 'Photo', 1),
(4, 'Packaging List', 1);


CREATE TABLE `job_status` (
  `job_status_id` int(11) NOT NULL AUTO_INCREMENT,
  `job_status_name` varchar(100) NOT NULL,
  `is_active` smallint(6) NOT NULL DEFAULT '1',
  PRIMARY KEY (`job_status_id`),
  INDEX `job_status_name` (`job_status_name`),
  INDEX `is_active` (`is_active`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

INSERT INTO `job_status` (`job_status_id`, `job_status_name`, `is_active`) VALUES
(1, 'Quote Request', 1),
(2, 'Order', 1),
(3, 'Order Processing', 1),
(4, 'Freight Ready', 1),
(5, 'Freight Request', 1),
(6, 'Freight Approved', 1),
(7, 'Completed', 1);

CREATE TABLE `job_order` (
  `job_order_id` int(11) NOT NULL AUTO_INCREMENT,
  `sd_id` int(11) NOT NULL,
  `job_id` int(11) NOT NULL,
  `jq_id` int(11) NOT NULL,
  `is_introduction` smallint(6) NOT NULL DEFAULT '0',
  `user_id` int(11) NOT NULL,
  `created_time` int(11) NOT NULL,
  `is_active` smallint(6) NOT NULL DEFAULT '1',
  PRIMARY KEY (`job_order_id`),
  INDEX `sd_id` (`sd_id`),
  INDEX `job_id` (`job_id`),
  INDEX `jq_id` (`jq_id`),
  INDEX `user_id` (`user_id`),
  INDEX `created_time` (`created_time`),
  INDEX `is_active` (`is_active`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;




CREATE TABLE `job_freight` (
  `job_freight_id` int(11) NOT NULL AUTO_INCREMENT,
  `fd_id` int(11) NOT NULL,
  `job_id` int(11) NOT NULL,
  `job_order_id` int(11) NOT NULL,
  `fq_id` int(11) NOT NULL,
  `created_time` int(11) NOT NULL,
  `is_active` smallint(6) NOT NULL DEFAULT '1',
  PRIMARY KEY (`job_freight_id`),
  INDEX `fd_id` (`fd_id`),
  INDEX `job_id` (`job_id`),
  INDEX `job_order_id` (`job_order_id`),
  INDEX `created_time` (`created_time`),
  INDEX `is_active` (`is_active`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;


CREATE TABLE `job_log` (
  `job_log_id` int(11) NOT NULL AUTO_INCREMENT,
  `job_id` int(11) NOT NULL,
  `job_status_id` int(11) NOT NULL,
  `description` text NULL,
  `created_time` int(11) NOT NULL,
  `job_file_id` int(11)  NULL,
  `user_id` int(11) NOT NULL,
  `is_active` smallint(6) NOT NULL DEFAULT '1',
  PRIMARY KEY (`job_log_id`),
  INDEX `job_id` (`job_id`),
  INDEX `job_status_id` (`job_status_id`),
  INDEX `user_id` (`user_id`),
  INDEX `job_file_id` (`job_file_id`),
  INDEX `created_time` (`created_time`),
  INDEX `is_active` (`is_active`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

CREATE TABLE `job_history` (
  `job_history_id` int(11) NOT NULL AUTO_INCREMENT,
  `job_id` int(11) NOT NULL,
  `job_status_id` int(11) NOT NULL,
  `description` text NULL,
  `created_time` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  PRIMARY KEY (`job_history_id`),
  INDEX `job_id` (`job_id`),
  INDEX `job_status_id` (`job_status_id`),
  INDEX `user_id` (`user_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;


CREATE TABLE `job_supplier_allocation` (
  `jsa_id` int(11) NOT NULL AUTO_INCREMENT,
  `job_id` int(11) NOT NULL,
  `sd_id` int(11) NOT NULL,
  `is_active` smallint(6) NOT NULL DEFAULT '1',
  PRIMARY KEY (`jsa_id`),
  INDEX `job_id` (`job_id`),
  INDEX `sd_id` (`sd_id`),
  INDEX `is_active` (`is_active`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;


CREATE TABLE `job_quote` (
  `jq_id` int(11) NOT NULL AUTO_INCREMENT,
  `job_id` int(11) NOT NULL,
  `sd_id` int(11) NOT NULL,
  `jsa_id` int(11) NOT NULL,
  `unit_volume` int(11) NULL,
  `price_per_unit` float NULL,
  `total_order` int(11) NULL,
  `freight_quote_cost` int(11) NULL,
  `total_cost` int(11) NULL,
  `currency_id` int(11) NULL,
  `payment_term` varchar(100) NOT NULL,
  `incoterm_id` int(11) NOT NULL,
  `lead_time` int(11) NOT NULL,
  `pre_approved_sample` SMALLINT(6) DEFAULT NULL,
  `sample_lead_time` int(11) DEFAULT NULL,
  `additional_information` text NOT NULL,
  `transaction_fee` float NOT NULL,
  `created_time` int(11) NOT NULL,
  `rank` int(11) NULL,
  `total_cost_rank` int(11) NULL,
  `is_approved` SMALLINT(6) NOT NULL DEFAULT '0',
  `is_active` SMALLINT(6) NOT NULL DEFAULT '1',
  PRIMARY KEY (`jq_id`),
  INDEX `job_id` (`job_id`),
  INDEX `sd_id` (`sd_id`),
  INDEX `jsa_id` (`jsa_id`),
  INDEX `lead_time` (`lead_time`),
  INDEX `sample_lead_time` (`sample_lead_time`),
  INDEX `created_time` (`created_time`),
  INDEX `unit_volume` (`unit_volume`),
  INDEX `total_order` (`total_order`),
  INDEX `currency_id` (`currency_id`),
  INDEX `rank` (`rank`),
  INDEX `is_approved` (`is_approved`),
  INDEX `is_active` (`is_active`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;



CREATE TABLE `currency` (
  `currency_id` int(11) NOT NULL AUTO_INCREMENT,
  `currency_code` varchar(10) NOT NULL,
  `currency_name` varchar(50) NOT NULL,
  `is_active` smallint(6) NOT NULL DEFAULT '1',
  PRIMARY KEY (`currency_id`),
INDEX `currency_code` (`currency_code`),
INDEX `currency_name` (`currency_name`),
INDEX `is_active` (`is_active`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;



INSERT INTO `currency` (`currency_id`, `currency_code`, `currency_name`, `is_active`) VALUES
(1, 'aed', 'United Arab Emirates dirham', 1),
(2, 'afn', 'Afghan afghani', 1),
(3, 'all', 'Albanian lek', 1),
(4, 'amd', 'Armenian dram', 1),
(5, 'ang', 'Netherlands Antillean guilder', 1),
(6, 'aoa', 'Angolan kwanza', 1),
(7, 'ars', 'Argentine peso', 1),
(8, 'aud', 'Australian dollar', 1),
(9, 'awg', 'Aruban florin', 1),
(10, 'azn', 'Azerbaijani manat', 1),
(11, 'bam', 'Bosnia and Herzegovina convertible mark', 1),
(12, 'bbd', 'Barbados dollar', 1),
(13, 'bdt', 'Bangladeshi taka', 1),
(14, 'bgn', 'Bulgarian lev', 1),
(15, 'bhd', 'Bahraini dinar', 1),
(16, 'bif', 'Burundian franc', 1),
(17, 'bmd', 'Bermudian dollar', 1),
(18, 'bnd', 'Brunei dollar', 1),
(19, 'bob', 'Boliviano', 1),
(20, 'brl', 'Brazilian real', 1),
(21, 'bsd', 'Bahamian dollar', 1),
(22, 'btn', 'Bhutanese ngultrum', 1),
(23, 'bwp', 'Botswana pula', 1),
(24, 'byr', 'Belarusian ruble', 1),
(25, 'bzd', 'Belize dollar', 1),
(26, 'cad', 'Canadian dollar', 1),
(27, 'cdf', 'Congolese franc', 1),
(28, 'chf', 'Swiss franc', 1),
(29, 'clp', 'Chilean peso', 1),
(30, 'cny', 'Chinese yuan', 1),
(31, 'cop', 'Colombian peso', 1),
(32, 'crc', 'Costa Rican colon', 1),
(33, 'cup', 'Cuban peso', 1),
(34, 'cve', 'Cape Verde escudo', 1),
(35, 'czk', 'Czech koruna', 1),
(36, 'djf', 'Djiboutian franc', 1),
(37, 'dkk', 'Danish krone', 1),
(38, 'dop', 'Dominican peso', 1),
(39, 'dzd', 'Algerian dinar', 1),
(40, 'egp', 'Egyptian pound', 1),
(41, 'ern', 'Eritrean nakfa', 1),
(42, 'etb', 'Ethiopian birr', 1),
(43, 'eur', 'Euro', 1),
(44, 'fjd', 'Fiji dollar', 1),
(45, 'fkp', 'Falkland Islands pound', 1),
(46, 'gbp', 'Pound sterling', 1),
(47, 'gel', 'Georgian lari', 1),
(48, 'ghs', 'Ghanaian cedi', 1),
(49, 'gip', 'Gibraltar pound', 1),
(50, 'gmd', 'Gambian dalasi', 1),
(51, 'gnf', 'Guinean franc', 1),
(52, 'gtq', 'Guatemalan quetzal', 1),
(53, 'gyd', 'Guyanese dollar', 1),
(54, 'hkd', 'Hong Kong dollar', 1),
(55, 'hnl', 'Honduran lempira', 1),
(56, 'hrk', 'Croatian kuna', 1),
(57, 'htg', 'Haitian gourde', 1),
(58, 'huf', 'Hungarian forint', 1),
(59, 'idr', 'Indonesian rupiah', 1),
(60, 'ils', 'Israeli new shekel', 1),
(61, 'inr', 'Indian rupee', 1),
(62, 'iqd', 'Iraqi dinar', 1),
(63, 'irr', 'Iranian rial', 1),
(64, 'isk', 'Icelandic króna', 1),
(65, 'jmd', 'Jamaican dollar', 1),
(66, 'jod', 'Jordanian dinar', 1),
(67, 'jpy', 'Japanese yen', 1),
(68, 'kes', 'Kenyan shilling', 1),
(69, 'kgs', 'Kyrgyzstani som', 1),
(70, 'khr', 'Cambodian riel', 1),
(71, 'kmf', 'Comoro franc', 1),
(72, 'kpw', 'North Korean won', 1),
(73, 'krw', 'South Korean won', 1),
(74, 'kwd', 'Kuwaiti dinar', 1),
(75, 'kyd', 'Cayman Islands dollar', 1),
(76, 'kzt', 'Kazakhstani tenge', 1),
(77, 'lak', 'Lao kip', 1),
(78, 'lbp', 'Lebanese pound', 1),
(79, 'lkr', 'Sri Lankan rupee', 1),
(80, 'lrd', 'Liberian dollar', 1),
(81, 'lsl', 'Lesotho loti', 1),
(82, 'ltl', 'Lithuanian litas', 1),
(83, 'lyd', 'Libyan dinar', 1),
(84, 'mad', 'Moroccan dirham', 1),
(85, 'mdl', 'Moldovan leu', 1),
(86, 'mga', 'Malagasy ariary', 1),
(87, 'mkd', 'Macedonian denar', 1),
(88, 'mmk', 'Myanma kyat', 1),
(89, 'mnt', 'Mongolian tugrik', 1),
(90, 'mop', 'Macanese pataca', 1),
(91, 'mro', 'Mauritanian ouguiya', 1),
(92, 'mur', 'Mauritian rupee', 1),
(93, 'mvr', 'Maldivian rufiyaa', 1),
(94, 'mwk', 'Malawian kwacha', 1),
(95, 'mxn', 'Mexican peso', 1),
(96, 'myr', 'Malaysian ringgit', 1),
(97, 'mzn', 'Mozambican metical', 1),
(98, 'nad', 'Namibian dollar', 1),
(99, 'ngn', 'Nigerian naira', 1),
(100, 'nio', 'Nicaraguan córdoba', 1),
(101, 'nok', 'Norwegian krone', 1),
(102, 'npr', 'Nepalese rupee', 1),
(103, 'nzd', 'New Zealand dollar', 1),
(104, 'omr', 'Omani rial', 1),
(105, 'pab', 'Panamanian balboa', 1),
(106, 'pen', 'Peruvian nuevo sol', 1),
(107, 'pgk', 'Papua New Guinean kina', 1),
(108, 'php', 'Philippine peso', 1),
(109, 'pkr', 'Pakistani rupee', 1),
(110, 'pln', 'Polish z?oty', 1),
(111, 'pyg', 'Paraguayan guaraní', 1),
(112, 'qar', 'Qatari riyal', 1),
(113, 'ron', 'Romanian new leu', 1),
(114, 'rsd', 'Serbian dinar', 1),
(115, 'rub', 'Russian ruble', 1),
(116, 'rwf', 'Rwandan franc', 1),
(117, 'sar', 'Saudi riyal', 1),
(118, 'sbd', 'Solomon Islands dollar', 1),
(119, 'scr', 'Seychelles rupee', 1),
(120, 'sdg', 'Sudanese pound', 1),
(121, 'sek', 'Swedish krona/kronor', 1),
(122, 'sgd', 'Singapore dollar', 1),
(123, 'shp', 'Saint Helena pound', 1),
(124, 'sll', 'Sierra Leonean leone', 1),
(125, 'sos', 'Somali shilling', 1),
(126, 'srd', 'Surinamese dollar', 1),
(127, 'ssp', 'South Sudanese pound', 1),
(128, 'std', 'São Tomé and Príncipe dobra', 1),
(129, 'syp', 'Syrian pound', 1),
(130, 'szl', 'Swazi lilangeni', 1),
(131, 'thb', 'Thai baht', 1),
(132, 'tjs', 'Tajikistani somoni', 1),
(133, 'tmt', 'Turkmenistani manat', 1),
(134, 'tnd', 'Tunisian dinar', 1),
(135, 'top', 'Tongan pa?anga', 1),
(136, 'try', 'Turkish lira', 1),
(137, 'ttd', 'Trinidad and Tobago dollar', 1),
(138, 'twd', 'New Taiwan dollar', 1),
(139, 'tzs', 'Tanzanian shilling', 1),
(140, 'uah', 'Ukrainian hryvnia', 1),
(141, 'ugx', 'Ugandan shilling', 1),
(142, 'usd', 'United States dollar', 1),
(143, 'uyu', 'Uruguayan peso', 1),
(144, 'uzs', 'Uzbekistan som', 1),
(145, 'vef', 'Venezuelan bolívar', 1),
(146, 'vnd', 'Vietnamese dong', 1),
(147, 'vuv', 'Vanuatu vatu', 1),
(148, 'wst', 'Samoan tala', 1),
(149, 'xaf', 'CFA franc BEAC', 1),
(150, 'xcd', 'East Caribbean dollar', 1),
(151, 'xof', 'CFA franc BCEAO', 1),
(152, 'xpf', 'CFP franc (franc Pacifique)', 1),
(153, 'yer', 'Yemeni rial', 1),
(154, 'zar', 'South African rand', 1),
(155, 'zmw', 'Zambian kwacha', 1),
(156, 'zwl', 'Zimbabwe dollar', 1);


CREATE TABLE `incoterm` (
  `incoterm_id` int(11) NOT NULL AUTO_INCREMENT,
  `incoterm_code` varchar(50) NOT NULL,   
  `incoterm_name` varchar(250) NOT NULL,
  `is_active` smallint(6) NOT NULL DEFAULT '1',
  PRIMARY KEY (`incoterm_id`),
  INDEX `incoterm_code` (`incoterm_code`),
  INDEX `incoterm_name` (`incoterm_name`),
  INDEX `is_active` (`is_active`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

INSERT INTO `incoterm` (`incoterm_id`, `incoterm_code`, `incoterm_name`, `is_active`) VALUES
(1, 'EXW', 'Ex Works (named place of delivery)', 1),
(2, 'FCA', 'Free Carrier (named place of delivery)', 1),
(3, 'CPT', 'Carriage Paid To (named place of destination)', 1),
(4, 'CIP', 'Carriage and Insurance Paid to (named place of destination)', 1),
(5, 'DAT', 'Delivered At Terminal (named terminal at port or place of destination)', 1),
(6, 'DAP', 'Delivered At Place (named place of destination)', 1),
(7, 'DDP', 'Delivered Duty Paid (named place of destination)', 1),
(8, 'FAS', 'Free Alongside Ship (named port of shipment)', 1),
(9, 'FOB', 'Free on Board (named port of shipment)', 1),
(10, 'CFR', 'Cost and Freight (named port of destination)', 1),
(11, 'CIF', 'Cost, Insurance & Freight (named port of destination)', 1);


CREATE TABLE `country` (
  `country_id` int(11) NOT NULL AUTO_INCREMENT,
  `country_code` varchar(5) NOT NULL,
  `iso_country_code` varchar(100) NOT NULL,
  `telephone_code` varchar(20) NULL,
  `country_name` varchar(100) NOT NULL,
  `is_active` smallint(6) NOT NULL DEFAULT '1',
  PRIMARY KEY (`country_id`),
  INDEX `country_code` (`country_code`),
  INDEX `iso_country_code` (`iso_country_code`),
  INDEX `telephone_code` (`telephone_code`),
  INDEX `country_name` (`country_name`),
  INDEX `is_active` (`is_active`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;


INSERT INTO `country` (`country_id`, `country_code`, `iso_country_code`, `telephone_code`, `country_name`, `is_active`) VALUES
(1, 'abw', 'aw', '+297', 'Aruba', 1),
(2, 'afg', 'af', '+93', 'Afghanistan', 1),
(3, 'ago', 'ao', '+244', 'Angola', 1),
(4, 'aia', 'ai', '+1264', 'Anguilla', 1),
(5, 'ala', 'ax', '+35818', 'Åland Islands', 1),
(6, 'alb', 'al', '+355', 'Albania', 1),
(7, 'and', 'ad', '+376', 'Andorra', 1),
(8, 'are', 'ae', '+971', 'United Arab Emirates', 1),
(9, 'arg', 'ar', '+54', 'Argentina', 1),
(10, 'arm', 'am', '+374', 'Armenia', 1),
(11, 'asm', 'as', '+1684', 'American Samoa', 1),
(12, 'ata', 'aq', '+672', 'Antarctica', 1),
(13, 'atf', 'tf', NULL, 'French Southern Territories', 1),
(14, 'atg', 'ag', '+1268', 'Antigua and Barbuda', 1),
(15, 'aus', 'au', '+61', 'Australia', 1),
(16, 'aut', 'at', '+43', 'Austria', 1),
(17, 'aze', 'az', '+994', 'Azerbaijan', 1),
(18, 'bdi', 'bi', '+257', 'Burundi', 1),
(19, 'bel', 'be', '+32', 'Belgium', 1),
(20, 'ben', 'bj', '+229', 'Benin', 1),
(21, 'bes', 'bq', '+5997', 'Bonaire, Sint Eustatius and Saba', 1),
(22, 'bfa', 'bf', '+226', 'Burkina Faso', 1),
(23, 'bgd', 'bd', '+880', 'Bangladesh', 1),
(24, 'bgr', 'bg', '+359', 'Bulgaria', 1),
(25, 'bhr', 'bh', '+973', 'Bahrain', 1),
(26, 'bhs', 'bs', '+1242', 'Bahamas', 1),
(27, 'bih', 'ba', '+387', 'Bosnia and Herzegovina', 1),
(28, 'blm', 'bl', '+590', 'Saint Barthélemy', 1),
(29, 'blr', 'by', '+375', 'Belarus', 1),
(30, 'blz', 'bz', '+501', 'Belize', 1),
(31, 'bmu', 'bm', '+1441', 'Bermuda', 1),
(32, 'bol', 'bo', '+591', 'Bolivia, Plurinational State of', 1),
(33, 'bra', 'br', '+55', 'Brazil', 1),
(34, 'brb', 'bb', '+1246', 'Barbados', 1),
(35, 'brn', 'bn', '+673', 'Brunei Darussalam', 1),
(36, 'btn', 'bt', '+975', 'Bhutan', 1),
(37, 'bvt', 'bv', '+47', 'Bouvet Island', 1),
(38, 'bwa', 'bw', '+267', 'Botswana', 1),
(39, 'caf', 'cf', '+236', 'Central African Republic', 1),
(40, 'can', 'ca', '+1', 'Canada', 1),
(41, 'cck', 'cc', '+61', 'Cocos (Keeling) Islands', 1),
(42, 'che', 'ch', '+41', 'Switzerland', 1),
(43, 'chl', 'cl', '+56', 'Chile', 1),
(44, 'chn', 'cn', '+86', 'China', 1),
(45, 'civ', 'ci', '+225', 'Côte d Ivoire', 1),
(46, 'cmr', 'cm', '+237', 'Cameroon', 1),
(47, 'cod', 'cd', '+243', 'Congo, the Democratic Republic of the', 1),
(48, 'cog', 'cg', '+242', 'Congo', 1),
(49, 'cok', 'ck', '+682', 'Cook Islands', 1),
(50, 'col', 'co', '+57', 'Colombia', 1),
(51, 'com', 'km', '+269', 'Comoros', 1),
(52, 'cpv', 'cv', '+238', 'Cape Verde', 1),
(53, 'cri', 'cr', '+506', 'Costa Rica', 1),
(54, 'cub', 'cu', '+53', 'Cuba', 1),
(55, 'cuw', 'cw', '+5999', 'Curaçao', 1),
(56, 'cxr', 'cx', '+61', 'Christmas Island', 1),
(57, 'cym', 'ky', '+1345', 'Cayman Islands', 1),
(58, 'cyp', 'cy', '+357', 'Cyprus', 1),
(59, 'cze', 'cz', '+420', 'Czech Republic', 1),
(60, 'deu', 'de', '+49', 'Germany', 1),
(61, 'dji', 'dj', '+253', 'Djibouti', 1),
(62, 'dma', 'dm', '+1767', 'Dominica', 1),
(63, 'dnk', 'dk', '+45', 'Denmark', 1),
(64, 'dom', 'do', '+1809', 'Dominican Republic', 1),
(65, 'dza', 'dz', '+213', 'Algeria', 1),
(66, 'ecu', 'ec', '+593', 'Ecuador', 1),
(67, 'egy', 'eg', '+20', 'Egypt', 1),
(68, 'eri', 'er', '+291', 'Eritrea', 1),
(69, 'esh', 'eh', '+212', 'Western Sahara', 1),
(70, 'esp', 'es', '+34', 'Spain', 1),
(71, 'est', 'ee', '+372', 'Estonia', 1),
(72, 'eth', 'et', '+251', 'Ethiopia', 1),
(73, 'fin', 'fi', '+358', 'Finland', 1),
(74, 'fji', 'fj', '+679', 'Fiji', 1),
(75, 'flk', 'fk', '+500', 'Falkland Islands (Malvinas)', 1),
(76, 'fra', 'fr', '+33 	', 'France', 1),
(77, 'fro', 'fo', '+298', 'Faroe Islands', 1),
(78, 'fsm', 'fm', '+691', 'Micronesia, Federated States of', 1),
(79, 'gab', 'ga', '+241', 'Gabon', 1),
(80, 'gbr', 'gb', '+44', 'United Kingdom', 1),
(81, 'geo', 'ge', '+995', 'Georgia', 1),
(82, 'ggy', 'gg', '+44', 'Guernsey', 1),
(83, 'gha', 'gh', '+233', 'Ghana', 1),
(84, 'gib', 'gi', '+350', 'Gibraltar', 1),
(85, 'gin', 'gn', '+224', 'Guinea', 1),
(86, 'glp', 'gp', '+590', 'Guadeloupe', 1),
(87, 'gmb', 'gm', '+220', 'Gambia', 1),
(88, 'gnb', 'gw', '+245', 'Guinea-Bissau', 1),
(89, 'gnq', 'gq', '+240', 'Equatorial Guinea', 1),
(90, 'grc', 'gr', '+30', 'Greece', 1),
(91, 'grd', 'gd', '+1473', 'Grenada', 1),
(92, 'grl', 'gl', '+299', 'Greenland', 1),
(93, 'gtm', 'gt', '+502', 'Guatemala', 1),
(94, 'guf', 'gf', '+594', 'French Guiana', 1),
(95, 'gum', 'gu', '+1671', 'Guam', 1),
(96, 'guy', 'gy', '+592', 'Guyana', 1),
(97, 'hkg', 'hk', '+852', 'Hong Kong', 1),
(98, 'hmd', 'hm', '+672', 'Heard Island and McDonald Islands', 1),
(99, 'hnd', 'hn', '+504', 'Honduras', 1),
(100, 'hrv', 'hr', '+385', 'Croatia', 1),
(101, 'hti', 'ht', '+509', 'Haiti', 1),
(102, 'hun', 'hu', '+36', 'Hungary', 1),
(103, 'idn', 'id', '+62', 'Indonesia', 1),
(104, 'imn', 'im', '+44', 'Isle of Man', 1),
(105, 'ind', 'in', '+91', 'India', 1),
(106, 'iot', 'io', '+246', 'British Indian Ocean Territory', 1),
(107, 'irl', 'ie', '+353', 'Ireland', 1),
(108, 'irn', 'ir', '+98', 'Iran, Islamic Republic of', 1),
(109, 'irq', 'iq', '+964', 'Iraq', 1),
(110, 'isl', 'is', '+354', 'Iceland', 1),
(111, 'isr', 'il', '+972', 'Israel', 1),
(112, 'ita', 'it', '+39', 'Italy', 1),
(113, 'jam', 'jm', '+1876', 'Jamaica', 1),
(114, 'jey', 'je', '+44', 'Jersey', 1),
(115, 'jor', 'jo', '+962', 'Jordan', 1),
(116, 'jpn', 'jp', '+81', 'Japan', 1),
(117, 'kaz', 'kz', '+7 6', 'Kazakhstan', 1),
(118, 'ken', 'ke', '+254', 'Kenya', 1),
(119, 'kgz', 'kg', '+996', 'Kyrgyzstan', 1),
(120, 'khm', 'kh', '+855', 'Cambodia', 1),
(121, 'kir', 'ki', '+686', 'Kiribati', 1),
(122, 'kna', 'kn', '+1869', 'Saint Kitts and Nevis', 1),
(123, 'kor', 'kr', '+82', 'Korea, Republic of', 1),
(124, 'kwt', 'kw', '+965', 'Kuwait', 1),
(125, 'lao', 'la', '+856', 'Lao Peoples Democratic Republic', 1),
(126, 'lbn', 'lb', '+961', 'Lebanon', 1),
(127, 'lbr', 'lr', '+231', 'Liberia', 1),
(128, 'lby', 'ly', '+218', 'Libya', 1),
(129, 'lca', 'lc', '+1758', 'Saint Lucia', 1),
(130, 'lie', 'li', '+423', 'Liechtenstein', 1),
(131, 'lka', 'lk', '+94', 'Sri Lanka', 1),
(132, 'lso', 'ls', '+266', 'Lesotho', 1),
(133, 'ltu', 'lt', '+370', 'Lithuania', 1),
(134, 'lux', 'lu', '+352', 'Luxembourg', 1),
(135, 'lva', 'lv', '+371', 'Latvia', 1),
(136, 'mac', 'mo', '+853', 'Macao', 1),
(137, 'maf', 'mf', '+590', 'Saint Martin (French part)', 1),
(138, 'mar', 'ma', '+212', 'Morocco', 1),
(139, 'mco', 'mc', '+377', 'Monaco', 1),
(140, 'mda', 'md', '+373', 'Moldova, Republic of', 1),
(141, 'mdg', 'mg', '+261', 'Madagascar', 1),
(142, 'mdv', 'mv', '+960', 'Maldives', 1),
(143, 'mex', 'mx', '+52', 'Mexico', 1),
(144, 'mhl', 'mh', '+692', 'Marshall Islands', 1),
(145, 'mkd', 'mk', '+389', 'Macedonia, the former Yugoslav Republic of', 1),
(146, 'mli', 'ml', '+223', 'Mali', 1),
(147, 'mlt', 'mt', '+356', 'Malta', 1),
(148, 'mmr', 'mm', '+95', 'Myanmar', 1),
(149, 'mne', 'me', '+382', 'Montenegro', 1),
(150, 'mng', 'mn', '+976', 'Mongolia', 1),
(151, 'mnp', 'mp', '+1670', 'Northern Mariana Islands', 1),
(152, 'moz', 'mz', '+258', 'Mozambique', 1),
(153, 'mrt', 'mr', '+222', 'Mauritania', 1),
(154, 'msr', 'ms', '+1664', 'Montserrat', 1),
(155, 'mtq', 'mq', '+596', 'Martinique', 1),
(156, 'mus', 'mu', '+230', 'Mauritius', 1),
(157, 'mwi', 'mw', '+265', 'Malawi', 1),
(158, 'mys', 'my', '+60', 'Malaysia', 1),
(159, 'myt', 'yt', '+262', 'Mayotte', 1),
(160, 'nam', 'na', '+264', 'Namibia', 1),
(161, 'ncl', 'nc', '+687', 'New Caledonia', 1),
(162, 'ner', 'ne', '+227', 'Niger', 1),
(163, 'nfk', 'nf', '+672', 'Norfolk Island', 1),
(164, 'nga', 'ng', '+234', 'Nigeria', 1),
(165, 'nic', 'ni', '+505', 'Nicaragua', 1),
(166, 'niu', 'nu', '+683', 'Niue', 1),
(167, 'nld', 'nl', '+31', 'Netherlands', 1),
(168, 'nor', 'no', '+47', 'Norway', 1),
(169, 'npl', 'np', '+977', 'Nepal', 1),
(170, 'nru', 'nr', '+674', 'Nauru', 1),
(171, 'nzl', 'nz', '+64', 'New Zealand', 1),
(172, 'omn', 'om', '+968', 'Oman', 1),
(173, 'pak', 'pk', '+92', 'Pakistan', 1),
(174, 'pan', 'pa', '+507', 'Panama', 1),
(175, 'pcn', 'pn', '+64', 'Pitcairn', 1),
(176, 'per', 'pe', '+51', 'Peru', 1),
(177, 'phl', 'ph', '+63', 'Philippines', 1),
(178, 'plw', 'pw', '+680', 'Palau', 1),
(179, 'png', 'pg', '+675', 'Papua New Guinea', 1),
(180, 'pol', 'pl', '+48', 'Poland', 1),
(181, 'pri', 'pr', '+1787', 'Puerto Rico', 1),
(182, 'prk', 'kp', '+82', 'Korea, Democratic Peoples Republic of', 1),
(183, 'prt', 'pt', '+351', 'Portugal', 1),
(184, 'pry', 'py', '+595', 'Paraguay', 1),
(185, 'pse', 'ps', '+970', 'Palestine, State of', 1),
(186, 'pyf', 'pf', '+689', 'French Polynesia', 1),
(187, 'qat', 'qa', '+974', 'Qatar', 1),
(188, 'reu', 're', '+262', 'Réunion', 1),
(189, 'rou', 'ro', '+40', 'Romania', 1),
(190, 'rus', 'ru', '+7', 'Russian Federation', 1),
(191, 'rwa', 'rw', '+250', 'Rwanda', 1),
(192, 'sau', 'sa', '+966', 'Saudi Arabia', 1),
(193, 'sdn', 'sd', '+249', 'Sudan', 1),
(194, 'sen', 'sn', '+221', 'Senegal', 1),
(195, 'sgp', 'sg', '+65', 'Singapore', 1),
(196, 'sgs', 'gs', '+500', 'South Georgia and the South Sandwich Islands', 1),
(197, 'shn', 'sh', '+290', 'Saint Helena, Ascension and Tristan da Cunha', 1),
(198, 'sjm', 'sj', '+47', 'Svalbard and Jan Mayen', 1),
(199, 'slb', 'sb', '+677', 'Solomon Islands', 1),
(200, 'sle', 'sl', '+232', 'Sierra Leone', 1),
(201, 'slv', 'sv', '+503', 'El Salvador', 1),
(202, 'smr', 'sm', '+378', 'San Marino', 1),
(203, 'som', 'so', '+252', 'Somalia', 1),
(204, 'spm', 'pm', '+508', 'Saint Pierre and Miquelon', 1),
(205, 'srb', 'rs', '+381', 'Serbia', 1),
(206, 'ssd', 'ss', '+211', 'South Sudan', 1),
(207, 'stp', 'st', '+239', 'Sao Tome and Principe', 1),
(208, 'sur', 'sr', '+597', 'Suriname', 1),
(209, 'svk', 'sk', '+421', 'Slovakia', 1),
(210, 'svn', 'si', '+386', 'Slovenia', 1),
(211, 'swe', 'se', '+46', 'Sweden', 1),
(212, 'swz', 'sz', '+268', 'Swaziland', 1),
(213, 'sxm', 'sx', '+1721', 'Sint Maarten (Dutch part)', 1),
(214, 'syc', 'sc', '+248', 'Seychelles', 1),
(215, 'syr', 'sy', '+963', 'Syrian Arab Republic', 1),
(216, 'tca', 'tc', '+1649', 'Turks and Caicos Islands', 1),
(217, 'tcd', 'td', '+235', 'Chad', 1),
(218, 'tgo', 'tg', '+228', 'Togo', 1),
(219, 'tha', 'th', '+66', 'Thailand', 1),
(220, 'tjk', 'tj', '+992', 'Tajikistan', 1),
(221, 'tkl', 'tk', '+690', 'Tokelau', 1),
(222, 'tkm', 'tm', '+993', 'Turkmenistan', 1),
(223, 'tls', 'tl', '+670', 'Timor-Leste', 1),
(224, 'ton', 'to', '+676', 'Tonga', 1),
(225, 'tto', 'tt', '+1868', 'Trinidad and Tobago', 1),
(226, 'tun', 'tn', '+216', 'Tunisia', 1),
(227, 'tur', 'tr', '+90', 'Turkey', 1),
(228, 'tuv', 'tv', '+688', 'Tuvalu', 1),
(229, 'twn', 'tw', '+886', 'Taiwan, Province of China', 1),
(230, 'tza', 'tz', '+255', 'Tanzania, United Republic of', 1),
(231, 'uga', 'ug', '+256', 'Uganda', 1),
(232, 'ukr', 'ua', '+380', 'Ukraine', 1),
(233, 'umi', 'um', '+1', 'United States Minor Outlying Islands', 1),
(234, 'ury', 'uy', '+598', 'Uruguay', 1),
(235, 'usa', 'us', '+1', 'United States', 1),
(236, 'uzb', 'uz', '+998', 'Uzbekistan', 1),
(237, 'vat', 'va', '+379', 'Holy See (Vatican City State)', 1),
(238, 'vct', 'vc', '+1784', 'Saint Vincent and the Grenadines', 1),
(239, 'ven', 've', '+58', 'Venezuela, Bolivarian Republic of', 1),
(240, 'vgb', 'vg', '+1284', 'Virgin Islands, British', 1),
(241, 'vir', 'vi', '+1340', 'Virgin Islands, U.S.', 1),
(242, 'vnm', 'vn', '+84', 'Viet Nam', 1),
(243, 'vut', 'vu', '+678', 'Vanuatu', 1),
(244, 'wlf', 'wf', '+681', 'Wallis and Futuna', 1),
(245, 'wsm', 'ws', '+685', 'Samoa', 1),
(246, 'yem', 'ye', '+967', 'Yemen', 1),
(247, 'zaf', 'za', '+27', 'South Africa', 1),
(248, 'zmb', 'zm', '+260', 'Zambia', 1),
(249, 'zwe', 'zw', '+263', 'Zimbabwe', 1);



CREATE TABLE `address` (
  `address_id` int(11) NOT NULL AUTO_INCREMENT,
  `address_name` varchar(100) NOT NULL,
  `street_address` text NULL,
  `state` varchar(100) NULL,
  `city` varchar(100) NULL,
  `post_code` varchar(100) NULL,
  `country_id` int(11) NULL,
  `telephone_code` varchar(20) NULL,
  `telephone_no` varchar(50) NULL,
  `fax_no` varchar(100) NULL,
  `is_active` smallint(6) NOT NULL DEFAULT '1',
  PRIMARY KEY (`address_id`),
  INDEX `country_id` (`country_id`),
  INDEX `telephone_no` (`telephone_no`),
  INDEX `state` (`state`),
  INDEX `city` (`city`),
  INDEX `post_code` (`post_code`),
  INDEX `telephone_code` (`telephone_code`),
  INDEX `is_active` (`is_active`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;



CREATE TABLE `contact_us` (
  `contact_id` int(11) NOT NULL AUTO_INCREMENT,
  `email` varchar(100) NOT NULL,
  `name` varchar(100) NOT NULL,
  `ip_address` varchar(100) NOT NULL,
  `subject` varchar(250) NOT NULL,
  `message` text NOT NULL,
  `created_time` int(11) NOT NULL,
  `is_active` smallint(6) NOT NULL DEFAULT '1',
  PRIMARY KEY (`contact_id`),
  INDEX `email` (`email`),
  INDEX `ip_address` (`ip_address`),
  INDEX `subject` (`subject`),
  INDEX `created_time` (`created_time`),
  INDEX `is_active` (`is_active`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;




CREATE TABLE `email_notification` (
  `email_notification_id` int(11) NOT NULL AUTO_INCREMENT,
  `from_email` varchar(100) NOT NULL,
  `to_email` varchar(100) NOT NULL,
  `cc_email` varchar(250) NULL,
  `subject` varchar(250) NOT NULL,
  `message` text NOT NULL,
  `status` enum('Queued','Delivered','') NOT NULL,
  `is_active` smallint(6) NOT NULL DEFAULT '1',
  PRIMARY KEY (`email_notification_id`),
INDEX `from_email` (`from_email`),
INDEX `to_email` (`to_email`),
INDEX `cc_email` (`cc_email`),
INDEX `subject` (`subject`),
INDEX `is_active` (`is_active`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;



CREATE TABLE `categories` (
  `cat_id` int(11) NOT NULL AUTO_INCREMENT,
  `category_name` varchar(100) NOT NULL,
  `is_active` smallint(6) NOT NULL DEFAULT '1',
  PRIMARY KEY (`cat_id`),
 INDEX `category_name` (`category_name`),
 INDEX `is_active` (`is_active`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;


INSERT INTO `categories` (`cat_id`, `category_name`, `is_active`) VALUES
(1, 'Retail', 1),
(2, 'Secure', 1),
(3, 'Telecom', 1),
(4, 'RFID', 1),
(5, 'Card Printers', 1),
(6, 'Card Readers', 1),
(7, 'Peripherals', 1),
(8, 'Payment Services', 1),
(9, 'Programs', 1),
(10, 'Materials', 1);


CREATE TABLE `sub_categories` (
  `sub_cat_id` int(11) NOT NULL AUTO_INCREMENT,
  `cat_id` int(11) NOT NULL,
  `sub_category_name` varchar(100) NOT NULL,
  `is_active` smallint(6) NOT NULL DEFAULT '1',
  PRIMARY KEY (`sub_cat_id`),
  INDEX `cat_id` (`cat_id`),
  INDEX `sub_category_name` (`sub_category_name`),
  INDEX `is_active` (`is_active`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;


INSERT INTO `sub_categories` (`sub_cat_id`, `cat_id`, `sub_category_name`, `is_active`) VALUES
(1, 1, 'Gift', 1),
(2, 1, 'Loyalty', 1),
(3, 1, 'Membership', 1),
(4, 1, 'Promotional', 1),
(5, 1, 'Oversize', 1),
(6, 1, 'Snap-Apart', 1),
(7, 2, 'Visa', 1),
(8, 2, 'MasterCard', 1),
(9, 2, 'Amex', 1),
(10, 2, 'Discovery', 1),
(11, 2, 'EMV', 1),
(12, 2, 'Driver Licence', 1),
(13, 2, 'Medicare', 1),
(14, 2, 'National ID', 1),
(15, 3, 'SIM Cards', 1),
(16, 3, 'Scratch Cards', 1),
(17, 4, 'Contact smart cards', 1),
(18, 4, 'contactless smart cards', 1),
(19, 4, 'labels', 1),
(20, 4, 'wrist bands', 1),
(21, 4, 'tokens', 1),
(22, 5, 'Datacard', 1),
(23, 5, 'Evolis', 1),
(24, 5, 'HID', 1),
(25, 5, 'Magicard', 1),
(26, 5, 'Matica', 1),
(27, 5, 'Nisca', 1),
(28, 5, 'Polaroid', 1),
(29, 5, 'Zebra', 1),
(30, 5, 'IDP', 1),
(31, 6, 'Swipe', 1),
(32, 6, 'Contact', 1),
(33, 6, 'Contactless', 1),
(34, 6, 'Fixed', 1),
(35, 6, 'Wireless', 1),
(36, 7, 'Lanyards', 1),
(37, 7, 'Ribbons', 1),
(38, 7, 'Cleaning Cards', 1),
(39, 7, 'card holders', 1),
(40, 7, 'Retractable Clips', 1),
(41, 8, 'Merchant services', 1),
(42, 8, 'banking services', 1),
(43, 8, 'stored value (open loop)', 1),
(44, 9, 'Loyalty', 1),
(45, 9, 'Gift', 1),
(46, 9, 'membership', 1),
(47, 9, 'stored value (closed Loop)', 1),
(48, 10, 'Raw PVC', 1),
(49, 10, 'RFID inlays', 1),
(50, 10, 'Contact modules', 1),
(51, 10, 'dual interface', 1);


CREATE TABLE `user_activation_log` (
  `ual_id` int(11) NOT NULL AUTO_INCREMENT,
  `user_id` int(11) NOT NULL,
  `random_hash_tag` varchar(150) NOT NULL,
  `is_active` smallint(6) NOT NULL DEFAULT '1',
  PRIMARY KEY (`ual_id`),
  INDEX `user_id` (`user_id`),
  INDEX `random_hash_tag` (`random_hash_tag`),
  INDEX `is_active` (`is_active`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;


CREATE TABLE `regions` (
  `region_id` int(11) NOT NULL AUTO_INCREMENT,
  `region_name` varchar(255) NOT NULL,
  `is_active` smallint(6) NOT NULL DEFAULT '1',
  PRIMARY KEY (`region_id`),
  INDEX `region_name` (`region_name`),
  INDEX `is_active` (`is_active`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;


INSERT INTO `regions` (`region_id`, `region_name`, `is_active`) VALUES
(1, 'Asia Pacific (excludes China, Australia & New Zealand)', 1),
(2, 'North America', 1),
(3, 'Central America', 1),
(4, 'South America', 1),
(5, 'Middle East', 1),
(6, 'United Kingdom', 1),
(7, 'Scandinavia (Sweden, Denmark, Norway, Finland)', 1),
(8, 'European Union', 1),
(9, 'Africa', 1),
(10, 'Indian Subcontinent', 1),
(11, 'Eastern Europe', 1);

CREATE TABLE `supplier_regions` (
  `sr_id` int(11) NOT NULL AUTO_INCREMENT,
  `sd_id` int(11) NOT NULL,
  `region_id` int(11) NOT NULL,
  `is_active` smallint(6) NOT NULL,
  PRIMARY KEY (`sr_id`),
  INDEX `sd_id` (`sd_id`),
INDEX `region_id` (`region_id`),
INDEX `is_active` (`is_active`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;


CREATE TABLE `job_freight_allocation` (
  `jfa_id` int(11) NOT NULL AUTO_INCREMENT,
  `job_id` int(11) NOT NULL,
  `fd_id` int(11) NOT NULL,
  `is_active` smallint(6) NOT NULL DEFAULT '1',
  PRIMARY KEY (`jfa_id`),
  INDEX `job_id` (`job_id`),
  INDEX `fd_id` (`fd_id`),
  INDEX `is_active` (`is_active`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;


CREATE TABLE `freight_quote` (
  `fq_id` int(11) NOT NULL AUTO_INCREMENT,
  `job_id` int(11) NOT NULL,
  `job_order_id` int(11) NOT NULL,
  `fd_id` int(11) NOT NULL,
  `currency_id` int(11) NOT NULL,
  `shipment_total_cost_ex_tax` float NOT NULL,
  `shipment_total_cost_inc_tax` float NOT NULL,
  `shipping_method_id` int(11) NOT NULL,
  `incoterm_id` int(11) NOT NULL,
  `shipment_nett_weight` float NOT NULL,
  `shipment_gross_weight` float NOT NULL,
  `transit_time` int(11) NOT NULL COMMENT 'From collection to delivery',
  `additional_notes` text,
  `is_approved` smallint(6) NOT NULL DEFAULT '0',
  `created_time` int(11) NOT NULL,
  `is_active` smallint(6) NOT NULL DEFAULT '1',
  PRIMARY KEY (`fq_id`),
  INDEX `job_id` (`job_id`),
  INDEX `job_order_id` (`job_order_id`),
  INDEX `fd_id` (`fd_id`),
  INDEX `currency_id` (`currency_id`),
  INDEX `created_time` (`created_time`),
  INDEX `shipping_method_id` (`shipping_method_id`),
  INDEX `incoterm_id` (`incoterm_id`),
  INDEX `transit_time` (`transit_time`),
  INDEX `is_approved` (`is_approved`),
  INDEX `is_active` (`is_active`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=latin1;


CREATE TABLE `shipping_method` (
  `shipping_method_id` int(11) NOT NULL AUTO_INCREMENT,
  `shipping_method_name` varchar(50) NOT NULL,
  `is_active` smallint(6) NOT NULL DEFAULT '1',
  PRIMARY KEY (`shipping_method_id`),
  INDEX `shipping_method_name` (`shipping_method_name`),
  INDEX `is_active` (`is_active`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

INSERT INTO `shipping_method` (`shipping_method_id`, `shipping_method_name`, `is_active`) VALUES
(1, 'Courier', 1),
(2, 'Air Freight', 1),
(3, 'Sea Freight', 1),
(4, 'Road Freight', 1),
(5, 'Split Shipment', 1);


CREATE TABLE `newsletter` (
  `nl_id` int(11) NOT NULL AUTO_INCREMENT,
  `email` varchar(100) NOT NULL,
  `hash_tag` varchar(250) NOT NULL,
  `is_active` smallint(6) NOT NULL,
  PRIMARY KEY (`nl_id`),
  UNIQUE KEY `email` (`email`),
  INDEX `hash_tag` (`hash_tag`),
  INDEX `is_active` (`is_active`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;


CREATE TABLE `job_shipping_details` (
  `jsd_id` int(11) NOT NULL AUTO_INCREMENT,
  `job_id` int(11) NOT NULL,
  `from_address_id` int(11) NULL,
  `from_address_supplier_address` smallint(6) NULL,
  `to_address_id` int(11) NULL,
  `to_address_consumer_address`  smallint(6) NULL,
  `is_require_delivery` smallint(6) NULL DEFAULT '0',
  `is_courier` smallint(6) NULL,
  `is_air_freight` smallint(6) NULL,
  `is_sea_freight` smallint(6) NULL,
  `is_active` smallint(6) NOT NULL,
  PRIMARY KEY (`jsd_id`),
  INDEX `job_id` (`job_id`),
  INDEX `is_require_delivery` (`is_require_delivery`),
  INDEX `is_courier` (`is_courier`),
  INDEX `is_air_freight` (`is_air_freight`),
  INDEX `is_sea_freight` (`is_sea_freight`),
  INDEX `from_address_id` (`from_address_id`),
  INDEX `to_address_id` (`to_address_id`),
  INDEX `is_active` (`is_active`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;