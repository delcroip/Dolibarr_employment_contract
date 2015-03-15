-- basic salary calcul method
INSERT INTO llx_emcontract_salary_method (datec,description,fk_user_author)
VALUE (NOW(), "Basic salary calcul method","1")

-- only step of the salary method operand 18 x operand 0
INSERT INTO llx_emcontract_salary_steps (datec, description,fk_salary_method, step, operand_1_type, 
operand_1_value,operand_2_type,operand_2_value,operator,fk_user_author,toshow)
VALUE (NOW(), "Salaire brut","4","1","0","18","0","0","2","1","1")

-- contract type
INSERT INTO llx_emcontract_type (datec,type_contract,description,weekly_hours,fk_salary_method,fk_user_author)
VALUE (NOW(),"1","CDI simple","35","4","1");

INSERT INTO llx_emcontract_type (datec,type_contract,description,weekly_hours,fk_salary_method,fk_user_author)
VALUE (NOW(),"2","CDD simple","35","4","1");

INSERT INTO llx_emcontract_type (datec,type_contract,description,weekly_hours,fk_salary_method,fk_user_author)
VALUE (NOW(),"1","Adminstateur Entreprise","35","4","1");