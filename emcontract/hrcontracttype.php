<?php
/* 
 * Copyright (C) 2007-2010 Laurent Destailleur  <eldy@users.sourceforge.net>
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
 *   	\file       dev/skeletons/skeleton_page.php
 *		\ingroup    emcontract othermodule1 othermodule2
 *		\brief      This file is an example of a php page
 *					Initialy built by build_class_from_table on 2015-07-06 20:38
 */

//if (! defined('NOREQUIREUSER'))  define('NOREQUIREUSER','1');
//if (! defined('NOREQUIREDB'))    define('NOREQUIREDB','1');
//if (! defined('NOREQUIRESOC'))   define('NOREQUIRESOC','1');
//if (! defined('NOREQUIRETRAN'))  define('NOREQUIRETRAN','1');
//if (! defined('NOCSRFCHECK'))    define('NOCSRFCHECK','1');			// Do not check anti CSRF attack test
//if (! defined('NOSTYLECHECK'))   define('NOSTYLECHECK','1');			// Do not check style html tag into posted data
//if (! defined('NOTOKENRENEWAL')) define('NOTOKENRENEWAL','1');		// Do not check anti POST attack test
//if (! defined('NOREQUIREMENU'))  define('NOREQUIREMENU','1');			// If there is no need to load and show top and left menu
//if (! defined('NOREQUIREHTML'))  define('NOREQUIREHTML','1');			// If we don't need to load the html.form.class.php
//if (! defined('NOREQUIREAJAX'))  define('NOREQUIREAJAX','1');
//if (! defined("NOLOGIN"))        define("NOLOGIN",'1');				// If this page is public (can be called outside logged session)

// Change this following line to use the correct relative path (../, ../../, etc)
$res=0;
if (! $res && file_exists("../main.inc.php")) $res=@include '../main.inc.php';					// to work if your module directory is into dolibarr root htdocs directory
if (! $res && file_exists("../../main.inc.php")) $res=@include '../../main.inc.php';			// to work if your module directory is into a subdir of root htdocs directory
if (! $res && file_exists("../../../dolibarr/htdocs/main.inc.php")) $res=@include '../../../dolibarr/htdocs/main.inc.php';     // Used on dev env only
if (! $res && file_exists("/var/www/dolibarr/htdocs/main.inc.php")) $res=@include '/var/www/dolibarr/htdocs/main.inc.php';   // Used on dev env only
if (! $res) die("Include of main fails");
// Change this following line to use the correct relative path from htdocs
//include_once(DOL_DOCUMENT_ROOT.'/core/class/formcompany.class.php');
dol_include_once('/emcontract/class/hrcontracttype.class.php');
dol_include_once('/core/lib/functions2.lib.php');
//document handling
dol_include_once('/core/lib/files.lib.php');
//dol_include_once('/core/lib/images.lib.php');
dol_include_once('/core/class/html.formfile.class.php');
dol_include_once('/core/class/html.formother.class.php');
// include conditionnally of the dolibarr version
//if((version_compare(DOL_VERSION, "3.8", "<"))){
        dol_include_once("/emcontract/lib/emcontract.lib.php");
//}

// Load traductions files requiredby by page
//$langs->load("companies");
$langs->load("Hrcontracttype_class");

// Get parameters
$id			= GETPOST('id','int');
$ref                    = GETPOST('ref','alpha');
$action		= GETPOST('action','alpha');
$backtopage = GETPOST('backtopage');
$cancel=GETPOST('cancel');
$confirm=GETPOST('confirm');
$tms= GETPOST('tms','alpha');
//// Get parameters
$removefilter=isset($_POST["removefilter_x"]);//|| isset($_POST["removefilter"]);
$applyfilter=isset($_POST["search_x"]) ;//|| isset($_POST["search"]);



if (!$removefilter && $applyfilter)		// Both test must be present to be compatible with all browsers
{
    $listsearch=isset($_POST['listsearch'])?$_POST['listsearch']:'';

    $ls_rowid=GETPOST('ls_rowid','int');
    $ls_description=GETPOST('ls_description','apha');
    $ls_date_creation_month=GETPOST('ls_date_creation_month','int');
    $ls_date_creation_year=GETPOST('ls_date_creation_year','int');
    $ls_type_contract=GETPOST('ls_type_contract','int');
    
}
$sortfield = GETPOST('sortfield','alpha'); //FIXME, need to use for all the list
$sortorder = GETPOST('sortorder','alpha');//FIXME, need to use for all the list
$page = GETPOST('page','int'); //FIXME, need to use for all the list
if ($page == -1) { $page = 0; }
$offset = $conf->liste_limit * $page;
$pageprev = $page - 1;
$pagenext = $page + 1;


