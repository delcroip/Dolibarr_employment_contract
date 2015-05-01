<?php
/* Copyright (C) 2015 delcroip <pmpdelcroix@gmail.com>
 * Copyright (C) 2007-2012 Laurent Destailleur  <eldy@users.sourceforge.net>
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
 *  \file       dev/skeletons/hrcontracttype.class.php
 *  \ingroup    mymodule othermodule1 othermodule2
 *  \brief      This file is an example for a CRUD class file (Create/Read/Update/Delete)
 *				Initialy built by build_class_from_table on 2015-05-01 16:09
 */

// Put here all includes required by your class file
require_once(DOL_DOCUMENT_ROOT."/core/class/commonobject.class.php");
//require_once(DOL_DOCUMENT_ROOT."/societe/class/societe.class.php");
//require_once(DOL_DOCUMENT_ROOT."/product/class/product.class.php");


/**
 *	Put here description of your class
 */
class contractType extends CommonObject
{
	var $db;							//!< To store db handler
	var $error;							//!< To return error code (or message)
	var $errors=array();				//!< To return several error codes (or messages)
	var $element='hrcontracttype';			//!< Id that identify managed objects
	var $table_element='hrcontracttype';		//!< Name of table without prefix where object is stored

    var $id;
    
	var $entity;
	var $datec='';
	var $datem='';
	var $type_contract;
	var $description;
	var $employee_status;
	var $fk_user_author;
	var $fk_user_modif;
	var $weekly_hours;
	var $modulation_period;
	var $working_days;
	var $normal_rate_days;
	var $daily_hours;
	var $night_hours_start;
	var $night_rate;
	var $night_hours_stop;
	var $holiday_weekly_generated;
	var $overtime_rate;
	var $overtime_recup_only;
	var $weekly_max_hours;
	var $weekly_min_hours;
	var $daily_max_hours;
	var $fk_salary_method;
	var $sm_custom_field_1_value;
	var $sm_custom_field_2_value;

    


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
		if (isset($this->type_contract)) $this->type_contract=trim($this->type_contract);
		if (isset($this->description)) $this->description=trim($this->description);
		if (isset($this->employee_status)) $this->employee_status=trim($this->employee_status);
		if (isset($this->fk_user_author)) $this->fk_user_author=trim($this->fk_user_author);
		if (isset($this->fk_user_modif)) $this->fk_user_modif=trim($this->fk_user_modif);
		if (isset($this->weekly_hours)) $this->weekly_hours=trim($this->weekly_hours);
		if (isset($this->modulation_period)) $this->modulation_period=trim($this->modulation_period);
		if (isset($this->working_days)) $this->working_days=trim($this->working_days);
		if (isset($this->normal_rate_days)) $this->normal_rate_days=trim($this->normal_rate_days);
		if (isset($this->daily_hours)) $this->daily_hours=trim($this->daily_hours);
		if (isset($this->night_hours_start)) $this->night_hours_start=trim($this->night_hours_start);
		if (isset($this->night_rate)) $this->night_rate=trim($this->night_rate);
		if (isset($this->night_hours_stop)) $this->night_hours_stop=trim($this->night_hours_stop);
		if (isset($this->holiday_weekly_generated)) $this->holiday_weekly_generated=trim($this->holiday_weekly_generated);
		if (isset($this->overtime_rate)) $this->overtime_rate=trim($this->overtime_rate);
		if (isset($this->overtime_recup_only)) $this->overtime_recup_only=trim($this->overtime_recup_only);
		if (isset($this->weekly_max_hours)) $this->weekly_max_hours=trim($this->weekly_max_hours);
		if (isset($this->weekly_min_hours)) $this->weekly_min_hours=trim($this->weekly_min_hours);
		if (isset($this->daily_max_hours)) $this->daily_max_hours=trim($this->daily_max_hours);
		if (isset($this->fk_salary_method)) $this->fk_salary_method=trim($this->fk_salary_method);
		if (isset($this->sm_custom_field_1_value)) $this->sm_custom_field_1_value=trim($this->sm_custom_field_1_value);
		if (isset($this->sm_custom_field_2_value)) $this->sm_custom_field_2_value=trim($this->sm_custom_field_2_value);

        

		// Check parameters
		// Put here code to add control on parameters values

