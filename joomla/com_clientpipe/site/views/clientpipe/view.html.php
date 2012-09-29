<?php


jimport( 'joomla.application.component.view');

/**
 * HTML View class for the ClientpipeWorld Component
 *
 * @package		SteamPower.ClientPipe
 * @subpackage	Components
 */


class ClientpipeViewClientpipe extends JView
{
	var $greeting;
	var $title;
	var $resultMsg = null;
	
	function display($tpl = null)
	{
		
		$postToken = JRequest::getVar('ncFormtoken');
		if($postToken == md5("clientpipe")) 
			$this->saveAppointment();
		
		$this->greeting = $this->get( 'Greeting' );
		$this->assignRef( 'greeting',	$this->greeting );
		$this->ncTitle = $this->get( 'Title' );
		
		parent::display($tpl);
	}
	
	public function saveAppointment() {
		if(!isset($dbo))
			$dbo =& JFactory::getDBO();
		$slot_id = JRequest::getVar('slot_id');
			$app_date = JRequest::getVar('app_date');
			$req_staff_id = JRequest::getVar('req_staff_id');
			
			$firstname = $_POST['firstname'];
			$lastname = JRequest::getVar('lastname');
			$email = JRequest::getVar('email');
			$phone = JRequest::getVar('phone');
			$notes = JRequest::getVar('notes');
			$staffid = JRequest::getVar('staffid');
			
			
			$strDate = date('d-M-Y', strtotime($app_date));
			
			$dummyCal = new inc_calendar();
			$dummyCal->loadOptions();
			
		$queryCheck = "SELECT * FROM `#__cp_appointment` WHERE 
			DATE_FORMAT(`app_date`,'%c') = DATE_FORMAT( ".date('Y-m-d', strtotime($app_date)).", '%c') 
			AND `email` = '$email'";
		$dbo->setQuery($queryCheck);
		$CheckApps = $dbo->loadObjectList();
		if(count($CheckApps) >= (int)$dummyCal->nc_options['app_monthly_limit'] && (int)$dummyCal->nc_options['app_monthly_limit'] > 0) {
			echo "<h3>You have already scheduled the maximum allowed number of appointments for this month 
					(".$dummyCal->nc_options['app_monthly_limit']."</h3>";
			exit;
		}	
			
			$strAppTime = JRequest::getVar('strAppTime');
			$stafflist = explode(",",(JRequest::getVar('stafflist') ) );
			
			$query = "SELECT * FROM `#__cp_appointment` WHERE `staff_id` = $req_staff_id AND `date` = $app_date AND `slot_id` = $slot_id";
			$dbo->setQuery($strQuery);
			$StaffAvail = $dbo->loadObject();
			if($StaffAvail && $StaffAvail->appointment_id) {
				$StaffAvail = false;
			} else
			$StaffAvail = true;
			
			if($dummyCal->nc_options['auto_assign_staff'] && $StaffAvail) {
				$strQuery = "INSERT INTO `#__cp_appointment` 
					(`slot_id`,`app_date`,`req_staff_id`,`staff_id`, `firstname`,`lastname`,`email`,`phone`,`notes` ) 
					VALUES ( $slot_id, '$app_date', $req_staff_id, $req_staff_id, '$firstname', '$lastname', '$email', '$phone', '$notes' )";
			
			} elseif($dummyCal->nc_options['auto_assign_staff'] && (!$StaffAvail || !$req_staff_id)) {
				$query = "SELECT * FROM `#__cp_staff` WHERE `staff_id` NOT IN (
				SELECT * FROM `#__cp_appointment` WHERE `staff_id` = $req_staff_id AND `date` = $app_date AND `slot_id` = $slot_id
				)";
				$dbo->setQuery($query);
				$objAvailableStaff = $dbo->loadObject();
				$req_staff_id = $objAvailableStaff->staff_id;
				
				$strQuery = "INSERT INTO `#__cp_appointment` 
					(`slot_id`,`app_date`,`req_staff_id`,`staff_id`, `firstname`,`lastname`,`email`,`phone`,`notes` ) 
					VALUES ( $slot_id, '$app_date', $req_staff_id, $req_staff_id, '$firstname', '$lastname', '$email', '$phone', '$notes' )";
			
			} else
			$strQuery = "INSERT INTO `#__cp_appointment` 
					(`slot_id`,`app_date`,`req_staff_id`,`firstname`,`lastname`,`email`,`phone`,`notes` ) 
					VALUES ( $slot_id, '$app_date', $req_staff_id, '$firstname', '$lastname', '$email', '$phone', '$notes' )";
			
			
			$dbo->setQuery($strQuery);
			if(!$dbo->query()) {
				$this->resultMsg = "We're sorry, your appointment cannot be scheduled or the information you submitted was incorrect
				<br />";
				
			} else {
				if($req_staff_id == "NULL")
				$req_staff_id = null;
				
				if($req_staff_id) {
					$dbo->setQuery("SELECT * FROM `#__cp_staff` WHERE `staff_id` = $req_staff_id");
						$objStaff = $dbo->loadObject();
						$message = "Please check your schedule, \n $firstname $lastname has requested an appointment on \n
						$strDate \n
						Time: $strAppTime \n
						Thank you!
						";
						if($objStaff->email)
						mail($objStaff->email, "Appointment Request", $message);
					
				} else if(is_array($stafflist)) {
					
					foreach($stafflist as $staffid) {
						$dbo->setQuery("SELECT * FROM `#__cp_staff` WHERE `staff_id` = $staffid");
						$objStaff = $dbo->loadObject();
						$message = "Please check your schedule, \n $firstname $lastname has requested an appointment on \n
						$strDate \n
						Time: $strAppTime \n
						Thank you!
						";
						if($objStaff->email)
						mail($objStaff->email, "Appointment Request", $message);
						
					}
				}
				if($dummyCal->nc_options['auto_assign_staff'] && $req_staff_id) { 
					$dbo->setQuery("SELECT * FROM `#__cp_staff` WHERE `staff_id` = $req_staff_id");
						$objStaff = $dbo->loadObject();
					$staffMsg = "<br />Your appointment has been scheduled with ".$objStaff->firstname." ".$objStaff->lastname."<br />";
				
				}
				else 
					$staffMsg = "";
				
				$message = "Thank you for requesting an appointment. For your records, please note the following information: \n
				$staffMsg
				Date of appointment: $strDate \n
				Time of appointment: 
				$strAppTime \n
				
				Thank you!
				";
				mail($email, "Your appointment request has been submitted", $message);
				
				$this->resultMsg = "Thank you for scheduling an appointment. $staffMsg
				The appointment date and time have been sent to the Email address you submitted on the form.";
				
			}
			
			
	}
	
	
}

include (JPATH_COMPONENT.DS.'views'.DS.'elements'.DS.'inc_calendar.inc.php');