$upload_dir = $conf->emcontract->dir_output.'/Hrcontracttype/'.dol_sanitizeFileName($object->ref);


 // uncomment to avoid resubmision
//if(isset( $_SESSION['Hrcontracttype_class'][$tms]))
//{

 //   $cancel=TRUE;
 //  setEventMessages('Internal error, POST not exptected', null, 'errors');
//}



// Right Management
 /*
if ($user->societe_id > 0 || 
       (!$user->rights->emcontract->add && ($action=='add' || $action='create')) ||
       (!$user->rights->emcontract->view && ($action=='list' || $action='view')) ||
       (!$user->rights->emcontract->delete && ($action=='confirm_delete')) ||
       (!$user->rights->emcontract->edit && ($action=='edit' || $action='update')))
{
	accessforbidden();
}
*/

// create object and set id or ref if provided as parameter
$object=new Hrcontracttype($db);
if($id>0)
{
    $object->id=$id; 
}
if(!empty($ref))
{
    $object->ref=$ref; 
}


/*******************************************************************
* ACTIONS
*
* Put here all code to do according to value of "action" parameter
********************************************************************/

// Action to add record
$error=0;
if ($cancel){
        reloadpage($backtopage,$id,$ref);
}else if(($action == 'create') || ($action == 'edit' && ($id>0 || !empty($ref)))){
    $tms=time();
    $_SESSION['Hrcontracttype_'.$tms]=array();
    $_SESSION['Hrcontracttype_'.$tms]['action']=$action;
            
}else if (($action == 'add') || ($action == 'update' && ($id>0 || !empty($ref))))
{
        //block resubmit
        if(empty($tms) || (!isset($_SESSION['Hrcontracttype_'.$tms]))){
                setEventMessages(null,'WrongTimeStamp_requestNotExpected', 'errors');
                $action=($action=='add')?'create':'edit';
        }
        //retrive the data
        		$object->rowid=GETPOST("Rowid");
		$object->entity=GETPOST("Entity");
		$object->type_contract=GETPOST("Typecontract");
		$object->title=GETPOST("Title");
		$object->description=GETPOST("Description");
		$object->employee_status=GETPOST("Employeestatus");
		$object->weekly_hours=GETPOST("Weeklyhours");
		$object->modulation_period=GETPOST("Modulationperiod");
		$object->working_days=GETPOST("Workingdays");
		$object->normal_rate_days=GETPOST("Normalratedays");
		$object->daily_hours=GETPOST("Dailyhours");
		$object->night_hours_start=GETPOST("Nighthoursstart");
		$object->night_rate=GETPOST("Nightrate");
		$object->night_hours_stop=GETPOST("Nighthoursstop");
		$object->holiday_weekly_generated=GETPOST("Holidayweeklygenerated");
		$object->overtime_rate=GETPOST("Overtimerate");
		$object->overtime_recup_only=GETPOST("Overtimerecuponly");
		$object->weekly_max_hours=GETPOST("Weeklymaxhours");
		$object->weekly_min_hours=GETPOST("Weeklyminhours");
		$object->daily_max_hours=GETPOST("Dailymaxhours");
		$object->salary_method=GETPOST("Salarymethod");
		$object->sm_custom_field_1_value=GETPOST("Smcustomfield1value");
		$object->sm_custom_field_2_value=GETPOST("Smcustomfield2value");

        
        
// test here if the post data is valide
 /*
 if($object->prop1==0 || $object->prop2==0) 
 {
     if ($id>0 || $ref!='')
        $action='create';
     else
        $action='edit';
 }
  */
        
 }else if ($id==0 && $ref=="" && $action!="create") 
 {
     $action="list";
 }
 
 
  switch($action){		
                    case 'update':
                            $result=$object->update($user);
                            if ($result > 0)
                            {
                                // Creation OK
                                unset($_SESSION['Hrcontracttype_'.$tms]);
                                    setEventMessages('hrcontractfullyUpdated',null, 'mesgs');
                                    reloadpage($backtopage,$result,$ref); 
                            }
                            else
                            {
                                    // Creation KO
                                    if (! empty($object->errors)) setEventMessages(null, $object->errors, 'errors');
                                    else setEventMessages($object->error, null, 'errors');
                                    $action='edit';
                            }
                    case 'delete':
                        if(isset($_GET['urlfile'])) $action='deletefile';
                    case 'view':
                    case 'viewinfo':
                    case 'viewdoc':
                    case 'edit':
                            // fetch the object data if possible
                            if ($id > 0 || !empty($ref) )
                            {
                                    $result=$object->fetch($id,$ref);
                                    if ($result < 0){ 
                                        dol_print_error($db);
                                    }else { // fill the id & ref
                                        if(isset($object->id))$id = $object->id;
                                        if(isset($object->rowid))$id = $object->rowid;
                                        if(isset($object->ref))$ref = $object->ref;
                                    }
                               
                            }else
                            {
                                    setEventMessage( $langs->trans("noIdPresent")." id:".$id,'errors');
                                    $action='list';
                            }
                            break;
                    case 'add':
                            $result=$object->create($user);
                            if ($result > 0)
                            {
                                    // Creation OK
                                // remove the tms
                                   unset($_SESSION['Hrcontracttype_'.$tms]);
                                   setEventMessages('hrcontractSucessfullyCreated',null, 'mesgs');
                                   reloadpage($backtopage,$result,$ref);
                                    
                            }else
                            {
                                    // Creation KO
                                    if (! empty($object->errors)) setEventMessages(null, $object->errors, 'errors');
                                    else  setEventMessages($object->error, null, 'errors');
                                    $action='create';
                            }                            
                            break;

                     case 'confirm_delete':
                            
                            $result=($confirm=='yes')?$object->delete($user):0;
                            if ($result > 0)
                            {
                                    // Delete OK
                                    setEventMessages($langs->trans("RecordDeleted"), null, 'mesgs');
                                    $action='list';
                                    
                            }
                            else
                            {
                                    // Delete NOK
                                    if (! empty($object->errors)) setEventMessages(null,$object->errors,'errors');
                                    else setEventMessages($object->error,null,'errors');
                                    $action='list';
                            }
                         break;
                    case 'list':
                    case 'create':
                    default:
                        //document handling
                        include_once DOL_DOCUMENT_ROOT . '/core/tpl/document_actions_pre_headers.tpl.php';
                        if(isset($_GET['urlfile'])) $action='viewdoc';
                            break;
            }             
