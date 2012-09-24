<?php


jimport( 'joomla.application.component.view');

/**
 * HTML View class for the ClientpipeWorld Component
 *
 * @package		SteamPower.ClientPipe
 * @subpackage	Components
 */


class ClientpipeViewAppform extends JView
{
	var $greeting;
	var $title;
	var $resultMsg = null;
	
	function display($tpl = null)
	{
		
		
		$this->greeting = $this->get( 'Greeting' );
		$this->assignRef( 'greeting',	$this->greeting );
		$this->ncTitle = $this->get( 'Title' );
		
		parent::display($tpl);
	}
	
	
	
}

include (JPATH_COMPONENT.DS.'views'.DS.'elements'.DS.'inc_calendar.inc.php');

class inc_calendar_older
{
	
	var $nc_options = array();
	
	var $cal = "CAL_GREGORIAN";
	var $format = "%Y%m%d";
	var $today;
	var $day;
	var $month;
	var $year;
	var $pmonth;
	var $pyear;
	var $nmonth;
	var $nyear;
	var $wday_names;
	var $weekNum;
	
	
	
	function dateNow($month,$year)
	{
		if(empty($month))
			$this->month = strftime("%m",time());
		else
			$this->month = $month;
		if(empty($year))
			$this->year = strftime("%Y",time());	
		else
		$this->year = $year;
		$this->today = strftime("%d",time());		
		$this->pmonth = $this->month - 1;
		$this->pyear = $this->year - 1;
		$this->nmonth = $this->month + 1;
		$this->nyear = $this->year + 1;
	}

	function daysInMonth($month,$year)
	{
		if(empty($year))
			$year = inc_calendar::dateNow("%Y");

		if(empty($month))
			$month = inc_calendar::dateNow("%m");
		
		if($month == 2)
		{
			if(inc_calendar::isLeapYear($year))
			{
				return 29;
			}
			else
			{
				return 28;
			}
		}
		else if($month==4 || $month==6 || $month==9 || $month==11)
			return 30;
		else
			return 31;
	}

	 function isLeapYear($year)
	{
      return (($year % 4 == 0 && $year % 100 != 0) || $year % 400 == 0); 
	}

 	function dayOfWeek($month,$year) 
	{ 
		$dow = date('w', strtotime("$year-$month-1"));
		
		$totWeeks = date('W'); //, strtotime("$year-$month-01"));
		if($totWeeks > 5) {
			$firstOfMonth = strtotime("$year-$month-01");
			$LastMonth = $firstOfMonth - 86400;
			
			$prevWeeks = date('W', $LastMonth);
			
		}
		else
			$prevWeeks = 0;
		
		
		$this->weekNum = $totWeeks - $prevWeeks;
		if($this->weekNum < 1) $this->weekNum = 1;
		if(date('W',$firstOfMonth) == date('W',$LastMonth) )
		$this->weekNum++;
		
		return $dow;
	}

	 function getWeekDay()
	{
		$week_day = inc_calendar::dayOfWeek($this->month,$this->year);
		//return $this->wday_names[$week_day];
		return $week_Day;
	}
		
