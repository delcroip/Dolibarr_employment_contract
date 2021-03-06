#!/usr/bin/php
<?php
/* Copyright (C) 2015 delcroip <pmpdelcroix@gmail.com>
 * Copyright (C) 2008-2014 Laurent Destailleur  <eldy@users.sourceforge.net>
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
 *	\file       dev/skeletons/build_class_from_table.php
 *  \ingroup    core
 *  \brief      Create a complete class file from a table in database
 */

$sapi_type = php_sapi_name();
$script_file = basename(__FILE__);
$path=dirname(__FILE__).'/';

// Test if batch mode
if (substr($sapi_type, 0, 3) == 'cgi') {
    echo "Error: You are using PHP for CGI. To execute ".$script_file." from command line, you must use PHP for CLI mode.\n";
    exit;
}

// Include Dolibarr environment
require_once("/var/www/dolibarr/htdocs/master.inc.php");
// After this $db is a defined handler to database.

// Main
$version='3.2';
@set_time_limit(0);
$error=0;

$langs->load("main");


print "***** $script_file ($version) *****\n";


// -------------------- START OF BUILD_CLASS_FROM_TABLE SCRIPT --------------------

// Check parameters
if (! isset($argv[1]) || (isset($argv[2]) && ! isset($argv[6])))
{
    print "Usage: $script_file tablename [server port databasename user pass]\n";
    exit;
}

if (isset($argv[2]) && isset($argv[3]) && isset($argv[4]) && isset($argv[5]) && isset($argv[6]))
{
	print 'Use specific database ids'."\n";
	$db=getDoliDBInstance('mysqli',$argv[2],$argv[5],$argv[6],$argv[4],$argv[3]);
}

if ($db->type != 'mysql' && $db->type != 'mysqli')
{
	print "Error: This script works with mysql or mysqli driver only\n";
	exit;
}

// Show parameters
print 'Tablename='.$argv[1]."\n";
print "Current dir is ".getcwd()."\n";


// Define array with list of properties
$property=array();
$table=$argv[1];
$foundprimary=0;
$resql=$db->DDLDescTable($table);
if ($resql)
{
	$i=0;
	while($obj=$db->fetch_object($resql))
	{
		//var_dump($obj);
		$i++;
		$property[$i]['field']=$obj->Field;
                // sve the default value from the dB
                $property[$i]['default']=$obj->Default;
                
                // object variable name
                if(strpos($obj->Field,"fk_")===0){
                    $property[$i]['var']=substr($obj->Field,3);
                }else{
                    $property[$i]['var']=$obj->Field;
                }
                
		if ($obj->Key == 'PRI')
		{
			$property[$i]['primary']=1;
			$foundprimary=1;
		}
		else
		{
			$property[$i]['primary']=0;
		}
		$property[$i]['type'] =$obj->Type;
		$property[$i]['null'] =$obj->Null;
		$property[$i]['extra']=$obj->Extra;
		if ($property[$i]['type'] == 'date'
			|| $property[$i]['type'] == 'datetime'
			|| $property[$i]['type'] == 'timestamp')
		{
			$property[$i]['istime']=true;
		}
		else
		{
			$property[$i]['istime']=false;
		}
		if (preg_match('/varchar/i',$property[$i]['type'])
			|| preg_match('/text/i',$property[$i]['type']))
		{
			$property[$i]['ischar']=true;
		}
		else
		{
			$property[$i]['ischar']=false;
		}
	}
}
else
{
	print "Error: Failed to get description for table '".$table."'.\n";
	return false;
}
//var_dump($property);

// Define substitute fetch/select parameters
$varpropselect="\n";
$cleanparam='';
$i=0;
foreach($property as $key => $prop)
{
    $i++;
    if ($prop['field'] != 'rowid')
    {
        $varpropselect.="\t\t\$sql.= \" ";
        $varpropselect.="t.".$prop['field'];
        if ($i < count($property)) $varpropselect.=",";
        $varpropselect.="\";";
        $varpropselect.="\n";
    }
}



