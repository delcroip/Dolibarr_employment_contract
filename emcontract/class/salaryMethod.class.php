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

/**
 * Description of salarymethod
 *
 * @author patrick
 */
class salaryMethod {
    //put your code here
   var $db;
   var $id;
   var $entity;
   var $datec;
   var $datem;
   var $description;
   var $fk_user_author;
   var $fk_user_modif;
   var $operands;
   
   
   public function __construct($db,$id='0') 
	{
		$this->db=$db;
		$this->id=$id;
	}
     /**
     *	fetch 
     *
     *	@param		int			$rowid                  salary method row id
     *	@return		int						result
     */
   
   function fetch($rowid)
   {
        $sql="SELECT emsm.rowid, emsm.entity, emsm.datec, emsm.datem, emsm.description";
        $sql.=" emsm.fk_user_author,emsm.fk_user_modif";   
        $sql.=" FROM ".MAIN_DB_PREFIX."_emcontract_salary_method as emsm";
        $sql.=' WHERE emsm.rowid="'.$rowid.'"';
        
        dol_syslog(get_class($this)."::fetch sql=".$sql, LOG_DEBUG);
        $resql=$this->db->query($sql);
        if ($resql)
        {
            if ($this->db->num_rows($resql))
            {
                $obj = $this->db->fetch_object($resql);

                $this->id               = $obj->id;
                $this->entity   	= $obj->entity;
                $this->datec    	= $obj->datem;
                $this->datem    	= $obj->datem;
                $this->description	= $obj->description;
                $this->fk_user_author   = $obj->fk_user_author;
                $this->fk_user_modif    = $obj->fk_user_modif;

            }
            $this->db->free($resql);
            return 1;
        }else
        {
            $this->error="Error ".$this->db->lasterror();
            dol_syslog(get_class($this)."::fetch ".$this->error, LOG_ERR);
            return -1;
        }	     
   }
 
     /**
     *	fetch Operands
     *
     *	@param		int			$user                   User row id
     *  @param		int                     $month                  0=no update of the calculated fields 
     *	@param		int			$year                   year to calculate
     *	@return		int						1= sucess, -1 =failure
     */
   function fetchOperands($user,$month=0,$year=0)
   {
        $error=1;
        $sql="SELECT em.base_rate, emt.weekly_hours, emt.modulation_period,";
        $sql.=" emt.working_days, emt.normal_rate_days, emt.daily_hours,";
        $sql.=" emt.night_hours_start, emt.night_rate, emt.night_hours_stop,";   
        $sql.=" emt.holiday_weekly_generated, emt.overtime_rate, emt.overtime_recup_only,";
        $sql.=" emt.weekly_max_hours, emt.weekly_min_hours, emt.daily_max_hours,";
        $sql.=" FROM ".MAIN_DB_PREFIX."_grh_contract as em";
        $sql.=" JOIN ".MAIN_DB_PREFIX."_grh_contract_type as emt";
        $sql.=" ON emt.rowid=em.fk_contract_type";
        $sql.=' WHERE em.rowid="'.$user.'"';
        
        dol_syslog(get_class($this)."::fetchOperands sql=".$sql, LOG_DEBUG);
        $resql=$this->db->query($sql);
        if ($resql)
        {
            if ($this->db->num_rows($resql))
            {
                $obj = $this->db->fetch_object($resql);
                $this->operands=array();
                $this->operands[0]            = $obj->base_rate;
                $this->operands[1]            = $obj->weekly_hours;
                $this->operands[2]            = $obj->modulation_period;
                $this->operands[3]            = $obj->working_days;
                $this->operands[4]            = $obj->normal_rate_days;
                $this->operands[5]            = $obj->daily_hours;
                $this->operands[6]            = $obj->night_hours_start;
                $this->operands[7]            = $obj->night_rate;
                $this->operands[8]            = $obj->night_hours_stop;
                $this->operands[9]            = $obj->holiday_weekly_generated;
                $this->operands[10]           = $obj->overtime_rate;
                $this->operands[11]           = $obj->overtime_recup_only;
                $this->operands[12]           = $obj->weekly_max_hours;
                $this->operands[13]           = $obj->weekly_min_hours;
                $this->operands[14]           = $obj->daily_max_hours;
                if($month && $year){
                    $error=calculateOperands($user,$month,$year);
                }
            }
            $this->db->free($resql);
            return error;
        }else
        {
            $this->error="Error ".$this->db->lasterror();
            dol_syslog(get_class($this)."::fetch ".$this->error, LOG_ERR);
            return -1;
        } 
   }
   
