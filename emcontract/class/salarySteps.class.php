<?php
/* Copyright (C) 2007-2012 Laurent Destailleur  <eldy@users.sourceforge.net>
 * Copyright (C) 2014	   Juanjo Menent		<jmenent@2byte.es>
 * Copyright (C) ---Put here your own copyright and developer email---
 *
 * This program is free software; you can redistribute it and/or modify
 * it under the terms of the GNU General Public License as published by
 * the Free Software Foundation; either version 3 of the License, or
 * (at your option) any later version.
 *
 * This program is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 * GNU General Public License for more details.
 *
 * You should have received a copy of the GNU General Public License
 * along with this program. If not, see <http://www.gnu.org/licenses/>.
 */

/**
 *  \file       dev/skeletons/hrsalarysteps.class.php
 *  \ingroup    mymodule othermodule1 othermodule2
 *  \brief      This file is an example for a CRUD class file (Create/Read/Update/Delete)
 *				Initialy built by build_class_from_table on 2015-05-01 16:19
 */

// Put here all includes required by your class file
require_once(DOL_DOCUMENT_ROOT."/core/class/commonobject.class.php");
//require_once(DOL_DOCUMENT_ROOT."/societe/class/societe.class.php");
//require_once(DOL_DOCUMENT_ROOT."/product/class/product.class.php");


/**
 *	Put here description of your class
 */
class Hrsalarysteps extends CommonObject
{
	var $db;							//!< To store db handler
	var $error;							//!< To return error code (or message)
	var $errors=array();				//!< To return several error codes (or messages)
	var $element='hrsalarysteps';			//!< Id that identify managed objects
	var $table_element='hrsalarysteps';		//!< Name of table without prefix where object is stored

    var $id;
    
	var $entity;
	var $datec='';
	var $datem='';
	var $fk_user_author;
	var $fk_user_modif;
	var $description;
	var $fk_salary_method;
	var $step;
	var $operand_1_type;
	var $operand_1_value;
	var $operand_2_type;
	var $operand_2_value;
	var $operator;
	var $operand_3_type;
	var $operand_3_value;
	var $accounting_account;
	var $ct_custom_fields_1_desc;
	var $ct_custom_fields_2_desc;
	var $c_custom_fields_1_desc;
	var $c_custom_fields_2_desc;
	var $toshow;

    


    /**
     *  Constructor
     *
     *  @param	DoliDb		$db      Database handler
     */
    function __construct($db)
    {
        $this->db = $db;
        return 1;
    }


