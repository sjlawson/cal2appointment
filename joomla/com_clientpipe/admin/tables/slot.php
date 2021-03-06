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
class TableSlot extends JTable
{
	/**
	 * Primary Key
	 *
	 * @var int
	 */
	var $slot_id = null;
	
	var $slot_title = null;
	
	var $time_start = null;
	
	var $time_end = null;
	
	var $default_slot = null;
	
	var $weekdays_csv = null;
	
	var $openings = null;

	
	/**
	 * Constructor
	 *
	 * @param object Database connector object
	 */
	function TableSlot(& $db) {
		parent::__construct('#__cp_slot', 'slot_id', $db);
	}
}