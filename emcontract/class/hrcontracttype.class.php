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
 *  \file       dev/hrcontracttypes/hrcontracttype.class.php
 *  \ingroup    emcontract othermodule1 othermodule2
 *  \brief      This file is an example for a CRUD class file (Create/Read/Update/Delete)
 *				Initialy built by build_class_from_table on 2015-07-06 20:38
 */

// Put here all includes required by your class file
require_once(DOL_DOCUMENT_ROOT."/core/class/commonobject.class.php");
//require_once(DOL_DOCUMENT_ROOT."/societe/class/societe.class.php");
//require_once(DOL_DOCUMENT_ROOT."/product/class/product.class.php");


/**
 *	Put here description of your class
 */
class Hrcontracttype extends CommonObject
{
	var $db;							//!< To store db handler
	var $error;							//!< To return error code (or message)
	var $errors=array();				//!< To return several error codes (or messages)
	var $element='hrcontracttype';			//!< Id that identify managed objects
	var $table_element='hr_contract_type';		//!< Name of table without prefix where object is stored

    var $id;
    
	var $entity;
	var $date_creation='';
	var $date_modification='';
	var $type_contract;
	var $title;
	var $description;
	var $employee_status;
	var $user_creation;
	var $user_modification;
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
	var $salary_method;
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
		if (isset($this->title)) $this->title=trim($this->title);
		if (isset($this->description)) $this->description=trim($this->description);
		if (isset($this->employee_status)) $this->employee_status=trim($this->employee_status);
		if (isset($this->user_creation)) $this->user_creation=trim($this->user_creation);
		if (isset($this->user_modification)) $this->user_modification=trim($this->user_modification);
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
		if (isset($this->salary_method)) $this->salary_method=trim($this->salary_method);
		if (isset($this->sm_custom_field_1_value)) $this->sm_custom_field_1_value=trim($this->sm_custom_field_1_value);
		if (isset($this->sm_custom_field_2_value)) $this->sm_custom_field_2_value=trim($this->sm_custom_field_2_value);

        

		// Check parameters
		// Put here code to add control on parameters values

        // Insert request
		$sql = "INSERT INTO ".MAIN_DB_PREFIX.$this->table_element."(";
		
		$sql.= "entity,";
		$sql.= "date_creation,";
		$sql.= "type_contract,";
		$sql.= "title,";
		$sql.= "description,";
		$sql.= "employee_status,";
		$sql.= "fk_user_creation,";
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
		$sql.= " NOW() ,";
		$sql.= " ".(! isset($this->type_contract)?'NULL':"'".$this->type_contract."'").",";
		$sql.= " ".(! isset($this->title)?'NULL':"'".$this->db->escape($this->title)."'").",";
		$sql.= " ".(! isset($this->description)?'NULL':"'".$this->db->escape($this->description)."'").",";
		$sql.= " ".(! isset($this->employee_status)?'NULL':"'".$this->employee_status."'").",";
		$sql.= " '".$user->id."',";
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
		$sql.= " ".(! isset($this->salary_method)?'NULL':"'".$this->salary_method."'").",";
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
		$sql.= " t.date_creation,";
		$sql.= " t.date_modification,";
		$sql.= " t.type_contract,";
		$sql.= " t.title,";
		$sql.= " t.description,";
		$sql.= " t.employee_status,";
		$sql.= " t.fk_user_creation,";
		$sql.= " t.fk_user_modification,";
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
				$this->date_creation = $this->db->jdate($obj->date_creation);
				$this->date_modification = $this->db->jdate($obj->date_modification);
				$this->type_contract = $obj->type_contract;
				$this->title = $obj->title;
				$this->description = $obj->description;
				$this->employee_status = $obj->employee_status;
				$this->user_creation = $obj->fk_user_creation;
				$this->user_modification = $obj->fk_user_modification;
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
				$this->salary_method = $obj->fk_salary_method;
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
		if (isset($this->title)) $this->title=trim($this->title);
		if (isset($this->description)) $this->description=trim($this->description);
		if (isset($this->employee_status)) $this->employee_status=trim($this->employee_status);
		if (isset($this->user_creation)) $this->user_creation=trim($this->user_creation);
		if (isset($this->user_modification)) $this->user_modification=trim($this->user_modification);
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
		if (isset($this->salary_method)) $this->salary_method=trim($this->salary_method);
		if (isset($this->sm_custom_field_1_value)) $this->sm_custom_field_1_value=trim($this->sm_custom_field_1_value);
		if (isset($this->sm_custom_field_2_value)) $this->sm_custom_field_2_value=trim($this->sm_custom_field_2_value);

        

		// Check parameters
		// Put here code to add a control on parameters values

        // Update request
        $sql = "UPDATE ".MAIN_DB_PREFIX.$this->table_element." SET";
        
