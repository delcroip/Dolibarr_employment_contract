-- ===================================================================
-- Copyright (C) 2013  Alexandre Spangaro <alexandre.spangaro@gmail.com>
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
-- Emcontract Revision 0.1.0



CREATE TABLE llx_hr_salary_method
(
rowid                 	integer NOT NULL DEFAULT AUTO_INCREMENT,
entity	              	integer DEFAULT 1 NOT NULL,		-- multi company id
datec                 	DATETIME NOT NULL,
datem		      	TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,              
description           	VARCHAR( 255 ) NOT NULL,
fk_user_author        	integer NOT NULL,
fk_user_modif         	integer,
PRIMARY KEY (rowid),
FOREIGN KEY(fk_user_author)  REFERENCES llx_user(rowid),
FOREIGN KEY (fk_user_modif) REFERENCES llx_user(rowid)
) 
ENGINE=innodb;



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
fk_salary_method	integer,
sm_custom_field_1_value DECIMAL(16,4),
sm_custom_field_2_value DECIMAL(16,4),
PRIMARY KEY (rowid),
FOREIGN KEY (fk_salary_method) REFERENCES llx_hr_salary_method(rowid),
FOREIGN KEY (fk_user_author) REFERENCES llx_user(rowid),
FOREIGN KEY (fk_user_modif) REFERENCES llx_user(rowid)
) 
ENGINE=innodb;


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
PRIMARY KEY (rowid),
FOREIGN KEY (fk_salary_method) REFERENCES llx_hr_salary_method(rowid),
FOREIGN KEY (fk_user_author) REFERENCES llx_user(rowid),
FOREIGN KEY (fk_user_modif) REFERENCES llx_user(rowid)
) 
ENGINE=innodb;

-- calculed operand
-- 16, number of weeks of the month


-- 16, raw number of hours
-- 17, sum of holiday generated during the month
-- 18, sum of hours during the month
-- 19, theoretical monthly salary (4.33*weekly hours*hourlyrate)
-- 20, theoretical monthly salary based on the real month weeks(NbWeeks*weekly hours*hourlyrate)

CREATE TABLE llx_hr_job_type 
(
rowid                 integer NOT NULL AUTO_INCREMENT,
entity                integer DEFAULT 1 NOT NULL,		-- multi company id
datec                 DATETIME NOT NULL,
datem		      TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,                
description           VARCHAR( 255 ),
fk_user_author        integer,
fk_user_modif         integer, 
base_rate             DECIMAL(8,4) NOT NULL, -- operand 0 |
PRIMARY KEY (rowid),
FOREIGN KEY (fk_user_author) REFERENCES llx_user(rowid),
FOREIGN KEY (fk_user_modif) REFERENCES llx_user(rowid)
) 
ENGINE=innodb;

--contract event --> should document the trying periods, the period of 'non concurences'

CREATE TABLE llx_hr_user_skills
(
rowid                 integer NOT NULL AUTO_INCREMENT,
entity                integer DEFAULT 1 NOT NULL,		-- multi company id
datec                 DATETIME NOT NULL,
datem		      TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,                
description           VARCHAR( 255 ),
fk_user_author        integer,
fk_user_modif         integer, 
fk_user               integer,
PRIMARY KEY (rowid),
FOREIGN KEY (fk_user) REFERENCES llx_user(rowid),
FOREIGN KEY (fk_user_author) REFERENCES llx_user(rowid),
FOREIGN KEY (fk_user_modif) REFERENCES llx_user(rowid)
) 
ENGINE=innodb;

CREATE TABLE llx_hr_job_skills
(
rowid                 integer NOT NULL AUTO_INCREMENT,
entity                integer DEFAULT 1 NOT NULL,		-- multi company id
datec                 DATETIME NOT NULL,
datem		      TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,                
description           VARCHAR( 255 ),
fk_user_author        integer,
fk_user_modif         integer, 
fk_job_type               integer,
PRIMARY KEY (rowid),
FOREIGN KEY (fk_job_type) REFERENCES llx_hr_job_type(rowid),
FOREIGN KEY (fk_user_author) REFERENCES llx_user(rowid),
FOREIGN KEY (fk_user_modif) REFERENCES llx_user(rowid)
) 
ENGINE=innodb;


CREATE TABLE llx_hr_contract 
(
rowid                 integer NOT NULL AUTO_INCREMENT,
fk_user               integer NOT NULL,
entity                integer DEFAULT 1 NOT NULL,		-- multi company id
datec                 DATETIME NOT NULL,
datem		      TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,   
fk_contract_type    integer,   
fk_job_type           integer, 
fk_job_Location       integer,             
date_dpae             date NULL,
date_medicalexam      date NULL,
date_sign_employee    date NULL,
date_sign_management  date NULL,
description           VARCHAR( 255 ),
date_start_contract   date NOT NULL,
date_end_contract     date NULL,
fk_user_author        integer,
fk_user_modif         integer, 
base_rate             DECIMAL(8,4) NOT NULL, -- operand 0 |
motif                 varchar(), -- coulb be used for cdd
custom_field_1_value DECIMAL(16,4),
custom_field_2_value DECIMAL(16,4),
-- Health_insurance_number         VARCHAR(64), -- Should it be in llx_user or in llx_emcontract ?
PRIMARY KEY (rowid),
FOREIGN KEY (fk_user) REFERENCES llx_user(rowid),
FOREIGN KEY (fk_contract_type ) REFERENCES llx_hr_contract_type(rowid),
FOREIGN KEY (fk_job_location ) REFERENCES llx_societe_address(rowid),
FOREIGN KEY (fk_user_author) REFERENCES llx_user(rowid),
FOREIGN KEY (fk_user_modif) REFERENCES llx_user(rowid)
) 
ENGINE=innodb;

CREATE TABLE llx_hr_contract_event -- use for try period, year vacancy, to document a contract update ...
(
rowid                 	integer NOT NULL AUTO_INCREMENT,
entity	              	integer DEFAULT 1 NOT NULL,		-- multi company id
datec                 	DATETIME NOT NULL,
datem		      	TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
date_start              DATETIME NOT NULL,
date_stop               DATETIME NOT NULL,
title                   varchar(255) NOT NULL,
description             varchar(2048),
PRIMARY KEY (rowid),
FOREIGN KEY (fk_contract) REFERENCES llx_hr_contract(rowid)
) 
ENGINE=innodb;


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
PRIMARY KEY (rowid),
FOREIGN KEY (fk_country) REFERENCES llx_c_pays(rowid),
FOREIGN KEY (fk_user_author) REFERENCES llx_user(rowid),
FOREIGN KEY (fk_user_modif) REFERENCES llx_user(rowid)
)
ENGINE=innodb;

CREATE TABLE llx_hr_contract_event
(
rowid                 integer NOT NULL AUTO_INCREMENT,
entity                integer DEFAULT 1 ,		-- multi company id
datec                 DATETIME NOT NULL,
datem		      TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,                
description           VARCHAR( 255 ),
fk_user_author        integer,
fk_user_modif         integer, 
day_date              DATE not NULL,
-- FIXME
PRIMARY KEY (rowid),
FOREIGN KEY (fk_country) REFERENCES llx_c_pays(rowid),
FOREIGN KEY (fk_user_author) REFERENCES llx_user(rowid),
FOREIGN KEY (fk_user_modif) REFERENCES llx_user(rowid)
)
ENGINE=innodb;