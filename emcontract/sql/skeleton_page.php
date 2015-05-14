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
 *		\ingroup    mymodule othermodule1 othermodule2
 *		\brief      This file is an example of a php page
 *					Put here some comments
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
dol_include_once('/module/class/skeleton_class.class.php');

// Load traductions files requiredby by page
//$langs->load("companies");
$langs->load("skeleton_class");

// Get parameters
$id			= GETPOST('id','int');
$action		= GETPOST('action','alpha');
$backtopage = GETPOST('backtopage');
$myparam	= GETPOST('myparam','alpha');

// Protection if external user
if ($user->societe_id > 0)
{
	//accessforbidden();
}

//if (empty($action) && empty($id) && empty($ref)) $action='list';

// Load object if id or ref is provided as parameter
$object=new Skeleton_Class($db);



/*******************************************************************
* ACTIONS
*
* Put here all code to do according to value of "action" parameter
********************************************************************/

// Action to add record
$error=0;
if (GETPOST('cancel')){
        if ($action == 'update'){
            $action="view";
        }else
        {
            $action="list";
        }
                  //$urltogo=$backtopage?$backtopage:dol_buildpath('?action=list',1);
	//header("Location: ".$urltogo);
}else if (($action == 'add') || ($action == 'create'))
{

        $object->prop1=GETPOST("field1");
        $object->prop2=GETPOST("field2");

                  
 }    
 switch($action){		
                    case 'update':
                            $result=$object->update($user);
                            if ($result > 0)
                            {
                                // Creation OK
                                    setEventMessages('objectSucessfullyUpdated');
                                    $action='view';
                            }
                            else
                            {
                                    // Creation KO
                                    if (! empty($object->errors)) setEventMessages(null, $object->errors, 'errors');
                                    else setEventMessages($object->error, null, 'errors');
                                    $action='edit';
                            }
             
                        break;
                    case 'add':
                            $result=$object->create($user);
                            if ($result > 0)
                            {
                                    // Creation OK
                                   setEventMessages('objectSucessfullyCreated');
                                   $action='list';
                                    exit;
                            }else
                            {
                                    // Creation KO
                                    if (! empty($object->errors)) setEventMessages(null, $object->errors, 'errors');
                                    else  setEventMessages($object->error, null, 'errors');
                                    $action='create';
                            }                            
                            break;
                    case 'view':
                    case 'edit':
                            if ($id > 0 )
                            {
                                    $result=$object->fetch($id,$ref);
                                    if ($result < 0) dol_print_error($db);
                            }else
                            {
                                    setEventMessage( $langs->trans("noIdPresent"),'errors');
                                    $action='list';
                            }
                            break;
                     case 'confirm_delete':
                            $result=$object->delete($user);
                            if ($result > 0)
                            {
                                    // Delete OK
                                    setEventMessages($langs->trans("RecordDeleted"), null, 'mesgs');
                                    $action='list';
                                    exit;
                            }
                            else
                            {
                                    // Delete NOK
                                    if (! empty($object->errors)) setEventMessages(null,$object->errors,'errors');
                                    else setEventMessages($object->error,null,'errors');
                                    $action='view';
                            }
                         break;
                    case 'list':
                    case 'create':
                    default:
                            break;
            } 


/***************************************************
* VIEW
*
* Put here all code to build page
****************************************************/

llxHeader('','skeleton','');

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
    case "view":
    {
        	// Buttons
	print '<div class="tabsAction">'."\n";
	$parameters=array();
	$reshook=$hookmanager->executeHooks('addMoreActionsButtons',$parameters,$object,$action);    // Note that $action and $object may have been modified by hook
	if ($reshook < 0) setEventMessages($hookmanager->error, $hookmanager->errors, 'errors');

	if (empty($reshook))
	{
		if ($user->rights->mymodule->write)
		{
			print '<div class="inline-block divButAction"><a class="butAction" href="'.$_SERVER["PHP_SELF"].'?id='.$object->id.'&amp;action=edit">'.$langs->trans("Modify").'</a></div>'."\n";
		}

		if ($user->rights->mymodule->delete)
		{
			if ($conf->use_javascript_ajax && empty($conf->dol_use_jmobile))	// We can't use preloaded confirm form with jmobile
			{
				print '<div class="inline-block divButAction"><span id="action-delete" class="butActionDelete">'.$langs->trans('Delete').'</span></div>'."\n";
			}
			else
			{
				print '<div class="inline-block divButAction"><a class="butActionDelete" href="'.$_SERVER["PHP_SELF"].'?id='.$object->id.'&amp;action=delete">'.$langs->trans('Delete').'</a></div>'."\n";
			}
		}
	}
	print '</div>'."\n";
        


	print '<br>';
        if($edit==1){
            print '<form method="POST" action="'.$_SERVER["PHP_SELF"].'">';
            print '<input type="hidden" name="action" value="add">';
            print '<input type="hidden" name="backtopage" value="'.$backtopage.'">';
            if($new==0){
                print '<input type="hidden" name="id" value="'.$object->id.'">';
            }
        }
	print '<table class="border centpercent">'."\n";

            print "<tr><td>prop1</td><td>".$object->field1."</td></tr>";
            print "<tr><td>prop2</td><td>".$object->field2."</td></tr>";

	print '</table>'."\n";
	print '<br>';
	print '<div class="center">';
        if($edit==1){
        if($new==1){
                print '<input type="submit" class="button" name="add" value="'.$langs->trans("Create");
            }else{
                print '<input type="submit" value="'.$langs->trans("Update").'" class="button">';
            }
            print '"> &nbsp; <input type="submit" class="button" name="cancel" value="'.$langs->trans("Cancel").'"></div>';
            print '</form>';
        }
        dol_fiche_end();
    }
        break;
    case 'list':
    default:
        {
    $sql = "SELECT";
    $sql.= " t.rowid,";
    $sql.= " t.field1,";
    $sql.= " t.field2";
    $sql.= " FROM ".MAIN_DB_PREFIX."mytable as t";
//    $sql.= " WHERE field3 = 'xxx'";
    $sql.= " ORDER BY field1 ASC";

    print '<table class="noborder">'."\n";
    print '<tr class="liste_titre">';
    print_liste_field_titre($langs->trans('field1'),$_SERVER['PHP_SELF'],'t.field1','',$param,'',$sortfield,$sortorder);
    print_liste_field_titre($langs->trans('field2'),$_SERVER['PHP_SELF'],'t.field2','',$param,'',$sortfield,$sortorder);
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
                print "<tr><td>prop1</td><td>".$obj->field1."</td></tr>";
                print "<tr><td>prop2</td><td>".$obj->field2."</td></tr>";

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

// End of page
llxFooter();
$db->close();
