/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
/**
 * Author:  Admin
 * Created: Jun 7, 2016
 */

/* Release 20160608 */
CREATE TABLE `news_comments` (
 `news_comment_id` INT(11) NOT NULL AUTO_INCREMENT ,
 `news_id` INT(11) NOT NULL ,
 `user_id` INT(11) NOT NULL ,
 `description` TEXT NOT NULL ,
`created_time` INT(11) NOT NULL ,
 `is_active` SMALLINT NOT NULL ,
 PRIMARY KEY(`news_comment_id`),
 INDEX `news_id` (`news_id`),
 INDEX `user_id` (`user_id`),
 INDEX `created_time`(`created_time`)
) ENGINE = InnoDB;

/* Release 20160613 */
CREATE TABLE `news_subcategory` ( 
 `news_subcategory_id` INT(11) NOT NULL AUTO_INCREMENT , 
 `news_category_id` INT(11) NOT NULL ,
 `subcategory_name` VARCHAR(100) NOT NULL , 
 `description` TEXT NOT NULL , 
 `created_by` INT(11) NOT NULL , 
 `created_time` INT(11) NOT NULL , 
 `is_active` SMALLINT NOT NULL , 
 PRIMARY KEY (`news_subcategory_id`), 
 INDEX `news_category_id` (`news_category_id`),
 INDEX `created_by` (`created_by`), 
 INDEX `created_time` (`created_time`), 
 INDEX `subcategory_name` (`subcategory_name`)
) ENGINE = InnoDB;

ALTER TABLE `news` CHANGE `news_category_id` `news_subcategory_id` INT(11) NOT NULL;

/* Release 20160621 */

ALTER TABLE `news_comments` ADD `is_moderated` SMALLINT NOT NULL DEFAULT '0' AFTER `is_active`;

