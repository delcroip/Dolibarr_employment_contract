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
 *  \file       dev/skeletons/user.class.php
 *  \ingroup    mymodule othermodule1 othermodule2
 *  \brief      This file is an example for a CRUD class file (Create/Read/Update/Delete)
 *				Initialy built by build_class_from_table on 2015-04-26 17:38
 */

// Put here all includes required by your class file
require_once(DOL_DOCUMENT_ROOT."/core/class/commonobject.class.php");
//require_once(DOL_DOCUMENT_ROOT."/societe/class/societe.class.php");
//require_once(DOL_DOCUMENT_ROOT."/product/class/product.class.php");


/**
 *	Put here description of your class
 */
class User extends CommonObject
{
	var $db;							//!< To store db handler
	var $error;							//!< To return error code (or message)
	var $errors=array();				//!< To return several error codes (or messages)
	var $element='user';			//!< Id that identify managed objects
	var $table_element='user';		//!< Name of table without prefix where object is stored

    var $id;
    
	var $entity;
	var $ref_ext;
	var $ref_int;
	var $datec='';
	var $tms='';
	var $fk_user_creat;
	var $fk_user_modif;
	var $login;
	var $pass;
	var $pass_crypted;
	var $pass_temp;
	var $civility;
	var $lastname;
	var $firstname;
	var $address;
	var $zip;
	var $town;
	var $fk_state;
	var $fk_country;
	var $job;
	var $skype;
	var $office_phone;
	var $office_fax;
	var $user_mobile;
	var $email;
	var $signature;
	var $admin;
	var $module_comm;
	var $module_compta;
	var $fk_societe;
	var $fk_socpeople;
	var $fk_member;
	var $fk_user;
	var $note;
	var $datelastlogin='';
	var $datepreviouslogin='';
	var $egroupware_id;
	var $ldap_sid;
	var $openid;
	var $statut;
	var $photo;
	var $lang;
	var $color;
	var $barcode;
	var $fk_barcode_type;
	var $accountancy_code;
	var $nb_holiday;
	var $thm;
	var $tjm;
	var $salary;
	var $salaryextra;
	var $weeklyhours;

    


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
		if (isset($this->ref_ext)) $this->ref_ext=trim($this->ref_ext);
		if (isset($this->ref_int)) $this->ref_int=trim($this->ref_int);
		if (isset($this->fk_user_creat)) $this->fk_user_creat=trim($this->fk_user_creat);
		if (isset($this->fk_user_modif)) $this->fk_user_modif=trim($this->fk_user_modif);
		if (isset($this->login)) $this->login=trim($this->login);
		if (isset($this->pass)) $this->pass=trim($this->pass);
		if (isset($this->pass_crypted)) $this->pass_crypted=trim($this->pass_crypted);
		if (isset($this->pass_temp)) $this->pass_temp=trim($this->pass_temp);
		if (isset($this->civility)) $this->civility=trim($this->civility);
		if (isset($this->lastname)) $this->lastname=trim($this->lastname);
		if (isset($this->firstname)) $this->firstname=trim($this->firstname);
		if (isset($this->address)) $this->address=trim($this->address);
		if (isset($this->zip)) $this->zip=trim($this->zip);
		if (isset($this->town)) $this->town=trim($this->town);
		if (isset($this->fk_state)) $this->fk_state=trim($this->fk_state);
		if (isset($this->fk_country)) $this->fk_country=trim($this->fk_country);
		if (isset($this->job)) $this->job=trim($this->job);
		if (isset($this->skype)) $this->skype=trim($this->skype);
		if (isset($this->office_phone)) $this->office_phone=trim($this->office_phone);
		if (isset($this->office_fax)) $this->office_fax=trim($this->office_fax);
		if (isset($this->user_mobile)) $this->user_mobile=trim($this->user_mobile);
		if (isset($this->email)) $this->email=trim($this->email);
		if (isset($this->signature)) $this->signature=trim($this->signature);
		if (isset($this->admin)) $this->admin=trim($this->admin);
		if (isset($this->module_comm)) $this->module_comm=trim($this->module_comm);
		if (isset($this->module_compta)) $this->module_compta=trim($this->module_compta);
		if (isset($this->fk_societe)) $this->fk_societe=trim($this->fk_societe);
		if (isset($this->fk_socpeople)) $this->fk_socpeople=trim($this->fk_socpeople);
		if (isset($this->fk_member)) $this->fk_member=trim($this->fk_member);
		if (isset($this->fk_user)) $this->fk_user=trim($this->fk_user);
		if (isset($this->note)) $this->note=trim($this->note);
		if (isset($this->egroupware_id)) $this->egroupware_id=trim($this->egroupware_id);
		if (isset($this->ldap_sid)) $this->ldap_sid=trim($this->ldap_sid);
		if (isset($this->openid)) $this->openid=trim($this->openid);
		if (isset($this->statut)) $this->statut=trim($this->statut);
		if (isset($this->photo)) $this->photo=trim($this->photo);
		if (isset($this->lang)) $this->lang=trim($this->lang);
		if (isset($this->color)) $this->color=trim($this->color);
		if (isset($this->barcode)) $this->barcode=trim($this->barcode);
		if (isset($this->fk_barcode_type)) $this->fk_barcode_type=trim($this->fk_barcode_type);
		if (isset($this->accountancy_code)) $this->accountancy_code=trim($this->accountancy_code);
		if (isset($this->nb_holiday)) $this->nb_holiday=trim($this->nb_holiday);
		if (isset($this->thm)) $this->thm=trim($this->thm);
		if (isset($this->tjm)) $this->tjm=trim($this->tjm);
		if (isset($this->salary)) $this->salary=trim($this->salary);
		if (isset($this->salaryextra)) $this->salaryextra=trim($this->salaryextra);
		if (isset($this->weeklyhours)) $this->weeklyhours=trim($this->weeklyhours);

        

