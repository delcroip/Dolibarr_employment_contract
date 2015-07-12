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

-- custom fields defs 
CREATE TABLE llx_hr_salary_cf_defs
(
rowid                   integer NOT NULL AUTO_INCREMENT,
`ref`                   VARCHAR(63),
entity	                integer DEFAULT 1 NOT NULL,		-- multi company id
date_creation           DATETIME NOT NULL,
date_modification	TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,                
fk_user_creation        integer NOT NULL,
fk_user_modification    integer ,
description             VARCHAR( 255 ) NOT NULL, -- desc to show on the pages
fk_salary_method        VARCHAR(63), -- ref to the salary method ref (id not used to be able to expor sm)
linked_to	        ENUM ('salary_method','contract','salary_calc') default 'salary_calc' NOT NULL, -- 0- value from emcontract operand, 1- output of another step, 2- value
default_value	        DECIMAL(16,4), -- 
PRIMARY KEY (rowid)
) 
ENGINE=innodb;


