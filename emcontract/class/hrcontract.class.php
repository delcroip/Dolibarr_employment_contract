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
 *  \file       dev/hrcontracts/hrcontract.class.php
 *  \ingroup    emcontract othermodule1 othermodule2
 *  \brief      This file is an example for a CRUD class file (Create/Read/Update/Delete)
 *				Initialy built by build_class_from_table on 2015-06-05 20:13
 */

// Put here all includes required by your class file
require_once(DOL_DOCUMENT_ROOT."/core/class/commonobject.class.php");
//require_once(DOL_DOCUMENT_ROOT."/societe/class/societe.class.php");
//require_once(DOL_DOCUMENT_ROOT."/product/class/product.class.php");


/**
 *	Put here description of your class
 */
class Hrcontract extends CommonObject
{
	var $db;							//!< To store db handler
	var $error;							//!< To return error code (or message)
	var $errors=array();				//!< To return several error codes (or messages)
	var $element='hrcontract';			//!< Id that identify managed objects
	var $table_element='hr_contract';		//!< Name of table without prefix where object is stored

    var $id;
    
	var $ref;
	var $user;
	var $entity;
	var $date_creation='';
	var $date_modification='';
	var $contract_type;
	var $job_type;
	var $job_Location;
	var $date_dpae='';
	var $date_medicalexam='';
	var $date_sign_employee='';
	var $date_sign_management='';
	var $description;
	var $date_start_contract='';
	var $date_end_contract='';
	var $user_creation;
	var $user_modification;
	var $base_rate;
	var $reason;
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
        
		if (isset($this->ref)) $this->ref=trim($this->ref);
		if (isset($this->user)) $this->user=trim($this->user);
		if (isset($this->entity)) $this->entity=trim($this->entity);
		if (isset($this->contract_type)) $this->contract_type=trim($this->contract_type);
		if (isset($this->job_type)) $this->job_type=trim($this->job_type);
		if (isset($this->job_Location)) $this->job_Location=trim($this->job_Location);
		if (isset($this->description)) $this->description=trim($this->description);
		if (isset($this->user_creation)) $this->user_creation=trim($this->user_creation);
		if (isset($this->user_modification)) $this->user_modification=trim($this->user_modification);
		if (isset($this->base_rate)) $this->base_rate=trim($this->base_rate);
		if (isset($this->reason)) $this->reason=trim($this->reason);
		if (isset($this->sm_custom_field_1_value)) $this->sm_custom_field_1_value=trim($this->sm_custom_field_1_value);
		if (isset($this->sm_custom_field_2_value)) $this->sm_custom_field_2_value=trim($this->sm_custom_field_2_value);

        

		// Check parameters
		// Put here code to add control on parameters values

        // Insert request
		$sql = "INSERT INTO ".MAIN_DB_PREFIX.$this->table_element."(";
		
		$sql.= "ref,";
		$sql.= "fk_user,";
		$sql.= "entity,";
		$sql.= "date_creation,";
		$sql.= "fk_contract_type,";
		$sql.= "fk_job_type,";
		$sql.= "fk_job_Location,";
		$sql.= "date_dpae,";
		$sql.= "date_medicalexam,";
		$sql.= "date_sign_employee,";
		$sql.= "date_sign_management,";
		$sql.= "description,";
		$sql.= "date_start_contract,";
		$sql.= "date_end_contract,";
		$sql.= "fk_user_creation,";
		$sql.= "base_rate,";
		$sql.= "reason,";
		$sql.= "sm_custom_field_1_value,";
		$sql.= "sm_custom_field_2_value";

		
        $sql.= ") VALUES (";
        