//--------------------------------
// Build skeleton_class.class.php
//--------------------------------

// Define working variables
$table=strtolower($table);
$tablenoprefix=preg_replace('/'.preg_quote(MAIN_DB_PREFIX).'/i','',$table);
$classname=preg_replace('/_/','',ucfirst($tablenoprefix));
$classmin=preg_replace('/_/','',strtolower($classname));


// Read skeleton_class.class.php file
$skeletonfile=$path.'skeleton_class.class.php';
$sourcecontent=file_get_contents($skeletonfile);
if (! $sourcecontent)
{
	print "\n";
	print "Error: Failed to read skeleton sample '".$skeletonfile."'\n";
	print "Try to run script from skeletons directory.\n";
	exit;
}

// Define output variables
$outfile='out.'.$classmin.'.class.php';
$targetcontent=$sourcecontent;

// Substitute class name
$targetcontent=preg_replace('/skeleton_class\.class\.php/', $classmin.'.class.php', $targetcontent);
$targetcontent=preg_replace('/skeleton/', $classmin, $targetcontent);
//$targetcontent=preg_replace('/\$table_element=\'skeleton\'/', '\$table_element=\''.$classmin.'\'', $targetcontent);
$targetcontent=preg_replace('/Skeleton_Class/', $classname, $targetcontent);

// Substitute comments
$targetcontent=preg_replace('/This file is an example to create a new class file/', 'Put here description of this class', $targetcontent);
$targetcontent=preg_replace('/\s*\/\/\.\.\./', '', $targetcontent);
$targetcontent=preg_replace('/Put here some comments/','Initialy built by build_class_from_table on '.strftime('%Y-%m-%d %H:%M',mktime()), $targetcontent);

// Substitute table name
//$targetcontent=preg_replace('/MAIN_DB_PREFIX."mytable/', 'MAIN_DB_PREFIX."'.$tablenoprefix, $targetcontent);
$targetcontent=preg_replace('/mytable/',$tablenoprefix, $targetcontent);
// Substitute declaration parameters
$varprop="\n";
$cleanparam='';
foreach($property as $key => $prop)
{
	if ($prop['field'] != 'rowid' && $prop['field'] != 'id')
	{
		$varprop.="\tvar \$".$prop['var'];
		if ($prop['istime']) $varprop.="=''";
		$varprop.=";";
		if ($prop['comment']) $varprop.="\t// ".$prop['extra'];
		$varprop.="\n";
	}
}
$targetcontent=preg_replace('/var \$prop1;/', $varprop, $targetcontent);
$targetcontent=preg_replace('/var \$prop2;/', '', $targetcontent);

// Substitute clean parameters
$varprop="\n";
$cleanparam='';
foreach($property as $key => $prop)
{
	if ($prop['field'] != 'rowid' && $prop['field'] != 'id' && ! $prop['istime'])
	{
		$varprop.="\t\tif (isset(\$this->".$prop['var'].")) \$this->".$prop['var']."=trim(\$this->".$prop['var'].");";
		$varprop.="\n";
	}
}
$targetcontent=preg_replace('/if \(isset\(\$this->prop1\)\) \$this->prop1=trim\(\$this->prop1\);/', $varprop, $targetcontent);
$targetcontent=preg_replace('/if \(isset\(\$this->prop2\)\) \$this->prop2=trim\(\$this->prop2\);/', '', $targetcontent);

// Substitute insert into parameters for the create
$varprop="\n";
$cleanparam='';
$i=0;
foreach($property as $key => $prop)
{
	$i++;
	$addfield=1;
        if($prop['var']=='user_modification') $addfield=0;
        if($prop['var']=='date_modification') $addfield=0;
	if ($prop['field'] == 'tms') $addfield=0;	// This is a field of type timestamp edited automatically
	if ($prop['extra'] == 'auto_increment') $addfield=0;
        
	if ($addfield)
	{
		$varprop.="\t\t\$sql.= \"".$prop['field'];
		if ($i < count($property)) $varprop.=",";
		$varprop.="\";";
		$varprop.="\n";
	}
}
$targetcontent=preg_replace('/\$sql\.= " field1,";/', $varprop, $targetcontent);
$targetcontent=preg_replace('/\$sql\.= " field2";/', '', $targetcontent);