    /**
     *  Create object into database
     *
     *  @param	User	$user        User that creates
     *  @param  int		$notrigger   0=launch triggers after, 1=disable triggers
     *  @return int      		   	 <0 if KO, Id of created object if OK
     */
    function create($user, $notrigger=0)
    {
    	global $conf, $langs;
		$error=0;

		// Clean parameters
        
		if (isset($this->entity)) $this->entity=trim($this->entity);
		if (isset($this->fk_user_author)) $this->fk_user_author=trim($this->fk_user_author);
		if (isset($this->fk_user_modif)) $this->fk_user_modif=trim($this->fk_user_modif);
		if (isset($this->description)) $this->description=trim($this->description);
		if (isset($this->fk_salary_method)) $this->fk_salary_method=trim($this->fk_salary_method);
		if (isset($this->step)) $this->step=trim($this->step);
		if (isset($this->operand_1_type)) $this->operand_1_type=trim($this->operand_1_type);
		if (isset($this->operand_1_value)) $this->operand_1_value=trim($this->operand_1_value);
		if (isset($this->operand_2_type)) $this->operand_2_type=trim($this->operand_2_type);
		if (isset($this->operand_2_value)) $this->operand_2_value=trim($this->operand_2_value);
		if (isset($this->operator)) $this->operator=trim($this->operator);
		if (isset($this->operand_3_type)) $this->operand_3_type=trim($this->operand_3_type);
		if (isset($this->operand_3_value)) $this->operand_3_value=trim($this->operand_3_value);
		if (isset($this->accounting_account)) $this->accounting_account=trim($this->accounting_account);
		if (isset($this->ct_custom_fields_1_desc)) $this->ct_custom_fields_1_desc=trim($this->ct_custom_fields_1_desc);
		if (isset($this->ct_custom_fields_2_desc)) $this->ct_custom_fields_2_desc=trim($this->ct_custom_fields_2_desc);
		if (isset($this->c_custom_fields_1_desc)) $this->c_custom_fields_1_desc=trim($this->c_custom_fields_1_desc);
		if (isset($this->c_custom_fields_2_desc)) $this->c_custom_fields_2_desc=trim($this->c_custom_fields_2_desc);
		if (isset($this->toshow)) $this->toshow=trim($this->toshow);

        

		// Check parameters
		// Put here code to add control on parameters values

        // Insert request
		$sql = "INSERT INTO ".MAIN_DB_PREFIX.$this->table_element."(";
		
		$sql.= "entity,";
		$sql.= "datec,";
		$sql.= "datem,";
		$sql.= "fk_user_author,";
		$sql.= "fk_user_modif,";
		$sql.= "description,";
		$sql.= "fk_salary_method,";
		$sql.= "step,";
		$sql.= "operand_1_type,";
		$sql.= "operand_1_value,";
		$sql.= "operand_2_type,";
		$sql.= "operand_2_value,";
		$sql.= "operator,";
		$sql.= "operand_3_type,";
		$sql.= "operand_3_value,";
		$sql.= "accounting_account,";
		$sql.= "ct_custom_fields_1_desc,";
		$sql.= "ct_custom_fields_2_desc,";
		$sql.= "c_custom_fields_1_desc,";
		$sql.= "c_custom_fields_2_desc,";
		$sql.= "toshow";

		
        $sql.= ") VALUES (";
        
		$sql.= " ".(! isset($this->entity)?'NULL':"'".$this->entity."'").",";
		$sql.= " ".(! isset($this->datec) || dol_strlen($this->datec)==0?'NULL':"'".$this->db->idate($this->datec)."'").",";
		$sql.= " ".(! isset($this->datem) || dol_strlen($this->datem)==0?'NULL':"'".$this->db->idate($this->datem)."'").",";
		$sql.= " ".(! isset($this->fk_user_author)?'NULL':"'".$this->fk_user_author."'").",";
		$sql.= " ".(! isset($this->fk_user_modif)?'NULL':"'".$this->fk_user_modif."'").",";
		$sql.= " ".(! isset($this->description)?'NULL':"'".$this->db->escape($this->description)."'").",";
		$sql.= " ".(! isset($this->fk_salary_method)?'NULL':"'".$this->fk_salary_method."'").",";
		$sql.= " ".(! isset($this->step)?'NULL':"'".$this->step."'").",";
		$sql.= " ".(! isset($this->operand_1_type)?'NULL':"'".$this->operand_1_type."'").",";
		$sql.= " ".(! isset($this->operand_1_value)?'NULL':"'".$this->operand_1_value."'").",";
		$sql.= " ".(! isset($this->operand_2_type)?'NULL':"'".$this->operand_2_type."'").",";
		$sql.= " ".(! isset($this->operand_2_value)?'NULL':"'".$this->operand_2_value."'").",";
		$sql.= " ".(! isset($this->operator)?'NULL':"'".$this->operator."'").",";
		$sql.= " ".(! isset($this->operand_3_type)?'NULL':"'".$this->operand_3_type."'").",";
		$sql.= " ".(! isset($this->operand_3_value)?'NULL':"'".$this->operand_3_value."'").",";
		$sql.= " ".(! isset($this->accounting_account)?'NULL':"'".$this->accounting_account."'").",";
		$sql.= " ".(! isset($this->ct_custom_fields_1_desc)?'NULL':"'".$this->db->escape($this->ct_custom_fields_1_desc)."'").",";
		$sql.= " ".(! isset($this->ct_custom_fields_2_desc)?'NULL':"'".$this->db->escape($this->ct_custom_fields_2_desc)."'").",";
		$sql.= " ".(! isset($this->c_custom_fields_1_desc)?'NULL':"'".$this->db->escape($this->c_custom_fields_1_desc)."'").",";
		$sql.= " ".(! isset($this->c_custom_fields_2_desc)?'NULL':"'".$this->db->escape($this->c_custom_fields_2_desc)."'").",";
		$sql.= " ".(! isset($this->toshow)?'NULL':"'".$this->toshow."'")."";

        
		$sql.= ")";

		$this->db->begin();

	   	dol_syslog(__METHOD__, LOG_DEBUG);
        $resql=$this->db->query($sql);
    	if (! $resql) { $error++; $this->errors[]="Error ".$this->db->lasterror(); }

		if (! $error)
        {
            $this->id = $this->db->last_insert_id(MAIN_DB_PREFIX.$this->table_element);

			if (! $notrigger)
			{
	            // Uncomment this and change MYOBJECT to your own tag if you
	            // want this action calls a trigger.

	            //// Call triggers
	            //$result=$this->call_trigger('MYOBJECT_CREATE',$user);
	            //if ($result < 0) { $error++; //Do also what you must do to rollback action if trigger fail}
	            //// End call triggers
			}
        }

        // Commit or rollback
        if ($error)
		{
			foreach($this->errors as $errmsg)
			{
	            dol_syslog(__METHOD__." ".$errmsg, LOG_ERR);
	            $this->error.=($this->error?', '.$errmsg:$errmsg);
			}
			$this->db->rollback();
			return -1*$error;
		}
		else
		{
			$this->db->commit();
            return $this->id;
		}
    }