		$sql.= " ".(! isset($this->ref)?'NULL':"'".$this->db->escape($this->ref)."'").",";
		$sql.= " ".(! isset($this->user)?'NULL':"'".$this->user."'").",";
		$sql.= " ".(! isset($this->entity)?'NULL':"'".$this->entity."'").",";
		$sql.= " NOW() ,";
		$sql.= " ".(! isset($this->contract_type)?'NULL':"'".$this->contract_type."'").",";
		$sql.= " ".(! isset($this->job_type)?'NULL':"'".$this->job_type."'").",";
		$sql.= " ".(! isset($this->job_Location)?'NULL':"'".$this->job_Location."'").",";
		$sql.= " ".(! isset($this->date_dpae) || dol_strlen($this->date_dpae)==0?'NULL':"'".$this->db->idate($this->date_dpae)."'").",";
		$sql.= " ".(! isset($this->date_medicalexam) || dol_strlen($this->date_medicalexam)==0?'NULL':"'".$this->db->idate($this->date_medicalexam)."'").",";
		$sql.= " ".(! isset($this->date_sign_employee) || dol_strlen($this->date_sign_employee)==0?'NULL':"'".$this->db->idate($this->date_sign_employee)."'").",";
		$sql.= " ".(! isset($this->date_sign_management) || dol_strlen($this->date_sign_management)==0?'NULL':"'".$this->db->idate($this->date_sign_management)."'").",";
		$sql.= " ".(! isset($this->description)?'NULL':"'".$this->db->escape($this->description)."'").",";
		$sql.= " ".(! isset($this->date_start_contract) || dol_strlen($this->date_start_contract)==0?'NULL':"'".$this->db->idate($this->date_start_contract)."'").",";
		$sql.= " ".(! isset($this->date_end_contract) || dol_strlen($this->date_end_contract)==0?'NULL':"'".$this->db->idate($this->date_end_contract)."'").",";
		$sql.= " '".$user->id."',";
		$sql.= " ".(! isset($this->base_rate)?'NULL':"'".$this->base_rate."'").",";
		$sql.= " ".(! isset($this->reason)?'NULL':"'".$this->db->escape($this->reason)."'").",";
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
		
		$sql.= " t.ref,";
		$sql.= " t.fk_user,";
		$sql.= " t.entity,";
		$sql.= " t.date_creation,";
		$sql.= " t.date_modification,";
		$sql.= " t.fk_contract_type,";
		$sql.= " t.fk_job_type,";
		$sql.= " t.fk_job_Location,";
		$sql.= " t.date_dpae,";
		$sql.= " t.date_medicalexam,";
		$sql.= " t.date_sign_employee,";
		$sql.= " t.date_sign_management,";
		$sql.= " t.description,";
		$sql.= " t.date_start_contract,";
		$sql.= " t.date_end_contract,";
		$sql.= " t.fk_user_creation,";
		$sql.= " t.fk_user_modification,";
		$sql.= " t.base_rate,";
		$sql.= " t.reason,";
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
                
				$this->ref = $obj->ref;
				$this->user = $obj->fk_user;
				$this->entity = $obj->entity;
				$this->date_creation = $this->db->jdate($obj->date_creation);
				$this->date_modification = $this->db->jdate($obj->date_modification);
				$this->contract_type = $obj->fk_contract_type;
				$this->job_type = $obj->fk_job_type;
				$this->job_Location = $obj->fk_job_Location;
				$this->date_dpae = $this->db->jdate($obj->date_dpae);
				$this->date_medicalexam = $this->db->jdate($obj->date_medicalexam);
				$this->date_sign_employee = $this->db->jdate($obj->date_sign_employee);
				$this->date_sign_management = $this->db->jdate($obj->date_sign_management);
				$this->description = $obj->description;
				$this->date_start_contract = $this->db->jdate($obj->date_start_contract);
				$this->date_end_contract = $this->db->jdate($obj->date_end_contract);
				$this->user_creation = $obj->fk_user_creation;
				$this->user_modification = $obj->fk_user_modification;
				$this->base_rate = $obj->base_rate;
				$this->reason = $obj->reason;
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
        