		// Check parameters
		// Put here code to add control on parameters values

        // Insert request
		$sql = "INSERT INTO ".MAIN_DB_PREFIX.$this->table_element."(";
		
		$sql.= "entity,";
		$sql.= "ref_ext,";
		$sql.= "ref_int,";
		$sql.= "datec,";
		$sql.= "fk_user_creat,";
		$sql.= "fk_user_modif,";
		$sql.= "login,";
		$sql.= "pass,";
		$sql.= "pass_crypted,";
		$sql.= "pass_temp,";
		$sql.= "civility,";
		$sql.= "lastname,";
		$sql.= "firstname,";
		$sql.= "address,";
		$sql.= "zip,";
		$sql.= "town,";
		$sql.= "fk_state,";
		$sql.= "fk_country,";
		$sql.= "job,";
		$sql.= "skype,";
		$sql.= "office_phone,";
		$sql.= "office_fax,";
		$sql.= "user_mobile,";
		$sql.= "email,";
		$sql.= "signature,";
		$sql.= "admin,";
		$sql.= "module_comm,";
		$sql.= "module_compta,";
		$sql.= "fk_societe,";
		$sql.= "fk_socpeople,";
		$sql.= "fk_member,";
		$sql.= "fk_user,";
		$sql.= "note,";
		$sql.= "datelastlogin,";
		$sql.= "datepreviouslogin,";
		$sql.= "egroupware_id,";
		$sql.= "ldap_sid,";
		$sql.= "openid,";
		$sql.= "statut,";
		$sql.= "photo,";
		$sql.= "lang,";
		$sql.= "color,";
		$sql.= "barcode,";
		$sql.= "fk_barcode_type,";
		$sql.= "accountancy_code,";
		$sql.= "nb_holiday,";
		$sql.= "thm,";
		$sql.= "tjm,";
		$sql.= "salary,";
		$sql.= "salaryextra,";
		$sql.= "weeklyhours";

		
        $sql.= ") VALUES (";
        