     /**
     *	Calculate the operands an user 
     *
     *	@param		int			$user                   User row id
     *	@param		int			$month                  month to calculate
     *	@param		int			$year                   year to calculate
     *	@return		int						1= sucess, -1 =failure
     */
   function calculateOperands($user,$month,$year)
   {
        if(!$user || !$month || !$year)
            return -1;
        $error=0;
        
        $error+=calculateNbWeeks($user,$month,$year);
        if(error<0)
            return $error;
        $error+=calculateOvertime($user,$month,$year);
        if(error<0)
            return $error;
        
        

       
       
       return 1;
   }
     /**
     *	retrieve the first working day for the user, could be in the month before
     *
     *	@param		int			$user                   User row id
     *	@param		int			$month                  month to calculate
     *	@param		int			$year                   year to calculate
     *  @param		string			$mode                   mode: theoric,raw, exact
     *	@return		date						first wokring day
     */
 function getLastWorkingDay($user,$month,$year,$mode){
       $lastDay=strtotime("last day of ".$month."/".$year);
       if($mode=="exact"){
            $lastDayWkNb=date('N',$lastDay)-1;
            // test if the week of the last day should be handled

            if($this->operands[3]-2^($lastDayWkNb)<0){ 
                // week closed, should be handled        
            }else{// week between two month, should be calculated during this month
                $lastDay=strtotime("last sunday of ".$month."/".$year);
            } 
       }
       return $lastDay;
 }
     /**
     *	retrieve the last working day for the user
     *
     *	@param		int			$user                   User row id
     *	@param		int			$month                  month to calculate
     *	@param		int			$year                   year to calculate
     *  @param		string			$mode                   mode: theoric,raw, exact
     *	@return		date						last wokring day
     */
 function getFirstWorkingDay($user,$month,$year,$mode){
       $firstDay=strtotime("first day of ".$month."/".$year);
       if($mode=="exact"){
            $firstDayWkNb=date('N',$firstDay)-1;
            $nbWeeks=0;
            //test if week of the first day should be handled
            if($this->operands[3]%2^($firstDayWkNb)==0){//could be use as the first day of the week

            }else if($this->operands[3]-2^($firstDayWkNb)<0){ 
                 // week closed, should be handled by the previous nomth
                $firstDay=strtotime("first monday of ".$month."/".$year);
            }else{// week between two month, should be calculated during this month
                $firstDay=strtotime("first monday of this week ",$firstDay);
            } 
       }
       return $firstDay;
 }
      /**
     *	retrieve the the number of weeks for an user between tzo date
     *
     *	@param		int			$user                   User row id
     *	@param		date			$first day              month to calculate
     *	@param		date			$last day               year to calculate
     *  @param		string			$mode                   mode
     *	@return		int						number of weeks
     */
 function getNbWeeks($user,$firstDay,$LastDay,$mode){
         $nbWeeks=52/12;
        if($mode=="exact"){
            //using the day number to avid issue if the last day is before thursday in december
            $nbWeeks=ciel((date('z',$lastDay)-date('z',$firstDay))/7);
        }else if($mode=="raw"){
           $nbWeeks=date('j',$lastDay)/7;
        }
       return $nbWeeks;
 }
      /**
     *	Calculate the number of weeks in the month
     *
     *	@param		int			$user                   User row id
     *	@param		int			$month                  month to calculate
     *	@param		int			$year                   year to calculate
     *	@return		int						1= sucess, -1 =failure
     */
 function calculateNbWeeks($user,$month,$year){
        $firstDay=getFirstWorkingDay($user,$month,$year,HR_WEEKCALC);
        $lastDay=getLastWorkingDay($user,$month,$year,HR_WEEKCALC);
        $this->operands[16]=getNbWeeks($user,$firstDay,$LastDay,HR_WEEKCALC);
 }
 
 

