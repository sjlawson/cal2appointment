<?php
/**
 * Clientpipe World table class
 * 
 * @package    SteamPower.ClientPipe
 * @subpackage Components
 * @link http://docs.joomla.org/Developing_a_Model-View-Controller_Component_-_Part_4
 * @license		GNU/GPL
 */

// No direct access
defined( '_JEXEC' ) or die( 'Restricted access' );

/**
 * Clientpipe Table class
 *
 * @package    SteamPower.ClientPipe
 * @subpackage Components
 */
class TableStaff extends JTable
{
	/**
	 * Primary Key
	 *
	 * @var int
	 */
	var $staff_id = null;
	
	var $firstname = null;
	
	var $lastname = null;
	
	var $email = null;
	
	var $contact_info = null;
	


	
	/**
	 * Constructor
	 *
	 * @param object Database connector object
	 */
	function TableStaff(& $db) {
		parent::__construct('#__cp_staff', 'staff_id', $db);
	}
}