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



CREATE TABLE llx_hr_contract_event -- use for try period, year vacancy, to document a contract update ...
(
rowid                 	integer NOT NULL AUTO_INCREMENT,
date_creation                 	DATETIME NOT NULL,
date_modification		      	TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
fk_user_creation        integer,
fk_user_modification         integer, 
date_start              DATETIME NOT NULL,
date_stop               DATETIME NOT NULL,
title                   varchar(255) NOT NULL,
description             varchar(2047),
PRIMARY KEY (rowid)
) 
ENGINE=innodb;