// Substitute insert values parameters
$varprop="\n";
$cleanparam='';
$i=0;
foreach($property as $key => $prop)
{
	$i++;
	$addfield=1;
	if ($prop['field'] == 'tms') $addfield=0;	// This is a field of type timestamp edited automatically
	if ($prop['extra'] == 'auto_increment') $addfield=0;
        if($prop['var']=='user_modification')$addfield=0;
        if($prop['var']=='date_modification')$addfield=0;

	if ($addfield)
	{
		$varprop.="\t\t\$sql.= \" ";
		
                if($prop['var']=='date_creation'){
                        $varprop.='NOW() ';
                }else if($prop['var']=='user_creation'){
                        $varprop.='\'".\$user->id."\'';
                       // $varprop.='{\$user->id}'; //FIXME ?
                }else if ($prop['istime'])
		{
			$varprop.='".(! isset($this->'.$prop['var'].') || dol_strlen($this->'.$prop['var'].')==0?\'NULL\':"\'".$this->db->idate(';
			$varprop.="\$this->".$prop['var']."";
			$varprop.=')."\'")."';
		}
		elseif ($prop['ischar'])
		{
			$varprop.='".(! isset($this->'.$prop['var'].')?\'NULL\':"\'".';
			$varprop.='$this->db->escape($this->'.$prop['var'].')';
			$varprop.='."\'")."';
		}
		else
		{
			$varprop.='".(! isset($this->'.$prop['var'].')?\'NULL\':"\'".';
			$varprop.="\$this->".$prop['var']."";
			$varprop.='."\'")."';
		}
                if ($i < count($property)) $varprop.=",";
                $varprop.='";';
		$varprop.="\n";
	}
}
$targetcontent=preg_replace('/\$sql\.= " \'".\$this->prop1\."\',";/', $varprop, $targetcontent);
$targetcontent=preg_replace('/\$sql\.= " \'".\$this->prop2\."\'";/', '', $targetcontent);

// Substitute update values parameters
$varprop="\n";
$cleanparam='';
$i=0;
foreach($property as $key => $prop)
{
	$i++;
        $addfield=1;
        if($prop['var']=='user_creation') $addfield=0;
        if($prop['var']=='date_creation') $addfield=0;
        if($prop['var']=='rowid') $addfield=0;
        if($prop['var']=='id') $addfield=0;
            
	if ($addfield)
	{

                    //don't update date & user creation fields
                
                $varprop.="\t\t\$sql.= \" ";
                $varprop.=$prop['field'].'=';
                if($prop['var']=='date_modification'){
                    $varprop.='NOW() ';
                }else if($prop['var']=='user_modification'){
                    $varprop.='\'".\$user->id."\'';
                     // $varprop.='".\$user."'; //FIXME ?
                }else if ($prop['istime'])
                {
                        // (dol_strlen($this->datep)!=0 ? "'".$this->db->idate($this->datep)."'" : 'null')
                        $varprop.='".(dol_strlen($this->'.$prop['var'].')!=0 ? "\'".$this->db->idate(';
                        $varprop.='$this->'.$prop['var'];
                        $varprop.=')."\'" : \'null\').';
                        $varprop.='"';
                }else
                {
                        $varprop.="\".";
                        // $sql.= " field1=".(isset($this->field1)?"'".$this->db->escape($this->field1)."'":"null").",";
                        if ($prop['ischar']){
                            $varprop.='(empty($this->'.$prop['var'].')?"null":"\'".$this->db->escape($this->'.$prop['var'].')."\'")';
                            // $sql.= " field1=".(isset($this->field1)?$this->field1:"null").",";                           
                        }else{
                            $varprop.='(empty($this->'.$prop['var'].')?"null":"\'".$this->'.$prop['var'].'."\'")';
                        }
                        $varprop.=".\"";
                }

                if ($i < count($property)) $varprop.=',';
                $varprop.='";';
                $varprop.="\n";

	}
}
$targetcontent=preg_replace('/\$sql.= " field1=".\(isset\(\$this->field1\)\?"\'".\$this->db->escape\(\$this->field1\)."\'":"null"\).",";/', $varprop, $targetcontent);
$targetcontent=preg_replace('/\$sql.= " field2=".\(isset\(\$this->field2\)\?"\'".\$this->db->escape\(\$this->field2\)."\'":"null"\)."";/', '', $targetcontent);

