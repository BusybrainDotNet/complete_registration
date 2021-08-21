CREATE DATABASE IF NOT EXISTS `livechat`;
USE livechat;

-- Table structure for registered users `chat_user` 
CREATE TABLE `users` ( 
`id` INT(11) AUTO_INCREMENT,
`user_id` VARCHAR(150) NOT NULL, 
`email` VARCHAR(150) NOT NULL,
`password` VARCHAR(150) NOT NULL,
`profile` VARCHAR(100) DEFAULT NULL,
`code` varchar(20) NOT NULL,
`user_status` ENUM('Disabled', 'Enabled'),
`login_status` ENUM('Logged_in', 'Logged_out'),
`login_2fa` ENUM('On', 'Off'),
`lastlogin` DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP,
`created` DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP,    
PRIMARY KEY  (`id`)
) ENGINE = InnoDB   DEFAULT CHARSET=latin1 ;



-- Table structure for users detail `profile` 
CREATE TABLE `profile` ( 
`id` INT NOT NULL AUTO_INCREMENT, 
`user_id` varchar(150) NULL DEFAULT NULL,
`fname` varchar(150) NULL DEFAULT NULL,
`lname` varchar(100) NULL DEFAULT NULL,
`phone` varchar(50) NULL DEFAULT NULL,
`dob` varchar(20) NULL DEFAULT NULL,
`nationality` varchar(100) NULL DEFAULT NULL,
`residence` varchar(100) NULL DEFAULT NULL,
`profileimage` varchar(200) NULL DEFAULT NULL, 
`timestamp` DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP, 
PRIMARY KEY (`id`) 
) ENGINE=InnoDB DEFAULT CHARSET=latin1;



-- Table structure for group chat `room` 
CREATE TABLE `room` ( 
`room_id` INT(11) AUTO_INCREMENT,
`user_id` VARCHAR(150) NOT NULL,
`room_name` VARCHAR(500) NOT NULL,
`room_type` ENUM('Private', 'Public'), 
`room_status` ENUM('Disabled', 'Enabled'),
`room_admin` VARCHAR(150) NOT NULL,
`room_moderator` VARCHAR(150) NOT NULL,
`created` DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP,    
PRIMARY KEY  (`room_id`)
) ENGINE = InnoDB   DEFAULT CHARSET=latin1 ;



-- Table structure for user post `post` 
CREATE TABLE `post` ( 
`id` INT(11) AUTO_INCREMENT,
`user_id` VARCHAR(150) NOT NULL,
`post_id` VARCHAR(50) NOT NULL,
`post_img` VARCHAR(500) NOT NULL,
`post_msg` text,
`created` DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP,    
PRIMARY KEY  (`id`)
) ENGINE = InnoDB   DEFAULT CHARSET=latin1 ;




-- Table structure for user chat `user_chat` 
CREATE TABLE `user_chat` ( 
`id` INT(11) AUTO_INCREMENT,
`user_id_from` VARCHAR(150) NOT NULL,
`chat_msg` text,
`user_id_to` VARCHAR(150) NOT NULL,
`created` DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP,    
PRIMARY KEY  (`id`)
) ENGINE = InnoDB   DEFAULT CHARSET=latin1 ;



-- Table structure for Adverts `market` 
CREATE TABLE `market` ( 
`id` INT NOT NULL AUTO_INCREMENT, 
`user_id` varchar(150) NULL DEFAULT NULL,
`msg` varchar(150) NULL DEFAULT NULL,
`coy` varchar(20) NULL DEFAULT NULL,
`nationality` varchar(100) NULL DEFAULT NULL,
`residence` varchar(100) NULL DEFAULT NULL,
`balance` varchar(50) DEFAULT '0.00', 
`status` ENUM('Paid', 'Free'),
`image` varchar(200) NULL DEFAULT NULL, 
`timestamp` DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP, 
PRIMARY KEY (`id`) 
) ENGINE=InnoDB DEFAULT CHARSET=latin1;




-- Table structure for reports `user_report` 
CREATE TABLE `report` ( 
`id` INT(11) AUTO_INCREMENT,
`user_id` VARCHAR(150) NOT NULL,  
`report_id` VARCHAR(150) NOT NULL,
`report_status` ENUM('Spam', 'Abuse', 'Scam'),
`report_msg` text,
`created` DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP,    
PRIMARY KEY  (`id`)
) ENGINE = InnoDB   DEFAULT CHARSET=latin1 ;