		$sql.= " ".(! isset($this->entity)?'NULL':"'".$this->entity."'").",";
		$sql.= " ".(! isset($this->ref_ext)?'NULL':"'".$this->db->escape($this->ref_ext)."'").",";
		$sql.= " ".(! isset($this->ref_int)?'NULL':"'".$this->db->escape($this->ref_int)."'").",";
		$sql.= " ".(! isset($this->datec) || dol_strlen($this->datec)==0?'NULL':"'".$this->db->idate($this->datec)."'").",";
		$sql.= " ".(! isset($this->fk_user_creat)?'NULL':"'".$this->fk_user_creat."'").",";
		$sql.= " ".(! isset($this->fk_user_modif)?'NULL':"'".$this->fk_user_modif."'").",";
		$sql.= " ".(! isset($this->login)?'NULL':"'".$this->db->escape($this->login)."'").",";
		$sql.= " ".(! isset($this->pass)?'NULL':"'".$this->db->escape($this->pass)."'").",";
		$sql.= " ".(! isset($this->pass_crypted)?'NULL':"'".$this->db->escape($this->pass_crypted)."'").",";
		$sql.= " ".(! isset($this->pass_temp)?'NULL':"'".$this->db->escape($this->pass_temp)."'").",";
		$sql.= " ".(! isset($this->civility)?'NULL':"'".$this->db->escape($this->civility)."'").",";
		$sql.= " ".(! isset($this->lastname)?'NULL':"'".$this->db->escape($this->lastname)."'").",";
		$sql.= " ".(! isset($this->firstname)?'NULL':"'".$this->db->escape($this->firstname)."'").",";
		$sql.= " ".(! isset($this->address)?'NULL':"'".$this->db->escape($this->address)."'").",";
		$sql.= " ".(! isset($this->zip)?'NULL':"'".$this->db->escape($this->zip)."'").",";
		$sql.= " ".(! isset($this->town)?'NULL':"'".$this->db->escape($this->town)."'").",";
		$sql.= " ".(! isset($this->fk_state)?'NULL':"'".$this->fk_state."'").",";
		$sql.= " ".(! isset($this->fk_country)?'NULL':"'".$this->fk_country."'").",";
		$sql.= " ".(! isset($this->job)?'NULL':"'".$this->db->escape($this->job)."'").",";
		$sql.= " ".(! isset($this->skype)?'NULL':"'".$this->db->escape($this->skype)."'").",";
		$sql.= " ".(! isset($this->office_phone)?'NULL':"'".$this->db->escape($this->office_phone)."'").",";
		$sql.= " ".(! isset($this->office_fax)?'NULL':"'".$this->db->escape($this->office_fax)."'").",";
		$sql.= " ".(! isset($this->user_mobile)?'NULL':"'".$this->db->escape($this->user_mobile)."'").",";
		$sql.= " ".(! isset($this->email)?'NULL':"'".$this->db->escape($this->email)."'").",";
		$sql.= " ".(! isset($this->signature)?'NULL':"'".$this->db->escape($this->signature)."'").",";
		$sql.= " ".(! isset($this->admin)?'NULL':"'".$this->admin."'").",";
		$sql.= " ".(! isset($this->module_comm)?'NULL':"'".$this->module_comm."'").",";
		$sql.= " ".(! isset($this->module_compta)?'NULL':"'".$this->module_compta."'").",";
		$sql.= " ".(! isset($this->fk_societe)?'NULL':"'".$this->fk_societe."'").",";
		$sql.= " ".(! isset($this->fk_socpeople)?'NULL':"'".$this->fk_socpeople."'").",";
		$sql.= " ".(! isset($this->fk_member)?'NULL':"'".$this->fk_member."'").",";
		$sql.= " ".(! isset($this->fk_user)?'NULL':"'".$this->fk_user."'").",";
		$sql.= " ".(! isset($this->note)?'NULL':"'".$this->db->escape($this->note)."'").",";
		$sql.= " ".(! isset($this->datelastlogin) || dol_strlen($this->datelastlogin)==0?'NULL':"'".$this->db->idate($this->datelastlogin)."'").",";
		$sql.= " ".(! isset($this->datepreviouslogin) || dol_strlen($this->datepreviouslogin)==0?'NULL':"'".$this->db->idate($this->datepreviouslogin)."'").",";
		$sql.= " ".(! isset($this->egroupware_id)?'NULL':"'".$this->egroupware_id."'").",";
		$sql.= " ".(! isset($this->ldap_sid)?'NULL':"'".$this->db->escape($this->ldap_sid)."'").",";
		$sql.= " ".(! isset($this->openid)?'NULL':"'".$this->db->escape($this->openid)."'").",";
		$sql.= " ".(! isset($this->statut)?'NULL':"'".$this->statut."'").",";
		$sql.= " ".(! isset($this->photo)?'NULL':"'".$this->db->escape($this->photo)."'").",";
		$sql.= " ".(! isset($this->lang)?'NULL':"'".$this->db->escape($this->lang)."'").",";
		$sql.= " ".(! isset($this->color)?'NULL':"'".$this->db->escape($this->color)."'").",";
		$sql.= " ".(! isset($this->barcode)?'NULL':"'".$this->db->escape($this->barcode)."'").",";
		$sql.= " ".(! isset($this->fk_barcode_type)?'NULL':"'".$this->fk_barcode_type."'").",";
		$sql.= " ".(! isset($this->accountancy_code)?'NULL':"'".$this->db->escape($this->accountancy_code)."'").",";
		$sql.= " ".(! isset($this->nb_holiday)?'NULL':"'".$this->nb_holiday."'").",";
		$sql.= " ".(! isset($this->thm)?'NULL':"'".$this->thm."'").",";
		$sql.= " ".(! isset($this->tjm)?'NULL':"'".$this->tjm."'").",";
		$sql.= " ".(! isset($this->salary)?'NULL':"'".$this->salary."'").",";
		$sql.= " ".(! isset($this->salaryextra)?'NULL':"'".$this->salaryextra."'").",";
		$sql.= " ".(! isset($this->weeklyhours)?'NULL':"'".$this->weeklyhours."'")."";

        
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
		$sql.= " t.ref_ext,";
		$sql.= " t.ref_int,";
		$sql.= " t.datec,";
		$sql.= " t.tms,";
		$sql.= " t.fk_user_creat,";
		$sql.= " t.fk_user_modif,";
		$sql.= " t.login,";
		$sql.= " t.pass,";
		$sql.= " t.pass_crypted,";
		$sql.= " t.pass_temp,";
		$sql.= " t.civility,";
		$sql.= " t.lastname,";
		$sql.= " t.firstname,";
		$sql.= " t.address,";
		$sql.= " t.zip,";
		$sql.= " t.town,";
		$sql.= " t.fk_state,";
		$sql.= " t.fk_country,";
		$sql.= " t.job,";
		$sql.= " t.skype,";
		$sql.= " t.office_phone,";
		$sql.= " t.office_fax,";
		$sql.= " t.user_mobile,";
		$sql.= " t.email,";
		$sql.= " t.signature,";
		$sql.= " t.admin,";
		$sql.= " t.module_comm,";
		$sql.= " t.module_compta,";
		$sql.= " t.fk_societe,";
		$sql.= " t.fk_socpeople,";
		$sql.= " t.fk_member,";
		$sql.= " t.fk_user,";
		$sql.= " t.note,";
		$sql.= " t.datelastlogin,";
		$sql.= " t.datepreviouslogin,";
		$sql.= " t.egroupware_id,";
		$sql.= " t.ldap_sid,";
		$sql.= " t.openid,";
		$sql.= " t.statut,";
		$sql.= " t.photo,";
		$sql.= " t.lang,";
		$sql.= " t.color,";
		$sql.= " t.barcode,";
		$sql.= " t.fk_barcode_type,";
		$sql.= " t.accountancy_code,";
		$sql.= " t.nb_holiday,";
		$sql.= " t.thm,";
		$sql.= " t.tjm,";
		$sql.= " t.salary,";
		$sql.= " t.salaryextra,";
		$sql.= " t.weeklyhours";

		
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
				$this->ref_ext = $obj->ref_ext;
				$this->ref_int = $obj->ref_int;
				$this->datec = $this->db->jdate($obj->datec);
				$this->tms = $this->db->jdate($obj->tms);
				$this->fk_user_creat = $obj->fk_user_creat;
				$this->fk_user_modif = $obj->fk_user_modif;
				$this->login = $obj->login;
				$this->pass = $obj->pass;
				$this->pass_crypted = $obj->pass_crypted;
				$this->pass_temp = $obj->pass_temp;
				$this->civility = $obj->civility;
				$this->lastname = $obj->lastname;
				$this->firstname = $obj->firstname;
				$this->address = $obj->address;
				$this->zip = $obj->zip;
				$this->town = $obj->town;
				$this->fk_state = $obj->fk_state;
				$this->fk_country = $obj->fk_country;
				$this->job = $obj->job;
				$this->skype = $obj->skype;
				$this->office_phone = $obj->office_phone;
				$this->office_fax = $obj->office_fax;
				$this->user_mobile = $obj->user_mobile;
				$this->email = $obj->email;
				$this->signature = $obj->signature;
				$this->admin = $obj->admin;
				$this->module_comm = $obj->module_comm;
				$this->module_compta = $obj->module_compta;
				$this->fk_societe = $obj->fk_societe;
				$this->fk_socpeople = $obj->fk_socpeople;
				$this->fk_member = $obj->fk_member;
				$this->fk_user = $obj->fk_user;
				$this->note = $obj->note;
				$this->datelastlogin = $this->db->jdate($obj->datelastlogin);
				$this->datepreviouslogin = $this->db->jdate($obj->datepreviouslogin);
				$this->egroupware_id = $obj->egroupware_id;
				$this->ldap_sid = $obj->ldap_sid;
				$this->openid = $obj->openid;
				$this->statut = $obj->statut;
				$this->photo = $obj->photo;
				$this->lang = $obj->lang;
				$this->color = $obj->color;
				$this->barcode = $obj->barcode;
				$this->fk_barcode_type = $obj->fk_barcode_type;
				$this->accountancy_code = $obj->accountancy_code;
				$this->nb_holiday = $obj->nb_holiday;
				$this->thm = $obj->thm;
				$this->tjm = $obj->tjm;
				$this->salary = $obj->salary;
				$this->salaryextra = $obj->salaryextra;
				$this->weeklyhours = $obj->weeklyhours;

                
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
		if (isset($this->ref_ext)) $this->ref_ext=trim($this->ref_ext);
		if (isset($this->ref_int)) $this->ref_int=trim($this->ref_int);
		if (isset($this->fk_user_creat)) $this->fk_user_creat=trim($this->fk_user_creat);
		if (isset($this->fk_user_modif)) $this->fk_user_modif=trim($this->fk_user_modif);
		if (isset($this->login)) $this->login=trim($this->login);
		if (isset($this->pass)) $this->pass=trim($this->pass);
		if (isset($this->pass_crypted)) $this->pass_crypted=trim($this->pass_crypted);
		if (isset($this->pass_temp)) $this->pass_temp=trim($this->pass_temp);
		if (isset($this->civility)) $this->civility=trim($this->civility);
		if (isset($this->lastname)) $this->lastname=trim($this->lastname);
		if (isset($this->firstname)) $this->firstname=trim($this->firstname);
		if (isset($this->address)) $this->address=trim($this->address);
		if (isset($this->zip)) $this->zip=trim($this->zip);
		if (isset($this->town)) $this->town=trim($this->town);
		if (isset($this->fk_state)) $this->fk_state=trim($this->fk_state);
		if (isset($this->fk_country)) $this->fk_country=trim($this->fk_country);
		if (isset($this->job)) $this->job=trim($this->job);
		if (isset($this->skype)) $this->skype=trim($this->skype);
		if (isset($this->office_phone)) $this->office_phone=trim($this->office_phone);
		if (isset($this->office_fax)) $this->office_fax=trim($this->office_fax);
		if (isset($this->user_mobile)) $this->user_mobile=trim($this->user_mobile);
		if (isset($this->email)) $this->email=trim($this->email);
		if (isset($this->signature)) $this->signature=trim($this->signature);
		if (isset($this->admin)) $this->admin=trim($this->admin);
		if (isset($this->module_comm)) $this->module_comm=trim($this->module_comm);
		if (isset($this->module_compta)) $this->module_compta=trim($this->module_compta);
		if (isset($this->fk_societe)) $this->fk_societe=trim($this->fk_societe);
		if (isset($this->fk_socpeople)) $this->fk_socpeople=trim($this->fk_socpeople);
		if (isset($this->fk_member)) $this->fk_member=trim($this->fk_member);
		if (isset($this->fk_user)) $this->fk_user=trim($this->fk_user);
		if (isset($this->note)) $this->note=trim($this->note);
		if (isset($this->egroupware_id)) $this->egroupware_id=trim($this->egroupware_id);
		if (isset($this->ldap_sid)) $this->ldap_sid=trim($this->ldap_sid);
		if (isset($this->openid)) $this->openid=trim($this->openid);
		if (isset($this->statut)) $this->statut=trim($this->statut);
		if (isset($this->photo)) $this->photo=trim($this->photo);
		if (isset($this->lang)) $this->lang=trim($this->lang);
		if (isset($this->color)) $this->color=trim($this->color);
		if (isset($this->barcode)) $this->barcode=trim($this->barcode);
		if (isset($this->fk_barcode_type)) $this->fk_barcode_type=trim($this->fk_barcode_type);
		if (isset($this->accountancy_code)) $this->accountancy_code=trim($this->accountancy_code);
		if (isset($this->nb_holiday)) $this->nb_holiday=trim($this->nb_holiday);
		if (isset($this->thm)) $this->thm=trim($this->thm);
		if (isset($this->tjm)) $this->tjm=trim($this->tjm);
		if (isset($this->salary)) $this->salary=trim($this->salary);
		if (isset($this->salaryextra)) $this->salaryextra=trim($this->salaryextra);
		if (isset($this->weeklyhours)) $this->weeklyhours=trim($this->weeklyhours);

        