// Substitute fetch/select parameters
$targetcontent=preg_replace('/\$sql\.= " t\.field1,";/', $varpropselect, $targetcontent);
$targetcontent=preg_replace('/\$sql\.= " t\.field2";/', '', $targetcontent);

// Substitute select set parameters
$varprop="\n";
$cleanparam='';
$i=0;
foreach($property as $key => $prop)
{
	$i++;
	if ($prop['field'] != 'rowid' && $prop['field'] != 'id')
	{
		$varprop.="\t\t\t\t\$this->".$prop['var']." = ";
		if ($prop['istime']) $varprop.='$this->db->jdate(';
		$varprop.='$obj->'.$prop['field'];
		if ($prop['istime']) $varprop.=')';
		$varprop.=";";
		$varprop.="\n";
	}
}
$targetcontent=preg_replace('/\$this->prop1 = \$obj->field1;/', $varprop, $targetcontent);
$targetcontent=preg_replace('/\$this->prop2 = \$obj->field2;/', '', $targetcontent);


// Substitute initasspecimen parameters
$varprop="\n";
$cleanparam='';
foreach($property as $key => $prop)
{
	if ($prop['field'] != 'rowid' && $prop['field'] != 'id')
	{
		$varprop.="\t\t\$this->".$prop['var']."='';";
		$varprop.="\n";
	}
}
$targetcontent=preg_replace('/\$this->prop1=\'prop1\';/', $varprop, $targetcontent);
$targetcontent=preg_replace('/\$this->prop2=\'prop2\';/', '', $targetcontent);
// Build file
$fp=fopen($outfile,"w");
if ($fp)
{
	fputs($fp, $targetcontent);
	fclose($fp);
	print "\n";
	print "File '".$outfile."' has been built in current directory.\n";
}
else $error++;
/*

//--------------------------------
// Build skeleton_script.php
//--------------------------------

// Read skeleton_script.php file
$skeletonfile=$path.'skeleton_script.php';
$sourcecontent=file_get_contents($skeletonfile);
if (! $sourcecontent)
{
	print "\n";
	print "Error: Failed to read skeleton sample '".$skeletonfile."'\n";
	print "Try to run script from skeletons directory.\n";
	exit;
}

// Define output variables
$outfile='out.'.$classmin.'_script.php';
$targetcontent=$sourcecontent;

// Substitute class name
$targetcontent=preg_replace('/skeleton_class\.class\.php/', $classmin.'.class.php', $targetcontent);
$targetcontent=preg_replace('/skeleton_script\.php/', $classmin.'_script.php', $targetcontent);
$targetcontent=preg_replace('/\$element=\'skeleton\'/', '\$element=\''.$classmin.'\'', $targetcontent);
$targetcontent=preg_replace('/\$table_element=\'skeleton\'/', '\$table_element=\''.$classmin.'\'', $targetcontent);
$targetcontent=preg_replace('/Skeleton_Class/', $classname, $targetcontent);

// Substitute comments
$targetcontent=preg_replace('/This file is an example to create a new class file/', 'Put here description of this class', $targetcontent);
$targetcontent=preg_replace('/\s*\/\/\.\.\./', '', $targetcontent);
$targetcontent=preg_replace('/Put here some comments/','Initialy built by build_class_from_table on '.strftime('%Y-%m-%d %H:%M',mktime()), $targetcontent);

// Substitute table name
$targetcontent=preg_replace('/MAIN_DB_PREFIX."mytable/', 'MAIN_DB_PREFIX."'.$tablenoprefix, $targetcontent);

// Build file
$fp=fopen($outfile,"w");
if ($fp)
{
	fputs($fp, $targetcontent);
	fclose($fp);
	print "File '".$outfile."' has been built in current directory.\n";
}
else $error++;


*/
//--------------------------------
// Build skeleton_page.php
//--------------------------------

