-- basic salary calcul method
INSERT INTO llx_hr_salary_method (date_creation, title, description,fk_user_creation)
VALUE (NOW(), "Basic salary calcul method", "Basic salary calcul method","1")

-- only step of the salary method operand 18 x operand 0
INSERT INTO llx_hr_salary_steps (date_creation, description,fk_salary_method, step, operand_1_type, 
operand_1_value,operand_2_type,operand_2_value,operator,fk_user_creation,toshow)
VALUE (NOW(), "Salaire brut","1","1","0","18","0","0","2","1","1")

-- contract type
INSERT INTO llx_hr_contract_type (date_creation,type_contract,title,description,weekly_hours,fk_salary_method,fk_user_creation)
VALUE (NOW(),"1","CDI simple","CDI simple","35","1","1");

INSERT INTO llx_hr_contract_type (date_creation,type_contract,title, description,weekly_hours,fk_salary_method,fk_user_creation)
VALUE (NOW(),"2","CDD simple","CDD simple","35","1","1");

INSERT INTO llx_hr_contract_type (date_creation,type_contract,title,description,weekly_hours,fk_salary_method,fk_user_creation)
VALUE (NOW(),"1","Adminstateur Entreprise","Adminstateur Entreprise","35","1","1");