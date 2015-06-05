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
 *   	\file       dev/skeletons/skeleton.php
 *		\ingroup    emcontract othermodule1 othermodule2
 *		\brief      This file is an example of a php page
 *					Initialy built by build_class_from_table on 2015-06-05 20:12
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
dol_include_once('/emcontract/class/hruserskills.class.php');
dol_include_once('/core/lib/functions2.lib.php');
//document handling
dol_include_once('/core/lib/files.lib.php');
//dol_include_once('/core/lib/images.lib.php');
dol_include_once('/core/class/html.formfile.class.php');



// Load traductions files requiredby by page
//$langs->load("companies");
$langs->load("Hruserskills_class");

// Get parameters
$id			= GETPOST('id','int');
$ref                    = GETPOST('ref','alpha');
$action		= GETPOST('action','alpha');
$backtopage = GETPOST('backtopage');
$cancel=GETPOST('cancel');
$confirm=GETPOST('confirm');
$tms= GETPOST('tms','alpha');
//// Get parameters
$sortfield = GETPOST('sortfield','alpha'); //FIXME, need to use for all the list
$sortorder = GETPOST('sortorder','alpha');//FIXME, need to use for all the list
$page = GETPOST('page','int'); //FIXME, need to use for all the list
if ($page == -1) { $page = 0; }
$offset = $conf->liste_limit * $page;
$pageprev = $page - 1;
$pagenext = $page + 1;


$upload_dir = $conf->emcontract->dir_output.'/Hruserskills/'.dol_sanitizeFileName($object->ref);


 // uncomment to avoid resubmision
//if(isset( $_SESSION['Hruserskills_class'][$tms]))
//{

 //   $cancel=TRUE;
 //  setEventMessages('Internal error, POST not exptected', null, 'errors');