    /**
     *  Load object in memory from the database
     *
     *  @param	int		$id    	Id object
     *  @param	string	$ref	Ref
     *  @return int          	<0 if KO, >0 if OK
     */
    function fetch($id,$ref='')
    {
    	global $langs;
        $sql = "SELECT";
		$sql.= " t.rowid,";
		
		$sql.= " t.entity,";
		$sql.= " t.datec,";
		$sql.= " t.datem,";
		$sql.= " t.fk_user_author,";
		$sql.= " t.fk_user_modif,";
		$sql.= " t.description,";
		$sql.= " t.fk_salary_method,";
		$sql.= " t.step,";
		$sql.= " t.operand_1_type,";
		$sql.= " t.operand_1_value,";
		$sql.= " t.operand_2_type,";
		$sql.= " t.operand_2_value,";
		$sql.= " t.operator,";
		$sql.= " t.operand_3_type,";
		$sql.= " t.operand_3_value,";
		$sql.= " t.accounting_account,";
		$sql.= " t.ct_custom_fields_1_desc,";
		$sql.= " t.ct_custom_fields_2_desc,";
		$sql.= " t.c_custom_fields_1_desc,";
		$sql.= " t.c_custom_fields_2_desc,";
		$sql.= " t.toshow";

		
        $sql.= " FROM ".MAIN_DB_PREFIX.$this->table_element." as t";
        if ($ref) $sql.= " WHERE t.ref = '".$ref."'";
        else $sql.= " WHERE t.rowid = ".$id;

    	dol_syslog(get_class($this)."::fetch");
        $resql=$this->db->query($sql);
        if ($resql)
        {
            if ($this->db->num_rows($resql))
            {
                $obj = $this->db->fetch_object($resql);

                $this->id    = $obj->rowid;
                
				$this->entity = $obj->entity;
				$this->datec = $this->db->jdate($obj->datec);
				$this->datem = $this->db->jdate($obj->datem);
				$this->fk_user_author = $obj->fk_user_author;
				$this->fk_user_modif = $obj->fk_user_modif;
				$this->description = $obj->description;
				$this->fk_salary_method = $obj->fk_salary_method;
				$this->step = $obj->step;
				$this->operand_1_type = $obj->operand_1_type;
				$this->operand_1_value = $obj->operand_1_value;
				$this->operand_2_type = $obj->operand_2_type;
				$this->operand_2_value = $obj->operand_2_value;
				$this->operator = $obj->operator;
				$this->operand_3_type = $obj->operand_3_type;
				$this->operand_3_value = $obj->operand_3_value;
				$this->accounting_account = $obj->accounting_account;
				$this->ct_custom_fields_1_desc = $obj->ct_custom_fields_1_desc;
				$this->ct_custom_fields_2_desc = $obj->ct_custom_fields_2_desc;
				$this->c_custom_fields_1_desc = $obj->c_custom_fields_1_desc;
				$this->c_custom_fields_2_desc = $obj->c_custom_fields_2_desc;
				$this->toshow = $obj->toshow;

                
            }
            $this->db->free($resql);

            return 1;
        }
        else
        {
      	    $this->error="Error ".$this->db->lasterror();
            return -1;
        }
    }