        // Insert request
		$sql = "INSERT INTO ".MAIN_DB_PREFIX.$this->table_element."(";
		
		$sql.= "entity,";
		$sql.= "datec,";
		$sql.= "datem,";
		$sql.= "type_contract,";
		$sql.= "description,";
		$sql.= "employee_status,";
		$sql.= "fk_user_author,";
		$sql.= "fk_user_modif,";
		$sql.= "weekly_hours,";
		$sql.= "modulation_period,";
		$sql.= "working_days,";
		$sql.= "normal_rate_days,";
		$sql.= "daily_hours,";
		$sql.= "night_hours_start,";
		$sql.= "night_rate,";
		$sql.= "night_hours_stop,";
		$sql.= "holiday_weekly_generated,";
		$sql.= "overtime_rate,";
		$sql.= "overtime_recup_only,";
		$sql.= "weekly_max_hours,";
		$sql.= "weekly_min_hours,";
		$sql.= "daily_max_hours,";
		$sql.= "fk_salary_method,";
		$sql.= "sm_custom_field_1_value,";
		$sql.= "sm_custom_field_2_value";

		
        $sql.= ") VALUES (";
        
		$sql.= " ".(! isset($this->entity)?'NULL':"'".$this->entity."'").",";
		$sql.= " ".(! isset($this->datec) || dol_strlen($this->datec)==0?'NULL':"'".$this->db->idate($this->datec)."'").",";
		$sql.= " ".(! isset($this->datem) || dol_strlen($this->datem)==0?'NULL':"'".$this->db->idate($this->datem)."'").",";
		$sql.= " ".(! isset($this->type_contract)?'NULL':"'".$this->type_contract."'").",";
		$sql.= " ".(! isset($this->description)?'NULL':"'".$this->db->escape($this->description)."'").",";
		$sql.= " ".(! isset($this->employee_status)?'NULL':"'".$this->employee_status."'").",";
		$sql.= " ".(! isset($this->fk_user_author)?'NULL':"'".$this->fk_user_author."'").",";
		$sql.= " ".(! isset($this->fk_user_modif)?'NULL':"'".$this->fk_user_modif."'").",";
		$sql.= " ".(! isset($this->weekly_hours)?'NULL':"'".$this->weekly_hours."'").",";
		$sql.= " ".(! isset($this->modulation_period)?'NULL':"'".$this->modulation_period."'").",";
		$sql.= " ".(! isset($this->working_days)?'NULL':"'".$this->working_days."'").",";
		$sql.= " ".(! isset($this->normal_rate_days)?'NULL':"'".$this->normal_rate_days."'").",";
		$sql.= " ".(! isset($this->daily_hours)?'NULL':"'".$this->daily_hours."'").",";
		$sql.= " ".(! isset($this->night_hours_start)?'NULL':"'".$this->night_hours_start."'").",";
		$sql.= " ".(! isset($this->night_rate)?'NULL':"'".$this->night_rate."'").",";
		$sql.= " ".(! isset($this->night_hours_stop)?'NULL':"'".$this->night_hours_stop."'").",";
		$sql.= " ".(! isset($this->holiday_weekly_generated)?'NULL':"'".$this->holiday_weekly_generated."'").",";
		$sql.= " ".(! isset($this->overtime_rate)?'NULL':"'".$this->overtime_rate."'").",";
		$sql.= " ".(! isset($this->overtime_recup_only)?'NULL':"'".$this->overtime_recup_only."'").",";
		$sql.= " ".(! isset($this->weekly_max_hours)?'NULL':"'".$this->weekly_max_hours."'").",";
		$sql.= " ".(! isset($this->weekly_min_hours)?'NULL':"'".$this->weekly_min_hours."'").",";
		$sql.= " ".(! isset($this->daily_max_hours)?'NULL':"'".$this->daily_max_hours."'").",";
		$sql.= " ".(! isset($this->fk_salary_method)?'NULL':"'".$this->fk_salary_method."'").",";
		$sql.= " ".(! isset($this->sm_custom_field_1_value)?'NULL':"'".$this->sm_custom_field_1_value."'").",";
		$sql.= " ".(! isset($this->sm_custom_field_2_value)?'NULL':"'".$this->sm_custom_field_2_value."'")."";

        
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
		$sql.= " t.type_contract,";
		$sql.= " t.description,";
		$sql.= " t.employee_status,";
		$sql.= " t.fk_user_author,";
		$sql.= " t.fk_user_modif,";
		$sql.= " t.weekly_hours,";
		$sql.= " t.modulation_period,";
		$sql.= " t.working_days,";
		$sql.= " t.normal_rate_days,";
		$sql.= " t.daily_hours,";
		$sql.= " t.night_hours_start,";
		$sql.= " t.night_rate,";
		$sql.= " t.night_hours_stop,";
		$sql.= " t.holiday_weekly_generated,";
		$sql.= " t.overtime_rate,";
		$sql.= " t.overtime_recup_only,";
		$sql.= " t.weekly_max_hours,";
		$sql.= " t.weekly_min_hours,";
		$sql.= " t.daily_max_hours,";
		$sql.= " t.fk_salary_method,";
		$sql.= " t.sm_custom_field_1_value,";
		$sql.= " t.sm_custom_field_2_value";

		
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
				$this->type_contract = $obj->type_contract;
				$this->description = $obj->description;
				$this->employee_status = $obj->employee_status;
				$this->fk_user_author = $obj->fk_user_author;
				$this->fk_user_modif = $obj->fk_user_modif;
				$this->weekly_hours = $obj->weekly_hours;
				$this->modulation_period = $obj->modulation_period;
				$this->working_days = $obj->working_days;
				$this->normal_rate_days = $obj->normal_rate_days;
				$this->daily_hours = $obj->daily_hours;
				$this->night_hours_start = $obj->night_hours_start;
				$this->night_rate = $obj->night_rate;
				$this->night_hours_stop = $obj->night_hours_stop;
				$this->holiday_weekly_generated = $obj->holiday_weekly_generated;
				$this->overtime_rate = $obj->overtime_rate;
				$this->overtime_recup_only = $obj->overtime_recup_only;
				$this->weekly_max_hours = $obj->weekly_max_hours;
				$this->weekly_min_hours = $obj->weekly_min_hours;
				$this->daily_max_hours = $obj->daily_max_hours;
				$this->fk_salary_method = $obj->fk_salary_method;
				$this->sm_custom_field_1_value = $obj->sm_custom_field_1_value;
				$this->sm_custom_field_2_value = $obj->sm_custom_field_2_value;

                
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
		if (isset($this->type_contract)) $this->type_contract=trim($this->type_contract);
		if (isset($this->description)) $this->description=trim($this->description);
		if (isset($this->employee_status)) $this->employee_status=trim($this->employee_status);
		if (isset($this->fk_user_author)) $this->fk_user_author=trim($this->fk_user_author);
		if (isset($this->fk_user_modif)) $this->fk_user_modif=trim($this->fk_user_modif);
		if (isset($this->weekly_hours)) $this->weekly_hours=trim($this->weekly_hours);
		if (isset($this->modulation_period)) $this->modulation_period=trim($this->modulation_period);
		if (isset($this->working_days)) $this->working_days=trim($this->working_days);
		if (isset($this->normal_rate_days)) $this->normal_rate_days=trim($this->normal_rate_days);
		if (isset($this->daily_hours)) $this->daily_hours=trim($this->daily_hours);
		if (isset($this->night_hours_start)) $this->night_hours_start=trim($this->night_hours_start);
		if (isset($this->night_rate)) $this->night_rate=trim($this->night_rate);
		if (isset($this->night_hours_stop)) $this->night_hours_stop=trim($this->night_hours_stop);
		if (isset($this->holiday_weekly_generated)) $this->holiday_weekly_generated=trim($this->holiday_weekly_generated);
		if (isset($this->overtime_rate)) $this->overtime_rate=trim($this->overtime_rate);
		if (isset($this->overtime_recup_only)) $this->overtime_recup_only=trim($this->overtime_recup_only);
		if (isset($this->weekly_max_hours)) $this->weekly_max_hours=trim($this->weekly_max_hours);
		if (isset($this->weekly_min_hours)) $this->weekly_min_hours=trim($this->weekly_min_hours);
		if (isset($this->daily_max_hours)) $this->daily_max_hours=trim($this->daily_max_hours);
		if (isset($this->fk_salary_method)) $this->fk_salary_method=trim($this->fk_salary_method);
		if (isset($this->sm_custom_field_1_value)) $this->sm_custom_field_1_value=trim($this->sm_custom_field_1_value);
		if (isset($this->sm_custom_field_2_value)) $this->sm_custom_field_2_value=trim($this->sm_custom_field_2_value);

        

