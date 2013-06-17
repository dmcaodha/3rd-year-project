-- This table below is for all users on the website application --
DROP TABLE IF EXISTS `site_users`;
CREATE TABLE  `site_users` (
  `id` int NOT NULL AUTO_INCREMENT,
  `firstName` varchar(25) NOT NULL,
  `lastName` varchar(25) NOT NULL,
  `email` varchar(255) NOT NULL,
  `userName` varchar(16) NOT NULL,
  `accountType` enum('web_user','admin_user') NOT NULL,
  `password` varchar(32) NOT NULL,
  UNIQUE (userName),
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

-- This table below is for all mobile user accounts on the website application --
DROP TABLE IF EXISTS `mobile_users` ;
CREATE TABLE `mobile_users` (
`id` int NOT NULL AUTO_INCREMENT ,
`userName` varchar( 16 ) NOT NULL ,
`password` varchar( 32 ) NOT NULL ,
 UNIQUE (userName),
`manager_id` INT NOT NULL ,
PRIMARY KEY ( `id` ) ,
FOREIGN KEY ( `manager_id` ) REFERENCES site_users( `id` )
) ENGINE = MYISAM DEFAULT CHARSET = latin1;

-- This table is for individual survey assignments --
DROP TABLE IF EXISTS `assignments`;
CREATE TABLE  `assignments` (
  `id` int NOT NULL AUTO_INCREMENT,
  `dateAssigned` date NOT NULL,
  `managerNotes` text NOT NULL,
  `surveyId` int NOT NULL,
  PRIMARY KEY (`id`),
  FOREIGN KEY (`surveyId`) REFERENCES surveys(`id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

-- This table is for assignments in relation to mobile users--
DROP TABLE IF EXISTS `user_assignments`;
CREATE TABLE  `user_assignments` (
  `id` int NOT NULL AUTO_INCREMENT,
  `mobId` int NOT NULL,
  `assignId` int NOT NULL,
  PRIMARY KEY (`id`),
  FOREIGN KEY (`mobId`) REFERENCES mobile_users(`id`),
  FOREIGN KEY (`assignId`) REFERENCES surveys(`assignId`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

-- This table is for all surveys --
DROP TABLE IF EXISTS `surveys`;
CREATE TABLE  `surveys` (
  `id` int NOT NULL AUTO_INCREMENT,
  `title` varchar(120) NOT NULL,
  `topic` varchar(120) NOT NULL,
  `dateCreated` date NOT NULL,
  `userId` int NOT NULL,
  PRIMARY KEY (`id`),
  FOREIGN KEY (`userId`) REFERENCES site_users(`id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

-- This table is for all questions belonging to a survey --
DROP TABLE IF EXISTS `questions`;
CREATE TABLE  `questions` (
  `id` int NOT NULL AUTO_INCREMENT,
  `question` text NOT NULL,
  `type` varchar(60) NOT NULL,
  `position` int(3) NOT NULL,
  `surveyId` int NOT NULL,
  PRIMARY KEY (`id`),
  FOREIGN KEY (`surveyId`) REFERENCES surveys(`id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

-- This table is for all questions belonging to a survey --
DROP TABLE IF EXISTS `poss_answers`;
CREATE TABLE  `poss_answers` (
  `id` int NOT NULL AUTO_INCREMENT,
  `choice1` text NOT NULL,
  `choice2` text NOT NULL,
  `choice3` text NOT NULL,
  `choice4` text NULL,
  `choice5` text NULL,
  `questionId` int NOT NULL,
  PRIMARY KEY (`id`),
  FOREIGN KEY (`questionId`) REFERENCES questions(`id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

-- This table is for the responses to questions --
DROP TABLE IF EXISTS `actual_answers`;
CREATE TABLE  `actual_answers` (
  `id` int NOT NULL AUTO_INCREMENT,
  `answerText` text NOT NULL,
  `responseId` int NOT NULL,
  `questionId` int NOT NULL,
  PRIMARY KEY (`id`),
  FOREIGN KEY (`responseId`) REFERENCES responses(`id`),
  FOREIGN KEY (`questionId`) REFERENCES questions(`id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

-- This table is for responses from surveys --
DROP TABLE IF EXISTS `responses`;
CREATE TABLE  `responses` (
  `id` int NOT NULL AUTO_INCREMENT,
  `mobId` int NOT NULL,
  `surveyId` int NOT NULL,
  `timestamp` TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  FOREIGN KEY (`mobId`) REFERENCES mobile_users(`id`),
  FOREIGN KEY (`surveyId`) REFERENCES surveys(`id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;