	function getDayEvents($year, $month, $day)
	{
		$return = "";
		//return $return;
		$eventstr = "";
		if(!isset($dbo))
		$dbo =& JFactory::getDBO();
		//check for events
		$sql = "SELECT * FROM #__cp_event WHERE `event_start` LIKE '".date('Y-m-d')."%'";
		$dbo->setQuery($sql);
		$objEvents = $dbo->loadObjectList();
		if($objEvents)
		foreach ($objEvents as $event) {
			$return .= $event->title.'<br />';
		}
		$eventstr = $return;
		//load slots
		
		$sql = "SELECT * FROM #__cp_slot WHERE `default_slot` = 1 AND `weekdays_csv` LIKE '%".date('D',strtotime("$year-$month-$day"))."%' ORDER BY `time_start`";
		$dbo->setQuery($sql);
		$objSlots = $dbo->loadObjectList();
		
		if($objSlots)
		foreach ($objSlots as $slot) {
			$slotReturn = '';
			$slotTimes = date("g:ia",strtotime("$year-$month-$day ".$slot->time_start)).
					"-".date("g:ia",strtotime("$year-$month-$day ".$slot->time_end));	
			$TSdate = strtotime("$year-$month-$day");
			$sql = "SELECT * FROM `#__cp_appointment` WHERE `slot_id` = ".$slot->slot_id." AND `app_date` LIKE '$year-$month-$day%'";
			$dbo->setQuery($sql);
			$objBookings = $dbo->loadObjectList();
			if($objBookings && count($objBookings) >= $slot->openings)
				$blnAvailable = false;
			else
				$blnAvailable = true;
			
			if($blnAvailable)
			$slotReturn .= '<a class="clientpipeLink" href="javascript:void(null);" onclick="bookAppointment(\''.$slot->slot_id.'\',\''.$TSdate.'\');">';
			if($slot->slot_title)
			$slotReturn .= '<span class="slotTitle">'.$slot->slot_title.'</span><br />';
			$slotReturn .= '<span class="slotTimes">'.$slotTimes.'</span>'; 
			if($blnAvailable)
			$slotReturn .= '</a>';
			
			$slotReturn .= '<br />';
			
			
			//load exceptions
			$sql = "SELECT e.*, s.* FROM #__cp_exception e, #__cp_slot s 
				WHERE e.`exception_date` LIKE '$year-$month-$day%' 
				AND e.`slot_id` = s.`slot_id` AND s.`slot_id` = ".$slot->slot_id;
			$dbo->setQuery($sql);
			$objCurrentSlotExcp = $dbo->loadObject();
			$on_staff = array();
			$off_staff = array();
			$openings = $slot->openings;
			if($objCurrentSlotExcp) {
				if($objCurrentSlotExcp->openings)
				$openings = $objCurrentSlotExcp->openings;
				
				if($objCurrentSlotExcp->on_staff_id_csv) 
					$on_staff=explode(',',$objCurrentSlotExcp->on_staff_id_csv);
				
				if($objCurrentSlotExcp->off_staff_id_csv) 
					$off_staff=explode(',',$objCurrentSlotExcp->off_staff_id_csv);
				
				//get extra staff
				if($objCurrentSlotExcp->on_staff_id_csv && $objCurrentSlotExcp->on_staff_id_csv != "") {
				$sql = "SELECT * FROM #__cp_staff WHERE `staff_id` IN (".$objCurrentSlotExcp->on_staff_id_csv.") ORDER BY `lastname` ";
				$dbo->setQuery($sql);
				$objExcpStaff = $dbo->loadObjectList();
				}
				
			}
			if(!$openings) $openings = 3;
			
			if($this->nc_options['show_staff']) {
				$slotReturn .= '<span class="staffNames">';
				//get staff names
				$sql = "SELECT s.* FROM #__cp_staff s, #__cp_slot_alloc a
						WHERE s.`staff_id` = a.`staff_id` 
						AND a.`slot_id` = ".$slot->slot_id." 
						ORDER BY s.`lastname`";
				$dbo->setQuery($sql);
				$objStaffList = $dbo->loadObjectList();
				
				if($objStaffList) {
					$stafflist = "";
				foreach($objStaffList as $staff) {
					
					if(!in_array($staff->staff_id,$off_staff) )
					$stafflist .='<a class="clientpipeLink" href="javascript:void(null);" onclick="bookAppointment(\''.$slot->slot_id.'\',\''.$TSdate.'\',\''.$staff->staff_id .'\');">';
					$stafflist .= substr($staff->firstname,0,1).". ".$staff->lastname.'</a><br />';
				}
				if(isset($objExcpStaff))
				foreach($objExcpStaff as $excpStaff) {
					$stafflist .='<a class="clientpipeLink" href="javascript:void(null);" onclick="bookAppointment(\''.$slot->slot_id.'\',\''.$TSdate.'\',\''.$excpStaff->staff_id .'\');">';
					$stafflist .= substr($excpStaff->firstname,0,1).". ".$excpStaff->lastname.'</a><br />';
				}
				 if($stafflist == "")
				 $stafflist = "unassigned<br />";
				 $slotReturn .= $stafflist;
				} else
				if(!$objStaffList && !$objExcpStaff)
					$slotReturn .= "unassigned<br />";
			
				$slotReturn .= '</span>';
			}
			$slotReturn .= "<div class='slotSeparator'>&nbsp;</div>";
			
			if($objCurrentSlotExcp && $objCurrentSlotExcp->all_off == 1)
			$slotReturn = "";
			
			$return .= $slotReturn;
		}
		
		
		//load any exceptions that add a non-default slot
		$sql = "SELECT e.* FROM #__cp_exception e, #__cp_slot s 
			WHERE e.`exception_date` LIKE '$year-$month-$day%' 
			AND e.`slot_id` = s.`slot_id` AND s.`default_slot` = 0";
		$dbo->setQuery($sql);
		$objIrregularSlots = $dbo->loadObjectList();
		$slotReturn = "";
		if($objIrregularSlots) {
		foreach ($objIrregularSlots as $slot) {
			$slotTimes = date("g:ia",strtotime("$year-$month-$day ".$slot->time_start)).
					"-".date("g:ia",strtotime("$year-$month-$day ".$slot->time_end));	
			if(!$slot->openings)
			 $openings = 3;
			else
			 $openings = $slot->openings;
			if($slot->slot_title)
			$slotReturn .= '<span class="slotTitle">'.$slot->slot_title.'</span><br />';
			$slotReturn .= '<span class="slotTimes">'.$slotTimes.'</span><br /><span class="staffNames">';
			$sql = "SELECT * FROM #__cp_staff WHERE `staff_id` IN (".$slot->on_staff_id_csv.") ORDER BY `lastname` LIMIT $openings";
			$dbo->setQuery($sql);
			$objStaffList = $dbo->loadObjectList();
			if($objStaffList)
			foreach($objStaffList as $staff) {
				$slotReturn .= substr($staff->firstname,0,1).". ".$staff->lastname.'<br />';
			}
			$slotReturn = substr($slotReturn,0,-6);
			$slotReturn .= '</span>';
		}
		$return .= $slotReturn;
		}
		
		//lastly check for an ALL_OFF exception w/o slot id (meaning everyone is off)
		$sql = "SELECT * FROM #__cp_exception 
			WHERE `exception_date` LIKE '$year-$month-$day%' AND `all_off` = 1 AND (`slot_id` IS NULL OR `slot_id` = 0) LIMIT 1";
		$dbo->setQuery($sql);
		$alloff = $dbo->loadObject();
		if($alloff)	
		   return $eventstr;
		
		return $return;
	}
	