//}
 $tms= time();
 $_SESSION['Hruserskills_class'][$tms]= array();


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
$object=new Hruserskills($db);
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
}else if (($action == 'add') || ($action == 'update' && ($id>0 || !empty($ref))))
{
        //retrive the data
        		$object->rowid=GETPOST("Rowid");
		$object->entity=GETPOST("Entity");
		$object->user=GETPOST("User");
		$object->skill=GETPOST("Skill");

        
        
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
                                    setEventMessages('hrcontractfullyUpdated',null, 'mesgs');
                                    reloadpage($backtopage,$id,$ref); 
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
                                    if ($result < 0) dol_print_error($db);
                               
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
                                   setEventMessages('hrcontractSucessfullyCreated',null, 'mesgs');
                                   reloadpage($backtopage,$id,$ref);
                                    
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
if(isset( $_SESSION['Hruserskills_class'][$tms]))
{
    unset($_SESSION['Hruserskills_class'][$tms]);
}

/***************************************************
* VIEW
*
* Put here all code to build page
****************************************************/

llxHeader('','Hruserskills','');

$form=new Form($db);


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
switch ($action) {
    case "create":
        $new=1;
    case "edit":
        $edit=1;
   case "delete";
        if( $action=='delete' && ($id>0 || $ref!="")){
         $ret=$form->form_confirm($_SERVER["PHP_SELF"].'?action=confirm_delete&id='.$id,$langs->trans("DeleteHruserskills"),$langs->trans("ConfirmDelete"),"confirm_delete", '', 0, 1);
         if ($ret == 'html') print '<br />';
         //to have the object to be deleted in the background\
        }
    case "view":
    {
        //print_fiche_titre($langs->trans('Hruserskills'));
        	// tabs
        if($edit==0 && $new==0){ //show tabs
            $head=Hruserskills_prepare_head($object);
            dol_fiche_head($head,'card',$langs->trans("Hruserskills"),0,'emcontract@emcontract');            
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

// show the field user

		print "<td class='fieldrequired'>".$langs->trans('User')." </td><td>";
		if($edit==1){
		print $form->select_dolusers($object->user, 'User', 1, '', 0 );
		}else{
		print $object->print_generic('user', 'rowid',$object->user,'lastname','firstname',' ');
		}
		print "</td>";
		print "\n</tr>\n";
		print "<tr>\n";

// show the field skill

		print "<td class='fieldrequired'>".$langs->trans('Skill')." </td><td>";
		if($edit==1){
		print $object->select_generic('skill','rowid','Skill','rowid','description',$object->skill);
		}else{
		print $object->print_generic('skill','rowid',$object->skill,'rowid','description');
		}
		print "</td>";
		print "<td></td></tr>\n";

            

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
                //if($user->rights->Hruserskills->edit)
                //{
                    print '<a href="'.$_SERVER["PHP_SELF"].'?id='.$_GET['id'].'&action=edit" class="butAction">'.$langs->trans("Update").'</a>';
                //}
                
                //if ($user->rights->Hruserskills->delete)
                //{
                    print '<a class="butActionDelete" href="'.$_SERVER["PHP_SELF"].'?id='.$_GET['id'].'&action=delete">'.$langs->trans('Delete').'</a>';
                //}
                //else
                //{
                //    print '<a class="butActionRefused" href="#" title="'.dol_escape_htmltag($langs->trans("NotAllowed")).'">'.$langs->trans('Delete').'</a>';
                //}
                    
                print '</div>';
            }
        }
      


//FIXME DELETE
        dol_fiche_end();
    }
        break;
        case 'viewinfo':
        //print_fiche_titre($langs->trans('Hruserskills'));
        $head=Hruserskills_prepare_head($object);
        dol_fiche_head($head,'info',$langs->trans("Hruserskills"),0,'emcontract@emcontract');            
        print '<table width="100%"><tr><td>';
        dol_print_object_info($object);
        print '</td></tr></table>';
        print '</div>';
        dol_fiche_end();
        break;
    case 'deletefile':
        $action='delete';
    case 'viewdoc':
        if (! $sortorder) $sortorder="ASC";
        if (! $sortfield) $sortfield="name";
	$object->fetch_thirdparty();

        //print_fiche_titre($langs->trans('Hruserskills'));
        $head=Hruserskills_prepare_head($object);
        dol_fiche_head($head,'documents',$langs->trans("Hruserskills"),0,'emcontract@emcontract');            
        
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

        dol_fiche_end();
        break;
    case "delete";
        if( ($id>0 || $ref!="")){
         $ret=$form->form_confirm($_SERVER["PHP_SELF"].'?action=confirm_delete&id='.$id,$langs->trans("DeleteHruserskills"),$langs->trans("ConfirmDelete"),"confirm_delete", '', 0, 1);
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
		$sql.= " t.fk_user_creation,";
		$sql.= " t.fk_user,";
		$sql.= " t.fk_skill";

    
    $sql.= " FROM ".MAIN_DB_PREFIX."hr_user_skills as t";
//    $sql.= " WHERE field3 = 'xxx'";
//    $sql.= " ORDER BY field1 ASC";

    print '<table class="noborder">'."\n";
    print '<tr class="liste_titre">';
    print_liste_field_titre($langs->trans('rowid'),$_SERVER['PHP_SELF'],'t.rowid','',$param,'',$sortfield,$sortorder);
print_liste_field_titre($langs->trans('entity'),$_SERVER['PHP_SELF'],'t.entity','',$param,'',$sortfield,$sortorder);
print_liste_field_titre($langs->trans('date_creation'),$_SERVER['PHP_SELF'],'t.date_creation','',$param,'',$sortfield,$sortorder);
print_liste_field_titre($langs->trans('user_creation'),$_SERVER['PHP_SELF'],'t.user_creation','',$param,'',$sortfield,$sortorder);

    
    print '</tr>';

    dol_syslog($script_file, LOG_DEBUG);
    $resql=$db->query($sql);
    if ($resql)
    {
       $i=0;
        $num = $db->num_rows($resql);
        while ($i < $num)
        {
            $obj = $db->fetch_object($resql);
            if ($obj)
            {
                // You can use here results
                		print "<tr class='".(($i%2==0)?'pair':'impair')." >";
		print "<td>".$obj->rowid."</td>";
		print "<td>".$obj->entity."</td>";
		print "<td>".dol_print_date($obj->date_creation,'day')."</td>";
		print "<td>".$object->print_generic('user_creation','rowid',$obj->fk_user_creation,'rowid','description')."</td>";
		print "</tr>";

                

            }
            $i++;
        }
    }
    else
    {
        $error++;
        dol_print_error($db);
    }

    print '</table>'."\n";
}
        break;
}

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
function Hruserskills_prepare_head($object)
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
