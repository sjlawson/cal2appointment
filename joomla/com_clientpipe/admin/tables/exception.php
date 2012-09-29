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
class TableException extends JTable
{
	/**
	 * Primary Key
	 *
	 * @var int
	 */
	var $exception_id = null;

	var $exception_date = null;
	
	var $slot_id = null;
	
	var $on_staff_id_csv = null;
	
	var $off_staff_id_csv = null;
	
	var $all_off = null;
	
	var $openints = null;
	
	var $recurrences = null;
	
	/**
	 * Constructor
	 *
	 * @param object Database connector object
	 */
	function TableException(& $db) {
		parent::__construct('#__cp_exception', 'exception_id', $db);
	}
}