	function getDayDetails($year, $month, $day)
	{
		//Return a more detailed list of events to be displayed in pop-up box
		return null;
		/*
		$count = 0;
		$query = "SELECT heading, body, DATE_FORMAT(date, '%W, %b %D, %Y') as Date, DATE_FORMAT(date, '%T') as hours24, DATE_FORMAT(date, '%l:%i%p') as time 
		FROM events WHERE DATE_FORMAT(date, '%Y %m %d') = '$year $month $day' ORDER BY hours24";
		$result = mysql_query($query);
		if(!$result) return null;
		$return = "";
		while($thisEvent = mysql_fetch_object($result))
		{
			if ($count != 0) $return .= "<br /><hr>";
			else $return = "<h3 style='margin-top: 0px;'>".$thisEvent->Date."</h3>";
			if($thisEvent->time != "12:00AM") $return .= $thisEvent->time." - ";
			$return .= "<b>".$thisEvent->heading."</b><br />";
			if($thisEvent->body)
			$return .= $thisEvent->body;
			$count++;
		}
		return stripslashes($return);
		*/
	}
	public function loadOptions() {
		if(!isset($dbo))
			$dbo =& JFactory::getDBO();
		$dbo->setQuery("SELECT * FROM `#__cp_options`");
		$objOptions = $dbo->loadObjectList();
		foreach($objOptions as $option) {
			$this->nc_options[$option->field_name] = $option->field_value; 
		}
		
	}