		// Check parameters
		// Put here code to add a control on parameters values

        // Update request
        $sql = "UPDATE ".MAIN_DB_PREFIX.$this->table_element." SET";
        
		$sql.= " entity=".(isset($this->entity)?$this->entity:"null").",";
		$sql.= " datec=".(dol_strlen($this->datec)!=0 ? "'".$this->db->idate($this->datec)."'" : 'null').",";
		$sql.= " datem=".(dol_strlen($this->datem)!=0 ? "'".$this->db->idate($this->datem)."'" : 'null').",";
		$sql.= " type_contract=".(isset($this->type_contract)?$this->type_contract:"null").",";
		$sql.= " description=".(isset($this->description)?"'".$this->db->escape($this->description)."'":"null").",";
		$sql.= " employee_status=".(isset($this->employee_status)?$this->employee_status:"null").",";
		$sql.= " fk_user_author=".(isset($this->fk_user_author)?$this->fk_user_author:"null").",";
		$sql.= " fk_user_modif=".(isset($this->fk_user_modif)?$this->fk_user_modif:"null").",";
		$sql.= " weekly_hours=".(isset($this->weekly_hours)?$this->weekly_hours:"null").",";
		$sql.= " modulation_period=".(isset($this->modulation_period)?$this->modulation_period:"null").",";
		$sql.= " working_days=".(isset($this->working_days)?$this->working_days:"null").",";
		$sql.= " normal_rate_days=".(isset($this->normal_rate_days)?$this->normal_rate_days:"null").",";
		$sql.= " daily_hours=".(isset($this->daily_hours)?$this->daily_hours:"null").",";
		$sql.= " night_hours_start=".(isset($this->night_hours_start)?$this->night_hours_start:"null").",";
		$sql.= " night_rate=".(isset($this->night_rate)?$this->night_rate:"null").",";
		$sql.= " night_hours_stop=".(isset($this->night_hours_stop)?$this->night_hours_stop:"null").",";
		$sql.= " holiday_weekly_generated=".(isset($this->holiday_weekly_generated)?$this->holiday_weekly_generated:"null").",";
		$sql.= " overtime_rate=".(isset($this->overtime_rate)?$this->overtime_rate:"null").",";
		$sql.= " overtime_recup_only=".(isset($this->overtime_recup_only)?$this->overtime_recup_only:"null").",";
		$sql.= " weekly_max_hours=".(isset($this->weekly_max_hours)?$this->weekly_max_hours:"null").",";
		$sql.= " weekly_min_hours=".(isset($this->weekly_min_hours)?$this->weekly_min_hours:"null").",";
		$sql.= " daily_max_hours=".(isset($this->daily_max_hours)?$this->daily_max_hours:"null").",";
		$sql.= " fk_salary_method=".(isset($this->fk_salary_method)?$this->fk_salary_method:"null").",";
		$sql.= " sm_custom_field_1_value=".(isset($this->sm_custom_field_1_value)?$this->sm_custom_field_1_value:"null").",";
		$sql.= " sm_custom_field_2_value=".(isset($this->sm_custom_field_2_value)?$this->sm_custom_field_2_value:"null")."";

        
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

		$object=new contractType($this->db);

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
		$this->type_contract='';
		$this->description='';
		$this->employee_status='';
		$this->fk_user_author='';
		$this->fk_user_modif='';
		$this->weekly_hours='';
		$this->modulation_period='';
		$this->working_days='';
		$this->normal_rate_days='';
		$this->daily_hours='';
		$this->night_hours_start='';
		$this->night_rate='';
		$this->night_hours_stop='';
		$this->holiday_weekly_generated='';
		$this->overtime_rate='';
		$this->overtime_recup_only='';
		$this->weekly_max_hours='';
		$this->weekly_min_hours='';
		$this->daily_max_hours='';
		$this->fk_salary_method='';
		$this->sm_custom_field_1_value='';
		$this->sm_custom_field_2_value='';

		
	}

}
