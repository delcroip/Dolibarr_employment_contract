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


CREATE TABLE llx_hr_salary_steps
(
rowid                   integer NOT NULL AUTO_INCREMENT,
entity	                integer DEFAULT 1 NOT NULL,		-- multi company id
datec                   DATETIME NOT NULL,
datem		        TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,                
fk_user_author          integer NOT NULL,
fk_user_modif           integer ,
description             VARCHAR( 255 ) NOT NULL,
fk_salary_method        integer NOT NULL,
step		        integer NOT NULL,
operand_1_type	        ENUM ('value','step','operand','salary_method') default 'value' NOT NULL, -- 0- value from emcontract operand, 1- output of another step, 2- value
operand_1_value	        DECIMAL(16,4), -- depending of the type, could be the number of the emcontract operand or a step or a pure value
operand_2_type	        ENUM ('value','step','operand','salary_method') default 'value' NOT NULL, -- 0- value from emcontract operand, 1- output of another step, 2- value
operand_2_value	        DECIMAL(16,4), -- depending of the type, could be the number of the emcontract operand or a step or a pure value
operator                ENUM ('plus','minus','mult','div','mod','slice','if','sup','inf','not','or','and','xor') NOT NULL, -- 0- value from emcontract operand, 1- output of another step, 2- value
operand_3_type	        ENUM ('value','step','operand','salary_method') default 'value' NOT NULL, -- 0- value from emcontract operand, 1- output of another step, 2- value
operand_3_value	        DECIMAL(16,4), -- depending of the type, could be the number of the emcontract operand or a step or a pure value
accounting_account      integer,
ct_custom_fields_1_desc varchar(255), -- contract type custom field  1 desc
ct_custom_fields_2_desc varchar(255),-- contract type custom field  2 desc
c_custom_fields_1_desc  varchar(255),-- contract custom field  1 desc
c_custom_fields_2_desc  varchar(255),-- contract custom field  2 desc
toshow		        BOOLEAN NOT NULL,
PRIMARY KEY (rowid)
) 
ENGINE=innodb;

