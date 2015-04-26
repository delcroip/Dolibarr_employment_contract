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
-- HR Revision 0.1.0

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
motif                 varchar(2048), -- coulb be used for cdd
custom_field_1_value DECIMAL(16,4),
custom_field_2_value DECIMAL(16,4),
PRIMARY KEY (rowid)
) 
ENGINE=innodb;