//Removing the tms array so the order can't be submitted two times
if(isset( $_SESSION['Hrcontracttype_class'][$tms]))
{
    unset($_SESSION['Hrcontracttype_class'][$tms]);
}

/***************************************************
* VIEW
*
* Put here all code to build page
****************************************************/

llxHeader('','Hrcontracttype','');
print "<div> <!-- module body-->";
$form=new Form($db);
$formother=new FormOther($db);


// Put here content of your page

// Example : Adding jquery code
print '<script type="text/javascript" language="javascript">
jQuery(document).ready(function() {
	function init_myfunc()
	{
		jQuery("#myid").removeAttr(\'disabled\');
		jQuery("#myid").attr(\'disabled\',\'disabled\');
	}
	init_myfunc();
	jQuery("#mybutton").click(function() {
		init_needroot();
	});
});
</script>';
$edit=0;
print_fiche_titre($langs->trans('Hrcontracttype'));

switch ($action) {
    case "create":
        $new=1;
    case "edit":
        $edit=1;
   case "delete";
        if( $action=='delete' && ($id>0 || $ref!="")){
         $ret=$form->form_confirm($_SERVER["PHP_SELF"].'?action=confirm_delete&id='.$id,$langs->trans("DeleteHrcontracttype"),$langs->trans("ConfirmDelete"),"confirm_delete", '', 0, 1);
         if ($ret == 'html') print '<br />';
         //to have the object to be deleted in the background\
        }
    case "view":
    {
        	// tabs
        if($edit==0 && $new==0){ //show tabs
            $head=Hrcontracttype_prepare_head($object);
            dol_fiche_head($head,'card',$langs->trans("Hrcontracttype"),0,'emcontract@emcontract');            
        }
	print '<br>';

        if($edit==1){
            if($new==1){
                print '<form method="POST" action="'.$_SERVER["PHP_SELF"].'?action=add">';
            }else{
                print '<form method="POST" action="'.$_SERVER["PHP_SELF"].'?action=update&id='.$id.'">';
            }
                        
            print '<input type="hidden" name="tms" value="'.$tms.'">';
            print '<input type="hidden" name="backtopage" value="'.$backtopage.'">';

        }else {// shoz the nqv bar
            $basedurltab=explode("?", $PHP_SELF);
            $basedurl=$basedurltab[0].'?action=list';
            $linkback = '<a href="'.$basedurl.(! empty($socid)?'?socid='.$socid:'').'">'.$langs->trans("BackToList").'</a>';
            if(!isset($object->ref))//save ref if any
                $object->ref=$object->id;
            print $form->showrefnav($object, 'action=view&id', $linkback, 1, 'rowid', 'ref', '');
            //reloqd the ref

        }

	print '<table class="border centpercent">'."\n";

            
		print "<tr>\n";

// show the field entity

		print "<td class='fieldrequired'>".$langs->trans('Entity')." </td><td>";
		if($edit==1){
		if ($new==1)
			print '<input type="text" value="1" name="Entity">';
		else
				print '<input type="text" value="'.$object->entity.'" name="Entity">';
		}else{
			print $object->entity;
		}
		print "</td>";

// show the field type_contract

		print "<td class='fieldrequired'>".$langs->trans('Typecontract')." </td><td>";
		if($edit==1){
			print '<input type="text" value="'.$object->type_contract.'" name="Typecontract">';
		}else{
			print $object->type_contract;
		}
		print "</td>";
		print "\n</tr>\n";
		print "<tr>\n";

// show the field title

		print "<td class='fieldrequired'>".$langs->trans('Title')." </td><td>";
		if($edit==1){
			print '<input type="text" value="'.$object->title.'" name="Title">';
		}else{
			print $object->title;
		}
		print "</td>";

// show the field description

		print "<td class='fieldrequired'>".$langs->trans('Description')." </td><td>";
		if($edit==1){
			print '<input type="text" value="'.$object->description.'" name="Description">';
		}else{
			print $object->description;
		}
		print "</td>";
		print "\n</tr>\n";
		print "<tr>\n";

// show the field employee_status

		print "<td class='fieldrequired'>".$langs->trans('Employeestatus')." </td><td>";
		if($edit==1){
			print '<input type="text" value="'.$object->employee_status.'" name="Employeestatus">';
		}else{
			print $object->employee_status;
		}
		print "</td>";

// show the field weekly_hours

		print "<td>".$langs->trans('Weeklyhours')." </td><td>";
		if($edit==1){
			print '<input type="text" value="'.$object->weekly_hours.'" name="Weeklyhours">';
		}else{
			print $object->weekly_hours;
		}
		print "</td>";
		print "\n</tr>\n";
		print "<tr>\n";

// show the field modulation_period

		print "<td>".$langs->trans('Modulationperiod')." </td><td>";
		if($edit==1){
			print '<input type="text" value="'.$object->modulation_period.'" name="Modulationperiod">';
		}else{
			print $object->modulation_period;
		}
		print "</td>";

// show the field working_days

		print "<td>".$langs->trans('Workingdays')." </td><td>";
		if($edit==1){
		if ($new==1)
			print '<input type="text" value="31" name="Workingdays">';
		else
				print '<input type="text" value="'.$object->working_days.'" name="Workingdays">';
		}else{
			print $object->working_days;
		}
		print "</td>";
		print "\n</tr>\n";
		print "<tr>\n";

// show the field normal_rate_days

		print "<td>".$langs->trans('Normalratedays')." </td><td>";
		if($edit==1){
		if ($new==1)
			print '<input type="text" value="31" name="Normalratedays">';
		else
				print '<input type="text" value="'.$object->normal_rate_days.'" name="Normalratedays">';
		}else{
			print $object->normal_rate_days;
		}
		print "</td>";

// show the field daily_hours

		print "<td>".$langs->trans('Dailyhours')." </td><td>";
		if($edit==1){
		if ($new==1)
			print '<input type="text" value="8.000" name="Dailyhours">';
		else
				print '<input type="text" value="'.$object->daily_hours.'" name="Dailyhours">';
		}else{
			print $object->daily_hours;
		}
		print "</td>";
		print "\n</tr>\n";
		print "<tr>\n";

// show the field night_hours_start

		print "<td>".$langs->trans('Nighthoursstart')." </td><td>";
		if($edit==1){
		if ($new==1)
			print '<input type="text" value="21:00:00" name="Nighthoursstart">';
		else
				print '<input type="text" value="'.$object->night_hours_start.'" name="Nighthoursstart">';
		}else{
			print $object->night_hours_start;
		}
		print "</td>";

// show the field night_rate

		print "<td>".$langs->trans('Nightrate')." </td><td>";
		if($edit==1){
		if ($new==1)
			print '<input type="text" value="1.500" name="Nightrate">';
		else
				print '<input type="text" value="'.$object->night_rate.'" name="Nightrate">';
		}else{
			print $object->night_rate;
		}
		print "</td>";
		print "\n</tr>\n";
		print "<tr>\n";

// show the field night_hours_stop

		print "<td>".$langs->trans('Nighthoursstop')." </td><td>";
		if($edit==1){
		if ($new==1)
			print '<input type="text" value="06:00:00" name="Nighthoursstop">';
		else
				print '<input type="text" value="'.$object->night_hours_stop.'" name="Nighthoursstop">';
		}else{
			print $object->night_hours_stop;
		}
		print "</td>";

// show the field holiday_weekly_generated

		print "<td>".$langs->trans('Holidayweeklygenerated')." </td><td>";
		if($edit==1){
		if ($new==1)
			print '<input type="text" value="0.500" name="Holidayweeklygenerated">';
		else
				print '<input type="text" value="'.$object->holiday_weekly_generated.'" name="Holidayweeklygenerated">';
		}else{
			print $object->holiday_weekly_generated;
		}
		print "</td>";
		print "\n</tr>\n";
		print "<tr>\n";

// show the field overtime_rate

		print "<td>".$langs->trans('Overtimerate')." </td><td>";
		if($edit==1){
		if ($new==1)
			print '<input type="text" value="1.250" name="Overtimerate">';
		else
				print '<input type="text" value="'.$object->overtime_rate.'" name="Overtimerate">';
		}else{
			print $object->overtime_rate;
		}
		print "</td>";

// show the field overtime_recup_only

		print "<td>".$langs->trans('Overtimerecuponly')." </td><td>";
		if($edit==1){
		if ($new==1)
			print '<input type="text" value="1" name="Overtimerecuponly">';
		else
				print '<input type="text" value="'.$object->overtime_recup_only.'" name="Overtimerecuponly">';
		}else{
			print $object->overtime_recup_only;
		}
		print "</td>";
		print "\n</tr>\n";
		print "<tr>\n";

// show the field weekly_max_hours

		print "<td>".$langs->trans('Weeklymaxhours')." </td><td>";
		if($edit==1){
		if ($new==1)
			print '<input type="text" value="48.000" name="Weeklymaxhours">';
		else
				print '<input type="text" value="'.$object->weekly_max_hours.'" name="Weeklymaxhours">';
		}else{
			print $object->weekly_max_hours;
		}
		print "</td>";

// show the field weekly_min_hours

		print "<td>".$langs->trans('Weeklyminhours')." </td><td>";
		if($edit==1){
		if ($new==1)
			print '<input type="text" value="16.000" name="Weeklyminhours">';
		else
				print '<input type="text" value="'.$object->weekly_min_hours.'" name="Weeklyminhours">';
		}else{
			print $object->weekly_min_hours;
		}
		print "</td>";
		print "\n</tr>\n";
		print "<tr>\n";

// show the field daily_max_hours

		print "<td>".$langs->trans('Dailymaxhours')." </td><td>";
		if($edit==1){
		if ($new==1)
			print '<input type="text" value="12.000" name="Dailymaxhours">';
		else
				print '<input type="text" value="'.$object->daily_max_hours.'" name="Dailymaxhours">';
		}else{
			print $object->daily_max_hours;
		}
		print "</td>";

// show the field salary_method

		print "<td>".$langs->trans('Salarymethod')." </td><td>";
		if($edit==1){
		print select_generic($db,'hr_salary_method','rowid','Salarymethod','rowid','description',$object->salary_method);
		}else{
		print print_generic($db,'hr_salary_method','rowid',$object->salary_method,'rowid','description');
		}
		print "</td>";
		print "\n</tr>\n";
		print "<tr>\n";

// show the field sm_custom_field_1_value

		print "<td>".$langs->trans('Smcustomfield1value')." </td><td>";
		if($edit==1){
			print '<input type="text" value="'.$object->sm_custom_field_1_value.'" name="Smcustomfield1value">';
		}else{
			print $object->sm_custom_field_1_value;
		}
		print "</td>";

// show the field sm_custom_field_2_value

		print "<td>".$langs->trans('Smcustomfield2value')." </td><td>";
		if($edit==1){
			print '<input type="text" value="'.$object->sm_custom_field_2_value.'" name="Smcustomfield2value">';
		}else{
			print $object->sm_custom_field_2_value;
		}
		print "</td>";
		print "\n</tr>\n";

            

	print '</table>'."\n";
	print '<br>';
	print '<div class="center">';
        if($edit==1){
        if($new==1){
                print '<input type="submit" class="button" name="add" value="'.$langs->trans("Create").'">';
            }else{
                print '<input type="submit" name="update" value="'.$langs->trans("Update").'" class="button">';
            }
            print ' &nbsp; <input type="submit" class="button" name="cancel" value="'.$langs->trans("Cancel").'"></div>';
            print '</form>';
        }else{
            $parameters=array();
            $reshook=$hookmanager->executeHooks('addMoreActionsButtons',$parameters,$object,$action);    // Note that $action and $object may have been modified by hook
            if ($reshook < 0) setEventMessages($hookmanager->error, $hookmanager->errors, 'errors');

            if (empty($reshook))
            {
                print '<div class="tabsAction">';

                // Boutons d'actions
                //if($user->rights->Hrcontracttype->edit)
                //{
                    print '<a href="'.$_SERVER["PHP_SELF"].'?id='.$id.'&action=edit" class="butAction">'.$langs->trans("Update").'</a>';
                //}
                
                //if ($user->rights->Hrcontracttype->delete)
                //{
                    print '<a class="butActionDelete" href="'.$_SERVER["PHP_SELF"].'?id='.$id.'&action=delete">'.$langs->trans('Delete').'</a>';
                //}
                //else
                //{
                //    print '<a class="butActionRefused" href="#" title="'.dol_escape_htmltag($langs->trans("NotAllowed")).'">'.$langs->trans('Delete').'</a>';
                //}
                    
                print '</div>';
            }
        }
        break;
    }
        case 'viewinfo':
        $head=Hrcontracttype_prepare_head($object);
        dol_fiche_head($head,'info',$langs->trans("Hrcontracttype"),0,'emcontract@emcontract');            
        print '<table width="100%"><tr><td>';
        dol_print_object_info($object);
        print '</td></tr></table>';
        print '</div>';
        break;
    case 'deletefile':
        $action='delete';
    case 'viewdoc':
        if (! $sortorder) $sortorder="ASC";
        if (! $sortfield) $sortfield="name";
	$object->fetch_thirdparty();

        $head=Hrcontracttype_prepare_head($object);
        dol_fiche_head($head,'documents',$langs->trans("Hrcontracttype"),0,'emcontract@emcontract');            
        
        $filearray=dol_dir_list($upload_dir,"files",0,'','\.meta$',$sortfield,(strtolower($sortorder)=='desc'?SORT_DESC:SORT_ASC),1);
	$totalsize=0;
	foreach($filearray as $key => $file)
	{
		$totalsize+=$file['size'];
	}
        print '<table class="border" width="100%">';
        $linkback = '<a href="'.$_SERVER["PHP_SELF"].(! empty($socid)?'?socid='.$socid:'').'">'.$langs->trans("BackToList").'</a>';
  	// Ref
  	print '<tr><td width="30%">'.$langs->trans("Ref").'</td><td>';
  	print $form->showrefnav($object, 'id', $linkback, 1, 'rowid', 'ref', '');
  	print '</td></tr>';
	// Societe
	//print "<tr><td>".$langs->trans("Company")."</td><td>".$object->client->getNomUrl(1)."</td></tr>";
        print '<tr><td>'.$langs->trans("NbOfAttachedFiles").'</td><td colspan="3">'.count($filearray).'</td></tr>';
        print '<tr><td>'.$langs->trans("TotalSizeOfAttachedFiles").'</td><td colspan="3">'.$totalsize.' '.$langs->trans("bytes").'</td></tr>';
        print '</table>';

        print '</div>';

        $modulepart = 'emcontract';
        $permission = $user->rights->emcontract->add;
        $param = '&id='.$object->id;
        include_once DOL_DOCUMENT_ROOT . '/core/tpl/document_actions_post_headers.tpl.php';

        
        break;
    case "delete";
        if( ($id>0 || $ref!="")){
         $ret=$form->form_confirm($_SERVER["PHP_SELF"].'?action=confirm_delete&id='.$id,$langs->trans("DeleteHrcontracttype"),$langs->trans("ConfirmDelete"),"confirm_delete", '', 0, 1);
         if ($ret == 'html') print '<br />';
         //to have the object to be deleted in the background        
        }
    case 'list':
    default:
        {
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

    
    $sql.= " FROM ".MAIN_DB_PREFIX."hr_contract_type as t";
    $sql.= " WHERE t.entity = ".$conf->entity;
    if ($filter && $filter != -1)		// GETPOST('filtre') may be a string
    {
            $filtrearr = explode(",", $filter);
            foreach ($filtrearr as $fil)
            {
                    $filt = explode(":", $fil);
                    $sql .= " AND " . $filt[0] . " = " . $filt[1];
            }
    }
    if ($ls_rowid)
    {
             $sql .= natural_search(array('t.rowid'), $ls_rowid);
    }
    if ($ls_description)
    {
             $sql .= natural_search('t.description', $ls_description);
    }
    if ($ls_date_creation_month)
    {

             $sql .= ' AND MONTH(t.date_creation)="'.$ls_date_creation_month.'"';
    }
    if ($ls_date_creation_year)
    {

             $sql .= ' AND YEAR(t.date_creation)="'.$ls_date_creation_year.'"';
    }
    if ($ls_type_contract)
    {
             $sql .= natural_search('t.type_contract', $ls_type_contract);
    }

    $nbtotalofrecords = 0;
  
    if (empty($conf->global->MAIN_DISABLE_FULL_SCANLIST))
    {
            $result = $db->query($sql);
            $nbtotalofrecords = $db->num_rows($result);
    }

    if(!empty($sortfield)){
        $sql.= $db->order($sortfield,$sortorder);
    }else{
          $sortorder = 'ASC';
    }
    
    
    if(!empty($limit)){
        $sql.= $db->plimit($limit+1, $offset);      
    }

//    $sql.= " WHERE field3 = 'xxx'";
//    $sql.= " ORDER BY field1 ASC";

    dol_syslog($script_file, LOG_DEBUG);
    $resql=$db->query($sql);
    if ($resql)
    {
   
    if (!empty($ls_rowid) )	$param.='&ls_rowid'.urlencode($ls_rowid);
    if (!empty($ls_description))      	$param.='&ls_description='.urlencode($ls_description);
    if (!empty($ls_date_creation_month))      	$param.='&ls_date_creation_month='.urlencode($ls_date_creation_month);
    if (!empty($ls_date_creation_year))	$param.='&ls_date_creation_year='.urlencode($ls_date_creation_year);
    if (!empty($ls_type_contract))	$param.='&ls_type_contract='.urlencode($ls_type_contract);
    if ($filter && $filter != -1) $param.='&filtre='.urlencode($filter);

    //print_barre_liste($langs->trans("Hrcontracttype"),$page,$_SERVER["PHP_SELF"],$param,$sortfield,$sortorder,'',$num,$nbtotalofrecords);
    print '<form method="POST" action="'.$_SERVER["PHP_SELF"].'">';
    print '<table class="liste" width="100%">'."\n";
    print '<tr class="liste_titre">';
    print_liste_field_titre($langs->trans("rowid"),$_SERVER["PHP_SELF"],"t.rowid","",$param,"align='left'",$sortfield,$sortorder);
    print "\n";
    print_liste_field_titre($langs->trans('description'),$_SERVER["PHP_SELF"],'t.description','',$param,'',$sortfield,$sortorder);
    print "\n";
    print_liste_field_titre($langs->trans('date_creation'),$_SERVER["PHP_SELF"],'t.date_creation','',$param,'',$sortfield,$sortorder);
    print "\n";
    print_liste_field_titre($langs->trans('type_contract'),$_SERVER["PHP_SELF"],'t.type_contract','',$param,'',$sortfield,$sortorder);
    print "\n";
    //print '<td class="liste_titre">&nbsp;</td>';
    print '</tr>';  
      // Filters FIXME
    print '<tr class="liste_titre">'; 
    //rowid
        print '<td class="liste_titre" align="left">';
    print '<input class="flat" size="5" type="text" name="ls_rowid" value="'.$ls_rowid.'">';
    print '</td>';
    //description
        print '<td class="liste_titre" >';
    print '<input class="flat" size="20" type="text" name="ls_description" value="'.$ls_description.'">';
    print '</td>';
    //date_creation
    print '<td class="liste_titre" colspan="1" >';
    print '<input class="flat" type="text" size="1" maxlength="2" name="ls_date_creation_month" value="'.$ls_date_creation_month.'">';
    $syear = $ls_date_creation_year;
    $formother->select_year($syear?$syear:-1,'ls_date_creation_year',1, 20, 5);
    print '</td>';
    //type_contract
        print '<td class="liste_titre" >';
    print '<input class="flat" size="16" type="text" name="ls_type_contract" value="'.$ls_type_contract.'">';
    //print '</td>';
    //print '<td class="liste_titre">';
    print '<input type="image" class="liste_titre" name="search" src="'.img_picto($langs->trans("Search"),'search.png','','',1).'" value="'.dol_escape_htmltag($langs->trans("Search")).'" title="'.dol_escape_htmltag($langs->trans("Search")).'">';
    print '<input type="image" class="liste_titre" name="removefilter" src="'.img_picto($langs->trans("Search"),'searchclear.png','','',1).'" value="'.dol_escape_htmltag($langs->trans("RemoveFilter")).'" title="'.dol_escape_htmltag($langs->trans("RemoveFilter")).'">';
    
    print '</td>';
    print '</tr>'."\n"; 
        
        
        
        
        
        
        
       $i=0;
        $num = $db->num_rows($resql);
        while ($i < $num)
        {
            $obj = $db->fetch_object($resql);
            if ($obj)
            {
                // You can use here results
                print "<tr class=\"".(($i%2==0)?'pair':'impair')."\" >";
		
		print "<td align='left'>".$object->getNomUrl($obj->rowid,$obj->rowid,'',1)."</td>";
		print "<td>".$obj->description."</td>";
		print "<td>".dol_print_date($db->jdate($obj->date_creation,'day'))."</td>";
		print "<td>".$obj->type_contract."</td>";
		print "</tr>\n";

                

            }
            $i++;
        }
    }
    else
    {
        $error++;
        dol_print_error($db);
    }

    print '</table>'."\n</form>\n";
}
        break;
}
dol_fiche_end();

function reloadpage($backtopage,$id,$ref){
        if (!empty($backtopage)){
            header("Location: ".$backtopage);            
        }else if (!empty($ref) ){
            header("Location: ".$_SERVER["PHP_SELF"].'?action=view&ref='.$id);
        }else if ($id>0)
        {
            header("Location: ".$_SERVER["PHP_SELF"].'?action=view&id='.$id);
        }else{
            header("Location: ".$_SERVER["PHP_SELF"].'?action=list');

        }

}
function Hrcontracttype_prepare_head($object)
{
    global $langs, $conf, $user;
    $h = 0;
    $head = array();

    $head[$h][0] = $_SERVER["PHP_SELF"].'?action=view&id='.$object->id;
    $head[$h][1] = $langs->trans("Card");
    $head[$h][2] = 'card';
    $h++;

    // Show more tabs from modules
    // Entries must be declared in modules descriptor with line
    // $this->tabs = array('entity:+tabname:Title:@emcontract:/emcontract/mypage.php?id=__ID__');   to add new tab
    // $this->tabs = array('entity:-tabname);   												to remove a tab
    complete_head_from_modules($conf,$langs,$object,$head,$h,'emcontract');
    complete_head_from_modules($conf,$langs,$object,$head,$h,'emcontract','remove');
    $head[$h][0] = $_SERVER["PHP_SELF"].'?action=viewdoc&id='.$object->id;
    $head[$h][1] = $langs->trans("Documents");
    $head[$h][2] = 'documents';
    $h++;
    
    $head[$h][0] = $_SERVER["PHP_SELF"].'?action=viewinfo&id='.$object->id;
    $head[$h][1] = $langs->trans("Info");
    $head[$h][2] = 'info';
    $h++;

    return $head;
}
// End of page
llxFooter();
$db->close();
