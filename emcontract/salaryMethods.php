<?php

/* 
 * Copyright (C) 2015 delcroip <pmpdelcroix@gmail.com>
 *
 * This program is free software: you can redistribute it and/or modify
 * it under the terms of the GNU General Public License as published by
 * the Free Software Foundation, either version 3 of the License, or
 * (at your option) any later version.
 *
 * This program is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 * GNU General Public License for more details.
 *
 * You should have received a copy of the GNU General Public License
 * along with this program.  If not, see <http://www.gnu.org/licenses/>.
 */

$res=@include("../main.inc.php");
if (! $res && file_exists("../main.inc.php")) $res=@include("../main.inc.php");
if (! $res && file_exists("../../main.inc.php")) $res=@include("../../main.inc.php");
if (! $res && file_exists("../../../main.inc.php")) $res=@include("../../../main.inc.php");
if (! $res && file_exists("/var/www/dolibarr/htdocs/main.inc.php")) $res=@include "/var/www/dolibarr/htdocs/main.inc.php";     // Used on dev env only
if (! $res) die("Include of main fails");

/*-----------------------------------------------------------------------------
 * Libraries
 *-----------------------------------------------------------------------------
 */
//require_once DOL_DOCUMENT_ROOT.'/core/class/html.form.class.php';
//require_once DOL_DOCUMENT_ROOT.'/core/class/html.formother.class.php';
//require_once DOL_DOCUMENT_ROOT.'/core/lib/date.lib.php';
//require_once DOL_DOCUMENT_ROOT.'/user/class/user.class.php';
//require_once DOL_DOCUMENT_ROOT.'/emcontract/class/emcontract.class.php';
//require_once DOL_DOCUMENT_ROOT.'/core/lib/functions2.lib.php';
//require_once DOL_DOCUMENT_ROOT.'/core/lib/usergroups.lib.php';
require_once DOL_DOCUMENT_ROOT.'/emcontract/class/salaryMethod.class.php';

/*-----------------------------------------------------------------------------
 * language files
 *-----------------------------------------------------------------------------
 */
$langs->load("admin");
$langs->load("errors");
//$langs->load('users');
//$langs->load('emcontract@emcontract');

/*-----------------------------------------------------------------------------
 * Access restiction
 * -----------------------------------------------------------------------------
 */
if (!$user->admin) {
    $accessforbidden = accessforbidden("you need to be admin");           
}

/*-----------------------------------------------------------------------------
 * Get GET & POST data
 *-----------------------------------------------------------------------------
 */
$action=$_GET['action'];
$id = $_GET['id'];
$salaryMethodStatic = new salaryMethod($db,$id);
if(isset($_POST['SalaryMethod'])){
    $salaryMethodStatic->fetchFromTab(array($_POST['SalaryMethod']));
}
/*-----------------------------------------------------------------------------
 * Behaviours based on the action
 *-----------------------------------------------------------------------------
 */
switch ($action){
        case "add":
        echo showSalaryMethod(0,'new');
        break;
    case "update":
        echo showSalaryMethod($id,'readWrite');
        break;
    case "delete":
        if($id!=0){
            $salaryMethodStatic->id=$id;
            if($salaryMethodStatic->delete()==0){
                setEventMessage($langs->trans("salaryMethodDeleted"));
            }else{
                setEventMessage($langs->trans("salaryMethodNotDeleted"),'errors');
            }       
        }
        break;
    case "view":
        echo showSalaryMethod($id,'readOnly');
        break;
    case "submit":
        if ($id==0){
            if($salaryMethodStatic->create()==0){
                setEventMessage($langs->trans("salaryMethodCreated"));
            }else{
                setEventMessage($langs->trans("salaryMethodNotCreated"),'errors');
            }
        }else if($salaryMethodStatic->id==$id){
            if($salaryMethodStatic->update()==0){
                setEventMessage($langs->trans("salaryMethodUpdated"));
            }else{
                setEventMessage($langs->trans("salaryMethodNotUpdated"),'errors');
            }
        }else{
            setEventMessage($langs->trans("noValidDataFound"),'errors');
        }
        default:
            break;
}
showSalaryMethodList();
/*-----------------------------------------------------------------------------
 * Functions
 *-----------------------------------------------------------------------------
 */    

/**
*	show the html matrix 
*
*	@return		int						   0 - sucess | -1 failure
*/ 

function showSalaryMethod($id,$mode)
{
    $new=0;
    $write=0;
    
    switch($mode){
        case 'readOnly': //default
            break;
        case 'readWrite':
            $write=1;
            break;
        case 'new':
            $new=1;
            $write=1;
            break;
    }
    $form='<form>';
    //FIXME
    $form.='<form>';
    return $form;
    
}
/**
*	show the html list 
*
*	@return		int						   0 - sucess | -1 failure
*/ 
function showSalaryMethodList(){
    //FIXME
}