// Read skeleton_page.php file
$skeletonfile=$path.'skeleton_page.php';
$sourcecontent=file_get_contents($skeletonfile);
if (! $sourcecontent)
{
    print "\n";
    print "Error: Failed to read skeleton sample '".$skeletonfile."'\n";
    print "Try to run script from skeletons directory.\n";
    exit;
}

// Define output variables
$outfile='out.'.$classmin.'_page.php';
$targetcontent=$sourcecontent;

// Substitute class name
$targetcontent=preg_replace('/skeleton_class\.class\.php/', $classmin.'.class.php', $targetcontent);
$targetcontent=preg_replace('/skeleton_script\.php/', $classmin.'_script.php', $targetcontent);
$targetcontent=preg_replace('/\$element=\'skeleton\'/', '\$element=\''.$classmin.'\'', $targetcontent);
$targetcontent=preg_replace('/\$table_element=\'skeleton\'/', '\$table_element=\''.$classmin.'\'', $targetcontent);
$targetcontent=preg_replace('/Skeleton_Class/', $classname, $targetcontent);
$targetcontent=preg_replace('/Skeleton/', $classname, $targetcontent);

// Substitute comments
$targetcontent=preg_replace('/This file is an example to create a new class file/', 'Put here description of this class', $targetcontent);
$targetcontent=preg_replace('/\s*\/\/\.\.\./', '', $targetcontent);
$targetcontent=preg_replace('/Put here some comments/','Initialy built by build_class_from_table on '.strftime('%Y-%m-%d %H:%M',mktime()), $targetcontent);

// Substitute table name
$targetcontent=preg_replace('/mytable/',$tablenoprefix, $targetcontent);

// Substitute fetch/select parameters
$targetcontent=preg_replace('/\$sql\.= " t\.field1,";/', $varpropselect, $targetcontent);
$targetcontent=preg_replace('/\$sql\.= " t\.field2";/', '', $targetcontent);

/*
 * substitue GETPOST
 */
$varpropget="";
$cleanparam='';
foreach($property as $key => $prop)
{
    if ($prop['var']!='user_creation'&& $prop['var']!='date_creation'
            && $prop['var']!='user_modification' && $prop['var']!='date_modification')
    switch($prop['type'])
    {
        case 'datetime':
        case 'date':
        case 'timestamp':
            $varpropget.="\t\t\$object->".$prop['var']."=dol_mktime(0, 0, 0,'";
            $varpropget.='GETPOST('.preg_replace('/_/','',ucfirst($prop['var']))."month'),'";
            $varpropget.='GETPOST('.preg_replace('/_/','',ucfirst($prop['var']))."day',')";
            $varpropget.='GETPOST('.preg_replace('/_/','',ucfirst($prop['var']))."year'));\n";
            break;
        default:
            $varpropget.="\t\t\$object->".$prop['var']."=GETPOST(\"";
            $varpropget.=preg_replace('/_/','',ucfirst($prop['var']))."\");\n";
            break;
    }
}
        
  $targetcontent=preg_replace('/\$object->prop1=GETPOST\("field1"\);/',$varpropget, $targetcontent);
//    $targetcontent=preg_replace('/BALISEHERE/',$varpropget, $targetcontent);
  $targetcontent=preg_replace('/\$object->prop2=GETPOST\("field2"\);/','', $targetcontent);
/*
 * substitute table lines
 */

