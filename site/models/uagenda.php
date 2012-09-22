<?php
/**
 * Nucleocal Model for Nucleocal World Component
 * 
 * @package    Joomla.Tutorials
 * @subpackage Components
 * @link http://dev.joomla.org/component/option,com_jd-wiki/Itemid,31/id,tutorials:components/
 * @license		GNU/GPL
 */

// Check to ensure this file is included in Joomla!
defined('_JEXEC') or die();

jimport( 'joomla.application.component.model' );

/**
 * Nucleocal Model
 *
 * @package    Joomla.Tutorials
 * @subpackage Components
 */
class NucleocalModelUagenda extends JModel
{
	/**
	 * Gets the greeting
	 * @return string The greeting to be displayed to the user
	 */
	
	function getGreeting()
	{
		$db =& JFactory::getDBO();

		$query = 'SELECT greeting FROM #__nc_nucleocal';
		$db->setQuery( $query );
		$greeting = $db->loadResult();

		return $greeting;
	}
	function getTitle()
	{
	$db =& JFactory::getDBO();

		$query = 'SELECT calendar_title FROM #__nc_nucleocal';
		$db->setQuery( $query );
		$ncTitle = $db->loadResult();

		return $ncTitle;	
	}
	function getOptions()
	{
	$db =& JFactory::getDBO();

		$query = 'SELECT * FROM #__nc_options';
		$db->setQuery( $query );
		$ncOptions = array();
		$objOptions = $db->loadObjectList();	
		foreach($objOptions as $option) {
			$ncOptions[$option->field_name] = $option->field_value;
		}
		
		return $ncOptions;
	}
	
	public function getStaff($staff_id = null) {
		$db =& JFactory::getDBO();
		if($staff_id) {
		$query = "SELECT * , CONCAT_WS(' ', `firstname` , `lastname`) AS StaffName FROM `#__nc_staff` WHERE `staff_id` = $staff_id";
		$db->setQuery($query);
		$dbResult = $db->loadObject();
		return $dbResult;
		} else {
			$query = "SELECT * , CONCAT_WS(' ', `firstname` , `lastname`) AS StaffName FROM `#__nc_staff` ORDER BY lastname";
		$db->setQuery($query);
		$dbResult = $db->loadObjectList();
		return $dbResult;
			
		}
	}
	
	function getAppointments()
	{
		if(!isset($user)) 
		$user =& JFactory::getUser();
		if($user->guest)
		return false;
		$db =& JFactory::getDBO();
				
		$query = "SELECT a.*,  t.`time_start` AS StartTime, t.`time_end` AS EndTime 
		FROM `#__nc_appointment` a, `#__nc_slot` t
		 WHERE a.`email` = '".$user->email . "' AND a.`app_date` >= ".date('Y-m-d')."
		 AND a.`slot_id` = t.`slot_id`";
		
		$db->setQuery($query);
		$dbResult = $db->loadObjectList();
		
		return $dbResult;
		
	}
	
	
}