CREATE TABLE `company_details` (
  `company_details_id` int(11) NOT NULL AUTO_INCREMENT,
  `company_name` varchar(150) NOT NULL,
  `company_logo_path` varchar(250) NOT NULL,
  `website` varchar(100) NOT NULL,
  `is_active` smallint(6) NOT NULL DEFAULT '1',
  PRIMARY KEY (`company_details_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

ALTER TABLE `consumer_details` ADD `company_details_id` INT NULL AFTER `address_id`, ADD INDEX (`company_details_id`);

ALTER TABLE `supplier_details` ADD `company_details_id` INT NULL AFTER `address_id`, ADD INDEX (`company_details_id`);

ALTER TABLE `freight_details` ADD `company_details_id` INT NULL AFTER `address_id`, ADD INDEX (`company_details_id`);


CREATE TABLE `admin_details` (
  `admin_id` int(11) NOT NULL AUTO_INCREMENT,
  `user_id` int(11) NOT NULL,
  `logo_path` varchar(250) DEFAULT NULL,
  `address_id` int(11) NOT NULL,
  `company_details_id` int(11) NOT NULL,
  `is_active` smallint(6) NOT NULL DEFAULT '1',
  PRIMARY KEY (`admin_id`),
  INDEX `user_id` (`user_id`),
  INDEX `address_id` (`address_id`),
  INDEX `company_details_id` (`company_details_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

INSERT INTO `admin_details` (`admin_id`, `user_id`, `logo_path`, `address_id`, `company_details_id`, `is_active`) VALUES (NULL, '1', NULL, '0', '0', '1');

ALTER TABLE `country` ADD `region_id` INT NOT NULL AFTER `country_name`, ADD INDEX `region_id` (`region_id`);

UPDATE country SET region_id =4 WHERE country_id =1;
UPDATE country SET region_id =1 WHERE country_id =2;
UPDATE country SET region_id =9 WHERE country_id =3;
UPDATE country SET region_id =3 WHERE country_id =4;
UPDATE country SET region_id =8 WHERE country_id =5;
UPDATE country SET region_id =11 WHERE country_id =6;
UPDATE country SET region_id =8 WHERE country_id =7;
UPDATE country SET region_id =5 WHERE country_id =8;
UPDATE country SET region_id =4 WHERE country_id =9;
UPDATE country SET region_id =5 WHERE country_id =10;
UPDATE country SET region_id =4 WHERE country_id =11;
UPDATE country SET region_id =1 WHERE country_id =12;
UPDATE country SET region_id =4 WHERE country_id =13;
UPDATE country SET region_id =3 WHERE country_id =14;
UPDATE country SET region_id =1 WHERE country_id =15;
UPDATE country SET region_id =8 WHERE country_id =16;
UPDATE country SET region_id =5 WHERE country_id =17;
UPDATE country SET region_id =9 WHERE country_id =18;
UPDATE country SET region_id =8 WHERE country_id =19;
UPDATE country SET region_id =9 WHERE country_id =20;
UPDATE country SET region_id =3 WHERE country_id =21;
UPDATE country SET region_id =9 WHERE country_id =22;
UPDATE country SET region_id =10 WHERE country_id =23;
UPDATE country SET region_id =8 WHERE country_id =24;
UPDATE country SET region_id =5 WHERE country_id =25;
UPDATE country SET region_id =3 WHERE country_id =26;
UPDATE country SET region_id =11 WHERE country_id =27;
UPDATE country SET region_id =3 WHERE country_id =28;
UPDATE country SET region_id =11 WHERE country_id =29;
UPDATE country SET region_id =3 WHERE country_id =30;
UPDATE country SET region_id =2 WHERE country_id =31;
UPDATE country SET region_id =4 WHERE country_id =32;
UPDATE country SET region_id =4 WHERE country_id =33;
UPDATE country SET region_id =3 WHERE country_id =34;
UPDATE country SET region_id =1 WHERE country_id =35;
UPDATE country SET region_id =10 WHERE country_id =36;
UPDATE country SET region_id =9 WHERE country_id =37;
UPDATE country SET region_id =9 WHERE country_id =38;
UPDATE country SET region_id =9 WHERE country_id =39;
UPDATE country SET region_id =2 WHERE country_id =40;
UPDATE country SET region_id =1 WHERE country_id =41;
UPDATE country SET region_id =8 WHERE country_id =42;
UPDATE country SET region_id =4 WHERE country_id =43;
UPDATE country SET region_id =10 WHERE country_id =44;
UPDATE country SET region_id =9 WHERE country_id =45;
UPDATE country SET region_id =9 WHERE country_id =46;
UPDATE country SET region_id =9 WHERE country_id =47;
UPDATE country SET region_id =9 WHERE country_id =48;
UPDATE country SET region_id =1 WHERE country_id =49;
UPDATE country SET region_id =4 WHERE country_id =50;
UPDATE country SET region_id =9 WHERE country_id =51;
UPDATE country SET region_id =9 WHERE country_id =52;
UPDATE country SET region_id =3 WHERE country_id =53;
UPDATE country SET region_id =3 WHERE country_id =54;
UPDATE country SET region_id =3 WHERE country_id =55;
UPDATE country SET region_id =1 WHERE country_id =56;
UPDATE country SET region_id =3 WHERE country_id =57;
UPDATE country SET region_id =8 WHERE country_id =58;
UPDATE country SET region_id =8 WHERE country_id =59;
UPDATE country SET region_id =8 WHERE country_id =60;
UPDATE country SET region_id =9 WHERE country_id =61;
UPDATE country SET region_id =3 WHERE country_id =62;
UPDATE country SET region_id =7 WHERE country_id =63;
UPDATE country SET region_id =3 WHERE country_id =64;
UPDATE country SET region_id =9 WHERE country_id =65;
UPDATE country SET region_id =4 WHERE country_id =66;
UPDATE country SET region_id =9 WHERE country_id =67;
UPDATE country SET region_id =9 WHERE country_id =68;
UPDATE country SET region_id =9 WHERE country_id =69;
UPDATE country SET region_id =8 WHERE country_id =70;
UPDATE country SET region_id =8 WHERE country_id =71;
UPDATE country SET region_id =9 WHERE country_id =72;
UPDATE country SET region_id =7 WHERE country_id =73;
UPDATE country SET region_id =1 WHERE country_id =74;
UPDATE country SET region_id =4 WHERE country_id =75;
UPDATE country SET region_id =8 WHERE country_id =76;
UPDATE country SET region_id =8 WHERE country_id =77;
UPDATE country SET region_id =1 WHERE country_id =78;
UPDATE country SET region_id =9 WHERE country_id =79;
UPDATE country SET region_id =6 WHERE country_id =80;
UPDATE country SET region_id =5 WHERE country_id =81;
UPDATE country SET region_id =8 WHERE country_id =82;
UPDATE country SET region_id =9 WHERE country_id =83;
UPDATE country SET region_id =8 WHERE country_id =84;
UPDATE country SET region_id =9 WHERE country_id =85;
UPDATE country SET region_id =3 WHERE country_id =86;
UPDATE country SET region_id =9 WHERE country_id =87;
UPDATE country SET region_id =9 WHERE country_id =88;
UPDATE country SET region_id =9 WHERE country_id =89;
UPDATE country SET region_id =8 WHERE country_id =90;
UPDATE country SET region_id =3 WHERE country_id =91;
UPDATE country SET region_id =11 WHERE country_id =92;
UPDATE country SET region_id =3 WHERE country_id =93;
UPDATE country SET region_id =4 WHERE country_id =94;
UPDATE country SET region_id =1 WHERE country_id =95;
UPDATE country SET region_id =4 WHERE country_id =96;
UPDATE country SET region_id =1 WHERE country_id =97;
UPDATE country SET region_id =1 WHERE country_id =98;
UPDATE country SET region_id =3 WHERE country_id =99;
UPDATE country SET region_id =11 WHERE country_id =100;
UPDATE country SET region_id =3 WHERE country_id =101;
UPDATE country SET region_id =8 WHERE country_id =102;
UPDATE country SET region_id =1 WHERE country_id =103;
UPDATE country SET region_id =8 WHERE country_id =104;
UPDATE country SET region_id =1 WHERE country_id =105;
UPDATE country SET region_id =6 WHERE country_id =106;
UPDATE country SET region_id =8 WHERE country_id =107;
UPDATE country SET region_id =5 WHERE country_id =108;
UPDATE country SET region_id =5 WHERE country_id =109;
UPDATE country SET region_id =7 WHERE country_id =110;
UPDATE country SET region_id =5 WHERE country_id =111;
UPDATE country SET region_id =8 WHERE country_id =112;
UPDATE country SET region_id =3 WHERE country_id =113;
UPDATE country SET region_id =6 WHERE country_id =114;
UPDATE country SET region_id =5 WHERE country_id =115;
UPDATE country SET region_id =1 WHERE country_id =116;
UPDATE country SET region_id =1 WHERE country_id =117;
UPDATE country SET region_id =9 WHERE country_id =118;
UPDATE country SET region_id =1 WHERE country_id =119;
UPDATE country SET region_id =1 WHERE country_id =120;
UPDATE country SET region_id =1 WHERE country_id =121;
UPDATE country SET region_id =3 WHERE country_id =122;
UPDATE country SET region_id =1 WHERE country_id =123;
UPDATE country SET region_id =5 WHERE country_id =124;
UPDATE country SET region_id =1 WHERE country_id =125;
UPDATE country SET region_id =5 WHERE country_id =126;
UPDATE country SET region_id =9 WHERE country_id =127;
UPDATE country SET region_id =9 WHERE country_id =128;
UPDATE country SET region_id =3 WHERE country_id =129;
UPDATE country SET region_id =8 WHERE country_id =130;
UPDATE country SET region_id =10 WHERE country_id =131;
UPDATE country SET region_id =9 WHERE country_id =132;
UPDATE country SET region_id =8 WHERE country_id =133;
UPDATE country SET region_id =8 WHERE country_id =134;
UPDATE country SET region_id =8 WHERE country_id =135;
UPDATE country SET region_id =1 WHERE country_id =136;
UPDATE country SET region_id =3 WHERE country_id =137;
UPDATE country SET region_id =9 WHERE country_id =138;
UPDATE country SET region_id =8 WHERE country_id =139;
UPDATE country SET region_id =11 WHERE country_id =140;
UPDATE country SET region_id =9 WHERE country_id =141;
UPDATE country SET region_id =10 WHERE country_id =142;
UPDATE country SET region_id =3 WHERE country_id =143;
UPDATE country SET region_id =1 WHERE country_id =144;
UPDATE country SET region_id =11 WHERE country_id =145;
UPDATE country SET region_id =9 WHERE country_id =146;
UPDATE country SET region_id =9 WHERE country_id =147;
UPDATE country SET region_id =1 WHERE country_id =148;
UPDATE country SET region_id =11 WHERE country_id =149;
UPDATE country SET region_id =10 WHERE country_id =150;
UPDATE country SET region_id =1 WHERE country_id =151;
UPDATE country SET region_id =9 WHERE country_id =152;
UPDATE country SET region_id =9 WHERE country_id =153;
UPDATE country SET region_id =3 WHERE country_id =154;
UPDATE country SET region_id =3 WHERE country_id =155;
UPDATE country SET region_id =9 WHERE country_id =156;
UPDATE country SET region_id =9 WHERE country_id =157;
UPDATE country SET region_id =1 WHERE country_id =158;
UPDATE country SET region_id =9 WHERE country_id =159;
UPDATE country SET region_id =9 WHERE country_id =160;
UPDATE country SET region_id =1 WHERE country_id =161;
UPDATE country SET region_id =9 WHERE country_id =162;
UPDATE country SET region_id =1 WHERE country_id =163;
UPDATE country SET region_id =9 WHERE country_id =164;
UPDATE country SET region_id =3 WHERE country_id =165;
UPDATE country SET region_id =1 WHERE country_id =166;
UPDATE country SET region_id =8 WHERE country_id =167;
UPDATE country SET region_id =7 WHERE country_id =168;
UPDATE country SET region_id =10 WHERE country_id =169;
UPDATE country SET region_id =1 WHERE country_id =170;
UPDATE country SET region_id =1 WHERE country_id =171;
UPDATE country SET region_id =5 WHERE country_id =172;
UPDATE country SET region_id =10 WHERE country_id =173;
UPDATE country SET region_id =3 WHERE country_id =174;
UPDATE country SET region_id =4 WHERE country_id =175;
UPDATE country SET region_id =4 WHERE country_id =176;
UPDATE country SET region_id =1 WHERE country_id =177;
UPDATE country SET region_id =1 WHERE country_id =178;
UPDATE country SET region_id =1 WHERE country_id =179;
UPDATE country SET region_id =8 WHERE country_id =180;
UPDATE country SET region_id =3 WHERE country_id =181;
UPDATE country SET region_id =1 WHERE country_id =182;
UPDATE country SET region_id =8 WHERE country_id =183;
UPDATE country SET region_id =4 WHERE country_id =184;
UPDATE country SET region_id =5 WHERE country_id =185;
UPDATE country SET region_id =4 WHERE country_id =186;
UPDATE country SET region_id =5 WHERE country_id =187;
UPDATE country SET region_id =3 WHERE country_id =188;
UPDATE country SET region_id =8 WHERE country_id =189;
UPDATE country SET region_id =11 WHERE country_id =190;
UPDATE country SET region_id =9 WHERE country_id =191;
UPDATE country SET region_id =5 WHERE country_id =192;
UPDATE country SET region_id =9 WHERE country_id =193;
UPDATE country SET region_id =9 WHERE country_id =194;
UPDATE country SET region_id =1 WHERE country_id =195;
UPDATE country SET region_id =4 WHERE country_id =196;
UPDATE country SET region_id =9 WHERE country_id =197;
UPDATE country SET region_id =8 WHERE country_id =198;
UPDATE country SET region_id =1 WHERE country_id =199;
UPDATE country SET region_id =9 WHERE country_id =200;
UPDATE country SET region_id =3 WHERE country_id =201;
UPDATE country SET region_id =8 WHERE country_id =202;
UPDATE country SET region_id =9 WHERE country_id =203;
UPDATE country SET region_id =2 WHERE country_id =204;
UPDATE country SET region_id =8 WHERE country_id =205;
UPDATE country SET region_id =9 WHERE country_id =206;
UPDATE country SET region_id =9 WHERE country_id =207;
UPDATE country SET region_id =4 WHERE country_id =208;
UPDATE country SET region_id =8 WHERE country_id =209;
UPDATE country SET region_id =8 WHERE country_id =210;
UPDATE country SET region_id =8 WHERE country_id =211;
UPDATE country SET region_id =9 WHERE country_id =212;
UPDATE country SET region_id =3 WHERE country_id =213;
UPDATE country SET region_id =9 WHERE country_id =214;
UPDATE country SET region_id =5 WHERE country_id =215;
UPDATE country SET region_id =3 WHERE country_id =216;
UPDATE country SET region_id =9 WHERE country_id =217;
UPDATE country SET region_id =9 WHERE country_id =218;
UPDATE country SET region_id =1 WHERE country_id =219;
UPDATE country SET region_id =1 WHERE country_id =220;
UPDATE country SET region_id =1 WHERE country_id =221;
UPDATE country SET region_id =5 WHERE country_id =222;
UPDATE country SET region_id =1 WHERE country_id =223;
UPDATE country SET region_id =1 WHERE country_id =224;
UPDATE country SET region_id =3 WHERE country_id =225;
UPDATE country SET region_id =9 WHERE country_id =226;
UPDATE country SET region_id =5 WHERE country_id =227;
UPDATE country SET region_id =1 WHERE country_id =228;
UPDATE country SET region_id =1 WHERE country_id =229;
UPDATE country SET region_id =9 WHERE country_id =230;
UPDATE country SET region_id =9 WHERE country_id =231;
UPDATE country SET region_id =11 WHERE country_id =232;
UPDATE country SET region_id =1 WHERE country_id =233;
UPDATE country SET region_id =4 WHERE country_id =234;
UPDATE country SET region_id =2 WHERE country_id =235;
UPDATE country SET region_id =1 WHERE country_id =236;
UPDATE country SET region_id =8 WHERE country_id =237;
UPDATE country SET region_id =3 WHERE country_id =238;
UPDATE country SET region_id =4 WHERE country_id =239;
UPDATE country SET region_id =3 WHERE country_id =240;
UPDATE country SET region_id =3 WHERE country_id =241;
UPDATE country SET region_id =1 WHERE country_id =242;
UPDATE country SET region_id =1 WHERE country_id =243;
UPDATE country SET region_id =1 WHERE country_id =244;
UPDATE country SET region_id =1 WHERE country_id =245;
UPDATE country SET region_id =5 WHERE country_id =246;
UPDATE country SET region_id =9 WHERE country_id =247;
UPDATE country SET region_id =9 WHERE country_id =248;
UPDATE country SET region_id =9 WHERE country_id =249;

ALTER TABLE `find_supplier_request` ADD `comments` VARCHAR(255) NOT NULL AFTER `request_type_id`;

ALTER TABLE `news` ADD `news_category_id` INT NOT NULL AFTER `description` ;

CREATE TABLE `user_transformation` (
  `ut_id` int(11) NOT NULL AUTO_INCREMENT,
  `user_id` int(11) NOT NULL,
  `user_type_id` int(11) NOT NULL,
  `created_time` int(11) NOT NULL,
  PRIMARY KEY (`ut_id`),
  KEY `user_id` (`user_id`),
  KEY `user_type_id` (`user_type_id`),
  KEY `created_time` (`created_time`)
) ENGINE=InnoDB AUTO_INCREMENT=28 DEFAULT CHARSET=latin1;


CREATE TABLE `content_product_mapping` (
  `product_id` int(11) NOT NULL AUTO_INCREMENT,
  `news_id`    int(11) NOT NULL, 
  `cat_id`    int(11) NOT NULL, 
  `sub_cat_id`int(11) NOT NULL, 
  `is_active` smallint(6) NOT NULL DEFAULT '1',
  PRIMARY KEY (`product_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

UPDATE `request_type` SET `request_type` = 'Email Supplier' WHERE `request_type`.`request_id` =1;
UPDATE `request_type` SET `request_type` = 'Request A Call' WHERE `request_type`.`request_id` =2;