$varprop="\n";
$cleanparam='';
$nbproperty=count($property);
$i=0;
foreach($property as $key => $prop)
{
	if ($prop['field'] != 'rowid' && $prop['field'] != 'id' && $prop['var']!='user_creation'&& $prop['var']!='date_creation'
                       && $prop['var']!='user_modification' && $prop['var']!='date_modification')
	{
                $varprop.=($i%2==0)?"\t\tprint \"<tr>\\n\";\n":'';
                $varprop.="\n// show the field ".$prop['var']."\n\n";
                if ($i>4) //some example of fieldrequired
                    $varprop.="\t\tprint \"<td>\".\$langs->trans('";
                else
                    $varprop.="\t\tprint \"<td class='fieldrequired'>\".\$langs->trans('";
                $varprop.=preg_replace('/_/','',ucfirst($prop['var']));
                $varprop.="').\" </td><td>\";\n";
                //suport the edit mode
                $varprop.="\t\tif(\$edit==1){\n";
                
                switch ($prop['type']) {
                    case 'datetime':
                    case 'date':
                    case 'timestamp':
                        $varprop.="\t\tif(\$new==1){\n";
                        $varprop.="\t\t\tprint \$form->select_date(-1,'";
                        $varprop.=preg_replace('/_/','',ucfirst($prop['var']))."');\n";
                        $varprop.="\t\t}else{\n";                                               $varprop.="\t\t\tprint \$form->select_date(\$object->";
                        $varprop.=$prop['var'].",'";
                        $varprop.=preg_replace('/_/','',ucfirst($prop['var']))."');\n";  
                        $varprop.="\t\t}\n\t\t}else{\n";
                        $varprop.="\t\t\tprint dol_print_date(\$object->";
                        $varprop.=$prop['var'].",'day');\n";
                        
                        break;
                    default:
                        // print $form->select_dolusers($em->fk_user, "fk_user", 1, "", 0 );	// By default, hierarchical parent
                        // print $em->select_typec(GETPOST('fk_contract_type','int'),'fk_contract_type',0); /*FIXME*/

                        if(strpos($prop['field'],'fk_user') ===0) 
                         {
                                $varprop.="\t\tprint \$form->select_dolusers(\$object->".$prop['var'].", '";
                                $varprop.=preg_replace('/_/','',ucfirst($prop['var']))."', 1, '', 0 );\n";
                                $varprop.="\t\t}else{\n";
                                $varprop.="\t\tprint print_generic(\$db,'user', 'rowid',\$object->".$prop['var'].",'lastname','firstname',' ');\n";
                         }else if(strpos($prop['field'],'fk_') ===0) 
                        {                           
                                $varprop.="\t\tprint select_generic(\$db,'".$prop['var']."','rowid','";
                                $varprop.= preg_replace('/_/','',ucfirst($prop['var']))."','rowid','description',";
                                $varprop.= "\$object->".$prop['var'].");\n";
                                $varprop.="\t\t}else{\n";
                                $varprop.="\t\tprint print_generic(\$db,'".$prop['var']."','rowid',";
                                $varprop.="\$object->".$prop['var'].",'rowid','description');\n";
                        }else if(strpos($property[$i]['type'],'enum')===0){
                                $varprop.="\t\tprint select_enum(\$db,'{$table}','{$prop['field']}','";
                                $varprop.= preg_replace('/_/','',ucfirst($prop['var']))."',";
                                $varprop.= "\$object->".$prop['var'].");\n";
                                $varprop.="\t\t}else{\n";
                                $varprop.="\t\tprint \$langs->trans(\$object->".$prop['var'].");\n";
                        }else                            
                        {
                                if(!empty($prop['default'])){
                                    $varprop.="\t\tif (\$new==1)\n";
                                    $varprop.="\t\t\tprint '<input type=\"text\" value=\"";
                                    $varprop.=$prop['default']."\" name=\"";
                                    $varprop.=preg_replace('/_/','',ucfirst($prop['var']));
                                    $varprop.="\">';\n\t\telse\n\t";
                                }
                                $varprop.="\t\t\tprint '<input type=\"text\" value=\"'.\$object->";
                                $varprop.=$prop['var'].".'\" name=\"";
                                $varprop.=preg_replace('/_/','',ucfirst($prop['var']))."\">';\n";  

                                $varprop.="\t\t}else{\n";
                                $varprop.="\t\t\tprint \$object->";
                                $varprop.=$prop['var'].";\n";
                        }
                        break;
                }  
                $varprop.="\t\t}\n";
                $varprop.="\t\tprint \"</td>\";\n";
                
                $varprop.=( $i%2==1)?"\t\tprint \"\\n</tr>\\n\";\n":'';
                $i++;
	}
        
}
//if there is an unpair number of line
if($i%2==1)
{
    $varprop.="\t\tprint \"<td></td></tr>\\n\";\n";
                
}