    /**
     *  Update object into database
     *
     *  @param	User	$user        User that modifies
     *  @param  int		$notrigger	 0=launch triggers after, 1=disable triggers
     *  @return int     		   	 <0 if KO, >0 if OK
     */
    function update($user, $notrigger=0)
    {
    	global $conf, $langs;
		$error=0;

		// Clean parameters
        
		if (isset($this->entity)) $this->entity=trim($this->entity);
		if (isset($this->fk_user_author)) $this->fk_user_author=trim($this->fk_user_author);
		if (isset($this->fk_user_modif)) $this->fk_user_modif=trim($this->fk_user_modif);
		if (isset($this->description)) $this->description=trim($this->description);
		if (isset($this->fk_salary_method)) $this->fk_salary_method=trim($this->fk_salary_method);
		if (isset($this->step)) $this->step=trim($this->step);
		if (isset($this->operand_1_type)) $this->operand_1_type=trim($this->operand_1_type);
		if (isset($this->operand_1_value)) $this->operand_1_value=trim($this->operand_1_value);
		if (isset($this->operand_2_type)) $this->operand_2_type=trim($this->operand_2_type);
		if (isset($this->operand_2_value)) $this->operand_2_value=trim($this->operand_2_value);
		if (isset($this->operator)) $this->operator=trim($this->operator);
		if (isset($this->operand_3_type)) $this->operand_3_type=trim($this->operand_3_type);
		if (isset($this->operand_3_value)) $this->operand_3_value=trim($this->operand_3_value);
		if (isset($this->accounting_account)) $this->accounting_account=trim($this->accounting_account);
		if (isset($this->ct_custom_fields_1_desc)) $this->ct_custom_fields_1_desc=trim($this->ct_custom_fields_1_desc);
		if (isset($this->ct_custom_fields_2_desc)) $this->ct_custom_fields_2_desc=trim($this->ct_custom_fields_2_desc);
		if (isset($this->c_custom_fields_1_desc)) $this->c_custom_fields_1_desc=trim($this->c_custom_fields_1_desc);
		if (isset($this->c_custom_fields_2_desc)) $this->c_custom_fields_2_desc=trim($this->c_custom_fields_2_desc);
		if (isset($this->toshow)) $this->toshow=trim($this->toshow);

        

		// Check parameters
		// Put here code to add a control on parameters values

        // Update request
        $sql = "UPDATE ".MAIN_DB_PREFIX.$this->table_element." SET";
        
		$sql.= " entity=".(isset($this->entity)?$this->entity:"null").",";
		$sql.= " datec=".(dol_strlen($this->datec)!=0 ? "'".$this->db->idate($this->datec)."'" : 'null').",";
		$sql.= " datem=".(dol_strlen($this->datem)!=0 ? "'".$this->db->idate($this->datem)."'" : 'null').",";
		$sql.= " fk_user_author=".(isset($this->fk_user_author)?$this->fk_user_author:"null").",";
		$sql.= " fk_user_modif=".(isset($this->fk_user_modif)?$this->fk_user_modif:"null").",";
		$sql.= " description=".(isset($this->description)?"'".$this->db->escape($this->description)."'":"null").",";
		$sql.= " fk_salary_method=".(isset($this->fk_salary_method)?$this->fk_salary_method:"null").",";
		$sql.= " step=".(isset($this->step)?$this->step:"null").",";
		$sql.= " operand_1_type=".(isset($this->operand_1_type)?$this->operand_1_type:"null").",";
		$sql.= " operand_1_value=".(isset($this->operand_1_value)?$this->operand_1_value:"null").",";
		$sql.= " operand_2_type=".(isset($this->operand_2_type)?$this->operand_2_type:"null").",";
		$sql.= " operand_2_value=".(isset($this->operand_2_value)?$this->operand_2_value:"null").",";
		$sql.= " operator=".(isset($this->operator)?$this->operator:"null").",";
		$sql.= " operand_3_type=".(isset($this->operand_3_type)?$this->operand_3_type:"null").",";
		$sql.= " operand_3_value=".(isset($this->operand_3_value)?$this->operand_3_value:"null").",";
		$sql.= " accounting_account=".(isset($this->accounting_account)?$this->accounting_account:"null").",";
		$sql.= " ct_custom_fields_1_desc=".(isset($this->ct_custom_fields_1_desc)?"'".$this->db->escape($this->ct_custom_fields_1_desc)."'":"null").",";
		$sql.= " ct_custom_fields_2_desc=".(isset($this->ct_custom_fields_2_desc)?"'".$this->db->escape($this->ct_custom_fields_2_desc)."'":"null").",";
		$sql.= " c_custom_fields_1_desc=".(isset($this->c_custom_fields_1_desc)?"'".$this->db->escape($this->c_custom_fields_1_desc)."'":"null").",";
		$sql.= " c_custom_fields_2_desc=".(isset($this->c_custom_fields_2_desc)?"'".$this->db->escape($this->c_custom_fields_2_desc)."'":"null").",";
		$sql.= " toshow=".(isset($this->toshow)?$this->toshow:"null")."";

        
        $sql.= " WHERE rowid=".$this->id;

		$this->db->begin();

		dol_syslog(__METHOD__);
        $resql = $this->db->query($sql);
    	if (! $resql) { $error++; $this->errors[]="Error ".$this->db->lasterror(); }

		if (! $error)
		{
			if (! $notrigger)
			{
	            // Uncomment this and change MYOBJECT to your own tag if you
	            // want this action calls a trigger.

	            //// Call triggers
	            //$result=$this->call_trigger('MYOBJECT_MODIFY',$user);
	            //if ($result < 0) { $error++; //Do also what you must do to rollback action if trigger fail}
	            //// End call triggers
			 }
		}

        // Commit or rollback
		if ($error)
		{
			foreach($this->errors as $errmsg)
			{
	            dol_syslog(__METHOD__." ".$errmsg, LOG_ERR);
	            $this->error.=($this->error?', '.$errmsg:$errmsg);
			}
			$this->db->rollback();
			return -1*$error;
		}
		else
		{
			$this->db->commit();
			return 1;
		}
    }


