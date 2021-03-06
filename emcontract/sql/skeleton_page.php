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
if (! $res && file_exists('../main.inc.php')) $res=@include '../main.inc.php';					// to work if your module directory is into dolibarr root htdocs directory
if (! $res && file_exists('../../main.inc.php')) $res=@include '../../main.inc.php';			// to work if your module directory is into a subdir of root htdocs directory
if (! $res && file_exists('../../../dolibarr/htdocs/main.inc.php')) $res=@include '../../../dolibarr/htdocs/main.inc.php';     // Used on dev env only
if (! $res && file_exists('/var/www/dolibarr/htdocs/main.inc.php')) $res=@include '/var/www/dolibarr/htdocs/main.inc.php';   // Used on dev env only
if (! $res) die("Include of main fails");
// Change this following line to use the correct relative path from htdocs
//include_once(DOL_DOCUMENT_ROOT.'/core/class/formcompany.class.php');
dol_include_once('/mymodule/class/skeleton_class.class.php');
dol_include_once('/core/lib/functions2.lib.php');
//document handling
dol_include_once('/core/lib/files.lib.php');
//dol_include_once('/core/lib/images.lib.php');
dol_include_once('/core/class/html.formfile.class.php');
// include conditionnally of the dolibarr version
//if((version_compare(DOL_VERSION, "3.8", "<"))){
        dol_include_once('/mymodule/lib/mymodule.lib.php');
//}
dol_include_once('/core/class/html.formother.class.php');
$PHP_SELF=$_SERVER['PHP_SELF'];
// Load traductions files requiredby by page
//$langs->load("companies");
$langs->load("Skeleton_class");

// Get parameter
$id			= GETPOST('id','int');
$ref                    = GETPOST('ref','alpha');
$action		= GETPOST('action','alpha');
$backtopage = GETPOST('backtopage');
$cancel=GETPOST('cancel');
$confirm=GETPOST('confirm');
$tms= GETPOST('tms','alpha');
//// Get parameters
$sortfield = GETPOST('sortfield','alpha'); 
$sortorder = GETPOST('sortorder','alpha')?GETPOST('sortorder','alpha'):'ASC';
$removefilter=isset($_POST["removefilter_x"]);//|| isset($_POST["removefilter"]);
$applyfilter=isset($_POST["search_x"]) ;//|| isset($_POST["search"]);
if (!$removefilter && $applyfilter)		// Both test must be present to be compatible with all browsers
{
    $ls_fields1=GETPOST('ls_fields1','int');
    $ls_fields2=GETPOST('ls_fields2','apha');
}


$page = GETPOST('page','int'); //FIXME, need to use for all the list
if ($page == -1) { $page = 0; }
$offset = $conf->liste_limit * $page;
$pageprev = $page - 1;
$pagenext = $page + 1;


$upload_dir = $conf->mymodule->dir_output.'/Skeleton/'.dol_sanitizeFileName($object->ref);


 // uncomment to avoid resubmision
//if(isset( $_SESSION['Skeleton_class'][$tms]))
//{

 //   $cancel=TRUE;
 //  setEventMessages('Internal error, POST not exptected', null, 'errors');
//}



// Right Management
 /*
if ($user->societe_id > 0 || 
       (!$user->rights->mymodule->add && ($action=='add' || $action='create')) ||
       (!$user->rights->mymodule->view && ($action=='list' || $action='view')) ||
       (!$user->rights->mymodule->delete && ($action=='confirm_delete')) ||
       (!$user->rights->mymodule->edit && ($action=='edit' || $action='update')))
{
	accessforbidden();
}
*/