$targetcontent=preg_replace('/print "<tr><td>prop1<\/td><td>".\$object->field1."<\/td><\/tr>";/', $varprop, $targetcontent);
$targetcontent=preg_replace('/print "<tr><td>prop2<\/td><td>".\$object->field2."<\/td><\/tr>";/', '', $targetcontent);

/*
 * substitute list header
 */
$varprop='';
$i=0;
foreach($property as $key => $prop)
{
    if($i<4) // just to have some example
    {
    $varprop.="\tprint_liste_field_titre(\$langs->trans('";
    $varprop.=$prop['var']."'),\$_SERVER['PHP_SELF'],'t.";
    $varprop.=$prop['var']."','',\$param,'',\$sortfield,\$sortorder);\nprint \"\\n\";\n";
    }
    $i++;  
}
$targetcontent=preg_replace('/print_liste_field_titre\(\$langs->trans\(\'field1\'\),\$_SERVER\[\'PHP_SELF\'\],\'t\.field1\',\'\',\$param,\'\',\$sortfield,\$sortorder\);/', $varprop, $targetcontent);
$targetcontent=preg_replace('/print_liste_field_titre\(\$langs->trans\(\'field2\'\),\$_SERVER\[\'PHP_SELF\'\],\'t\.field2\',\'\',\$param,\'\',\$sortfield,\$sortorder\);/','', $targetcontent);

/*
 * substitute list rows
 */
$varprop='';
$i=0;
$varprop.="\t\tprint \"<tr class=\\\"\".((\$i%2==0)?'pair':'impair').\"\\\" >\";\n";
foreach($property as $key => $prop)
{
if($i<4) // just to have some example
    {
    
    if($prop['istime']){
        $varprop.="\t\tprint \"<td>\".dol_print_date(\$obj->";
        $varprop.=$prop['field'].",'day').\"</td>\";\n";      
    }else if(strpos($prop['field'],'fk_') ===0) {
        $varprop.="\t\tprint \"<td>\".print_generic(\$db,'".$prop['var']."','rowid',";
        $varprop.="\$obj->".$prop['field'].",'rowid','description').\"</td>\";\n";
    }else if($prop['field']=='id' || $prop['field']=='rowid'){
        $varprop.="\t\tprint \"<td>\".\$object->getNomUrl(\$obj->rowid,\$obj->rowid,'',1).\"</td>\";\n";
    }else if($prop['field']=='ref'){
        $varprop.="\t\tprint \"<td>\".\$object->getNomUrl(\$obj->ref,\$obj->ref,'',0).\"<td>\";\n";
    }else
    {                     
        $varprop.="\t\tprint \"<td>\".\$obj->".$prop['field'].".\"</td>\";\n";
    }
    }
    $i++;  
}
$varprop.="\t\tprint \"</tr>\";\n";
$targetcontent=preg_replace('/print "<tr><td>prop1<\/td><td>"\.\$obj->field1\."<\/td><\/tr>";/', $varprop, $targetcontent);
$targetcontent=preg_replace('/print "<tr><td>prop2<\/td><td>"\.\$obj->field2\."<\/td><\/tr>";/', '', $targetcontent);



// Build file
$fp=fopen($outfile,"w");
if ($fp)
{
    fputs($fp, $targetcontent);
    fclose($fp);
    print "File '".$outfile."' has been built in current directory.\n";
}
else $error++;


// -------------------- END OF BUILD_CLASS_FROM_TABLE SCRIPT --------------------

print "You can now rename generated files by removing the 'out.' prefix in their name and store them into directory /yourmodule/class.\n";
return $error;