		// Check parameters
		// Put here code to add a control on parameters values

        // Update request
        $sql = "UPDATE ".MAIN_DB_PREFIX.$this->table_element." SET";
        
		$sql.= " entity=".(isset($this->entity)?$this->entity:"null").",";
		$sql.= " ref_ext=".(isset($this->ref_ext)?"'".$this->db->escape($this->ref_ext)."'":"null").",";
		$sql.= " ref_int=".(isset($this->ref_int)?"'".$this->db->escape($this->ref_int)."'":"null").",";
		$sql.= " datec=".(dol_strlen($this->datec)!=0 ? "'".$this->db->idate($this->datec)."'" : 'null').",";
		$sql.= " tms=".(dol_strlen($this->tms)!=0 ? "'".$this->db->idate($this->tms)."'" : 'null').",";
		$sql.= " fk_user_creat=".(isset($this->fk_user_creat)?$this->fk_user_creat:"null").",";
		$sql.= " fk_user_modif=".(isset($this->fk_user_modif)?$this->fk_user_modif:"null").",";
		$sql.= " login=".(isset($this->login)?"'".$this->db->escape($this->login)."'":"null").",";
		$sql.= " pass=".(isset($this->pass)?"'".$this->db->escape($this->pass)."'":"null").",";
		$sql.= " pass_crypted=".(isset($this->pass_crypted)?"'".$this->db->escape($this->pass_crypted)."'":"null").",";
		$sql.= " pass_temp=".(isset($this->pass_temp)?"'".$this->db->escape($this->pass_temp)."'":"null").",";
		$sql.= " civility=".(isset($this->civility)?"'".$this->db->escape($this->civility)."'":"null").",";
		$sql.= " lastname=".(isset($this->lastname)?"'".$this->db->escape($this->lastname)."'":"null").",";
		$sql.= " firstname=".(isset($this->firstname)?"'".$this->db->escape($this->firstname)."'":"null").",";
		$sql.= " address=".(isset($this->address)?"'".$this->db->escape($this->address)."'":"null").",";
		$sql.= " zip=".(isset($this->zip)?"'".$this->db->escape($this->zip)."'":"null").",";
		$sql.= " town=".(isset($this->town)?"'".$this->db->escape($this->town)."'":"null").",";
		$sql.= " fk_state=".(isset($this->fk_state)?$this->fk_state:"null").",";
		$sql.= " fk_country=".(isset($this->fk_country)?$this->fk_country:"null").",";
		$sql.= " job=".(isset($this->job)?"'".$this->db->escape($this->job)."'":"null").",";
		$sql.= " skype=".(isset($this->skype)?"'".$this->db->escape($this->skype)."'":"null").",";
		$sql.= " office_phone=".(isset($this->office_phone)?"'".$this->db->escape($this->office_phone)."'":"null").",";
		$sql.= " office_fax=".(isset($this->office_fax)?"'".$this->db->escape($this->office_fax)."'":"null").",";
		$sql.= " user_mobile=".(isset($this->user_mobile)?"'".$this->db->escape($this->user_mobile)."'":"null").",";
		$sql.= " email=".(isset($this->email)?"'".$this->db->escape($this->email)."'":"null").",";
		$sql.= " signature=".(isset($this->signature)?"'".$this->db->escape($this->signature)."'":"null").",";
		$sql.= " admin=".(isset($this->admin)?$this->admin:"null").",";
		$sql.= " module_comm=".(isset($this->module_comm)?$this->module_comm:"null").",";
		$sql.= " module_compta=".(isset($this->module_compta)?$this->module_compta:"null").",";
		$sql.= " fk_societe=".(isset($this->fk_societe)?$this->fk_societe:"null").",";
		$sql.= " fk_socpeople=".(isset($this->fk_socpeople)?$this->fk_socpeople:"null").",";
		$sql.= " fk_member=".(isset($this->fk_member)?$this->fk_member:"null").",";
		$sql.= " fk_user=".(isset($this->fk_user)?$this->fk_user:"null").",";
		$sql.= " note=".(isset($this->note)?"'".$this->db->escape($this->note)."'":"null").",";
		$sql.= " datelastlogin=".(dol_strlen($this->datelastlogin)!=0 ? "'".$this->db->idate($this->datelastlogin)."'" : 'null').",";
		$sql.= " datepreviouslogin=".(dol_strlen($this->datepreviouslogin)!=0 ? "'".$this->db->idate($this->datepreviouslogin)."'" : 'null').",";
		$sql.= " egroupware_id=".(isset($this->egroupware_id)?$this->egroupware_id:"null").",";
		$sql.= " ldap_sid=".(isset($this->ldap_sid)?"'".$this->db->escape($this->ldap_sid)."'":"null").",";
		$sql.= " openid=".(isset($this->openid)?"'".$this->db->escape($this->openid)."'":"null").",";
		$sql.= " statut=".(isset($this->statut)?$this->statut:"null").",";
		$sql.= " photo=".(isset($this->photo)?"'".$this->db->escape($this->photo)."'":"null").",";
		$sql.= " lang=".(isset($this->lang)?"'".$this->db->escape($this->lang)."'":"null").",";
		$sql.= " color=".(isset($this->color)?"'".$this->db->escape($this->color)."'":"null").",";
		$sql.= " barcode=".(isset($this->barcode)?"'".$this->db->escape($this->barcode)."'":"null").",";
		$sql.= " fk_barcode_type=".(isset($this->fk_barcode_type)?$this->fk_barcode_type:"null").",";
		$sql.= " accountancy_code=".(isset($this->accountancy_code)?"'".$this->db->escape($this->accountancy_code)."'":"null").",";
		$sql.= " nb_holiday=".(isset($this->nb_holiday)?$this->nb_holiday:"null").",";
		$sql.= " thm=".(isset($this->thm)?$this->thm:"null").",";
		$sql.= " tjm=".(isset($this->tjm)?$this->tjm:"null").",";
		$sql.= " salary=".(isset($this->salary)?$this->salary:"null").",";
		$sql.= " salaryextra=".(isset($this->salaryextra)?$this->salaryextra:"null").",";
		$sql.= " weeklyhours=".(isset($this->weeklyhours)?$this->weeklyhours:"null")."";

        
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