 function calculateOvertime($user,$month,$year){
  
        $weeklyHours=$this->operands[1];
        $dailyHours=$this->operands[5];
        if(($weeklyHours<=0) || ($dailyHours<=0)) // if not set calculation not possible
            return -1;
        $actuals=0;
        $holiday=0;
        $overtime=0;
        $workingDays=$this->operands[3];
        $nbWkDays=0;
        // calculate the number of possible working days
         $MTWTFSS=sprintf( "%07d", decbin($openDays));
        for($i=0;$i<7;$i++){
            if($MTWTFSS[$i]==1)
                $nbWkDays++;
        }    
        switch ($this->operands[2])
        {
            case 1:// if the modulation period is the month

                    
                //FIXME
                break;
            case 3:// if the modulation period is the quarter              
                if($month%3==0){ // calculate only after the end of the quarter
                    //FIXME
                }
                break;
            case 6:// if the modulation period is the semester
                if($month==6 ||$month==12){ // calculate only after the end of the semester
                    //FIXME
                }
                break;
            case 12:// if the modulation period is the year
                if($month==12){ // calculate only after the end of the year
                    //FIXME
                }
                break;

            case 0:// if the modulation period is the week
                $firstDay=getFirstWorkingDay($user,$month,$year,"exact");
                $lastDay=getLastWorkingDay($user,$month,$year,"exact");
                $nbWeeks =getNbWeeks($user,$firstDay,$LastDay,"exact");
                for($i=0;$i<$nbWeeks;$i++)
                {
                    $lastDay=strtotime('next sunday',$firstDay);
                    $actuals=fetchActuals($user,$firstDay,$lastDay);
                    $holiday=fetchHoliday($user,$firstDay,$lastDay,$workingDays,1);
                    if($actuals>=0 && $holiday>=0){
                        //get the number of day that he should work
                        //$nbWkDays=round($weeklyHours/$dailyHours);
                        $expectedHours=($nbWkDays-$holiday)/$nbWkDays*$weeklyHours;
                        //$expectedHours=$weeklyHours-$holiday*$dailyHours;
                        //$expectedHours=($nbWkDays-$holiday)*$dailyHours;
                        if($expectedHours<0){
                            $expectedHours=0;
                        }elseif ($expectedHours>$weeklyHours) {
                            $expectedHours=$weeklyHours;
                        }
                       $overtime+=$actuals-($expectedHours);
                    }else{
                       $overtime=-1;
                       break;
                    }
                    $firstDay=  strtotime('next monday',$firstDay);
                    
                }
                break;
  

            default:
                
                break;
        }
        //FIXME

        
 }
 
       /**
     *	fetch Actuals
     *
     *	@param		int			$user                   User row id
     *	@param		date			$firstDay               first day of the assesement period
     *	@param		date			$lastDay                first day of the assesement period
     *	@return		int						number of hours worked this week
     */ 
 function fetchActuals($user,$firstDay,$lastDay){
        if(empty($firstDay)||empty($user)||empty($lastDay))
            return -1;
        $actuals=0;
        $sql = "SELECT SUM(ptt.task_duration)";	
        $sql .= " FROM ".MAIN_DB_PREFIX."projet_task_time AS ptt";
        $sql .= " WHERE ptt.fk_user='".$user."'";
        $sql .= " AND (ptt.task_date>=FROM_UNIXTIME('".$firstDay."')) ";
        $sql .= " AND (ptt.task_date<FROM_UNIXTIME('".strtotime($firstDay.' + 1 days')."'));";
        dol_syslog(get_class($this)."::fetchActuals sql=".$sql, LOG_DEBUG);
        $resql=$this->db->query($sql);
        if ($resql)
        {
                $num = $this->db->num_rows($resql);
                if($num)
                {
                        $error=0;
                        $obj = $this->db->fetch_object($resql);
                        $actuals= $obj->task_duration/360000;
                }
                $this->db->free($resql);
                return $actuals;
         }
        else
        {
                $this->error="Error ".$this->db->lasterror();
                dol_syslog(get_class($this)."::fetchActuals".$this->error, LOG_ERR);
                return -1;
        }
  
        
 }

