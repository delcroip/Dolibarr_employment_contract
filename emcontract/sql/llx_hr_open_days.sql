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



CREATE TABLE llx_hr_open_days
(
rowid                 integer NOT NULL AUTO_INCREMENT,
entity                integer DEFAULT 1 ,		-- multi company id
datec                 DATETIME NOT NULL,
datem		      TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,                
description           VARCHAR( 255 ),
fk_user_author        integer,
fk_user_modif         integer, 
day_status            integer NOT NULL,  -- 0 open, 1 weekend, 2 national holiday, 3 other
day_date              DATE not NULL,
fk_country            integer DEFAULT NULL, -- null if the country doesn't matter
PRIMARY KEY (rowid)
)
ENGINE=innodb;

