<?php
/**
 * Nucleocal World table class
 * 
 * @package    Joomla.Tutorials
 * @subpackage Components
 * @link http://docs.joomla.org/Developing_a_Model-View-Controller_Component_-_Part_4
 * @license		GNU/GPL
 */

// No direct access
defined( '_JEXEC' ) or die( 'Restricted access' );

/**
 * Nucleocal Table class
 *
 * @package    Joomla.Tutorials
 * @subpackage Components
 */
class TableAppointment extends JTable
{
	/**
	 * Primary Key
	 *
	 * @var int
	 */
	var $appointment_id = null;

	var $slot_id = null;
	
	var $app_date = null;
	
	var $staff_id = null;
	
	var $firstname = null;
	
	var $lastname = null;
	
	var $email = null;
	
	var $phone = null;
	
	var $notes = null;
	
	var $req_staff_id = null;
	
	/**
	 * Constructor
	 *
	 * @param object Database connector object
	 */
	function TableAppointment(& $db) {
		parent::__construct('#__nc_appointment', 'appointment_id', $db);
	}
}