/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
/**
 * Author:  Admin
 * Created: Apr 11, 2016
 */

ALTER TABLE `supplier_details` 
CHANGE `company_name` `company_name` VARCHAR(250) DEFAULT NULL, 
CHANGE `trading_name` `trading_name` VARCHAR(250) DEFAULT NULL;


ALTER TABLE `freight_details` 
CHANGE `company_name` `company_name` VARCHAR(250) DEFAULT NULL, 
CHANGE `trading_name` `trading_name` VARCHAR(250) DEFAULT NULL;


ALTER TABLE `user_type` 
CHANGE `user_type_name` `user_type_name` VARCHAR(150) NOT NULL;


ALTER TABLE `job_file` 
CHANGE `file_type_id` `file_type_id` SMALLINT(6) NOT NULL;


ALTER TABLE `job_status` 
CHANGE `job_status_name` `job_status_name` VARCHAR(250) NOT NULL;


ALTER TABLE `job_quote` 
CHANGE `unit_volume` `unit_volume` FLOAT NULL DEFAULT NULL;

CREATE TABLE `job_quote_chat` (
  `jqc_id` int(11) NOT NULL AUTO_INCREMENT,
  `jq_id` int(11) NOT NULL,
  `user_id` int(11) NULL,
  `created_time` int(11) NULL,
  `msg` text NULL,
  `is_active` smallint(6) NOT NULL,
  PRIMARY KEY (`jqc_id`),
  INDEX `jq_id` (`jq_id`),
  INDEX `user_id` (`user_id`),
  INDEX `is_active` (`is_active`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

UPDATE `country` SET `iso_country_code` = 'ly' WHERE `country_id` = 128;

/*** Phase 2 release 2*/
ALTER TABLE `job_details` DROP `modified_time`;

ALTER TABLE `job_details` ADD `completed_time` INT NULL AFTER `created_time`, ADD INDEX (`completed_time`);




/*** phase 2 release 3 **/

ALTER TABLE `consumer_details` 
ADD `company_name` VARCHAR(150) NULL AFTER `address_id`, 
ADD `company_logo_path` VARCHAR(250) NULL AFTER `company_name`, 
ADD `website` VARCHAR(100) NULL AFTER `company_logo_path`;

ALTER TABLE `supplier_details` 
ADD `company_logo_path` VARCHAR(250) NULL AFTER `address_id`;

INSERT INTO `job_status` (`job_status_id`, `job_status_name`, `is_active`) VALUES (NULL, 'Canceled', '1'); 

/*** phase 2 release 4 - 20160511**/

UPDATE `job_status` SET `job_status_name` = 'Cancelled' WHERE `job_status`.`job_status_id` = 8;


ALTER TABLE `freight_details` 
ADD `company_logo_path` VARCHAR(250) NULL AFTER `address_id`;

UPDATE `country` SET `telephone_code`='+76' WHERE `country_id` = '117';

/*** phase 2 release 5 - 20160516**/

UPDATE `country` SET `country_name` = 'Bolivia (Plurinational State of)' WHERE `country_id` = 32;
UPDATE `country` SET `country_name` = 'Congo (Democratic Republic of the)' WHERE `country_id` = 47;
UPDATE `country` SET `country_name` = 'Micronesia (Federated States of)' WHERE `country_id` = 78;
UPDATE `country` SET `country_name` = 'Iran (Islamic Republic of)' WHERE `country_id` = 108;
UPDATE `country` SET `country_name` = 'Korea (Republic of)' WHERE `country_id` = 123;
UPDATE `country` SET `country_name` = 'Moldova (Republic of)' WHERE `country_id` = 140;
UPDATE `country` SET `country_name` = 'Macedonia (The former Yugoslav Republic of)' WHERE `country_id` = 145;
UPDATE `country` SET `country_name` = 'Korea (Democratic Peoples Republic of)' WHERE `country_id` = 182;
UPDATE `country` SET `country_name` = 'State of Palestine' WHERE `country_id` = 185;
UPDATE `country` SET `country_name` = 'Tanzania (United Republic of)' WHERE `country_id` = 230;
UPDATE `country` SET `country_name` = 'Venezuela (Bolivarian Republic of)' WHERE `country_id` = 239;

ALTER TABLE `contact_us` CHANGE `name` `first_name` VARCHAR(100) 
CHARACTER SET latin1 COLLATE latin1_swedish_ci NOT NULL;

ALTER TABLE `contact_us` ADD `last_name` VARCHAR(50) 
NOT NULL AFTER `first_name`;

ALTER TABLE `contact_us` 
ADD `telephone_code`  VARCHAR(20) NOT NULL AFTER `last_name`, 
ADD `telephone_no` VARCHAR(50) NOT NULL AFTER `telephone_code`;


ALTER TABLE `job_history` 
ADD `super_admin_id` INT NOT NULL DEFAULT '0' AFTER `user_id`;
ALTER TABLE `user_history_log` 
ADD `super_admin_id` INT NOT NULL DEFAULT '0' AFTER `description`;

ALTER TABLE `job_details` ADD `is_sample_required` SMALLINT(6) NULL DEFAULT NULL AFTER `is_sealed`;

UPDATE `country` SET `country_name` = 'Aland Islands' WHERE `country_id` = 5;

/*** phase 2 release 6 - 20160523**/

CREATE TABLE `news` ( 
    `news_id` INT(11) NOT NULL AUTO_INCREMENT , 
    `news_title` VARCHAR(250) NOT NULL , 
    `news_permalink` VARCHAR(250) NOT NULL , 
    `description` TEXT NOT NULL , 
    `news_category_id` INT(11) NOT NULL ,
    `meta_id` INT(11) NOT NULL , 
    `created_by` INT(11) NOT NULL , 
    `created_time` INT(11) NOT NULL , 
    `is_active` SMALLINT NOT NULL , 
    PRIMARY KEY (`news_id`), 
    INDEX `news_title` (`news_title`), 
    INDEX `news_category_id` (`news_category_id`),
    INDEX `meta_id` (`meta_id`),
    INDEX `created_by` (`created_by`), 
    INDEX `created_time` (`created_time`)
) ENGINE = InnoDB;

CREATE TABLE `news_category` ( 
    `news_category_id` INT(11) NOT NULL AUTO_INCREMENT , 
    `category_name` VARCHAR(100) NOT NULL , 
    `description` TEXT NOT NULL , 
    `created_by` INT(11) NOT NULL , 
    `created_time` INT(11) NOT NULL , 
    `is_active` SMALLINT NOT NULL , 
    PRIMARY KEY (`news_category_id`), 
    INDEX `created_by` (`created_by`), 
    INDEX `created_time` (`created_time`), 
    INDEX `category_name` (`category_name`)
) ENGINE = InnoDB;

CREATE TABLE `tags` ( 
    `tag_id` INT(11) NOT NULL AUTO_INCREMENT , 
    `tag_name` VARCHAR(100) NOT NULL , 
    `created_by` INT(11) NOT NULL , 
    `created_time` INT(11) NOT NULL , 
    `is_active` SMALLINT NOT NULL , 
    PRIMARY KEY (`tag_id`), 
    INDEX `tag_name` (`tag_name`), 
    INDEX `created_by` (`created_by`), 
    INDEX `created_time` (`created_time`)
) ENGINE = InnoDB;

CREATE TABLE `meta` ( 
    `meta_id` INT(11) NOT NULL AUTO_INCREMENT ,
    `meta_title` VARCHAR(250) NOT NULL , 
    `meta_keyword` TEXT NOT NULL , 
    `meta_description` TEXT NOT NULL , 
    `is_active` SMALLINT NOT NULL , 
    PRIMARY KEY (`meta_id`), 
    INDEX `meta_title` (`meta_title`)
) ENGINE = InnoDB;

CREATE TABLE `news_images` ( 
    `news_image_id` INT(11) NOT NULL AUTO_INCREMENT , 
    `image_path` TEXT NOT NULL , 
    `news_id` INT(11) NOT NULL , 
    `created_by` INT(11) NOT NULL , 
    `created_time` INT(11) NOT NULL , 
    `is_active` SMALLINT NOT NULL , 
    PRIMARY KEY (`news_image_id`), 
    INDEX `news_id` (`news_id`), 
    INDEX `created_by` (`created_by`), 
    INDEX `created_time` (`created_time`)
) ENGINE = InnoDB;

CREATE TABLE `notification` (
  `notification_id` int(11) NOT NULL AUTO_INCREMENT,
  `user_id` int(11) NOT NULL,
  `job_id` int(11) NOT NULL,
  `description` text NOT NULL,
  `generated_by` int(11) NOT NULL,
  `created_time` int(11) NOT NULL,
  `is_read` smallint(6) NOT NULL DEFAULT '0',
  `is_active` smallint(6) NOT NULL DEFAULT '1',
  PRIMARY KEY (`notification_id`),
  INDEX `user_id` (`user_id`),
  INDEX `job_id` (`job_id`),
  INDEX `generated_by` (`generated_by`),
  INDEX `created_time` (`created_time`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

/*** phase 2 release 6 - 20160527**/

ALTER TABLE `news` ADD UNIQUE(`news_permalink`);

INSERT INTO `sub_categories` ( `cat_id`, `sub_category_name`, `is_active`) VALUES
(1, 'ATM Cards', 1),
(5, 'Fargo', 1),
(5, 'NBS', 1);

CREATE TABLE `job_additional_details` ( 
    `jad_id` INT(11) NOT NULL AUTO_INCREMENT , 
    `job_id` INT(11) NOT NULL ,
    `plastic_id` INT(11)  NULL ,
    `plastic_other` VARCHAR(100)  NULL , 
    `thickness_id` INT(11)  NULL ,
    `thickness_other` VARCHAR(100)  NULL ,  
    `cmyk_id` INT(11)  NULL ,
    `pantone_front_color` VARCHAR(100)  NULL ,  
    `pantone_reverse_color` VARCHAR(100)  NULL ,  
    `metallic_ink_id` INT(11)  NULL , 
    `scented_ink`  SMALLINT  NULL, 
    `uv_ink`  SMALLINT  NULL, 
    `raised_surface`  SMALLINT  NULL, 
    `magnetic_tape_id` INT(11) NOT NULL ,
    `personalization_id` INT(11)  NULL ,
    `magnetic_strip_encoding` SMALLINT  NULL, 
    `scratch_off_panel` SMALLINT  NULL, 
    `front_signature_panel_id` INT(11)  NULL ,
    `reverse_signature_panel_id` INT(11)  NULL ,
    `embossing_id` INT(11)  NULL ,
    `hologram_id` INT(11)  NULL ,
    `hologram_other` VARCHAR(100)  NULL ,  
    `hotstamping_id` INT(11)  NULL ,
    `hotstamping_other` VARCHAR(100)  NULL , 
    `fulfillment_service_required` SMALLINT  NULL, 
    `card_holder` SMALLINT  NULL, 
    `dimensions` VARCHAR(100)  NULL ,  
    `gsm` VARCHAR(100)  NULL ,  
    `finish_id` INT(11)  NULL ,
    `attach_card_with_glue` SMALLINT  NULL, 
    `bundling_required_id` INT(11)  NULL ,
    `bundling_required_other` VARCHAR(100)  NULL , 
    `contactless_chip_id` INT(11)  NULL ,
    `contactless_chip_other` VARCHAR(100)  NULL , 
    `contact_chip_id` INT(11)  NULL ,
    `contact_chip_other` VARCHAR(100)  NULL , 
    `key_tag_id` INT(11)  NULL ,
    `key_hole_punching` SMALLINT  NULL, 
    `unique_card_size` VARCHAR(100)  NULL , 
    `is_active` SMALLINT NOT NULL , 
    PRIMARY KEY (`jad_id`), 
    INDEX `job_id` (`job_id`), 
    INDEX `plastic_id` (`plastic_id`),
    INDEX `thickness_id` (`thickness_id`),
    INDEX `cmyk_id` (`cmyk_id`),
    INDEX `front_signature_panel_id` (`front_signature_panel_id`),  
    INDEX `embossing_id` (`embossing_id`),  
    INDEX `magnetic_tape_id` (`magnetic_tape_id`), 
    INDEX `metallic_ink_id` (`metallic_ink_id`),  
    INDEX `hologram_id` (`hologram_id`), 
    INDEX `hotstamping_id` (`hotstamping_id`), 
    INDEX `bundling_required_id` (`bundling_required_id`), 
    INDEX `contact_chip_id` (`contact_chip_id`), 
    INDEX `key_tag_id` (`key_tag_id`), 
    INDEX `is_active` (`is_active`)
) ENGINE = InnoDB;

CREATE TABLE `plastic` (
  `plastic_id` int(11) NOT NULL AUTO_INCREMENT,
  `plastic_name` varchar(100) NOT NULL,
  `is_active` smallint(6) NOT NULL DEFAULT '1',
  PRIMARY KEY (`plastic_id`),
  INDEX `plastic_name` (`plastic_name`),
  INDEX `is_active` (`is_active`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;


INSERT INTO `plastic` (`plastic_id`, `plastic_name`, `is_active`) VALUES
(1, 'PVC_White', 1),
(2, 'PVC-Transparent', 1),
(3, 'Recycled PVC', 1),
(4, 'PETG', 1),
(5, 'ABS', 1),
(7, 'PET', 1),
(8, 'Paper', 1),
(9, 'Other - Please Specify', 1);

CREATE TABLE `thickness` (
  `thickness_id` int(11) NOT NULL AUTO_INCREMENT,
  `thickness_name` varchar(100) NOT NULL,
  `is_active` smallint(6) NOT NULL DEFAULT '1',
  PRIMARY KEY (`thickness_id`),
  INDEX `thickness_name` (`thickness_name`),
  INDEX `is_active` (`is_active`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

INSERT INTO `thickness` (`thickness_id`, `thickness_name`, `is_active`) VALUES
(1, '0.30mm', 1),
(2, '0.46mm', 1),
(3, '0.76mm', 1),
(4, '1.00mm', 1),
(5, '1.50mm', 1),
(6, 'Other - Please Specify', 1);

CREATE TABLE `cmyk` (
  `cmyk_id` int(11) NOT NULL AUTO_INCREMENT,
  `cmyk_name` varchar(100) NOT NULL,
  `is_active` smallint(6) NOT NULL DEFAULT '1',
  PRIMARY KEY (`cmyk_id`),
  INDEX `cmyk_name` (`cmyk_name`),
  INDEX `is_active` (`is_active`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

INSERT INTO `cmyk` (`cmyk_id`, `cmyk_name`, `is_active`) VALUES
(1, '1 side', 1),
(2, '2 side', 1);

CREATE TABLE `metallic_ink` (
  `metallic_ink_id` int(11) NOT NULL AUTO_INCREMENT,
  `metallic_ink_name` varchar(100) NOT NULL,
  `is_active` smallint(6) NOT NULL DEFAULT '1',
  PRIMARY KEY (`metallic_ink_id`),
  INDEX `metallic_ink_name` (`metallic_ink_name`),
  INDEX `is_active` (`is_active`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;


INSERT INTO `metallic_ink` (`metallic_ink_id`, `metallic_ink_name`, `is_active`) VALUES
(1, '1 side', 1),
(2, '2 side', 1);

CREATE TABLE `magnetic_tape` (
  `magnetic_tape_id` int(11) NOT NULL AUTO_INCREMENT,
  `magnetic_tape_name` varchar(100) NOT NULL,
  `is_active` smallint(6) NOT NULL DEFAULT '1',
  PRIMARY KEY (`magnetic_tape_id`),
  INDEX `magnetic_tape_name` (`magnetic_tape_name`),
  INDEX `is_active` (`is_active`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

INSERT INTO `magnetic_tape` (`magnetic_tape_id`, `magnetic_tape_name`, `is_active`) VALUES
(1, 'HiCo', 1),
(2, 'LoCo', 1);

CREATE TABLE `personalization` (
  `personalization_id` int(11) NOT NULL AUTO_INCREMENT,
  `personalization_name` varchar(100) NOT NULL,
  `is_active` smallint(6) NOT NULL DEFAULT '1',
  PRIMARY KEY (`personalization_id`),
  INDEX `personalization_name` (`personalization_name`),
  INDEX `is_active` (`is_active`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

INSERT INTO `personalization` (`personalization_id`, `personalization_name`, `is_active`) VALUES
(1, '1 side', 1),
(2, '2 side', 1);

CREATE TABLE `front_signature_panel` (
  `front_signature_panel_id` int(11) NOT NULL AUTO_INCREMENT,
  `front_signature_panel_name` varchar(100) NOT NULL,
  `is_active` smallint(6) NOT NULL DEFAULT '1',
  PRIMARY KEY (`front_signature_panel_id`),
  INDEX `front_signature_panel_name` (`front_signature_panel_name`),
  INDEX `is_active` (`is_active`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

INSERT INTO `front_signature_panel` (`front_signature_panel_id`, `front_signature_panel_name`, `is_active`) VALUES
(1, 'White', 1),
(2, 'Clear', 1);

CREATE TABLE `reverse_signature_panel` (
  `reverse_signature_panel_id` int(11) NOT NULL AUTO_INCREMENT,
  `reverse_signature_panel_name` varchar(100) NOT NULL,
  `is_active` smallint(6) NOT NULL DEFAULT '1',
  PRIMARY KEY (`reverse_signature_panel_id`),
  INDEX `reverse_signature_panel_name` (`reverse_signature_panel_name`),
  INDEX `is_active` (`is_active`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

INSERT INTO `reverse_signature_panel` (`reverse_signature_panel_id`, `reverse_signature_panel_name`, `is_active`) VALUES
(1, 'White', 1),
(2, 'Clear', 1);

CREATE TABLE `embossing` (
  `embossing_id` int(11) NOT NULL AUTO_INCREMENT,
  `embossing_name` varchar(100) NOT NULL,
  `is_active` smallint(6) NOT NULL DEFAULT '1',
  PRIMARY KEY (`embossing_id`),
  INDEX `embossing_name` (`embossing_name`),
  INDEX `is_active` (`is_active`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

INSERT INTO `embossing` (`embossing_id`, `embossing_name`, `is_active`) VALUES
(1, 'Gold', 1),
(2, 'Silver', 1);

CREATE TABLE `hologram` (
  `hologram_id` int(11) NOT NULL AUTO_INCREMENT,
  `hologram_name` varchar(100) NOT NULL,
  `is_active` smallint(6) NOT NULL DEFAULT '1',
  PRIMARY KEY (`hologram_id`),
  INDEX `hologram_name` (`hologram_name`),
  INDEX `is_active` (`is_active`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

INSERT INTO `hologram` (`hologram_id`, `hologram_name`, `is_active`) VALUES
(1, 'Visa', 1),
(2, 'MasterCard', 1),
(3, 'Diners Club', 1),
(4, 'Custom', 1),
(5, 'Others - Please Specify', 1);

CREATE TABLE `hotstamping` (
  `hotstamping_id` int(11) NOT NULL AUTO_INCREMENT,
  `hotstamping_name` varchar(100) NOT NULL,
  `is_active` smallint(6) NOT NULL DEFAULT '1',
  PRIMARY KEY (`hotstamping_id`),
  INDEX `hotstamping_name` (`hotstamping_name`),
  INDEX `is_active` (`is_active`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

INSERT INTO `hotstamping` (`hotstamping_id`, `hotstamping_name`, `is_active`) VALUES
(1, 'Gold', 1),
(2, 'Silver', 1),
(3, 'Other', 1);


CREATE TABLE `finish` (
  `finish_id` int(11) NOT NULL AUTO_INCREMENT,
  `finish_name` varchar(100) NOT NULL,
  `is_active` smallint(6) NOT NULL DEFAULT '1',
  PRIMARY KEY (`finish_id`),
  INDEX `finish_name` (`finish_name`),
  INDEX `is_active` (`is_active`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

INSERT INTO `finish` (`finish_id`, `finish_name`, `is_active`) VALUES
(1, 'Satin', 1),
(2, 'Matte', 1);

CREATE TABLE `bundling_required` (
  `bundling_required_id` int(11) NOT NULL AUTO_INCREMENT,
  `bundling_required_name` varchar(100) NOT NULL,
  `is_active` smallint(6) NOT NULL DEFAULT '1',
  PRIMARY KEY (`bundling_required_id`),
  INDEX `bundling_required_name` (`bundling_required_name`),
  INDEX `is_active` (`is_active`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

INSERT INTO `bundling_required` (`bundling_required_id`, `bundling_required_name`, `is_active`) VALUES
(1, 'In Lots of 10', 1),
(2, 'In Lots of 25', 1),
(3, 'Other - Please Specify', 1);

CREATE TABLE `contactless_chip` (
  `contactless_chip_id` int(11) NOT NULL AUTO_INCREMENT,
  `contactless_chip_name` varchar(100) NOT NULL,
  `is_active` smallint(6) NOT NULL DEFAULT '1',
  PRIMARY KEY (`contactless_chip_id`),
  INDEX `contactless_chip_name` (`contactless_chip_name`),
  INDEX `is_active` (`is_active`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

INSERT INTO `contactless_chip` (`contactless_chip_id`, `contactless_chip_name`, `is_active`) VALUES
(1, 'Mifare Ultralight', 1),
(2, 'Mifare 1k (S50)', 1),
(3, 'Mifare 4k (S70)', 1),
(4, 'EM 4102', 1),
(5, 'TK 4100', 1),
(6, 'Other - Please Specify', 1);



CREATE TABLE `contact_chip` (
  `contact_chip_id` int(11) NOT NULL AUTO_INCREMENT,
  `contact_chip_name` varchar(100) NOT NULL,
  `is_active` smallint(6) NOT NULL DEFAULT '1',
  PRIMARY KEY (`contact_chip_id`),
  INDEX `contact_chip_name` (`contact_chip_name`),
  INDEX `is_active` (`is_active`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

INSERT INTO `contact_chip` (`contact_chip_id`, `contact_chip_name`, `is_active`) VALUES
(1, 'SLE 5528', 1),
(2, 'SLE 5542', 1),
(3, 'Other - Please Specify', 1);



CREATE TABLE `key_tag` (
  `key_tag_id` int(11) NOT NULL AUTO_INCREMENT,
  `key_tag_name` varchar(100) NOT NULL,
  `is_active` smallint(6) NOT NULL DEFAULT '1',
  PRIMARY KEY (`key_tag_id`),
  INDEX `key_tag_name` (`key_tag_name`),
  INDEX `is_active` (`is_active`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

INSERT INTO `key_tag` (`key_tag_id`, `key_tag_name`, `is_active`) VALUES
(1, '2 Up', 1),
(2, '3 Up', 1);

/*** phase 2 release 7 - 20160528**/

CREATE TABLE `chat_notification` (
  `chat_notification_id` int(11) NOT NULL AUTO_INCREMENT,
  `jq_id` int(11) NOT NULL,
  `to_user_id` int(11) NOT NULL,
  `from_user_id` int(11) NOT NULL,
  `description` text NOT NULL,
  `is_read` smallint(6) NOT NULL DEFAULT '0',
  `is_active` smallint(6) NOT NULL DEFAULT '1',
  `created_time` int(11) NOT NULL,
  PRIMARY KEY (`chat_notification_id`),
  INDEX `jq_id` (`jq_id`),
  INDEX `to_user_id` (`to_user_id`),
  INDEX `from_user_id` (`from_user_id`),
  INDEX `created_time` (`created_time`)
) ENGINE=InnoDB AUTO_INCREMENT=11 DEFAULT CHARSET=latin1;


INSERT INTO `sub_categories` ( `cat_id`, `sub_category_name`, `is_active`) VALUES
(1, 'Metal Card', 1);

CREATE TABLE `request_type` (
  `request_id` int(11) NOT NULL AUTO_INCREMENT,
  `request_type` varchar(150) NOT NULL,
  `is_active` smallint(6) NOT NULL DEFAULT '1',
  PRIMARY KEY (`request_id`),
  INDEX `request_type` (`request_type`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

INSERT INTO `request_type` (`request_id`, `request_type`, `is_active`) VALUES (NULL, 'Request for a call', '1');
INSERT INTO `request_type` (`request_id`, `request_type`, `is_active`) VALUES (NULL, 'Request for an email', '1');

CREATE TABLE `find_supplier_request` (
  `find_supplier_request_id` int(11) NOT NULL AUTO_INCREMENT,
  `user_id` int(11) NOT NULL,
  `email` varchar(100) NOT NULL,
  `find_supplier_id` int(11) DEFAULT NULL,
  `sd_id` int(11) NOT NULL,
  `request_type_id` int(11) NOT NULL,
  `is_active` smallint(6) NOT NULL DEFAULT '1',
  PRIMARY KEY (`find_supplier_request_id`),
  INDEX `user_id` (`user_id`),
  INDEX `sd_id` (`sd_id`),
  INDEX `request_type_id` (`request_type_id`)
) ENGINE=InnoDB AUTO_INCREMENT=21 DEFAULT CHARSET=latin1;

/*** phase 2 patch release 8 - 20160530**/

CREATE TABLE `find_supplier_details` ( 
 `find_supplier_id`INT(11) NOT NULL AUTO_INCREMENT ,
 `company_name` VARCHAR(250) NOT NULL ,
 `email`VARCHAR(250) NOT NULL ,
 `telephone_code` VARCHAR(50) NOT NULL ,
 `telephone_number` VARCHAR(100) NOT NULL ,
 `company_logo` VARCHAR(250) NOT NULL,
 `description` TEXT NOT NULL ,
 `region` INT(11) NOT NULL ,
 `country` INT(11)NOT NULL ,
 `is_active` SMALLINT NOT NULL ,
 PRIMARY KEY (`find_supplier_id`)
)ENGINE = InnoDB;

CREATE TABLE `find_supplier_sub_category` (
 `find_supplier_sub_category_id` INT(11) NOT NULL AUTO_INCREMENT ,
 `find_supplier_id` INT(11) NOT NULL , 
 `sub_category_id` INT(11) NOT NULL ,
 `is_active` SMALLINT NOT NULL , 
 PRIMARY KEY (`find_supplier_sub_category_id`),
 INDEX `find_supplier_id` (`find_supplier_id`), 
 INDEX `sub_category_id`(`sub_category_id`)
) ENGINE = InnoDB;

CREATE TABLE `find_supplier_region` (
 `find_supplier_region_id` INT(11) NOT NULL AUTO_INCREMENT , 
 `find_supplier_id`INT(11) NOT NULL ,
 `region_id` INT(11) NOT NULL ,
 `is_active` SMALLINT NOT NULL,
 PRIMARY KEY (`find_supplier_region_id`),
 INDEX `find_supplier_id`(`find_supplier_id`),
 INDEX `region_id` (`region_id`)
) ENGINE = InnoDB;


