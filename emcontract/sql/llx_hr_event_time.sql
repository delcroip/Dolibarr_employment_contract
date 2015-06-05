-- ===================================================================
-- Copyright (C) 2015  Patrick Delcroix <pmpdelcroix@gmail.com>
--
-- This program is free software; you can redistribute it and/or modify
-- it under the terms of the GNU General Public License as published by
-- the Free Software Foundation; either version 3 of the License, or
-- (at your option) any later version.
--
-- This program is distributed in the hope that it will be useful,
-- but WITHOUT ANY WARRANTY; without even the implied warranty of
-- MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
-- GNU General Public License for more details.
--
-- You should have received a copy of the GNU General Public License
-- along with this program. If not, see <http://www.gnu.org/licenses/>.
--
-- ===================================================================
-- HR Revision 0.1.0



CREATE TABLE llx_hr_event_time --table to document the holiday, company holiday, sick leave ...
(
rowid                 integer NOT NULL AUTO_INCREMENT,
audience              ENUM('GLOBAL', 'ENTITY', 'GROUP','USER') DEFAULT 'USER' NOT NULL ,		-- multi company id
fk_audience_item           integer DEFAULT NULL, -- link to the user / group if applicable
date_creation                 DATETIME NOT NULL,
date_modification		      TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,                
event_type            ENUM('WORK','HOLIDAY','SICK_LEAVE','UNPAID_HOLIDAY','NATIONAL_HOLIDAY','TRAINING','UNION'),
description           VARCHAR( 255 ),
fk_user_creation      integer,
fk_user_modification  integer, 
status                ENUM('SAVED','SUBMITTED','ACCEPTED','REJECTED'), 
day_date              DATE not NULL,
duration              TIME DEFAULT "8:00:00",
fk_country            integer DEFAULT NULL, -- null if the country doesn't matter
PRIMARY KEY (rowid)
)
ENGINE=innodb;