// create object and set id or ref if provided as parameter
$object=new Skeleton_Class($db);
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
    $_SESSION['Skeleton_'.$tms]=array();
    $_SESSION['Skeleton_'.$tms]['action']=$action;
            
}else if (($action == 'add') || ($action == 'update' && ($id>0 || !empty($ref))))
{
        //block resubmit
        if(empty($tms) || (!isset($_SESSION['Skeleton_'.$tms]))){
                setEventMessages(null,'WrongTimeStamp_requestNotExpected', 'errors');
                $action=($action=='add')?'create':'edit';
        }
        //retrive the data
        $object->prop1=GETPOST("field1");
        $object->prop2=GETPOST("field2");
        
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
        
 }else if ($id==0 && $ref=='' && $action!='create') 
 {
     $action='list';
 }
 
 
  switch($action){		
                    case 'update':
                            $result=$object->update($user);
                            if ($result > 0)
                            {
                                // Creation OK
                                unset($_SESSION['Skeleton_'.$tms]);
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
                                    setEventMessage( $langs->trans('noIdPresent').' id:'.$id,'errors');
                                    $action='list';
                            }
                            break;
                    case 'add':
                            $result=$object->create($user);
                            if ($result > 0)
                            {
                                    // Creation OK
                                // remove the tms
                                   unset($_SESSION['Skeleton_'.$tms]);
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
                                    setEventMessages($langs->trans('RecordDeleted'), null, 'mesgs');
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
if(isset( $_SESSION['Skeleton_class'][$tms]))
{
    unset($_SESSION['Skeleton_class'][$tms]);
}

/***************************************************
* VIEW
*
* Put here all code to build page
****************************************************/

llxHeader('','Skeleton','');
print "<div> <!-- module body-->";
$form=new Form($db);
$formother=new FormOther($db);

// Put here content of your page

// Example : Adding jquery code
/*print '<script type="text/javascript" language="javascript">
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
</script>';*/

print_fiche_titre($langs->trans('Skeleton'));
$edit=$new=0;
switch ($action) {
    case 'create':
        $new=1;
    case 'edit':
        $edit=1;
   case 'delete';
        if( $action=='delete' && ($id>0 || $ref!="")){
         $ret=$form->form_confirm($PHP_SELF.'?action=confirm_delete&id='.$id,$langs->trans('DeleteSkeleton'),$langs->trans('ConfirmDelete'),'confirm_delete', '', 0, 1);
         if ($ret == 'html') print '<br />';
         //to have the object to be deleted in the background\
        }
    case 'view':
    {
        	// tabs
        if($edit==0 && $new==0){ //show tabs
            $head=Skeleton_prepare_head($object);
            dol_fiche_head($head,'card',$langs->trans('Skeleton'),0,'mymodule@mymodule');            
        }

	print '<br>';
        if($edit==1){
            if($new==1){
                print '<form method="POST" action="'.$PHP_SELF.'?action=add">';
            }else{
                print '<form method="POST" action="'.$PHP_SELF.'?action=update&id='.$id.'">';
            }
                        
            print '<input type="hidden" name="tms" value="'.$tms.'">';
            print '<input type="hidden" name="backtopage" value="'.$backtopage.'">';

        }else {// show the nav bar
            $basedurltab=explode("?", $PHP_SELF);
            $basedurl=$basedurltab[0].'?action=list';
            $linkback = '<a href="'.$basedurl.(! empty($socid)?'?socid='.$socid:'').'">'.$langs->trans("BackToList").'</a>';
            if(!isset($object->ref))//save ref if any
                $object->ref=$object->id;
            print $form->showrefnav($object, 'action=view&id', $linkback, 1, 'rowid', 'ref', '');
            //reloqd the ref

        }

	print '<table class="border centpercent">'."\n";

            print "<tr><td>prop1</td><td>".$object->field1."</td></tr>";
            print "<tr><td>prop2</td><td>".$object->field2."</td></tr>";

	print '</table>'."\n";
	print '<br>';
	print '<div class="center">';
        if($edit==1){
        if($new==1){
                print '<input type="submit" class="button" name="add" value="'.$langs->trans('Create').'">';
            }else{
                print '<input type="submit" name="update" value="'.$langs->trans('Update').'" class="button">';
            }
            print ' &nbsp; <input type="submit" class="button" name="cancel" value="'.$langs->trans('Cancel').'"></div>';
            print '</form>';
        }else{
            $parameters=array();
            $reshook=$hookmanager->executeHooks('addMoreActionsButtons',$parameters,$object,$action);    // Note that $action and $object may have been modified by hook
            if ($reshook < 0) setEventMessages($hookmanager->error, $hookmanager->errors, 'errors');

            if (empty($reshook))
            {
                print '<div class="tabsAction">';

                // Boutons d'actions
                //if($user->rights->Skeleton->edit)
                //{
                    print '<a href="'.$PHP_SELF.'?id='.$id.'&action=edit" class="butAction">'.$langs->trans('Update').'</a>';
                //}
                
                //if ($user->rights->Skeleton->delete)
                //{
                    print '<a class="butActionDelete" href="'.$PHP_SELF.'?id='.$id.'&action=delete">'.$langs->trans('Delete').'</a>';
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
        $head=Skeleton_prepare_head($object);
        dol_fiche_head($head,'info',$langs->trans("Skeleton"),0,'mymodule@mymodule');            
        print '<table width="100%"><tr><td>';
        dol_print_object_info($object);
        print '</td></tr></table>';
        print '</div>';
        break;
    case 'deletefile':
        $action='delete';
    case 'viewdoc':
        if (! $sortfield) $sortfield='name';
	$object->fetch_thirdparty();

        $head=Skeleton_prepare_head($object);
        dol_fiche_head($head,'documents',$langs->trans("Skeleton"),0,'mymodule@mymodule');            
        
        $filearray=dol_dir_list($upload_dir,'files',0,'','\.meta$',$sortfield,(strtolower($sortorder)=='desc'?SORT_DESC:SORT_ASC),1);
	$totalsize=0;
	foreach($filearray as $key => $file)
	{
		$totalsize+=$file['size'];
	}
        print '<table class="border" width="100%">';
        $linkback = '<a href="'.$PHP_SELF.(! empty($socid)?'?socid='.$socid:'').'">'.$langs->trans("BackToList").'</a>';
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

        $modulepart = 'mymodule';
        $permission = $user->rights->mymodule->add;
        $param = '&id='.$object->id;
        include_once DOL_DOCUMENT_ROOT . '/core/tpl/document_actions_post_headers.tpl.php';

        
        break;
    case 'delete':
        if( ($id>0 || $ref!='')){
         $ret=$form->form_confirm($PHP_SELF.'?action=confirm_delete&id='.$id,$langs->trans('DeleteSkeleton'),$langs->trans('ConfirmDelete'),'confirm_delete', '', 0, 1);
         if ($ret == 'html') print '<br />';
         //to have the object to be deleted in the background        
        }
    case 'list':
    default:
        {
    $sql = 'SELECT';
    $sql.= ' t.rowid,';
    $sql.= ' t.field1,';
    $sql.= ' t.field2';
    $sql.= ' FROM '.MAIN_DB_PREFIX.'mytable as t';
    $sql.= ' WHERE t.entity = '.$conf->entity;
    if ($filter && $filter != -1)		// GETPOST('filtre') may be a string
    {
            $filtrearr = explode(',', $filter);
            foreach ($filtrearr as $fil)
            {
                    $filt = explode(':', $fil);
                    $sql .= ' AND ' . $filt[0] . ' = ' . $filt[1];
            }
    }
    //pass the search criteria
    if ($ls_fields1) $sql .= natural_search(array('t.fields1'), $ls_fields1);
    if ($ls_fields2) $sql .= natural_search('t.fields2', $ls_fields2);
    //list limit
    $nbtotalofrecords = 0;
    if (empty($conf->global->MAIN_DISABLE_FULL_SCANLIST))
    {
            $result = $db->query($sql);
            $nbtotalofrecords = $db->num_rows($result);
    }
    if(!empty($sortfield)){$sql.= $db->order($sortfield,$sortorder);
    }else{ $sortorder = 'ASC';}
    if(!empty($limit))$sql.= $db->plimit($limit+1, $offset);      

    //execute SQL
    dol_syslog($script_file, LOG_DEBUG);
    $resql=$db->query($sql);
    if ($resql)
    {
        if (!empty($ls_fields1))	$param.='&ls_fields1'.urlencode($ls_fields1);
        if (!empty($ls_fields2))	$param.='&ls_fields2'.urlencode($ls_fields2);
        if ($filter && $filter != -1) $param.='&filtre='.urlencode($filter);

    //print_barre_liste($langs->trans("Hrcontracttype"),$page,$_SERVER["PHP_SELF"],$param,$sortfield,$sortorder,'',$num,$nbtotalofrecords);
        print '<form method="POST" action="'.$_SERVER["PHP_SELF"].'">';
        print '<table class="liste" width="100%">'."\n";
        //TITLE
        print '<tr class="liste_titre">';
        print_liste_field_titre($langs->trans('field1'),$PHP_SELF,'t.field1','',$param,'',$sortfield,$sortorder);
        print_liste_field_titre($langs->trans('field2'),$PHP_SELF,'t.field2','',$param,'',$sortfield,$sortorder);
        print '</tr>';
        //SEARCH FIELDS
        print '<tr class="liste_titre">'; 
        print '<td><input type="text" name="ls_fields1" value="'.$ls_fields1.'"></td>';
        print '<td><input type="text" name="ls_fields2" value="'.$ls_fields2.'">';
        
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
    print '</from>'."\n";
    
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
function Skeleton_prepare_head($object)
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
    // $this->tabs = array('entity:+tabname:Title:@mymodule:/mymodule/mypage.php?id=__ID__');   to add new tab
    // $this->tabs = array('entity:-tabname);   												to remove a tab
    complete_head_from_modules($conf,$langs,$object,$head,$h,'mymodule');
    complete_head_from_modules($conf,$langs,$object,$head,$h,'mymodule','remove');
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