		$sql.= " entity=".(empty($this->entity)?"null":"'".$this->entity."'").",";
		$sql.= " date_modification=NOW() ,";
		$sql.= " type_contract=".(empty($this->type_contract)?"null":"'".$this->type_contract."'").",";
		$sql.= " title=".(empty($this->title)?"null":"'".$this->db->escape($this->title)."'").",";
		$sql.= " description=".(empty($this->description)?"null":"'".$this->db->escape($this->description)."'").",";
		$sql.= " employee_status=".(empty($this->employee_status)?"null":"'".$this->employee_status."'").",";
		$sql.= " fk_user_modification='".$user->id."',";
		$sql.= " weekly_hours=".(empty($this->weekly_hours)?"null":"'".$this->weekly_hours."'").",";
		$sql.= " modulation_period=".(empty($this->modulation_period)?"null":"'".$this->modulation_period."'").",";
		$sql.= " working_days=".(empty($this->working_days)?"null":"'".$this->working_days."'").",";
		$sql.= " normal_rate_days=".(empty($this->normal_rate_days)?"null":"'".$this->normal_rate_days."'").",";
		$sql.= " daily_hours=".(empty($this->daily_hours)?"null":"'".$this->daily_hours."'").",";
		$sql.= " night_hours_start=".(empty($this->night_hours_start)?"null":"'".$this->night_hours_start."'").",";
		$sql.= " night_rate=".(empty($this->night_rate)?"null":"'".$this->night_rate."'").",";
		$sql.= " night_hours_stop=".(empty($this->night_hours_stop)?"null":"'".$this->night_hours_stop."'").",";
		$sql.= " holiday_weekly_generated=".(empty($this->holiday_weekly_generated)?"null":"'".$this->holiday_weekly_generated."'").",";
		$sql.= " overtime_rate=".(empty($this->overtime_rate)?"null":"'".$this->overtime_rate."'").",";
		$sql.= " overtime_recup_only=".(empty($this->overtime_recup_only)?"null":"'".$this->overtime_recup_only."'").",";
		$sql.= " weekly_max_hours=".(empty($this->weekly_max_hours)?"null":"'".$this->weekly_max_hours."'").",";
		$sql.= " weekly_min_hours=".(empty($this->weekly_min_hours)?"null":"'".$this->weekly_min_hours."'").",";
		$sql.= " daily_max_hours=".(empty($this->daily_max_hours)?"null":"'".$this->daily_max_hours."'").",";
		$sql.= " fk_salary_method=".(empty($this->salary_method)?"null":"'".$this->salary_method."'").",";
		$sql.= " sm_custom_field_1_value=".(empty($this->sm_custom_field_1_value)?"null":"'".$this->sm_custom_field_1_value."'").",";
		$sql.= " sm_custom_field_2_value=".(empty($this->sm_custom_field_2_value)?"null":"'".$this->sm_custom_field_2_value."'")."";

        
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
     *	Return clickable name (with picto eventually)
     *
     *	@param		string			$htmlcontent 		text to show
     *	@param		int			$id                     Object ID
     *	@param		string			$ref                    Object ref
     *	@param		int			$withpicto		0=_No picto, 1=Includes the picto in the linkn, 2=Picto only
     *	@return		string						String with URL
     */
    function getNomUrl($htmlcontent,$id=0,$ref='',$withpicto=0)
    {
    	global $langs;

    	$result='';
        if(empty($ref) && $id==0){
            if(isset($this->id))  {
                $id=$this->id;
            }else if (isset($this->rowid)){
                $id=$this->rowid;
            }if(isset($this->ref)){
                $ref=$this->ref;
            }
        }
        
        if($id){
            $lien = '<a href="'.DOL_URL_ROOT.'/emcontract/hrcontracttype.php?id='.$id.'&action=view">';
        }else if (!empty($ref)){
            $lien = '<a href="'.DOL_URL_ROOT.'/emcontract/hrcontracttype.php?ref='.$ref.'&action=view">';
        }else{
            $lien =  "";
        }
        $lienfin=empty($lien)?'':'</a>';

    	$picto='emcontract@emcontract';
        
        if($ref){
            $label=$langs->trans("Show").': '.$ref;
        }else if($id){
            $label=$langs->trans("Show").': '.$id;
        }
    	if ($withpicto==1){ 
            $result.=($lien.img_object($label,$picto).$htmlcontent.$lienfin);
        }else if ($withpicto==2) {
            $result.=$lien.img_object($label,$picto).$lienfin;
        }else{  
            $result.=$lien.$htmlcontent.$lienfin;
        }
    	return $result;
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

		$object=new Hrcontracttype($this->db);

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
		$this->date_creation='';
		$this->date_modification='';
		$this->type_contract='';
		$this->title='';
		$this->description='';
		$this->employee_status='';
		$this->user_creation='';
		$this->user_modification='';
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
		$this->salary_method='';
		$this->sm_custom_field_1_value='';
		$this->sm_custom_field_2_value='';

		
	}

}
