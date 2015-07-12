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

-- custom fields value
CREATE TABLE llx_hr_salary_cf_value
(
rowid                   integer NOT NULL AUTO_INCREMENT,
entity	                integer DEFAULT 1 NOT NULL,		-- multi company id
date_creation           DATETIME NOT NULL,
date_modification	TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,                
fk_user_creation        integer NOT NULL,
fk_salary_cf_defs       VARCHAR(63), -- ref to the salary custom fields ref (id not used to be able to expor sm)
apply_to	        VARCHAR(63), -- ref, depend of linked to: 'salary_method','contract'
cf_value	        DECIMAL(16,4), -- 
PRIMARY KEY (rowid)
) 
ENGINE=innodb;