 	/**
	 *  Delete object in database
	 *
     *	@param  User	$user        User that deletes
     *  @param  int		$notrigger	 0=launch triggers after, 1=disable triggers
	 *  @return	int					 <0 if KO, >0 if OK
	 */
	function delete($user, $notrigger=0)
	{
		global $conf, $langs;
		$error=0;

		$this->db->begin();

		if (! $error)
		{
			if (! $notrigger)
			{
				// Uncomment this and change MYOBJECT to your own tag if you
		        // want this action calls a trigger.

	            //// Call triggers
	            //$result=$this->call_trigger('MYOBJECT_DELETE',$user);
	            //if ($result < 0) { $error++; //Do also what you must do to rollback action if trigger fail}
	            //// End call triggers
			}
		}

		if (! $error)
		{
    		$sql = "DELETE FROM ".MAIN_DB_PREFIX.$this->table_element;
    		$sql.= " WHERE rowid=".$this->id;

    		dol_syslog(__METHOD__);
    		$resql = $this->db->query($sql);
        	if (! $resql) { $error++; $this->errors[]="Error ".$this->db->lasterror(); }
		}

        // Commit or rollback
		if ($error)
		{
			foreach($this->errors as $errmsg)
			{
	            dol_syslog(__METHOD__." ".$errmsg, LOG_ERR);
	            $this->error.=($this->error?', '.$errmsg:$errmsg);
			}
			$this->db->rollback();
			return -1*$error;
		}
		else
		{
			$this->db->commit();
			return 1;
		}
	}



	/**
	 *	Load an object from its id and create a new one in database
	 *
	 *	@param	int		$fromid     Id of object to clone
	 * 	@return	int					New id of clone
	 */
	function createFromClone($fromid)
	{
		global $user,$langs;

		$error=0;

		$object=new Hrsalarysteps($this->db);

		$this->db->begin();

		// Load source object
		$object->fetch($fromid);
		$object->id=0;
		$object->statut=0;

		// Clear fields
		// ...

		// Create clone
		$result=$object->create($user);

		// Other options
		if ($result < 0)
		{
			$this->error=$object->error;
			$error++;
		}

		if (! $error)
		{


		}

		// End
		if (! $error)
		{
			$this->db->commit();
			return $object->id;
		}
		else
		{
			$this->db->rollback();
			return -1;
		}
	}


	/**
	 *	Initialise object with example values
	 *	Id must be 0 if object instance is a specimen
	 *
	 *	@return	void
	 */
	function initAsSpecimen()
	{
		$this->id=0;
		
		$this->entity='';
		$this->datec='';
		$this->datem='';
		$this->fk_user_author='';
		$this->fk_user_modif='';
		$this->description='';
		$this->fk_salary_method='';
		$this->step='';
		$this->operand_1_type='';
		$this->operand_1_value='';
		$this->operand_2_type='';
		$this->operand_2_value='';
		$this->operator='';
		$this->operand_3_type='';
		$this->operand_3_value='';
		$this->accounting_account='';
		$this->ct_custom_fields_1_desc='';
		$this->ct_custom_fields_2_desc='';
		$this->c_custom_fields_1_desc='';
		$this->c_custom_fields_2_desc='';
		$this->toshow='';

		
	}

}