        /**
     *	fetch holiday 
     *
     *	@param		int			$user                   User row id
     *	@param		date			$firstDay               first day of the assesement period
     *	@param		date			$lastDay                first day of the assesement period
     *	@param		int			$openDays               Monday 2^0, Tuesday 2^1,   
     *	@param		int			$publicHoliday          0 - don't fetch public holiday, 1- fetch it  
     *	@return		int						number of hours worked this week
     */ 
 function fetchHolidays($user,$firstDay,$lastDay,$openDays,$publicHoliday=0){
      //
        if(empty($yearWeek)||empty($user))
            return -1;
        //$firstDay=strtotime("monday of this week ",$yearWeek);
        //$lastDay=strtotime("monday of next week ",$yearWeek);
        $nbPHD=($publicHoliday)?fetchPublicHoliday($firstDay,$lastDay,$openDays):0;
        $sql = "SELECT hd.date_debut,hd.date_fin,hd.halfday";	
        $sql .= " FROM ".MAIN_DB_PREFIX."holiday AS hd";
        $sql .= " WHERE hd.fk_user='".$user."'";
        $sql .= " AND (hd.statut='3') ";
        $sql .= " AND ((hd.date_fin>=FROM_UNIXTIME('".strtotime($yearWeek)."')) ";
        $sql .= " OR (hd.date_debut<FROM_UNIXTIME('".strtotime($yearWeek.' + 7 days')."')));";
        dol_syslog(get_class($this)."::fetchHolidays sql=".$sql, LOG_DEBUG);
        $resql=$this->db->query($sql);
        $nbHD=0;
        if ($resql)// FIXME remove not workingday
        {
                $halfday=0;
                $num = $this->db->num_rows($resql);
                for($i=0;$i<$num;$i++)
                {
                        $error=0;
                        $obj = $this->db->fetch_object($resql);
                        // define the limites of the holiday within the week
                        if($obj->date_debut < $firstDay ){ //fixme need time not date
                            $firstHoliday=$firstDay;
                        }else{
                            $firstHoliday=$obj->date_debut;
                            if($obj->halfday==-1 ||$obj->halfday==2)
                                $halfday++;
                        }
                        if($obj->date_fin > $lastDay ){ //fixme need time not date
                            $lastHoliday=$lastDay;
                        }else{
                            $lastHoliday=$obj->date_debut;
                            if($obj->halfday==1||$obj->halfday==2)
                                $halfday++;
                        }
                        // count the days 
                        $nbHDRaw=$firstHoliday->diff($lastHoliday)->format("%a");
                        //remove the non woking days
                        ////get the day (monday, tues ...) of hte first day
                        $fday=$firstHoliday->format("%N");
                        //transforn OpenDays to a string of bit first for monday ....
                        $MTWTFSS=sprintf( "%07d", decbin($openDays));
                        // remove the non open day from the vacation count
                        for($i=$fday-1;$i<$nbHDRaw+$fday;$i++){
                            if($MTWTFSS[$i%7]==0)
                                $nbHDRaw--;
                        }                      
                        $nbHD+=$nbHDRaw;
                        
                        // remove the public holiday part of the holiday
                        if($nbPHD)
                           $nbPHD-=fetchPublicHoliday($firstHoliday,$lastHoliday,$openDays); 
                }
                $this->db->free($resql);
                return $nbHD+$nbPHD;
         }
        else
        {
                $this->error="Error ".$this->db->lasterror();
                dol_syslog(get_class($this)."::fetchHolidays".$this->error, LOG_ERR);
                return -1;
        }       
 }
     /**
     *	fetch public holiday 
     *
     *	@param		date			$firstDay               first day of the assesement period
     *	@param		date			$lastDay                first day of the assesement period
     *	@return		int						number of public holiday
     */ 
 function fetchPublicHoliday($firstDay,$lastDay, $openDays){
     $publicUser=0; // fixme
     return fetchHolidays($publicUser,$firstDay,$lastDay,$openDays,0);
 }
      /**
     *	fetch data from the POST tab
     *
     *	@param		array			$matrix                    array containing all the Salary Method info
    *	@return		int						   0 - sucess | -1 failure
     */ 
 
 function fetchFromTab($matrix){
    $ret=0;
        //FIXME
    return $ret;
 }
       /**
     *	create a new Salary methode in the db
     *
    *	@return		int						   0 - sucess | -1 failure
     */ 
 
 function create(){
    $ret=0;
        //FIXME
     return $ret;
 }
       /**
     *	delete a new Salary methode in the db
     *
    *	@return		int						   0 - sucess | -1 failure
     */ 
 
 function delete(){
    $ret=0;
        //FIXME
     return $ret;
 } 
    /**
    *	create a new Salary methode in the db
    *
    *	@return		int						   0 - sucess | -1 failure
     */ 
 
 function update(){
    $ret=0;
        //FIXME
     return $ret;
 }
}//end class



