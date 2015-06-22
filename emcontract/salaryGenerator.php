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

/*------------------------- Includes Dolibarr ---------------------------------*/
$res=0;
if (! $res && file_exists("../main.inc.php")) $res=@include '../main.inc.php';					// to work if your module directory is into dolibarr root htdocs directory
if (! $res && file_exists("../../main.inc.php")) $res=@include '../../main.inc.php';			// to work if your module directory is into a subdir of root htdocs directory
if (! $res && file_exists("../../../dolibarr/htdocs/main.inc.php")) $res=@include '../../../dolibarr/htdocs/main.inc.php';     // Used on dev env only
if (! $res && file_exists("/var/www/dolibarr/htdocs/main.inc.php")) $res=@include '/var/www/dolibarr/htdocs/main.inc.php';   // Used on dev env only
if (! $res) die("Include of main fails");
/*----------------------- Includes Class -------------------------------------*/
//dol_include_once('/emcontract/class/hrcontract.class.php');
//$langs->load("Hrcontract_class");
dol_include_once('/core/class/html.formother.class.php');
$htmlother = new FormOther($db);
dol_include_once('/core/class/html.form.class.php');
$form=new Form($db);

/*--------------------------- Get param ---------------------------------------*/

$id			= GETPOST('id','int');
$ref                    = GETPOST('ref','alpha');
$tms                    = GETPOST('tms','alpha');
$employee               = GETPOST('employee','alpha');
//if no post or tms doesn't exist then the step can't be other than 1
$step=(isset($_POST) || isset($_SESSION['SG_'.$tms]))?GETPOST('step','int'):1;

/*--------------------------- Get param & action ------------------------------*/
switch ($step) {
    case 1:
    // if TMS set and save inthe session then delete it
        if(!empty($tms) && isset($_SESSION['SG_'.$tms])){
            unset($_SESSION['SG_'.$tms]);
        }
        $tms= time();
        
        break;            
    case 2:
        if(empty($tms)){
            print '<script> alert("NoTimestamp");</script>';
            header("Location: ".$_SERVER["PHP_SELF"].'?step=1');
        }else{
            $_SESSION['SG_'.$tms]=array();
            $user_id=GetnSaveInput($tms,'User',$_POST);
            $month=GetnSaveInput($tms,'month',$_POST);
            $year=GetnSaveInput($tms,'year',$_POST);
        }
        break;
    case 3:
        if(empty($tms)){
            print '<script> alert("NoTimestamp");</script>';
            header("Location: ".$_SERVER["PHP_SELF"].'?step=2');
        }else{
            (array)$salaryElements  = GetnSaveInput($tms,'salaryElements',$_POST);
        }
        break;
    default:
        $step =1;
        break;
}






/*---------------------------- Dolibarr menu----------------------------------*/
llxHeader('',$langs->trans('salaryGenerator'),'');
$form=new Form($db);
$head=salaryGenerator_prepare_head($object);
dol_fiche_head($head,'step'.$step,$langs->trans("salaryGenerator"),0,'emcontract@emcontract');            

/*---------------------------- MAIN        ----------------------------------*/

Switch ($step){
case 2:
    //validation for the inputs from step 1

    break;
case 1:
default:
    $year=date('Y',strtotime( $yearWeek.' +0 day'));
    $month=date('m',strtotime( $yearWeek.' +0 day'));
    print '<form method="POST" action="?step=2">';
    print '<input type="hidden" name="tms" value="'.$tms.'">';
    print '<table class="border centpercent">'."\n";
    print '<tr>'."\n";
    print "\t<td>".$langs->trans('User')."</td>\n\t<td>\n\t\t";
    print $form->select_dolusers($object->user, 'User', 1, '', 0 )."\n\t</td>\n";
    print "</tr>\n";
    print "<tr>\n";
    print "\t<td>".$langs->trans('period')."</td>\n\t<td>\n\t\t";
    print $htmlother->select_month($month, 'month').' - '.$htmlother->selectyear($year,'year',1,10,3)."\n\t</td>\n";
    print "</tr>\n";
    print '</table>';
    print '<input type="submit" class="button" value="'.$langs->trans('step').' 2">';
		
    print '</form>';

    break;

}

/*----------------------------- FOOTER ---------------------------------------*/
dol_fiche_end();
llxFooter();
$db->close;
/*---------------------------- Functions -------------------------------------*/
        
        
function salaryGenerator_prepare_head($object)
{
    global $langs, $conf, $user;
    $h = 0;
    $head = array();

    $head[$h][0] = $_SERVER["PHP_SELF"].'?step=1';
    $head[$h][1] = $langs->trans("step").' 1';
    $head[$h][2] = 'step1';
    $h++;
    $head[$h][0] = $_SERVER["PHP_SELF"].'?step=2';
    $head[$h][1] = $langs->trans("step").' 2';
    $head[$h][2] = 'step2';
    $h++;
    $head[$h][0] = $_SERVER["PHP_SELF"].'?step=3';
    $head[$h][1] = $langs->trans("step").' 3';
    $head[$h][2] = 'step3';
    $h++;

    return $head;
}
/*
 * function to genegate a select list from a table, the showed text will be a concatenation of some 
 * column defined in column bit, the Least sinificative bit will represent the first colum 
 * 
 *  @param    int               	$timestamp          timestamp of the onGoing Salary methods
 *  @param    string              	$variableName       name of the value in the GET, POST, SESSION[$timestamp]
 *  @param    string              	$GETPOST            $_POST to get POST date, $_GET to get GET data
 *  @return any                                             value got
 */
function GetnSaveInput($timestamp,$variableName,$GETPOST){
    $value= $GETPOST[$variableName];
    if (empty($value) && isset($_SESSION['SG_'.$timestamp][$variableName])){
        $value=$_SESSION['SG_'.$timestamp][$variableName];
    }else if(isset($_SESSION['SG_'.$timestamp])){ // if to avoid creation of timestamp not in the right time
        $_SESSION['SG_'.$timestamp][$variableName]=$value;
    }
    return $value;
}