bootstrap-week-calendar
=======================

Another Bootstrap 3 Calendar

A Full view calendar based on Twitter Bootstrap. Please try the [demo](http://www.albertobravi.com/demo-bootstrap-calendar/).

![Bootstrap full calendar](http://www.albertobravi.com/demo-bootstrap-calendar/demo.png)

##Quick Start
 - Create a database
 - Edit connection params
 - Setup database


----------


###Create a database:

````sql
CREATE TABLE `booking` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL,
  `title` varchar(255) NOT NULL,
  `abstract` text,
  `status` int(1) NOT NULL COMMENT '0=unavailable, 1=available, 2=extra',
  `started_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `finish_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `created_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `updated_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=1 DEFAULT CHARSET=utf8;
````


###Edit connection Params in this file 
    ./config.php

###For setup database:
#####edit params in this file. It's very important for customize you database. (require php knowledge):
    ./setupDatabase.php

#####invoke via Web
    /setupDatabase.php

###License

[MIT License](LICENSE). © Alberto Bravi (http://twitter.com/albertobravi).