		$object=new User($this->db);

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
		$this->ref_ext='';
		$this->ref_int='';
		$this->datec='';
		$this->tms='';
		$this->fk_user_creat='';
		$this->fk_user_modif='';
		$this->login='';
		$this->pass='';
		$this->pass_crypted='';
		$this->pass_temp='';
		$this->civility='';
		$this->lastname='';
		$this->firstname='';
		$this->address='';
		$this->zip='';
		$this->town='';
		$this->fk_state='';
		$this->fk_country='';
		$this->job='';
		$this->skype='';
		$this->office_phone='';
		$this->office_fax='';
		$this->user_mobile='';
		$this->email='';
		$this->signature='';
		$this->admin='';
		$this->module_comm='';
		$this->module_compta='';
		$this->fk_societe='';
		$this->fk_socpeople='';
		$this->fk_member='';
		$this->fk_user='';
		$this->note='';
		$this->datelastlogin='';
		$this->datepreviouslogin='';
		$this->egroupware_id='';
		$this->ldap_sid='';
		$this->openid='';
		$this->statut='';
		$this->photo='';
		$this->lang='';
		$this->color='';
		$this->barcode='';
		$this->fk_barcode_type='';
		$this->accountancy_code='';
		$this->nb_holiday='';
		$this->thm='';
		$this->tjm='';
		$this->salary='';
		$this->salaryextra='';
		$this->weeklyhours='';

		
	}

}
