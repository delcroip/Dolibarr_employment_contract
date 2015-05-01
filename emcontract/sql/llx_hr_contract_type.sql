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



CREATE TABLE llx_hr_contract_type 
(
rowid                 	integer NOT NULL AUTO_INCREMENT,
entity	              	integer DEFAULT 1 NOT NULL,		-- multi company id
datec                 	DATETIME NOT NULL,
datem		      	TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
type_contract         	integer NOT NULL,      -- 0- admin, 1- CDI, 2- CDD, 3- apprentissage , 4- stage ,,          
description           	VARCHAR( 255 ) NOT NULL,
employee_status         integer, -- cadre, assimilé cadre, non cadre, cadre dirigeant
fk_user_author        	integer ,
fk_user_modif         	integer ,
weekly_hours	      	DECIMAL(5,3) NOT NULL, -- operand 1 |
modulation_period      	integer DEFAULT 0, -- operand 2 | 0 - one week, 1- one month, 2- two month ...
working_days           	integer DEFAULT 31, -- operand 3 | (2^0)=1- monday, (2^1)=2- tuesday, (2^2)=4- Wednesday ... ex M+T+W+T+F=1+2+4+8+16=31, 
normal_rate_days     	integer DEFAULT 31, -- operand 4 |  all other worink day are regarded as days with an overrate
daily_hours	      	DECIMAL(5,3) DEFAULT 8, -- operand 5 | informative, could be used for the timesheet
night_hours_start   	TIME DEFAULT "21:00:00",-- operand 6 |
night_rate	      	DECIMAL(4,3) default 1.5,	-- operand 7 |
night_hours_stop	TIME DEFAULT "06:00:00",-- operand 8 |
holiday_weekly_generated DECIMAL(4,3) DEFAULT 0.5, -- operand 9 |
overtime_rate           DECIMAL(4,3) DEFAULT 1.25, -- operand 10 |
overtime_recup_only     BOOLEAN DEFAULT true, --operand 11 |
weekly_max_hours        DECIMAL(5,3) DEFAULT 48, -- operand 12 | for modulation calculation
weekly_min_hours        DECIMAL(5,3) DEFAULT 16, -- operand 13 | for modulation calculation
daily_max_hours         DECIMAL(5,3) Default 12, -- operand 14 | for timesheet 
fk_salary_method	integer, -- foreigner key to document which salary mehode should be used
sm_custom_field_1_value DECIMAL(16,4), -- value a a custom fields 1, the description depends on the salary methods
sm_custom_field_2_value DECIMAL(16,4), -- value a a custom fields 1, the description depends on the salary methods
PRIMARY KEY (rowid)
) 
ENGINE=innodb;

-- calculed operand
-- 16, number of weeks of the month


-- 16, raw number of hours
-- 17, sum of holiday generated during the month
-- 18, sum of hours during the month
-- 19, theoretical monthly salary (4.33*weekly hours*hourlyrate)
-- 20, theoretical monthly salary based on the real month weeks(NbWeeks*weekly hours*hourlyrate)
