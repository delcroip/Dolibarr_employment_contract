<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of salarymethod
 *
 * @author patrick
 */
class salarymethod {
    //put your code here
   var $id;
   var $entity;
   var $datec;
   var $datem;
   var $description;
   var $fk_user_author;
   var $fk_user_modif;
   var $operands;
   
   
   
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
       if(!$month || !$year)
           return -1;
       //FIXME, JOIN needed with opendays
        $sql='SELECT ptt.rowid, SUM(ptt.task_duration), WEEK(ptt.task_date)';
        $sql.=' FROM llx_projet_task_time AS ptt';
        $sql.=' WHERE ptt.fk_user="2"';
        $sql.=' AND MONTH(ptt.task_date)="2"';
        $sql.=' AND YEAR(ptt.task_date)="2015"';
        $sql.=' GROUP BY WEEK(ptt.task_date)';
        $sql.=' ORDER BY WEEK(ptt.task_date)'; 
       
       
       return $error;
   }


}//end class