	function showThisMonth($month = null, $year = null)
	{
		/* default options, retrievable from inc_calendar::nc_options[] are:
		 * show_staff = 0
		 * sync_staff_openings = 0
		 * auto_assign_staff = 0
		 * allow_staff_req = 0
		 * display_greeting = 0
		 * display_title = 0
		 * 
		 */
		if(!count($this->nc_options))
		$this->loadOptions();
		
		$comWebPath = "components" . DS . "com_clientpipe" . DS;
		$this->wday_names = array();// yahoo's php interpreter really sucks - array() won't work right
		$this->wday_names[0] = "Sun";
		$this->wday_names[1] = "Mon";
		$this->wday_names[2] = "Tue";
		$this->wday_names[3] = "Wed";
		$this->wday_names[4] = "Thu";
		$this->wday_names[5] = "Fri";
		$this->wday_names[6] = "Sat";
		
			
		
		if($month);
		$this->month = $month;
		if($year)
		$this->year = $year;
		$monthTimeStamp = strtotime("20-".$this->month."-".$this->year);
        $width = 92;
        $height = 80;
		print '<table class="calendarTable" align="center" >';
		//print '<tr><td class="calendar" colspan="7">Month & Year: <b>'.$this->month ." / " .$this->year .'</b></td></tr>';
		print '<tr>
			<td id="prevBtnTD" colspan="2" style="height: 25px;text-align: right;margin-bottom:0px; padding-bottom: 0px;" valign="bottom">
			<img id="prevBtnImg" onclick="showPrevMonth();" src="'.$comWebPath.'images'.DS.'cal_prev.png" />
			</td>
			<td valign="bottom" class="monthTitle" colspan="3" style="height: 25px !important;text-align:center;" >
			'.date('F Y',$monthTimeStamp).'
			</td>
			<td id="nextBtnTD valign="bottom" colspan="2" style="height: 25px;text-align: left;">
			<img id="nextBtnImg" onclick="showNextMonth();" src="'.$comWebPath.'images'.DS.'cal_next.png" />
			</td>
			</tr>';
		
		print '<tr ><td colspan="7"><table class="weekdayrow"><tr> ';
		for($i=0;$i<7;$i++)
			print '<td  width= "'.$width.'" height="30" align="center" >'. $this->wday_names[$i]. '</td>';
		print '</tr></table></td></tr>';		
		$wday = inc_calendar::dayOfWeek($this->month,$this->year);
		
		$no_days = inc_calendar::daysInMonth($this->month,$this->year);
		$count = 1;
		$rownum = 1;
		if($this->weekNum == 1 || date('n') != $this->month ) {
			print '<tr class=\'rowMaximise\' id = "calrow1">';
		} else 
		print '<tr class=\'rowMinimise\' id = "calrow1">';
		
		for($i=1;$i<=$wday;$i++)
		{
			print '<td class="calendar" onclick="showCalRow(\''.$rownum.'\');" style="background-color: #cccccc !important;"  align="center">
			<div style="width: 100%; height: 100%">&nbsp;</div></td>';
			$count++;
		}
		
		for($i=1;$i<=$no_days;$i++)
		{ 
			if($count > 4) 
				$side = "left";
			else 
				$side = "right";
		
			if(strlen((string)$i) == 1 ) 
				$i = "0".$i;
				
			$hint = addslashes($this->getDayDetails($this->year, $this->month, $i));
			$hint = str_replace("\r\n","<br />",$hint);
			
			if($i == $this->today && $this->month == date('m') ) 
				print '<td onclick="showCalRow(\''.$rownum.'\')" id="day" class="calendarToday">';	
			else
				print '<td onclick="showCalRow(\''.$rownum.'\')" id="day" class="calendarDay">';
				
			print '<div class="dayNum" >'.$i.'</div>';
			
			if($hint)
				print "<a href='#cal' class=\"hintanchor\" title=\"$hint\">";
				
			print '<div class="calEvent"><div class="clickme">Click Row</div>';
			print $this->getDayEvents($this->year, $this->month, $i);
			//print 'Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua.';
			print '</div>';
			
			if ($hint) 
				print '</a>';
			
			print "</td>";
			
			
				
			if($count > 6) {
				$rownum++;
				if($this->weekNum == $rownum && date('n') == $this->month) {
					print "</tr><tr class='rowMaximise' id='calrow$rownum'>";

				} else 
				print "</tr><tr class='rowMinimise' id='calrow$rownum'>";
				$count = 0;
				
			} 
			$count++;
			if($i == $no_days && $count < 7 && $count > 0) {
				for($x = $count ;$x <= 7; $x++) {
					print '<td class="calendar" onclick="showCalRow(\''.$rownum.'\');"
					style="background-color: #cccccc !important;" align="center">
					<div style="width: 100%; height: 100%">&nbsp;</div></td>';
				}
			} 
		}
		print '</tr></table>';
	}
	
}

?>
