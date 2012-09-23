DROP TABLE IF EXISTS `#__cp_clientpipe`;
DROP TABLE IF EXISTS `#__cp_slot`;
Drop TABLE IF EXISTS `#__cp_exception`;
DROP TABLE IF EXISTS `#__cp_slot_alloc`;
DROP TABLE IF EXISTS `#__cp_staff`;
DROP TABLE IF EXISTS `#__cp_staff`;


Create TABLE `#__cp_clientpipe` (
  `id` int(11) NOT NULL auto_increment PRIMARY KEY,
  `greeting` varchar(255) NOT NULL,
  `calendar_title` varchar(128) NULL DEFAULT NULL)
 ENGINE=MyISAM AUTO_INCREMENT=0 DEFAULT CHARSET=utf8;

Create TABLE `#__cp_options` (
  `option_id` int(11) NOT NULL auto_increment PRIMARY KEY,
  `field_name` varchar(45) NOT NULL,
  `field_description` varchar(1024) NULL DEFAULT NULL,
  `field_tooltip` varchar(255) NULL DEFAULT NULL,
  `field_value` varchar(45) NULL DEFAULT NULL)
  ENGINE=MyISAM AUTO_INCREMENT=0 DEFAULT CHARSET=utf8;

Create TABLE `#__cp_slot` (
 `slot_id` int(11) NOT NULL auto_increment PRIMARY KEY,
 `slot_title` varchar(45) NULL DEFAULT NULL,
 `time_start` time NULL DEFAULT NULL,
 `time_end` time NULL DEFAULT NULL,
 `default_slot` tinyint(4) NOT NULL DEFAULT '1',
 `weekdays_csv` varchar(30) NOT NULL DEFAULT 'Mon,Tue,Wed,Thu,Fri', 
 `openings` int(11) NOT NULL DEFAULT '3')
 ENGINE=MyISAM AUTO_INCREMENT=0 DEFAULT CHARSET=utf8;

Create TABLE `#__cp_exception` (
 `exception_id` int(11) NOT NULL auto_increment PRIMARY KEY,
 `exception_date` DATE NULL DEFAULT NULL,
 `slot_id` int(11)  NULL DEFAULT NULL,
 `on_staff_id_csv` varchar(45) NULL DEFAULT NULL,
 `off_staff_id_csv` varchar(45) NULL DEFAULT NULL,
 `all_off` tinyint(4) NOT NULL DEFAULT '0',
 `openings` int(11) NOT NULL DEFAULT '3') 
 ENGINE=MyISAM AUTO_INCREMENT=0 DEFAULT CHARSET=utf8;

Create TABLE `#__cp_slot_alloc` (
 `slot_alloc_id` int(11) NOT NULL auto_increment PRIMARY KEY,
 `slot_id` int(11) NULL DEFAULT NULL,
 `staff_id` int(11) NULL DEFAULT NULL) 
 ENGINE=MyISAM AUTO_INCREMENT=0 DEFAULT CHARSET=utf8;

Create TABLE `#__cp_staff` (
 `staff_id`  int(11) NOT NULL auto_increment PRIMARY KEY,
 `firstname` varchar(45) NULL DEFAULT NULL,
 `lastname`  varchar(45) NULL DEFAULT NULL,
 `email` varchar(128) NULL DEFAULT NULL,
 `contact_info` varchar(1024) NULL DEFAULT NULL )
 ENGINE=MyISAM AUTO_INCREMENT=0 DEFAULT CHARSET=utf8;

CREATE TABLE `#__cp_appointment` (
       `appointment_id` INT UNSIGNED NOT NULL AUTO_INCREMENT PRIMARY KEY, 
       `slot_id` INT NOT NULL, 
       `app_date` DATE NOT NULL, 
       `staff_id` INT NULL DEFAULT NULL, 
       `firstname` VARCHAR(60) NOT NULL, 
       `lastname` VARCHAR(60) NOT NULL, 
       `email` VARCHAR(128) NOT NULL, 
       `phone` VARCHAR(30) NULL DEFAULT NULL,	
       `notes` MEDIUMTEXT NULL DEFAULT NULL, 
       `req_staff_id` INT NULL DEFAULT NULL) 
       ENGINE = MyISAM  AUTO_INCREMENT=0 CHARACTER SET utf8 COLLATE utf8_general_ci;

Create TABLE `#__cp_event` (
 `event_id` int(11) NOT NULL auto_increment PRIMARY KEY,
 `event_start` datetime NULL DEFAULT NULL,
 `event_end` datetime NULL DEFAULT NULL,
 `allday` tinyint(4) NOT NULL DEFAULT '0',
 `title` varchar(80) NULL DEFAULT NULL,
 `description` MEDIUMTEXT CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL)
 ENGINE=MyISAM AUTO_INCREMENT=0 DEFAULT CHARSET=utf8;

Insert INTO `#__cp_clientpipe` (`greeting`,`calendar_title`) VALUES 
       ('Your client scheduling just got piped with Steam Power!','ClientPipe');

Insert INTO `#__cp_options` (`field_name`,`field_value`,`field_description`, `field_tooltip`) VALUES
       ('show_staff','1','Show names of staff who have been assigned to a slot', 'Show names of staff who have been assigned to a slot'),
       ('sync_staff_openings','0','Make appointment slot openings match assigned staff','Make appointment slot openings match assigned staff'),
       ('auto_assign_staff','1','When an appointment is requested, auto-assign the first available staff member to the appointment','Auto-assign available staff to appointments'),
       ('allow_staff_req','1','Allow request for specific staff when creating an appointment','Allow request for specific staff when creating an appointment'),
       ('display_greeting','0','Display greeting above calendar','Display Greeting above calendar'),
       ('display_title','0','Display title above calendar','Display title above calendar'),
       ('default_weekly_recurring','0','Make public appointments weekly recurring','If appointments are all recurring, only one per attendee is allowed'),
       ('staff_display_title','Staff','This is how your staff will be referred to on the site','This is how your staff will be referred to on the site'),
       ('appointment_per_staff','1','Set to one if each staff member can only be allowed one appointment per slot','Potential appointments per slot'),
       ('app_monthly_limit','0','Limit to number of allow appointments per month (set to zero if unlimited)','Limit to number of allow appointments per month (set to zero if unlimited)') ;
       

Insert INTO `#__cp_slot` ( `slot_title`,`time_start`, `time_end`) VALUES 
( 'Early Morning', '9:00:00', '10:00:00'),
( 'Late Morning', '10:00:00', '11:00:00'),
( 'Early Afternoon', '13:00:00', '14:00:00'),
( 'Late Afternoon', '15:00:00', '16:00:00');

Insert INTO `#__cp_staff` (`firstname`, `lastname`) VALUES 
       ('Slot', 'Staff-1'),
       ('Slot', 'Staff-2'),
       ('Slot', 'Staff-3'),
       ('Slot', 'Staff-4');

Insert INTO `#__cp_slot_alloc` (`slot_id`, `staff_id`) VALUES 
       ( '1','1'),
       ( '2','2'),
       ( '3','3'),
       ( '4','4');

Insert INTO `#__cp_exception` (`exception_date`, `all_off`) VALUES 
       ( '2010-12-25',1),
       ( '2011-12-25',1),
       ( '2012-12-25',1);