		if (isset($this->ref)) $this->ref=trim($this->ref);
		if (isset($this->user)) $this->user=trim($this->user);
		if (isset($this->entity)) $this->entity=trim($this->entity);
		if (isset($this->contract_type)) $this->contract_type=trim($this->contract_type);
		if (isset($this->job_type)) $this->job_type=trim($this->job_type);
		if (isset($this->job_Location)) $this->job_Location=trim($this->job_Location);
		if (isset($this->description)) $this->description=trim($this->description);
		if (isset($this->user_creation)) $this->user_creation=trim($this->user_creation);
		if (isset($this->user_modification)) $this->user_modification=trim($this->user_modification);
		if (isset($this->base_rate)) $this->base_rate=trim($this->base_rate);
		if (isset($this->reason)) $this->reason=trim($this->reason);
		if (isset($this->sm_custom_field_1_value)) $this->sm_custom_field_1_value=trim($this->sm_custom_field_1_value);
		if (isset($this->sm_custom_field_2_value)) $this->sm_custom_field_2_value=trim($this->sm_custom_field_2_value);

        

		// Check parameters
		// Put here code to add a control on parameters values

        // Update request
        $sql = "UPDATE ".MAIN_DB_PREFIX.$this->table_element." SET";
        
		$sql.= " ref=".(isset($this->ref)?"'".$this->db->escape($this->ref)."'":"null").",";
		$sql.= " fk_user=".(isset($this->user)?$this->user:"null").",";
		$sql.= " entity=".(isset($this->entity)?$this->entity:"null").",";
		$sql.= " date_modification=NOW() ,";
		$sql.= " fk_contract_type=".(isset($this->contract_type)?$this->contract_type:"null").",";
		$sql.= " fk_job_type=".(isset($this->job_type)?$this->job_type:"null").",";
		$sql.= " fk_job_Location=".(isset($this->job_Location)?$this->job_Location:"null").",";
		$sql.= " date_dpae=".(dol_strlen($this->date_dpae)!=0 ? "'".$this->db->idate($this->date_dpae)."'" : 'null').",";
		$sql.= " date_medicalexam=".(dol_strlen($this->date_medicalexam)!=0 ? "'".$this->db->idate($this->date_medicalexam)."'" : 'null').",";
		$sql.= " date_sign_employee=".(dol_strlen($this->date_sign_employee)!=0 ? "'".$this->db->idate($this->date_sign_employee)."'" : 'null').",";
		$sql.= " date_sign_management=".(dol_strlen($this->date_sign_management)!=0 ? "'".$this->db->idate($this->date_sign_management)."'" : 'null').",";
		$sql.= " description=".(isset($this->description)?"'".$this->db->escape($this->description)."'":"null").",";
		$sql.= " date_start_contract=".(dol_strlen($this->date_start_contract)!=0 ? "'".$this->db->idate($this->date_start_contract)."'" : 'null').",";
		$sql.= " date_end_contract=".(dol_strlen($this->date_end_contract)!=0 ? "'".$this->db->idate($this->date_end_contract)."'" : 'null').",";
		$sql.= " fk_user_modification='".$user->id."',";
		$sql.= " base_rate=".(isset($this->base_rate)?$this->base_rate:"null").",";
		$sql.= " reason=".(isset($this->reason)?"'".$this->db->escape($this->reason)."'":"null").",";
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
     *	Return clicable name (with picto eventually)
     *
     *	@param		int			$withpicto		0=_No picto, 1=Includes the picto in the linkn, 2=Picto only
     *	@return		string						String with URL
     */
    function getNomUrl($withpicto=0)
    {
    	global $langs;

    	$result='';
        $id=0;
        $ref='';
        if(isset($this->id))  
            $id=$this->id;
        else if (isset($this->rowid))
            $id=$this->rowid;
        if(isset($this->ref))
            $ref=$this->ref;
        if($id)
            $lien = '<a href="'.DOL_URL_ROOT.'/emcontract/hrcontract.php?id='.$id.'&action=view">';
    	else if ($ref)
            $lien = '<a href="'.DOL_URL_ROOT.'/emcontract/hrcontract.php?ref='.$ref.'&action=view">';
    	else
            return "Error";
        $lienfin='</a>';

    	$picto='emcontract@emcontract';
        
        if($ref)
            $label=$langs->trans("Show").': '.$ref;
        else if($id)
            $label=$langs->trans("Show").': '.$id;
        
    	if ($withpicto) $result.=($lien.img_object($label,$picto).$lienfin);
    	if ($withpicto && $withpicto != 2) $result.=' ';
    	if ($withpicto != 2) $result.=$lien.$ref.$lienfin;
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

		$object=new Hrcontract($this->db);

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
		
		$this->ref='';
		$this->user='';
		$this->entity='';
		$this->date_creation='';
		$this->date_modification='';
		$this->contract_type='';
		$this->job_type='';
		$this->job_Location='';
		$this->date_dpae='';
		$this->date_medicalexam='';
		$this->date_sign_employee='';
		$this->date_sign_management='';
		$this->description='';
		$this->date_start_contract='';
		$this->date_end_contract='';
		$this->user_creation='';
		$this->user_modification='';
		$this->base_rate='';
		$this->reason='';
		$this->sm_custom_field_1_value='';
		$this->sm_custom_field_2_value='';

		
	}
/*
 * function to genegate a select list from a table, the showed text will be a concatenation of some 
 * column defined in column bit, the Least sinificative bit will represent the first colum 
 * 
 *  @param    string              	$table                 table which the fk refers to (without prefix)
 *  @param    string              	$fieldValue         field of the table which the fk refers to, the one to put in the Valuepart
 *  @param    string              	$htmlName        name to the form select
 *  @param    string              	$fieldToShow1    first part of the concatenation
 *  @param    string              	$fieldToShow1    second part of the concatenation
 *  @param    string              	$selected            which value must be selected
 *  @param    string              	$sqlTail              to limit per entity, to filter ...
 *  @param    string              	$separator          separator between the tow contactened fileds

 *  @return string                                                   html code
 */
function select_generic($table, $fieldValue,$htmlName,$fieldToShow1,$fieldToShow2="",$selected="",$sqlTail="",$separator=', '){
     //
    if($table=="" || $fieldValue=="" || $fieldToShow1=="" || $htmlName=="" )
    {
        return "error, one of the mandatory field of the function  select_generic is missing";
    }
    $select="<select class=\"flat\" id=\"".$htmlName." \" name=\"".$htmlName."\">";
    
    $sql="SELECT";
    $sql.=" ".$fieldValue;
    $sql.=" ,".$fieldToShow1;
    if(!empty($fieldToShow2))
        $sql.=" ,".$fieldToShow2;
    $sql.= " FROM ".MAIN_DB_PREFIX.$table." as t";
    if(!empty($sqlTail))
            $sql.=" , ".$sqlTail;
    //$sql.= " ORDER BY t.".$field;
       
    dol_syslog("form::select_generic sql=".$sql, LOG_DEBUG);
    
    $resql=$this->db->query($sql);
   
    if ($resql)
    {
        $select.= "<option value=\"-1\" ".(empty($selected)?"selected=\"selected\"":"").">&nbsp;</option>\n";
        $i=0;
         //return $table."this->db".$field;
        $num = $this->db->num_rows($resql);
        while ($i < $num)
        {
            
            $obj = $this->db->fetch_object($resql);
            
            if ($obj)
            {
                    $select.= "<option value=\"".$obj->{$fieldValue}."\" ";
                    $select.=(($obj->{$fieldValue}===$selected)?"selected=\"selected\" >":">");                    
                    $select.=$obj->{$fieldToShow1};
                    if(!empty($fieldToShow2))
                         $select.=$separator.$obj->{$fieldToShow2};            
                    $select.="</option>\n";
            } 
            $i++;
        }
    }
    else
    {
        $error++;
        dol_print_error($this->db);
       $select.= "<option value=\"-1\" selected=\"selected\">ERROR</option>\n";
    }
      $select.="</select>\n";
      return $select;
    
 }
/*
 * function to genegate a select list from a table, the showed text will be a concatenation of some 
 * column defined in column bit, the Least sinificative bit will represent the first colum 
 * 
 *  @param    string              	$table              table which the enum refers to (without prefix)
 *  @param    string              	$fieldValue         field of the table which the enum refers to
 *  @param    string              	$htmlName           name to the form select
 *  @param    string              	$selected           which value must be selected
 *  @return string                                                   html code
 */
 
function select_enum($table, $fieldValue,$htmlName,$selected=""){
     global $langs;
    if($table=="" || $fieldValue=="" || $htmlName=="" )
    {
        return "error, one of the mandatory field of the function  select_enum is missing";
    }    
    $sql="SHOW COLUMNS FROM ";//llx_hr_event_time LIKE 'audience'";
    $sql.=MAIN_DB_PREFIX.$table." WHERE Field='";
    $sql.=$fieldValue."'";
    //$sql.= " ORDER BY t.".$field;
       
    dol_syslog("form::select_enum sql=".$sql, LOG_DEBUG);
    
    $resql=$this->db->query($sql);
    
    if ($resql)
    {
        $i=0;
         //return $table."this->db".$field;
        $num = $this->db->num_rows($resql);
        if($num)
        {
           
            $obj = $this->db->fetch_object($resql);
            if ($obj && strpos($obj->Type,'enum(')===0)
            {
                if(empty($selected) && !empty($obj->Default))$selected="'{$obj->Default}'";
                $select="<select class=\"flat\" id=\"{$htmlName}\" name=\"{$htmlName}\">";
                $select.= "<option value=\"-1\" ".(empty($selected)?"selected=\"selected\"":"").">&nbsp;</option>\n";

                $enums= explode(',',substr($obj->Type, 5,-1));
                foreach ($enums as $enum){
                    $select.= "<option value=\"{$enum}\" ";
                    $select.=((substr($enum,1,-1)===$selected)?"selected=\"selected\" >":">");                    
                    $select.=$langs->trans(substr($enum,1,-1));          
                    $select.="</option>\n";
                }  
                $select.="</select>\n";
            }else{
                $select="<input selected=\"{$selected}\" id=\"{$htmlName} \" name=\"{$htmlName}\">";
            }
 
        }else{
                $select="<input selected=\"{$selected}\" id=\"{$htmlName} \" name=\"{$htmlName}\">";
        }
    }
    else
    {
        $error++;
        dol_print_error($this->db);
       $select="<input selected=\"{$selected}\" id=\"{$htmlName} \" name=\"{$htmlName}\">";
    }
      
      return $select;
    
 }

/*
 * function to genegate a select list from a table, the showed text will be a concatenation of some 
 * column defined in column bit, the Least sinificative bit will represent the first colum 
 * 
 *  @param    string              	$table                 table which the fk refers to (without prefix)
 *  @param    string              	$fieldValue         field of the table which the fk refers to, the one to put in the Valuepart
 *  @param    string              	$selected           value selected of the field value column
 *  @param    string              	$fieldToShow1    first part of the concatenation
 *  @param    string              	$fieldToShow1    second part of the concatenation
 *  @param    string              	$separator          separator between the tow contactened fileds

 *  @return string                                                   html code
 */
function print_generic($table, $fieldValue,$selected,$fieldToShow1,$fieldToShow2="",$separator=', '){
   //return $table.$this->db.$field;
    if($table=="" || $fieldValue=="" || $fieldToShow1=='')
    {
        return "error, one of the mandatory field of the function  print_generic is missing";
    }else if (empty($selected)){
        return "NuLL";
    }
    
    $sql="SELECT";
    $sql.=" ".$fieldValue;
    $sql.=" ,".$fieldToShow1;
    if(!empty($fieldToShow2))
        $sql.=" ,".$fieldToShow2;
    $sql.= " FROM ".MAIN_DB_PREFIX.$table." as t";
    $sql.= " WHERE t.".$fieldValue."=".$selected;
       
    dol_syslog("form::print_generic sql=".$sql, LOG_DEBUG);
    
    $resql=$this->db->query($sql);
    
    if ($resql)
    {

        $num = $this->db->num_rows($resql);
        if ( $num)
        {
            $obj = $this->db->fetch_object($resql);
            
            if ($obj)
            {
                            $select=$obj->{$fieldToShow1};
                            if(!empty($fieldToShow2))
                                 $select.=$separator.$obj->{$fieldToShow2};        
            }else{
                $select= "NULL";
            }
        }else{
            $select= "NULL";
        }
    }
    else
    {
        $error++;
        dol_print_error($this->db);
       $select.= "ERROR";
    }
      $select.="\n";
      return $select;
 }
 
 
}
